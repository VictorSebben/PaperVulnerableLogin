<?php

class Database {
    private static $_instance;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    private function __construct() {
        try {
            $this->_pdo = new PDO( 'mysql:dbname=db_tcc;host=127.0.0.1', 'victor', 'ifsul' );
            $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->_pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ );
        } catch ( PDOException $e ) {
            die( 'Connection failed.' );
        }
    }

    public static function getInstance() {
        if ( !isset( self::$_instance ) ) {
            self::$_instance = new Database();
        }

        return self::$_instance;
    }

    public function query( $sql, array $params ) {
        $this->_error = false;

        if ( $this->_query = $this->_pdo->prepare( $sql ) ) {
            if ( count( $params ) ) {
                $x = 1;
                foreach ( $params as $param ) {
                    $this->_query->bindValue( $x, $param );
                    $x++;
                }
            }

            if ( $this->_query->execute() ) {
                $this->_results = $this->_query->fetchAll( PDO::FETCH_OBJ );
                $this->_count   = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    public function prepare( $sql ) {
        $this->_query = $this->_pdo->prepare( $sql );
    }

    public function executePreparedQuery( array $params ) {
        if ( count( $params ) ) {
            $x = 1;
            foreach ( $params as $param ) {
                $this->_query->bindValue( $x, $param );
                $x++;
            }
        }

        if ( $this->_query->execute() ) {
            $this->_results = $this->_query->fetchAll( PDO::FETCH_OBJ );
            $this->_count   = $this->_query->rowCount();
        } else {
            $this->_error = true;
        }
    }

    public function select( $rows = '*', $table, $where = array() ) {
        if ( is_array( $rows ) ) {
            $rows = implode( ", ", $rows );
        }

        $sql = "SELECT {$rows} FROM {$table} WHERE ";

        $params = "";
        if ( is_array( $where ) && ( sizeof( $where ) > 0 ) ) {
            $x = 2;
            foreach ( $where as $value ) {
                if ( $x === 0 ) {
                    $params[] = $value;
                    $sql .= "? AND ";
                } else {
                    $sql .= "{$value} ";
                }

                $x--;
                if ( $x === -1 ) {
                    $x = 2;
                }
            }

            $sql = preg_replace( '/AND $/', '', $sql );

            exit($sql);
            $this->query( $sql, $params );
        }
    }

    /* public function insert( $table, $fields = array() ) { */

    /* } */

    public function delete( $table, $where ) {
        if ( count( $where ) === 3 ) {
            $field    = $where[0];
            $operator = $where[1];
            $value    = $where[2];
            $sql = "DELETE FROM {$table} WHERE {$field} {$operator} ?";

            if ( !$this->_query( $sql, array( $value ) )->getError ) {
                return true;
            }
        }

        return false;
    }

    /* public function update() { */

    /* } */

    public function getResults() {
        return $this->_results;
    }

    public function getFirstResult() {
        return $this->getResults()[0];
    }

    // did the query work out ok?
    public function getError() {
        return $this->_error;
    }

    // were records found?
    public function getCount() {
        return $this->_count;
    }
}
