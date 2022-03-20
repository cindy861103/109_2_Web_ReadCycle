<!-- 先判斷是否為admin 若不是的話就硬性退出 
之後，會看到所有會員資料，並且可以編輯
-->
<?php
	include ("../conn.php");
	session_start(); // session啟動
	ini_set('display_errors', 0); // 錯誤訊息關掉
	if (isset($_SESSION["memberid"]) && $_SESSION['level'] == "0"){
		$memberid = $_SESSION['memberid'];
		$level = $_SESSION['level'] ;
		
?>


<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>會籍資料</title>
	<link rel="stylesheet" href="css/Membership_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script type='text/javascript' src='../home.js'></script>
</head>

<?php
	}else{
	echo "非法入侵!請使用Admin帳號";
	header('Refresh:2;Log_In.html');   
	exit();
	}
	$sql = "SELECT * FROM member ;";

	$result= $db -> query($sql);
	$attr = $result -> fetch_assoc();



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
		<a href="Manage_Backstage.html">後臺審核</a><br>
		<a href="Membership.html">會籍資料</a><br>
		<br>
		書適圈 Readcycle<br>
		<p>常見問題<br>
		創辦理念<br>
		商業合作<br>
		聯絡我們<br><p>
    </div>
    <div>
		<p class="memberinfo">會籍資料</p>
        <br><br><br>
		<hr style="border: 1px solid#005889;" align="left">
	</div>
	<div class="tablen"><!-- 讓所有的資料在同一頁之類ㄉㄚ？-->

<?php 
	do{
?>

	<!-- <table class="table1"> -->
	
	<table >
		<tr>
			<td class="bookname" colspan="5"></td>
			<!-- <td class="edit"><button class="edit" href="">編輯</button></td> -->
		</tr>
		<tr>
			<td class="info">加入時間</td>
			<td align="center">會員編號</td>
			<td align="center">名字</td>
			<td align="center">系級</td>
			<td align="center">性別</td>
			<td align="center">最後編輯時間</td>
			<td class="edit"><button class="edit" href="">編輯</button></td>
		</tr>
		<tr>
			<td class="info"><?php echo date("Ymd",strtotime($attr['create_date'])); ?></td>
			<td align="center"><?php echo $attr['member_id']; ?></td>
			<td align="center"><?php echo $attr['name']; ?></td>
			<td align="center"><?php echo $attr['depart']; ?></td>
			<td align="center"><?php echo $attr['sex']; ?></td>
			<td align="center"><?php echo date("Ymd",strtotime($attr['update_date'])); ?></td>
		</tr>
	</table>
	<?php
		}while($attr = $result -> fetch_assoc());
	?>
	</div>
	</body>
</html>


