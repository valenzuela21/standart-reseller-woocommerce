<?php

class options_aditional
{

    function __construct()
    {
        add_action('init', [$this, 'remove_cart']);
        add_action('woocommerce_single_product_summary', [$this, 'add_cart_btnShopping'], 25, 20);
        add_action('woocommerce_before_single_product', [$this, 'shopping_master_reseller'], 5);
        add_action('init', [$this, 'require_field']);
        add_action('woocommerce_order_status_processing', [$this, 'wc_processing_finalizado']);
    }

    public function remove_cart()
    {
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    }

    function require_field()
    {
        require_once plugin_dir_path(__FILE__) . 'upload_image.php';
        require_once plugin_dir_path(__FILE__) . 'upload_image_product.php';
        require_once plugin_dir_path(__FILE__) . '../Api/add_cart/woocommerce_ajax_add_to_cart.php';
    }

    public function shopping_master_reseller()
    {

        $reseller_id = get_post_meta(get_the_ID(), 'meta_reseller_shopping', true);
        $id = $reseller_id;

        if (!empty($id) || $id != "") {

            $args = array(
                'p' => $id[0],
                'post_status' => 'publish',
                'post_type' => 'tienda',
            );

            $consult = get_posts($args);
            $image_id = get_post_meta($id, '_thumbnail_id', true);
            $category = $this->getCategory($id[0]);

            ?>
            <div class="container-reseller">
                <div class="row">
                    <div class="col-4 col-sm-3 col-md-3 col-lg-2 col-xl-2">
                        <?php if ($image_id != false) { ?>
                            <img src="<?php echo wp_get_attachment_url($image_id); ?>"
                                 alt="<?php echo $consult[0]->post_title; ?>"/>
                        <?php } else {
                            echo " <img src='https://via.placeholder.com/250x250' alt='not-image' />";
                        } ?>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <h2 style="margin: 0px"><?php echo $consult[0]->post_title; ?></h2>
                        <?php

                        foreach ($category as $item) {

                            $url = $item['url'];
                            $title = $item['title'];

                            echo '<a href=' . $url . ' >' . $title . '</a>';
                        }
                        ?>

                        <p> <?php echo $consult[0]->post_content; ?> </p>
                        <a href="<?php echo get_permalink($id[0]); ?>"> Ir Tienda </a>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo " ";
        }
    }

    public function add_cart_btnShopping()
    {

        wp_enqueue_style('baseplugin-frontend-buttom-payment');
        wp_enqueue_script('baseplugin-frontend-buttom-payment');

        echo "<div id='vue-frontend-payment-btn'></div>";

    }

    public function getCategory($product_id)
    {
        $categoryGeneral = [];
        $category = get_the_terms($product_id, 'type-tendero');
        foreach ($category as $list) {
            $arrayItem['title'] = $list->name;
            $arrayItem['url'] = get_category_link($list->term_id);
            array_push($categoryGeneral, $arrayItem);
        }
        return $categoryGeneral;
    }

    public function wc_processing_finalizado()
    {
        WC()->session->__unset('id_session');
    }


}

new options_aditional();