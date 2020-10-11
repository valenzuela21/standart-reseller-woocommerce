<?php
include(dirname(__FILE__) . "/load.php");

class  delete_item_product_reseller
{

    public function delete_item()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $id_reseller = $data['id_reseller'];
        $id_post = $data['id_post'];

        $consult = get_post_meta($id_post, 'meta_reseller_shopping', true);
        $key = array_keys($consult, $id_reseller);

        unset($consult[$key[0]]);

        $newConsult = array_values($consult);

        update_post_meta($id_post, 'meta_reseller_shopping', $newConsult);


    }

}
$app = new delete_item_product_reseller();
$app->delete_item();
