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
	<meta name="viewport" content="
	width=divice-width,
	initial-scale=1.0"> 
	<link rel="stylesheet" type="text/css" href="../css/request_book1_style.css">
	<link rel="stylesheet" href="../css/home.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">	
	<title>徵求書籍1</title>
</head>
<?php
}else{
	echo "請先登入!";
	header('Refresh:2;../html/Log_In.html');  
	exit();
}
// 剛進來1
if($_SERVER["REQUEST_METHOD"]=="GET"){
	$book_title = $ISBN = $author =$publishing_house = $publication_date =$version = $situation =""; // 字串
	
}
// 2傳回來
if($_SERVER["REQUEST_METHOD"]=="POST"){

	// 如果是1傳去下一步
	// 要拿到form值 ＆_POS
	
	// $function_id=$_POST['function_id']; // 會是自創數字
	$book_title = $_POST['book_title']; // 字串
	$ISBN = $_POST['ISBN']; //數字
	$author = $_POST['author']; 
	$publishing_house = $_POST['publishing_house']; 
	$publication_date = $_POST['publication_date']; 
	$version = $_POST['version'];
	$situation = $_POST['situation'];

}
?>



<body>
	<div>
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
					<li class="active">填寫書籍資料</li>
					<li>確認資料</li>
					<li>徵求釋出</li>
				</ul>
				
			</div>
			<div class="upload-container">
				<div class="upload">
				<div class="image-preview" id="imagePreview">
					<img src="../index_img/magazine-book_OBGUXZX9T8.jpg" alt="book" class="image-preview_image">
				</div>
			</div>
			<div class="container2">
			<form id='form1' name='form1' method='post' action='Request_Book2.php'> <!--才能傳值--> 
				<input class="input" type="text" name="book_title" placeholder="  *輸入完整書名" value="<?php echo $book_title;?>">
				<input class="input" type="text" name="ISBN" placeholder="  *輸入ISBN碼(13碼)"  value="<?php echo $ISBN;?>">
				<input class="input" type="text" name="author" placeholder="  *輸入作者" value="<?php echo $author ;?>" >
				<input class="input" type="text" name="publishing_house" placeholder="  *輸入出版社"  value="<?php echo $publishing_house;?>">
				<input class="input" type="text" name="publication_date" placeholder="  *輸入出版日期" value="<?php echo $publication_date;?>">
				<input class="input" type="text" name="version" placeholder="  輸入版本" value="<?php echo $version;?>">
				<select name="situation" >
				<?php 
					if($book_title ==  ""){
						?>
					<option value="0"> *選擇書本狀況</option> 
				<?php
					}else{
				?>
					
					<option value="<?php echo $situation;?>" >  <?php echo $situation;?> </option> 
				<?php
					}
				?>
					<option value="皆可">皆可</option>
					<option value="全新">全新</option>
					<option value="近全新">近全新</option>
					<option value="良好">良好</option>
					<option value="普通">普通</option>
					<option value="差強人意">差強人意</option>

				</select>
				<div>
					<span id="sale-book_next"><input name='go2' value="下一步" type="submit" class="button1" ></span>
				</div>
			</form> <!--才能傳值-->
			</div>
		</div>
	</div>

	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>

</body>
</html>