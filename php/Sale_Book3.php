<!-- 這邊也是拿到會員session 

刊登書籍3：
要拿到參數傳到資料庫裡（有book跟function），
另外，book如果ＩＳＢＮ已經存在的話，不要去更動（因為只有審核後才會存在
另外，上傳圖片要存到資料夾裡（檔名為function_id_1&2?）
然後傳進資料庫時是檔名而已
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
	<link rel="stylesheet" type="text/css" href="../css/sale_book3_style.css">
	<link rel="stylesheet" href="../css/home.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<title>刊登書籍3</title>
</head>

<?php
}else{
	echo "請先登入!";
	header('Refresh:2; ../html/Log_In.html');   
	exit();
}


if($_SERVER["REQUEST_METHOD"]=="POST"){
	// 如果是1傳去下一步
	// 要拿到form值 ＆＿ＰＯＳ
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


}

if($_SERVER["REQUEST_METHOD"]=="GET" ){
	$memberid = $_GET['memberid'];
	// 如果是2的上一步回車
	// 應該也是拿到get(錯了是ｐｏ)
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
	$pub_price = $_GET['pub_price']; //2才有/
	$description = $_GET['description']; //2才有
	//
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
				<li class="active" id='active'>填寫書籍資料</li>
				<li class="active" id='active'>輸入定價、備註</li>
				<li class="active">確認資料</li>
			</ul>
			
		</div>
		<!-- 暫存圖片1 -->
		<div class="upload-container">
			<div class="upload">
			<div >
			<!-- <div class="image-preview" id="imagePreview"> -->
				<!-- <img src="" alt="Image Preview" class="image-preview_image"> -->
				<!-- <img src='../img/AC_1_1.jpg' class="image-preview" id="imagePreview"> -->
				<img class="image-preview" id="imagePreview" src='../img/<?php echo $function_id."_1.jpg" ;?>'>
				<!-- <span class="image-preview__default-text">封面</span> -->
			</div>
		</div>
		<!-- 暫存圖片2 -->
			<div class="upload">
				<div >	
				<!-- <div class="image-preview" id="imagePreview"> -->
					<!-- <img src="" alt="Image Preview" class="image-preview_image"> -->
					<!-- <img src='../img/AC_1_1.jpg' class="image-preview" id="imagePreview"> -->
					<!-- 暫存路徑 2號還不知怎麼拿路徑-->
					<img class="image-preview" id="imagePreview" src='../img/<?php echo $function_id."_2.jpg" ;?>'>
					<!-- <span class="image-preview__default-text">資訊頁</span> -->
				</div>
			</div>
		</div>
		
			
		<div class="container2">
		<form  id='form3' method="post" action="Sale_Book3.php"> <!--才能傳值-->
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
			<!-- <input name="book_depart" type="hidden" value="<?php //echo $_POST['book_depart']; ?>"> -->
			<input name="pub_price" type="hidden" value="<?php echo $pub_price; ?>">
			<input name="description" type="hidden" value="<?php echo $description; ?>">
			<input name="pic1" type="hidden" value="<?php echo $function_id."_1.jpg"; ?>">
			<input name="pic2" type="hidden" value="<?php echo $function_id."_2.jpg"; ?>">
			<!-- 不知為何沒有科系 -->
			<span class="name">書名 <?php echo $book_title;?></span>
			<span class="info">ISBN碼: <?php echo $ISBN;?></span>
			<span class="info">作者: <?php echo $author;?></span>
			<span class="info">出版社: <?php echo $publishing_house;?></span>
			<span class="info">出版日期: <?php echo $publication_date;?></span>
			<span class="info">版本: <?php echo $version;?></span>
			<span class="info">書本狀況: <?php echo $situation;?></span>
				<span class="info">定價:  <?php echo $pub_price;?></span>
				<span class="info">備註: <?php echo $description;?></span>
			</form>
			<div >
			<!-- botton 才不會form直接送出 -->
				<span id="sale-book_last"><input id="up2" name="up2" value= "上一步" type="botton" class="button1" ></span>
			</div>
			<div>
				<span id="sale-book_next"><input id="save" name="save" value= "刊登上架" type="botton" class="button2"></span>
			</div>
		</div>
			
	</div>
	
	<script type="text/javascript">


		let form2=document.getElementById('form3')
		document.getElementById('up2').onclick=e=>{
			form2.action='Sale_Book2.php'
			form2.submit()
		}
		document.getElementById('save').onclick=e=>{
			form2.action='Sale_Book4.php'
			form2.submit()
		}
	</script>
	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
	
</body>
</html>