<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'View/widgets/head.php'; ?>
</head>
<body>
<?php include 'View/widgets/navbar.php'; ?>
<?= '<div style="margin: 100px 0 0 0;"></div>' ?>
<?= isset($_SESSION['global_msg']) ? $_SESSION['global_msg'] : '' ?>
<?php $_SESSION['global_msg'] = ''; ?>
<?php include $view.'.php'; ?>
<footer class="site-footer text-light">
    <?php include 'View/widgets/foot.php'; ?>
</footer>
<?php include 'View/widgets/script.php'; ?>
</body>
</html>