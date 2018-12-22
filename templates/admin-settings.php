<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div class="wrap">
    <h1 class="wp-heading-inline">Interswitch Payment Form</h1>
    <?php if( isset($_GET['settings-updated']) ) { ?>
        <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
            <p><strong><?php _e('Settings saved.') ?></strong></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
    <?php } ?>
    <hr class="wp-header-end">
    <h2 class="nav-tab-wrapper wp-clearfix">
		<a href="http://localhost:8085/wp-admin/nav-menus.php" class="nav-tab nav-tab-active">Settings</a>
		<a href="http://localhost:8085/wp-admin/nav-menus.php" class="nav-tab">Edit CSS Styles</a>
	</h2>
    <form id="interswitch-payment-form" action="options.php" method="POST" enctype="multipart/form-data" class="validate" novalidate="novalidate">
        <?php settings_fields( 'ipf_options_group' ); ?>
        <?php do_settings_sections( 'ipf_options_group' ); ?>
        <h2>Settings</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                    <label for="ipf_options[mode]"><?php _e( 'Mode', 'ipf-payment' ); ?></label>
                    </th>
                    <td class="forminp forminp-text">
                    <select class="regular-text code" name="ipf_options[mode]" required>
                        <?php $mode = esc_attr( $attr['mode'] ); ?>
                        <option selected disabled></option>
                        <?php foreach($attr['mode_options'] as $value){ ?>
                                <option value="<?php echo $value['key']; ?>" <?php selected( $mode, $value['key'] ) ?>><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                    <p class="description">You can switch to Live mode, to accept real transactions.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="ipf_options[mac]"><?php _e( 'Mac', 'ipf-payment' ); ?></label>
                    </th>
                    <td class="forminp forminp-text">
                        <input class="regular-text code" type="text" 
                            name="ipf_options[mac]" 
                            value="<?php echo esc_attr( $attr['mac'] ); ?>" required />
                        <p class="description">Please provide your Mac Key</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="ipf_options[product_id]"><?php _e( 'Product ID', 'ipf-payment' ); ?></label>
                    </th>
                    <td class="forminp forminp-text">
                        <input class="regular-text code" type="text" 
                            name="ipf_options[product_id]" 
                            value="<?php echo esc_attr( $attr['product_id'] ); ?>" 
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                        <p class="description">Please provide your Product ID</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="ipf_options[pay_item_id]"><?php _e( 'Pay Item ID', 'ipf-payment' ); ?></label>
                    </th>
                    <td class="forminp forminp-text">
                        <input class="regular-text code" type="text" 
                            name="ipf_options[pay_item_id]"
                            value="<?php echo esc_attr( $attr['pay_item_id'] ); ?>" 
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                        <p class="description">Please provide your Pay Item ID</p>
                    </td>
                </tr>
                <tr>
                <th scope="row">
                    <label for="ipf_options[footnotes]"><?php _e( 'Footnotes', 'ipf-payment' ); ?></label>
                </th>
                <td>
                    <textarea name="ipf_options[footnotes]" rows="5" cols="20" class="large-text code"><?php echo trim($attr['footnotes']); ?></textarea>
                </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>