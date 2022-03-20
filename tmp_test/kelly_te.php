

<?php 
		
header('content-type:text/html;charset=utf-8');


include("upload_function.php");
if( isset( $_FILES['file'] ) )
{
     $files = get_files();

     foreach( $files as $file_info ) 
     {
          $message = upload_file($file_info);
          echo '<p>' . $message . '</p>';
     }
}
else
{
     echo '操作錯誤';
}

// echo '<p><a href="index.php">返回首頁</a></p>';

?>
     echo "inpFile1tmp_name:".$_FILES['inpFile1']['tmp_name']."<br>";
	echo "inpFile1name:".$_FILES['inpFile1']['name']."<br>";
	echo "inpFile1New:".$_FILES['inpFile1']['name']."<br>";
	$pic1 = $_FILES['inpFile1']['tmp_name']; //
	echo ":".$_FILES['inpFile1']['tmp_name']."<br>"; //
	$tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();die($tmp_dir);
	echo $tmp_dir;
?>