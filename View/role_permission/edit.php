<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<h1 align="center">Role management</h1>
<div class="row">
    <div class="container container-fluid col-sm-2">
        <?php include 'View/widgets/dashboard_menu.php' ?>
    </div>
    <div class="container container-fluid col-sm-10">
        <form enctype="multipart/form-data" method="post">
            <table class="table-bordered container" style="text-align: center;">
                <thead>
                <tr>
                    <th></th>
                    <?php foreach ($data['permissions'] as $permission): ?>
                        <th><?= $permission->getName() ?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['roles'] as $role): ?>
                    <tr>
                        <td><?= $role->getName() ?></td>
                        <?php foreach ($data['permissions'] as $permission): ?>
                            <td>
                                <input type="checkbox" name="<?= $role->getId().'-'.$permission->getId() ?>" value="<?= $role->getId().'-'.$permission->getId() ?>" <?= (isset($data['role_permission'][$role->getId()][$permission->getId()]) AND $data['role_permission'][$role->getId()][$permission->getId()] == 1) ? 'checked' : '' ?>>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
                <input name="token" hidden="hidden" readonly value="<?= $data['token'] ?>">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="reset" class="btn btn-danger">Reset</button>
                <a href="?cont=rolepermission" class="btn btn-secondary">Back to dashboard</a>
            </div>
        </form>
    </div>
</div>
