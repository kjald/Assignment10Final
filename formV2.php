<?php include ("top.php"); ?>


<body id="home">

<?php include ("header.php"); 
 
 print "\n";
 
  include ("menu.php"); ?>
    
    
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
//include("tryme.php");
//print phpinfo();



/* the purpose of this page is to display a form to allow a person to register
 * the form will be sticky meaning if there is a mistake the data previously 
 * entered will be displayed again. Once a form is submitted (to this same page)
 * we first sanitize our data by replacing html codes with the html character.
 * then we check to see if the data is valid. if data is valid enter the data 
 * into the table and we send and dispplay a confirmation email message. 
 * 
 * if the data is incorrect we flag the errors.
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 * Last updated on: October 17, 2014
 * 
 * 
  -- --------------------------------------------------------
  --
  -- Table structure for 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
$debug = true;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>";


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;




//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$fldFirstName = "";
$fldLastName = "";
$fldEmail = "";
$fldZipCode = "";
$fldMon = "";
$fldTue = "";
$fldWed = "";
$fldThu = "";
$fldFri = "";
$fldSat = "";
$fldSun = "";
$fldGroupSize = "";
$fldItems = "";
$fldEmails = "";
$fldDateJoined = "";




//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$fldFirstNameERROR = "false";
$fldLastNameERROR = "false";
$fldEmailERROR = "false";
$fldZipCodeERROR = "false";
//$fldMonERROR = "";
//$fldTueERROR = "";
//$fldWedERROR = "";
//$fldThuERROR = "";
//$fldFriERROR = "";
//$fldSatERROR = "";
//$fldSunERROR = "";
$fldGroupSizeERROR = "false";
$fldItemsERROR = "false";
$fldEmailsERROR = "false";



//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// used for building email message to be sent and displayed
$mailed = false;
$messageA = "";
$messageB = "";
$messageC = "";

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2a Security
//
    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2b Sanitize (clean) data
// remove any potential JavaScript or html code from users input on the
// form. Note it is best to follow the same order as declared in section 1c.
    $fldFirstName = filter_var($_POST["txtFirstName"], FILTER_SANITIZE_STRING);
    $fldLastName = filter_var($_POST["txtLastName"], FILTER_SANITIZE_STRING);
    $fldEmail = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $fldZipCode = filter_var($_POST["txtZipCode"], FILTER_SANITIZE_STRING);
    $fldMon = filter_var($_POST["chkMon"], FILTER_SANITIZE_STRING);
    $fldTue = htmlentities($_POST["chkTue"], ENT_QUOTES, "UTF-8");
    $fldWed = htmlentities($_POST["chkWed"], ENT_QUOTES, "UTF-8");
    $fldThu = htmlentities($_POST["chkThu"], ENT_QUOTES, "UTF-8");
    $fldFri = htmlentities($_POST["chkFri"], ENT_QUOTES, "UTF-8");
    $fldSat = htmlentities($_POST["chkSat"], ENT_QUOTES, "UTF-8");
    $fldSun = htmlentities($_POST["chkSun"], ENT_QUOTES, "UTF-8");
    $fldGroupSize = filter_var($_POST["groupSize"], FILTER_SANITIZE_STRING);
    $fldItems = htmlentities($_POST["radItems"], ENT_QUOTES, "UTF-8");
    $fldEmails = htmlentities($_POST["radEmails"], ENT_QUOTES, "UTF-8");


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//
// Validation section. Check each value for possible errors, empty or
// not what we expect. You will need an IF block for each element you will
// check (see above section 1c and 1d). The if blocks should also be in the
// order that the elements appear on your form so that the error messages
// will be in the order they appear. errorMsg will be displayed on the form
// see section 3b. The error flag ($emailERROR) will be used in section 3c.


    if ($fldFirstName == "") {
        $errorMsg[] = "Please enter your First Name";
        $fldFirstNameERROR = true;
    } elseif (!verifyAlphaNum($fldFirstName)) {
        $errorMsg[] = "Your First Name appears to be incorrect.";
        $fldFirstNameERROR = true;
    }
    
    
    
    if ($fldLastName == "") {
        $errorMsg[] = "Please enter your Last Name";
        $fldLastNameERROR = true;
    } elseif (!verifyAlphaNum($fldLastName)) {
        $errorMsg[] = "Your Last Name appears to be incorrect.";
        $fldLastNameERROR = true;
    }

    
    if ($fldEmail == "") {
        $errorMsg[] = "Please enter your Email address";
        $fldEmailERROR = true;
    } elseif (!verifyEmail($fldEmail)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $fldEmailERROR = true;
    }
    
    
    if ($fldZipCode == "") {
        $errorMsg[] = "Please enter your Zip Code";
        $fldZipCodeERROR = true;
    } elseif (!verifyAlphaNum($fldZipCode)) {
        $errorMsg[] = "Your Zip Code appears to be incorrect.";
        $fldZipCodeERROR = true;
    }
    
    if ($fldGroupSize == "") {
        $errorMsg[] = "Please enter your Group Size";
        $fldGroupSizeERROR = true;
    } elseif (!verifyAlphaNum($fldGroupSize)) {
        $errorMsg[] = "Your Group Size appears to be incorrect.";
        $fldGroupSizeERROR = true;
    }
    
    if ($fldItems == "") {
        $errorMsg[] = "Please tell me about your items";
        $fldItemsERROR = true;
    } elseif (!verifyAlphaNum($fldItems)) {
        $errorMsg[] = "Your items preference seems to be incorrect.";
        $fldItemsERROR = true;
    }
    
    if ($fldEmails == "") {
        $errorMsg[] = "Please enter if you would like Emails";
        $fldEmailsERROR = true;
    } elseif (!verifyAlphaNum($fldEmails)) {
        $errorMsg[] = "Your email preference appears to be incorrect.";
        $fldEmailsERROR = true;
    }
      
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2d Process Form - Passed Validation
//
// Process for when the form passes validation (the errorMsg array is empty)
//
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //

        $primaryKey = "";
        $dataEntered = false;
        try {
            $thisDatabase->db->beginTransaction();
            
            
            //TRY 5
 
            
            
            $query1 = 'INSERT INTO tblUser SET fldFirstName = ?, fldLastName = ?, fldEmail = ?, fldZip = ?';
            $query2 = 'INSERT INTO tblShopping SET fldMon = ?, fldTue = ?, fldWed = ?, fldThu = ?, fldFri = ?, fldSat = ?, fldSun = ?, fldGroupSize = ?'; 
            $query3 = 'INSERT INTO tblPromotion SET fldEmails = ?, fldItems = ?'; 
            $data1 = array($fldFirstName, $fldLastName, $fldEmail, $fldZipCode);
            $data2 = array($fldMon, $fldTue, $fldWed, $fldThu, $fldFri, $fldSat, $fldSun, $fldGroupSize);
            $data3 = array($fldEmails, $fldItems);
            $results = $thisDatabase->insert($query1, $data1);
            $results = $thisDatabase->insert($query2, $data2);
            $results = $thisDatabase->insert($query3, $data3);
            
            
          
            
            
            
            

            $primaryKey = $thisDatabase->lastInsert();
            if ($debug)
                print "<p>pmk= " . $primaryKey;

// all sql statements are done so lets commit to our changes
            $dataEntered = $thisDatabase->db->commit();
            $dataEntered = true;
            if ($debug)
                print "<p>transaction complete ";
        } catch (PDOException $e) {
            $thisDatabase->db->rollback();
            if ($debug)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
        }
        // If the transaction was successful, give success message
        if ($dataEntered) {
            if ($debug)
                print "<p>data entered now prepare keys ";
            //#################################################################
            // create a key value for confirmation

            $query = "SELECT fldDateJoined FROM tblUser WHERE pmkUserId=" . $primaryKey;
            $results = $thisDatabase->select($query);

            $dateSubmitted = $results[0]["fldDateJoined"];

            $key1 = sha1($dateSubmitted);
            $key2 = $primaryKey;

            if ($debug)
                print "<p>key 1: " . $key1;
            if ($debug)
                print "<p>key 2: " . $key2;


            //#################################################################
            //
            //Put forms information into a variable to print on the screen
            //

            $messageA = '<h2>Thank you for registering.</h2>';

            $messageB = "<p>Click this link to confirm your registration: ";
            $messageB .= '<a href="' . $domain . $path_parts["dirname"] . '/confirmation.php?q=' . $key1 . '&amp;w=' . $key2 . '">Confirm Registration</a></p>';
            $messageB .= "<p>or copy and paste this url into a web browser: ";
            $messageB .= $domain . $path_parts["dirname"] . '/confirmation.php?q=' . $key1 . '&amp;w=' . $key2 . "</p>";

            $messageC .= "<p><b>First Name:</b><i>   " . $fldFirstName . "</i></p>";
            $messageC .= "<p><b>Last Name:</b><i>   " . $fldLastName . "</i></p>";
            $messageC .= "<p><b>Email Address:</b><i>   " . $fldEmail . "</i></p>";
            $messageC .= "<p><b>Zip Code:</b><i>   " . $fldZipCode . "</i></p>";
            $messageC .= "<p><b>Shopping Monday:</b><i>   " . $fldMon . "</i></p>";
            $messageC .= "<p><b>Shopping Tuesday:</b><i>   " . $fldTue . "</i></p>";
            $messageC .= "<p><b>Shopping Wednesday:</b><i>   " . $fldWed . "</i></p>";
            $messageC .= "<p><b>Shopping Thursday:</b><i>   " . $fldThu . "</i></p>";
            $messageC .= "<p><b>Shopping Friday:</b><i>   " . $fldFri . "</i></p>";
            $messageC .= "<p><b>Shopping Saturday:</b><i>   " . $fldSat . "</i></p>";
            $messageC .= "<p><b>Shopping Sunday:</b><i>   " . $fldSun . "</i></p>";
            $messageC .= "<p><b>Group Size:</b><i>   " . $fldGroupSize . "</i></p>";
            $messageC .= "<p><b>Lookiing for Specific Items:</b><i>   " . $fldItems . "</i></p>";
            $messageC .= "<p><b>Recieve Emails:</b><i>   " . $fldEmails . "</i></p>";

            //##############################################################
            //
            // email the form's information
            //
            $to = $fldEmail; // the person who filled out the form
            $cc = "";
            $bcc = "";
            $from = "Karen's Kloset <noreply@yoursite.com>";
            $subject = "Confirm Karen's Information";

            $mailed = sendMail($to, $cc, $bcc, $from, $subject, $messageA . $messageB . $messageC);
        } //data entered  
    } // end form is valid
} // ends if form was submitted.
//#############################################################################
//
// SECTION 3 Display Form
//
?>
<article id="main">
    <?php
//####################################
//
// SECTION 3a.
//
//
//
//
// If its the first time coming to the form or there are errors we are going
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print "<h1>Your Request has ";
        if (!$mailed) {
            print "not ";
        }
        print "been processed</h1>";
        print "<p>A copy of this message has ";
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $fldEmail . "</p>";
        print "<p>Mail Message:</p>";
        print $messageA . $messageC;
    } else {
//####################################
//
// SECTION 3b Error Messages
//
// display any error messages before we print out the form
        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
//####################################
//
// SECTION 3c html Form
//
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:
          value="<?php print $email; ?>
          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)
          NOTE this line:
          <?php if($emailERROR) print 'class="mistake"'; ?>
          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.
         */
        ?>
    
    
    
    
    
    
        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">
            <fieldset class="wrapper">
                <h1>Register for Karen's Kloset today!+</h1>
                
                <fieldset class="wrapperTwo">
                    <legend>Please complete the following form</legend>
                    <fieldset class="contact">
                        
                        

              
                    
                        
                        <legend>Contact Information</legend>



                        <label for="txtFirstName" class="required">First Name
                            <input type="text" id="txtFirstName" name="txtFirstName"
                                   value="<?php print $fldFirstName; ?>"
                                   tabindex="10" maxlength="45" placeholder="Enter a valid First Name"
                                   <?php if ($fldFirstNameERROR) print 'class="mistake"'; ?> 
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                     <label for="txtLastName" class="required">Last Name
                            <input type="text" id="txtLastName" name="txtLastName"
                                   value="<?php print $fldLastName; ?>"
                                   tabindex="20" maxlength="45" placeholder="Enter a valid Last Name"
                                   <?php if ($fldLastNameERROR) print 'class="mistake"'; ?> 
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        <label for="txtEmail" class="required">Email
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="<?php print $fldEmail; ?>"
                                   tabindex="30" maxlength="45" placeholder="Enter a valid email address"
                                   <?php if ($fldEmailERROR) print 'class="mistake"'; ?> 
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        
                        <label for="txtZipCode" class="required">Zip Code
                            <input type="text" id="txtZipCode" name="txtZipCode"
                                   value="<?php print $fldZipCode; ?>"
                                   tabindex="40" maxlength="45" placeholder="Enter a valid Zip Code"
                                   <?php if ($fldZipCodeERROR) print 'class="mistake"'; ?> 
                                   onfocus="this.select()"
                                   >
                        </label>
                      
                     
                     
                    </fieldset> <!-- ends contact -->
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                                        <fieldset class="checkboxInline">
                       <legend>What days of the week do you shop at second hand stores?<em>(check all that apply.)</em>
                    <br />
                    </legend>

                                            <label for="chkMon">
                       <input type="checkbox" id="chkMon" name="chkMon" value="1"
                                       tabindex="50" /> Monday</label>

                       <label for="chkTue"><input type="checkbox" id="chkTue" name="chkTue" value="1"
                                       tabindex="60" /> Tuesday</label>

                       <label for="chkWed"><input type="checkbox" id="chkWed" name="chkWed" value="1"
                                       tabindex="70" /> Wednesday</label>   

                       <label for="chkThu"><input type="checkbox" id="chkThu" name="chkThu" value="1"
                                       tabindex="80" /> Thursday</label>

                       <label for="chkFri"><input type="checkbox" id="chkFri" name="chkFri" value="1"
                                       tabindex="90" /> Friday</label>						 

                       <label for="chkSat"><input type="checkbox" id="chkSat" name="chkSat" value="1"
                                       tabindex="100" /> Saturday</label>

                            <label for="chkSun"><input type="checkbox" id="chkSun" name="chkSun" value="1"
                                       tabindex="110" /> Sunday</label>
                    </fieldset>


                    
                    
                    
                      

                    
                    
                    
                    <fieldset>  
                        <legend>When shopping, are you usually:</legend>
                   
                       <select id="groupSize" name="groupSize" tabindex="120" size="1">
                          <option value="One"  selected="selected" >Alone</option>
                          <option value="Two" >With another friend</option>
                          <option value="Three or more" >With two or more friends</option>
                       </select>
                    </fieldset>   
                    
                   
                    
               
                    <fieldset class="radiotwo">
                       <legend>Do you come to the store looking for specific items?</legend>
                       <label><input type="radio" id="radItemsYes" name="radItems" value="1" 
                                       tabindex="130" />Yes</label>
                       <label><input type="radio" id="radItemsNo" name="radItems" value="0" 
                                       tabindex="140" checked="checked"/>No</label>

                    </fieldset>

                    
                    
                    
                    <fieldset class="radiotwo">
                       <legend>Would you like to receive email promotions? (No spam!)</legend>
                       <label><input type="radio" id="radEmailsYes" name="radEmails" value="1" 
                                       tabindex="150" checked="checked" />Yes</label>
                       <label><input type="radio" id="radEmailsNo" name="radEmails" value="0" 
                                       tabindex="160" />No</label>

                    </fieldset>


                    

                </fieldset> <!-- ends wrapper Two -->
                
                
                
                
                
                
                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="900" class="button">
                </fieldset> <!-- ends buttons -->
            </fieldset> <!-- Ends Wrapper -->
        </form>
        <?php
    } // end body submit
    ?>
</article>



<?php
include "footer.php";
if ($debug)
    print "<p>END OF PROCESSING</p>";
?>

</body>
