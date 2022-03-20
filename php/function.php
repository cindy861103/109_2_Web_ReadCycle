
<?php 
// include("../../conn.php");
// // 今天的日期」
// date_default_timezone_get();
// $tz='Asia/Taipei';
// date_default_timezone_set($tz) ;
// // echo $_SERVER['REQUEST_TIME']."<br>";
// $now = $_SERVER['REQUEST_TIME'] ;
// echo $now;
//genSn()產生當天訂單流水號

function genSn(){
	include("../conn.php");
	// 今天的日期」
	date_default_timezone_get();
	$tz='Asia/Taipei';
	date_default_timezone_set($tz) ;
	$now = $_SERVER['REQUEST_TIME'] ;
	
	$sql = "SELECT count(LEFT(function_id,8)) as id FROM book_function 
	WHERE DATE_FORMAT(pub_create_date,'%Y%m%d') = DATE_FORMAT(FROM_UNIXTIME('$now'),'%Y%m%d')
	";
	
	$res = $db -> query($sql);
	$attr = $res -> fetch_row();
	// echo (int)$attr[0]+1;
	$orderSn = date('Ymd', $now) . str_pad(
		((int)$attr[0] + 1
	), 3, '0', STR_PAD_LEFT);
	
	return $orderSn ;}

	$sn = genSn();


// 確認book 的 isbn存在與否
	function checkIsbn($db,$ISBN){
		$sql = "SELECT count(*) FROM book where ISBN = '$ISBN'";
		$result= $db -> query($sql);
		$attr = $result -> fetch_assoc();
		if($attr != '0'){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	
// echo __FILE__."<br/>";
// echo __DIR__."<br/>";
// echo basename(__FILE__)."<br/>";
// echo basename(__FILE__,".php")."<br/>";
// echo basename(__DIR__)."<br/>";
// echo basename(__DIR__,"Lab")."<br/>";
// echo dirname(__FILE__)."<br/>";
// echo dirname(dirname(__FILE__))."<br/>";
// echo dirname(__DIR__);109_2_web_book_match/img
	// echo "<img src='../../img/AC_1_1.jpg' />";
	

	
?>
