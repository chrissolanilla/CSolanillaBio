<!DOCTYPE html>
<html>
<head>
<?php include('includes.html'); ?><!-- includes.html -->
<title>Tutorials - Techrangers</title>
</head>

<body>

	<?php include('header.html'); ?> <!-- header.html -->
	
	<main role="main" id="tutorialsmain">
		<!-- main content -->
		<div id="title">
			<h1>Tutorials</h1>
		</div>
		
		<?php include('sidebar.html'); ?> <!-- sidebar.html -->
		
		<section role="region" class="pagecontent"> 
		
			<p>Here at the Techrangers, we believe that you don't really know something until you are able to teach it. That is why, as part of our training, backend developers are given an opportunity to make a tutorial explaining a programming concept. The tutorials provide experience in development processes, technical writing, and project management.</p>

			<p>These tutorials have been compiled here as a resource for our team and you.</p>
			
			<section role="region" id="tutorials">
				<section role="region" class="tutitem"> 
					<h1><a href="http://ucfcdl.github.io/html5-tutorial/" target="_blank">Introduction to HTML5 and Canvas</a></h1>
					<img src="images/tutorials/intro_html5_canvas.jpg" alt="Introduction to HTML5 and Canvas" />
					<p>This tutorial is designed to introduce you to working with the HTML5 canvas tag and JavaScript by walking you through the creation of controls for a top down driving game.</p>
					<p class="author">Created By: Christopher McLean on April 17<sup>th</sup>, 2013</p>
				</section>
				
				<section role="region" class="tutitem">
					<h1><a href="techrangers-training.php" target="_blank">Techrangers Training</a></h1>
					<img src="images/tutorials/techrangers_training.jpg" alt="Techrangers Training" />
					<p>This tutorial is designed to introduce you to the Fuel PHP framework by walking you through the creation of a simple messaging app.</p>
					<p class="author">Created By the Techrangers: on November 9<sup>th</sup>, 2012</p>
				</section>
				
				<section role="region" class="tutitem"> 
					<h1><a href="oauth-python-tutorial.php" target="_blank">OAuth Python Tutorial</a></h1>
					<img src="images/tutorials/oauth_python.jpg" alt="OAuth Python Tutorial" />
					<p>This tutorial explains how to use OAuth 1.0 with Python and the Django framework.</p>
					<p class="author">Created By: Munawar Bijani on May 2<sup>nd</sup>, 2012</p>
				</section>
				
				<section role="region" class="tutitem"> 
					<h1><a href="a-simple-poll-manager-with-django.php" target="_blank">A Simple Poll Manager With Django</a></h1>
					<img src="images/tutorials/poll_manager_django.jpg" alt="A Simple Poll Manager With Django" />
					<p>In this tutorial I'll be showing you how to make a simple poll manager using Django, a Python framework.</p>
					<p class="author">Created By: Jesse Slavens on April 30<sup>th</sup>, 2012</p>
				</section>
				
				<section role="region" class="tutitem"> 
					<h1><a href="http://ucf.github.io/fuelphp-crash-course/" target="_blank">Fuel Crash Course</a></h1>
					<img src="images/tutorials/fuelphp_crash.jpg" alt="Fuel Crash Course" />
					<p>This tutorial is designed to introduce you to the Fuel PHP framework by walking you through the creation of a simple messaging app.</p>
					<p class="author">Created By: Kevin Baugh &amp; Keegan Berry on October 14<sup>th</sup>, 2011</p>
				</section>
			</section>
		</section>
	</main>
 
	<?php include('footer.html'); ?> <!-- footer.html -->

</body>
</html>