<?php
class Database
{
    private static $dbHost = 'localhost' ;
    private static $dbName = '' ;
    private static $dbUsername = '';
    private static $dbUserPassword = '';
   
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName
            , self::$dbUsername
            , self::$dbUserPassword
            , array(
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
          )); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
//www.startutorial.com/articles/view/php-crud-tutorial-part-1#sthash.IovmQcVJ.dpuf
?>
