<?php
	class Conf {

	 private static $APP_ID = "8bA5hUs4U96x96qcSaX5GVQj";
	 private static $MASTER_KEY = "98uVy2y8B3YKT74bvZ3dmFvE";
	 private static $IP_ADRESS = "10.15.81.12";
	 private static $PORT = "1337";

	public static function get_APP() {
	  return self::$APP_ID;
	}

	public static function get_MASTER() {
	  return self::$MASTER_KEY;
	}

	public static function get_IP() {
	  return self::$IP_ADRESS;
	}

	public static function get_PORT() {
	  return self::$PORT;
	}

	public static function set_APP($app) {
	  self::$APP_ID = $app;
	}

	public static function set_MASTER($master) {
	  self::$MASTER_KEY = $master;
	}

	public static function set_IP($ip) {
	   self::$IP_ADRESS = $ip;
	}

	public static function set_PORT($port) {
	   self::$PORT = $port;
	}

}
