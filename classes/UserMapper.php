<?php

namespace classes\mapper;
use \classes\domain as Domain;

class UserMapper extends Mapper {
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$_pdo->prepare(
            "SELECT * FROM users WHERE username=? AND password=?"
        );

        $this->updateStmt = self::$_pdo->prepare(
            "UPDATE users SET username=?, password=? WHERE id=?"
        );

        $this->insertStmt = self::$_pdo->prepare(
            "INSERT INTO users ( username, password )
                         values ( ?, ? )"
        );
    }

    protected function doCreateObject( array $array )
    {
        $obj = new Domain\User( $array['id'] );
        $obj->setUsername( $array['username'] );
        $obj->setPassword( $array['password'] );
        return $obj;
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    function rawSelect( $sql ) {
        return self::$_pdo->query( $sql );
    }

    protected function doInsert( Domain\DomainObject $object ) {
        $values = array( $object->getUsername(), $object->getPassword() );
        $this->insertStmt->execute( $values );
        $id = self::$_pdo->lastInsertId();
        $object->setId( $id );
    }

    function update( Domain\DomainObject $object ) {
        $values = array( $object->getUsername(), $object->getPassword(), $object->getId() );
        $this->updateStmt->execute( $values );
    }

}
