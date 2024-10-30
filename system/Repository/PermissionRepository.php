<?php
class PermissionRepository extends Repository {
    public function getAllPermissions() {
        try {
            $result = $this->connection->set_query('SELECT * FROM permissions WHERE deleted_at IS NULL')->load_rows();
            
            if (!$result) return false;
            $permissions = [];
            foreach ($result as $row) {
                $permission = new Permissions($row->id, $row->name);
                $permissions[$row->id] = $permission;
            }
            return $permissions;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function getPermission($value, $column = 'id') {
        try {
            $result = $this->connection->set_query('SELECT * FROM permissions WHERE '.$column.' LIKE ?')->load_row([$value]);
            
            if (!$result) return false;
            return new Permissions($result->id, $result->name);
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function addPermission($name) {
        try {
            $permission = $this->connection->set_query('SELECT * FROM permissions WHERE name = ?')->load_row([$name]);
            if ($permission) return -1;
            $result = $this->connection->set_query('INSERT INTO permissions (name) VALUES (?)')->save([$name]);
            
            return $result;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return 0;
        }
    }
    public function updatePermission($id, $name) {
        try {
            $result = $this->connection->set_query('UPDATE permissions SET name=? WHERE id=?')->save([$name, $id]);
            
            if (!$result) return false; else return true;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function deletePermission($id) {
        try {
            $result = $this->connection->set_query('UPDATE permissions SET deleted_at = NOW() WHERE id=?')->save([$id]);
            
            return $result;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
    public function editPermission($id, $name) {
        try {
            $result = $this->connection->set_query('UPDATE permissions SET name=? WHERE id=? and deleted_at IS NULL')->save([$name, $id]);
            
            if (!$result) return 0; else return 1;
        } catch (Exception $e) {
            // debug purpose
            // echo $e->getMessage();
            return -1;
        }
    }
}