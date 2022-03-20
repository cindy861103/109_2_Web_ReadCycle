<input >
<?php
    include("../php/select_array.php");
    // $sql = "SELECT bf.function_id, bf.ISBN, bf.pic1, bf.situation, b.book_title, b.author, bf.pub_price, bf.pub_update_date FROM book b,book_function bf where bf.ISBN = b.ISBN LIMIT 9";
    // $arr = get_table_array($sql);
    // print_r($arr);
    $sql = "SELECT bf.function_id, bf.ISBN, bf.pic1, bf.situation, b.book_title, b.author, bf.pub_price, bf.pub_update_date FROM book b,book_function bf where bf.ISBN = b.ISBN ORDER BY bf.pub_update_date DESC LIMIT 9";
    $arr = get_table_array($sql);
    $d = $arr[3]['pub_update_date'];
    // $fd = date("Y-m-d", $d);
    $sd = substr($d, 0, 10);
    echo $sd;
    
?>


<?php

?>
