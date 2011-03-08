<?php

	/*
		testproxy.php - tests OVER 9000 proxies 
	*/

include_once('includes/config.php');	// config and include files

if(isset($_REQUEST[PROXY_REQ_VAR])) {	// we are receiving a request from an external source as a get or post var
	echo $pb->return_env_variables($_SERVER);
	exit;	// dont wast bandwidth loading bullshit
}	

$hmenu  = "\n*****     pbot v".VERSION." - by: hysterix     *****\n\n";
$hmenu .= "Usage: php testproxy.php [-option] [hostname] [path]\n";
$hmenu .= "Or   : php grabproxy.php [-option] > [path] && php testproxy.php [-option] [hostname] [path]\n";
$hmenu .= "-h               This help menu\n";
$hmenu .= "-c               Proxies separated by commas\n";
$hmenu .= "-n               Proxies separated by newlines\n";
$hmenu .= "-a               Optional: Test anonymity level (requires hostname)\n";
$hmenu .= "option           What format to save list as\n";
$hmenu .= "path             Path to tmp folder location and file name\n";
$hmenu .= "Test if up: php grabproxy.php -n 100 > /tmp/pb.new && php testproxy.php -n /tmp/pb.new > /tmp/pb.good\n";
$hmenu .= "Test anonymity: php grabproxy.php -n 100 > /tmp/pb.new && php testproxy.php -n -a hysterix.com/pbot /tmp/pb.new > /tmp/pb.good\n\n";

$testanon = false;

if($argc < 3) { // they did not pass anything, echo help menu
	echo "Error: Path and option must both be passed!\n";
	echo $hmenu;
	exit;
} else {
	// this is a really shitty way to grab args passed to the script but meh
	$pathnew = $argv[$argc-1];
	if($argv[1] == '-h' || $argv[2] == '-h' || $argv[3] == '-h' || $argv[4] == '-h' || $argv[5] == '-h') { // echo help menu and exit
		echo $hmenu;
		exit;
	}
	if($argv[1] == '-c' || $argv[2] == '-c' || $argv[3] == '-c') {
		$ltype = ',';
	}
	if($argv[1] == '-n' || $argv[2] == '-n' || $argv[3] == '-n') {
		$ltype = "\n";
	}

	if($argv[1] == '-a') {
		$testanon = true;
		$hname    = $argv[2];
	}
	if($argv[2] == '-a') {
		$testanon = true;
		$hname    = $argv[3];
	}
	if($argv[3] == '-a') {
		$testanon = true;
		$hname    = $argv[4];
	}
	
	if($testanon) {
		if($argc < 5) { echo "Missing argument. Exiting!\n"; }
		if($hname == '' || $hname == ' ' || $hname == null) {
			echo "Options malformed.  Exiting!\n";
			exit;
		}
	}
	
	if($ltype == '' || $ltype == ' ' || $ltype == null) { echo "Options malformed.  Exiting!\n"; }
	if($pathnew == '' || $pathnew == ' ' || $pathnew == null) { echo "Options malformed.  Exiting!\n"; }
	
	$yatmpvar  = '';
	$he 	   = fopen($pathnew,"r");
	while(!feof($he))
	{
	    $output    = fgets($he, 1024);
	    $yatmpvar .= $output;
	}

	$pb        = new proxybot($config['needle'],$userAgentString,$curlheader);  // create the proxybot class instance
	$yatemplol = explode($ltype,$yatmpvar);
	for($i=0,$limit=count($yatemplol);$i<$limit;++$i) {
	 	if($yatemplol[$i] == "\n" ) {
	  		unset($yatemplol[$i]);
	  	} elseif(($yatemplol[$i] == '') || $yatemplol[$i] == ' ') {
			unset($yatemplol[$i]);
		}
	}
	
	$proxtype = 'new';
	$yacntr	  = 0;
	
	if((strcmp($proxtype,'good') == 0) || (strcmp($proxtype,'inactive') == 0)) {	// proxytype is good or inactive
		for($i=0;$i<count($yatemplol);$i++){
			if (isset($yatemplol[$i])) {
				$userAgent = $pb->retAgentString($pb->uagent);
				$yatempcon = explode(':',$yatemplol[$i]);
				$arrProx[$yacntr] = array('ip' => $yatempcon[0], 'port' => $yatempcon[1], 'type' =>  $yatempcon[2], 'useragent' => $userAgent);
				$yacntr++;
			}
		}
	} else {	// proxytype is new, build three per single ip:port
		for($i=0;$i<count($yatemplol);$i++){
			if (isset($yatemplol[$i])) {
				$userAgent = $pb->retAgentString($pb->uagent);
				$yatempcon = explode(':',$yatemplol[$i]);
				$arrProx[$yacntr] = array('ip' => $yatempcon[0], 'port' => $yatempcon[1], 'type' => 'socks4', 'useragent' => $userAgent);
				$yacntr++;
				$arrProx[$yacntr] = array('ip' => $yatempcon[0], 'port' => $yatempcon[1], 'type' => 'socks5', 'useragent' => $userAgent);
				$yacntr++;
				$arrProx[$yacntr] = array('ip' => $yatempcon[0], 'port' => $yatempcon[1], 'type' => 'http', 'useragent' => $userAgent);
				$yacntr++;
			}
		}
	}
	
	if($testanon) {
		$yatmpvar = $pb->test_proxies($arrProx,$proxtype,'internal',$hname);
	} else {
		$yatmpvar = $pb->check($arrProx,$proxtype);
	}
	
	for($i=0;$i<count($yatmpvar);$i++) {
		if(isset($yatmpvar[$i]['ip'])) {  // automagically returns working proxy, port, and type
			echo $yatmpvar[$i]['ip'].' '.$yatmpvar[$i]['port'].' '.$yatmpvar[$i]['type'];
			if(isset($yatmpvar[$i]['alevel'])) { echo "     # ".$yatmpvar[$i]['alevel']; }
			echo "\n";
		} //else {
			// If you want pbot to return an error message, echo it here		
			// echo "failure...\n";
		//}
	}	
}
?>
