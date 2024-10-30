<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<!--navbar header section start -->
<div class="header_section" style="background: #252525; position: fixed; top: 0; z-index:9999; margin-top: -15px;">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="logo"><a href=<?= BASE_URL ?>><img src="Images/logo.png" width="50px" height="50px" ></a></div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href=<?= BASE_URL ?>>HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?cont=user">DASHBOARD</a>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link dropdown">
                            <div class="nav-item"><img src="Images/UploadAvatars/<?= isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'no-avatar.png' ?>" style="border-radius: 50%; margin: 0 5px; object-fit: cover; width: 45px; height: 45px;">Hi, <?= is_login() ? $_SESSION['name'] : 'guest' ?></div>
                            <div class="nav-item dropdown-content">
                                <?=
                                is_login() ?
                                    '<a class="dropdown-item" style="color: navajowhite;" href="?cont=user&action=profile&id='.$_SESSION['id'].'">My profile</a>
                                    <a class="dropdown-item" style="color: darkred;" href="?cont=user&action=logout">Logout</a>'
                                    :
                                    '<a class="dropdown-item" style="color: navajowhite;" href="?cont=user&action=login">Login</a>
                                    <a class="dropdown-item" style="color: darkred;" href="?cont=user&action=registration">Register</a>'
                                ?>
                            </div>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <div class="search_icon"><a href="#"><img src="images/search-icon.png"></a></div>
                </form>
            </div>
        </nav>
    </div>
</div>
<!--navbar header section end -->