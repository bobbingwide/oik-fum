<?php 
/**
Plugin Name: oik-fum
Plugin URI: http://www.oik-plugins.com/oik-plugins/oik-fum
Description: oik flexible update manager
Version: 1.2.0
Author: bobbingwide
Author URI: http://www.bobbingwide.com
License: GPL2

    Copyright 2012-2015 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

/**
 * Implement "admin_menu" for oik-fum
 * 
 * Here oik-fum is dependent upon oik-lib
 * It won't work if it's only oik, since oik won't invoke "oik_lib_loaded"
 */
function oikf_admin_menu() {
	//echo __FUNCTION__; 
  // How do we know it's safe to run oik_require_lib() ?
	if ( did_action( "oik_lib_loaded" ) ) {
		if ( !did_action( "oik_admin_menu" ) ) {
			oikf_admin_setup();
		}
	} else {
		//echo "oik_lib_loaded not happeneed yet";
	}
}

/**
 * Take some action when a library has been loaded
 * 
 * You may think it's a good idea to defer admin menu processing until a library has been loaded.
 *
 * This is not the way to do it. 
 * Example: Do some action when "oik-admin" has been loaded.
 * Well, oik-admin may be loaded a lot earlier than you think and you'll end up doing things in the wrong order.
 * 
 * @param object $lib the loaded OIK_lib object
 */ 
function oikf_oik_lib_loaded( $lib ) {
}

/**
 * Add admin when 'oik' OR 'oik-lib' is active
 *
 * What if it's been done already?
 * oik-fum is dependent upon its own library ( oik_fum ) and the
 * shared libraries that the oik base plugin used.
 * If oik-lib is active then we can simply request "oik_fum"
 * If not, we have to request them one by one. 
 *
 * @TODO We can tell oik-lib is active by ???
 *
 */
function oikf_admin_setup() {
	oik_lib_fallback( __DIR__ . "/vendor/bobbingwide/oik_fum" );
	$bobbfunc = oik_require_lib( "bobbfunc" );
	c( $bobbfunc );
	$bobbforms = oik_require_lib( "bobbforms" );
	c( $bobbforms );
	$oik_admin = oik_require_lib( "oik-admin" );
	c( $oik_admin );
	$oik_fum = oik_require_lib( "oik_fum" );
	c( $oik_fum );
	bw_trace2( $oik_fum, "oik_fum library?" );
	if ( $oik_fum && !is_wp_error( $oik_fum ) ) {
		$oik_fum_admin = oik_require_file( 'admin/oik-fum.php', "oik_fum" );
		bw_trace2( $oik_fum_admin, "oik_fum_admin?" );
		c( $oik_fum_admin );
		//echo $oik_fum_admin;
		if ( $oik_fum_admin ) {
			oik_fum_add_page();
		}
	}
}

/**
 * Implement "oik_query_libs" filter for oik-fum
 *
 * oik-fum provides the "oik_fum" library...
 * perhaps this should be called the bobbingwide/oik_fum library? 
 * which is dependent upon 'bw_list_table'
 */
function oik_fum_query_libs( $libraries ) {
	$lib_args = array();
	//$libs = array( "oik_fum" => "bw_list_table", "bw_list_table" => null );
	$libs = array( "oik_fum"  => "bobbingwide/oik_depends" );
	$versions = array( "oik_fum" => "0.0.1", "bw_list_table" => "0.0.1" );
	foreach ( $libs as $library => $depends ) {
		$lib_args['library'] = $library;
		$lib_args['plugin'] = "oik-fum";
		$lib_args['vendor-dir'] = "vendor";
		$lib_args['vendor'] = "bobbingwide"; 
		$lib_args['file'] = null;
		$lib_args['src'] = null;
		$lib_args['deps'] = $depends;
		
		// Here we should consider deferring the version setting until it's actually time to check compatibility
		$lib_args['version'] = bw_array_get( $versions, $library, null );
		$lib = new OIK_lib( $lib_args );
		$libraries[] = $lib;
	}
	
	// Add "oik_plugins" library
	//unset( $lib_args['vendor-dir'];
	//unset( $lib_args['vendor'];
	//unset( $lib_args['package'];
	//unset( $lib_args['file'];
	//unset( $lib_args['src' ];
	
	$lib_args2 = array( 'library' => "bobbingwide/oik_plugins", 'deps' => "oik-admin", "plugin" => "oik-fum" );
	$libraries[] = new OIK_lib( $lib_args2 );
	$lib_args2 = array( 'library' => "bobbingwide/oik_depends", "deps" => null, "plugin" => "oik-fum", "file" => "oik-depends.php" );
	$libraries[] = new OIK_lib( $lib_args2 );
	bw_trace2( $libraries, "oik-fum libraries" );
	bw_backtrace();
	return( $libraries );
}

/**
 * Implement "oik_admin_menu" for oik-fum
 * 
 * Registers a number of plugins as being supported by an oik-plugins server
 * 
 * Note: "oik_admin_menu" will be invoked before "admin_menu" since 
 * 
 */
function oikf_oik_admin_menu() {
  oik_register_plugin_server( __FILE__ );
	oikf_admin_setup();
}

/**
 * Implement "pre_site_transient_update_themes" filter for oik-fum
 */	

function oikf_site_transient_update_themes( $args ) {
  bw_trace2( $args, "ostut" );
  return( $args );
}

/**
 * Implement "wp_update_themes" action for oik-fum
 */ 
function oikf_update_themes( $args ) {
  bw_trace2();
}

/**
 * Implement "admin_notices" for oik-fum
 *
 * Using Scribu's method we would have had the following in the header
 * 
 * Depends: oik base plugin,oik-lib: shared library management
 * 
 * Using this method what we want to be able to do is check for the presence of a number 
 * of alternative plugins...
 * 
 * oik-fum depends on either oik:3.0.0 or oik-lib:0.0.2
 * 
 * Our current test on oik_require_lib doesn't work because oik-bwtrace also provides this
 * we either need to look for something that's shared by oik and oik-lib
 * OR we need to develop the improved dependency checking to use the '|' for OR. 
 * 
 */
function oikf_admin_notices() {
  static $plugin_basename = null;
  if ( !$plugin_basename ) {
    $plugin_basename = plugin_basename(__FILE__);
    // bw_trace2( $plugin_basename, "plugin_basename" );
    add_action( "after_plugin_row_oik-fum/oik-fum.php" , "oikf_admin_notices" );   
    if ( !function_exists( "oik_plugin_lazy_activation" ) ) { 
      require_once( "admin/oik-activation.php" );
    }
  } 
	if ( !function_exists( "oik_require_lib" ) ) { 
		$depends = "oik:3.0.0|oik-lib:0.0.2";
		oik_plugin_lazy_activation( __FILE__, $depends, "oik_plugin_plugin_inactive" );
	}
}

/**
 * Function to invoke when oik-fum loaded
 * 
 */	
function oikf_add_filters() {

	add_filter( "oik_query_libs", "oik_fum_query_libs" );
  add_action( "oik_admin_menu", "oikf_oik_admin_menu" );
  //add_filter( "pre_site_transient_update_themes", "oikf_site_transient_update_themes" );
  //add_action( "wp_update_themes", "oikf_update_themes" );
	add_action( "oik_lib_loaded", "oikf_oik_lib_loaded" );
	add_action( "admin_menu", "oikf_admin_menu", 11 );
	add_action( "admin_notices", "oikf_admin_notices" );
}

oikf_add_filters();





  
    

