<?php $options = $this->options; ?>
<h3>Set Up Your API Connection to Your Infusionsoft App</h3>

<p>Before WordPress can start talking to Infusionsoft, we need a few key pieces of information.</p>

<div class="form-row">
	<label for="application-name">Application Name</label>
	https://<input type="text" name="<?php echo $this->plugin_pre . 'settings'; ?>[infusionsoft_application_name]" id="application-name" value="<?php echo esc_attr($options['infusionsoft_application_name']); ?>" size="12">.infusionsoft.com/
	<div class="description">Your Application Name is the first part of the URL you use to log in to your Infusionsoft account. (e.g. If my url was https://innerbot.infusionsoft.com, <em>innerbot</em> would be my Application Name )</div>
</div>

<div class="form-row">
	<label for="username">Application Username</label>
	<input type="text" name="<?php echo $this->plugin_pre . 'settings'; ?>[infusionsoft_username]" id="username" value="<?php esc_attr( $options['infusionsoft_username'] ); ?>">
	<div class="description">This is the username you use to log in to your Infusionsoft Application</div>
</div>

<div class="form-row">
	<label for="password">Application Password</label>
	<input type="password" name="<?php echo $this->plugin_pre . 'settings'; ?>[infusionsoft_password]" id="password" value="<?php esc_attr( $options['infusionsoft_password'] ); ?>">
	<div class="description">This is the password you use to log in to your Infusionsoft Application</div>
</div>