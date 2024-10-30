<?php
defined('BASE_URL') OR exit('Access denied !!!');
$genders = ['Male', 'Female', 'Other'];
?>
<h1 align="center">User dashboard</h1>
<div class="row">
    <div class="container container-fluid col-sm-2">
        <?php include 'View/widgets/dashboard_menu.php' ?>
    </div>
    <div class="container container-fluid col-sm-10">
        <form method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input type="text" placeholder="Search.." name="search">
                <input name="token" type="password" hidden="hidden" readonly value="<?= $data['token'] ?>">
                <select name="condition">
                    <option value="name" selected>Search by name</option>
                    <option value="id">Search by id</option>
                    <option value="email">Search by email</option>
                </select>
                <button class="btn search_icon" type="submit">Search</button>
            </div>
        </form>
        <a href="?cont=user&action=newUser" class="btn btn-primary" style="text-align: center; margin: 10px;"> Add new user </a>
        <table class="user-table table fixed-table">
            <thead>
            <tr>
                <th class="user-table">ID</th>
                <th class="user-table">Name</th>
                <th class="user-table">Birthdate<br>(y-m-d)</th>
                <th class="user-table">Email</th>
                <th class="user-table">Gender</th>
                <th class="user-table">Avatar</th>
                <th class="user-table">Status</th>
                <th class="user-table">Operation</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['users'] as $user): ?>
                <tr>
                    <td class="user-table"><?= $user->getId() ?></td>
                    <td class="user-table"><?= $user->getName() ?></td>
                    <td class="user-table"><?= $user->getBirthday() ?></td>
                    <td class="user-table"><?= $user->getEmail() ?></td>
                    <td class="user-table"><?= $genders[$user->getGender() - 1] ?></td>
                    <td class="user-table"><img src="images/uploadavatars/<?= $user->getAvatar() ?>" style="border-radius: 50%; margin: 5px; object-fit: cover; width: 45px; height: 45px;"></td>
                    <td class="user-table">
                        <?php
                        $temp = [
                            'color' => $user->getStatus() == 1 ? 'green' : 'red',
                            'class' => $user->getStatus() == 1 ? 'btn btn-danger' : 'btn btn-success',
                            'text' => $user->getStatus() == 1 ? 'Deactive' : 'Active',
                            'value' => $user->getStatus() == 1 ? 2 : 1
                        ];
                        ?>
                        <form method="post" enctype="multipart/form-data" action="?cont=user&action=update_status&value=<?= $temp['value'] ?>&id=<?= $user->getId() ?>">
                            <input name="token" type="password" hidden="hidden" readonly value="<?= $data['token'] ?>">
                            <div class="btn" style="align-items: center; background: <?= $temp['color'] ?>; border-radius: 50%; height: 20px; width: 20px; padding: 0; margin: 10px" ></div><button type="submit" class="<?= $temp['class'] ?>"><?= $temp['text'] ?></button>
                        </form>
                    </td>
                    <td>
                        <form id="delete-<?= $user->getId() ?>" enctype="multipart/form-data" method="post" action="?cont=user&action=delete&id=<?= $user->getId() ?>">
                            <a class="btn btn-primary" href="?cont=user&action=profile&id=<?= $user->getId() ?>">View</a>
                            <a class="btn btn-secondary" href="?cont=user&action=admin_edit&id=<?= $user->getId() ?>">Edit</a>
                            <input name="token" type="password" hidden="hidden" readonly value="<?= $data['token'] ?>">
                            <button type="button" class="btn btn-danger" onclick="confirmDelete('<?= $user->getId() ?>')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

            <script>
                function confirmDelete(user) {
                    if (confirm("Are you sure you want to delete?")) {
                        document.getElementById("delete-" + user).submit();
                    }
                }
            </script>
        </table>
    </div>
    <div class="container container-fluid text-center">
        <?php
            $page = empty($_GET['page']) ? 1 : $_GET['page'];
            $value = empty($_GET['value']) ? '' : '&value='.$_GET['value'];
            $condition = empty($_GET['condition']) ? '' : '&condition='.$_GET['condition'];
            $pre_page = "?cont=user&action=search".$value.$condition."&page=".($page - 1);
            $nxt_page = "?cont=user&action=search".$value.$condition."&page=".($page + 1);
        ?>
        <?php if ($page > 1) { ?>
            <a href="<?= $pre_page ?>" class="btn btn-primary">Previous</a>
        <?php } ?>
        <label class="btn btn-outline-primary"><?= $page ?></label>
        <?php if ($page < $data['max Pages']) { ?>
            <a href="<?= $nxt_page ?>" class="btn btn-primary">Next</a>
        <?php } ?>
    </div>
</div>