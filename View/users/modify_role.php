<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<h1 align="center">User dashboard</h1>
<div class="row">
    <div class="container container-fluid col-sm-2">
        <?php include 'View/widgets/dashboard_menu.php' ?>
    </div>
    <div class="container container-fluid col-sm-10" style="padding: 20px 5% 20px 0;">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Status</th>
                <th>Role</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $users = $data['users'];
            $roles = $data['roles'];
            foreach ($users as $user) :
                ?>
                <form enctype="multipart/form-data" method="post">
                    <tr>
                        <td><?= $user->getId() ?></td>
                        <td><?= $user->getName() ?></td>
                        <td><?= $user->getEmail() ?></td>
                        <td><img src="images/uploadavatars/<?= $user->getAvatar() ?>" style="border-radius: 50%; margin: 5px; object-fit: cover; width: 45px; height: 45px;"></td>
                        <td>
                            <div class="btn" style="align-items: center; background: <?= $user->getStatus() == 1 ? 'green' : 'red' ?>; border-radius: 50%; height: 20px; width: 20px; padding: 0; margin: 10px" ></div>
                        </td>
                        <td>
                            <input hidden readonly value="<?= $user->getId() ?>" name="user_id">
                            <div class="container container-fluid">
                                <select style="" name="role_id">
                                    <?php foreach ($roles as $role) : ?>
                                        <option style="" value="<?= $role->getId() ?>" <?= $role->getId() == $user->getRole_id() ? 'selected' : '' ?>><?= $role->getName() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <input name="token" type="password" hidden="hidden" readonly value="<?= $data['token'] ?>">
                            <button type="submit" class="btn btn-success">Update</button>
                        </td>
                    </tr>
                </form>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>