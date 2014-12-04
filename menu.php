<nav id='cssmenu'>
<!--<ul>
   
   <li><a href='https://kjalderm.w3.uvm.edu/cs148/assignment10/home.php'><span>+Home</span></a></li>
   <li><a href='https://kjalderm.w3.uvm.edu/cs148/assignment10/products.php'><span>+Our Products</span></a></li>
   <li><a href='https://kjalderm.w3.uvm.edu/cs148/assignment10/deals.php'><span>+Important Information</span></a></li>
   <li><a href='https://kjalderm.w3.uvm.edu/cs148/assignment10/aboutUs.php'><span>+About Us</span></a></li>
   <li><a href='https://kjalderm.w3.uvm.edu/cs148/assignment10/contactUs.php'><span>+Contact Us</span></a></li>
   <li class='last'><a href='https://kjalderm.w3.uvm.edu/cs148/assignment10/form.php'><span>+Store Feedback</span></a></li>
</ul>
    -->
   
     <ul>
		
		
		<?php
		 if(basename($_SERVER['PHP_SELF'])=="home.php"){
		 	 print '<li class="activePage">+Home</li>';
		} else {
		   print '<li><a href="home.php">+Home</a></li>';
		}
		 if(basename($_SERVER['PHP_SELF'])=="products.php"){
		 	 print '<li class="activePage">+Our Products</li>';
		} else {
		   print '<li><a href="products.php">+Our Products</a></li>';
		}
		if(basename($_SERVER['PHP_SELF'])=="deals.php"){
		 	 print '<li class="activePage">+Deals, Events & Info</li>';
		} else {
		   print '<li><a href="deals.php">+Deals, Events & Info</a></li>';
		}
		if(basename($_SERVER['PHP_SELF'])=="aboutUs.php"){
		 	 print '<li class="activePage">+About Us</li>';
		} else {
		   print '<li><a href="aboutUs.php">+About Us</a></li>';
		}
                if(basename($_SERVER['PHP_SELF'])=="contactUs.php"){
		 	 print '<li class="activePage">+Contact Us</li>';
		} else {
		   print '<li><a href="contactUs.php">+Contact Us</a></li>';
		}
                if(basename($_SERVER['PHP_SELF'])=="formV2.php"){
		 	 print '<li class="activePage">+Store Feedback</li>';
		} else {
		   print '<li><a href="formV2.php">+Store Feedback</a></li>';
		}
		?> 

		
		
				
     </ul> 
</nav>