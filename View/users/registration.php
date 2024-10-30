<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<div class="container-fluid" style="padding: 50px;">
    <div class="image_2"><img src="Images/logo.png" style="height: 70px; width: auto;"></div>
    <h1 class="about_taital">Registration</h1>
    <!-- Registration form -->
    <form method="post" enctype="multipart/form-data">
        <!-- Start of basic information -->
        <div class="container col-xl-4 col-lg-6 col-xs-12" style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin">
                <div class="input-group-text">
                    <label for="email" style="margin: 0; width: 30%;"><b>Email *</b></label>
                    <input type="text" class="email-bt" required placeholder="Enter email" name="email" size="28" aria-required="true">
                </div><br>
                <div class="input-group-text">
                    <label for="password" style="margin: 0; width: 30%;"><b>Password *</b></label>
                    <input type="password" class="email-bt" required placeholder="Enter Password" name="password" size="50" aria-required="true">
                </div><br>
                <div class="input-group-text">
                    <label for="2ndpassword" style="margin: 0; width: 30%;"><b>Retype<br>password *</b></label>
                    <input type="password" class="email-bt" required placeholder="Retype password" name="2ndpassword" size="50" aria-required="true">
                </div><br>
                <div class="input-group-text">
                    <label for="birthdate"  style="margin: 0; width: 30%;"><b>Birthdate *</b></label>
                    <input type="date" class="email-bt" required name="birthdate" aria-required="true">
                </div><br>
                <div class="input-group-text">
                    <label for="gender"  style="margin: 0; width: 30%;"><b>Gender *</b></label>
                    <select name="gender" class="email-bt">
                        <option value="1" >Male</option>
                        <option value="2">Female</option>
                        <option value="3" selected>Other</option>
                    </select>
                </div><br>
            </div>
        </div>
        <!-- End of basic information -->
        <!-- Start of additional information-->
        <div class="container col-xl-4 col-lg-6 col-xs-12"  style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin">
                <div class="input-group-text">
                    <label for="name"  style="margin: 0; width: 30%;"><b>Name</b></label>
                    <input type="text" class="email-bt" placeholder="Enter Alias" name="name" size="50">
                </div><br>
                <div class="input-group-text">
                    <label for="avatar"  style="margin: 0; width: 30%;"><b>Avatar</b></label>
                    <input type="file" class="form-control-file" placeholder="Choose your file..." onchange="preview(event)" name="avatar" aria-describedby="fileHelpId" style="margin: 0; padding: 0 0 0 20px;">
                </div><br>
                <div>
                    <img id="preview-img-1">
                    <img id="preview-img-2">
                </div>
            </div>
        </div>
        <!-- End of additional information -->
        <div class="container col-xl-4 col-lg-6 col-xs-12"  style="float: left; padding: 25px;">
            <div class="container col-xs-12 mail_sectin card-group">
                <input type="password" readonly hidden="hidden" name="token" value="<?= $data['token'] ?>">
                <button type="submit" class="btn btn-success" style="margin-bottom: 10px; width: 100%;">Register</button>
                <a href=<?= BASE_URL ?> type="button" class="btn btn-secondary" style="margin-bottom: 10px; width: 100%;">Go back to home page</a>
                <a href="?cont=user&action=login" type="button" class="btn btn-dark" style="margin-bottom: 10px; width: 100%;">Already have an account?<br>Login now !</a>
            </div>
        </div>
    </form>
    <!-- End of registration form -->
</div>
<script>
    let preview = function(event) {
        let size = [130, 60];
        for (let i = 1; i < 3; i++) {
            let $img = 'preview-img-' + i;
            let output = document.getElementById($img);
            output.style.height = size[i-1] + 'px';
            output.style.width = size[i-1] + 'px';
            output.style.float = "left";
            output.style.marginRight = "20px";
            output.style.borderRadius = "50%";
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }

    };
</script>