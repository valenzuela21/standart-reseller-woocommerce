<?php
include(dirname(__FILE__) . "/load.php");

class insert_new_reseller
{

    public function insertReseller()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $id_reseller = $data['id_reseller'];
        $consult = get_post_meta($id, 'meta_reseller_shopping', true);

        if (!empty($consult) && !$consult == NULL && !$consult == "") {
            if (is_array($consult)) {
                if (!in_array($id_reseller, $consult)) {
                    $arrayData = array_merge((array)$id_reseller, $consult);
                } else {
                    $arrayData = $consult;
                }

                update_post_meta($id, 'meta_reseller_shopping', $arrayData);
            }

        } else {
            update_post_meta($id, 'meta_reseller_shopping', (array)$id_reseller);
        }


    }

}

$app = new insert_new_reseller();
$app->insertReseller();
