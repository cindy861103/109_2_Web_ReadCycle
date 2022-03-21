<!-- 
刊登管理1 :

用迴圈拿到個人在 readcycle.bookfunction裡面的所有資料並列出來
-->

<?php
	include ("../conn.php");
	session_start(); // session啟動
	ini_set('display_errors', 0); // 錯誤訊息關掉
	if (isset($_SESSION["memberid"] ) ){
		$memberid = $_SESSION['memberid'];
		$level = $_SESSION['level'] ;
		
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>管理刊登1 </title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/Manage_Sell1_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<?php
}else{
	echo "請先登入!";
	header('Refresh:2; ../html/Log_In.html');   
	exit();
}
?>

<?php 
	$memberid = $_SESSION['memberid'];
	$sql = "SELECT book_function.* ,book.book_title FROM book_function ,book 
	WHERE member_id = '$memberid' && function = '刊登' 
	&& book.ISBN = book_function.ISBN
	ORDER BY pub_update_date DESC";

	$result= $db -> query($sql);
	$attr = $result -> fetch_assoc();
	
	$editstr="member_id=".$attr['member_id']. 
	"&pub_update_date=".$attr['pub_update_date']. //最後編輯時間
	"&pub_create_date=".$attr['pub_create_date']. //刊登建立時間
	"&function_id=".$attr['function_id']. // 書籍功能編號
	"&pub_price=".$attr['pub_price']. //書籍價格
	"&book_condition=".$attr['book_condition']. //書籍狀態（未審核、未售出、已售出）
	"&situation=".$attr['situation']. //書況
	"&book_title=".$attr['book_title'].
	"&pic1".$attr['pic1'];  // 書名
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

	<!--以上為首頁邊框-->

	<div>
		<p class="uploadsetting">刊登管理</p>
		<br><br><br><br>
		<hr style="border: 1px solid #005889;" align="left">
	</div>
	
	<!-- 讓資料迴圈出來 -->
	<div class="tablen">
		<!-- 讓所有的資料在同一頁 ，有新增加css-->
		<?php
		if ($attr['book_title']) {
			do {
		?>
				<table class="table1">
					<!-- Ｋ：表格的css需要調整 -->
					<table width="100%">
						<tr>
							<td class="bookname" colspan="5">書名: <?php echo $attr['book_title']; ?></td>
							<td class="edit"><a class="edit" href="Manage_Sell3.php?<?php
echo "member_id=" . $attr['member_id'] . "&function_id=" . $attr['function_id']; ?>">編輯</a></td>
						</tr>
						<tr>
							<td class="info">建立時間</td>
							<td class="info">刊登編號</td>
							<td class="info">定價</td>
							<td class="info">狀態</td>
							<td class="info">書況</td>
							<td class="info">最後編輯時間</td>
						</tr>
						<tr>
							<td class="info"><?php echo date("Ymd", strtotime($attr['pub_create_date'])); ?></td>
							<td class="info"><?php echo $attr['function_id']; ?></td>
							<td class="info"><?php echo $attr['pub_price']; ?></td>
							<td class="info"><?php echo $attr['book_condition']; ?></td>
							<td class="info"><?php echo $attr['situation']; ?></td>
							<td class="info"><?php echo date("Ymd", strtotime($attr['pub_update_date'])); ?></td>
						</tr>

					</table>
				</table>
			<?php
			} while ($attr = $result->fetch_assoc());
		} else { ?>
			<!-- 若沒有買過的話！ -->
			<h1>尚未有刊登記錄呦！～ </br>快點翻翻不要的舊書吧！</h1>

		<?php
		}
		?>

	</div>

    <script type='text/javascript' src='../jquery-3.6.0.js'></script>
    <script type='text/javascript' src='../home.js'></script>
    <script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>

</body>
</html>