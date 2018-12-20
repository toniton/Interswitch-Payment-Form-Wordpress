<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div class="wrap">
  <h1 class="wp-heading-inline">Interswitch Transactions</h1>
  <?php if(isset($_GET['s']) && !empty($_GET['s'])){ ?>
      <span class="subtitle">Search results for “<?php echo$_GET['s'] ?>”</span>
  <?php } ?>
  <form method="GET">
    <h2>All Transactions</h2>
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
    <?php
      $attr->prepare_items();
      $attr->search_box('search', 'search_id');
      $attr->display();
    ?>
  </form>
</div>