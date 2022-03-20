<!-- 
for login 

1. 先看資料是否有填寫完整
2. 再比對資料庫內容
3. 跳轉到登入後首頁

-->
<!DOCTYPE html>
<html>
<head>
     <!-- session打開 -->
     <?php session_start(); ?>
     <meta charset="UTF-8">
     <title>登入</title>
     <link rel="stylesheet" type="text/css" href="css/Log_In_style.css"/>
</head>

<body>
     <div id="login_frame">
          <p id="text_logo">登入</p>
     <!-- 登入驗證 -->
          <?php 
          // 必填
          $userid = $password = "";
          // 測試是否有拿到
          // 並接收使用者輸入
          if ($_SERVER["REQUEST_METHOD"]=="POST"){
               if (empty($_POST["userid"])){
                    echo '請輸入學號<br>';
               }else{
                    $memberid = $_POST["userid"];
               }
               if (empty($_POST["password"])){
                    echo "請輸入密碼<br>";
               }else{
                    $password = $_POST["password"];
               }
          }
          ?>

     <?php
          /*連線資料庫*/
     include ("../conn.php");

     // 接收使用者輸入
     // session 放入 
     // admin 跟 member 有 level 值

     if($memberid == '' || $password == ''){
          echo "<h2>輸入失敗，兩秒後回前頁</h2>";
          echo "<meta http-equiv=REFRESH CONTENT=2;url=Log_In.html>";
     }else{
          $sql = "SELECT password,level,depart FROM member WHERE member_id = '$memberid' ";
          
          $result= $db -> query($sql);
          $attr = $result -> fetch_row();
          if($password != '' && $attr[0]==$password){
               echo "<h2>登入成功!</h2>";
               $_SESSION['memberid'] = $memberid;
               // admin權限
               $_SESSION['level'] = $attr[1] ;
               $_SESSION['depart'] = $attr[2] ;
               // 登入後的會員首頁
               // $url = "home"."/?member_id=".$memberid.".html";
               // echo "<script>location.href='".$_SERVER["HTTP_REFERER"]."';</script>"; 
               header("Refresh:2 ; ../ingrid/home.html?member_id=$memberid");
          }else{
               echo "<h2>登入失敗!</h2>";
               echo "<h2>即將跳轉回去登入頁面</h2> ";
               header("Refresh:2 ; Log_In.html");
          }
     }
     ?>
</body>

</html>