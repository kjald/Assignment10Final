<footer>


 <?php
$today = date("F j, Y");

// this is needed since the the format we display is not considered valid for the time element
$todayDateValue = date("Y-m-d"); 

print '<p>Today is: <time datetime="' . $todayDateValue . '">' . $today . "</time></p>\n";

?>
  <p>Created by: Kenny Alderman</p>
 <!--   Friday May 10th, 2013 -->

</footer>