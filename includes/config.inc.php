<?php

// config.inc.php - curlheader info


$config['needle'] = 'google';	// what to search for when connecting through the proxy

/* header info for curl (browser info needed its own function) */
$curlheader = array( 
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.8",
		"Accept-Language: en-us,en;q=0.5",
		"Cache-Control: must-revalidate, post-check=0, pre-check=0, max-age=0",
		"Expires: 0",
		"Accept-Encoding: gzip,deflate",
		"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
		"Keep-Alive: 300",
		"Connection: keep-alive",
		"Pragma: " // browsers keep this blank
);

?>
