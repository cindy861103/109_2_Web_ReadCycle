<!-- 放單書資料的地方 -->
<?php
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
	<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<title>書本資訊</title>
		<link rel="stylesheet" href="../css/home.css">
		<link rel="stylesheet" type="text/css" href="../css/Book_style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	</head>

<?php
} else {
	$class_arr = get_random_depart($self_depart);
	$self_depart = ''; //本科系是空值
	$bar_depart = $class_arr[0]; //取陣列第一個科系
}
?>

<?php
$function_id = $_GET['function_id'];
$sql = "SELECT *
FROM book_function as bf
INNER JOIN member as m
ON bf.member_id = m.member_id
INNER JOIN book as b
ON bf.ISBN = b.ISBN
WHERE bf.function_id = '$function_id'";
$result = $db->query($sql);
$attr = $result->fetch_assoc();
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

	<!-- Ｋ：接照片的路徑 -->
	<!-- 拿到照片的 $attr['pic1'] $attr['pic2']-->

	<div class="right">
		<div class="upload-container">
			<div class="upload">
				<!-- <div class="image-preview" id="imagePreview"> -->
				<div>
					<img src="../img/<?php echo $attr['pic1']; ?> " alt="Image" class="image-preview">
				</div>
			</div>
		</div>
		<div class="container2">
			<span class="name"><?php echo $attr['book_title']; ?></span>
			<span class="info">作者：<?php echo $attr['author']; ?> </span>
			<span class="info">ISBN碼：<?php echo $attr['ISBN']; ?> </span>
			<span class="info">出版社：<?php echo $attr['publishing_house']; ?> </span>
			<span class="info">出版日期：<?php echo substr($attr['publication_date'], 0, 10); ?> </span>
			<span class="info">版本：<?php echo $attr['version']; ?> </span>
			<span class="info">書本狀況：<?php echo $attr['situation']; ?> </span>
			<span class="info">科系用書：<?php echo $attr['class']; ?> </span>
			<span class="info">刊登者：<?php echo $attr['name']; ?> </span>
			<span class="info">定價：<?php echo $attr['pub_price']; ?> 元</span>
			<!-- 還沒接到購物車 -->
			<!-- <button id="sale-book_last">加入購物車 </button> -->
				<br><a href="Cart.php?member_id=<?php echo $memberid ?>&function_id=<?php echo $attr['function_id']; ?>">加入購物車</a>
			<!-- 不讓他直接購買，一定要先加入購物車才能結帳 -->
				<!-- <a id="sale-book_next" href="Check1.php?member_id=<?php echo $memberid ?>&function_id=<?php echo $attr['function_id']; ?>">直接購買 </a> -->
		</div>

		<div class='note'>
			<p> 備註</p>
		</div>

		<!-- Ｋ：備註文字放下面p-->
		<div class="note_text">
			<p><?php echo $attr['description']; ?></p>
		</div>

	</div>

	<script type='text/javascript' src='./jquery-3.6.0.js'></script>
	<script type='text/javascript' src='./bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
	<script type='text/javascript' src='../home.js'></script>

</body>
</html>