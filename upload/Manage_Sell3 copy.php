<?php
    include ("../conn.php");
	session_start(); // session啟動
	ini_set('display_errors', 0); // 錯誤訊息關掉
	if (isset($_SESSION["memberid"])){
		$memberid = $_SESSION['memberid'];
	
?>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理刊登3</title>
    <link rel="stylesheet" href="css/Manage_Sale2_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script type='text/javascript' src='../home.js'></script>
</head>

<?php
}else{
	echo "請先登入!";
	header('Refresh:2;Log_In.html');   
	exit();
}
// 這邊是為了資料可以看到原資料
// 用id 去拿原資料
if($_SERVER["REQUEST_METHOD"]=="GET" ){
    
    $member_id=$_GET['member_id'];
    $function_id=$_GET['function_id'];

    $sql = "SELECT book_function.* ,book.* FROM book_function ,book 
	WHERE member_id = '$memberid' && function = '刊登' && function_id = '$function_id'
	&& book.ISBN = book_function.ISBN";
// 拿重要的ＳＥＬＥＣＴ去定義變數
	$result= $db -> query($sql);
	$attr = $result -> fetch_assoc();
    //需要拿的變數
    
        $book_title = $attr['book_title'];
        $ISBN = $attr['ISBN'];
        $author = $attr['author'];
        $publishing_house = $attr['publishing_house'];
        $publication_date = $attr['publication_date'];
        $version = $attr['version'];
        $situation = $attr['situation'];
        $pub_price = $attr['pub_price'];
        $description = $attr['description'];
}else{
        
        $member_id='';
        $function_id=''; 
        $ISBN = '';
        $author = '';
        $publishing_house = '';
        $publication_date = '';
        $version = '';
        $situation = '';
        $pub_price = '';
        $description = '';
        
    }

    // $pic1 = $attr['pic1'];
    // $pic2 = $attr['pic2'];
    


// 這邊是為了資料可以更改

if($_SERVER["REQUEST_METHOD"]=="POST"){
        
        $member_id=$_POST['member_id'];
        
        $function_id=$_POST['function_id'];
        $book_title = $_POST['book_title']; 
        $ISBN = $_POST['ISBN'];
        
        $author = $_POST['author']; 
        $publishing_house = $_POST['publishing_house']; 
        $publication_date = $_POST['publication_date']; 
        $version = $_POST['version'];
        $situation = $_POST['situation'];
        $pub_price = $_POST['pub_price'];
        $description = $_POST['description'];
        // $pic1 = $_POST['pic1']; //
        // $pic2 = $_POST['pic2']; //
        
        

        // 一直無法改到資料庫 因為sql有誤導致，但沒對sql語法防呆所以搞很久
        // 已經可以了
        ////有些不能改，例如跟書book本身有關的 除了ISBN
        $sql="UPDATE book_function SET 
                ISBN = '$ISBN'
                ,situation ='".$situation."'
                ,pub_price ='".$pub_price."'
                ,description = '".$description."' WHERE member_id='$member_id' && function = '刊登' && function_id = '$function_id'";
        
        if ($db -> query($sql) === True){
            
            
            echo "<h2>編輯成功</h2>";
            header("Location:Manage_Sale2 copy.php?member_id=$member_id&function_id=$function_id");
            
			
        }else{
            echo "<h2>編輯失敗</h2>";
            echo mysqli_error($db);
        }
    }
?>


<body>
	<div class="header">
		<div class="logo" src="">Readcycle</div>
		<div class="search">
			<input class="search-bar" type="text" name="search" id="search" placeholder="搜尋">
			<button class="search-btn"><i class="fas fa-search"></i></button>
		</div>
			<div class="publish">刊登</div>
			<div class="request">徵求</div>
			<div class="notification"><i class="fas fa-bell"></i></div>
			<div class="member"><i class="fas fa-user"></i></div>
			<div class="cart"><i class="fas fa-shopping-cart"></i></div>
	</div>
	<div class="banner">
		<img class="banner" src="/Users/ingrid881010/Downloads/image 7.png">
	</div>
	<div class="left">
		<p>書籍管理<br></p>
		<a href=Manage_Sale1.html>刊登管理</a><br>
		<a href="Manage_Require.html">徵求管理</a><br>
		<a href="Manage_Member1.html">會員管理</a><br>
		<a href="Manage_Order.html">訂單查詢</a><br>
		<br>
		書適圈 Readcycle<br>
		<p>
		常見問題<br>
		創辦理念<br>
		商業合作<br>
		聯絡我們<br>
		</p>
	</div>

    <!--以上為首頁邊框-->

    <div>
        <p class="uploadsetting">刊登管理</p>
        <p class="uploadwarning"><img src="exclamation_mark.png" width="22">  刊登須知</p>
        <br><br><br>
        <hr style="border: 1px solid#005889;" align="left">
    </div>
    <div class="image-preview">
        <!--
            <form action="upload.php" method="post" enctype="multipart/form-data" class="upload_image">
            <input type="file" name="file" id="file"/><br/>
            <input type="submit" name="submit" value="上傳檔案"/>
        </form>
        -->
    </div>
    <!-- form 裡面跟書有關的不能動，只能用ISBN讀取 -->
    <div class="bookinfo">
        <form method="post" action="Manage_Sale3 copy.php">
            <p><input type="text" name="book_title" class="text_field" placeholder="輸入完整書名" value="<?php echo $book_title;?>" /></p>
            <p><input type="text" name="ISBN" class="text_field" placeholder="輸入ISBN碼（13碼）" value="<?php echo $ISBN;?>" /></p>
            <p><input type="text" name="author" class="text_field" placeholder="輸入作者" value="<?php echo $author;?>" /></p>
            <p><input type="text" name="publishing_house" class="text_field" placeholder="輸入出版社" value="<?php echo $publishing_house;?>" /></p>
            <p><input type="text" name="publication_date" class="text_field" placeholder="輸入出版日期" value="<?php echo $publication_date;?>" /></p>
            <p><input type="text" name="version" class="text_field" placeholder="輸入版本" value="<?php echo $version;?>" /></p>
            <p><select name="situation" name="Bookcondition" class="select_field" value="<?php echo $situation;?>">
                <option value="0">選擇書本狀況</option>
                <option value="1">全新</option>
                <option value="2">拆封未使用</option>
                <option value="">良好</option>
                <option value="">有使用痕跡</option>
                <option value="">有筆記</option>
                <option value="">有缺頁</option>
                </select>
            </p>
            <p><input type="text" name="pub_price" class="text_field" placeholder="輸入價格" value="<?php echo $pub_price;?>" /></p>
            <p><textarea name="description" class="remark" rows="3" placeholder="輸入備註" ><?php echo $description;?> </textarea></p>
    </div>
    <div>
        <input name="member_id" type="hidden" value="<?php echo $member_id; ?>">
        <input name="function_id" type="hidden" value="<?php echo $function_id; ?>">
        <button type="submit" class="confirm" href="Manage_Sale3 copy.php">確認修改</button>
    </div>
    </form>
</body>
</html>