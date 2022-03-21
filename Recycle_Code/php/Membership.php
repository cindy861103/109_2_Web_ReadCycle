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
	<link rel="stylesheet" href="../css/Membership_style.css">
	<link rel="stylesheet" href="../css/home.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
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

	<div class="left">
		<p>書籍管理<br></p>
		<a href="Manage_Sell1.php">刊登管理</a><br>
		<a href="Manage_Require1.php">徵求管理</a><br>
		<a href="Manage_Member1.php">會員管理</a><br>
		<a href="Manage_Order.php">購買紀錄</a><br>
		<?php if($level == 0){
		?>
		<a href="Manage_Backstage1.php">後臺審核</a><br>
		<a href="Membership.php">會籍資料</a><br>
		<?php
		}
		?>
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
	<form method="post" action="Manage_Member2.php">
		<input name="member_id" type="hidden" value="<?php echo $attr['member_id']; ?>">
		<input name="depart" type="hidden" value="<?php echo $attr['depart']; ?>">
		<input name="name" type="hidden" value="<?php echo $attr['name']; ?>">
		<input name="sex" type="hidden" value="<?php echo $attr['sex']; ?>">
		<input name="email" type="hidden" value="<?php echo $attr['email']; ?>">
		<input name="phone_num" type="hidden" value="<?php echo $attr['phone_num']; ?>">
		</form>

	<div>
		<p class="memberinfo">會籍資料</p>
     	<br><br><br><br>
		<hr style="border: 1px solid#005889;" align="left">
	</div>
	
	
<div class="tablen">
	
<?php 
		
	do{
		$editstr="member_id=".$attr['member_id'].
		"&depart=".$attr['depart'].
		"&name=".$attr['name'].
		"&sex=".$attr['sex'].
		"&email=".$attr['email'].
		"&phone_num=".$attr['phone_num']; 
?>
	
	<!-- <table class="table1"> -->
	<div>
	<table>
		<tr>
			<td class="name" colspan="5">姓名：<?php echo $attr['name']; ?></td>
			<td class="edit"><a href="../php/Membership2.php?<?php echo $editstr;?>" class="edit">編輯</a></td>
		</tr>
		<tr>
			<td class="info">會員編號</td>
			<td class="info">會員信箱</td>
			<td class="info">會員密碼</td>
			<td class="info">系級</td>
			<td class="info">性別</td>
			<td class="info">最後編輯時間</td>

		<!--
			<td align="center">最後編輯時間</td>
			<td class="edit"><button class="edit" href="">編輯</button></td>
		-->
		</tr>
	
		<tr>
			<td class="info"><?php echo $attr['member_id']; ?></td>
			<td class="info"><?php echo $attr['email']; ?></td>
			<td class="info">*****</td>
			<!-- <td class="info"><?php //echo $attr['password']; ?></td> -->
			<td class="info"><?php echo $attr['depart']; ?></td>
			<td class="info"><?php if($attr['sex']==1){echo "女";}else{echo "男";} ?></td>
			<td class="info"><?php echo date("Ymd",strtotime($attr['update_date'])); ?></td>
		</tr>
	</table>
	</div>
	<?php
		}while($attr = $result -> fetch_assoc());
	?>
	</div>

	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>

</body>
</html>