<?php // (C) Copyright Bobbing Wide 2015

/**
 * 	Admin pages for oik-fum
 *
 
 */
 
/**
 * Implement "admin_menu" action for oik-fum
 *
 * Define the oik-fum admin interface
 *
 */
function oik_fum_add_page() {

		add_action( 'admin_init', 'oik_fum_init' );
		gobang();
}		
