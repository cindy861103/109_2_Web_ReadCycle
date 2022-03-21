
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/Forget_Pwd_style.css"/>
<meta charset="utf-8" />
<title>forget_pwd.php</title>
</head>
<body>
<div id="forget_pwd_frame">
     <?php
     // 連上資料庫，拿到 會員密碼
     // 是否是表單送回
          if ($_SERVER["REQUEST_METHOD"]=="POST"){
               if (empty($_POST["username"])){
                    echo "填入你的學號<br>";
                    $user = $newpd =  $to ='';
               }else{
                    $user = $_POST["username"]; // 取得表單欄位內容
                    
                    include ('../conn.php');
                    // 確認有沒有在會員名單內
                    $sql = "SELECT member_id,email FROM member where member_id = '$user'";
                    $result= $db -> query($sql);
                    $attr = $result -> fetch_row();
                    
                    if($attr[0] == $user ){
                         $to = $attr[1]; // email
                         
                    }else{
                         echo "沒有找到此帳戶，請先註冊。";
                    }
                    // 直接幫忙資料庫改密碼（亂數）
                    $newpd = bin2hex(random_bytes(10));
                    $sql = "UPDATE `member` SET `password` = '$newpd' WHERE `member`.`member_id` = '$user';";
                    $result= $db -> query($sql);
               }
          }
          // 寄出
          $from = "07153104@gm.scu.edu.tw";
          $header = "From: $from \n";
          $subject = "Readcycle書適圈會員密碼通知函";
          $body = " $user 您好，這是您的新密碼: $newpd ! \n 為了您的帳戶安全，登入後請改新密碼";
          // 送出郵件
               if (mail($to, $subject, $body, $header)){
                    echo "<h1>郵件已經成功的寄出!</br>請去信箱查收您的新密碼 </h1>";
                    echo "<h2>2秒後...即將跳回登入頁面</h2>";
                    header("Refresh:2 ; ../html/Log_In.html"); 
               }else{
                    echo "<h1>郵件寄送失敗!請聯繫本平台<h1>";
               }
                    

     ?>
     
</div>
</body>
</html>