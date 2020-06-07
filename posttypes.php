<?php

function create_posttypes() {
 
    register_post_type( 'bookings',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Bookings' ),
                'singular_name' => __( 'Booking' ),
                'add_new_item' =>  __('Add new Booking'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'bookings'),
        )
    );

    register_post_type( 'packages',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Packages' ),
                'singular_name' => __( 'Package' ),
                'add_new_item' =>  __('Add new Package'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'packages'),
            'taxonomies'        => array('extras'),
        )
    );
	
    register_post_type( 'athletes',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Athletes' ),
                'singular_name' => __( 'Athlete' ),
                'add_new_item' =>  __('Add new Athlete'),
                'edit_item' =>  __('Edit Athlete'),

            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'athletes')
        )
    );


   $post_type = 'athletes';
   remove_post_type_support( $post_type, 'editor');

}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttypes' );

function wpb_change_title_text( $title ){
     $screen = get_current_screen();
  
     if  ( 'athletes' == $screen->post_type ) {
          $title = 'Name';
     }
  
     return $title;
}
  
add_filter( 'enter_title_here', 'wpb_change_title_text' );

function srdjan_prices_metabox() {
    add_meta_box( 
        'srdjan_prices_metabox', 
        __( 'Package Price', 'package_price'), 
        'srdjan_prices_metabox_callback', 
        'packages', 
        'normal', 
        'default'
    );
}
add_action( 'add_meta_boxes', 'srdjan_prices_metabox' );

function srdjan_slots_metabox() {
    add_meta_box( 
        'srdjan_slots_metabox', 
        __( 'Available Slots', 'package_slots'), 
        'srdjan_slots_metabox_callback', 
        'packages', 
        'normal', 
        'default'
    );
}
add_action( 'add_meta_boxes', 'srdjan_slots_metabox' );

function srdjan_id_metabox() {
    add_meta_box( 
        'srdjan_id_metabox', 
        __( 'Athlete Info', 'athlete_id'), 
        'srdjan_id_metabox_callback', 
        'athletes', 
        'normal', 
        'default'
    );
}
add_action( 'add_meta_boxes', 'srdjan_id_metabox' );

function srdjan_paystatus_metabox() {
    add_meta_box( 
        'srdjan_paystatus_metabox', 
        __( 'Pay Status', 'pay_status'), 
        'srdjan_paystatus_metabox_callback', 
        'bookings', 
        'normal', 
        'default'
    );
}
add_action( 'add_meta_boxes', 'srdjan_paystatus_metabox' );

function srdjan_paystatus_metabox_callback( $post ) { 

wp_nonce_field( 'srdjan_paystatus_metabox_nonce', 'srdjan_paystatus_nonce' ); ?>

  <?php         
    $status   = get_post_meta( $post->ID, 'pay_status', true );
  ?>

  <p>
  <label for="pay_status"><?php _e('Pay Status', 'kvkoolitus' ); ?></label><br/> 
  <input type="text" class="widefat" name="pay_status" value="<?php echo esc_attr( $status ); ?>" />
  </p>    

<?php }


function srdjan_prices_metabox_callback( $post ) { 

wp_nonce_field( 'srdjan_prices_metabox_nonce', 'srdjan_prices_nonce' ); ?>

  <?php         
    $price   = get_post_meta( $post->ID, 'package_price', true );
  ?>

  <p>
  <label for="package_price"><?php _e('Price', 'kvkoolitus' ); ?></label><br/> 
  <input type="text" class="widefat" name="package_price" value="<?php echo esc_attr( $price ); ?>" />
  </p>    

<?php }

function srdjan_slots_metabox_callback( $post ) { 

wp_nonce_field( 'srdjan_slots_metabox_nonce', 'srdjan_slots_nonce' ); ?>

  <?php         
    $slots   = get_post_meta( $post->ID, 'package_slots', true );
  ?>

  <p>
  <label for="package_slots"><?php _e('Available Slots', 'kvkoolitus' ); ?></label><br/> 
  <input type="text" class="widefat" name="package_slots" value="<?php echo esc_attr( $slots ); ?>" />
  </p>    

<?php }

function srdjan_id_metabox_callback( $post ) { 

wp_nonce_field( 'srdjan_id_metabox_nonce', 'srdjan_id_nonce' ); ?>

  <?php         
    $id   = get_post_meta( $post->ID, 'athlete_id', true );
    $phone   = get_post_meta( $post->ID, 'athlete_phone', true );
    $address   = get_post_meta( $post->ID, 'athlete_address', true );
    $bday   = get_post_meta( $post->ID, 'athlete_bday', true );
  ?>

  <p>
  <label for="athlete_id"><?php _e('ID', 'kvkoolitus' ); ?></label><br/> 
  <input type="text" class="widefat" name="athlete_id" value="<?php echo esc_attr( $id ); ?>" />
  </p>    

  <p>
  <label for="athlete_phone"><?php _e('Phone', 'kvkoolitus' ); ?></label><br/> 
  <input type="text" class="widefat" name="athlete_phone" value="<?php echo esc_attr( $phone ); ?>" />
  </p>  

  <p>
  <label for="athlete_address"><?php _e('Address', 'kvkoolitus' ); ?></label><br/> 
  <input type="text" class="widefat" name="athlete_address" value="<?php echo esc_attr( $address ); ?>" />
  </p>  

  <p>
  <label for="athlete_bday"><?php _e('Date of birth', 'kvkoolitus' ); ?></label><br/> 
  <input type="date" class="widefat" name="athlete_bday" value="<?php echo esc_attr( $bday ); ?>" />
  </p>  

<?php }

function srdjan_paystatus_save_meta( $post_id ) {

  if( !isset( $_POST['srdjan_paystatus_nonce'] ) || !wp_verify_nonce( $_POST['srdjan_paystatus_nonce'],'srdjan_paystatus_metabox_nonce') ) 
    return;

  if ( !current_user_can( 'edit_post', $post_id ))
    return;

  if ( isset($_POST['pay_status']) ) {        
    update_post_meta($post_id, 'pay_status', sanitize_text_field($_POST['pay_status']));      
  }

}
add_action('save_post', 'srdjan_paystatus_save_meta');

function srdjan_prices_save_meta( $post_id ) {

  if( !isset( $_POST['srdjan_prices_nonce'] ) || !wp_verify_nonce( $_POST['srdjan_prices_nonce'],'srdjan_prices_metabox_nonce') ) 
    return;

  if ( !current_user_can( 'edit_post', $post_id ))
    return;

  if ( isset($_POST['package_price']) ) {        
    update_post_meta($post_id, 'package_price', sanitize_text_field($_POST['package_price']));      
  }

}
add_action('save_post', 'srdjan_prices_save_meta');

function srdjan_slots_save_meta( $post_id ) {

  if( !isset( $_POST['srdjan_slots_nonce'] ) || !wp_verify_nonce( $_POST['srdjan_slots_nonce'],'srdjan_slots_metabox_nonce') ) 
    return;

  if ( !current_user_can( 'edit_post', $post_id ))
    return;

  if ( isset($_POST['package_slots']) ) {        
    update_post_meta($post_id, 'package_slots', sanitize_text_field($_POST['package_slots']));      
  }

}
add_action('save_post', 'srdjan_slots_save_meta');

function srdjan_id_save_meta( $post_id ) {

  if( !isset( $_POST['srdjan_id_nonce'] ) || !wp_verify_nonce( $_POST['srdjan_id_nonce'],'srdjan_id_metabox_nonce') ) 
    return;

  if ( !current_user_can( 'edit_post', $post_id ))
    return;

  if ( isset($_POST['athlete_id']) ) {        
    update_post_meta($post_id, 'athlete_id', sanitize_text_field($_POST['athlete_id']));      
  }

  if ( isset($_POST['athlete_phone']) ) {        
    update_post_meta($post_id, 'athlete_phone', sanitize_text_field($_POST['athlete_phone']));      
  }

  if ( isset($_POST['athlete_address']) ) {        
    update_post_meta($post_id, 'athlete_address', sanitize_text_field($_POST['athlete_address']));      
  }

  if ( isset($_POST['athlete_bday']) ) {        
    update_post_meta($post_id, 'athlete_bday', sanitize_text_field($_POST['athlete_bday']));      
  }

}
add_action('save_post', 'srdjan_id_save_meta');

add_action( 'init', 'crunchify_create_deals_custom_taxonomy', 0 );
 
//create a custom taxonomy name it "type" for your posts
function crunchify_create_deals_custom_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Extras', 'taxonomy general name' ),
    'singular_name' => _x( 'Extra', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Extra' ),
    'all_items' => __( 'All Extras' ),
    'parent_item' => __( 'Parent Type' ),
    'parent_item_colon' => __( 'Parent Type:' ),
    'edit_item' => __( 'Edit Type' ), 
    'update_item' => __( 'Update Type' ),
    'add_new_item' => __( 'Add New Type' ),
    'new_item_name' => __( 'New Type Name' ),
    'menu_name' => __( 'Extras' ),
  );  
 
  register_taxonomy('extras',array('packages'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'extra' ),
  ));
}

function mj_taxonomy_add_custom_meta_field() {
        ?>
        <div class="form-field">
            <label for="term_meta[price_term_meta]"><?php _e( 'Price', 'MJ' ); ?></label>
            <input type="text" name="term_meta[price_term_meta]" id="term_meta[price_term_meta]" value="">
        </div>
    <?php
    }
add_action( 'extras_add_form_fields', 'mj_taxonomy_add_custom_meta_field', 10, 2 );


function mj_taxonomy_edit_custom_meta_field($term) {

    $t_id = $term->term_id;
	
    $term_meta = get_option( "taxonomy_$t_id" ); 
   ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[price_term_meta]"><?php _e( 'Price', 'MJ' ); ?></label></th>
        <td>
            <input type="text" name="term_meta[price_term_meta]" id="term_meta[price_term_meta]" value="<?php echo esc_attr( $term_meta['price_term_meta'] ) ? esc_attr( $term_meta['price_term_meta'] ) : ''; ?>">
        </td>
    </tr>
<?php
}

add_action( 'extras_edit_form_fields','mj_taxonomy_edit_custom_meta_field', 10, 2 );

function mj_save_taxonomy_custom_meta_field( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {

        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }

}  
add_action( 'edited_extras', 'mj_save_taxonomy_custom_meta_field', 10, 2 );  
add_action( 'create_extras', 'mj_save_taxonomy_custom_meta_field', 10, 2 );