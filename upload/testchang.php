<?php 
     include("conn.php");
     $member_id = '07153104';
     
     $sql="UPDATE member SET member_id ='$member_id'
               ,depart ='depart2'
               ,name ='name2'
               
               WHERE member_id='$member_id' ";

     if ($db -> query($sql) === True){
          echo "<h2>編輯成功</h2>";
          header("Manage_Member1 copy.php");
     }else{
          echo "<h2>編輯失敗</h2>";
          echo $member_id."/".$depart;
     }

?>