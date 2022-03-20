<?php
	//改變原來 $_FILES 的 array 
	function get_files() {
		//將上傳的檔案資料重組(key值、name順序對調以利後續處理--->小技巧)，再放進array中。
		foreach( $_FILES as $file )
		{
			foreach( $file['name'] as $key => $val )
			{
				$files[$key]['name'] 	 = $file['name'][$key];
				$files[$key]['type'] 	 = $file['type'][$key];
				$files[$key]['tmp_name'] = $file['tmp_name'][$key];
				$files[$key]['error'] 	 = $file['error'][$key];
				$files[$key]['size'] 	 = $file['size'][$key];				
			}
		}
		return $files;
	}
	
	//上傳檔案函數
	function upload_file($file_info,$new)
	{
		//存放錯誤訊息
		$error_info = "";
		
		//檔名+1\2
		$name = $new;
		//上傳路徑
		// $upload_path = '../upload';
		$upload_path = '../img';
		//檔案路徑
		$file_path = $upload_path . '/' . $name ;		
		// 判斷是否有錯誤
		if( $file_info['error'] > 0 ) 
		{
			// 匹配的錯誤代碼
			switch( $file_info['error'] ) 
			{
				case 1:
					$error_info = '上傳的檔案超過了 php.ini 中 upload_max_filesize 允許上傳檔案容量的最大值';
					break;
				case 2:
					$error_info = '上傳檔案的大小超過了 HTML 表單中 MAX_FILE_SIZE 選項指定的值';
					break;
				case 3:
					$error_info = '檔案只有部分被上傳';
					break;
				case 4:
					$error_info = '沒有檔案被上傳（沒有選擇上傳檔案就送出表單）';
					break;
				case 5:
					$error_info = '伺服器臨時檔案遺失';
					break;
				case 6:
					$error_info = '檔案寫入到暫存資料夾錯誤';
					break;
				case 7:
					$error_info = '硬碟無法寫入';
					break;
				case 8:
					$error_info = '上傳的文件被 PHP 擴展程式中斷';
					break;
			}
			return($error_info);
		}
		
		//取得上傳檔案的副檔名
		$ext = pathinfo($file_info['name'], PATHINFO_EXTENSION); 		
		//預設檢查副檔名
		$allowExt = array('jpeg', 'jpg', 'gif', 'png', 'ppt');
		// 檢查上傳檔案副檔名
		if( !is_array($allowExt) )  // 判斷參數是否為陣列
		{
			return('檔案類型型態必須為 array');
		}	
		else 
		{
			if( !in_array($ext, $allowExt) )  // 檢查陣列中是否有允許的擴展名
			{
				return('非法檔案類型');
			}	
		}
		
		//檢查指定目錄是否存在，不存在就建立目錄
		// if( !file_exists($upload_path) )
		// {
		// 	mkdir($upload_path, 0777, true);  // 建立目錄
		// }
		
		//檢查檔案有沒有重覆上傳，有就覆蓋
		if( file_exists( $upload_path . '/' . $name ) )
		{
			move_uploaded_file($file_info["tmp_name"], $file_path);
		}
		else
		{
			// 將檔案從臨時目錄移至指定目錄
			move_uploaded_file($file_info["tmp_name"], $file_path);	
			// echo $file_info["tmp_name"]."<br>";
			// echo  "路徑".$file_path ; 
			// return $file_info['name'] . '上傳成功';
		}		
		
	}return $name;

	?>