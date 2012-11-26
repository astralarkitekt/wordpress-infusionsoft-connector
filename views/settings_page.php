<div class="wrap" id="<?php echo $this->plugin_pre; ?>-wrapper">
	
	<h2 class="page-title"><?php _e( 'Infusionsoft API Settings', $this->text_domain ) ?></h2>

	<form id="<?php echo $this->plugin_pre; ?>settings" name="<?php echo $this->plugin_pre; ?>settings" class="infusionsoft-settings-page" action="options.php" method="post">
		
		<?php $this->get_connection_status(); ?>

		<?php settings_errors(); ?>

		<?php settings_fields( $this->plugin_pre . 'settings' ); ?>	

		<?php do_settings_sections( $this->settings_page_slug ); ?>

		<div class="form-row">
			<input type="reset" name="reset" id="<?php echo $this->plugin_pre; ?>reset" value="<?php _e( 'Reset to Defaults', $this->text_domain ); ?>" class="button" />
			<input type="submit" name="submit" id="<?php echo $this->plugin_pre; ?>submit" value="<?php _e('Save Settings', $this->text_domain ); ?>" class="button-primary" />
		</div>

	</form>
</div>