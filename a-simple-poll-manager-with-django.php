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
                        <p>This is going to break our website when we try to run it until we write our views and URLs for adding and viewing polls, but that’s okay! We’ll get to that soon enough.</p>

                    <h2 id="addingpolls">Adding Polls</h2>
                        <p>Alrighty, it’s time to set the page we’re going to use to create polls. Let’s start with the view:</p>
                        <pre>def add_poll(request):
        #calls the PollForm we created and displays it on the page
        if request.method == 'POST':
            form = PollForm(request.POST)
            if form.is_valid():
                form.save() 
                return HttpResponseRedirect('../.')
        else:
            form = PollForm()
        return render_to_response ('add_poll.html', {'form': form}, context_instance = RequestContext(request),)</pre>

                        <p>Everything here is pretty straight-forward. By default, the page loads up the PollForm. On submit, it checks and sees if the form is valid and saves the information if it is and redirects them to the add_choices page. If it isn’t, the form gets reloaded.</p>

                        <p>Now it’s time to add the URL for this view. Open up urls.py and write this code under the url for the index:</p>
                        <pre>url(r'^add_poll/$', 'poll_tutorial.polls.views.add_poll', name = 'add_poll'),</pre>
                        <p>To wrap up this view, we need to complete the template for it. Create a new HTML file and add the following code:</p>

                        <pre>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /&gt;
    &lt;title>Add a Poll&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;

    &lt;p&gt;Add a Poll&lt;/p&gt;
    &lt;form name="addPoll" action "/add_choices/" method="post"&gt; {% csrf_token %}
        &lt;fieldset&gt;     
                    &lt;label id="questionID" for="id_question"&gt;Question:&lt;/label&gt; {{form.question}}
            &lt;input id="submit" type="submit" value="Submit" /&gt;
        &lt;/fieldset&gt;
    &lt;/form&gt;
        
&lt;/body&gt;
&lt;/html&gt;</pre>
                        <p>This template is also pretty straight forward. We have a form with an input field which we call from Django (which, if you look, is the question field in the Poll table). When the form is submitted, Django saves whatever was in the input field into our database.</p>

                    <h2 id="addingchoices">Adding Choices</h2>
                        <p>Since we can now create polls we’re going to need the option to add choices to it. Open up views.py and add the following code:</p>
                        <pre>def add_choice(request, poll_id):
        poll = Poll.objects.get(id = poll_id)
        if request.method =='POST':
            form = ChoiceForm(request.POST)
            if form.is_valid():
                # uses false commit to save the poll as the current poll ID, sets the initial vote to 0, and saves all choices the user
                # has put in the form
                add_poll = form.save(commit = False)
                add_poll.poll = poll
                add_poll.vote = 0
                add_poll.save()         
                form.save()
            return HttpResponseRedirect('../')
        else: 
            form = ChoiceForm()
        return render_to_response ('add_choices.html', {'form': form, 'poll_id': poll_id,}, 
                                context_instance = RequestContext(request),)</pre>

                        <p>Here’s what we’re doing in this view:
                            <ul>
                                <li>The first thing we’re doing is pulling the current poll ID from the URL. This allows us to save the poll ID to a variable and input that variable into the database.</li>
                                <li>Next, we attempt to save the information in the form to the database.
                                    <ul>
                                        <li>If the form is valid, we’re going to use a false commit to save multiple values into the database. We’re saving the poll ID number into the database as well as initializing the vote count to 0.</li>
                                        <li>If the form is not valid (as seen in the else statement), the page gets reloaded and the form is wiped clean.</li>
                                    </ul>
                                </li>
                            </ul>
                        <p>If the form is valid and the data is accepted, the user is redirected to the page where the poll’s information is displayed.</p>
                        <p>Now that we have out view set up, let’s add the following to urls.py:</p>
                        <pre>url(r'^polls/(?P&lt;poll_id&gt;\d+)/add_choices/$', 'poll_tutorial.polls.views.add_choice', name = 'add_choice'),</pre>

                        <p>This url is a little different from the previous two. The difference here is (?P&lt;poll_id&gt;\d+), which allows us to add (and extract) the poll ID to the url.</p>

                        <p>To wrap this view up, we need to create the template for it. This template is going to look exactly like the add_polls template we created earlier:</p>
                        <pre>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /&gt;
    &lt;title>Add a Poll&lt;/title&gt;
&lt;/head&gt;&gt;
&lt;body&gt;
    &lt;p&gt;Add Choices&lt;/p&gt;
    &lt;form id="choice" name="" action="" method="post"&gt; {% csrf_token %}
        &lt;fieldset&gt;
            &lt;label for="id_choice"&gt;Choice: &lt;/label&gt;{{form.choice}}
        
            &lt;input id="submit" type="submit" value="Submit" /&gt;
        &lt;/fieldset&gt;
    &lt;/form&gt;

&lt;/body&gt;
&lt;/html&gt;</pre>

                        <h2 id="viewactivepolls">Viewing a List of All Active Polls</h2>
                            <p>Great! We’ve created a poll and added choices to it! But now we need a page to display the poll we just created, as well as any other poll we might create in the future. Let’s open up views.py and add the following:</p>
                            <pre>def view_polls(request):
        poll_query = Poll.objects.all().order_by('date')
        return render_to_response('polls.html',{'poll_query': poll_query, })</pre>
                            <p>This view is very simple – all it does is makes a query that grabs all the polls in the database and displays them by date created. Now let’s make the url for it:</p>
                            <pre>url(r'^polls/$', 'poll_tutorial.polls.views.view_polls', name = 'polls'),</pre>

                            <p>Finally, let’s create the template for it:</p>
                            <pre>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /&gt;
    &lt;title&gt;Vote!&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;p&gt;Here's a list of polls&lt;/p&gt;
    {% if poll_query %}
    &lt;ul&gt;
        {% for poll in poll_query %}
            &lt;li&gt;&lt;a href='{{poll.id}}/'>{{poll.question}}&lt;/a&gt;&lt;/li&gt;
        {% endfor %}
    &lt;/ul&gt;
    {% else %}
        &lt;p&gt;There are no polls available.&lt;/p&gt;   
    {% endif %}

&lt;/body&gt;
&lt;/html&gt;</pre>

                            <P>Here’s a quick rundown of what’s going on in this template:</p>
                                <ul>
                                    <li>Essentially what we’re doing is checking if there are any polls in the database.
                                        <ul>
                                            <li>If there are polls in the database, an unordered list is created and lists all the polls in the database as a link (we’ll be using these links later)</li>
                                            <li>If there are no polls in the database, a paragraph stating “there are no polls available” is displayed.<li>
                                        </ul>
                                    </li>
                                </ul>

                        <h2 id="viewsinglepoll">Viewing a Single Poll</h2> 
                            <p>Remember those links we created on the polls page in the last section? Now we’re going to use internet sworcery to make them do stuff! Open up views.py and add the following:</p>
                            <pre>def view_single_poll(request, poll_id): 
        poll = Poll.objects.get(id=poll_id)
        choices = poll.choice_set.all().order_by('id')
        return render_to_response('poll_info.html', {'poll': poll, 'choices':choices,}, context_instance = RequestContext(request),)</pre>
                            <p>This view (coupled with the template) creates a page where the title, choices, and results (eventually) will be displayed for a single poll. Now let’s add the URL for it:</p>
                            <pre>url(r'^polls/(?P&lt;poll_id&gt;\d+)/$','poll_tutorial.polls.views.view_single_poll'),</pre>

                            <p>And finally, let’s create the template:</p>
                            <pre>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /&gt;
    &lt;title&gt;Add a Poll&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;p&gt;&lt;a href="add_choices/">Add choices&lt;/a&gt;&lt;/p&gt;
    &lt;p&gt;&lt;a href="vote/">Click here to vote&lt;/a&gt;&lt;/p&gt;
    {% for choice in choices %}
        &lt;p class="resultsList"&gt;{{choice.choice}} - {{choice.votes_set.count}}&lt;/p&gt;
    {% endfor %}
        
&lt;/body&gt;
&lt;/html&gt;</pre>

                            <p>Here’s a quick rundown of what’s going on in this template:</p>
                                <ul>
                                    <li>At the top of the page, we have two links – one linking to the add choices page we created earlier and other that will lead us to a page where we can vote on the poll.</li>
                                    <li>Under the links is a for loop that goes through the choices for the poll and displays them along with the number of votes for that choice.</li>
                                </ul>

                        <h2 id="addingvotes">Adding Votes to the Database</h2>
                            <p>Okay, now that we have our polls and choices set up, we need to set up a way to vote. Open up views.py and add the following view:</p>
                            <pre>def add_vote(request, poll_id):
        poll = Poll.objects.get(id=poll_id) 
        choice = Choice.objects.filter(poll=poll_id).order_by('id')
        if request.method == 'POST':
            vote = request.POST.get('choice')
            if vote:
                vote = Choice.objects.get(id=vote)  
                #saves the poll id, user id, and choice to the Votes table
                v = Votes(poll=poll, choiceVote = vote)
                v.save()
                #redirects the user to the results page after they submit their vote
                return HttpResponseRedirect('../')
        return render_to_response('votes.html',{'choice': choice, 'poll': poll, 'vcount': vcount,}, context_instance=RequestContext(request))</pre>

                            <p>Here’s what this view does:</p>
                                <ul>
                                    <li>First, it grabs the poll ID from the URL</li>
                                    <li>Next, we use a query to get all the choices in the poll and display them by ID (which is the same as date created in this case)</li>
                                    <li>On form submit, django saves whatever choice in checked in the form to the variable “vote”</li>
                                    <li>If the user chose a vote, django then saves the poll ID and the choice ID into the database, and then returns the user to the previous page (poll_info.html)</li>
                                </ul>
                            <p>URL time! Throw this bad boy into urls.py:</p>
                            <pre>url(r'^polls/(?P&lt;poll_id&gt;\d+)/vote/$', 'poll_tutorial.polls.views.add_vote', name = 'vote'),</pre>
                            <p>Let’s wrap this baby up, template style!</p>

                            <pre>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /&gt;
    &lt;title&gt;Vote!&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;p&gt;{{poll.question}}&lt;/p&gt;
    {% if choice %}
    &lt;form method="post" action="" id="voteForm"&gt;{% csrf_token %}
        &lt;fieldset&gt;
            {% for choice in choice %}
                &lt;p&gt;&lt;input type="radio" name="choice" id="choice" value="{{choice.id}}" /&gt;
                &lt;label for="choice{{forloop.counter&gt;{{choice.choice}}&lt;/label&gt;&lt;/p&gt;
            {%endfor%}
                
            &lt;input type="submit" id="submit" value="Submit" /&gt;
        &lt;/fieldset&gt;
            
    &lt;/form&gt;
    {% else %}
    &lt;p class="noChoice">No votes have been added to this poll yet!&lt;/p&gt;
    {% endif %}


&lt;/body&gt;
&lt;/html&gt;</pre>

                            <p>In layman’s terms:</p>
                                <ul>
                                    <li>First we check if there are any choices in the database for this particular poll.</li>
                                    <li>If the poll does have choices, we display the form.</li>
                                    <li>We use a for loop to loop through and display every choice for this poll as an option with a radio button next to it.</li>
                                    <li>If there are no choices in the database, an error message (shown in the if statement) is displayed on the screen.</li>
                                </ul>

                        <h2 id="displayresults">Displaying the Results</h2> 
                            <p>Final stretch! We’ve already set up the template for the results (in poll_info.html), so all we have to write is the view:</p>
                            <pre>def view_results(request, poll_id):
        # displays the choices and the number of votes they have - diaplaying the number of votes is done in the view_results template
        poll = Poll.objects.get(id=poll_id)
        choices = poll.choice_set.all()
        return render_to_response('poll_info.html', vars())</pre>

                        <h2 id="testing">Testing Out Your Site</h2>
                            <p>And there we have it! Now start your command line, navigate to your project folder, and enter the following command:</p>
                            <pre>python manage.py runserver</pre>
                            <p>Your command prompt should now print an address that you can copy and paste in your browser. Vola! A working poll manager!</p>
            </section>  
         </section>
    </main>
    
    <?php include('footer.html'); ?> <!-- footer.html -->

</body>