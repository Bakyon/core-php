<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<h1 align="center">Role management</h1>
<div class="row">
    <div class="container container-fluid col-sm-2">
        <?php include 'View/widgets/dashboard_menu.php' ?>
    </div>
    <div class="container container-fluid col-sm-10">
<!--        --><?php //var_dump($data); ?>
        <table class="table-bordered container" style="text-align: center;">
            <thead>
            <tr>
                <th></th>
                <?php foreach ($data[1] as $permission): ?>
                <th><?= $permission->getName() ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data[0] as $role): ?>
                <tr>
                    <td><?= $role->getName() ?></td>
                    <?php foreach ($data[1] as $permission): ?>
                    <td><?= (isset($data[2][$role->getId()][$permission->getId()]) AND $data[2][$role->getId()][$permission->getId()] == 1) ? 'x' : '' ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="container container-fluid" style="margin-top: 20px; margin-bottom: 20px;">
            <a class="btn btn-success" href="?cont=rolepermission&action=edit">Manage role - permission</a>
        </div>
    </div>
</div>