<!-- 刊登管理2: 用session掌握登入
每一本書不同頁：用memberid & book_func_id 去對地方

-->

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
    <title>管理刊登2</title>
</head>
<?php
}else{
	echo "請先登入!";
	header('Refresh:2;Log_In.html');   
	exit();
}
// 拿到資料
if($_SERVER["REQUEST_METHOD"]=="GET" ){
    
    $member_id=$_GET['member_id'];
    $function_id=$_GET['function_id'];

    $sql = "SELECT book_function.* ,book.* FROM book_function ,book 
	WHERE member_id = '$memberid' && function = '刊登' && function_id = '$function_id'
	&& book.ISBN = book_function.ISBN";
// 拿重要的ＳＥＬＥＣＴ去定義變數
	$result= $db -> query($sql);
	$attr = $result -> fetch_assoc();
    // echo mysqli_error($db);
    //需要拿的變數
    // $book_title = $attr['book_title'];
    // $ISBN = $attr['ISBN'];
    // $author = $attr['author'];
    // $publishing_house = $attr['publishing_house'];
    // $publication_date = $attr['publication_date'];
    // $version = $attr['version'];
    // $situation = $attr['situation'];
    // $pub_price = $attr['pub_price'];
    // $description = $attr['description'];
}else{
    
    echo "沒拿到誒";
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
?>
<body>
    <body>
        <link rel="stylesheet" href="css/Manage_Sale2_style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <script type='text/javascript' src='../home.js'></script>
    </head>
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
        <div class="image-preview"></div>
        <br><br><br><br><br>
        <div class="bookinfo">
            書名 : <?php echo $attr['book_title'];?><br>
            ISBN : <?php echo $attr['ISBN'];?><br>
            作者 : <?php echo $attr['author'];?><br>
            出版社 : <?php echo $attr['publishing_house'];?><br>
            出版日期 : <?php echo $attr['publication_date'];?><br>
            版本 : <?php echo $attr['version'];?><br>
            書本狀況 : <?php echo $attr['situation'];?><br>
            定價 : <?php echo $attr['pub_price'];?><br>
            備註 : <?php echo $attr['description'];?><br>
            狀態 : <?php echo $attr['book_condition'];?><br>
        
        <?php 
        // 是否有人購買之類的
        // 之後記得要串 購買人的資訊 
        if(TRUE){
            echo "<h1>尚無人購買</h1>";
        }else{
            // $sql ;
        ?>
        </div>
        <table class="order" width="800">
            <tr>
                <td>訂單編號</td>
                <td>購買人</td>
                <td>聯絡電話</td>
                <td>Email</td>
            </tr>
            <tr>
            <!-- 之後要接購買人 -->
                <td>07134562</td> 
                <td>林衣珊</td>
                <td>0934526738</td>
                <td>07134562@gm.scu.edu.tw</td>
            </tr>
        </table>
        <?php 
        }
        ?>
</body>
</html>