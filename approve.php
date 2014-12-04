<?php
/* the purpose of this page is to accept the hashed date joined and primary key  
 * as passed into this page in the GET format.
 * 
 * I retrieve the date joined from the table for this person and verify that 
 * they are the same. After which i update the confirmed field and acknowlege 
 * to the user they were successful. Then i send an email to the system admin 
 * to approve their membership 
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: October 17, 2014
 * 
 * 
 */

include "top.php";

print '<article id="main">';

print '<h1>Approval Confirmation</h1>';

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
$debug = false;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%

$adminEmail = "kjalderm@uvm.edu";
$message = "<p>I am sorry but this project cannot be confrimed at this time. Please call 999-9999 for help in resolving this matter.</p>";


//##############################################################
//
// SECTION: 2 
// 
// process request

if (isset($_GET["q"])) {
    $key1 = htmlentities($_GET["q"], ENT_QUOTES, "UTF-8");
    $key2 = htmlentities($_GET["w"], ENT_QUOTES, "UTF-8");

    $data = array($key2);
    //##############################################################
    // get the membership record 

    $query = "SELECT `fldFirstName`,`fldLastName`,`fldEmails`,`fldZip`,`fldMon`,`fldTue`,`fldWed`,`fldThu`,`fldFri`,`fldSat`,`fldSun`,`fldGroupSize`,`fldEmails`,`fldItems` FROM `tblUser`,`tblShopping`,`tblPromotion` WHERE pmkUserId = ?";
    $results = $thisDatabase->select($query, $data);

  
 
    
    $dateSubmitted = $results[0]["fldDateJoined"];
    $fldFirstName = $results[0]["$fldFirstName"];
    $fldLastName = $results[0]["$fldLastNameName"];
    $email = $results[0]["fldEmail"];
    $fldZipCode = $results[0]["$fldZipCode"];
    $fldMon = $results[0]["$fldMon"];
    $fldTue = $results[0]["$fldTue"];
    $fldWed = $results[0]["$fldWed"];    
    $fldThu = $results[0]["$fldThu"];
    $fldFri = $results[0]["$fldFri"];
    $fldSat = $results[0]["$fldSat"];
    $fldSun = $results[0]["$fldSun"];
    $fldGroupSize = $results[0]["$fldGroupSize"];
    $fldItems = $results[0]["$fldItems"];
    $fldEmails = $results[0]["$fldEmails"];

    $k1 = sha1($dateSubmitted);

    if ($debug) {
        print "<p>Date: " . $dateSubmitted;
        print "<p>email: " . $email;
        print "<p><pre>";
        print_r($results);
        print "</pre></p>";
        print "<p>k1: " . $k1;
        print "<p>q : " . $key1;
    }
    //##############################################################
    // update approved
    if ($key1 == $k1) {
        if ($debug)
            print "<h1>Confirmed</h1>";

        $query = "UPDATE tblRegister set fldApproved=1 WHERE pmkRegisterId = ? ";
        $results = $thisDatabase->select($query, $data);

        if ($debug) {
            print "<p>Query: " . $query;
            print "<p><pre>";
            print_r($results);
            print_r($data);
            print "</pre></p>";
        }
        // notify admin
        $message = '<h2>Approved successful</h2>';

        
        

        if ($debug)
            print "<p>" . $message;

        $to = $adminEmail;
        $cc = "";
        $bcc = "";
        $from = "Final Approved link <noreply@yoursite.com>";
        $subject = "You have sucessfully approved a new used";

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, "");

        if ($debug) {
            print "<p>";
            if (!$mailed) {
                print "NOT ";
            }
            print "mailed to admin ". $to . ".</p>";
        }

        // notify user
        $to = $email;
        $cc = "";
        $bcc = "";
        $from = "Kenny Alderman <noreply@yoursite.com>";
        $subject = "You were confirmed by the admin";
        $message = "<p>Thank you for taking the time to confirm your registration, it had now been approved by the admin, and are apart of the database.</p>";

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);

        print $message;
        if ($debug) {
            print "<p>";
            if (!$mailed) {
                print "NOT ";
            }
            print "mailed to member: " . $to . ".</p>";
        }
    }else{
        print $message;
    }
} // ends isset get q
?>



<?php
include "footer.php";
if ($debug)
    print "<p>END OF PROCESSING</p>";
?>
</article>
</body>
</html>