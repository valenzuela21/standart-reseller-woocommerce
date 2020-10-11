<?php
include(dirname(__FILE__) . "/load.php");

class consult_shopping_success
{

    public function consultShopping()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $id_post = get_post_meta($id, 'meta_reseller_shopping', true);

        $args = array('post_type' => 'tienda', 'posts_per_page' => -1);

        $query = get_posts($args);
        $arrayGeneral = [];
        foreach ($query as $item) {
            $id_general = $item->ID;

            if (in_array($id_general, $id_post)) {
                $arrayItem['id'] = $item->ID;
                $arrayItem['title'] = $item->post_title;

                array_push($arrayGeneral, $arrayItem);

            }

        }

        header("Content-type: application/json");
        echo json_encode(array_reverse($arrayGeneral));
        die();

    }


}

$app = new consult_shopping_success();
$app->consultShopping();
