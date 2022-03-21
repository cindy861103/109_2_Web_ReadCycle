<!-- 
先用session 連到個人資料庫
然後把資料填上去(先讓資料浮在格子上)
若沒有連到session 就跑到 login介面

(先讓資料浮在格子上)
內容可以變更
只要按送出就會UPdate資料庫內容
防呆機制：必填的東西、字串、內容等。
-->
<?php
include ("../conn.php");
session_start(); // session啟動
ini_set('display_errors', 0); // 錯誤訊息關掉
if (isset($_SESSION["memberid"])){
    $memberid = $_SESSION['memberid'];
    $level = $_SESSION['level'];
?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員管理1</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Manage_Member2_style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<?php
}else{
    echo "請先登入!";
    header('Refresh:2; ../html/Log_In.html');   
    exit();
}
// if(isset($_GET['member_id'])){
if($_SERVER["REQUEST_METHOD"]=="GET" ){
    $member_id=$_GET['member_id'];
    $depart=$_GET['depart'];
    $name=$_GET['name'];
    $sex=$_GET['sex'];
    $email=$_GET['email'];
    $phone_num=$_GET['phone_num'];
    
}else{
    $member_id='';
    $depart='';
    $name='';
    $sex='';
    $email='';
    $phone_num=''; 
    }

if($_SERVER["REQUEST_METHOD"]=="POST"){
        $member_id=$_POST['member_id'];
        $depart=$_POST['depart'];
        $name=$_POST['name'];
        $sex=$_POST['sex'];
        $email=$_POST['email'];
        $phone_num=$_POST['phone_num']; 
        $pw=$_POST['pw']; 
        
        // 一直無法改到資料庫 因為sql有誤導致，但沒對sql語法防呆所以搞很久
        // 已經可以了
        $sql="UPDATE member SET member_id ='".$member_id."'
                ,depart ='".$depart."'
                ,name ='".$name."'
                ,sex ='".$sex."'
                ,password = '".$pw."'
                ,email = '".$email."' WHERE member_id='$member_id' ";
        
        if ($db -> query($sql) === True){
            
            header("Location: Manage_Member1.php");
            echo "<h2>編輯成功</h2>";
        }else{
            echo "<h2>編輯失敗</h2>";
        }
    }
?>
<body>
    <?php 
		$memberid = $_SESSION['memberid'];
        $sql = "SELECT * FROM member WHERE member_id = '$memberid' ";
        $result= $db -> query($sql);
        $attr = $result -> fetch_assoc();
        
	?>
    <!--以下是上方的header-->
    <form name="search" method="post" action="aftersearch.php">
        <div class="header">
            <div class="logo"><a href="../php/home.php?<?php echo "member_id=" . $memberid . "&depart=" . $depart; ?>">Readcycle</a></div>
            <div class="search">
                <input class="search-bar" type="text" name="search" id="search" placeholder="搜尋">
                <button type="submit" class="search-btn" name="search_confirm"><i class="fas fa-search"></i></button>
            </div>
            <div class="publish"><a href="../php/Sale_Book1.php">刊登</a></div>
            <div class="request"><a href="../php/Request_Book1.php">徵求</a></div>
            <div class="notification">
                <div class="popover__title">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="popover__content">
                    <p class="popover__message">最新通知<br>(現正建置中...)</p>
                </div>
            </div>
            <div class="member">
                <div class="popover__title">
                    <i class="fas fa-user"></i>
                </div>
                <div class="popover__content">
                    <div class="popover__message">
                        <a href="../html/Log_In.html">登入</a><br>
                        <a href="../php/Manage_Sell1.php">刊登管理</a><br>
                        <a href="../php/Manage_Require1.php">徵求管理</a><br>
                        <a href="../php/Manage_Member1.php">會員管理</a><br>
                        <a href="../php/Manage_Order.php">訂單查詢</a>
                        <a href="../php/Log_Out.php">登出</a><br>
                    </div>>
                </div>
            </div>
            <div class="cart"><a href="../php/Cart.php"><i class="fas fa-shopping-cart"></i></a></div>
        </div>
    </form>

    <div class="left">
        <p>書籍管理<br></p>
        <a href="Manage_Sell1.php">刊登管理</a><br>
        <a href="Manage_Require1.php">徵求管理</a><br>
        <a href="Manage_Member1.php">會員管理</a><br>
        <a href="Manage_Order.php">購買紀錄</a><br>
        <?php if($level == 0){
        ?>
        <a href="Manage_Backstage1.php">後臺審核</a><br>
        <a href="Membership.php">會籍資料</a><br>
        <?php
        }
        ?>
        <br><br>
        <div class="information">
            <p>書適圈 Readcycle</p>
            <a href="../php/information.php#AboutUs">創辦理念</a><br>
            <a href="../php/information.php#FAQ">常見問題</a><br>
            <a href="../php/information.php#Contact">聯絡我們</a><br>
            <a href="../php/information.php#Cooperation">商業合作</a>
        </div>
        <br>
        <img src="../index_img/Readcycle_logo.png">
     </div>

    <div>
        <p class="membersetting">會員管理</p>
        <br><br><br><br>
        <hr style="border: 1px solid#005889;" align="left">
    </div>

    <div class="image">
        <img src="../index_img/member_image_removebg.png" width="60%" >
    </div>

    <div class="memberentry">
        <form method="post" action="Manage_Member2.php">
            <p><input name="member_id" type="text"  class="text_field" placeholder= "輸入學號" value="<?php echo $member_id;?>" /></p>
            <p><select name="depart" id="" class="select_field"  >
            <optgroup label="選擇科系">
                <!-- 之後這邊用php生成科系好像比較快 -->
                <?php 
                    // $departls = array()
                ?>
                <option value="<?php echo $depart;?>"><?php echo $depart;?></option>
                <option value="中文系">中文系</option>
                <option value="歷史系">歷史系</option>
                <option value="哲學系">哲學系</option>
                <option value="政治系">政治系</option>
                <option value="社會系">社會系</option>
                <option value="社工系">社工系</option>
                <option value="音樂系">音樂系</option>
                <option value="英文系">英文系</option>
                <option value="日文系">日文系</option>
                <option value="德文系">德文系</option>
                <option value="法律系">法律系</option>
                <option value="巨資系">巨資系</option>
                <option value="數學系">數學系</option>
                <option value="物理系">物理系</option>
                <option value="化學系">化學系</option>
                <option value="微物系">微物系</option>
                <option value="心理系">心理系</option>
                <option value="經濟系">經濟系</option>
                <option value="會計系">會計系</option>
                <option value="企管系">企管系</option>
                <option value="國貿系">國貿系</option>
                <option value="財精系">財精系</option>
                <option value="資管系">資管系</option>
            </select></p>
            <p><input type="text" name="name" class="text_field" placeholder="輸入姓名" value="<?php echo $name;?>"/></p>
            <p><select name="sex" id="" class="select_field">
                <optgroup label="選擇性別">
                <option value="0" <?php echo ($sex==0)?"selected":""; ?> >男性</option>
                <option value="1" <?php echo ($sex==1)?"selected":""; ?> >女性</option>
            </select></p>
            <p><input type="text" name="email" class="text_field" placeholder="輸入常用信箱" value="<?php echo $attr['email'];?>" /></p>
            <p><input type="text" name="phone_num" class="text_field" placeholder="輸入手機號碼" value="<?php echo $attr['phone_num'];?>"/></p>
            <p><input type="password" name="pw" class="text_field" placeholder="密碼" value="<?php echo $attr['password'];?>" /></p>
            
    </div>
    <div>
        
        <button type="submit" class="confirm" href="Manage_Member2.php">確認修改</button>
        <!-- 按鍵位置跑掉了 -->
        <a type="button" class="back" value="返回" href="Manage_Member1.php"> 返回</a>
        
    </div>
    </form>

    <script type='text/javascript' src='../jquery-3.6.0.js'></script></script>
    <script type='text/javascript' src='../home.js'></script>
    <script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>

</body>
</html>

