<?php
include("../conn.php");
include("select_array.php");
include("depart_random.php");	
include ("function.php"); //function
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
	<meta name="viewport" content="
	width=divice-width,
	initial-scale=1.0"> 
	<link rel="stylesheet" type="text/css" href="../css/sale_book4_style.css">
	<link rel="stylesheet" href="../css/home.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/cbacd055c2.js" crossorigin="anonymous"></script>
	<title>刊登書籍4</title>
</head>
<?php
}else{
	echo "請先登入!";
	header('Refresh:2; ../html/Log_In.html');   
	exit();
}


if($_SERVER["REQUEST_METHOD"]=="POST"){
	// 如果是1傳去下一步
	$memberid = $_POST['memberid'];
	
	$function_id=$_POST['function_id']; // 會是自創數字
	$book_title = $_POST['book_title']; // 字串
	$ISBN = $_POST['ISBN']; //數字
	$author = $_POST['author']; 
	$publishing_house = $_POST['publishing_house']; 
	$publication_date = $_POST['publication_date']; 
	$version = $_POST['version'];
	$situation = $_POST['situation'];
	$book_depart = $_POST['book_depart'];
	$pub_price = $_POST['pub_price']; //2才有
	$description = $_POST['description']; //2才有
	$pic1 = $_POST['pic1']; //
     $pic2 = $_POST['pic2']; //
	// 寫id 前八碼是今天日期，後三碼是當天刊登的00N本
	

	// 判斷book.isbn是否存在，已存在的話就不用審核了
	if ($ans = checkIsbn($db,$ISBN) ==  FALSE ){
		$sql = "INSERT INTO `book` (`ISBN`, `book_title`, `author`, `version`, `publishing_house`, `publication_date`, `book_update_date`) 
		VALUES ('$ISBN', '$book_title', '$author', '$version', '$publishing_house', current_timestamp(), current_timestamp());";
		$sql2 .= "INSERT INTO `book_function` (`function_id`, `ISBN`, `member_id`, `situation`, `pub_price`, `book_condition`, `class`, `pic1`, `pic2`, `description`, `function`, `pub_create_date`, `pub_update_date`) 
			VALUES ('$function_id', '$ISBN', '$memberid', '$situation', '$pub_price', '未審核', '$book_depart', '$pic1', '$pic2', '$description', '刊登', current_timestamp(), current_timestamp())";

		$result = $db -> query($sql);
		$result = $db -> query($sql2);
	}else{
		$sql = "INSERT INTO `book_function` (`function_id`, `ISBN`, `member_id`, `situation`, `pub_price`, `book_condition`, `class`, `pic1`, `pic2`, `description`, `function`, `pub_create_date`, `pub_update_date`) 
		VALUES ('$function_id', '$ISBN', '$memberid', '$situation', '$pub_price', '已審核', '$book_depart', '$pic1', '$pic2', '$description', '刊登', current_timestamp(), current_timestamp())";
		$result= $db -> query($sql);
	}
}
?>
<body>
	<div class="layer1">
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

		<div class="right">
			<div class='title'>
				<p>刊登書籍</p>
			</div>
			<div class = container>
				<ul class="progressBar">
					<li class="active" id='active'>填寫書籍資料</li>
					<li class="active" id='active'>輸入定價、備註</li>
					<li class="active">確認資料</li>
				</ul>
				
			</div>

			<div class="finish">
				<div class="icon">
					<i class="fas fa-check"></i>
				</div>
				<div class="text">
					<p>已刊登成功</p>
				</div>
				<div class="button">
					<a type='button' href="Sale_Book1.php">刊登下一本</a>
				</div>
			</div>
			<div class="upload-container">
				<div class="upload">
					<div class="image-preview" id="imagePreview">
						<img src="" alt="Image Preview" class="image-preview_image">
						<span class="image-preview__default-text">封面</span>

					</div>
				</div>
				<div class="upload">
					<div class="image-preview" id="imagePreview">
						<img src="" alt="Image Preview" class="image-preview_image">
						<span class="image-preview__default-text">資訊頁</span>
					</div>
				</div>
			</div>
			
				
			<div class="container2">
				<span class="name">書名</span>
				<span class="info">ISBN碼: </span>
				<span class="info">作者: </span>
				<span class="info">出版社: </span>
				<span class="info">出版日期: </span>
				<span class="info">版本: </span>
				<span class="info">書本狀況: </span>
				<span class="info">定價:  </span>
				<span class="info">備註: </span>
			</div>	
		</div>
	</div>

	<?php
	if($result === TRUE){
		echo "<h2>刊登成功</h2>";
		// <!-- 要跳轉的頁面網址 -->
	?>
	<?php 
	}else{
	?>
		<!-- <div class='layer3'>
		<div class='icon'>
			<i class='fas fa-check'></i>
		</div>
		<div class='text'>
			<p class='caption'>刊登失敗</p>
			<p class='subtitle'>將在5秒內跳轉回刊登頁面，方便您重新刊登下一本書</p>
			<script language=javascript> 
				setTimeout('window.location="Sale_Book1.php"',5000)
			</script>
		</div>
		<button type='button'>刊登下一本</button>
	</div>";
		 -->
	<?php
	}
	?>

	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
	
</body>
</html>