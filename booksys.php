<?php
//error_reporting(E_ERROR | E_PARSE);
/**
 * Plugin Name: BookSys Camp Management
 * Plugin URI: 
 * Version: 1.0
 * Author: Srdjan Nezic
 * Author URI: 
 */
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

function tohead(){
	//wp_enqueue_style( 'payment', plugin_dir_url( __FILE__ ) . 'payment.css');
}

add_action('wp_enqueue_scripts','tohead');

add_action( 'manage_bookings_posts_custom_column', 'smashing_bookings_column', 10, 2);
add_action( 'manage_packages_posts_custom_column', 'smashing_packages_column', 10, 2);

// Add the custom columns to the book post type:
add_filter( 'manage_bookings_posts_columns', 'set_custom_edit_bookings_columns' );
add_filter( 'manage_packages_posts_columns', 'set_custom_edit_packages_columns' );

function set_custom_edit_bookings_columns($columns) {
    unset($columns['title']);
    $columns['bookid'] = __( 'Book ID', 'your_text_domain' );
    $columns['childname'] = __( 'Childs Packages', 'your_text_domain' );
	  $columns['phone'] = __( 'Phone', 'your_text_domain' );
    $columns['mothername'] = __( 'Mother', 'your_text_domain' );
    $columns['fathername'] = __( 'Father', 'your_text_domain' );
    $columns['email'] = __( 'Email', 'your_text_domain' );
    // $columns['packages'] = __( 'Packages', 'your_text_domain' );
    $columns['totalprice'] = __( 'Total Price', 'your_text_domain' );
    $columns['extras'] = __( 'Extras', 'your_text_domain' );
    $columns['pay_status'] = __( 'Pay Status', 'your_text_domain' );
    $columns['checklist'] = __( 'User checklist', 'your_text_domain' );
    $columns['note'] = __( 'Note', 'your_text_domain' );

    return $columns;
}

function set_custom_edit_packages_columns($columns) {
    unset($columns['taxonomy-extras']);
    $columns['slots'] = __( 'Slots Available', 'your_text_domain' );

    return $columns;
}

function smashing_bookings_column( $column, $post_id ) {
  $meta = get_post_meta( $post_id );
  //var_dump($meta);
  if ( 'bookid' === $column ) {
    //$mothername = get_post_meta(  , 'mothername' , true ); 
    echo '#'.$post_id;
  }
  if ( 'childname' === $column ) {
    $childname = get_post_meta( $post_id , 'childname' , true ); 
   //  foreach($childname as $key=>$child){
		 //  echo $child . '( '. get_post_meta( $post_id , 'bday' , true )[$key] .' ) , ';
	  // }
    $meta = get_post_meta( $post_id , 'childspackages' , true );
    $decoded = json_decode(urldecode($meta));
    if($decoded){
      foreach ($decoded as $child) {
        //var_dump($child);
        echo '<p><b>' . $child->child . ' (' . $child->birthday . ')</b>: ' . $child->package.'</p>'; 
      }
    }
  }
  if ( 'phone' === $column ) {
    $phone = get_post_meta( $post_id , 'phone' , true ); 
    $dial = get_post_meta( $post_id , 'dial' , true ); 

    echo $dial . ' ' . $phone;
  }
  if ( 'mothername' === $column ) {
    $mothername = get_post_meta( $post_id , 'mothername' , true ); 
    echo $mothername;
  }
  if ( 'fathername' === $column ) {
    $fathername = get_post_meta( $post_id , 'fathername' , true ); 
    echo $fathername;
  }
  if ( 'email' === $column ) {
    $fathername = get_post_meta( $post_id , 'email' , true ); 
    echo $fathername;
  }
  if ( 'extras' === $column ) {
    $extras = get_post_meta( $post_id , 'extras' , true );
    $qnt = get_post_meta( $post_id , 'extras_quantity' , true );

    //var_dump($extras);

    $counter = 0;
    foreach($qnt as $key=>$q){
	 	 if($q > 0){
      echo $q.' x ' . $extras[$counter] . '<br/>';
      $counter ++;
	   }
    }
  }
  if ( 'totalprice' === $column ) {
    $price = get_post_meta( $post_id , 'price' , true ); 
    echo $price . '€';
  }
  if( 'pay_status' === $column ){
     $status = get_post_meta( $post_id , 'pay_status' , true ); 
    echo $status;   
  }
  if( 'checklist' === $column ){
    $meta = get_post_meta( $post_id , 'checklist' , true );
    $decoded = json_decode(urldecode($meta));
    if($decoded){
      foreach ($decoded as $child) {
        //var_dump($child);
        echo '<p><b>' . $child->child . ' (' . $child->birthday . ')</b>: ' . $child->checklist.'</p>'; 
      }
    }
  }
  if( 'note' === $column ){
     $note = get_post_meta( $post_id , 'note' , true ); 
    echo $note;   
  }
}

function smashing_packages_column( $column, $post_id ) {
  $meta = get_post_meta( $post_id );
  //var_dump($meta);
  if ( 'slots' === $column ) {
    $slots = get_post_meta($post_id  , 'package_slots' , true ); 
    echo $slots;
  }
}

add_action( 'wp_enqueue_scripts', 'my_custom_script_load' );
function my_custom_script_load(){

  wp_enqueue_style( 'tel-css', plugin_dir_url( __FILE__ ) . 'intl-tel-input-master/build/css/intlTelInput.css', '', rand(9,1000));
  wp_enqueue_script( 'tel-js', plugin_dir_url( __FILE__ ) . 'intl-tel-input-master/build/js/intlTelInput.js', array('jquery'), rand(9,1000));

  wp_enqueue_style( 'booksys-css', plugin_dir_url( __FILE__ ) . '/main.css', '', rand(9,1000));
  wp_enqueue_script( 'booksys-js', plugin_dir_url( __FILE__ ) . '/main.js', array( 'jquery' ), rand(9,1000) );

  wp_enqueue_style( 'fa-css', 'https://use.fontawesome.com/199431e66b.js', '', rand(9,1000));
  

  wp_enqueue_style( 'ui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', '', rand(9,1000));
  wp_enqueue_script( 'ui-js', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array( 'jquery' ), rand(9,1000) );

  wp_enqueue_script( 'grecaptcha', "https://www.google.com/recaptcha/api.js?render=6Lft2v8UAAAAAF96Ojuk0EdfB-0HTm0qY0W9zTCA");
  
}

add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );

include('shortcodes.php');
include('posttypes.php');
include('register.php'); 
