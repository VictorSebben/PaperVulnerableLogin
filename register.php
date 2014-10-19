<?php

require_once( 'init.php' );

use \classes\util as Util;
use \classes\mapper as Mapper;
use \classes\domain as Domain;

if ( isset( $_POST['submit'] ) ) {
    $password = Util\Hash::make( $_POST['password'] );

    $user = new Domain\User();
    $user->setUsername( $_POST['username'] );
    $user->setPassword( $password );

    $userMapper = new Mapper\UserMapper();
    try {
        $userMapper->insert( $user );
        header( 'Location: ./' );
    } catch ( Exception $e ) {
        echo $e->getMessage();
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
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Enter your password again:</label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <input type="submit" value="Register" name="submit">
</form>
</body>
</html>