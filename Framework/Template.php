<?php
     namespace Framework;
    use Framework\Auth;
    
    class Template
    {
        protected static $user = null;
        
        public static function can($permissions, $content)
        {
            self::$user = Auth::user();
            if(is_array(self::$user) && in_array($permissions, self::$user['permissions_name'])){
                return $content;
            }
            return '';
        }

    }