<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div class="wrap">
  <h1 class="wp-heading-inline">Interswitch Re-Query</h1>
  <form method="GET">
    <h2>Re-Query Transaction</h2>
    <hr/>
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row"><label for="txn_ref"><?php _e( 'Transaction Reference', 'ipf-payment' ); ?></label></th>
          <td>
              <input class="regular-text code" type="text" 
                  name="txn_ref" 
                  value="<?php echo esc_attr( $attr['txn_ref'] ); ?>" required />
              <?php submit_button('Query'); ?>
          </td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
  </form>
  <table class="form-table">
    <tbody>
      <tr>
        <th scope="row">Amount</th>
        <td><?php echo $attr['Amount'] .' '. $attr['currency'] ?></td>
      </tr>
      <tr>
        <th scope="row">Payment Ref</th>
        <td><?php echo $attr['PaymentReference'] ?></td>
      </tr>
      <tr>
        <th scope="row">Code</th>
        <td><?php echo $attr['ResponseCode'] ?></td>
      </tr>
      <tr>
        <th scope="row">Response Message</th>
        <td><?php echo $attr['ResponseDescription'] ?></td>
      </tr>
    </tbody>
  </table>
</div>