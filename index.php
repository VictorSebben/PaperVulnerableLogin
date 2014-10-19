<?php

require_once( 'init.php' );

//require_once( 'classes/domain/User.php' );
//require_once( 'classes/Mapper.php' );
//require_once( 'classes/UserMapper.php' );

use \classes\mapper as Mapper;
use \classes\domain as Domain;

/*  dsn      = 'mysql:dbname=db_classes;host=127.0.0.1'; */
/* $user     = 'victor'; */
/* $password = 'ifsul'; */

/* try { */
/*   $pdo = new PDO( $dsn, $user, $password ); */
/*   $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); */
/*   $pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ ); */
/* } catch ( PDOException $e ) { */
/*   echo 'Connection failed: ' . $e->getMessage(); */
/* } */

// $db = new \classes\mapper\Mapper();
// $db->select( array( 'id', 'name' or <a href="register.php">register.</a> ), 'users', array( 'name', '=', 'victor', 'id', '=', '1' ), 'name'  );

if ( Domain\User::isLoggedIn() ) {
    $userMapper = new Mapper\UserMapper();
    $user = $userMapper->find( $_SESSION["user"] );

    if ( isset( $user ) ) {
        echo '<h2>Welcome, ' . $user->getUsername() . '</h2>';
        echo '<a href="logout.php">Logout</a>';
    }
} else {
    echo '<p>You need to <a href="login.php">Log in</a> or <a href="register.php">Register</a></p>';
}

