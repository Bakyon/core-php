<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<h1 align="center">Role management</h1>
<div class="row">
    <div class="container container-fluid col-sm-2">
        <?php include 'View/widgets/dashboard_menu.php' ?>
    </div>
    <div class="container container-fluid col-sm-10">
        <form method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input  type="text" required placeholder="Role name" name="name">
                <input name="token" hidden readonly value="<?= $data['token'] ?>">
                <button class="btn btn-success" type="submit">Add</button>
            </div>
        </form>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['roles'] as $id => $role): ?>
                <form id="form-<?= $id ?>" action="?cont=role&action=delete&id=<?= $id ?>" method="post" enctype="multipart/form-data">
                    <tr>
                        <td class="user-table"><?= $role->getId() ?></td>
                        <td class="user-table"><?= $role->getName() ?></td>
                        <td>
                            <input name="token" type="password" hidden="hidden" readonly value="<?= $data['token'] ?>">
                            <a class="btn btn-primary" href="?cont=role&action=edit&id=<?= $id ?>">Edit</a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete('<?= $id ?>')">Delete</button>
                        </td>
                    </tr>
                </form>
            <?php endforeach; ?>
            </tbody>

            <script>
                function confirmDelete(role) {
                    if (confirm("Are you sure you want to delete?")) {
                        // Redirect to the delete action
                        $formElement = document.getElementById("form-" + role);
                        $formElement.submit();
                    }
                }
            </script>
        </table>
    </div>
</div>