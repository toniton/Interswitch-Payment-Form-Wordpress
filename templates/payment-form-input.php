<?php
    if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<?php switch($atts['type']) : case 'text': ?>
    <div>
        <label for="<?php echo trim($atts['id']); ?>"><?php echo $atts['name']; ?></label>
        <input id="<?php echo trim($atts['id']); ?>" name="meta[<?php echo trim($atts['id']); ?>]" type="<?php echo $atts['type']; ?>" placeholder="<?php echo $atts['placeholder']; ?>" required/>
        <br/>
    </div>
<? break; case 'select' : ?>
    <div>
        <label for="<?php echo trim($atts['id']); ?>"><?php echo $atts['name']; ?></label>
        <select id="<?php echo trim($atts['id']); ?>" name="meta[<?php echo trim($atts['id']); ?>]">
            <option disabled selected></option>
            <?php echo do_shortcode($content); ?>
        </select>
        <br/>
    </div>
<? break; case 'textarea' : ?>
    <div>
        <label for="<?php echo trim($atts['id']); ?>"><?php echo $atts['name']; ?></label>
        <textarea id="<?php echo trim($atts['id']); ?>" name="meta[<?php echo trim($atts['id']); ?>]" placeholder="<?php echo $atts['placeholder']; ?>"></textarea>
        <br/>
    </div>
<? break; default : ?>
    <div>This type of shortcode is not supported yet for extra fields!</div>
<?php break; endswitch ?>