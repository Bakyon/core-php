<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<div class="container-fluid profile-container">
    <div class="row container">
        <h1>Edit profile</h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <!-- Start of change info form -->
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="col-xl-12">
                    <!-- Start of basic information -->
                    <div class="container col-xl-4 col-xs-12" style="float: left; padding: 25px;">
                        <div class="container col-xs-12 mail_sectin">
                            <div class="input-group-text">
                                <label for="email" style="margin: 0; width: 30%;"><b>Email</b></label>
                                <input type="text" class="email-bt" readonly value="<?= $data['user']->getEmail() ?>" name="email" size="28" aria-required="true">
                            </div><br><div class="input-group-text">
                                <label for="name" style="margin: 0; width: 30%;"><b>Name</b></label>
                                <input type="text" class="email-bt" required value="<?= $data['user']->getName() ?>" name="name" size="28" aria-required="true">
                            </div><br>
                            <div class="input-group-text">
                                <label for="birthdate"  style="margin: 0; width: 30%;"><b>Birthdate</b></label>
                                <input type="date" class="email-bt" required value="<?= $data['user']->getBirthday() ?>" name="birthdate" size="20" aria-required="true">
                            </div><br>
                            <div class="input-group-text">
                                <label for="gender"  style="margin: 0; width: 30%;"><b>Gender</b></label>
                                <select name="gender" class="email-bt">
                                    <option value="1" <?= $data['user']->getGender() == 1 ? 'selected' : '' ?>>Male</option>
                                    <option value="2" <?= $data['user']->getGender() == 2 ? 'selected' : '' ?>>Female</option>
                                    <option value="3" <?= $data['user']->getGender() == 3 ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div><br>
                        </div>
                    </div>
                    <!-- End of basic information -->
                    <!-- Start of additional information-->
                    <div class="container col-xl-4 col-xs-12"  style="float: left; padding: 25px;">
                        <div class="container col-xs-12 mail_sectin">
                            <div class="input-group-text">
                                <label for="avatar"  style="margin: 0; width: 30%;"><b>Avatar</b></label>
                                <input type="file" class="form-control-file" placeholder="Choose your file..." onchange="preview(event)" id="avatar" name="avatar" aria-describedby="fileHelpId" style="margin: 0; padding: 0 0 0 20px;">
                            </div><br>
                            <div>
                                <img id="preview-img-1" src="Images/UploadAvatars/<?= $data['user']->getAvatar() ?>" width="130px" height="130px" style="border-radius: 50%; margin: 5px; padding: 0;">
                                <img id="preview-img-2" src="Images/UploadAvatars/<?= $data['user']->getAvatar() ?>" width="60px" height="60px" style="border-radius: 50%; margin: 5px; padding: 0;">
                                <div class="row" style="padding: 10px;">
                                    <button class="btn btn-dark" type="button" onclick="reset_prv('<?= $_SESSION['avatar'] ?>')" style="width: 200px; margin: 0 0 10px 30px;">Reset image</button>
                                    <button class="btn btn-danger" type="button" onclick="unset_avt()" style="width: 200px; margin: 0 0 10px 30px;">Remove avatar</button>
                                    <script>
                                        let preview = function(event) {
                                            for (let i = 1; i < 3; i++) {
                                                let $img = 'preview-img-' + i;
                                                let output = document.getElementById($img);
                                                output.src = URL.createObjectURL(event.target.files[0]);
                                                output.onload = function() {
                                                    URL.revokeObjectURL(output.src) // free memory
                                                }
                                            }
                                        };
                                        let reset_prv = function(avt) {
                                            let $img1 = document.getElementById('preview-img-1');
                                            let $img2 = document.getElementById('preview-img-2');
                                            $img1.src = $img2.src = 'Images/UploadAvatars/' + avt;
                                            let $fileInput = document.getElementById('avatar');
                                            $fileInput.files = null;
                                            $fileInput.value = '';
                                        };
                                        let unset_avt = function() {
                                            if (confirm('Are you sure you want to remove your avatar? This action cannot be undone and going to take effect right after you confirm.')) {
                                                window.location.href = '?cont=user&action=unsetavt';
                                            }
                                        };
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of additional information -->
                    <!-- Start of avatar preview -->
                    <div class="container col-xl-4 col-xs-12"  style="float: left; padding: 25px;">
                        <input name="token" type="password" hidden="hidden" readonly value="<?= $data['token'] ?>">
                        <button type="submit" class="btn btn-success" style="width: 200px; margin: 0 0 10px 30px;">Update profile</button>
                        <button type="reset" class="btn btn-danger" style="width: 200px; margin: 0 0 10px 30px;" onclick="reset_prv('<?= $_SESSION['avatar'] ?>')">Reset</button>
                        <a href="?cont=user&action=profile" class="btn btn-secondary" style="width: 200px;margin: 0 0 10px 30px;">Go back</a>
                    </div>
                    <!-- End of avatar preview -->
                </div>
            </form>
            <!-- End of change info form -->

        </div>
    </div>
</div>

