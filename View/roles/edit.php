<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<h1 align="center">Role management</h1>
<div class="row">
    <div class="container container-fluid col-sm-2">
        <?php include 'View/widgets/dashboard_menu.php' ?>
    </div>
    <div class="container container-fluid col-sm-10">
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>New name</th>
                <th>Confirmation</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <form method="post" enctype="multipart/form-data">
                    <td class="user-table">
                        <input  type="text" disabled value="<?= $data['role']->getId() ?>" name="id">
                    </td>
                    <td class="user-table">
                        <input  type="text" disabled value="<?= $data['role']->getName() ?>" name="name">
                    </td>
                    <td class="user-table">
                        <input  type="text" required placeholder="Enter new role name..." name="new_name">
                    </td>
                    <td class="user-table">
                        <input name="token" value="<?= $data['token'] ?>" readonly type="password" hidden="hidden">
                        <button type="submit" class="btn btn-success">Update</button>
                    </td>
                </form>
            </tr>
            </tbody>
        </table>
    </div>
</div>