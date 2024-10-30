<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'View/widgets/head.php'; ?>
</head>
<body>
<?= isset($_SESSION['empty_msg']) ? $_SESSION['empty_msg'] : '' ?>
<?php $_SESSION['empty_msg'] = ''; ?>
<div>
    <?php include $view.'.php'; ?>
</div>
</body>
</html>