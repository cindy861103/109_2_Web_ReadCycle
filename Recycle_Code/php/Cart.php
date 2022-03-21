<?php
include("../conn.php");
include("select_array.php");
include("depart_random.php");
include("cart_order_func.php");

session_start(); // session啟動
ini_set('display_errors', 0); // 錯誤訊息關掉
if (isset($_SESSION["memberid"])) {
	$memberid = $_SESSION['memberid'];
	// $memberid = '05153255'; //test-->delete【測試用，要刪除】
	$level = $_SESSION['level'];
	$depart = $_SESSION['depart'];
	// $depart = '企管系'; //test-->delete【測試用，要刪除】


	$class_arr = get_random_depart($depart);
	if (!empty($depart)) {
		$self_depart = $depart;
		$bar_depart = $depart;
	} else {
		$self_depart = ''; //本科系
		$bar_depart = $class_arr[0]; //取陣列第一個科系
	}
	$cart_id = 'C' . $memberid;
	// $function_id = '20210523007'; //test-->delete【測試用，要刪除】
	if (isset($_GET['function_id'])) {
		$function_id = $_GET['function_id'];
		// $memberid = $_GET['member_id'];  //用Session取值

		//先判斷該刊登是否已加入購物車
		if (check_fid_in_cart($function_id, $cart_id) == 0) {
			$cart_d_id = get_items_num($cart_id); //取得目前正要加入購物車商品的購物車明細編號
			//加入購物車明細表--->db
			$sql_select = "SELECT bf.* FROM book_function bf WHERE function_id='$function_id'";
			$res = $db->query($sql_select);
			$attr = $res->fetch_assoc();
			$pub_price = $attr['pub_price'];

			$sql_insert = "INSERT INTO `cart_d` (`cart_d_id`, `cart_id`, `function_id`, `cart_quantity`, `cart_price`, `cart_condition`, `cart_date`) VALUES ('$cart_d_id', '$cart_id', '$function_id', 1, $pub_price , '未結帳', current_timestamp())";
			$result = $db->query($sql_insert);
		} else {
			//若已經刊登過就回上一頁
			// echo "<script>history.go(-1)</script>";
		}
	}

	// // 檢查是否有接收到按鈕的選項
	// if (isset($_POST["cart-plus_confirm"])) {
	// 	$sql = "INSERT INTO `cart_d` (`cart_d_id`, `cart_id`, `function_id`, `cart_quantity`, `cart_price`, `cart_condition`, `cart_date`) 
	// 	VALUES ('$cart_d_id', '$cart_id', '$author', '$version', '$publishing_house', current_timestamp(), current_timestamp());";
	// }
?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="UTF-8">
		<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=utf-8'>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		<title>購物車</title>
		<link rel="stylesheet" href="../css/Cart.css">

		<link rel="stylesheet" href="../css/home.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	</head>

<?php
} else {
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
					<p class="popover__message">最新通知</p>
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
			<div class="cart"><a href="../php/Cart.php?member_id=<?php echo $memberid; ?>"><i class="fas fa-shopping-cart"></i></a></div>
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
		<img src="../index_img/Readcycle_logo.png">
	</div>

	<!--以下是購物車內容-->
	<div class="right">
		<div class='title'>
			<p>購物車</p>
		</div>
		<!-- 進度條 -->
		<div class="container">
			<ul class="progressBar">
				<li class="active">選擇結帳項目</li>
				<li>確認進行結帳的項目</li>
				<li>確認個人資料的填寫</li>
				<li>訂單成立</li>
			</ul>
		</div>
		<!-- 迴圈印出購物車細項 -->
		<?php
		// $sql_all_item = "SELECT * FROM cart_d as cd
		// 	INNER JOIN cart as c
		// 	ON cd.cart_id = c.cart_id
		// 	INNER JOIN member as m
		// 	ON c.member_id = m.member_id
		// 	INNER JOIN book_function as bf
		// 	ON cd.function_id = bf.function_id
		// 	INNER JOIN book as b
		// 	ON bf.ISBN = b.ISBN
		// 	WHERE cd.cart_id = '$cart_id' && cd.cart_condition='未結帳'
		// 	ORDER BY cd.cart_date DESC";

		$sql_all_item = "SELECT * from cart_d as cd
		JOIN book_function as bf ON bf.function_id = cd.function_id
		JOIN book as b ON bf.ISBN = b.ISBN
		JOIN member as m ON bf.member_id = m.member_id
		WHERE cd.cart_id = '$cart_id' && cd.cart_condition='未結帳'";
		$arr = get_table_array($sql_all_item);
		?>
		<form name="cart_detail" method="POST" action="Check1.php">
			<?php foreach ($arr as $key => $value) { ?>
				<table>
					<tr>
						<td rowspan="3">
							<?php echo "<input type='checkbox' name='cart[]' value=" . $value['cart_d_id'] . ">"; ?>
						</td>
						<td rowspan="3" id="img_td">
							<div>
							<!-- <div class="img_container"> -->
								<img src="../img/<?php echo $value['pic1']; ?>" alt="Image Preview" class="img_container">
							</div>
						</td>
						<td class="book_info_cart" id="book_title"><?php echo $value['book_title']; ?></td>
						<td rowspan="3">$<?php echo $value['pub_price']; ?></td>
					</tr>
					<tr>
						<td class="book_info_cart" id="book_status">書本狀況：<?php echo $value['situation']; ?></td>
					</tr>
					<tr>
						<td class="book_info_cart" id="book_uploader">刊登者：<?php echo $value['name']; ?></td>
					</tr>
				</table>
			<?php } ?>
			<!-- <div class="button" id="sale-book_next"> -->
			<div >
				<span><input id="sale-book_next" name='go_check1' value="下一步" type="submit"></span>
			</div>
		</form>
		<!-- <button id="sale-book_next">
			下一步
		</button> -->
	</div>

	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
</body>

	</html>