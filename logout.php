<?php

require_once( 'init.php' );

$user = new \classes\domain\User();
$user->logout();

header( "Location: ./" );
