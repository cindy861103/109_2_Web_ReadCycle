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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>購買紀錄</title>
	<link rel="stylesheet" href="css/Manage_Order_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script type='text/javascript' src='../home.js'></script>
</head>

<?php
}else{
	echo "請先登入!";
	header('Refresh:2;Log_In.html');
	exit();

}
	$memberid = $_SESSION['memberid'];
	$sql ="SELECT order_m.member_id,order_d.*,book_function.*,book.book_title FROM `order_d`,order_m,book_function,book
	where order_m.member_id = '$memberid' 
	&& order_d.order_id = order_m.order_id 
	&& order_d.function_id= book_function.function_id
	&& book_function.ISBN = book.ISBN";
	$result= $db -> query($sql);
	$attr = $result -> fetch_assoc();
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
		<p>
		常見問題<br>
		創辦理念<br>
		商業合作<br>
		聯絡我們<br>
		</p>
	</div>

	<!--以上為首頁邊框-->

	<div>
		<p class="uploadsetting">購買紀錄</p>
		<br><br><br><br><br>
		<hr style="border: 1px solid#005889;" align="left">
	</div>

	<?php 
		do{
	?>
<!-- 我現在邏輯是拿訂單明細當主角，不是拿一整份訂單，-->
<!-- todo : 取消訂單php、判斷成交與否 -->
<table class="table1">
<table >
		<tr>
			<td class="bookname" colspan="5">書名: <?php echo $attr['book_title']; ?></td>
			<!-- 不是編輯是取消訂單 -->
			<!-- 寫一個刪除訂單的php -->
		</tr>
		<tr>
			<td class="info">購買時間</td>
			<td align="center">訂單明細編號</td>
			<td align="center">價格</td>
			<td align="center">狀態</td>
			<td align="center">賣家信箱</td>
		</tr>
		<tr>
			<td class="info"><?php echo date("Ymd",strtotime($attr['pub_create_date'])); ?></td>
			<td align="center"><?php echo $attr['function_id']; ?></td>
			<td align="center"><?php echo $attr['pub_price']; ?></td>
			<td align="center">成交</td> <!-- 判斷成交未拿到書or成交拿到書、-->
			<td align="center"><?php echo $attr['situation']; ?></td><!--這邊放賣家信箱-->
			<!-- <td align="center"><?php //echo date("Ymd",strtotime($attr['pub_update_date'])); ?></td> -->
		</tr>
		<?php
			}while($attr = $result -> fetch_assoc());
		?>
	</table>
</body>
</html>