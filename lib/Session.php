<?php

/**
 * Created by PhpStorm.
 * User: Przemo
 * Date: 2017-07-09
 * Time: 19:01
 */
class Session {

    public static function init() {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            if (session_id() == '') {
                session_start();
            }
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    /**
     * @param $key
     * @param $val
     */
    public static function set($key, $val) {
        $_SESSION[$key] = $val;
    }

    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public static function checkSession() {
        self::init();
        if (self::get("adminlogin") == false) {
            self::destroy();
            header("Location:login.php");
        }
    }

    public static function checkLogin() {
        self::init();
        if (self::get("adminlogin") == true) {
            header("Location:login.php");
        }
    }

    public static function destroy() {
        session_destroy();
        header("Location:login.php");
    }
}
