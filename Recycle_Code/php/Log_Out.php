<!-- 
測試：登出的時候要把session砍掉
之後只要有登出鍵都要放上這個
-->

<?php
     session_start();
     $_SESSION['memberid']=NULL; // 會員id
     $_SESSION['level']=NULL; // 判斷admin

     unset($_SESSION['memberid']);
     unset($_SESSION['level']);

     header('Location:../php/home.php');    
?>


