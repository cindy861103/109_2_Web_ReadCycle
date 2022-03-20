
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>forget_pwd.php</title>
</head>
<body>
     

     <?php
     // 連上資料庫，拿到 會員密碼
     // 是否是表單送回
          if ($_SERVER["REQUEST_METHOD"]=="POST"){
               if (empty($_POST["username"])){
                    echo "填入你的學號";
                    
               }else{
                    $user = $_POST["username"]; // 取得表單欄位內容
                    
                    include ('conn.php');
                    // 確認有沒有在會員名單內
                    $sql = "SELECT member_id,email FROM member where member_id = '$user'";
                    $result= $db -> query($sql);
                    $attr = $result -> fetch_row();
                    
                    if($attr[0] == $user ){
                         $to = $attr[1]; // email
                         echo $to;
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
          $subject = "Readcycle 重新設定新密碼";
          $body = " $user 您好，這是您的新密碼: $newpd ! \n 為了您的帳戶安全，登入後請改新密碼";
          // 送出郵件
               if (mail($to, $subject, $body, $header))
                    echo "郵件已經成功的寄出!請去信箱查收您的新密碼 <br/>";
               else
                    echo "郵件寄送失敗!請聯繫本平台<br/>";
     ?>
     
     
</body>
</html>