<?php
//
//產生購物車商品的流水編號
function get_items_num($cart_id)
{
    include("../conn.php");
    
    $sql = "SELECT count('$cart_id') as id FROM cart_d WHERE cart_id = '$cart_id'";

    $res = $db->query($sql);
    $attr = $res->fetch_row();
    $cart_item_num = $cart_id.str_pad(((int)$attr[0] + 1), 2, '0', STR_PAD_LEFT);

    return $cart_item_num;
}

// $cart_id = 'C07170181';
// $x = get_items_num($cart_id);
// echo $x;

//確認function_id是不是已存在於購物車內
function check_fid_in_cart($function_id,$cart_id)
{
    include("../conn.php");
    $sql = "SELECT count(*) FROM cart_d where function_id = '$function_id' && cart_id = '$cart_id' && cart_condition='未結帳'" ;
    $result = $db->query($sql);
    $attr = $result->fetch_row();
    // echo "attr:".$attr[0];
    if ($attr[0] == 0) {
        // if ($attr != 0) {
        //已存在
        return 0;
    } else {
        //不存在
        // echo '以重複';
        return 1;
    }
}
// $function_id = '20200312001';
// $y = check_fid_in_cart($function_id);
// echo $y;

?>