<?php if (permission_check('user management')) { ?>
    <div>
        <a href="?cont=user">User management</a>
    </div>
<?php } ?>
<?php if (permission_check('user management')) { ?>
    <div>
        <a href="?cont=user&action=modify_role">User permission management</a>
    </div>
<?php } ?>
<?php if (permission_check('role management')) { ?>
    <div>
        <a href="?cont=role">Role management</a>
    </div>
<?php } ?>
<?php if (permission_check('role_permission management')) { ?>
    <div>
        <a href="?cont=rolepermission">Role - Permission management</a>
    </div>
<?php } ?>