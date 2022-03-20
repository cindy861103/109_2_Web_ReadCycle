<!-- 
測試：拿到登入session
然後把資料庫的東西拿出來（目前拿會員資料，之後拿書籍之類的） 
-->
<!DOCTYPE html>
<html>
<head>
     <!-- session打開 -->
     <?php session_start(); ?>
     <meta charset="UTF-8">
     <title>測試個人資料</title>
     <link rel="stylesheet" type="text/css" href=""/>
</head>

<body>
     <?php 
          // if ($_SESSION['memberid'] != null){
          //      echo $_SESSION['memberid']."<br>";
          // }else{
          //      echo "沒拿到";
          // }
     ?>
     <?php

     include("conn.php");
     // 若沒有登入成功
     if ($_SESSION['memberid'] != null){
          $memberid = $_SESSION['memberid'];
          // 拿member表的東西
          $sql = "SELECT * FROM member WHERE member_id = '$memberid' ";
         
          // $result= $db -> query($sql);
          // $attr = $result -> fetch_assoc();
          $attr = $result -> fetch_row();
          for($i =0 ;$i< count($attr) ;$i++){
               echo "$i:".$attr[$i]."<br>";
          }
          
          echo "id:".$attr[1];
     }else{
          echo ":)";
     }
     
     ?>
     
</body>

</html>