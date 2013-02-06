<?php 
//Get our usual php pages that all our pages that display data will include. 
include("session_start.php"); 
include("header.php");
?>
	<div id="primary_content">
						<?php
$viewmonth=date("n");
if (($viewmonth==12)||($viewmonth<7))
{
if (isset($_POST["viewsource"])) {echo"<hr />";highlight_file(__FILE__);}
else echo('<form action="' . $_SERVER["PHP_SELF"] . '" method="post">
<p><input type="submit" name="viewsource" value="View source"/></p></form>');
}
?>
							<p><b>Design</b></p>
	
							<p>My design all started from and mostly remained the same from my CS15020 project that i made last year, which as stated in that project mostly came from my own website www.thehiddennation.com. I've had my website for a number of years and as such have been happy with my HTML and CSS that I've developed for that website and saw no reason not to use the HTML and CSS design from my previous work.</p>
							
							<p>I had previously done some PHP and MYSQL for my own projects, these projects were simple all they involved was the connection to a database and printing out of select data in select locations based upon a STEAMID which is passed by a game server per user. So knowing that information i went about designing my PHP around multiple files, each file having a certain task and then i would include or require the files where required.</p>
							
							<p>One or two problems i faced with my PHP was the adding of items to a basket, i was initially going to go with having a button for adding each individual item to the basket but then after reading the assignment again i noted that check boxes were meant to be used and changed my design around this fact. With the change to the check boxes i could add more then one item at any one post so all data past via post was done with Array's and all adding and removing of data from my basket was done via array's.</p>
							
							<p>The biggest problem i faced with my website in general was the addition of JavaScript for the regular expression required for validating e-mails and CC number at the end of the project. I find fixing JavaScript to be very annoying as if JS is broken/ written incorrectly it won't give me an error it will simply not work and i will have to debug with other methods.</p>
							
							<p><b>Testing</b></p>
							
							<p>Testing my website involved XHTML 1.0 Strict Validation which i have working on all pages apart from my shop.php page, this page could have been validated but with removing certain features/ changing around my design that i felt wasn't required and i made the decision not to change this page to be validated.</p>
							
							<p>I've also tested how my website looks in Google Chrome, Internet Explorer 9 and Firefox each of which looked the same across all browsers i used to test, there were minimal differences when testing with IE9 but nothing that breaks the website in any horrible way.</p>
							
							<p><b>Evaluation</b></p>
							
							<p>Overall i'm very happy with my website design and implementation, nothing was to frustrating for my project apart from my JavaScript and no PHP problem took my longer then a few minutes to fix as i went along. If this wasn't a project for university and i had complete control over the database i would spend much more time on having a database driven website for username and passwords and then the user would store all of their details prior to a transaction so i didn't get certain details from them each and every transaction.</p>
							
							<p>Making the website database driven would be rather simple but does add much more security elements to my website as i would then have data that people would want and security suddenly becomes a problem if i'm to store sensitive information.</p>
							
							<p><b>Decleration</b></p>
							
							<p>I declare that the work found on this website http://users.aber.ac.uk/nah14/cs25010 is my own Nathan Hand (nah14@aber.ac.uk)</p>
							
							<p><b>Viewing Source!</b></p>
							
							<p>I've added the view source button to all pages that you physically view, but other pages that are just included don't have their source viewed as such i've placed all my code into .txt files in users.aber.ac.uk/nah14/cs25010/src incase there is a problem.</p>
							
							<p id="disclaimer">The information, ramblings and general nonsense posted here are done so by (Nathan Hand nah14@aber.ac.uk) these potentially politically and technically incorrect ramblings are not that of Aberystwyth University or anyone else. Any views given are my own and are nothing to do with A.U.</p>
							
	</div>
<?php include("footer.php");?>