<?php

	session_start();
	
	header("content-type: image/jpeg");

	//製作流程：產生隨機數 -> 創建圖片 -> 隨機數寫進圖片 -> 存在session
	
	//【Step1】產生隨機數
	$rand = null; 
	
	for($i=0;$i<4;$i++) //因為有四位數，所以i為0~3。
	{
		$rand .= dechex(rand(1,15)); 
		//隨機產生亂數1~15再把抽出來的數字利用dechex函數把10進制轉為16進制。故會有英文字母。
	}
	//.=：連接每次產生的字串，不會讓前面產生的字串消失，而是以連結的形式串字元。


	//【Step2】創建圖片
	//設置圖片大小
	$im = imagecreatetruecolor(100,34);
	
	//設置顏色
	$bg = imagecolorallocate($im,0,0,0); //更改背景色--->(0,0,0)：黑色
	imagefill($im,0,0,$bg);
	$te = imagecolorallocate($im,255,255,255); //配置文字顏色--->(255,255,255)：白色

	//製作線條干擾
	for($i=0;$i<5;$i++) //範例製作4條線(i = 0~4)
	{
		$te2 = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
		imageline($im,rand(0,100),0,100,30,$te2);
	}

	//製作點干擾
	for($i=0;$i<400;$i++) //範例製作400個干擾點(i = 0~399)
	{
		imagesetpixel($im,rand()%100,rand()%34,$te2);//rand()%100：取得0~100以內的數字
	}


	//【Step3】隨機數($rand)寫進圖片($im)
	imagestring($im, rand(4,6),rand(3,70),rand(0,16), $rand, $te);

	//輸出圖片	
	imagejpeg($im);


	//【Step4】驗證碼的正確值存在session中的verify的變數內，以利後續核對。
	$_SESSION['verify'] = $rand;