<?php
    namespace Framework;

    use DateTime;
    use DateTimeZone;

    class Validation {
        /**
         * Validation a string
         * 
         * @param string $value
         * @param int $min
         * @param int $max
         *  
         * @return bool
         */   
        public static function string ($value, $min = 1, $max = INF) {
            if(is_string($value)){
                $value = trim($value);
                $length = strlen($value);
                return ($length >= $min && $length <= $max);
            }
            return false;
        }
        
        /**
         * Validate a array
         * 
         * @param array $arr
         * 
         *  @return bool
         */
        public static function array ($arr) {
            return is_array($arr) && count($arr) > 0;
        }
        /**
         * Validation a email address
         * 
         * @param string $value
         * 
         * @return mixed
         */
        public static function email ($value) {
            $value = trim($value);
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }
        /**
         * Validation a against another
         * 
         * @param string $value1
         * @param string $value2
         * 
         * @return bool
         */
        public static function match ($value1, $value2) {
            $value1 = trim($value1);
            $value2 = trim($value2);
            return ($value1 === $value2);
        }

        public static function validateDate($date, $format = 'Y-m-d') {
            $d = DateTime::createFromFormat($format, $date);
            $d->setTimezone(new DateTimeZone("Asia/Ho_Chi_Minh"));
            return $d && $d->format($format) === $date;
        }

        public static function startEndDate($startDate, $endDate) {
            //self để gọi lại thuộc tính trong class
            return self::validateDate($startDate, 'Y-m-d') && self::validateDate($endDate, 'Y-m-d') && $startDate <= $endDate;
        }
    }
