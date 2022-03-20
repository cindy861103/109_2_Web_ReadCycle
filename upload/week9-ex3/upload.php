<?php
		
	header('content-type:text/html;charset=utf-8');
	include("upload_function.php");
	if( isset( $_FILES['pic'] ) )
	{
		$files = get_files();
		$i = 0;
		$new = '';
		foreach( $files as $file_info ) 
		{
			$i++;
			$message = upload_file($file_info,$new,$i);
			echo '<p>' . $message . '</p>';
		}
	}
	else
	{
		echo '操作錯誤';
	}

	// echo '<p><a href="index.php">返回首頁</a></p>';
	
	?>