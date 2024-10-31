<div class="wrap">
<h2>Quaderno Checkout Settings</h2>
<p>Quaderno allows you to comply with the EU VAT rules for digital goods and send beautiful invoices to your customers. <br>You need a Quaderno account for this extension to work. <a href="https://quaderno.io/pricing/" target="_blank">Click here to sign up</a> and get your access data.</p>
<form method="post" action="options.php">
    <?php settings_fields( 'quaderno-checkout-settings-group' ); ?>
    <?php do_settings_sections( 'quaderno-checkout-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Private key</th>
        <td><input type="text" name="quaderno_private_key" value="<?php echo esc_attr( get_option('quaderno_private_key') ); ?>" class="regular-text" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Public key</th>
        <td><input type="text" name="quaderno_public_key" value="<?php echo esc_attr( get_option('quaderno_public_key') ); ?>" class="regular-text" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>
</form>
</div>