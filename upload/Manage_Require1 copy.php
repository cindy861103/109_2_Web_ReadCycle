<?php
include ("../conn.php");
session_start(); // session啟動
ini_set('display_errors', 0); // 錯誤訊息關掉
if (isset($_SESSION["memberid"])){
	$memberid = $_SESSION['memberid'];
?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>管理徵求</title>
	<link rel="stylesheet" href="css/Manage_Require_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script type='text/javascript' src='../home.js'></script>
</head>

<?php
}else{
	echo "請先登入!";
	header('Refresh:2;Log_In.html');  
	exit();
}

	$memberid = $_SESSION['memberid'];
	$sql = "SELECT book_function.* ,book.book_title FROM book_function ,book 
	WHERE member_id = '$memberid' && function = '徵求' 
	&& book.ISBN = book_function.ISBN";

	$result= $db -> query($sql);
	$attr = $result -> fetch_assoc();
	
	$editstr="member_id=".$attr['member_id']. 
	"&pub_update_date=".$attr['pub_update_date']. //最後編輯時間
	"&pub_create_date=".$attr['pub_create_date']. //刊登建立時間
	"&function_id=".$attr['function_id']. // 書籍功能編號
	"&pub_price=".$attr['pub_price']. //書籍價格
	"&book_condition=".$attr['book_condition']. //書籍狀態（未審核、未售出、已售出）
	"&situation=".$attr['situation']. //書況
	"&book_title=".$attr['book_title'];  // 書名
	

	

?>

<body>
	<div class="header">
		<div class="logo" src="">Readcycle</div>
		<div class="search">
			<input class="search-bar" type="text" name="search" id="search" placeholder="搜尋">
			<button class="search-btn"><i class="fas fa-search"></i></button>
		</div>
			<div class="publish">刊登</div>
			<div class="request">徵求</div>
			<div class="notification"><i class="fas fa-bell"></i></div>
			<div class="member"><i class="fas fa-user"></i></div>
			<div class="cart"><i class="fas fa-shopping-cart"></i></div>
	</div>
	<div class="banner">
		<img class="banner" src="/Users/ingrid881010/Downloads/image 7.png">
	</div>
	<div class="left">
		<p>書籍管理<br></p>
		<a href=Manage_Sale1.html>刊登管理</a><br>
		<a href="Manage_Require.html">徵求管理</a><br>
		<a href="Manage_Member1.html">會員管理</a><br>
		<a href="Manage_Order.html">訂單查詢</a><br>
		<br>
		書適圈 Readcycle<br>
		<p>
		常見問題<br>
		創辦理念<br>
		商業合作<br>
		聯絡我們<br>
		</p>
	</div>

	<!--以上為首頁邊框-->

	<div>
		<p class="uploadsetting">徵求管理</p>
		<p class="uploadwarning"><img src="exclamation_mark.png" width="22">  刊登須知</p>
		<br><br><br>
		<hr style="border: 1px solid#005889;" align="left">
	</div>
	<div class="tablen">  <!-- 讓所有的資料在同一頁 ，有新增加css -->
	<?php 
	
	
	
	do{
	?>
	<!-- <table class="table1"> -->
	<!-- Ｋ：表格的css需要調整 -->
	
	<table>
	<!-- <table class="table1"> -->
		<tr>
			<td class="bookname" colspan="5"><?php echo $attr['book_title']; ?></td>
			<td class="edit">
			<a class="edit" href="Manage_Require2 copy.php?<?php 
			echo "member_id=".$attr['member_id']."&function_id=".$attr['function_id'];?>">
			編輯</a></td>
		</tr>
		<tr>
			<td class="info">建立時間</td>
			<td align="center">刊登編號</td>
			<!-- <td align="center"></td> -->
			<td align="center">狀態</td>
			<td align="center">書況</td>
			<td align="center">最後編輯時間</td>
		</tr>
		
		<tr>
			
			<td class="info"><?php echo date("Ymd",strtotime($attr['pub_create_date'])); ?></td>
			<td align="center"><?php echo $attr['function_id']; ?></td>
			<!-- <td align="center"></td> -->
			<?php 
				$ISBN= $attr['ISBN'] ;
				$sql2 = "SELECT function_id,ISBN  FROM book_function
						WHERE function = '刊登'  && ISBN = '$ISBN'";
				$result2 = $db -> query($sql2);
				$la = $result2 -> fetch_assoc();
				$book = $la['function_id'];
				 // 匹配的
			?><!--  下面要去找所有刊登書籍裡有沒有這本書的ISBN，有的話就用刊登bookid寫href，沒有的話就寫徵求中-->
			<td align="center">
				<?php if($book){
					// 網址現在是錯的呦
					echo '<a href="Manage_Sale3 copy.php?member_id=$attr["member_id"]&function_id=$book">已找到</a>';
					$fref=array($la['function_id']);
				}else{ // 但很多本的話怎麼辦？還沒想到
					echo "徵求中";}?>
				
			</td> 
			<td align="center"><?php echo $attr['book_condition']; // 到時候唯二能編輯的地方，另一個是刪除 ?></td> 
			<td align="center"><?php echo date("Ymd",strtotime($attr['pub_update_date'])); ?></td>
		</tr>
		</table>
	<?php
	}while($attr = $result -> fetch_assoc());
	?>
	</div>
</body>
</html>