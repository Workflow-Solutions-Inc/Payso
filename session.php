<?php
session_id("payso");
   session_start();
   //unset($_SESSION['counter']);
   if( isset( $_SESSION['counter'] ) ) 
   {
      $_SESSION['counter'] += 1;

      if($_SESSION['counter'] == 2)
      {
         unset($_SESSION['counter']);
      }
   }
   else 
   {
      $_SESSION['counter'] = 1;
      
   }
	
   $msg = "You have visited this page ".  $_SESSION['counter'];
   $msg .= "in this session.";
?>

<html>
   
   <head>
      <title>Setting up a PHP session</title>
   </head>
   
   <body>
      <?php  echo ( $msg ); ?>
   </body>
   
</html>