<?php
/**
* Sitemap - Automatically sitemapping module for ImpressCMS
*
*
* File: xml_google.php
*
* @copyright    http://www.xoops.org/ The XOOPS Project
* @copyright    XOOPS_copyrights.txt
* @copyright    http://www.impresscms.org/ The ImpressCMS Project
* @license      GNU General Public License (GPL)
*               a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package      Sitemap 
* @since        1.30
* @author       chanoir
* ----------------------------------------------------------------------------------------------------------
*               Sitemap
* @since        1.40
* @author       McDonald
* @version      $Id$
*/

if ( ! defined( 'SITEMAP_ROOT_CONTROLLER_LOADED' ) ) {
	if( ! file_exists( dirname(__FILE__) . '/modules/sitemap/xml_google.php' ) ) {
		die( "Don't call this file directly" );
	}
	if( ! empty( $_SERVER['REQUEST_URI'] ) ) {
		$_SERVER['REQUEST_URI'] = str_replace( 'xml_google.php' , 'modules/sitemap/xml_google.php' , $_SERVER['REQUEST_URI'] );
	} else {
		$_SERVER['REQUEST_URI'] = '/modules/sitemap/xml_google.php';
	}
	$_SERVER['PHP_SELF'] = $_SERVER['REQUEST_URI'];
	define( 'SITEMAP_ROOT_CONTROLLER_LOADED' , 1 );
	$real_xml_google_path = dirname( __FILE__ ) . '/modules/sitemap/xml_google.php';
	chdir( './modules/sitemap/' );
	require $real_xml_google_path;
	exit ;
} else {
	require '../../mainfile.php';
}

$sitemap_configs = $xoopsModuleConfig;

if ( function_exists( 'mb_http_output' ) ) {
	mb_http_output('pass');
}

header( 'Content-Type:text/xml; charset=utf-8' );

include_once ICMS_ROOT_PATH . '/modules/sitemap/include/sitemap.php';

$xoopsTpl = new icms_view_Tpl();

$sitemap = sitemap_show();

$xoopsTpl -> assign( 'lastmod', gmdate( 'Y-m-d\TH:i:s\Z' ) ); // TODO
$xoopsTpl -> assign( 'sitemap', $sitemap );
$xoopsTpl -> assign( 'show_subcategoris', $sitemap_configs['show_subcategoris'] );

$xoopsTpl -> assign( 'this', array( 'mods' => icms::$module -> getVar( 'dirname' ), 'name' => icms::$module -> getVar( 'name' ) ) );

icms::$logger -> disableLogger();

$xoopsTpl -> display( 'db:sitemap_xml_google.html' );
?>