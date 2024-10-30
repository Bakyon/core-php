<?php
class RolePermissionController extends Controller {
    private $roleRepository;
    private $permissionRepository;
    private $rolePermissionRepository;
    public function __construct() {
        $this->roleRepository = new RoleRepository();
        $this->permissionRepository = new PermissionRepository();
        $this->rolePermissionRepository = new RolePermissionRepository();
    }
    public function index() {
        if (permission_check('role_permission management')) {
            $roles = $this->roleRepository->getAllRoles();
            $permissions = $this->permissionRepository->getAllPermissions();
            $role_permission = $this->rolePermissionRepository->getAll();
            $data = [$roles, $permissions, $role_permission];
            $this->show('View/role_permission/index', $data);
        } else $this->_403();
    }

    public function edit() {
        if (permission_check('role_permission management')) {
            $roles = $this->roleRepository->getAllRoles();
            $permissions = $this->permissionRepository->getAllPermissions();
            $temp = [];
            if (!empty($_POST)) {
                if (empty($_POST['token']) || empty($_SESSION['token']) || $_POST['token'] != $_SESSION['token']) {
                    $this->_403();
                    exit();
                } else {
                    foreach ($roles as $role) {
                        foreach ($permissions as $permission) {
                            $temp[$role->getId()][$permission->getId()] = $role->getId() == 1 ? 1 : 0;
                        }
                    }
                    $validator = new NumberValidator(['role id', 'permission id']);
                    foreach ($_POST as $key => $value) {
                        $temp2 = explode("-", $value);
                        if (count($temp2) < 2) continue;
                        $input = [
                            'role id' => $temp2[0],
                            'permission id' => $temp2[1],
                        ];
                        if ($validator->validate($input)) {
                            $temp[$input['role id']][$input['permission id']] = 1;
                        }
                    }
                    foreach ($roles as $role) {
                        foreach ($permissions as $permission) {
                            if ($temp[$role->getId()][$permission->getId()] == 1) {
                                $this->rolePermissionRepository->add($role->getId(), $permission->getId());
                            } else {
                                $this->rolePermissionRepository->remove($role->getId(), $permission->getId());
                            }
                        }
                    }
                }
            }
            $_SESSION['token'] = '';
            try {
                $token = bin2hex(random_bytes(16));
                $role_permission = $this->rolePermissionRepository->getAll();
                $data = [
                    'roles' => $roles,
                    'permissions' => $permissions,
                    'role_permission' => $role_permission,
                    'token' => $token
                ];
                $_SESSION['token'] = $token;
                $this->show('View/role_permission/edit', $data);
            } catch (\Random\RandomException $e) {
                $this->_500();
                exit();
            }
        } else $this->_403();
    }
}