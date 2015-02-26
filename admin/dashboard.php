<div class="wrap gabfire-plugin-settings">

	<div id="panelheader">
		<div id="branding">
			<a href="http://www.gabfirethemes.com/" />
				<img src="<?php echo plugins_url('../img/logo.png', __FILE__); ?>" alt="" />
			</a>
		</div>
		<div class="header-info">
			<?php _e('Gabfire Login Limits',self::$text_domain); ?>
		</div>
	</div> <!-- panelheader -->


	<div class="metabox-holder has-right-sidebar">
		<div class="inner-sidebar">
			<div class="postbox">
				<h3><span><?php _e('Products & Services',self::$text_domain); ?></span></h3>
				<div class="inside">
					<ul>
						<li><a href="http://www.gabfirethemes.com/wp-themes/" target="_blank"><?php _e('WordPress Themes',self::$text_domain); ?></a></li>
						<li><a href="http://www.gabfirethemes.com/services/" target="_blank"><?php _e('WordPress Services',self::$text_domain); ?></a></li>
						<li><a href="http://www.gabfirethemes.com/affiliate-program/" target="_blank"><?php _e('Become an Affiliate',self::$text_domain); ?></a></li>
						<li><a href="http://www.gabfirethemes.com/contact/" target="_blank"><?php _e('Contact Us',self::$text_domain); ?></a></li>
					</ul>
				</div>
			</div>

			<div class="postbox">
				<h3><span><?php _e('Social',self::$text_domain); ?></span></h3>
				<div class="inside">
					<ul>
						<li><a href="http://www.gabfirethemes.com/feed/" target="_blank"><?php _e('Subscribe to RSS',self::$text_domain); ?></a></li>
						<li><a href="http://eepurl.com/dknlQ" target="_blank"><?php _e('Subscribe to Newsletters',self::$text_domain); ?></a></li>
						<li><a href="http://www.twitter.com/gabfirethemes" target="_blank"><?php _e('Follow on Twitter',self::$text_domain); ?></a></li>
						<li><a href="http://www.facebook.com/pages/Gabfire-Premium-Themes/330773148827" target="_blank"><?php _e('Friend Us on Facebook',self::$text_domain); ?></a></li>
						<li><a href="https://plus.google.com/106104916131754615481" target="_blank"><?php _e('Circle on Google+',self::$text_domain); ?></a></li>
					</ul>
				</div>
			</div>

			<div class="postbox">
				<h3><span><?php _e('Support',self::$text_domain); ?></span></h3>
				<div class="inside">
					<ul>
						<li><a href="http://www.gabfirethemes.com/codex" target="_blank"><?php _e('Gabfire Codex',self::$text_domain); ?></a></li>
						<li><a href="http://forums.gabfire.com/" target="_blank"><?php _e('Support Forums',self::$text_domain); ?></a></li>
						<li><a href="http://www.gabfirethemes.com/faq/" target="_blank"><?php _e('Frequently Asked Questions',self::$text_domain); ?></a></li>
						<li><a href="http://www.gabfirethemes.com/blog/" target="_blank"><?php _e('Latest News',self::$text_domain); ?>Latest News</a></li>
					</ul>
				</div>
			</div>
		</div> <!-- .inner-sidebar -->

		<div id="post-body">
			<div id="post-body-content">

				<form method="post">
					<table class="form-table">
						<tbody>

							<!-- Login Limit -->

							<tr>
								<th class="gabfire_admin_table_th">
									<label><?php _e('Login Limit', self::$text_domain); ?></label>
									<td class="gabfire_admin_table_td">
										<select id="gabfire_settings_login_attempt_limit" name="gabfire_settings_login_attempt_limit">

										<?php for ($i = -1; $i < 21; $i++) { ?>
											<option value="<?php echo $i;?>" <?php echo isset($settings['login_attempt_limit']) && (int) $settings['login_attempt_limit'] == $i ? 'selected' : ''; ?>><?php echo $i;?></option>
										<?php } ?>
										</select><br/>

										<em><?php _e('Default: -1 (i.e. Unlimited)', self::$text_domain); ?></em><br/>
										<em><?php _e('0: no login attempts allowed', self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Cache Limit -->

							<tr>
								<th class="gabfire_admin_table_th">
									<label><?php _e('Time Interval', self::$text_domain); ?></label>
									<td class="gabfire_admin_table_td">

										<select id="gabfire_settings_cache_limit" name="gabfire_settings_cache_limit">

											<option value="10" <?php echo isset($settings['cache_limit']) && $settings['cache_limit'] == '10' ? 'selected' : ''; ?>><?php _e('10 seconds', self::$text_domain); ?></option>
											<option value="30" <?php echo isset($settings['cache_limit']) && $settings['cache_limit'] == '30' ? 'selected' : ''; ?>><?php _e('30 seconds', self::$text_domain); ?></option>
											<option value="60" <?php echo isset($settings['cache_limit']) && $settings['cache_limit'] == '60' ? 'selected' : ''; ?>><?php _e('1 minute', self::$text_domain); ?></option>
											<option value="90" <?php echo isset($settings['cache_limit']) && $settings['cache_limit'] == '90' ? 'selected' : ''; ?>><?php _e('1.5 minutes', self::$text_domain); ?></option>
											<option value="120" <?php echo isset($settings['cache_limit']) && $settings['cache_limit'] == '120' ? 'selected' : ''; ?>><?php _e('2 minutes', self::$text_domain); ?></option>
											<option value="300" <?php echo isset($settings['cache_limit']) && $settings['cache_limit'] == '300' ? 'selected' : ''; ?>><?php _e('5 minutes', self::$text_domain); ?></option>

										</select><br/>

										<em><?php _e('The amount of time that login attempts will be trakced for. (i.e 5 attempts in 60 seconds)', self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Cache Wait Limit -->

							<tr>
								<th class="gabfire_admin_table_th">
									<label><?php _e('Wait time', self::$text_domain); ?></label>
									<td class="gabfire_admin_table_td">

										<select id="gabfire_settings_cache_wait_limit" name="gabfire_settings_cache_wait_limit">

											<option value="60" <?php echo isset($settings['cache_wait_limit']) && $settings['cache_wait_limit'] == '60' ? 'selected' : ''; ?>><?php _e('1 minute', self::$text_domain); ?></option>
											<option value="120" <?php echo isset($settings['cache_wait_limit']) && $settings['cache_wait_limit'] == '120' ? 'selected' : ''; ?>><?php _e('2 minutes', self::$text_domain); ?></option>
											<option value="300" <?php echo isset($settings['cache_wait_limit']) && $settings['cache_wait_limit'] == '300' ? 'selected' : ''; ?>><?php _e('5 minutes', self::$text_domain); ?></option>
											<option value="600" <?php echo isset($settings['cache_wait_limit']) && $settings['cache_wait_limit'] == '600' ? 'selected' : ''; ?>><?php _e('10 minutes', self::$text_domain); ?></option>
											<option value="1800" <?php echo isset($settings['cache_wait_limit']) && $settings['cache_wait_limit'] == '1800' ? 'selected' : ''; ?>><?php _e('30 minutes', self::$text_domain); ?></option>
											<option value="3600" <?php echo isset($settings['cache_wait_limit']) && $settings['cache_wait_limit'] == '3600' ? 'selected' : ''; ?>><?php _e('1 hour', self::$text_domain); ?></option>

										</select><br/>

										<em><?php _e('How long the user has to wait after login attempts have exceeded limit and cache time. (i.e. After 5 fails within 60 seconds the user wont be able to attempt again for another 5 mins)', self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

						</tbody>
					</table>

					<?php wp_nonce_field('gabfire_login_limits_admin_settings'); ?>

					<?php submit_button(); ?>

					<a href="<?php echo wp_login_url(); ?>" title="Login Page" target="_blank" class="button"><?php _e('Login Page',self::$text_domain); ?></a>

				</form>

			</div><!-- post-body-content -->
		</div><!--  post-body -->
	</div> <!-- metabox-holder has-right-sidebar -->

</div><!-- rap gabfire-plugin-settings -->