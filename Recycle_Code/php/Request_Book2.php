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
<html>
<head>
	<meta charset="UTF-8"> 
	<meta name="viewport" content="width=divice-width,initial-scale=1.0"> 
	<link rel="stylesheet" type="text/css" href="../css/request_book2_style.css">
	<link rel="stylesheet" href="../css/home.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">		
	<title>徵求書籍2</title>
</head>
<?php
}else{
	echo "請先登入!";
	header('Refresh:2;../html/Log_In.html');  
	exit();
}
// 1傳進來
if($_SERVER["REQUEST_METHOD"]=="POST" ){
	$memberid = $_SESSION['memberid'];
	// 如果是2的上一步回車
	// $function_id=$_GET['function_id']; // 會是自創數字

	$book_title = $_POST['book_title']; // 字串
	$ISBN = $_POST['ISBN']; //數字
	$author = $_POST['author']; 
	$publishing_house = $_POST['publishing_house']; 
	$publication_date = $_POST['publication_date']; 
	$version = $_POST['version'];
	$situation = $_POST['situation'];
}

//3傳回來是post
if($_SERVER["REQUEST_METHOD"]=="GET" ){
	$book_title = $ISBN = $author =$publishing_house = $publication_date =$version = $situation =""; // 字串
	
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
			<p>徵求書籍</p>
		</div>
		<div class = container>
			<ul class="progressBar">
				<li class="active" id='active'>填寫書籍資料</li>
				<li class="active">確認資料</li>
				<li>徵求釋出</li>
			</ul>
		</div>
		<div  class="upload-container">
			<div class="upload">
			<div >
				<!-- <img src="../index_img/magazine-book_OBGUXZX9T8.jpg" alt="book" class="image-preview_image"> -->
				<img src="../index_img/magazine-book_OBGUXZX9T8.jpg" alt="book" class="image-preview" id="imagePreview">
			</div>
		</div>
		<div class="container2">
		<form id='form2' name='form2' method="post" action="Request_Book3.php" > 
			<span class="name"><?php echo $book_title;?></span>
			<span class="info">ISBN碼: <?php echo $ISBN;?></span>
			<span class="info">作者: <?php echo $author;?></span>
			<span class="info">出版社: <?php echo $publishing_house;?></span>
			<span class="info">出版日期: <?php echo $publication_date;?></span>
			<span class="info">版本: <?php echo $version;?></span>
			<span class="info">書本狀況: <?php echo $situation;?></span>
			<!-- 隱藏傳值 為了傳回去1有東西-->
			<input class="input" name="book_title" type="hidden" value="<?php echo $book_title; ?>">
			<input class="input" name="ISBN" type="hidden" value="<?php echo $ISBN; ?>">
			<input class="input" name="author" type="hidden" value="<?php echo $author; ?>">
			<input class="input" name="publishing_house" type="hidden" value="<?php echo $publishing_house; ?>">
			<input class="input" name="publication_date" type="hidden" value="<?php echo $publication_date; ?>">
			<input class="input" name="version" type="hidden" value="<?php echo $version; ?>">
			<input class="input" name="situation" type="hidden" value="<?php echo $situation; ?>">
			<div >
			<span id="sale-book_last"><input id="up1" name="up1" value="上一步" type="botton" class="button2"></span>
			</div>
			<div >
			<span id="sale-book_next"><input id="go3" name="go3" value="確認徵求" type="botton" class = "button1" ></span>
			</div>
		</form>
		</div>
		<script type="text/javascript">
			let form2=document.getElementById('form2')
			document.getElementById('up1').onclick=e=>{
				form2.action='Request_Book1.php'
				form2.submit()
			}
			document.getElementById('go3').onclick=e=>{
				form2.action='Request_Book3.php'
				form2.submit()
			}

		</script>
	</div>

	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>

</body>
</html>