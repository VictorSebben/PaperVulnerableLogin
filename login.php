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
<body class='login-form'>
  <section>
    <header class="login-header">
      <h1>Simple Login System</h1>
    </header>
    <div class="form-div">
      <fieldset>
        <legend>Login</legend>
        <form action="" method="post">
          <div class="login-info-input">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
          </div>
          <div class="clear"></div>
          <div class="login-info-input">
            <label for="password">Password</label>
            <input type="text" name="password" id="password" autocomplete="off">
          </div>
          <div class="clear"></div>
          <div class="div-submit">
            <label for="submit">&nbsp;</label>
            <input type="submit" value="Log in" name="submit">
            <?php
               if ( isset( $_SESSION['error'] ) ) {
                   echo "<p class='msg-error'>{$_SESSION['error']}</p>";
                   unset( $_SESSION['error'] );
               }
            ?>
          </div>
        </form>
      </fieldset>
    </div>
  </section>
</body>
</html>
