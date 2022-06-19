<?php
   require "../libraries/main/Main.php";
   require "../libraries/database/Management.php";
   $connection = new ManageConnection($database);
   $connection->Logout();
   sleep(1);
   header("Location: ./login");
   exit;
   ?>
