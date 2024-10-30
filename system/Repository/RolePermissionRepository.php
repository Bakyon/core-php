<?php
class RolePermissionRepository extends Repository {
    public function getAll()  {
        try {
            $result = $this->connection->set_query('SELECT * FROM role_permission')->load_rows();
            $arr = [];
            foreach ($result as $row) {
                $arr[$row->role_id][$row->permission_id] = 1;
            }
            return $arr;
        } catch (PDOException $e) {
            // debug purpose
            // echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function add($role_id, $permission_id) {
        try {
            $result = $this->connection->set_query('INSERT INTO role_permission (role_id, permission_id) VALUES (?, ?)')->save([$role_id, $permission_id]);
            
            return $result;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }

    public function remove($role_id, $permission_id) {
        try {
            $result = $this->connection->set_query('DELETE FROM role_permission WHERE role_id = ? AND permission_id = ?')->save([$role_id, $permission_id]);
            
            return $result;
        } catch (PDOException $e) {
            // debug purpose
            // echo $e->getMessage();
            return false;
        }
    }
}