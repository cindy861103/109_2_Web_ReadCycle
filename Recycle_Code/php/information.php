<?php
//include other php files
include("../conn.php");
include("select_array.php");
include("depart_random.php");

session_start(); // session啟動
ini_set('display_errors',0); // 錯誤訊息關掉
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
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=utf-8'>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>更多資訊</title>
	<link rel="stylesheet" href="../css/information.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
</head>

<?php
} else {
	$class_arr = get_random_depart($self_depart);
	$self_depart = ''; //本科系是空值
	$bar_depart = $class_arr[0]; //取陣列第一個科系
}
?>
<!-- // Ｋ待辦 -->
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
			<a href="../php/information.php#AboutUs" name="#AboutUs" id="#AboutUs">創辦理念</a><br>
			<a href="../php/information.php#FAQ" name="#FAQ" id="#FAQ">常見問題</a><br>
			<a href="../php/information.php#Contact" name="#Contact" id="#Contact">聯絡我們</a><br>
			<a href="../php/information.php#Cooperation" name="#Cooperation" id="#Cooperation">商業合作</a>
		</div>
		<br>
		<img src="../index_img/Readcycle_logo.png">
	</div>

	<div class="nav">
		<a href="#AboutUs">創辦理念</a>
		<a href="#FAQ">常見問題</a>
		<a href="#Contact">聯絡我們</a>
		<a href="#Cooperation">商業合作</a>
	</div>

	<div class="right">
		<a name="AboutUs"></a>
		<div><h2>創辦理念</h2>
		痛點（問題點）<br>
		　　上課使用教科書是學生們都會經歷的事，實際上，當今各大專院校裡買賣二手書的風氣可謂十分盛行。對買家而言，在評估過價格與使用頻率後，認為購入全新的教科書並不划算。尤其，若喜歡書上有學長姐筆記的學生，買二手書更是個好選擇。對賣家而言，存放這些書籍需要空間，況且這些書已經不會再用到，若是成功賣出也能賺取一點錢。<br>
		　　我們發現在學期結束及新學期開始之際，透過Facebook社團「東吳二手教科書」交易的同學不計其數。然而，這個平臺使用起來不太方便。一方面，受到貼文消息排序的影響，買賣雙方很容易錯過媒合的機會。另一方面，在沒有分類的茫茫貼文海中，使用者要搜尋資訊根本無從找起。也就是說，同學們常常得碰運氣才能找到自己所需的書或者需要該書的同學。<br><br>
		目的（解決方法、預期效果）<br>
		　　我們希望架設一個二手書媒合平臺以減少學生轉賣和徵求教科書的困擾。除了減輕大家的負擔，也能避免學生為了省錢去非法影印，更能讓教科書資源得到有效的運用。其中，註冊帳號的依據是學號或教職員編碼，為的是要確認使用者為東吳大學的師生，以降低交易風險和防止不必要的糾紛。而平臺主要有三大特點：首先是搜尋功能，能夠縮短使用者查找到所需書籍的時間。再者是媒合通知功能，當平臺成功為徵求者配對書籍時會發送通知，讓徵求者省下尋找書籍的時間，快速進入後續購買程序。最後則是購物車功能，使用者可以將確定購買或考慮中的書籍加入購物車，無論要結帳抑或是比價都會更有效率。
		</div>
		<br>
		<a name="FAQ"></a>
		<div><h2>常見問題</h2>
		內容尚未上架，仍在編輯中，請耐心等候。
		<!-- 痛點（問題點）<br>
		　　上課使用教科書是學生們都會經歷的事，實際上，當今各大專院校裡買賣二手書的風氣可謂十分盛行。對買家而言，在評估過價格與使用頻率後，認為購入全新的教科書並不划算。尤其，若喜歡書上有學長姐筆記的學生，買二手書更是個好選擇。對賣家而言，存放這些書籍需要空間，況且這些書已經不會再用到，若是成功賣出也能賺取一點錢。<br>
		　　我們發現在學期結束及新學期開始之際，透過Facebook社團「東吳二手教科書」交易的同學不計其數。然而，這個平臺使用起來不太方便。一方面，受到貼文消息排序的影響，買賣雙方很容易錯過媒合的機會。另一方面，在沒有分類的茫茫貼文海中，使用者要搜尋資訊根本無從找起。也就是說，同學們常常得碰運氣才能找到自己所需的書或者需要該書的同學。<br><br>
		目的（解決方法、預期效果）<br>
		　　我們希望架設一個二手書媒合平臺以減少學生轉賣和徵求教科書的困擾。除了減輕大家的負擔，也能避免學生為了省錢去非法影印，更能讓教科書資源得到有效的運用。其中，註冊帳號的依據是學號或教職員編碼，為的是要確認使用者為東吳大學的師生，以降低交易風險和防止不必要的糾紛。而平臺主要有三大特點：首先是搜尋功能，能夠縮短使用者查找到所需書籍的時間。再者是媒合通知功能，當平臺成功為徵求者配對書籍時會發送通知，讓徵求者省下尋找書籍的時間，快速進入後續購買程序。最後則是購物車功能，使用者可以將確定購買或考慮中的書籍加入購物車，無論要結帳抑或是比價都會更有效率。 -->
		</div>
		<br>
		<a name="Contact"></a>		
		<div><h2>聯絡我們</h2>
		內容尚未上架，仍在編輯中，請耐心等候。
		<!-- 痛點（問題點）<br>
		　　上課使用教科書是學生們都會經歷的事，實際上，當今各大專院校裡買賣二手書的風氣可謂十分盛行。對買家而言，在評估過價格與使用頻率後，認為購入全新的教科書並不划算。尤其，若喜歡書上有學長姐筆記的學生，買二手書更是個好選擇。對賣家而言，存放這些書籍需要空間，況且這些書已經不會再用到，若是成功賣出也能賺取一點錢。<br>
		　　我們發現在學期結束及新學期開始之際，透過Facebook社團「東吳二手教科書」交易的同學不計其數。然而，這個平臺使用起來不太方便。一方面，受到貼文消息排序的影響，買賣雙方很容易錯過媒合的機會。另一方面，在沒有分類的茫茫貼文海中，使用者要搜尋資訊根本無從找起。也就是說，同學們常常得碰運氣才能找到自己所需的書或者需要該書的同學。<br><br>
		目的（解決方法、預期效果）<br>
		　　我們希望架設一個二手書媒合平臺以減少學生轉賣和徵求教科書的困擾。除了減輕大家的負擔，也能避免學生為了省錢去非法影印，更能讓教科書資源得到有效的運用。其中，註冊帳號的依據是學號或教職員編碼，為的是要確認使用者為東吳大學的師生，以降低交易風險和防止不必要的糾紛。而平臺主要有三大特點：首先是搜尋功能，能夠縮短使用者查找到所需書籍的時間。再者是媒合通知功能，當平臺成功為徵求者配對書籍時會發送通知，讓徵求者省下尋找書籍的時間，快速進入後續購買程序。最後則是購物車功能，使用者可以將確定購買或考慮中的書籍加入購物車，無論要結帳抑或是比價都會更有效率。 -->
		</div>
		<br>
		<a name="Cooperation"></a>		
		<div><h2>商業合作</h2>
		內容尚未上架，仍在編輯中，請耐心等候。
		<!-- 痛點（問題點）<br>
		　　上課使用教科書是學生們都會經歷的事，實際上，當今各大專院校裡買賣二手書的風氣可謂十分盛行。對買家而言，在評估過價格與使用頻率後，認為購入全新的教科書並不划算。尤其，若喜歡書上有學長姐筆記的學生，買二手書更是個好選擇。對賣家而言，存放這些書籍需要空間，況且這些書已經不會再用到，若是成功賣出也能賺取一點錢。<br>
		　　我們發現在學期結束及新學期開始之際，透過Facebook社團「東吳二手教科書」交易的同學不計其數。然而，這個平臺使用起來不太方便。一方面，受到貼文消息排序的影響，買賣雙方很容易錯過媒合的機會。另一方面，在沒有分類的茫茫貼文海中，使用者要搜尋資訊根本無從找起。也就是說，同學們常常得碰運氣才能找到自己所需的書或者需要該書的同學。<br><br>
		目的（解決方法、預期效果）<br>
		　　我們希望架設一個二手書媒合平臺以減少學生轉賣和徵求教科書的困擾。除了減輕大家的負擔，也能避免學生為了省錢去非法影印，更能讓教科書資源得到有效的運用。其中，註冊帳號的依據是學號或教職員編碼，為的是要確認使用者為東吳大學的師生，以降低交易風險和防止不必要的糾紛。而平臺主要有三大特點：首先是搜尋功能，能夠縮短使用者查找到所需書籍的時間。再者是媒合通知功能，當平臺成功為徵求者配對書籍時會發送通知，讓徵求者省下尋找書籍的時間，快速進入後續購買程序。最後則是購物車功能，使用者可以將確定購買或考慮中的書籍加入購物車，無論要結帳抑或是比價都會更有效率。 -->
		</div>
		<br><br><br>
	</div>
	
	<script type='text/javascript' src='../jquery-3.6.0.js'></script>
	<script type='text/javascript' src='../home.js'></script>
	<script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
</body>
</html>