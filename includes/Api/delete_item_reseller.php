<?php
include(dirname(__FILE__) . "/load.php");
class delete_item_reseller{

    public function deleteItem(){
        $data = json_decode(file_get_contents("php://input"), true);
        $id_post =  $data['id_post'];
        $id = $data['id'];

        $consult = get_post_meta($id, 'meta_reseller_shopping', true);
        $key = array_keys($consult, $id_post);

        unset($consult[$key[0]]);

        $newConsult = array_values($consult);

        update_post_meta($id, 'meta_reseller_shopping', $newConsult);

    }


}
$app=new delete_item_reseller();
$app->deleteItem();
