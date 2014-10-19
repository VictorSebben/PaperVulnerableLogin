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
        echo 'Username or Password incorrect!';
    }
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
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
