<?php

	/* if uninstall not called from WordPress exit */

	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit ();

	/* Delete all existence of this plugin */

	$settings = 'gabfire_login_limits_settings';
	$version = 'gabfire_login_limits_version';

	if ( !is_multisite() ) {

		/* Delete blog option */

		delete_option($settings);
		delete_option($version);
	}

	else {

		/* Delete site option */

		delete_site_option($settings);
		delete_site_option($version);
	}
?>