<html>

<head>

	<title>上傳檔案</title>

	<style>
		input {
			display: block;
			margin-bottom: 5px;
		}
	</style>

</head>

<body>

	<form action="upload.php" method="post" enctype="multipart/form-data">
		<?php 
		// $tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
		// die($tmp_dir);
		// echo $tmp_dir ; 
		// if(chmod(777,$tmp_dir)){
		// 	echo "OK<br>";
		// }else{
		// 	echo "NOT<br>";
		// }
			?>
		
		<!--與單檔(week2)最大的不同是name中的file是儲存為[](陣列)，故可以一次儲存多筆資料，每上傳一次就存在陣列中一次。-->
		<input type="file" name="file[]">
		<input type="file" name="file[]">
		<input type="file" name="file[]">

		<button type="submit">上傳</button>

	</form>

</body>

</html>