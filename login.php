<?php

require_once( 'init.php' );

use \classes\mapper as Mapper;
use \classes\domain as Domain;

if ( isset( $_POST["submit"] ) ) {
    // filter_input() não usado propositalmente
    $user = new Domain\User();

    $login = $user->login( $_POST['username'], $_POST['password'] );

    if ( $login ) {
        header( 'Location: ./' );
    } else {
        $_SESSION['error'] = 'Username or Password incorrect!';
    }
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel='stylesheet' href='style.css' media='screen'>
</head>
<body>
<?php
    if ( isset( $_SESSION['error'] ) ) {
        echo "<p class='msg-error'>{$_SESSION['error']}</p>";
        unset( $_SESSION['error'] );
    }
?>
<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="text" name="password" id="password" autocomplete="off">
    </div>

    <input type="submit" value="Log in" name="submit">
</form>
</body>
</html>
