<?php
class RoleController extends Controller {
    private RoleRepository $roleRepository;
    public function __construct() {
        $this->roleRepository = new RoleRepository();
    }
    public function index() {
        if (permission_check('role management')) {
            if (!empty($_POST)) {
                if (empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
                    $this->_403();
                    exit();
                } else {
                    // add new role
                    $msg = '';
                    $input = ['role name' => $_POST['name']];
                    $validator = new RoleValidator();
                    if ($validator->validate($input)) {
                        $check = $this->roleRepository->addRole($_POST['name']);
                        if ($check < 0) {
                            $msg .= alert_msg('Role name already exists.');
                        } elseif ($check = 0) {
                            $msg .= alert_msg('Fail to add role.');
                        } else {
                            $msg .= alert_msg('Role added successfully.', 1);
                        }
                    } else {
                        foreach ($validator->getErrors() as $error) {
                            foreach ($error as $e) {
                                $msg .= alert_msg($e);
                            }
                        }
                    }
                    $_SESSION['global_msg'] .= $msg;
                }
            }
            $_SESSION['token'] = '';
            try {
                $token = bin2hex(random_bytes(16));
                $roles = $this->roleRepository->getAllRoles();
                if (!$roles) $this->_500();
                else {
                    $data = [
                        'roles' => $roles,
                        'token' => $token
                    ];
                    $_SESSION['token'] = $token;
                    $this->show('View/roles/index', $data);
                }
            } catch (\Random\RandomException $e) {
                $this->_500();
                exit();
            }

        } else $this->_403();
    }

    public function delete() {
        if (permission_check('role management')) {
            if (empty($_GET['id'])) $this->_404();
            else {
                if (empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
                    $this->_403();
                    exit();
                } else {
                    $_SESSION['token'] = '';
                    $check = $this->roleRepository->deleteRole($_GET['id']);
                    if ($check) redirect_to('?cont=role', alert_msg('Role deleted successfully.', 1));
                    else redirect_to('?cont=role', alert_msg('Failed to delete role.'));
                }
            }
        } else $this->_403();
    }

    public function edit() {
        if (permission_check('role management')) {
            if (empty($_GET['id'])) $this->_404();
            else {
                if (!ctype_digit($_GET['id'])) {
                    $this->_404();
                    exit();
                }
                $role = $this->roleRepository->getRole($_GET['id']);
                if (!$role) $this->_500();
                else {
                    $msg = '';
                    if (!empty($_POST)) {
                        if (empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] != $_POST['token']) {
                            $this->_403();
                            exit();
                        } else {
                            $validator = new RoleValidator();
                            $input = ['role name' => $_POST['new_name']];

                            if ($validator->validate($input)) {
                                $check = $this->roleRepository->editRole($role->getId(), $input['role name']);
                                if ($check == 0) {
                                    $msg .= alert_msg('Role name already exists.');
                                } elseif ($check == 1) {
                                    $msg .= alert_msg('Role updated successfully.', 1);
                                    redirect_to('?cont=role', $msg);
                                } elseif ($check == -1) {
                                    $msg .= alert_msg('Failed to update role.');
                                } else {
                                    $this->_500();
                                }
                            } else {
                                foreach ($validator->getErrors() as $error) {
                                    foreach ($error as $e) {
                                        $msg .= alert_msg($e);
                                    }
                                }
                            }
                        }
                    }
                    try {
                        $_SESSION['global_msg'] .= $msg;
                        $token = bin2hex(random_bytes(16));
                        $data = [
                            'role' => $role,
                            'token' => $token
                        ];
                        $this->show('View/roles/edit', $data);
                    } catch (\Random\RandomException $e) {
                        $this->_500();
                        exit();
                    }
                }
            }
        } else $this->_403();
    }
}