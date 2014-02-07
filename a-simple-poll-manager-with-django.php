<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A Simple Poll Manager with Django - Techrangers</title>

<script type="text/javascript" src="http://teach.ucf.edu/wp-content/themes/online/pulldown/online-dropdown.js?2013-12"></script>
<script type="text/javascript" src="http://universityheader.ucf.edu/bar/js/university-header.js"></script>
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<body>

	<?php include('header.html'); ?> <!-- header.html -->
    
    <main role="main" id="pollmanagermain">
    	<!-- main content -->
        <div id="title">
            <h1>A Simple Poll Manager with Django</h1>
        </div>
        
        <?php include('sidebar.html'); ?> <!-- sidebar.html -->
        
        <section role="region" class="pagecontent" id="trtrainingpage">
   
            <section role="region">
                <p class="tutauthor">Created By: Jesse Slavens on April 30<sup>th</sup>, 2012</p>
                <p>In this tutorial I’ll be showing you how to make a simple poll manager using Django, a Python framework.</p>

                <h1>Table of Contents</h1>
                    <ol>
                        <li><a href="#setupdatabase1">Setting up the database</a></li>
                        <li><a href="#changingthetimezone">Changing the Time Zone</a></li>
                        <li><a href="#specifyingdirectory">Specifying Your Template Directory</a></li>
                        <li><a href="#specifyingapps">Specifying Installed Apps</a></li></a></li>
                        <li><a href="#setupdatabase2">Setting Up the Database</a></li>
                        <li><a href="#createpollmodel">Creating the Polls Model</a></li>
                        <li><a href="#createchoicemodel">Creating the Choices Model</a></li>
                        <li><a href="#createvotemodel">Creating the Votes Model</a></li>
                        <li><a href="#pollform">Poll Form</a></li>
                        <li><a href="#choiceform">Choice form</a></li>
                        <li><a href="#importviews">Imports for views.py</a></li>
                        <li><a href="#indexpage">Index Page</a></li>
                        <li><a href="#addingpolls">Adding Polls</a></li>
                        <li><a href="#addingchoices">Adding Choices</a></li>
                        <li><a href="#viewactivepolls">Viewing a List of All Active Polls</a></li>
                        <li><a href="#viewsinglepoll">Viewing a Single Poll</a></li>
                        <li><a href="#addingvotes">Adding Votes to the Database</a></li>
                        <li><a href="#displayresults">Displaying the Results</a></li>
                        <li><a href="#testing">Testing Out Your Site</a></li>
                    </ol>
            </section>
            
            <section role="region">        
                <h1>Getting Started</h1>
                    
                    <p>In this tutorial I’ll be showing you how to make a simple poll manager using Django, a Python framework.

                    <p>To complete this tutorial, you’re going to need to have:
                        <ul>
                            <li>A basic understanding of the Python programming language</li>
                            <li>Django installed on your server</li>
                        </ul>
                    <p>If you’ve never used Python before, or if you feel you need to brush up on your Python skills, you should check out <a href="http://learnpythonthehardway.org/book/" target="_blank">http://learnpythonthehardway.org/book/</a>.</p>

                    <p>If you need to install Django on a server, follow this tutorial to get yourself started: <a href="https://docs.djangoproject.com/en/dev/topics/install/?from=olddocs" target="_blank">https://docs.djangoproject.com/en/dev/topics/install/?from=olddocs</a></p>
            </section>
            
            <section role="region">   
                <h1>Starting Your Project</h1>     
                    <p>Once you’ve got Django installed, the first thing you’re going to need to do is open up your command line (Command Prompt in Windows or Terminal in Mac) and cd to the folder you want to start your project in. From here, we want to run the following command to start our Django project:</p>
                    <pre>django-admin.py startproject poll_manager</pre>

                    <p>Note that poll_manager is the name of your project, and can be changed to whatever you want it to be named.</p>

                    <p>The next step is to create the poll manager app. To do this, you need to cd into the poll_manager directory and run the following code in command line:</p>
                    <pre>python manage.py startapp polls</pre>

                    <p>Running this command will create a folder called polls containing three files: views.py, models.py, and test.py. We will be working with views.py and models.py.</p>
            </section>
            
            <section role="region">  
                <h1>Configuring settings.py</h1>  
                    <h2 id="setupdatabase1">Setting up the database</h2>
                        <p>With your favorite text editor, navigate to your poll_manager folder and open up settings.py. The first thing we’re going to do here is set up our database, so head down to the section that says DATABASES and enter the following information:</p>
                        <pre>‘ENGINE’: ‘django.db.backends.mysql’,
‘NAME’: ’localhost’,
‘USER’: ’root’,
‘PASSWORD’: ‘’,
‘HOST’: ‘’,
‘PORT’:’’,</pre>
                        <p><em>Note that this information may vary depending on how you have your server set up.</em></p>
                    
                    <h2 id="changingthetimezone">Changing the Time Zone</h2>
                        <p>Next we’re going to change the TIME_ZONE setting to whichever time zone you’re currently in (for example, North American east coast time would be 'America/New_York'). A list of the time zone names can be found here <a href="http://en.wikipedia.org/wiki/List_of_tz_zones_by_name" target="_blank">http://en.wikipedia.org/wiki/List_of_tz_zones_by_name.</a></p>

                    <h2 id="specifyingdirectory">Specifying Your Template Directory</h2>
                        <p>The next thing we’re going to do is specify which directory our template files are going to be. The first thing we need to do is create a directory called “templates” in the poll_manager directory. When that’s completed, head back to your settings.py files and scroll down to TEMPLATE_DIRS. Here you need to put in the file path to the templates folder, which might look something like:</p>
                        <pre>'/home/ public_python/poll_manager/templates'</pre>
                        <p>or</p>
                        <pre>‘C:/www/poll_manager/templates’</pre>

                    <h2 id="specifyingapps">Specifying Installed Apps</h2>
                        <p>Finally, we need to scroll down to INSTALLED_APPS and do two things:
                            <ul>
                                <li>Comment out 'django.contrib.auth'</li>
                                <li>Add 'polls' to the bottom of the list</li>
                            </ul>
                        <p>We don’t necessarily need the auth app for this tutorial, so we’re commenting it out to save some database space. Adding ‘polls’ to the bottom will enable the polls app we’re building to work on the website we will be creating.</p>
            </section>

            <section role="region">    
                <h1>Setting Up Models</h1>    
                    <p>Head into your “polls” app folder and open up models.py. The first thing we need to do is import two modules into the file, so put the following code at the top of your document:</p>
                    <pre>from django.db import models
from django.forms import ModelForm </pre>
                    <p>These two lines will enable the use of models and model forms in your document.</p>

                    <h2 id="setupdatabase2">Setting Up the Database</h2>
                        <p>Now it’s time to set up our database. The first thing we need to do is create a new database in phpmyadmin. For the sake of this tutorial, let’s name it "polls."</p>

                    <h2 id="createpollmodel">Creating the Polls Model</h2>
                        <p>Next, it’s time to set up our tables. Let’s head back over to models.py and make the table for the actual poll. We’re going to want this table to contain two colums; the name of the question and the date the poll was created. To do this, we write the following code:</p>

                        <pre>class Poll(models.Model):
        question = models.CharField(max_length=255)
        date = models.DateTimeField(auto_now_add=True)
    
        def __unicode__(self):
            return self.question</pre>

                        <p>This model is set up to do a couple things:</p>
                        <ul>
                            <li>Creates a colums named “question” with a max length of 255 characters</li>
                            <li>Creates a column named “date” that automatically adds the current date and time when the user creates a poll</li>
                        </ul>

                    <h2 id="createchoicemodel">Creating the Choices Model</h2>
                        <p>Now we’re going to create a model for our choices. For this model, we’re going to use the “Poll” model as a foreign key and create a choice column to store the choices for our polls. Insert the following lines of code into your “models.py” document:</p>
                        <pre>class Choice(models.Model):
        poll = models.ForeignKey(Poll)
        choice = models.CharField(max_length=255, blank=True)</pre>
                        <p>This model looks very similar to the last one, with a couple very minor changes. As you can see, we set up “poll” as a foreign key for the “Poll” model, and added a choice column that accepts a max length of 255 characters.</p>

                    <h2 id="createvotemodel">Creating the Votes Model</h2>
                        <p>Now that we have a table to house our polls and choices, we need a new table to keep track of votes. To do this, we’re going to create two columns in this table that are foreign keys of the other two models we’ve created. The code for this model looks like this:</p>
                        <pre>class Votes(models.Model):
        poll = models.ForeignKey(Poll)
        choiceVote = models.ForeignKey(Choice)</pre>
                        <p>We’ve created our models…now what? The next step is to create forms that relate to these models, which Django makes incredibly easy. There are two ways to create forms in Django; you can create a forms.py page and create your forms there, or you can create something called a Model Form in models.py. For this tutorial, we’re going to do the latter.</p>

                    <h2 id="pollform">Poll Form</h2>
                        <p>For this poll manager, we’re only going to need two forms – one to create polls and another to add choices to your poll. First, let’s create the model form for the “Poll” model:</p>
                        <pre>class PollForm(ModelForm):
        class Meta:
            model = Poll</pre>
                        <p>Here’s what we just did:</p>
                            <ul>
                                <li>We created a model form called PollForm, which we can later call to use in our views</li>
                                <li>We declared that this form is going to use metadata from the model named Poll</li>
                            </ul>

                    <h2 id="choiceform">Choice form</h2>
                        <p>Next up, we’re going to create the form to input choices. The code for this looks exactly like the code we used to create “PollForm”, with one small difference:</p>
                        <pre>class ChoiceForm(ModelForm):
        class Meta:
        model = Choice
        fields = ('choice',)</pre>
                        <p>The “fields” option lets us choose which input fields we want the form to display. Alternatively, we could have written exclude = (poll,), which would have essentially done the same thing.</p>
            </section>

            <section role="region">  
                <h1>Setting up the Views, Templates, and URLs</h1> 
                    <p>Now that we have our database, models, and forms set up, we can go ahead and write our views. We’re also going to be creating our templates and URLs for our views simultaneously.</p>

                    <h2 id="importviews">Imports for views.py</h2>
                        <p>Open up views.py and add this to the top of the page. These are the modules we’re going to be using for this tutorial:</p>
                        <pre>from django.http import HttpResponseRedirect, HttpResponse
from django.template import Context, loader, RequestContext
from django.shortcuts import render_to_response, render
from models import Poll, Choice, Votes, PollForm, ChoiceForm</pre>

                    <h2 id="indexpage">Index Page</h2>
                        <p>The index page is going to be very short and sweet. Let’s head to views.py and add the following code:</p>
                        <pre>def index(request):
        return render_to_response('index.html', context_instance = RequestContext(request),)</pre>

                        <p>All we’re doing in this view is linking it to a template. Now let’s open up urls.py and add the following URL:</p>
                        <pre>url(r'^$', 'poll_tutorial.polls.views.index', name = 'index'),</pre>
                        <p>Finally, let’s set up our template. Create a document called index.html and add the following. The code for this is going to be short and sweet:</p>
                        <pre>&lt;!DOCTYPE html>
&lt;html&gt;
&lt;head&gt;
    &lt;meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /&gt;
    &lt;title>Poll Manager Home&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;

    &lt;p>Welcome!&lt;/p&gt; 
    &lt;p>&lt;a href="{% url polls %}">View Polls&lt;/a>&lt;/p&gt;
    &lt;p>&lt;a href="{% url add_poll %}">Add a poll&lt;/a>&lt;/p&gt;  
        
&lt;/body&gt;
&lt;/html&gt;</pre>
            </section>

            <section role="region">        
                
                    
            </section>

            <section role="region">        
                <h1 id="addingpolls">Adding Polls</h1>
                    
            </section>

            <section role="region">        
                <h1 id="addingchoices">Adding Choices</h1>
                    
            </section>

            <section role="region">        
                <h1 id="viewactivepolls">Viewing a List of All Active Polls</h1>
                    
            </section>

            <section role="region">        
                <h1 id="viewsinglepoll">Viewing a Single Poll</h1>
                    
            </section>

            <section role="region">        
                <h1 id="addingvotes">Adding Votes to the Database</h1>
                    
            </section>

            <section role="region">        
                <h1 id="displayresults">Displaying the Results</h1>
                    
            </section>

            <section role="region">        
                <h1 id="testing">Testing Out Your Site</h1>
                    
            </section>
         </section>
    </main>
    
    <?php include('footer.html'); ?> <!-- footer.html -->

</body>