<?php
defined('BASE_URL') OR exit('Access denied !!!');
$genders = ['Male', 'Female', 'Other'];
?>
<div class="container-fluid profile-container">
    <div class="row">
        <div class="col-xl-3">
            <div class="card-img" style="padding: 30px;">
                <img src="images/UploadAvatars/<?= $data->getAvatar() ?>" style="border-radius: 50%; margin: 0 5px; object-fit: cover; width: 200px; height: 200px;">
            </div>
            <?php
            if (is_login() && strcasecmp($data->getId(), $_SESSION['id']) == 0) {
                ?>
                <div>
                    <a href="?cont=user&action=edit" class="btn btn-success" style="width: 200px;margin: 0 0 10px 30px;">Edit profile</a>
                    <a href="?cont=user&action=changepw" class="btn btn-secondary" style="width: 200px; margin: 0 0 10px 30px;">Change password</a>
                    <button class="btn btn-danger" style="width: 200px; margin: 0 0 10px 30px;" onclick="confirmResetPsw()">Reset password</button>
                    <script>
                        function confirmResetPsw() {
                             if (confirm('Are you sure you want to reset password?')) {
                                 // Redirect to the reset password action
                                 window.location.href = "?cont=user&action=resetpw";
                             }
                        }
                    </script>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col-xl-9">
            <!-- Start of basic information -->
            <div class="container col-xs-12" style="float: left; padding: 25px;">
                <div class="container col-xs-12 mail_sectin">
                    <div class="input-group-text">
                        <label for="name" style="margin: 0; width: 30%;"><b>Name</b></label>
                        <input type="text" class="email-bt" disabled value="<?= $data->getName() ?>" name="name" size="28" aria-required="true">
                    </div><br>
                    <div class="input-group-text">
                        <label for="gender"  style="margin: 0; width: 30%;"><b>Gender</b></label>
                        <input type="text" class="email-bt" disabled value="<?= $genders[$data->getGender() - 1] ?>" name="gender" size="20" aria-required="true">
                    </div><br>
                    <div class="input-group-text">
                        <label for="birthday"  style="margin: 0; width: 30%;"><b>Birthdate</b></label>
                        <input type="date" class="email-bt" disabled value="<?= $data->getBirthday() ?>" name="birthday" aria-required="true">
                    </div><br>
                    <div class="input-group-text">
                        <label for="address"  style="margin: 0; width: 30%;"><b>Registered email</b></label>
                        <input type="text" class="email-bt" disabled value="<?= $data->getEmail() ?>" name="address" aria-required="true">
                    </div><br>
                </div>
            </div>
            <!-- End of basic information -->
        </div>
    </div>
</div>