<?php
date_default_timezone_set('Africa/Nairobi');
require_once('meekrodb.2.3.class.php');
require_once('Logger.php');

define( 'LOG_FILE', 'egpSacco.log');
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PASS', 'MSql@db24' ); 
define( 'DB_NAME', 'egpsavings' );

/** SMS */
define( 'SMS_URL', 'https://www.lyptustech.com/lyptus-api/sms/' );
define( 'SMS_USER', 'EGIC-SMS-21002-EGIC2021' );
define( 'SMS_PASS', 'EGIC-200-222345-SMS2021' );
define( 'CLIENT_ID', '82354' );

/** EMAIL */
#define( 'EMAIL_URL', 'https://www.lyptustech.com/lyptus-api/email/' );
#define( 'EMAIL_USER', 'EMAIL-LYPTUS-9992' );
#define( 'EMAIL_PASS', 'EMAIL-KEY-LYPTUS-9992' );

DB::$user = DB_USER;
DB::$password = DB_PASS;
DB::$dbName = DB_NAME;
DB::$host = DB_HOST;
?>
