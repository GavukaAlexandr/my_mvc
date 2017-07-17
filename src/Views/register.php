<?php extract($data) ?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta charset="utf-8"/>
</head>

<body>
<form method="post" action="/register">
    <!--<div class="imgcontainer">-->
    <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">-->
    <!--</div>-->

    <div>
        <h2>
            <?php if (!empty($message)){
                echo $message;
            }; ?>
        </h2>
    </div>
    <div class="container">
        <label><b>name</b></label>
        <input type="text" placeholder="Enter name" name="name" required>

        <label><b>email</b></label>
        <input type="email" placeholder="Enter Email" name="email" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <button type="submit">Register</button>
        <!--<input type="checkbox" checked="checked"> Remember me-->
    </div>

    <!--<div class="container" style="background-color:#f1f1f1">-->
    <!--<button type="button" class="cancelbtn">Cancel</button>-->
    <!--<span class="psw">Forgot <a href="#">password?</a></span>-->
    <!--</div>-->
</form>
</body>
</html>
