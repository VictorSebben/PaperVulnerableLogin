<?php

namespace classes\util;

class Hash {
    public static function make( $string ) {
        return hash( 'sha256', $string );
    }
} 