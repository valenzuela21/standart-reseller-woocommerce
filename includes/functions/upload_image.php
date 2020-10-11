<?php
/* Add Image Upload to Series Taxonomy */

// Add Upload fields to "Add New Taxonomy" form
function add_series_image_field() {
    // this will add the custom meta field to the add new term page
    $seriesimage = "";
	?>
<div class="form-field">
    <label for="series_image"><?php _e( 'Banner Image:', 'master-tienda' ); ?></label>
    <input type="text" name="series_image[image]" id="series_image[image]" class="series-image"
        value="<?php echo $seriesimage; ?>">
    <input class="upload_image_button button" name="_add_series_image" id="_add_series_image" type="button"
        value="Select/Upload Image" />
    <script>
    jQuery(document).ready(function() {
        jQuery('#_add_series_image').click(function() {
            wp.media.editor.send.attachment = function(props, attachment) {
                jQuery('.series-image').val(attachment.url);
            }
            wp.media.editor.open(this);
            return false;
        });
    });
    </script>
</div>
<?php
}
add_action( 'type-tendero_add_form_fields', 'add_series_image_field', 10, 2 );

// Add Upload fields to "Edit Taxonomy" form
function journey_series_edit_meta_field($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "weekend-series_$t_id" ); ?>

<tr class="form-field">
    <th scope="row" valign="top"><label for="_series_image"><?php _e( 'Banner Image', 'journey' ); ?></label></th>
    <td>
        <?php
				$seriesimage = esc_attr( $term_meta['image'] ) ? esc_attr( $term_meta['image'] ) : ''; 
				?>
        <input type="text" name="series_image[image]" id="series_image[image]" class="series-image"
            value="<?php echo $seriesimage; ?>">
        <input class="upload_image_button button" name="_series_image" id="_series_image" type="button"
            value="Select/Upload Image" />
    </td>
</tr>
<tr class="form-field">
    <th scope="row" valign="top"></th>
    <td style="height: 150px;">
        <style>
        div.img-wrap {
            background: url('http://placehold.it/1350x350') no-repeat center;
            background-size: contain;
            max-width: 450px;
            max-height: 150px;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        div.img-wrap img {
            max-width: 450px;
        }
        </style>
        <div class="img-wrap">
            <img src="<?php echo $seriesimage; ?>" id="series-img">
        </div>
        <script>
        jQuery(document).ready(function() {
            jQuery('#_series_image').click(function() {
                wp.media.editor.send.attachment = function(props, attachment) {
                    jQuery('#series-img').attr("src", attachment.url)
                    jQuery('.series-image').val(attachment.url)
                }
                wp.media.editor.open(this);
                return false;
            });
        });
        </script>
    </td>
</tr>
<?php
}
add_action( 'type-tendero_edit_form_fields', 'journey_series_edit_meta_field', 10, 2 );

// Save Taxonomy Image fields callback function.
function save_series_custom_meta( $term_id ) {
	if ( isset( $_POST['series_image'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "weekend-series_$t_id" );
		$cat_keys = array_keys( $_POST['series_image'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['series_image'][$key] ) ) {
				$term_meta[$key] = $_POST['series_image'][$key];
			}
		}
		// Save the option array.
		update_option( "weekend-series_$t_id", $term_meta );
	}
}  
add_action( 'edited_type-tendero', 'save_series_custom_meta', 10, 2 );  
add_action( 'create_type-tendero', 'save_series_custom_meta', 10, 2 );