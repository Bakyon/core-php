<?php
class UserController extends Controller {
    private $userRepository;
    public function __construct() {
        $this->userRepository = new UserRepository();
    }
    function index() {
        if (!permission_check('user management')) $this->_403();
        else {
            if (!empty($_POST)) {
                if (empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
                    $this->_403();
                    exit();
                } else {
                    $value = [
                        'search' => $_POST['search'],
                        'condition' => $_POST['condition'],
                    ];
                    $validator = new SearchValidator();
                    if ($validator->validate($value)) {
                        redirect_to('?cont=user&action=search&value=' . $_POST['search'] . '&condition=' . $_POST['condition']);
                    } else {
                        foreach ($validator->getErrors() as $field => $error) {
                            foreach ($error as $e) {
                                $_SESSION['global_msg'] .= alert_msg($e);
                            }
                        }
                    }
                }
            }
            try {
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
                $noOfPages = intdiv($this->userRepository->noOfUsers()->{'COUNT(id)'} - 1, 5) + 1;
                $page = empty($_GET['page']) ? '1' : $_GET['page'];
                if (ctype_digit($page) && $page <= $noOfPages) {
                    $users = $this->userRepository->getAllUsers($page);
                    $data = [
                        'users' => $users,
                        'token' => $token,
                        'max Pages' => $noOfPages
                    ];
                    $this->show('View/users/showAll', $data);
                } else {
                    $this->_404();
                    exit();
                }
            } catch (\Random\RandomException $e) {
                $this->_500();
                exit();
            }
        }
    }

    function search() {
        if (!permission_check('user management')) $this->_403();
        else {
            $validator = new SearchValidator();
            if (!empty($_POST)) {
                if (empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
                    $this->_403();
                    exit();
                } else {
                    $value = [
                        'search' => $_POST['search'],
                        'condition' => $_POST['condition'],
                    ];
                    if ($validator->validate($value)) {
                        redirect_to('?cont=user&action=search&value=' . $_POST['search'] . '&condition=' . $_POST['condition']);
                    } else {
                        $msg = '';
                        foreach ($validator->getErrors() as $field => $error) {
                            foreach ($error as $e) {
                                $msg .= alert_msg($e);
                            }
                        }
                        redirect_to('?cont=user', $msg);
                    }
                }
            }
            $value = [
                'search' => $_GET['value'],
                'condition' => $_GET['condition'],
            ];
            if ($validator->validate($value)) {
                $users = $this->userRepository->search('%' . $value['search'] . '%', $value['condition']);
                if (!$users) redirect_to('?cont=user', alert_msg('No user found!'));
                else {
                    try {
                        $token = bin2hex(random_bytes(16));
                        $_SESSION['token'] = $token;
                        $noOfPages = intdiv(count($users) - 1, 5) + 1;
                        $page = empty($_GET['page']) ? '1' : $_GET['page'];
                        $users = array_slice($users, 5 * ($page - 1), 5 * $page);
                        $data = [
                            'users' => $users,
                            'token' => $token,
                            'max Pages' => $noOfPages
                        ];
                        $this->show('View/users/result', $data);
                    } catch (\Random\RandomException $e) {
                        $this->_500();
                        exit();
                    }
                }
            } else {
                $msg = '';
                foreach ($validator->getErrors() as $field => $error) {
                    foreach ($error as $e) {
                        $msg .= alert_msg($e);
                    }
                }
                redirect_to('?cont=user', $msg);
            }
        }
    }

    function login() {
        if (is_login()) redirect_to(BASE_URL);
        if (!empty($_POST)) {
            $validator = new LoginValidator();
            $input = [
                'email' => $_POST['email'],
                'password' => $_POST['psw'],
            ];
            if ($validator->validate($input)) {
                $user = $this->userRepository->login($input['email'], $input['password']);
                if ($user) {
                    if ($user['status'] == 2) {
                        echo alert_msg('Account is blocked! Please contact administrator.');
                    } else {
                        $_SESSION['login_status'] = 1;
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['name'] = $user['name'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['avatar'] = $user['avatar'];
                        $permissions = $this->userRepository->getPermissions($user['id']);
                        $_SESSION['permission'] = implode(',', $permissions);
                        // save cookie if needed
                        if (isset($_POST['remember']) and $_POST['remember']) {
                            $time = time() + 60 * 60 * 24 * 30; // save cookie for 30 days
                            setcookie("remember", true, $time);
                            setcookie("id", $user['id'], $time);
                            setcookie("name", $user['name'], $time);
                            setcookie("email", $user['email'], $time);
                            setcookie("avatar", $user['avatar'], $time);
                            setcookie("permission", $_SESSION['permission'], $time);
                        }
                        redirect_to(BASE_URL, alert_msg('Login successful', 1));
                    }
                } else echo alert_msg('Wrong username or password!');
            } else {
                $msg = '';
                foreach ($validator->getErrors() as $field => $error) {
                    foreach ($error as $e) {
                        $msg .= alert_msg($e);
                    }
                }
                echo $msg;
            }

        }
        $this->show('View/users/login', null, 'empty');
    }

    function registration() {
        if (is_login()) redirect_to(BASE_URL);
        $this->add('?cont=user&action=login');
    }
    function newUser() {
        if (!permission_check('user management')) $this->_403();
        else $this->add('?cont=user');
    }

    private function add($redirect) {
        $msg = '';
        if (!empty($_POST)) {
            if (empty($_POST['token']) || empty($_SESSION['token']) || $_SESSION['token'] != $_POST['token']) {
                $this->_403();
                exit();
            } else {
                $name = empty($_POST['name']) ? $this->emailToName($_POST['email']) : $_POST['name'];
                $validator = new UserValidator();
                $input = [
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    '2ndpassword' => $_POST['2ndpassword'],
                    'gender' => $_POST['gender'],
                    'birthdate' => $_POST['birthdate'],
                    'name' => $name
                ];
                if ($validator->validate($input)) {
                    $check = $this->userRepository->registration($name, $_POST['email'], $_POST['password'], $_POST['gender'], $_POST['birthdate']);
                    if ($check == -1) {
                        $msg .= 'Email existed. Please try another email.';
                    } elseif ($check > 0) {
                        $msg .= alert_msg('Registration successful', 1);
                        // Upload avatar if account successfully created
                        if (isset($_FILES['avatar'])) {
                            $msg .= singleUpload($_FILES['avatar'], 'Images/UploadAvatars/', $name);
                            if (isset($_SESSION['uploaded_name'])) {
                                if (!$this->userRepository->setAvatar($check, $_SESSION['uploaded_name'])) {
                                    $msg .= alert_msg('Cannot update avatar image. Please contact your admin.');
                                }
                                unset($_SESSION['uploaded_name']);
                            }
                        }
                        redirect_to($redirect, $msg);
                    } else {
                        $msg .= 'Registration failed. You might need to contact your admin.';
                    }
                } else {
                    foreach ($validator->getErrors() as $field => $error) {
                        foreach ($error as $e) {
                            $msg .= alert_msg($e);
                        }
                    }
                    redirect_to('?cont=user', $msg);
                }
            }
        }
        try {
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;
            $_SESSION['empty_msg'] = empty($msg) ? '' : alert_msg($msg);
            $data = [
                'token' => $token
            ];
            $this->show('View/users/registration', $data, 'empty');
        } catch (\Random\RandomException $e) {
            $this->_500();
            exit();
        }
    }
    private function emailToName($email) : string
    {
        if (empty($email)) return '';
        $name = explode('@', $email);
        $name = $name[0];
        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $name);
    }

    function logout() {
        session_destroy();
        setcookie("remember", '', time() - 3600);
        setcookie("id", '', time() - 3600);
        setcookie("name", '', time() - 3600);
        setcookie("email", '', time() - 3600);
        setcookie("avatar", '', time() - 3600);
        setcookie("permission", '', time() - 3600);
        redirect_to(BASE_URL, alert_msg('Logout successful',1));
    }

    function profile() {
        if (!empty($_GET['id'])) {
            if (ctype_digit($_GET['id'])) {
                $data = $this->userRepository->getUserById($_GET['id']);
                if ($data !== false) {
                    $this->show('View/users/profile', $data);
                } else {
                    redirect_to(BASE_URL, alert_msg('Account does not exists'));
                }
            } else $this->_404();
        } else {
            if (is_login()) redirect_to('?cont=user&action=profile&id='.$_SESSION['id']);
            else $this->_404();
        }
    }

    function update_status() {
        if (!permission_check('user management')) $this->_403();
        else {
            if (empty($_POST['token']) || empty($_SESSION['token']) || $_SESSION['token'] != $_POST['token']) {
                $this->_403();
                exit();
            } else {
                if (empty($_GET['id']) or empty($_GET['value'])) $this->_404();
                else {
                    $id = $_GET['id'];
                    if (!ctype_digit($id)) {
                        $this->_404();
                    } elseif (strcmp($id, $_SESSION['id']) != 0) {
                        $status = $_GET['value'];
                        if (in_array($status, [1, 2])) {
                            $this->userRepository->updateStatus($id, $status);
                        } else $this->_404();
                    }
                    redirect_to('?cont=user');
                }
            }
        }
    }

    private function core_edit($data, $self_edit = true) {
        $msg = '';
        if (!empty($_POST)) {
            if (empty($_POST['token']) || empty($_SESSION['token']) || $_POST['token'] != $_SESSION['token']) {
                $this->_403();
                exit();
            } else {
                $name = empty($_POST['name']) ? $this->emailToName($_POST['email']) : $_POST['name'];

                $validator = new UserValidator();
                $input = [
                    'email' => $data->getEmail(),
                    'password' => '123456',
                    '2ndpassword' => '123456',
                    'gender' => $self_edit ? $_POST['gender'] : $data['gender'],
                    'birthdate' => $self_edit ? $_POST['birthdate'] : $data['birthdate'],
                    'name' => $name
                ];

                if ($validator->validate($input)) {
                    if ($self_edit) $gender = (int) $_POST['gender'];
                    else $gender = $data->getGender();
                    if ($this->userRepository->updateUser($data->getId(), $name, $gender, $_POST['birthdate'])) {
                        $msg .= alert_msg('Update successful', 1);
                        // Upload avatar if info is update successfully
                        if (isset($_FILES['avatar'])) {
                            $msg .= singleUpload($_FILES['avatar'], 'Images/UploadAvatars/', $name);
                            if (isset($_SESSION['uploaded_name'])) {
                                $this->userRepository->setAvatar($data->getId(), $_SESSION['uploaded_name']);
                                if ($self_edit) $_SESSION['avatar'] = $_SESSION['uploaded_name'];
                                unset($_SESSION['uploaded_name']);
                            }
                        }
                        if ($self_edit) redirect_to('?cont=user&action=profile', $msg);
                        else redirect_to('?cont=user&action=profile&id='.$_GET['id'], $msg);
                    }
                } else {
                    foreach ($validator->getErrors() as $field => $error) {
                        foreach ($error as $e) {
                            $msg .= alert_msg($e);
                        }
                    }
                }
            }
        }
        $_SESSION['global_msg'] = empty($msg) ? '' : alert_msg($msg);
    }

    function edit() {
        if (!is_login()) $this->_403();
        else {
            $id = $_SESSION['id'];
            $user = $this->userRepository->getUserById($id);
            if (!$user) {
                $this->logout();
                exit('Something went wrong');
            }
            $this->core_edit($user, true);
            try {
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
                $data = [
                    'user' => $user,
                    'token' => $token
                ];
                $this->show('View/users/edit', $data);
            } catch (\Random\RandomException $e) {
                $this->_500();
                exit();
            }
        }
    }

    public function admin_edit() {
        if (!permission_check('user management')) $this->_403();
        else {
            if (!empty($_GET['id'])) {
                if (ctype_digit($_GET['id'])) {
                    $user = $this->userRepository->getUserById($_GET['id']);
                    if (!$user) redirect_to('?cont=user', alert_msg('Id '.$_GET['id'].' does not exist!'));
                    else {
                        try {
                            $token = bin2hex(random_bytes(16));
                            $_SESSION['token'] = $token;
                            $data = [
                                'user' => $user,
                                'token' => $token
                            ];
                            $this->core_edit($user, false);
                            $this->show('View/users/admin_edit', $data);
                        } catch (\Random\RandomException $e) {
                            $this->_500();
                            exit();
                        }
                    }
                } else {
                    $this->_404();
                }
            } else {
                redirect_to('?cont=user', alert_msg('Account does not exists'));
            }
        }
    }

    function unsetavt() {
        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
        else {
            if (permission_check('profile')) {
                $this->userRepository->setAvatar($_SESSION['id'], 'no-avatar.png');
                $_SESSION['avatar'] = 'no-avatar.png';
                redirect_to('?cont=user&action=profile&id='.$_SESSION['id']);
            }
        }
    }

    function changepw() {
        if (!is_login()) $this->_403();
        else {
            $msg = '';
            if (!empty($_POST)) {
                if (empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
                    $this->_403();
                    exit();
                } else {
                    $input = [
                        'old_password' => $_POST['old_password'],
                        'new_password' => $_POST['new_password'],
                        'confirm_password' => $_POST['confirm_password']
                    ];
                    $validator = new ChangePasswordValidator();

                    if ($validator->validate($input)) {
                        $check = $this->userRepository->changePassword($_SESSION['id'], $_POST['old_password'], $_POST['new_password']);
                        switch ($check) {
                            case 0:
                                $msg .= alert_msg('Cannot update password. Please contact your admin.');
                                break;
                            case 1:
                                $msg = 'Your password has been changed!';
                                redirect_to('?cont=user&action=profile&id='.$_SESSION['id'], alert_msg($msg, 1));
                                break;
                            case -1:
                                $msg = alert_msg('Your old password is wrong!');
                                break;
                            default:
                                $this->_500();
                        }
                    } else {
                        foreach ($validator->getErrors() as $field => $error) {
                            foreach ($error as $e) {
                                $msg .= alert_msg($e);
                            }
                        }
                    }
                }
            }
            $user = $this->userRepository->getUserById($_SESSION['id']);
            $_SESSION['global_msg'] = empty($msg) ? '' : ($msg);
            try {
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
                $data = [
                    'user' => $user,
                    'token' => $token
                ];
                $this->show('View/users/changepw', $data);
            } catch (\Random\RandomException $e) {
                $this->_500();
                exit();
            }
        }
    }

    function delete() {
        if (!is_login()) redirect_to('?cont=user&action=login');
        if (permission_check('user management')) {
            if (empty($_GET['id'])) redirect_to('?cont=user', alert_msg('That account does not exist'));
            if ($_GET['id'] === $_SESSION['id']) {
                redirect_to('?cont=user', alert_msg('You can\'t delete your own account!'));
            } else {
                if (!ctype_digit($_GET['id'])) {
                    $this->_404();
                    exit();
                } else {
                    if (empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
                        $this->_403();
                        exit();
                    } else {
                        if ($this->userRepository->deleteUserById($_GET['id'])) {
                            redirect_to('?cont=user', alert_msg('Successfully delete account with id '.$_GET['id'], 1));
                        } else {
                            redirect_to('?cont=user', alert_msg('Account with id '.$_GET['id'].' does not exist.'));
                        }
                    }
                }
            }
        } else $this->_403();
    }

//    function resetpw() {
//        if (!is_login()) redirect_to(BASE_URL.'?cont=user&action=login');
//        $user = $_GET['user'];
//        if ((new users())->updatePassword($user, '123')) {
//            redirect_to('?cont=user&action=profile', alert_msg('Successfully reset password', 1));
//        } else {
//            redirect_to('?cont=user&action=profile', alert_msg('Failed to reset password'));
//        }
//    }

    public function modify_role() {
        if (!permission_check('user management')) $this->_403();
        else {
            $msg = '';
            if (!empty($_POST)) {
                if (empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
                    $this->_403();
                    exit();
                } else {
                    $input = [
                        'role_id' => $_POST['role_id'],
                        'user_id' => $_POST['user_id']
                    ];
                    $validator = new NumberValidator(['role_id', 'user_id']);
                    if ($validator->validate($input)) {
                        if (strcmp($_SESSION['id'], $_POST['user_id']) != 0) {
                            $result = $this->userRepository->updateRole($_POST['user_id'], $_POST['role_id']);
                            if ($result) {
                                $msg .= alert_msg('Update successful', 1);
                            } else {
                                $msg .= alert_msg('Something went wrong!');
                            }
                        }
                    } else {
                        foreach ($validator->getErrors() as $field => $error) {
                            foreach ($error as $e) {
                                $msg .= alert_msg($e);
                            }
                        }
                    }
                }
            }
            $_SESSION['global_msg'] = empty($msg) ? '' : $msg;
            $users = $this->userRepository->getAllUsers();
            $roles = (new RoleRepository())->getAllRoles();
            try {
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
                $data = [
                    'users' => $users,
                    'roles' => $roles,
                    'token' => $token
                ];
                $this->show('View/users/modify_role', $data);
            } catch (\Random\RandomException $e) {
                $this->_500();
                exit();
            }
        }
    }
}