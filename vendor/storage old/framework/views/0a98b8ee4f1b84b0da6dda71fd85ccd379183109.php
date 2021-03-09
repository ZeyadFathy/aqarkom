<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="utf-8"> 
    </head>
    <body>
        <p>عزيزي  <?php echo e($user->name, false); ?></p>
        <p>لقد تم تغيير كلمة المرور كلمة مرورك الجديدة : <?php echo e($password, false); ?></p>
    </body>
</html>    