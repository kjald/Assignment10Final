<?php include ("top.php"); ?>


<body id="home">

<?php include ("header.php"); 
 
 print "\n";
 
  include ("menu.php"); ?>
    
    
<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
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
  -- Table structure for table `tblRegister`
  --

  CREATE TABLE IF NOT EXISTS `tblRegister` (
  `pmkRegisterId` int(11) NOT NULL AUTO_INCREMENT,
  `fldEmail` varchar(65) DEFAULT NULL,
  `fldDateJoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fldConfirmed` tinyint(1) NOT NULL DEFAULT '0',
  `fldApproved` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pmkRegisterId`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

 * I am using a surrogate key for demonstration, 
 * email would make a good primary key as well which would prevent someone
 * from entering an email address in more than one record.
 */


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
$email = "";
$screenName = "";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$emailERROR = false;
$screenNameERROR = false;


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
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $screenName = htmlentities($_POST["txtScreenName"], ENT_QUOTES, "UTF-8");


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


    if ($email == "") {
        $errorMsg[] = "Please enter your Email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }
    
    
    //REPEAT FOR SCREEN NAME
    
    if ($screenName == "") {
        $errorMsg[] = "Please enter your Screen Name";
        $screenNameERROR = true;
    } elseif (!verifyAlphaNum($screenName)) {
        $errorMsg[] = "Your username appears to be incorrect.";
        $screenNameERROR = true;
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
            $query = 'INSERT INTO tblRegister SET fldEmail = ?, fldScreenName = ?';
            $data = array($email, $screenName);
            if ($debug) {
                print "<p>sql " . $query;
                print"<p><pre>";
                print_r($data);
                print"</pre></p>";
            }
            $results = $thisDatabase->insert($query, $data);

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

            $query = "SELECT fldDateJoined FROM tblRegister WHERE pmkRegisterId=" . $primaryKey;
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

            $messageC .= "<p><b>Email Address:</b><i>   " . $email . "</i></p>";
            $messageC .= "<p><b>Screen Name:</b><i>   " . $screenName . "</i></p>";

            //##############################################################
            //
            // email the form's information
            //
            $to = $email; // the person who filled out the form
            $cc = "";
            $bcc = "";
            $from = "Kennys CRUD Database <noreply@yoursite.com>";
            $subject = "CS 148 registration Email and Screen Name";

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
        print "<p>To: " . $email . "</p>";
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

                          <label for="txtFname" class="required">First Name</label>
                        <input type="text" id="txtFname" name="txtFname" value="" 
                              tabindex="100" maxlength="25" required placeholder="enter your first name" 
                                  class="mistake"                 				  	
                                                                                                  autofocus onfocus="this.select()">



                     <label for="txtLname" class="required">Last Name</label>
                     <input type="text" id="txtLname" name="txtLname" value="" tabindex="120"
                              size="25" maxlength="45" required placeholder="enter your last name"
                              class="mistake"                autofocus onfocus="this.select()">


                        
                        
                        
                        <label for="txtEmail" class="required">Email
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="<?php print $email; ?>"
                                   tabindex="120" maxlength="45" placeholder="Enter a valid email address"
                                   <?php if ($emailERROR) print 'class="mistake"'; ?> 
                                   onfocus="this.select()"
                                   >
                        </label>
                        
                        
                        
                      
                     
                     <label for="txtZipCode" class="required">Zip Code</label>
                     <input type="text" id="txtZipCode" name="txtZipCode" value="" tabindex="120"
                              size="25" maxlength="45" required placeholder="type your zipcode"
                              class="mistake"                autofocus onfocus="this.select()">
                     
                     
                    </fieldset> <!-- ends contact -->
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                                        <fieldset class="checkboxInline">
                       <legend>What days of the week do you shop at second hand stores?<em>(check all that apply.)</em>
                    <br />
                    <b></legend>

                    <label>
                       <label><input type="checkbox" id="chkMonday" name="chkMonday" value="1"
                                       tabindex="150" /> Monday</label>

                       <label><input type="checkbox" id="chkTuesday" name="chkTuesday" value="1"
                                       tabindex="160" /> Tuesday</label>

                       <label><input type="checkbox" id="chkWednesday" name="chkWednesday" value="1"
                                       tabindex="170" /> Wednesday</label>   

                       <label><input type="checkbox" id="chkThursday" name="chkThursday" value="1"
                                       tabindex="180" /> Thursday</label>

                       <label><input type="checkbox" id="chkFriday" name="chkFriday" value="1"
                                       tabindex="190" /> Friday</label>						 

                       <label><input type="checkbox" id="chkSaturday" name="chkSaturday" value="1"
                                       tabindex="200" /> Saturday</label>

                            <label><input type="checkbox" id="chkSunday" name="chkSunday" value="1"
                                       tabindex="210" /> Sunday</label>
                    </fieldset>


                    
                    
                    
                      

                    
                    
                    
                    <fieldset>  
                        <legend>When shopping, are you usually:</legend>
                   
                       <select id="shoppingActivity" name="Activity" tabindex="210" size="1">
                          <option value="One"  selected="selected" >Alone</option>
                          <option value="Two" >With another friend</option>
                          <option value="Three or more" >With two or more friends</option>
                       </select>
                    </fieldset>   
                    
                   
                    
               
                    
                    
                    
                    
                    <fieldset class="radiotwo">
                       <legend>Would you like to receive email promotions? (No spam!)</legend>
                       <label><input type="radio" id="radEmailYes" name="radEmailYes" value="1" 
                                       tabindex="240" checked="checked" />Yes</label>
                       <label><input type="radio" id="radEmailNo" name="radEmailNo" value="0" 
                                       tabindex="250" />No</label>

                    </fieldset>

                    
                    
                    
                    
                    
                    
               
                 
                    <fieldset class="radiotwo">
                       <legend>Do you come to the store looking for specific items?</legend>
                       <label><input type="radio" id="radItemYes" name="radItemYes" value="1" 
                                       tabindex="220" />Yes</label>
                       <label><input type="radio" id="radItemNo" name="radItemNo" value="0" 
                                       tabindex="230" checked="checked"  checked="checked" />No</label>

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
</html>