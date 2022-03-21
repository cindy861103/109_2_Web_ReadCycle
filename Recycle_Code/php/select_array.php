<?php
    function get_table_array($sql){
        include("../conn.php"); 
        $pub_array = $db->query($sql);
        $array_item = 0;
        $pub_arr_home = array();
        while ($list = mysqli_fetch_array($pub_array)) {  //判斷是否還有資料沒有取完，如果取完，則停止while迴圈。
            $pub_arr_home[$array_item] = $list;
            $array_item++;
        }
        return $pub_arr_home;
    }
?>