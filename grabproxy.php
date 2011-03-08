<?php

	/*
		grabproxy.php - grabs OVER 9000 proxies 
	*/

include_once('includes/config.php');	// config and include files
$hmenu  = "\n*****     pbot v".VERSION." - by: hysterix     *****\n\n";
$hmenu .= "Usage: php grabproxy.php [-option] [int]\n";
$hmenu .= "-h               This help menu\n";
$hmenu .= "-c               Proxies separated by commas\n";
$hmenu .= "-n               Proxies separated by newlines\n";
$hmenu .= "int              Maximum number of proxies to return (optional)\n";
$hmenu .= "option           What format to save list as\n";
$hmenu .= "If no maximum number is passed, returns OVER 9000 proxies\n\n";

if($argc < 2) { // they did not pass anything, echo help menu
	echo "Error: no options passed!\n";
	echo $hmenu;
} else {
	if($argv[1] == '-h') { // echo help menu and exit
		echo $hmenu;
		exit;
	} elseif($argv[1] == '-c') {
		$ltype = ',';
	} elseif($argv[1] == '-n') {
		$ltype = "\n";
	} else {
		echo "Error: no list type entered";
		echo $hmenu;
		exit;
	}
	
	$arrSites = array(
				"2ch",
				"aliveproxy",
				"atomintersoft",
				"compinfo",
				"cybersyndrome",
				"freeproxych",
				"freeproxy",
				"freeproxylists",
				"getfreeproxy",
				"ipaddress",
				"ipcn",
				"j1f",
				"proxiesthatwork",
				"myproxy",
				"proxygo",
				"proxyleech",
				"proxylist",
				"proxylists",
				"pheaven",
				"proxyserverfinder",
				"rosinstrument",
				"samair",
				"speedtest",
				"xroxy");
	
	$arrSitesH = array(
				"2ch",
				"aliveproxy",
				"atomintersoft",
				"compinfo",
				"cybersyndrome",
				"freeproxych",
				"freeproxy",
				"freeproxylists",
				"getfreeproxy",
				"ipaddress",
				"ipcn",
				"j1f",
				"proxiesthatwork",
				"myproxy",
				"proxygo",
				"proxyleech",
				"proxylist",
				"proxylists",
				"pheaven",
				"proxyserverfinder",
				"rosinstrument",
				"samair",
				"speedtest",
				"xroxy",
				"hidemyass");
	
	$cntSite = count($arrSites)-1;	// off by one syndrome strikes again
	$pb      = new proxybot($config['needle'],$userAgentString,$curlheader);  // create the proxybot class instance
	$arrayHashes = array();
	
	// this is a jumble of shit spaghett code
	if(isset($argv[2])) {
		if(is_numeric($argv[2])) { // max number of proxies
			if($argv[2] < 15 ) {
				$rsites = $pb->uniqueRand(2,0,$cntSite);	// 2 random numbers between zero and number of sites
				$sites  = array();
				for($i=0;$i<2;$i++){ $sites[] = $arrSites[$rsites[$i]]; } // loop through and grab the names of the randomly chosen site
			} elseif($argv[2] < 50) {
				$rsites = $pb->uniqueRand(3,0,$cntSite);	// 3 random numbers between zero and number of sites
				$sites  = array();
				for($i=0;$i<3;$i++){ $sites[] = $arrSites[$rsites[$i]]; } // loop through and grab the names of the randomly chosen site
			} elseif($argv[2] < 100) {
				$rsites = $pb->uniqueRand(4,0,$cntSite+1);	// 4 random numbers between zero and number of sites
				$sites  = array();
				for($i=0;$i<4;$i++){ $sites[] = $arrSitesH[$rsites[$i]]; } // loop through and grab the names of the randomly chosen site
			} elseif($argv[2] < 500) {
				$rsites = $pb->uniqueRand(12,0,$cntSite+1);	// 12 random numbers between zero and number of sites
				$sites  = array();
				for($i=0;$i<12;$i++){ $sites[] = $arrSitesH[$rsites[$i]]; } // loop through and grab the names of the randomly chosen site
			} else { // if($argv[1] < 9000)
				$rsites = $pb->uniqueRand($cntSite,0,$cntSite+1);	// random numbers between zero and number of sites
				$sites  = array();
				for($i=0;$i<$cntSite;$i++){ $sites[] = $arrSitesH[$rsites[$i]]; } // loop through and grab the names of the randomly chosen site
			}

			$finallist     = $pb->returnFinalList($sites);
			
			if(!empty($finallist)) {  // return only as many as they want us to
				unset($finallist[0]); // first proxy has port as zero... @_@
				for($i=0;$i<count($finallist);$i++) {		// duplicate removal
					$hash = md5($finallist[$i][0].$finallist[$i][1]); // md5 to the rescue again
			        if (!isset($arrayHashes[$hash])) {		// if the md5 didn't come up, keep track of it, otherwise its a dupe
			            $arrayHashes[$hash] = $hash;		// save the current element hash
			        } else {
				        unset($finallist[$i]); // unset dupe
			        }
				}
				$newlist = array_slice($finallist, 0, $argv[2]);
				foreach($newlist as $tehlist) {
					echo $tehlist[0].':'.$tehlist[1].$ltype;
				}
				if($ltype == ',') {
					echo "\n";
				}
			} else { // no ips were returned
				echo "Error: no ip\'s found!\n";
			}
		} else { // malformed data
			echo "Error: please only pass commands, or integers to me.\n";
		}
	} else {
		$sites	       = $arrSites;
		$finallist     = $pb->returnFinalList($sites);
		
		if(!empty($finallist)) {  // return 9000 proxies
			unset($finallist[0]); // first proxy has port as zero... @_@
			for($i=0;$i<count($finallist);$i++) {		// duplicate removal
				$hash = md5($finallist[$i][0].$finallist[$i][1]); // md5 to the rescue again
				if (!isset($arrayHashes[$hash])) {		// if the md5 didn't come up, keep track of it, otherwise its a dupe
					$arrayHashes[$hash] = $hash;		// save the current element hash
				} else {
					unset($finallist[$i]); // unset dupe
				}
			}
			$newlist = array_slice($finallist, 0, 9000);
			foreach($finallist as $tehlist) {
				echo $tehlist[0].':'.$tehlist[1].$ltype;
			}
			if($ltype == ',') {
				echo "\n";
			}
		} else { // no ips were returned
		  echo "Error: no ip\'s found!\n";
	   }
  }
}
?>
