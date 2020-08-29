<div class="simple-trading-bid-card">
  <div class='<?php echo $profit ? "profit bid-header" : "loss bid-header"; ?>' >
    <div class="pl-amount">
      <?php echo $profit ? ("$".$pl_amount." Profit") : ("-$".$pl_amount." Loss"); ?>
    </div>
    <div class="stock">
      <?php echo "$symbol $type $stock";  ?>
    </div>
  </div>
  <div class="detail">
    <div class="personal">
      <div class="image">
        <img src="<?php echo $profile_image_url; ?>" />
      </div>
      <div class="content">
        <h5 class="title">
          <?php echo $user_name; ?>
        </h5>
        <p class="comment">
          <?php echo $comment; ?>
        </p>
      </div>
    </div>
    <div class="picture">
      <img src="<?php echo $picture; ?>" />
    </div>
  </div>
  <div class="reactions">
    <span>
      <?php echo $favs; ?> <span class="icon-heart"></span>
    </span>
    <span>
      <?php echo $likes; ?> <span class="icon-like"></span>
    </span>
    <span>
      <?php echo $dislikes; ?> <span class="icon-dislike"></span>
    </span>
  </div>
  <div class="view-btn">
    <a href="https://jabbatrading.com/bid-details/?bid_id=<?php echo $bid_id; ?>"> View </a>
  </div>
</div>