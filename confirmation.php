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

print '<h1>Registration Confirmation</h1>';

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
$message = "<p>I am sorry but this project cannot be confrimed at this time. Please call (802) 999-9999 for help in resolving this matter.</p>";


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

    //$query = "SELECT fldDateJoined, fldEmail, fldScreenName FROM tblRegister WHERE pmkRegisterId = ? ";
    //$query = "SELECT `fldFirstName`,`fldLastName`,`fldEmails`,`fldZip`,`fldMon`,`fldTue`,`fldWed`,`fldThu`,`fldFri`,`fldSat`,`fldSun`,`fldGroupSize`,`fldEmails`,`fldItems` FROM `tblUser`,`tblShopping`,`tblPromotion` WHERE pmkUserId = ?";
    //$results = $thisDatabase->select($query, $data);

  
    
            $query = 'INSERT INTO tblUser SET fldFirstName = ?, fldLastName = ?, fldEmail = ?, fldZip = ?';
            $data = array($fldFirstName, $fldLastName, $fldEmail, $fldZipCode);
            $results = $thisDatabase->insert($query, $data);
            
            
            $query2 = 'INSERT INTO tblShopping SET fldMon = ?, fldTue = ?, fldWed = ?, fldThu = ?, fldFri = ?, fldSat = ?, fldSun = ?, fldGroupSize = ?';
            $data2 = array($fldMon, $fldTue, $fldWed, $fldThu, $fldFri, $fldSat, $fldSun, $fldGroupSize);$results = $thisDatabase->insert($query2, $data2);
            
            
            $query3 = 'INSERT INTO tblPromotion SET fldEmails = ?, fldItems = ?';
            $data3 = array($fldItems, $fldEmails);
            $results = $thisDatabase->insert($query3, $data3);
    
    
    
    
    
    
    
 
    
    $dateSubmitted = $results[0]["fldDateJoined"];
    $fldFirstName = $results[0]["$fldFirstName"];
    $fldLastName = $results[0]["$fldLastNameName"];
    $fldEmail = $results[0]["fldEmail"];
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
        print "<p>email: " . $fldEmail;
        print "<p><pre>";
        print_r($results);
        print "</pre></p>";
        print "<p>k1: " . $k1;
        print "<p>q : " . $key1;
    }
    //##############################################################
    // update confirmed
    if ($key1 == $k1) {
        if ($debug)
            print "<h1>Confirmed</h1>";

        $query = "UPDATE tblUser set fldConfirmed=1 WHERE pmkRegisterId = ? ";
        $results = $thisDatabase->select($query, $data);

        if ($debug) {
            print "<p>Query: " . $query;
            print "<p><pre>";
            print_r($results);
            print_r($data);
            print "</pre></p>";
        }
        // notify admin
        $message = '<h2>The following Registration has been confirmed:</h2>';

            $message .= "<p>Click this link to confirm your registration: ";
            $message .= '<a href="' . $domain . $path_parts["dirname"] . '/approve.php?q=' . $key1 . '&amp;w=' . $key2 . '">Approve Registration</a></p>';
            $message .= "<p>or copy and paste this url into a web browser: ";
            $message .= $domain . $path_parts["dirname"] . '/approve.php?q=' . $key1 . '&amp;w=' . $key2 . "</p>";

            
            $message .= "<p><b>First Name:</b><i>   " . $fldFirstName . "</i></p>";
            $message .= "<p><b>Last Name:</b><i>   " . $fldLastName . "</i></p>";
            $message .= "<p><b>Email Address:</b><i>   " . $fldEmail . "</i></p>";
            $message .= "<p><b>Zip Code:</b><i>   " . $fldZipCode . "</i></p>";
            $message .= "<p><b>Shopping Monday:</b><i>   " . $fldMon . "</i></p>";
            $message .= "<p><b>Shopping Tuesday:</b><i>   " . $fldTue . "</i></p>";
            $message .= "<p><b>Shopping Wednesday:</b><i>   " . $fldWed . "</i></p>";
            $message .= "<p><b>Shopping Thursday:</b><i>   " . $fldThu . "</i></p>";
            $message .= "<p><b>Shopping Friday:</b><i>   " . $fldFri . "</i></p>";
            $message .= "<p><b>Shopping Saturday:</b><i>   " . $fldSat . "</i></p>";
            $message .= "<p><b>Shopping Sunday:</b><i>   " . $fldSun . "</i></p>";
            $message .= "<p><b>Group Size:</b><i>   " . $fldGroupSize . "</i></p>";
            $message .= "<p><b>Lookiing for Specific Items:</b><i>   " . $fldItems . "</i></p>";
            $message .= "<p><b>Recieve Emails:</b><i>   " . $fldEmails . "</i></p>";

        if ($debug)
            print "<p>" . $message;

        $to = $adminEmail;
        $cc = "";
        $bcc = "";
        $from = "Kenny Alderman <noreply@yoursite.com>";
        $subject = "This user wants to be approved";

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);

        if ($debug) {
            print "<p>";
            if (!$mailed) {
                print "NOT ";
            }
            print "mailed to admin ". $to . ".</p>";
        }

        // notify user
        $to = $fldEmail;
        $cc = "";
        $bcc = "";
        $from = "Kenny Alderman <noreply@yoursite.com>";
        $subject = "You have asked to be approved!";
        $message = "<p>Thank you for taking the time to confirm your registration. Feel free to explore the rest of our website!</p>";

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