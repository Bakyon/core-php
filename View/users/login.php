<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<div class="container-fluid" style="padding: 50px;">
    <!-- Login form -->
    <div class="container col-sm-5" style="float: left; padding: 25px;">
        <div class="image_2"><img src="Images/logo.png" style="height: 70px; width: auto;"></div>
        <h1 class="about_taital">Login</h1>
        <div class="container">
            <div class="col-md-12">
                <div class="mail_sectin">
                    <form action="#" method="post">
                        <div class="input-group-sm">
                            <label for="email"><b>Email</b></label>
                            <input type="text" class="email-bt" placeholder="Enter email" name="email" required>
                        </div><br>
                        <div class="input-group">
                            <label for="psw"><b>Password</b></label>
                            <input type="password" class="email-bt" placeholder="Enter Password" name="psw" required>
                        </div><br>
                        <div class="input-group">
                            <label>
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                        </div><br>
                        <div class="card-group">
                            <button type="submit" class="col-sm-12 btn btn-success" style="margin-bottom: 10px;">Login</button>
                            <a href=<?= BASE_URL ?> type="button" class="col-sm-12 btn btn-secondary" style="margin-bottom: 10px;">Go back to home page</a>
                            <a href="?cont=user&action=registration" type="button" class="col-sm-12 btn btn-primary" style="margin-bottom: 10px;">Don't have an account? Register now !</a>
                            <div class="col-sm-12 text-center" style="padding: 10px 0 10px 0;"><a href="#">Forgot password?</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of login form -->
    <!-- Start of login background-->
    <div class="container col-sm-7"  style="float: left; padding: 25px;">
        <img src="../Images/auctionhouse-bg.jpg"/>
    </div>
    <!-- End of login background-->
</div>