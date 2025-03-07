<?php
    namespace Framework;
    class Session {
        /**
         * start the session
         */
        public static function start() {
            // ini_set('session.cookie_domain', $_SERVER['HTTP_HOST']);
            if(session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
        /**
         * Set the session key/value pair
         * 
         * @param string $key
         * @param mixed $value
         * @return void
         */
        public static function set($key, $value) {
            $_SESSION[$key] = $value;
        }
        /**
         * Get the session value by key
         * 
         * @param string $key
         * @param mixed $default
         * @return mixed
         */
        public static function get($key, $default = null) {
            return isset($_SESSION[$key])? $_SESSION[$key] : $default;
        }

         /**
         * Check if session key exists
         * 
         * @param string $key
         * @return bool
         */
        public static function has($key) {
            return isset($_SESSION[$key]);
        }

         /**
         * clear session by key
         * 
         * @param string $key
         * @return void
         */
        public static function clear($key) {
            if(isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
            }
        }
         /**
         * clear all session
         * 
         * 
         * @return void
         */
        public static function clearAll() { 
            session_unset();
            session_destroy();
        }
         /**
         * Set flash message
         * 
         * @param string $key
         * @param string $message
         * @return void
         */
        public static function setflashMessage($key, $message) {
            self::set('flash_' . $key, $message);
        }
        /**
         * Get flash message and unset
         * 
         * @param string $key
         * @param string $default
         * @return string 
         */
        public static function getflashMessage($key, $default = null) {
            $message = self::get('flash_'. $key, $default);
            self::clear('flash_'. $key);
            return $message;
        }
    }