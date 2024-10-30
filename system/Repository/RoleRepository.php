<?php
class RoleRepository extends Repository {
    public function getAllRoles() {
        try {
            $result = $this->connection->set_query('SELECT * FROM roles WHERE deleted_at IS NULL')->load_rows();
            if (!$result) return false;
            $roles = [];
            foreach ($result as $row) {
                $role = new Roles($row->id, $row->name);
                $roles[$row->id] = $role;
            }
            return $roles;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function getRole($value, $column = 'id') {
        try {
            $result = $this->connection->set_query('SELECT * FROM roles WHERE '.$column.' LIKE ?')->load_row([$value]);
            if (!$result) return false;
            return new Roles($result->id, $result->name);
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function addRole($name) {
        try {
            $role = $this->connection->set_query('SELECT * FROM roles WHERE name = ?')->load_row([$name]);
            if ($role) return -1;
            $result = $this->connection->set_query('INSERT INTO roles (name) VALUES (?)')->save([$name]);

            return $result;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return 0;
        }
    }
    public function updateRole($id, $name) {
        try {
            $result = $this->connection->set_query('UPDATE roles SET name=? WHERE id=?')->save([$name, $id]);

            if (!$result) return false; else return true;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function deleteRole($id) {
        try {
            $result = $this->connection->set_query('UPDATE roles SET deleted_at = NOW() WHERE id=?')->save([$id]);

            return $result;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function editRole($id, $name) {
        try {
            $result = $this->connection->set_query('UPDATE roles SET name=? WHERE id=? and deleted_at IS NULL')->save([$name, $id]);

            if (!$result) return 0; else return 1;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return -1;
        }
    }
}