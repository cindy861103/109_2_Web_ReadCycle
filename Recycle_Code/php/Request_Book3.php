<!-- 徵求的邏輯：
放上想要的書，但book.ISBN可能還不存在
％％所以book.ISBN跟func的不可相容吧
因為徵求的內容我們不會拿來審核？
===
不然就是判斷isbn在不在
如果ＩＳＢＮ不存在，那就先把書本資料放進去
然後到時候也列為審核
再把資料傳一傳
若是在的話，就只存function

-->


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
	<link rel="stylesheet" type="text/css" href="../css/request_book3_style.css">
	<!-- <link rel="stylesheet" type="text/css" href="../css/sale_book4_style.css"> -->
	<script src="https://kit.fontawesome.com/cbacd055c2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/home.css">
	<title>徵求書籍3</title>
</head>
<?php
	}else{
	echo "請先登入!";
	header('Refresh:2;../html/Log_In.html');  
	exit();
}
// 直接進資料庫
if($_SERVER["REQUEST_METHOD"]=="POST" ){
	$book_title = $_POST['book_title']; // 字串
	$ISBN = $_POST['ISBN']; //數字V
	$author = $_POST['author']; 
	$publishing_house = $_POST['publishing_house']; 
	$publication_date = $_POST['publication_date'];   
	$version = $_POST['version']; 
	$situation = $_POST['situation']; //V
	// 拿到流水號
	//如果編號重複就一直加直到沒有重複了
	do {
		$sn = genSn();
		$errorNo = mysqli_errno($db);
		if ($errorNo >0 && $errorNo !=1062){
			break;
		}
	}while($errorNo == 1062);
	$function_id = $sn ;
	//判別有沒有isbn在book裡
	if ($ans = checkIsbn($db,$ISBN) ==  FALSE ){
		$sql = "INSERT INTO `book` (`ISBN`, `book_title`, `author`, `version`, `publishing_house`, `publication_date`, `book_update_date`) VALUES 
			('$ISBN', '$book_title', '$author', '$version', '$publishing_house', current_timestamp(), current_timestamp());
			INSERT INTO `book_function` (`function_id`, `ISBN`, `member_id`, `situation`, `pub_price`, `book_condition`, `class`, `pic1`, `pic2`, `description`, `function`, `pub_create_date`, `pub_update_date`) 
			VALUES ('$function_id', '$ISBN', '$memberid', '$situation', '0', '未審核', 'NULL', 'pic1', 'pic2', NULL, '徵求', current_timestamp(), current_timestamp())";
		$result= $db -> multi_query($sql);
	}else{
		$sql = "INSERT INTO `book_function` (`function_id`, `ISBN`, `member_id`, `situation`, `pub_price`, `book_condition`, `class`, `pic1`, `pic2`, `description`, `function`, `pub_create_date`, `pub_update_date`) 
		VALUES ('$function_id', '$ISBN', '$memberid', '$situation', '0', '已審核', 'NULL', 'pic1', 'pic2', NULL, '徵求', current_timestamp(), current_timestamp())";
		$result= $db -> query($sql);
	}
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
					<li class="active" id='active'>確認資料</li>
					<li class="active">徵求釋出</li>
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
					<a type='button' href="Request_Book1.php">刊登下一本</a>
				</div>
			</div>

			<div class="upload-container">
			<div class="upload">
				<div id="imagePreview">
					<img src="../index_img/magazine-book_OBGUXZX9T8.jpg" alt="book" class="image-preview">
				</div>
			</div>
			<div class="container2">

			<form id='form3' name='form3' method="post"  > 
				<span class="name"><?php echo $book_title;?></span>
				<span class="info">ISBN碼: <?php echo $ISBN;?></span>
				<span class="info">作者: <?php echo $author;?></span>
				<span class="info">出版社: <?php echo $publishing_house;?></span>
				<span class="info">出版日期: <?php echo $publication_date;?></span>
				<span class="info">版本: <?php echo $version;?></span>
				<span class="info">書本狀況: <?php echo $situation;?></span>
				<!-- 隱藏傳值 為了傳回去2有東西-->
				<input name="book_title" type="hidden" value="<?php echo $book_title; ?>">
				<input name="ISBN" type="hidden" value="<?php echo $ISBN; ?>">
				<input name="author" type="hidden" value="<?php echo $author; ?>">
				<input name="publishing_house" type="hidden" value="<?php echo $publishing_house; ?>">
				<input name="publication_date" type="hidden" value="<?php echo $publication_date; ?>">
				<input name="version" type="hidden" value="<?php echo $version; ?>">
				<input name="situation" type="hidden" value="<?php echo $situation; ?>">
			</form>
			</div>	
		</div>
	</div>
	<!-- 傳東西 -->

	<!-- <div class="layer2"> -->
	<!-- </div> -->
	
	<!-- 勿觸 -->
	<?php 
		if ($result === TRUE ){
			// echo "完成";
	?>
	<!-- 勿觸 -->
<!-- 
	<div class="layer3">
		<div class="icon">
			<i class="fas fa-check"></i>
		</div>
		<div class="text">
			<p class="title">已徵求成功</p>
			<p class="subtitle">將在5秒內跳轉回徵求頁面，方便您刊登下一本書</p>
		</div>
		<a type='button' >徵求下一本</a>
		<a type='button' >回首頁</a>
	</div> -->
	
	
	<!-- 勿觸 -->
	<?php 
		}else {
			echo "失敗";
			echo mysqli_error($db);
		}
	?>





	<!-- 要跳轉的頁面網址 -->
	<!-- <script language=javascript> 
		setTimeout('window.location="Request_Book1.php"',5000)
	</script>
	-->
	<script type="text/javascript">
		let form2=document.getElementById('form3')
		document.getElementById('up2').onclick=e=>{
			form2.action='Request_Book2.php'
			form2.submit()
		}
		document.getElementById('go3').onclick=e=>{
			form2.action='Request_Book3.php'
			form2.submit()
		}

	</script>
</body>
</html>