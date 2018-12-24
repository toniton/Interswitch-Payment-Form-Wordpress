<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
    wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
    wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . '../assets/js/code-editor.js', array( 'jquery' ), '', true );
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
        <?php foreach($attr['tabs'] as $key => $tab) {?>
		    <a href="?page=<?php echo $_REQUEST['page'] ?>&tab=<?php echo $key; ?>" class="nav-tab <?php if ($key === $attr['currentTab']) echo 'nav-tab-active'; ?> "><?php echo $tab; ?></a>
        <?php } ?>
	</h2>
    <form id="interswitch-payment-form" action="" method="POST" enctype="multipart/form-data" class="validate" novalidate="novalidate">
        <fieldset>
            <h3>Only CSS</h3>
            <p class="description">Do your CSS magic</p>
            <textarea id="code_editor_page_css" rows="5" name="css" class="widefat textarea"><?php echo wp_unslash( $attr['css'] ); ?></textarea>   
        </fieldset>
        <?php submit_button('Save CSS Styling'); ?>
    </form>
</div>