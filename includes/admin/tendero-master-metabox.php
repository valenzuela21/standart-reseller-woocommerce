<?php
if (!defined('ABSPATH')) exit;
class tendero_master_metabox{

    function __construct()
    {
        add_action('cmb2_admin_init', array($this, 'product_add_metaboxes'));
    }

    public function product_add_metaboxes(){
        $prefix = "input_options_product_";

        $metabox_events = new_cmb2_box(array(
            "id" => $prefix . "metabox_tendero",
            "title" => __("Opciones Envio", "cmb2"),
            "object_types" => array("tienda")
        ));


        $metabox_events->add_field( array(
            'name' => __("Envio Gratis", "cmb2"),
            'desc' => __("Seleccione si el envio es gratis.", "cmb2"),
            'id'   => $prefix . "free",
            'type' => 'checkbox',
        ) );


        $metabox_events->add_field( array(
            'name'    => 'Valor Minimo',
            'desc'    =>  __( 'Ingresa el precio minimo de envio.', 'cmb2' ),
            'default' =>  '',
            'id'      =>  $prefix . 'pressing_fixed_tendero',
            'type'    => 'text_small',
        ) );


        $metabox_events->add_field( array(
            'name'    => __("Valor Envio Por Km", "cmb2"),
            'desc'    => __("Ingrese el valor del envio por 1Km. Ejemplo: 300", "cmb2"),
            'default' => __("", "cmb2"),
            "id" => $prefix . "presing_send",
            'type'    => 'text_small'
        ) );
    }


}
new tendero_master_metabox();
