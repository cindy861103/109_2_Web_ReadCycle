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

	<form action="upload_function.php" method="post" enctype="multipart/form-data">

		<!--與單檔(week2)最大的不同是name中的file是儲存為[](陣列)，故可以一次儲存多筆資料，每上傳一次就存在陣列中一次。-->
		<input type="file" name="file[]">
		<input type="file" name="file[]">
		<input type="file" name="file[]">

		<button type="submit">上傳</button>

	</form>

</body>

</html>