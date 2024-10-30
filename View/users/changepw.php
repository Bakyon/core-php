<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<div class="container-fluid profile-container">
    <div class="row">
        <div class="col-xl-3">
            <div class="card-img" style="padding: 30px;">
                <img src="Images/UploadAvatars/<?= $data->getAvatar() ?>" style="border-radius: 50%; margin: 0 5px; object-fit: cover; width: 200px; height: 200px;">
            </div>
            <div>
                <a href="?cont=user&action=profile" class="btn btn-secondary" style="width: 200px;margin: 0 0 10px 30px;">Go back</a>
            </div>
        </div>
        <div class="col-xl-9">
            <!-- Start of change pw form -->
            <form action="#" method="post" enctype="multipart/form-data">
                <!-- Start of password form -->
                <div class="container col-xl-8 col-xs-12" style="float: left; padding: 25px;">
                    <div class="container col-xs-12 mail_sectin">
                        <div class="input-group-text">
                            <label for="old_password" style="margin: 0; width: 30%;"><b>Current password</b></label>
                            <input type="password" class="email-bt" required placeholder="Enter current password" name="old_password" size="28" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                        </div><br>
                        <div class="input-group-text">
                            <label for="new_password"  style="margin: 0; width: 30%;"><b>New password</b></label>
                            <input type="password" class="email-bt" required placeholder="Enter new password" name="new_password" size="20" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                        </div><br>
                        <div class="input-group-text">
                            <label for="confirm_password"  style="margin: 0; width: 30%;"><b>Confirm password</b></label>
                            <input type="password" class="email-bt" required placeholder="Retype new password" name="confirm_password" aria-required="true" style="margin: 0; padding: 0 0 0 20px;">
                        </div><br>
                    </div>
                </div>
                <!-- End of password form -->
                <div class="container col-xl-1">
                    <input name="token" type="password" hidden="hidden" readonly value="<?= $data['token'] ?>">
                    <button type="submit" class="btn btn-success" style="width: 200px; margin: 0 0 10px 30px;">Change password</button>
                </div>
            </form>
            <!-- End of change pw form -->
        </div>
    </div>
</div>

