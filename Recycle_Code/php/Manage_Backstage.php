<?php
include("../conn.php");
session_start(); // session啟動
ini_set('display_errors', 0); // 錯誤訊息關掉
if (isset($_SESSION["memberid"]) && $_SESSION['level'] == "0") {
	$memberid = $_SESSION['memberid'];
	$level = $_SESSION['level'];

?>
	<!--/Applications/XAMPP/xamppfiles/htdocs/07153104/109_2_web_book_match/css/Manage_Backstage_style.css-->
	<!DOCTYPE html>
	<html lang="zh-tw">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<title>後臺審核</title>
		<link rel="stylesheet" href="../css/home.css">
		<link rel="stylesheet" href="../css/Manage_Backstage_style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	</head>

<?php
} else {
	echo "非法入侵!請使用Admin帳號";
	header('Refresh:2;../html/Log_In.html');
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
	
	<!--以下是左側sidebar-->
	<div class="left">
		<p>書籍管理</p>
		<a href="Manage_Sell1.php">刊登管理</a><br>
		<a href="Manage_Require1.php">徵求管理</a><br>
		<a href="Manage_Member1.php">會員管理</a><br>
		<a href="Manage_Order.php">購買紀錄</a><br>
		<?php if ($level == 0) {
		?>
			<a href="Manage_Backstage.php">後臺審核</a><br>
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

	<div class="tab">
		<button class="tablinks" onmouseover="openCity(event, 'ing')">待審核</button>
		<button class="tablinks" onmouseover="openCity(event, 'pass')">審核通過</button>
		<button class="tablinks" onmouseover="openCity(event, 'fail')" id="defaultOpen">審核未通過</button>
		<br><br>
		<hr style="border: 1px solid#005889;" align="left" noshade>
	</div>

	<!-- 審核失敗 -->

	<div id="fail" class="tabcontent">
		<?php
		$sql = "SELECT book_function.* ,book.book_title FROM book_function ,book 
			WHERE member_id = '$memberid' && book_condition = '審核失敗' 
			&& book.ISBN = book_function.ISBN";

		$result = $db->query($sql);
		$attr = $result->fetch_assoc();
		do {
		?>
			<table class="table1">
				<tr>
					<td class="bookname" colspan="6">我是審核失敗的書籍......</td>
				</tr>
				<tr>
					<td class="info">建立時間</td>
					<td align="center">刊登編號</td>
					<td align="center">定價</td>
					<td align="center">狀態</td>
					<td align="center">書況</td>
					<td align="center">最後編輯時間</td>
				</tr>
				<tr>
					<td class="info">20210428</td>
					<td align="center">20210401001</td>
					<td align="center">200</td>
					<td align="center">未售出</td>
					<td align="center">良好</td>
					<td align="center">20210428</td>
				</tr>
			</table>
		<?php
		} while ($attr = $result->fetch_assoc());
		?>
	</div>
	<!-- 審核通過 -->
	<div id="pass" class="tabcontent">
		<?php
		$sql = "SELECT book_function.* ,book.book_title FROM book_function ,book 
			WHERE (book_condition = '未售出' || book_condition = '已售出')
			&& book.ISBN = book_function.ISBN";

		$result = $db->query($sql);
		$attr = $result->fetch_assoc();

		do {
		?>
			<table class="table1">

				<tr>
					<td class="bookname" colspan="6">我是審核通過的書籍!!!</td>
				</tr>
				<tr>
					<td class="info">建立時間</td>
					<td align="center">刊登編號</td>
					<td align="center">定價</td>
					<td align="center">狀態</td>
					<td align="center">書況</td>
					<td align="center">最後編輯時間</td>
				</tr>
				<tr>
					<td class="info">20210428</td>
					<td align="center">20210401001</td>
					<td align="center">200</td>
					<td align="center">未售出</td>
					<td align="center">良好</td>
					<td align="center">20210428</td>
				</tr>
			</table>
		<?php
		} while ($attr = $result->fetch_assoc());
		?>
	</div>

	<!-- 審核中 -->
	<!-- 現在會沒有往下排疊 -->
	<!-- <div id="ing" class="tabcontent"> -->

	<?php
	//要拿的資料庫東西 （未審核）
	// book 的所有東西
	$sql = "SELECT book_function.* ,book.book_title FROM book_function ,book 
		WHERE book_condition = '未審核' 
		&& book.ISBN = book_function.ISBN";
	$result = $db->query($sql);
	$attr = $result->fetch_assoc();
	$i = 0;
	do {
		$i++;
		echo $i;
	?>
		<div id="ing" class="tabcontent">
			<div>
				<table class="table1">
					<tr>
						<td class="bookname" colspan="5">我是正在審核中的書籍啦!</td>
						<td class="pass_btn">
							<button class="pass_btn">通過</button><br>
							<button class="fail_btn">未通過</button>
						</td>
					</tr>
					<tr>
						<td class="info">建立時間</td>
						<td align="center">刊登編號</td>
						<td align="center">定價</td>
						<td align="center">狀態</td>
						<td align="center">書況</td>
						<td align="center">最後編輯時間</td>
					</tr>
					<tr>
						<td class="info"><?php echo date("Ymd", strtotime($attr['pub_create_date'])); ?></td>
						<td align="center"><?php echo $attr['function_id']; ?></td>
						<td align="center"><?php echo $attr['pub_price']; ?></td>
						<td align="center"><?php echo $attr['book_condition']; ?></td>
						<td align="center"><?php echo $attr['situation']; ?></td>
						<td align="center"><?php echo date("Ymd", strtotime($attr['pub_update_date'])); ?></td>
					</tr>
				</table>
			</div>
		<?php
	} while ($attr = $result->fetch_assoc());
		?>

	<script type='text/javascript' src='./jquery-3.6.0.js'></script>
	<script type='text/javascript' src='./bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
	<script type='text/javascript' src='../home.js'></script>

</body>
</html>