<?php
    function get_random_depart($key_depart)
    {
        $depart_array = array('中文系', '歷史系', '哲學系', '政治系', '社會系', '社工系', '音樂系', '英文系', '日文系', '德文系', '法律系', '巨資系', '數學系', '物理系', '化學系', '微物系', '心理系', '經濟系', '會計系', '企管系', '國貿系', '財精系', '資管系');
        $random_array = $depart_array;
        shuffle($random_array); //隨機排序陣列

        //重建刪除後的陣列元素索引值
        function array_remove(&$random_array, $offset)
        {
            array_splice($random_array, $offset, 1);
        }

        // 判斷特定系所是否在內
        if (($key = array_search($key_depart, $random_array)) !== false) {
            array_remove($random_array, $key); //True--->從隨機陣列中移除
        }else{
            $random_array = $random_array;
        }
        return $random_array;  //回傳本科系以外的特定科系
    }
?>
