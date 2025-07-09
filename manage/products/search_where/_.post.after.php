<?php
// $id = $this->row['Id'];
// $all = db::all("select * from wb_products_search_where_extid where wb_products_search_where_id='{$id}'");

// if($_POST['wb_products_search_where']){
//     foreach ($_POST['wb_products_search_where'] as $k => $v) {
//         $post[$v['key']] = $v;
//     }
//     // 增、删、改
//     $insert = [];
//     $delete = [];
//     $update = [];
//     foreach ($all as $k => $v) {
//         if(!in_array($v['key'], $post)) {
//             $delete[] = (int)$v['Id'];
//         } else {
//             unset($post[$v['key']]);
//             $update[$v['Id']] = array(
//                 'wb_products_id' => $v['wb_products_id'],
//             );
//         }
//     }
//     // 添加
//     foreach ($post as $k => $v) {
//         $insert[] = array(
//             'wb_products_search_where_id' => $id,
//             'key' => $v['key'],
//             'wb_products_id' => $v['wb_products_id'],
//         );
//     }
//     $delete && db::delete('wb_products_search_where_extid', "Id in(".implode(',', $delete).")" );
//     $update && db::update_bat('wb_products_search_where_extid', 'Id', $update);
//     $insert && db::insert_bat('wb_products_search_where_extid', $insert);
// }