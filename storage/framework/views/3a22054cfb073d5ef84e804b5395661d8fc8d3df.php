<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yêu cầu tạo lại mật khẩu</title>
</head>
<body>
    <div class="cw-wrapper">
        <h3>Xin chào, <?php echo e($user->name); ?></h3>
        <p>
            Chúng tôi vừa nhận được yêu cầu đặt lại mật khẩu của bạn. <br>Hãy truy cập link bên dưới để đặt lại mật khẩu
        </p>
        <p>
            link: <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
        </p>

        <p></p>
        <p></p>
        <p>Nếu không phải bạn vui lòng bỏ qua email này!</p>
        
    </div>
</body>
</html><?php /**PATH /Users/doanln/Desktop/Gomee/wisestyle/resources/views/mails/reset-password.blade.php ENDPATH**/ ?>