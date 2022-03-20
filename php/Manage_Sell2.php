<!-- 刊登管理2: 用session掌握登入
每一本書不同頁：用memberid & book_func_id 去對地方

-->

<?php
    include ("../conn.php");
	session_start(); // session啟動
	ini_set('display_errors', 0); // 錯誤訊息關掉
	if (isset($_SESSION["memberid"])){
		$memberid = $_SESSION['memberid'];
        $level = $_SESSION['level'] ;
	
?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理刊登2</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Manage_Sell2_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<?php
}else{
	echo "請先登入!";
	header('Refresh:2;Log_In.html');   
	exit();
}
// 拿到資料
if($_SERVER["REQUEST_METHOD"]=="GET" ){
    
    $member_id=$_GET['member_id'];
    $function_id=$_GET['function_id'];

    $sql = "SELECT book_function.* ,book.* FROM book_function ,book 
	WHERE member_id = '$memberid' && function = '刊登' && function_id = '$function_id'
	&& book.ISBN = book_function.ISBN";
// 拿重要的ＳＥＬＥＣＴ去定義變數
	$result= $db -> query($sql);
	$attr = $result -> fetch_assoc();
    

}else{
    echo "沒拿到誒";
    $member_id='';
    $function_id=''; 
    $ISBN = '';
    $author = '';
    $publishing_house = '';
    $publication_date = '';
    $version = '';
    $situation = '';
    $pub_price = '';
    $description = '';
    $pic1='';
}
?>
<body>
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
        <!--以上為首頁邊框-->

        <div>
            <p class="uploadsetting">刊登管理</p>
            <br><br><br><br>
            <hr style="border: 1px solid#005889;" align="left">
        </div>

        <div>
            <img src="../img/<?php echo $attr['pic1']; ?> "alt="Image" class="image-preview">
        </div>
        
        <br><br><br><br><br>
        <div class="bookinfo">

            書名 : <?php echo $attr['book_title'];?><br>
            ISBN : <?php echo $attr['ISBN'];?><br>
            作者 : <?php echo $attr['author'];?><br>
            出版社 : <?php echo $attr['publishing_house'];?><br>
            出版日期 : <?php echo $attr['publication_date'];?><br>
            版本 : <?php echo $attr['version'];?><br>
            書本狀況 : <?php echo $attr['situation'];?><br>
            定價 : <?php echo $attr['pub_price'];?><br>
            備註 : <?php echo $attr['description'];?><br>
            狀態 : <?php echo $attr['book_condition'];?><br>
        
        <?php 
        // 是否有人購買之類的
        // 之後記得要串 購買人的資訊 
        $sql2 = "SELECT * FROM order_d,order_m,member
                WHERE function_id =  '$function_id' 
                && order_d.order_id = order_m.order_id
                && member.member_id = order_m.member_id";
        $result2= $db -> query($sql2);
	    $attr2 = $result2 -> fetch_assoc();
        
        if($attr2['order_d_id'] == null){
            echo "<h1>尚無人購買</h1>";
        }else{
            // $sql ;
        ?>
        </div>
        <table class="order" width="800">
            <tr>
                <td>訂單編號</td>
                <td>購買人</td>
                <td>聯絡電話</td>
                <td>Email</td>
            </tr>
            <tr>
            <!-- 購買人 -->
                <td><?php echo $attr2['order_d_id'];?></td> 
                <td><?php echo $attr2['name'];?></td>
                <!-- 電話 -->
                <td>********</td>
                <td><?php echo $attr2['email'];?></td>
            </tr>
            
            <a class="edit" href="Manage_Sell3.php?<?php 
			echo "member_id=".$attr['member_id']."&function_id=".$attr['function_id'];?>">編輯</a>
            <a class="back" type="button" value="返回" href="Manage_Sell1.php"> 返回</a>
        </table>
        <?php 
        }
        ?>

    <script type='text/javascript' src='../jquery-3.6.0.js'></script>
    <script type='text/javascript' src='../home.js'></script>
    <script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>

 
</body>
</html>

