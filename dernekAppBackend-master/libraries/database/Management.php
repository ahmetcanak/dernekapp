<?php

#^Database Informations

/*************       DATABASE          ***************/
    define("HOST", "localhost");
    define("PORT", "3306");
    define("USER", "ahmetc18_ahmetcanak-dernek");
    define("PASSWORD", "NIRYBzdC5C");
    define("DATABASE", "ahmetc18_ahmetcanak-dernek-app");


/*************       SYSTEM CONFIG          ***************/
    date_default_timezone_set('Europe/Istanbul');


/*************       CONNECTION          ***************/
    try {
      $database = new PDO("mysql:host=".HOST.";port=".PORT.";dbname=".DATABASE.";charset=utf8", "".USER."", "".PASSWORD."");
      $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      echo $exception->getMessage();
    }

?>
