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
?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<?php 

	?>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>會員管理1</title>
	<link rel="stylesheet" href="../css/Manage_Member1_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script type='text/javascript' src='../home.js'></script>

</head>
<?php
}else{
	echo "請先登入!";
	header('Refresh:2;Log_In.html');  
	exit();
}
?>
<body>
	<div class="header">
		<div class="logo" src="">Readcycle</div>
		<div class="search">
			<input class="search-bar" type="text" name="search" id="search" placeholder="搜尋">
			<button class="search-btn"><i class="fas fa-search"></i></button>
		</div>
			<div class="publish">刊登</div>
			<div class="request">徵求</div>
			<div class="notification"><i class="fas fa-bell"></i></div>
			<div class="member"><i class="fas fa-user"></i></div>
			<div class="cart"><i class="fas fa-shopping-cart"></i></div>
	</div>
	<div class="banner">
		<img class="banner" src="/Users/ingrid881010/Downloads/image 7.png">
	</div>
	<div class="left">
		<p>書籍管理<br></p>
		<a href=Manage_Sale1.html>刊登管理</a><br>
		<a href="Manage_Require.html">徵求管理</a><br>
		<a href="Manage_Member1.html">會員管理</a><br>
		<a href="Manage_Order.html">訂單查詢</a><br>
		<br>
		書適圈 Readcycle<br>
		<p>常見問題<br>
		創辦理念<br>
		商業合作<br>
		聯絡我們<br><p>
     </div>

	<!--以上為首頁邊框-->
	<!-- 下面有php -->
	

     <div>
		<p class="membersetting">會員管理</p>
		<p class="uploadwarning"><img src="exclamation_mark.png" width="22">  刊登須知</p>
		<br><br><br>
		<hr style="border: 1px solid#005889;" align="left">
	</div>
	<div class="image">

		<img src="member_image_removebg.png" width="30%" >
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
		<a href="Manage_Member2 copy.php?<?php echo $editstr;?>" class="memberedit">編輯</a> 
		<ins class="membertitle">會員資訊</ins><br><br>
		
		學號：<?php echo $attr['member_id'];?><br>
		科系：<?php echo $attr['depart'];?> <br>
		名字：<?php echo $attr['name'];?><br>
		性別：<?php if($attr['sex']==0){echo "男性";}else{echo "女性";} ?><br>
		信箱：<?php echo $attr['email'];?><br>
		電話：<?php echo $attr['phone_num'];?><br>
		
	</div>