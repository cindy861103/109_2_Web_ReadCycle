<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<title>註冊</title>
<link rel="stylesheet" type="text/css" href="../css/Register_style.css"/>
</head>
<body>
     <!-- Ｋ：還是要改id（另種框架） -->
     <div id="signup_frame">
          <!-- <p id="text_logo">註冊</p> Ｋ：可以拿掉之類的（反正設計而已）-->
          <?php
               // 出現拿不到
               ini_set('display_errors', 0);
               // 必填驗證
               // $memberid = $pwd = "";
               // 測試是否有拿到
               // 並接收使用者輸入
               if($_SERVER["REQUEST_METHOD"]=="POST"){
                    // K:學號八碼都只能是1~9(如果資料庫是varchar就可以用字元數判斷)
                    if(empty($_POST["userid"])){
                         echo '請輸入學號<br>';
                    }else{
                         $memberid = $_POST['userid'];
                    }
                    // 科系不能是val "0" 
                    if(empty($_POST["depart"]) or $_POST["depart"]=="0"){
                         echo "請選擇你的科系<br>";
                    }else{
                         $depart = $_POST['depart'];
                    }
                    // 名字...暫時沒想到不能怎樣
                    if (empty($_POST["username"])){
                         echo "請輸入你的名字<br>";
                    }else{
                         $name = $_POST['username'];
                    }
                    // 性別不能是val 0
                    if (empty($_POST["sex"])or $_POST["sex"]==0){
                         echo '請選擇你的性別<br>';
                    }else{
                         $sex = $_POST['sex'];
                    }
                    // 信箱語法 必須是～@~.~
                    if (empty($_POST["email"])){
                         echo "請輸入你的信箱<br>";
                    }elseif(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == False){
                         echo "請輸入正確信箱<br>";
                    }
                    else{
                         $email= $_POST['email'];
                    }
                    // 電話
                    if (empty($_POST["phone_num"])){
                         echo "請輸入你的聯絡號碼<br>";
                    }else{
                         $phone_num= $_POST['phone_num'];
                    }
                    // 密碼要與確認密碼相符 
                    if (empty($_POST["pwd"])){
                         echo "請輸入密碼<br>";
                    }elseif($_POST["pwd"]==$_POST["check"]){
                         $password= $_POST['pwd'];
                    }else{
                         echo "確認密碼不符<br>";
                    }
               }
          ?>

          <?php
          /*連線資料庫 但之後可能可以conn.php*/
          include ("conn.php");
               

          /*變數放進SQL*/
               // 前面的驗證都沒錯之後，才可丟進註冊步驟 
               if($memberid == null || $password == null || $depart == null || $name == null || $sex == null || $email == null || $phone_num == null){
                    echo "<h2>註冊失敗</h2>";
                    echo "<h2>即將跳轉回去註冊頁面</h2>";
                    echo '<meta http-equiv=REFRESH CONTENT=10;url=../html/Register.html>';
               }else{
                    $sql = "SELECT * FROM member where member_id = '$memberid'";
                    $result= $db -> query($sql);
                    $attr = $result -> fetch_assoc();
                    // 考慮有無存在
                    echo "wqqq:".$memberid;
                    if($attr['member_id'] != $memberid){
                         $sql = "INSERT INTO member(member_id,depart,name,sex,email,phone_num,password) 
                         VALUES('$memberid','$depart','$name','$sex','$email','$phone_num','$password')";
                         
                         if ($db -> query($sql) === True){
                              // 成功新增後先跑出訊息、三秒後跳轉登入頁面
                              
                              echo "<h2>註冊成功</h2>";
                              echo "<h2>2秒後...即將跳回首頁</h2>";
                              header("Refresh:10 ; Log_In.html"); 
                         }
                    }else{     
                         echo "<h2>已經有人註冊過了</h2>";
                         echo '<meta http-equiv=REFRESH CONTENT=10;url=../html/Register.html>';
                    }
               }
          ?>
     </div>
</body>
</html>