<!DOCTYPE html>
<html lang="en">
<head>
<title>Karen's Kloset</title>
<style type="text/css" media="screen, print">
    @font-face {
      font-family: "ByTheButterfly";
      src: url("font/ByTheButterfly.ttf");
    }
		 nav { font-family: "ByTheButterfly", serif }
		header { font-family: "ByTheButterfly", serif }
		h1 { font-family: "ByTheButterfly", serif }
  </style>
<meta charset="utf-8">
<meta name="author" content="Kenneth J. Alderman">
<meta name="description" content="Karen's Kloset - Klassy, Klassic, and Komfy. One on one customer service to get you what you need! Look for Anna the mannequinne">

<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
<![endif]-->

<link rel="stylesheet"
href="https://kjalderm.w3.uvm.edu/cs148/assignment10/style.css"
type="text/css"
media="screen">


<?php
        $debug = false;
        
        
        
        
        /* ##### Step one
*
* create your database object using the appropriate database username
*/

require_once('../bin/myDatabase.php');

$dbUserName = get_current_user() . '_writer';
$whichPass = "w"; //flag for which one to use.
$dbName = strtoupper(get_current_user()) . '_FINAL_PROJECT';

$thisDatabase = new myDatabase($dbUserName, $whichPass, $dbName);

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
//
//  $domain = "https://www.uvm.edu" or http://www.uvm.edu;

        $domain = "http://";
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS']) {
                $domain = "https://";
            }
        }

        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

        $domain .= $server;

        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

        $path_parts = pathinfo($phpSelf);

        if ($debug) {
            print "<p>Domain" . $domain;
            print "<p>php Self" . $phpSelf;
            print "<p>Path Parts<pre>";
            print_r($path_parts);
            print "</pre>";
        }

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// inlcude all libraries
//

        require_once('lib/security.php');

        if ($path_parts['filename'] == "form" || "formV2") {
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }
        ?>	

<script type="text/javascript">
function newWindow(imgName, winName, intWidth, intHeight) {
	var strSize
	strSize = "width=" + intWidth + ",height=" + intHeight;
	window.open(imgName, winName, strSize)
}
function positionWindow(imgName, winName, intWidth, intHeight, intLeft, intTop) {
var strSize
strSize = "width=" + intWidth + ",height=" + intHeight + ",left=" + intLeft + ",top=" + intTop;
window.open(imgName, winName, strSize)
}
</script>





    </head>



		