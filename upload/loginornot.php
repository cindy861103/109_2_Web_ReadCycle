

<!-- 
感覺要進入這個頁面時就要先確定是否有登入，沒有就跳轉登入介面
-->



<?php 
	include ("conn.php");

	if ($_SESSION['memberid'] != null){
			$memberid = $_SESSION['memberid'];
			$sql = "SELECT * FROM member WHERE member_id = '$memberid' ";
			$result= $db -> query($sql);
			$attr = $result -> fetch_assoc();
			
		}else{
			echo " 請先登入";
			header('Refresh:1;Log_In.html');    
		}

?>
