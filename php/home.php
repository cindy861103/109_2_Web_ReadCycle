<?php
//include other php files
include("../conn.php");
include("select_array.php");
include("depart_random.php");

session_start(); // session啟動
ini_set('display_errors', 0); // 錯誤訊息關掉
if (isset($_SESSION["memberid"])) {
	$memberid = $_SESSION['memberid'];
	$level = $_SESSION['level'];
	$depart = $_SESSION['depart'];
	// $depart = ''; //test-->delete【測試用，要刪除】

	$class_arr = get_random_depart($depart);
	if (!empty($depart)) {
		$self_depart = $depart;
		$bar_depart = $depart;
	} else {
		$self_depart = ''; //本科系
		$bar_depart = $class_arr[0]; //取陣列第一個科系
	}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=utf-8'>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Readcycle首頁</title>
	<link rel="stylesheet" href="../css/home.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
</head>

<?php
} else {
	$class_arr = get_random_depart($self_depart);
	$self_depart = ''; //本科系是空值
	$bar_depart = $class_arr[0]; //取陣列第一個科系
}
?>
<!-- // Ｋ待辦 -->

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

	<ul class="banner">
		<li><a href="https://rebeccareadsbooks.com/2016/10/30/book-exchange-project/"><img src="../index_img/banner1.jpeg" alt="" /></a></li>
		<li><a href="https://www.tridentbookscafe.com/event/september-book-swap"><img src="../index_img/banner2.jpeg" alt="" /></a></li>
		<li><a href="https://singledoggy.investments/2020/09/"><img src="../index_img/banner3.jpeg" alt="" /></a></li>
	</ul>

	<!--以下是左側sidebar-->
	<div class="left">
		<p><b>本科系</b><br></p>
		<a href="home.php?<?php echo "member_id=" . $memberid . "&depart=" . $depart; ?>"><?php echo $self_depart; ?><br></a>
		<p><b>其他科系</b><br></p>
		<div class="department">
			<?php
			foreach ($class_arr as $value) {
				echo "<a href=home.php?member_id=" . $memberid . "&depart=" . $value . ">" . $value . "<br></a>";
			}
			?>
		</div>
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

	<div class="right">
		<!--以下是首頁內容-->
		<div class="tab">
			<button class="tablinks" onmouseover="openCity(event, 'latest')" id="defaultOpen"><b>最新刊登</b></button>
			<button class="tablinks" onmouseover="openCity(event, 'class')"><b><?php echo $_GET['depart'] //echo $bar_depart ?>用書</b></button>
		</div>

		<!-- 輸出【本平臺】最新刊登的資料(迴圈) -->
		<?php
		// 查詢頁面上刊登的資料
		/*
		刊登編號:function_id /bf
		ISBN: ISBN /bf /b
		書的封面圖:pic1 /bf
		書名:book_title /b
		作者:author /b
		書本狀況:situation /bf
		定價:pub_price /bf
		刊登建立時間:pub_create_date  /bf */
		// $sql = "SELECT bf.function_id, bf.ISBN, bf.class, bf.pic1, bf.situation, b.book_title, b.author, bf.pub_price, bf.pub_create_date FROM book b,book_function bf where bf.ISBN = b.ISBN ORDER BY bf.pub_create_date DESC";
		$sql = "SELECT * FROM book b,book_function bf where bf.function = '刊登' && bf.book_condition = '已審核未成交' && bf.ISBN = b.ISBN ORDER BY bf.pub_create_date DESC";
		$arr = get_table_array($sql);
		?>

		<form name="latest_book" method="post" action="Cart.php">
			<div id="latest" class="tabcontent">
				<?php if (!empty($arr)) { ?>
					<?php for ($i = 0; $i < 9; $i = $i + 3) { ?>
						<div class="table">
							<div class="table-row">
								<?php for ($j = $i; $j < $i + 3; $j++) { ?>
									<!--取1~3筆--->
									<!--取4~6筆--->
									<!--取7~9筆--->
									<div class="table-cell">
										<div class="book">
											<img src="../img/<?php echo $arr[$j]['pic1']; ?>" width='100' height='200' alt="刊登不足...">
										</div>
										<div class="book_info">
											<!--書名--->
											<div class="book_title"><a href="Book.php?function_id=<?php echo $arr[$j]['function_id'] ?>"><?php echo $arr[$j]['book_title']; ?></a>
											</div>
											<!--書況--->
											<div class="book_condition"><?php echo "書況：" . $arr[$j]['situation']; ?></div>
											<!--價錢--->
											<div class="book_price"><?php echo "價格：" . $arr[$j]['pub_price'] . "元" ?></div>
											<button><a href="Cart.php?member_id=<?php echo $memberid ?>&function_id=<?php echo $arr[$j]['function_id']; ?>">加入購物車</a></button>
											<!-- <button type="submit" class="cart-plus-btn" name="cart-plus_confirm"><i class="fas fa-cart-plus"></i></button> -->
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				<?php } else {
					echo "<br><h2>目前尚無刊登中的書籍，<br>可於上方進行刊登或徵求，<br>抑或是耐心等候他人的刊登書籍。</h2>";
				} ?>
			</div>
		</form>


		<!-- 輸出僅有【本科系】最新刊登的資料(迴圈) -->
		<?php
		// 查詢頁面上刊登的資料
		$depart = $_GET['depart'];
		// $sql = "SELECT bf.function_id, bf.ISBN, bf.class, bf.pic1, bf.situation, b.book_title, b.author, bf.pub_price, bf.pub_create_date FROM book b,book_function bf where bf.ISBN = b.ISBN && class = '$depart' ORDER BY bf.pub_create_date DESC";
		$sql = "SELECT * FROM book b,book_function bf where bf.function = '刊登' && bf.book_condition = '已審核未成交' && class = '$depart' && bf.ISBN = b.ISBN ORDER BY bf.pub_create_date DESC";
		$arr = get_table_array($sql);
		?>
		<form name="class_book" method="post" action="Cart.php">
			<div id="class" class="tabcontent">
				<?php if (!empty($arr)) { ?>
					<?php for ($i = 0; $i < 9; $i = $i + 3) { ?>
						<div class="table">
							<div class="table-row">
								<?php for ($j = $i; $j < $i + 3; $j++) { ?>
									<!--取1~3筆--->
									<!--取4~6筆--->
									<!--取7~9筆--->
									<div class="table-cell">
										<div class="book">
											<img src="../img/<?php echo $arr[$j]['pic1']; ?>" width='100' height='200' alt="刊登不足...">
										</div>
										<div class="book_info">
											<!--書名--->
											<div class="book_title"><a href="Book.php?function_id=<?php echo $arr[$j]['function_id'] ?>"><?php echo $arr[$j]['book_title']; ?></a>
											</div>
											<!--書況--->
											<div class="book_condition"><?php echo "書況：" . $arr[$j]['situation']; ?></div>
											<!--價錢--->
											<div class="book_price"><?php echo "價格：" . $arr[$j]['pub_price'] . "元" ?></div>
											<button><a href="Cart.php?member_id=<?php echo $memberid ?>&function_id=<?php echo $arr[$j]['function_id']; ?>">加入購物車</a></button>
											<!-- <button type="submit" class="cart-plus-btn" name="cart-plus_confirm"><i class="fas fa-cart-plus"></i></button> -->
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				<?php } else {
					echo "<br><h2>目前此科系尚無刊登中的書籍，<br>可於左側選取其他科系的刊登書籍。</h2>";
				} ?>
			</div>
		</form>
	</div>

	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>

</body>
</html>