<!-- 
感覺要進入這個頁面時就要先確定是否有登入，沒有就跳轉登入介面
// include_once("loginornot.php");

先用session 連到個人資料庫
然後把資料填上去
若沒有連到session 就跑到 login介面

編輯紐點下去跑到2

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
	<link rel="stylesheet" href="../css/Manage_Member1_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<?php
}else{
	echo "請先登入!";
	header('Refresh:2; ../html/Log_In.html');  
	exit();
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
	<!-- 下面有php -->
	

    <div>
		<p class="membersetting">會員管理</p>
		<br><br><br><br>
		<hr style="border: 1px solid#005889;" align="left">
	</div>
	<div class="image">
		<img src="../index_img/member_image_removebg.png" width="60%">
	</div>
	<?php 
		$memberid = $_SESSION['memberid'];
		$sql = "SELECT * FROM member WHERE member_id = '$memberid' ";
		$result= $db -> query($sql);
		$attr = $result -> fetch_assoc();
		
		
		$editstr="member_id=".$attr['member_id'].
		"&depart=".$attr['depart'].
		"&name=".$attr['name'].
		"&sex=".$attr['sex'].
		"&email=".$attr['email'].
		"&phone_num=".$attr['phone_num']; 
		?>
	<div class="memberinfo">
		<!-- 連接處 -->
		<!-- <a href="Manage_Member2.html" class="memberedit">編輯</a>  -->
		<!-- 這邊一定要記得回來改！！！因為沒有hide 變數$editstr 密碼都被看到了 -->
		<a href="Manage_Member2.php?<?php echo $editstr;?>" class="memberedit">編輯</a> 
		<ins class="membertitle">會員資訊</ins><br><br>
		
		學號：<?php echo $attr['member_id'];?><br>
		科系：<?php echo $attr['depart'];?> <br>
		名字：<?php echo $attr['name'];?><br>
		性別：<?php if($attr['sex']==0){echo "男性";}else{echo "女性";} ?><br>
		信箱：<?php echo $attr['email'];?><br>
		電話：<?php echo $attr['phone_num'];?><br>
		
	</div>

	<script type='text/javascript' src='../jquery-3.6.0.js'></script></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>

</body>
</html>