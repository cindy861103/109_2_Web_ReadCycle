<?php
     try{
          // mysqli('連線的伺服器', 'username', 'password', 'database', 'port')

          // $db = new mysqli('localhost','root','','readcycle','8080'); //Kelly
          $db = new mysqli('localhost', 'U05153255', 'P05153255', 'readcycle', '3306'); //Cindy
          
          if($db->connect_error){
               /*連線資料庫失敗，並說為什麼失敗*/
               die("Connection failed: " . $db->connect_error);
          }else{ 
               /*連線資料庫成功*/
               // echo "SQL CONN SUCCESS!<br>";
               echo '';
          }
     }catch(Exception $e){
          // Ｋ：也是失敗原因、但...我也忘記為什麼要再寫 
          echo "Exception:".$e -> getMessage()."\n";
          !mysqli_connect_error() or die('資料庫連線失敗');
     }
     $db->query('SET NAMES UTF8');

?>

