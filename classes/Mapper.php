<?php

namespace classes\mapper;
use \classes\domain as Domain;

abstract class Mapper {
    protected static $_pdo;
    protected $selectByIdStmt;

    function __construct() {
        try {
            self::$_pdo = new \PDO( 'mysql:dbname=db_tcc;host=127.0.0.1', 'victor', 'ifsul' );
            self::$_pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            self::$_pdo->setAttribute( \PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ );

            $this->selectByIdStmt = self::$_pdo->prepare( "SELECT * FROM users WHERE id=?" );
        } catch ( \Exception $e ) {
            die( 'Connection failed.' );
        }
    }

    function find( $id ) {
        $this->selectByIdStmt->execute( array( $id ) );
        $array = $this->selectByIdStmt->fetch( \PDO::FETCH_ASSOC );
        $this->selectByIdStmt->closeCursor();
        if ( ! is_array( $array ) ) { return null; }
        if ( ! isset( $array['id'] ) ) { return null; }
        $object = $this->createObject( $array );
        return $object;
    }

    function createObject( $array ) {
        $obj = $this->doCreateObject( $array );
        return $obj;
    }

    function insert( Domain\DomainObject $obj ) {
        $this->doInsert( $obj );
    }

    abstract function update( Domain\DomainObject $object );
    protected abstract function doCreateObject( array $array );
    protected abstract function doInsert( Domain\DomainObject $object );
    protected abstract function selectStmt();
}
