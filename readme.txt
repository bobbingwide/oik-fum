=== oik-fum ===
Contributors: bobbingwide, vsgloik
Donate link: http://www.oik-plugins.com/oik/oik-donate/
Tags: oik, update manager 
Requires at least: 4.2
Tested up to: 4.3.1
Stable tag: 1.2.0

oik flexible update manager

== Description ==
Originally, a very simple plugin that directs your WordPress site to check different servers for different plugins and themes
this plugin is now being put to proper use to support plugins that don't want to be dependent upon the oik base plugin.

It's an attempt at a standalone version of the oik options > plugins tab.

It'll work differently from the existing implementation of the tab.

* using the new BW_List_Table class that's also used in oik-clone to create the list
* using a multi-file shareable shared library that makes use of oik-lib's functionality and the oik_boot fallback logic
* May support downloading versions from GitHub
* It MAY NOT support automatic checking integrated with WordPress's plugin updates
* It MAY NOT support themes
* It may not use any logic from tgmpluginactivation



== Installation ==
1. Upload the contents of the oik-fum plugin to the `/wp-content/plugins/oik-fum' directory
1. Activate the oik-fum plugin through the 'Plugins' menu in WordPress

Note: oik-fum is dependent upon the oik plugin. You can activate it but it will not work unless oik is also activated.
Download oik from 
[oik download](http://wordpress.org/extend/plugins/oik/)

== Frequently Asked Questions ==

= What is this plugin for? =
It directs update requests for certain plugins to the oik-plugins server(s).

= What repositories can it work with? =

* OIK plugins servers such as oik-plugins.com, oik-plugins.co.uk, bobbingwide.com/blog, oik-plugins.eu ?,  etcetera
* GitHub support planned

== Screenshots ==
1. None

== Upgrade Notice ==
= 1.2.0 =
Early days yet.

= 1.2 =
Needed to get oik-plugins.eu to apply the latest version of nivo2011

= 1.1.1106 = 
Depends on oik v1.17 

= 1.1.0928 = 
Testing WPMS Upgrade code... seems to be a bit different! 

= 1.1.0925 =
Set oik to be server from the (locally) defined oik-plugins server

= 1.1.0829 =
Testing to see if this is "greater" than 1.1.0802.1 - note the length


== Changelog ==
= 1.2.0 =
* Changed: Now uses semantic versioning
* Changed: No longer depends on oik
* Changed: Tested with WordPress 4.2 and above

= 1.2 =
* Added: support for oik-themes, with dummy registration of oik20120 and nivo2011 which don't themselves include calls to oik_register_theme_server()

= 1.1.1106 
* Changed: Simplified - removed registrations for other plugins

= 1.1.0928 =
* oik-bbpress not FORCED from oik-plugins.com

= 1.1.0925 =
* Added oik-bbpress and oik

= 1.1.0809 =
* Added: us-tides now supported from qw/wpit

= 1.1.0802 =
* Added: support for multiple servers


== Further reading ==
If you want to read more about oik plugins and themes then please visit 
[oik-plugins](http://www.oik-plugins.com/) 



