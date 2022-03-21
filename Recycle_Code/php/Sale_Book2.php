<!-- 這邊也是拿到會員session 

刊登書籍2：
要拿到參數傳到下一步，
也要當3回來上一步時，可以傳回值並看到
但是好像少了科系用書的li
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
	<link rel="stylesheet" type="text/css" href="../css/sale_book2_style.css">
	<link rel="stylesheet" href="../css/home.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<title>刊登書籍2</title>
</head>

<!-- 登入後才可使用刊登 -->
<?php
}else{
	echo "請先登入!";
	header('Refresh:2; ../html/Log_In.html');   
	exit();
}

if($_SERVER["REQUEST_METHOD"]=="GET" ){
	
	$memberid = $_GET['memberid'];
	
	// 如果是2的上一步回車
	// 應該也是拿到get
	// 這邊都還不關資料庫的事情
	$function_id=$_GET['function_id']; // 會是自創數字

	$book_title = $_GET['book_title']; // 字串
	$ISBN = $_GET['ISBN']; //數字
	$author = $_GET['author']; 
	$publishing_house = $_GET['publishing_house']; 
	$publication_date = $_GET['publication_date']; 
	$version = $_GET['version'];
	$situation = $_GET['situation'];
	$book_depart = $_GET['book_depart'];
	$pub_price = $_GET['pub_price']; //在2填入的值
	$description = $_GET['description']; //在2填入的值

}
if($_SERVER["REQUEST_METHOD"]=="POST"){
	// 如果是1傳去下一步
	// 要拿到form值 ＆＿ＰＯＳ
	$memberid = $_POST['memberid'];
	$function_id=$_POST['function_id']; // 會是自創數字
	$book_title = $_POST['book_title']; 
	$ISBN = $_POST['ISBN']; 
	
	$author = $_POST['author']; 
	$publishing_house = $_POST['publishing_house']; 
	$publication_date = $_POST['publication_date']; 
	$version = $_POST['version'];
	$situation = $_POST['situation'];
	$book_depart = $_POST['book_depart'];
	$pub_price = $_POST['pub_price']; //在2填入的值
	$description = $_POST['description']; //在2填入的值
	$pic1 = $_POST['pic1']; //
     $pic2 = $_POST['pic2']; //
	

	// 照片處理
	$temp = $_FILES['pic1']['tmp_name'];
	$real = $_FILES['pic1']['name'];
	// 名稱要改成邏輯：
	
	//以下面這個方式，讓回到第一頁時還是可以重傳照片並覆蓋
	// echo 'temp_name'.$_FILES['pic']['temp_name'];
	// echo 'name'.$_FILES['pic']['name'];
	
	// 則回到第一頁，第一頁要記得接img
	header('content-type:text/html;charset=utf-8');
	include("upload_function.php");
	if( isset( $_FILES['pic'] ) )
	{
		$files = get_files();
		$i = 0;
		foreach($files as $file_info){
			$i++;
			$new = $function_id.'_'.$i.".jpg";
			
			$pic = upload_file($file_info,$new);
		}
	}
	else
	{
		echo '操作錯誤';
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
			<p>刊登書籍</p>
		</div>
		<div class = container>
			<ul class="progressBar">
				<li class="active"id='active'>填寫書籍資料</li>
				<li class="active" >輸入定價、備註</li>
				<li>確認資料</li>
			</ul>
		<!-- 暫存圖片1 -->

		<div class="upload-container">
			<div class="upload">
			<!-- <div class="image-preview" id="imagePreview"> -->
			<div>
		
				<!-- <img src='../img/AC_1_1.jpg' class="image-preview" id="imagePreview"> -->
				<!-- 暫存路徑 -->
				<img class="image-preview" id="imagePreview" src='../img/<?php echo $function_id."_1.jpg" ;?>'>
				
			</div>
		<!-- 暫存圖片2 -->
		</div>
			<div class="upload">
				<div>
					<!-- <img src='../img/AC_1_1.jpg' class="image-preview" id="imagePreview"> -->
					<!-- 暫存路徑 2號還不知怎麼拿路徑-->
					<img class="image-preview" id="imagePreview" src='../img/<?php echo $function_id."_2.jpg" ;?>'>
				</div>
			</div>
		</div>
		
		<!-- 1內容抓取以及2內容傳值 -->
		<div class="container2">

		<!-- <form method="post" action="Sale_Book3.php">  -->
		<form id='form2' name='form2' method="post" action="Sale_Book3.php" > 
			<!-- 藉由form傳值 -->
			<input name="memberid" type="hidden" value="<?php echo $memberid; ?>">
			<input name="function_id" type="hidden" value="<?php echo $function_id; ?>">
			<input name="book_title" type="hidden" value="<?php echo $book_title; ?>">
			<input name="ISBN" type="hidden" value="<?php echo $ISBN; ?>">
			<input name="author" type="hidden" value="<?php echo $author; ?>">
			<input name="publishing_house" type="hidden" value="<?php echo $publishing_house; ?>">
			<input name="publication_date" type="hidden" value="<?php echo $publication_date; ?>">
			<input name="version" type="hidden" value="<?php echo $version; ?>">
			<input name="situation" type="hidden" value="<?php echo $situation; ?>">
			<input name="book_depart" type="hidden" value="<?php echo $book_depart; ?>">
			<input name="pub_price" type="hidden" value="<?php echo $pub_price; ?>">
			<input name="description" type="hidden" value="<?php echo $description; ?>">
			<input name="pic1" type="hidden" value="<?php echo $function_id."_1.jpg" ?>">
			<input name="pic2" type="hidden" value="<?php echo $function_id."_2.jpg" ?>">
			<!-- 不知為何沒有科系 -->
			<span class="name">書名 <?php echo $book_title;?></span>
			<span class="info">ISBN碼: <?php echo $ISBN;?></span>
			<span class="info">作者: <?php echo $author;?></span>
			<span class="info">出版社: <?php echo $publishing_house;?></span>
			<span class="info">出版日期: <?php echo $publication_date;?></span>
			<span class="info">版本: <?php echo $version;?></span>
			<span class="info">書本狀況: <?php echo $situation;?></span>
			<span class="info">科系用書: <?php echo $book_depart;?></span>

			<input class="input" type="text" name="pub_price" placeholder="  *輸入定價" value="<?php echo $pub_price;?>">
			<input class="input" type="text" name="description" placeholder="  *輸入備註" value="<?php echo $description;?>">

			<div>
				<span id="sale-book_last"><input id="up1" name="up1" value="上一步" type="botton" class="button1"></span>
			</div>
			<div >
				<span id="sale-book_next"><input id="go3" name="go3" value="下一步" type="botton"class="button2"></span>
			</div>
		</form>
		</div>
			
	</div>
	
	<script type="text/javascript">

		//下一步
		// // 找到id在哪
		// document.getElementById('form2').onsubmit=e=>{
		// 	// 把預設的動作停掉
		// 	e.preventDefault()
		// 	// 換成以下的（“”）
		// 	console.log('hello')
		// }
		// 
		let form2=document.getElementById('form2')
		document.getElementById('up1').onclick=e=>{
			form2.action='Sale_Book1.php'
			form2.submit()
		}
		document.getElementById('go3').onclick=e=>{
			form2.action='Sale_Book3.php'
			form2.submit()
		}

	</script>
	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
	
</body>
</html>