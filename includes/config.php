<?php

/*
	config.php - config for proxybot
*/

session_start(); // start the session

include_once('proxybot.class.php');	// proxybot class
include_once('curl.php');    		// very nice curl wrapper, in fact, the only library worth keeping

error_reporting(E_ALL ^ E_NOTICE);  // turn off warnings
//ini_set('display_errors','1');

set_time_limit(0);			    	// stop timeouts
ini_set('memory_limit','128M');		// ever since multi-threading through (whatever number you want) proxies at a time was implemented, moar mem is needed

/* connectivity parameters */
define('MAX_CONNECTIONS',100); 		// max number of simultaneous curl connections (crank it up for serious speed (high memory usage) - keep it high to keep speed up)
define('MAX_RETRYS',2);	  	   		// max number of retrys per site
define('PROXY_TIMEOUT',5);	   		// timeout value to check a proxy in seconds
define('SITE_TIMEOUT',120);	   		// timeout value when connecting to sites

/* testing parameters  */
define('MAX_NEW_CHECK',9001);  		// max number of new proxies that could potentially be checked per user click
define('MAX_GOOD_CHECK',9001); 		// max number of good proxies that could potentially be checked per user click
define('MAX_INAC_CHECK',9001); 		// max number of inactive proxies that could potentially be checked per user click
define('PROXY_REQ_VAR','partyvan'); // change this to whatever you want

/* gui parameters */
define('SHOW_NEW_CHECK',0);	  		// 0 - do not show the number of new proxies that can be checked;  1 - show
define('SHOW_GOOD_CHECK',0);  		// 0 - do not show the number of good proxies that can be checked; 1 - show

/* behavior parameters */
define('AUTO_DUPE_REMOVE',1);		// 0 - do not automatically remove duplicates; 1 - automatically remove duplicates before testing any proxies, and after inserting new ones
define('AUTO_BAN',1);				// 0 - do not automatically delete banned ips; 1 - automatically delete banned ips
define('ALLOW_TRUNCATE',0);			// 0 - do not allow the truncate function; 1 - allow the truncate function
define('HIDEMYASS_HASHIFIER',0);	// 0 - do not display hash and portnumber of unknown hidemyass hashes; 1 - show  -- sometimes when turned on, it randomly spits out errors finding hashes even though we already have them; be prepared for this, couldnt figure out why it does it
define('HIDEMYASS_RAPE_LEVEL',15);	// how badly do you want to rape hidemyass.com? This is the amount of threaded hidemyass urls scraped per SINGLE user click (shouldnt go higher than around 20)

/* metadata parameters */
define('VERSION',0.3);				// it seemed liked v0.1 was only yesterday...

?>
