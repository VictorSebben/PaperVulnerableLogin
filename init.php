<?php

session_start();

spl_autoload_extensions( ".php" ); // comma-separated list
spl_autoload_register( function( $class ) {
    $class = preg_replace('/.*\\\/', '', $class);
    require_once 'classes' . DIRECTORY_SEPARATOR . $class . '.php';
} );