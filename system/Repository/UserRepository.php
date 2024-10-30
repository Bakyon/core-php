<?php
class UserRepository extends Repository {
    function getAllUsers($page = 1, $orderBy = 'id', $itemPerPage = 5) {
        try {
            $offset = ($page - 1) * $itemPerPage;
            $result = $this->connection->set_query('SELECT id, role_id, name, birthday, email, gender, avatar, status FROM users WHERE deleted_at IS NULL ORDER BY '.$orderBy.' LIMIT ? OFFSET ?')->load_rows([$itemPerPage, $offset]);
            $users = [];
            if ($result) {
                foreach ($result as $user) {
                    $temp = new Users();
                    $temp->setId($user->id);
                    $temp->setRole_id($user->role_id);
                    $temp->setName($user->name);
                    $temp->setBirthday($user->birthday);
                    $temp->setEmail($user->email);
                    $temp->setGender($user->gender);
                    $temp->setAvatar($user->avatar);
                    $temp->setStatus($user->status);
                    // id	name	birthday	password	email	gender	avatar	status (1 - active, 2 - block)
                    $users[$user->id] = $temp;
                }
            }
            return $users;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    function noOfUsers () {
        try {
            $result = $this->connection->set_query('SELECT COUNT(id) FROM users WHERE deleted_at IS NULL')->load_rows();
            return $result[0];
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }

    function login($email, $password) {
        try {
            $result = $this->connection->set_query('SELECT id, role_id, password, name, avatar, status FROM users WHERE email = ? and deleted_at IS NULL')->load_row([$email]);
            if (!$result) return false;
            if (password_verify($password, $result->password)) {
                return [
                    'id' => $result->id,
                    'role_id' => $result->role_id,
                    'email' => $email,
                    'name' => $result->name,
                    'avatar' => $result->avatar,
                    'status' => $result->status
                ];
            } else return false;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }

    function registration($name, $email, $password, $gender, $birthdate): int
    {
        try {
            $flag = $this->connection->set_query('SELECT id FROM users WHERE email = ?')->load_row([$email]);
            if ($flag) return -1;
            $flag = $this->connection->set_query('INSERT INTO users (name, email, password, gender, birthday) VALUES (?, ?, ?, ?, ?)')->save([$name, $email, password_hash($password, PASSWORD_DEFAULT), $gender, $birthdate]);
            if ($flag) {
                $result = $this->connection->pdo->lastInsertId();
                return $result;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return 0;
        }
    }

    function setAvatar($id, $avatar) {
        try {
            $flag = $this->connection->set_query('UPDATE users SET avatar = ? WHERE id = ?')->save([$avatar, $id]);
            if ($flag) return 1; else return 0;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }

    function getUserById($id) {
        try {
            $result = $this->connection->set_query('SELECT name, birthday, email, gender, avatar, status FROM users WHERE id = ? AND deleted_at IS NULL')->load_row([$id]);
            if (!$result) return false;
            $temp = new Users();
            $temp->setId($id);
            $temp->setName($result->name);
            $temp->setBirthday($result->birthday);
            $temp->setEmail($result->email);
            $temp->setGender($result->gender);
            $temp->setAvatar($result->avatar);
            $temp->setStatus($result->status);
            return $temp;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }

    function deleteUserById($id) {
        if (!$this->getUserById($id)) return false;
        try {
            $result = $this->connection->set_query('UPDATE users SET deleted_at = NOW() WHERE id = ?')->save([$id]);
            return $result;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }

    function updateUser($id, $name, $gender, $birthdate) {
        try {
            $result = $this->connection->set_query('UPDATE users SET name = ?, gender = ?, birthday = ? WHERE id = ?')->save([$name, $gender, $birthdate, $id]);
            return $result;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }

    public function search($value, $column = 'name') {
        try {
            $result = $this->connection->set_query('SELECT * FROM users WHERE ' . $column . ' LIKE ? AND deleted_at IS NULL')->load_rows([$value]);
            if (!$result) return false;
            $users = [];
            foreach ($result as $user) {
                $temp = new Users();
                $temp->setId($user->id);
                $temp->setName($user->name);
                $temp->setBirthday($user->birthday);
                $temp->setEmail($user->email);
                $temp->setGender($user->gender);
                $temp->setAvatar($user->avatar);
                $temp->setStatus($user->status);
                $users[$user->id] = $temp;
            }
            return $users;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }

    public function getPermissions($id) {
        try {
            $result = $this->connection->set_query('SELECT name FROM permissions WHERE id IN (SELECT permission_id FROM role_permission WHERE role_id = (SELECT role_id FROM users WHERE id = ?))')->load_rows([$id]);
            $perms = [''];
            $i = 0;
            foreach ($result as $permission) {
                $perms[$i] = $permission->name;
                $i += 1;
            }
            return $perms;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function updateRole($user_id, $role_id) {
        try {
            $result = $this->connection->set_query('UPDATE users SET role_id = ? WHERE id = ? AND deleted_at IS NULL')->save([$role_id, $user_id]);
            return $result;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function updateStatus($id, $status) {
        try {
            $result = $this->connection->set_query('UPDATE users SET status = ? WHERE id = ?')->save([$status, $id]);
            return $result;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function changePassword($id, $old_pw, $new_pw) : int {
        try {
            $user = $this->connection->set_query('SELECT password FROM users WHERE id = ?')->load_row([$id]);
            if (password_verify($old_pw, $user->password)) {
                $hash = password_hash($new_pw, PASSWORD_DEFAULT);
                $result = $this->connection->set_query('UPDATE users SET password = ? WHERE id = ?')->save([$hash, $id]);
                return $result ? 1 : 0;
            } else {
                return -1;
            }
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return 0;
        }
    }
}