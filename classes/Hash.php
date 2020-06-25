<?php

class Hash {

    public static function make($string) {
        return password_hash($string, PASSWORD_DEFAULT);
    }

    public static function check($noHash, $hashed) {
        return password_verify($noHash, $hashed);
    }

    public static function unique() {
        return self::make(uniqid());
    }
}