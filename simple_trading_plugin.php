<?php

/**
 * Plugin Name: SIMPLE TRADING
 * Description: handle the basic trading with the plugin
 * Version:           1.0
 * Author: Muhammad Arslan
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP:      5.2
 */

/*
SIMPLE TRADING is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
SIMPLE TRADING is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with SIMPLE TRADING. If not, see  https://www.gnu.org/licenses/gpl-2.0.html
*/


// To display error message
function display_error_message($msg){
  $error = $msg;
  include plugin_dir_path( __FILE__ ) . './template/error.php';
}

function simple_trading_create_tables(){
  
  global $wpdb;
  $table_name = $wpdb->prefix . "customsimpletrading";
  $charset_collate = $wpdb->get_charset_collate();
  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    symbol text,
    chart text, 
    entry_date datetime DEFAULT '0000-00-00 00:00:00',
    exit_date datetime DEFAULT '0000-00-00 00:00:00',
    entry_price float,
    exit_price float,
    type varchar(10),
    stock varchar(20),
    pl_amount float,
    pl_percentage varchar(5),
    strike_price float,
    expiration_date datetime, 
    picture text,
    position_size varchar(20),
    comments longtext,
    userid mediumint(9),
    PRIMARY KEY  (id)
  ) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

}

register_activation_hook( __FILE__, 'simple_trading_create_tables' );

function simple_trading_deactivation(){
  remove_shortcode('render_simple_trading_form');
  remove_shortcode('simple_trading_current');
  remove_shortcode( 'simple_trading_by_id' );
  remove_shortcode('simple_trading_all');
  wp_dequeue_style( 'simple_trading' );
}

register_deactivation_hook( __FILE__, 'simple_trading_deactivation' );

add_shortcode('render_simple_trading_form', 'load_trading_form');

function load_trading_form(){
  
  if(is_user_logged_in()){
    
    global $wpdb;
    $table_name = $wpdb->prefix . "customsimpletrading";
    wp_enqueue_style('simple_trading',plugins_url() . '/simple-trading/assets/css/simple_trading.css');
    if(isset($_POST['stf_submit'])){
      $_symbol = sanitize_text_field($_POST['symbol']);
      $_entry_date = sanitize_text_field($_POST['entry_date']);
      $_exit_date = sanitize_text_field($_POST['exit_date']);
      $_entry_price = sanitize_text_field($_POST['entry_price']);
      $_exit_price = sanitize_text_field($_POST['exit_price']);
      $_position_size = sanitize_text_field($_POST['position_size']);
      $_type = sanitize_text_field($_POST['type']);
      $_stock = sanitize_text_field($_POST['stock']);
      $_comments = sanitize_text_field($_POST['comments']);
      $_strike_price = sanitize_text_field($_POST['strike_price']);
      $_expiration_date = sanitize_text_field($_POST['expiration_date']);
      $_chart = $_FILES['chart'];
      $_picture = $_FILES['picture'];
      if( !empty($_symbol) && !empty($_entry_date) && !empty($_exit_date) && !empty($_entry_price) && !empty($_exit_price) && !empty($_position_size) && !empty($_type) && !empty($_stock) && !empty($_comments) && !empty($_strike_price) && !empty($_expiration_date) && !empty($_chart) && !empty($_picture) && is_numeric($_entry_price) && is_numeric($_exit_price) && is_numeric($_strike_price) ){
        $uploadchart = wp_upload_bits($_chart["name"], null, file_get_contents($_chart["tmp_name"]));
        $uploadpicture = wp_upload_bits($_picture["name"], null, file_get_contents($_picture["tmp_name"]));
        if(empty($uploadchart['error']) && empty($uploadpicture['error'])){
          $_chart_url = $uploadchart['url'];
          $_picture_url = $uploadpicture['url'];
          $_entry_price = (float)$_entry_price;
          $_exit_price = (float)$_exit_price;
          $_strike_price = (float)$_strike_price;
          $_pl_amount = $_exit_price - $_entry_price;
          $_pl_percentage = 1.0;
          $_pl_percentage = round(($_pl_amount/$_entry_price)*100,2);
          if($_pl_amount < 0){
            $_pl_percentage = $_pl_percentage * -1;
          }
          $_pl_percentage = strval($_pl_percentage) . "%";
          $result = $wpdb->query(
            $wpdb->prepare(
              "
              INSERT INTO $table_name
              (symbol, chart, entry_date, exit_date, entry_price, exit_price, type, stock, pl_amount, pl_percentage, strike_price, expiration_date, picture, position_size, comments, userid)
              VALUES ( %s, %s, %s, %s, %f, %f, %s, %s, %f, %s, %f, %s, %s, %s, %s, %d )
              ",
              array(
                $_symbol,
                $_chart_url,
                $_entry_date,
                  $_exit_date,
                  $_entry_price,
                  $_exit_price,
                  $_type,
                  $_stock,
                  $_pl_amount,
                  $_pl_percentage,
                  $_strike_price,
                  $_expiration_date,
                  $_picture_url,
                  $_position_size,
                  $_comments,
                  get_current_user_id(),
               )
            )
          );
          if($result != 0 && $result != false){
            $success = 'Your form has been saved.';
            include plugin_dir_path( __FILE__ ) . './template/success.php';
          }else{
            display_error_message('ops! Something went wrong. Try again in a while.');
          }
          $wpdb->flush();
        }else{
          display_error_message('Oops! Something went wrong while uploading the files.');
        }
      }else{
        display_error_message('Some fields are missing or incorrect!');
      }
    }
    include plugin_dir_path( __FILE__ ) . './template/form.php';

  }else{
    auth_redirect();
  }

}

add_shortcode('simple_trading_current', 'load_current_user_bids');

function load_current_user_bids(){
  if(is_user_logged_in()){
    global $wpdb;
    $table_name = $wpdb->prefix . "customsimpletrading";
    $userid = get_current_user_id();
    $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE userid=$userid ", ARRAY_A );
    if($wpdb->num_rows > 0){
      wp_enqueue_style('simple_trading',plugins_url() . '/simple-trading/assets/css/st_bid_card.css');
      foreach ($results as $row) {
        $bid_id = $row['id'];
        $pl_amount = $row['pl_amount'];
        $type = $row['type'];
        $stock = $row['stock'];
        $symbol = $row['symbol'];
        $comment = $row['comments'];
        $pciture = $row['picture'];
        $profit = false;
        $userid = $row['userid'];
        $user = get_user_by( 'ID', (int)$userid );
        $user_name = "";
        $profile_image_url = get_avatar_url( (int)$userid );
        if(!empty($user)){
          $user_name = $user->display_name;
        }
        $favs = 0;
        $likes = 0;
        $dislikes = 0;
        if($type == "long"){
          if($pl_amount > 0){
            $profit = true;
          }
        }else{
          if($pl_amount < 0){
            $profit = true;
          }
        }
        include plugin_dir_path( __FILE__ ) . './template/bid.php';
      }
    }else{
      ?>
      <h2>
        Nothing added yet.
      </h2>
      <?php
    }

  }else{
    auth_redirect();
  }
  $wpdb->flush();
}

add_shortcode('simple_trading_all', 'load_all_users_bids');

function load_all_users_bids(){
  global $wpdb;
  $table_name = $wpdb->prefix . "customsimpletrading";
  $results = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );
  if($wpdb->num_rows > 0){
    wp_enqueue_style('simple_trading',plugins_url() . '/simple-trading/assets/css/st_bid_card.css');
    foreach ($results as $row) {
      $bid_id = $row['id'];
      $pl_amount = $row['pl_amount'];
      $type = $row['type'];
      $stock = $row['stock'];
      $symbol = $row['symbol'];
      $comment = $row['comments'];
      $picture = $row['picture'];
      $profit = false;
      $userid = $row['userid'];
      $user = get_user_by( 'ID', (int)$userid );
      $user_name = "";
      $profile_image_url = get_avatar_url( (int)$userid );
      if(!empty($user)){
        $user_name = $user->display_name;
      }
      $favs = 0;
      $likes = 0;
      $dislikes = 0;
      if($type == "long"){
        if($pl_amount > 0){
          $profit = true;
        }
      }else{
        if($pl_amount < 0){
          $profit = true;
        }
      }
      include plugin_dir_path( __FILE__ ) . './template/bid.php';
    }
  }else{
    ?>
    <h2>
      Nothing added yet.
    </h2>
    <?php
  }
  
  $wpdb->flush();
}

add_shortcode('simple_trading_by_id', 'load_bid_by_id');
function load_bid_by_id(){
  wp_enqueue_style('simple_trading',plugins_url() . '/simple-trading/assets/css/st_bid_card.css');
  include plugin_dir_path( __FILE__ ) . './template/single.php';
}

?>