<?php
	include ("../conn.php");
	session_start(); // session啟動
	ini_set('display_errors', 0); // 錯誤訊息關掉
	if (isset($_SESSION["memberid"])){
		$memberid = $_SESSION['memberid'];
        $level = $_SESSION['level'] ;
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理徵求2</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Manage_Require2_style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
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
	WHERE member_id = '$memberid' && function = '徵求' && function_id = '$function_id'
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
        $pic1 = $attr['pic1'];
        $pic2 = $attr['pic2'];
}else{
        
    }

    
    


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
        // $pic1 = $_POST['pic1']; //徵求不用改圖
        // $pic2 = $_POST['pic2']; //
        
        

        $sql="UPDATE book_function SET 
                ISBN = '$ISBN'
                ,situation ='".$situation."'
                ,pub_price ='".$pub_price."'
                ,description = '".$description."' WHERE member_id='$member_id' && function = '徵求' && function_id = '$function_id'";
        
        if ($db -> query($sql) === True){
            echo "<h2>編輯成功</h2>";
            header("Location:Manage_Require1.php?member_id=$member_id");
        }else{
            echo "<h2>編輯失敗</h2>";

            // header("Location:Manage_Require2.php?member_id=$member_id&function_id=$function_id");
        }
    }
?>
<body>
    <!--以下是上方的header-->
    <form name="search" method="post" action="aftersearch.php">
        <div class="header">
            <div class="logo"><a href="../php/home.php?<?php echo "member_id=" . $memberid . "&depart=" . $depart; ?>">Readcycle</a></div>
            <div class="search">
                <input class="search-bar" type="text" name="search" id="search" placeholder="搜尋">
                <button type="submit" class="search-btn" name="search_confirm"><i class="fas fa-search"></i></button>
            </div>
            <div class="publish"><a href="../php/Sale_Book1.php">刊登</a></div>
            <div class="request"><a href="../php/Request_Book1.php">徵求</a></div>
            <div class="notification">
                <div class="popover__title">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="popover__content">
                    <p class="popover__message">最新通知<br>(現正建置中...)</p>
                </div>
            </div>
            <div class="member">
                <div class="popover__title">
                    <i class="fas fa-user"></i>
                </div>
                <div class="popover__content">
                    <div class="popover__message">
                        <a href="../html/Log_In.html">登入</a><br>
                        <a href="../php/Manage_Sell1.php">刊登管理</a><br>
                        <a href="../php/Manage_Require1.php">徵求管理</a><br>
                        <a href="../php/Manage_Member1.php">會員管理</a><br>
                        <a href="../php/Manage_Order.php">訂單查詢</a>
                        <a href="../php/Log_Out.php">登出</a><br>
                    </div>>
                </div>
            </div>
            <div class="cart"><a href="../php/Cart.php"><i class="fas fa-shopping-cart"></i></a></div>
        </div>
    </form>

    <div class="left">
        <p>書籍管理<br></p>
        <a href="Manage_Sell1.php">刊登管理</a><br>
        <a href="Manage_Require1.php">徵求管理</a><br>
        <a href="Manage_Member1.php">會員管理</a><br>
        <a href="Manage_Order.php">購買紀錄</a><br>
        <?php if($level == 0){
        ?>
        <a href="Manage_Backstage1.php">後臺審核</a><br>
        <a href="Membership.php">會籍資料</a><br>
        <?php
        }
        ?>
        <br><br>
        <div class="information">
            <p>書適圈 Readcycle</p>
            <a href="../php/information.php#AboutUs">創辦理念</a><br>
            <a href="../php/information.php#FAQ">常見問題</a><br>
            <a href="../php/information.php#Contact">聯絡我們</a><br>
            <a href="../php/information.php#Cooperation">商業合作</a>
        </div>
        <br>
        <img src="../index_img/Readcycle_logo.png">
    </div>

    <!--以上為首頁邊框-->

    <div>
        <p class="uploadsetting">徵求管理</p>
        <br><br><br><br>
        <hr style="border: 1px solid#005889;" align="left">
    </div>
    
    
    <!-- 照片展現 -->
    <div>
        <img src="../img/<?php echo $attr['pic1']; ?> "alt="Image" class="image-preview">
    </div>
    <!-- form 裡面跟書有關的不能動，只能用ISBN讀取 -->
    <div class="bookinfo">
        <form method="post" action="Manage_Require2.php">
            <p><input type="text" name="book_title" class="text_field" placeholder="輸入完整書名" value="<?php echo $book_title;?>" /></p>
            <p><input type="text" name="ISBN" class="text_field" placeholder="輸入ISBN碼（13碼）" value="<?php echo $ISBN;?>" /></p>
            <p><input type="text" name="author" class="text_field" placeholder="輸入作者" value="<?php echo $author;?>" /></p>
            <p><input type="text" name="publishing_house" class="text_field" placeholder="輸入出版社" value="<?php echo $publishing_house;?>" /></p>
            <p><input type="text" name="publication_date" class="text_field" placeholder="輸入出版日期" value="<?php echo $publication_date;?>" /></p>
            <!--無法配對到版本 <p><input type="text" name="version" class="text_field" placeholder="輸入版本" value="<?php echo $version;?>" /></p>  -->
            <p><select name="situation" name="Bookcondition" class="select_field" >
            <!-- value="<?php echo $situation;?>"     -->
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
        <button type="submit" class="confirm" href="Manage_Require2.php">確認修改</button>
        <!-- 用一個del.php  -->
    </div>
    </form>


    <script type='text/javascript' src='../jquery-3.6.0.js'></script>
    <script type='text/javascript' src='../home.js'></script>
    <script type='text/javascript' src='../bootstrap-3.3.7-dist/js/bootstrap.min.js'></script>
    
</body>
</html>