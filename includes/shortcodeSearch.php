<?php

class shortcodeSearch
{

    function __construct()
    {
        // Shortcode: [search-product-master]
        add_shortcode('search-product-master', [$this, 'searchProduct']);
    }

    public function searchProduct()
    {
        echo "
            <div>
              <form action='".home_url( '/' )."' method='get' style='height: 45px;' >
                <input type='text' style='border: 1px solid #f5c155; border-radius: 30px; color: #645858;' placeholder='Buscar Producto...' name='s' />
                <input type='submit' style='position: absolute; right: 0px; border-radius: 0px 20px 0px 20px;' value='Buscar' />
              </form>
             </div>";
    }


}

new shortcodeSearch();
