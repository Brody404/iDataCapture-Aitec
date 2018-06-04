<?php
    class Session {

        public static function is_connected() {
           $currentUser = Parse\ParseUser::getCurrentUser();
      	   if ($currentUser)
      	       return true;
      	   else
      	       return false;
        }

        public static function is_user($userId) {
            return (self::is_connected() && !empty($_SESSION['parseData']['user']) && ($_SESSION['parseData']['user']->getObjectId() == $userId));
        }

        public static function is_admin() {
          return false;
        }

    }
