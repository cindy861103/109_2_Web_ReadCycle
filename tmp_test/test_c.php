<?php
// session_start();
include("../conn.php");
// $db = new mysqli('localhost', 'U05153255', 'P05153255', 'readcycle', '3306'); //Cindy

?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
     <meta charset="utf-8" />
     <title>test.php</title>

     <?php
     // if (isset($_POST["search_confirm"])) {
     //      $search_keyword = $_POST["search"];
     //      echo $search_keyword;
     // }
     ?>
</head>

<body>
<?php
     // 書的封面圖:pic1 /bf
     // 刊登編號:function_id /bf
     // 書名:book_title /b
     // 作者:author /b
     // ISBN碼: /b /bf
     // 出版社:publishing_house /b
     // 出版日期:publication_date /b
     // 版本:version /b
     // 書本狀況:situation /bf
     // 刊登者:name /member
     // 定價:pub_price /bf
     // 備註:description /bf
     // 刊登更新時間:pub_update_date  /bf

     // $sql = "SELECT * FROM book_function WHERE user_name` like '%小%' like member_id = '07153104'";
     // "SELECT bf.*, b.* FROM book_function bf LEFT JOIN book b ON bf.ISBN=b.ISBN"
     // $sql = "SELECT bfm.* b.* FROM (SELECT bf.*, m.name FROM book_function bf INNER JOIN member m ON bf.member_id=m.member_id) bfm LEFT JOIN book b ON bfm.ISBN=b.ISBN";
     // $sql = "SELECT b.*,bf.*,m.name FROM book b,book_function bf,member m where bf.ISBN = b.ISBN && bf.member_id= m.member_id";
     // $sql = "SELECT bf.function_id, bf.ISBN, bf.pic1, bf.situation, b.book_title, b.author, bf.pub_price, bf.pub_update_date
     // FROM book b,book_function bf
     // where bf.ISBN = b.ISBN";
     $depart = '日文系';
     $sql = "SELECT bf.function_id, bf.ISBN, bf.class, bf.pic1, bf.situation, b.book_title, b.author, bf.pub_price, bf.pub_create_date FROM book b,book_function bf where bf.ISBN = b.ISBN && class = '$depart' ORDER BY bf.pub_create_date DESC";
     
     // $sql = "SELECT bf.*, m.name FROM book_function bf INNER JOIN member m ON bf.member_id=m.member_id";
     // $sql = "SELECT bf.*, b.* FROM book_function bf LEFT JOIN book b ON bf.ISBN=b.ISBN";
     $result = $db->query($sql);
     // echo $result;

     echo "<table border=1>";
     echo "<tr>";
     while ($meta = mysqli_fetch_field($result))
          echo "<td><small>" . $meta->name . "</small></td>";
     echo "</tr>";
     // 取得欄位數
     $total_fields = mysqli_num_fields($result);
     while ($rows = mysqli_fetch_array($result, MYSQLI_NUM)) {
          echo "<tr>";
          for ($i = 0; $i < $total_fields; $i++)
               echo "<td><small>" . $rows[$i] . "</small></td>";
          echo "</tr>";
     }
     echo "</table>";

     
     // $attr = $result -> fetch_assoc();
     // echo $attr;
?>
     <!-- <form name="header" method="post" action="test.php">
          <div class="header">
               <div class="logo" src="">Readcycle</div>
               <div class="search">
                    <input class="search-bar" type="text" name="search" id="search" placeholder="搜尋">
                    <button class="search-btn" type="submit" name="search_confirm"><i class="fas fa-search"></i></button>
               </div>
               <div class="publish">刊登</div>
               <div class="request">徵求</div>
               <div class="notification"><i class="fas fa-bell"></i></div>
               <div class="member"><i class="fas fa-user"></i></div>
               <div class="cart"><i class="fas fa-shopping-cart"></i></div>
          </div>
     </form> -->
     <?php
     // echo $search_keyword;
     // $sql_1 = "SELECT bf.function_id, bf.ISBN, bf.pic1, bf.situation, b.book_title, b.author, bf.pub_price, bf.pub_update_date FROM book b,book_function bf where bf.ISBN = b.ISBN";

     // $result1 = $db->query($sql_1);
     // $i = 0;
     // $list_arr = array();
     // while ($list = mysqli_fetch_array($result1)) {  //判斷是否還有資料沒有取完，如果取完，則停止while迴圈。
     //      $list_arr[$i] = $list;
     //      $i++;
     // }
     // // print_r($list_arr); //顯示查詢出來資料所組成的二維陣列內容。
     // echo $list_arr[2]['pic1'];


     // foreach ($row as $key => $val){
     //      echo $val[0];
     // }
     // $pub_array = $result1->fetch_assoc();
     // print_r($pub_array);

     // echo $pub_array[0][5];
     // echo $pub_array['pic1']['0'];
     
     ?>
</body>