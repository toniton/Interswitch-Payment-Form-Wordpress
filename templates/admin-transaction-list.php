<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div class="wrap">
  <h2>Interswitch Transactions</h2>
  <form method="get">
    <p class="search-box">
      <label class="screen-reader-text" for="user-search-input">Search Users:</label>
      <input type="search" id="user-search-input" name="s" value="">
      <input type="submit" id="search-submit" class="button" value="Search Users">
    </p>
    <h2>All Transactions</h2>
    
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
    <?php
      $attr->prepare_items();
      $attr->display();
    ?>
  </form>
</div>