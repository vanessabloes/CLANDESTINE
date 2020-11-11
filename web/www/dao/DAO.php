<?php

class DAO {

  // Properties
  private static $sharedPDO;
  protected $pdo;

  // Constructor
  function __construct() {

    if(empty(self::$sharedPDO)) {
      self::$sharedPDO = new PDO("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
      self::$sharedPDO->exec("SET CHARACTER SET utf8");
      self::$sharedPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$sharedPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    $this->pdo =& self::$sharedPDO;

  }

  // Methods

}
