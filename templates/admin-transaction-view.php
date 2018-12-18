<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div class="wrap">
  <h1 class="wp-heading-inline">Interswitch Transaction</h1>
  <form method="get">
    <h2>Ref: <?php echo $attr->txn_ref; ?></h2>
  <hr/>
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row">Transaction Reference</th>
          <td><?php echo $attr->txn_ref ?></td>
        </tr>
        <tr>
          <th scope="row">Email</th>
          <td><?php echo $attr->email ?></td>
        </tr>
        <tr>
          <th scope="row">Amount</th>
          <td><?php echo $attr->amount .' '. $attr->currency ?></td>
        </tr>
        <tr>
          <th scope="row">Payment Ref</th>
          <td><?php echo $attr->pay_ref ?></td>
        </tr>
        <tr>
          <th scope="row">Meta</th>
          <td>
            <?php foreach( json_decode($attr->meta) as $key => $value ) { ?>
              <p>
                <strong><?php echo ucwords($key); ?>:</strong> 
                <span><?php echo ucwords($value); ?></span>
              </p>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <th scope="row">Code</th>
          <td><?php echo $attr->code ?></td>
        </tr>
        <tr>
          <th scope="row">Response Message</th>
          <td><?php echo $attr->response ?></td>
        </tr>
        <tr>
          <th scope="row">Created</th>
          <td><?php echo date_format(date_create($attr->created_at),"D, M d, Y H:ia") ?></td>
        </tr>
        <tr>
          <th scope="row">Last Updated</th>
          <td><?php echo date_format(date_create($attr->updated_at),"M d, Y H:ia") ?></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>