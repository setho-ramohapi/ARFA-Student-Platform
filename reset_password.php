<?php require_once 'controllers/authController.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <link rel= "stylesheet" href = "style4.css">
    <title> Reset Password </title>


</head>
<body>

    <div class = "container">
        <div class = "row">
            <div class = "col-md-4 offset-md-4 form-div">
                <form action = "reset_password.php" method = "post">

                    <h3 class = "text-center">Reset your Password</h3>

                    <?php if (count($errors) > 0): ?>
                    <div class = "alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                        <li> <?php echo $error; ?></li>
                        <?php endforeach; ?>

                    </div>
                    <?php endif; ?>

                  
                    <div class = "form-group">
                        <label for= "password"> Password</label>
                        <input type = "password" name = "password" class = "form-control form-control-lg">
                    </div>
                    <div class = "form-group">
                        <label for= "passwordConf"> Confirm Password</label>
                        <input type = "password" name = "passwordConf" class = "form-control form-control-lg">
                    </div>

                    <div class = "form-group">
                        <button type= "submit" name = "reset-password-btn"  style="background-color:orange;" class = "btn btn-primary btn-block btn-lg">Reset Password </button>
                    </div>

                </form>

    </div>
        </div>
            <div>

</body>


</html>