<?php
	include ("../conn.php");
	session_start(); // session啟動
	ini_set('display_errors', 0); // 錯誤訊息關掉
	if (isset($_SESSION["memberid"] ) ){
		$memberid = $_SESSION['memberid'];
		$level = $_SESSION['level'] ;
		
?>
<!DOCTYPE html>
<html lang="zh-tw">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>後臺審核-待審核</title>
		<link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="../css/Manage_Backstage1_style.css">
	    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    </head>
    <?php
}else{
	echo "請先登入!";
	header('Refresh:2; ../html/Log_In.html');   
	exit();
}
	$sql ="SELECT * FROM book_function,book,member
	where book_function.book_condition='未審核'
	&& book_function.member_id = member.member_id
	&& book_function.ISBN = book.ISBN";
	$result= $db -> query($sql);
	$attr = $result -> fetch_assoc();

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
		<p>書籍管理</p>
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
		<p class="tab">
			<a href="../php/Manage_Backstage1.php">待審核 &nbsp; &nbsp; &nbsp;</a>
			<a href="../php/Manage_Backstage2.php">審核通過 &nbsp; &nbsp; &nbsp;</a>
			<a href="../php/Manage_Backstage3.php">審核未通過</a>
		</p>
	</div>
	<br><br><br><br>
	<hr style="border: 1px solid#005889;" align="left">
	<?php if($attr['book_title']){
		do{
	?>
	<div class="tablen">
		<table class="table1">
			<tr>
			<td class="bookname" colspan="5"><?php echo $attr['book_title']; ?></td>
				<td class="pass_btn">
					<button class="pass_btn" >通過</button>
					<button class="fail_btn" >未通過</button>
				</td>
			</tr>
			<tr>
			<td class="info">建立時間</td>
				<td class="info">刊登編號</td>
				<td class="info">定價</td>
				<td class="info">狀態</td>
				<td class="info">書況</td>
				<td class="info">最後編輯時間</td>
			</tr>
			<tr>
				<td class="info"><?php echo date("Ymd",strtotime($attr['pub_create_date'])); ?></td>
				<td class="info"><?php echo $attr['function_id']; ?></td>
				<td class="info"><?php echo $attr['pub_price']; ?></td>
				<td class="info"><?php echo $attr['book_condition']; ?></td>
				<td class="info"><?php echo $attr['situation']; ?></td>
				<td class="info"><?php echo date("Ymd",strtotime($attr['pub_update_date'])); ?></td>
			</tr>
		</table>
		<?php
			}while($attr = $result -> fetch_assoc());
		}else { ?>
			<!-- 若沒有買過的話！ -->
			<h1>尚未有新資料，無需審核呦！～ </h1>
		<?php 
		}
		?>
	</div>

    <script type='text/javascript' src='./jquery-3.6.0.js'></script>
    <script type='text/javascript' src='./bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='../home.js'></script>

</body>
</html>