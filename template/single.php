<?php 

if(isset($_GET['bid_id'])){

  global $wpdb;
  $bid_id = $_GET['bid_id'];
  $table_name = $wpdb->prefix . "customsimpletrading";
  $row = $wpdb->get_row( "SELECT * FROM $table_name WHERE id=$bid_id", ARRAY_A );
  if($row){
    $bid_id = $row['id'];
    $pl_amount = $row['pl_amount'];
    $type = $row['type'];
    $stock = $row['stock'];
    $symbol = $row['symbol'];
    $comment = $row['comments'];
    $picture = $row['picture'];
    $chart = $row['chart'];
    $entry_date = $row['entry_date'];
    $entry_date = explode(" ",$entry_date);
    $entry_date = $entry_date[0];
    $exit_date = $row['exit_date'];
    $exit_date = explode(" ",$exit_date);
    $exit_date = $exit_date[0];
    $entry_price = $row['entry_price'];
    $exit_price = $row['exit_price'];
    $strike = $row['strike_price'];
    $expiration_date = $row['expiration_date'];
    $expiration_date = explode(" ",$expiration_date);
    $expiration_date = $expiration_date[0];
    $position_size = $row['position_size'];
    $pl_percentage = $row['pl_percentage'];
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
      }else{
        $pl_amount = floatval($pl_amount) * -1;
      }
    }else{
      if($pl_amount < 0){
        $profit = true;
        $pl_amount = floatval($pl_amount) * -1;
      }
    }
    ?>
    <div class="simple-trading-single-bid">
    <?php
    include plugin_dir_path( __FILE__ ) . './bid.php';
    include plugin_dir_path( __FILE__ ) . './table.php';
    ?>
    <div class="chart-img">
       <img src="<?php echo $chart; ?>" /> 
    </div>
    <div class="picture-img">
       <img src="<?php echo $picture; ?>" /> 
    </div>
    </div>
    <?php
  }else{
    ?>
    <h1 style="text-align:center;margin-top:100px"> 
      404 Bid Not Found.
    </h1>
    <?php
  }

}else{
  ?>
  <h1 style="text-align:center;margin-top:100px"> 
    404 Bid Not Found.
  </h1>
  <?php
}

?>