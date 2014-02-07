<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OAuth Python Tutorial - Techrangers</title>

<script type="text/javascript" src="http://teach.ucf.edu/wp-content/themes/online/pulldown/online-dropdown.js?2013-12"></script>
<script type="text/javascript" src="http://universityheader.ucf.edu/bar/js/university-header.js"></script>
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<body>

    <?php include('header.html'); ?> <!-- header.html -->
    
    <main role="main" id="oauthpythonmain">
        <!-- main content -->
        <div id="title">
            <h1>OAuth Python Tutorial</h1>
        </div>
        
        <?php include('sidebar.html'); ?> <!-- sidebar.html -->
        
        <section role="region" class="pagecontent" id="oauthpythonpage">
   
            <section role="region">
                <p class="tutauthor">Created By: Munawar Bijani on May 2<sup>nd</sup>, 2012</p>
                <p>This tutorial explains how to use OAuth 1.0 with Python and the Django framework.</p>

                <h1>Table of Contents</h1>
                    <ol>
                        <li><a href="#overview">Overview</a></li>
                        <li><a href="#oauth">OAuth</a></li>
                        <li><a href="#writingcode">Writing Code</a></li>
                        <li><a href="#testsite">Test Site</a></li>
                        <li><a href="#summary">Summary</a></li>
                    </ol>
            </section>
            
            <section role="region">        
                <h1 id="overview">Overview</h1>
                    <p>If you were around during the last few years or so, chances are you have heard of <a href="http://www.twitter.com/" target="_blank">Twitter</a>, a “microblogging service” that lets you send no more than 140 characters of your life’s history at a time. In this tutorial, we’ll interface to Twitter from code–not their website. You’ll learn how to send a tweet to your Twitter account, but you can expand on this as much as you like.</p>

                    <p>Essentially, we’re going to build a generic <a href="http://www.oauth.net/core/1.0" target="_blank">OAuth</a> module using Python. Then, we’ll use the OAuth module to interface to Twitter. Our test site will be written using the Django Python Framework.</p>
            </section>
            
            <section role="region">        
                <h1 id="oauth">OAuth</h1>
                    <p>At this point you have two choices: either read the OAuth 1.0 technical specifications linked earlier with all of its formalities and official language, or just let me explain it. Yes, I thought so.</p>

                    <h2>What is OAuth?</h2>
                        <p>OAuth stands for Open Authentication Protocol. The protocol lets you act on a person’s behalf (I.E.: impersonate them) and do things to a website. Before OAuth, doing this required the person who wanted to give you this access to hand over their user name and password. When your application wanted to send a request on the person’s behalf, it would give the website that person’s credentials and then make the request. The request would look something like:</p>
                        <pre>http://site.com/api/sync?username=user_name&amp;password=user_pass&amp;args=args</pre>

                        <p>There is one glaring problem with this approach: <strong>security</strong>. It became a real concern when sites stating they would not share or use your password for other than its intended purpose were breaking their part of the Terms of Service.</p>

                        <p>OAuth was developed with this in mind. With OAuth, you no longer share your username and password with an application. Instead, the application redirects you to the actual site (such as Twitter) and that site asks for your credentials, which the application never sees. The site, in turn, sends the application an <strong>access token</strong> which the application uses to make requests on your behalf. The great thing about this approach is that the access token is also stored with the endpoint site (Twitter,) and you can log in to your account on the endpoint and revoke the access token, thereby disallowing the application from making any further requests on your behalf–without even touching the application!</p>

                    <h2>Terms</h2>
                        <p>Before we discuss how to actually build an OAuth module, there are a few terms with which you should be familiar.</p>

                        <p>When we say “server,” this refers to the server you are sending a request to. For instance, if we wanted to interface with Facebook, Facebook would be our server. In this case, we’ll be interfacing with Twitter, so our server is Twitter.</p>

                        <p>By contrast, an <strong>endpoint</strong> is a specific URL on the server. Every command we send to the server has a URL associated with it; this is how the server knows what to do with our request. For instance, to send a tweet to your account, you might call the</p>
                        <pre>/1/statuses/update.json</pre>

                        <p>endpoint on the api.twitter.com server, so the entire URL would look like</p>
                        <pre>https://api.twitter.com/1/statuses/update.json</pre>

                        <p>If you wanted to get the public timeline, you might use</p>
                        <pre>/1/feed/timeline.json</pre>

                        <p>so the entire URL will look like</p>
                        <pre>https://api.twitter.com/1/feed/timeline.json</pre>

                        <p>In these cases, /1/statuses/update.json and /1/feed/timeline.json are <strong>endpoints</strong> on the api.twitter.com <strong>server</strong>. Think of endpoints as points where the request ends up. That is literally what they are when interfacing to an API.</p>

                    <h2>OAuth 1.0 Authorization Flow</h2>
                        <p>We also need to know the authorization flow before we actually start writing it. We’ll be using OAuth 1.0 here, not OAuth 2.0. Be careful with this distinction, since some sites use 1.0 and others use 2.0. They are different in their protocols. People tend to be much cooler if they can implement OAuth 1.0, since It’s the more difficult of the two versions to get correct.</p>

                        <p>If you would like access to impersonate a user, you first need a request token. We’ll see how to get this request token in more detail later on, but keep this term in mind, since it is how you start an OAuth handshake.</p>

                        <p>Once you get a request token and request token secret back from the server, the user using your application should be redirected to an <strong>OAuth Dialog</strong> where the server will ask them to enter their credentials.</p>

                        <p>Once the user enters their credentials, the server will redirect back to your application and provide two things:</p>
                            <ol>
                                <li>your original request token</li>
                                <li>a verifier string</li>
                            </ol>

                        <p>The request the server makes to your application will look like</p>
                        <pre>http://myapplication.com/callback?oauth_token=authToken&amp;oauth_verifier=verifierString</pre>

                        <p>The value in the oauth_token field is the same request token you sent to the server.</p>

                        <p>Your application sends the request token, and verifier string back to the server, encrypting it using the request token secret.</p>

                        <p>Finally, your application receives two things: an access token, and an access token secret. Now, when you want to make a request to an endpoint on the server, you will send your access token and other data, encrypted using the access token secret. This is how the server will know who made the request and whether it is legitimate or not.</p>

                    <h2>Signing Requests</h2>
                        <p>All of your requests must be signed using the HMAC-SHA1 hashing algorithm. The server checks your hash to make sure it matches the hash it generates. If it does, the data you sent has not been compromised. So how do we actually sign things?</p>

                        <h3>Base String</h3>
                            <p>First, take the full “resource URL” you want to call. Add an ampersand (&amp;) before it, and put the HTTP method you will use before that, typically POST. Add another ampersand. So the Base String will look like</p>
                            <pre>POST&amp;http%3A%2F%2Fwww.example.com&amp;</pre>

                            <p>Next, sort all of your parameters in alphabetical order, add the name of the parameter to the string you started building, followed by a URL-encoded equals sign (%3D) followed by the parameter’s value.</p>

                            <p>If the parameter is not the last one, tack on a URL-encoded ampersand (%26) and include the next parameter, URL-encoded equals sign, and the parameter’s value. Do this until you have all the parameters listed.</p>

                            <p>This construction is called the <strong>Base String</strong>. An example base string is shown below.</p>
                            <pre>POST&amp;http%3A%2F%2Fapi.twitter.com%2Fapi%2Ftest.json&amp;parama%3Dparamaval%26paramb%3Dparambval%26version%3D1.0</pre>

                            <p>The parameter name and parameter value should be URL-encoded. We’ll build a function to handle URL encoding for us when we build our module. Also make sure the URL itself is encoded.</p>

                        <h3>Hashing</h3>
                            <p>The <strong>Base String</strong> is hashed using token credentials. Token credentials are different depending on what part of the OAuth handshake you are currently going through.</p>
                            <ul>
                                <li>If you’re asking for a request token, your token credentials are the consumer secret followed by an ampersand (&amp;) often called a “dangling ampersand.” This is because you don’t have a token yet, so there is no token secret.</li>
                                <li>If you have a request token and are requesting an access token, your token credentials are the consumer secret, an ampersand (&amp;), and the request token secret.</li>
                                <li>If you’ve received authorization and can now make requests on the user’s behalf, your token credentials are the consumer secret, followed by an ampersand (&amp;), followed by the access token secret.</li>
                            </ul>

                            <p>Whichever string is relevant to you, this string is what you apply as the key when applying the HMAC-SHA1 hashing algorithm. The Base String is the value to hash.</p>

                            <p>You send your final signature to the server along with the rest of the request as the <strong>oauth_signature</strong> parameter.</p>
            </section>
            
            <section role="region">        
                <h1 id="writingcode">Writing Code</h1>
                    <p>We’ll build this module step-by-step and write our code according to the OAuth flow. Once you have all the code written, you’ll be glad you read through all this preliminary information before scrolling down here. Having a basic understanding of the OAuth flow will help you understand the code more quickly.</p>

                    <h2>Imports</h2>
                        <p>We will use the import [modulename] syntax here instead of the from [modulename] import [function] syntax to make it more clear where the functions come from.</p>

                        <p>Imports typically go at the top of a module, so we’ll write them here.</p>
                        <pre>import urllib #for url-encode
import urllib2 #for getting and receiving data from server
import time #Unix timestamp
import hmac #for signing
import hashlib #for signing
import random #For nonce generation
import base64 #For conversion of hmac hash from bytes to human-readable string</pre>

                    <h2>Variables</h2>
                        <p>For the complete OAuth flow, we need a place to store:</p>
                        <ul>
                            <li>A request token</li>
                            <li>A request token secret</li>
                            <li>A consumer key</li>
                            <li>A consumer secret</li>
                            <li>An access token</li>
                            <li>An access token secret</li>
                        </ul>

                        <p>The variables we declare next are for this purpose. When we call a function to give us a request token, since we also need a request token secret from the server, we will set the request token secret variable. This way, we don’t have to return a list of values. The developer can simply read the oauth.requestTokenSecret variable.</p>

                        <pre>consumerKey = ""
consumerSecret = ""
accessToken = ""
accessTokenSecret = ""
requestToken = ""
requestTokenSecret = ""</pre>

                    <h2>Preliminary Functions</h2>
                        <p>We will only expose five functions for the developer to use. These will handle getting a request token, getting an access token, and making a request to the API. The final functions that will be exposed will set up some initial variables. The rest of the functions are functions that will only be used internally. This is why you will see an underscore (_) before the name. If a function name is preceeded by an underscore, when a developer writes</p>
                        <pre>from oauth import *</pre>

                        <p>the function will not be imported. This follows OOP practices of “data hiding,” although the developer can still explicitly call the function by referencing the module name:</p>
                        <pre>oauth._some_hidden_function()</pre>

                        <p>In other OOP languages, this is not true. Hiding a function prevents ALL outside access.</p>
                        <p>First, the functions to set up some variables.</p>
                        <pre>def setConsumerCreds(ckey, csecret):
        global consumerKey
        global consumerSecret
        consumerKey = ckey
        consumerSecret = csecret</pre>

                        <p>This function initializes the consumer key and secret variables. The consumer key and consumer secret are values you receive from the server when you register your application. You can log in to your account and dev.twitter.com and find these values. The consumer key is how Twitter identifies your application when you send requests. You will need read and write access to post a tweet. Click settings in your application’s control panel on dev.twitter.com and change the access type from read only to read and write. Next, click Details, and click Reset. You will be asked if you want to reset your consumer key and secret. Confirm the action, and your key and secret will change and will now have read and write permissions. Use the new pair of keys from now on to make requests.</p>
                        <pre>def set_access_token(key, secret):
        global accessToken
        global accessTokenSecret
        accessToken = key
        accessTokenSecret = secret</pre>

                        <p>This function initializes the access token and secret. We will discuss these later.</p>
                        <p>Take a look at the first two lines of the function that begin with the word</p>
                        <pre>global</pre>

                        <p>If you are used to other OOP languages, take note that Python handles global variables differently than other languages. If we declare a global variable like consumerKey, we can’t simply use it inside a function within the module unless we tell Python explicitly that the variable we are talking about is, in fact, the global version, and not a shadow copy.</p>

                        <p>If we leave out the two global lines, when we set consumerKey equal to ckey, Python will create a local variable called consumerKey and assign to it the value of ckey. We want the ckey value to go into the global variable consumerKey so other functions can refer to it, so we write</p>
                        <pre>global consumerKey</pre>

                        <p>to make consumerKey a global reference.</p>
                        <p>This convention is not needed when reading from global variables, only when you wish to write to them.</p>

                        <h3>Base String Function</h3>
                            <p>The first order of business we will take care of is the Base String. This is the most fundamental part of an OAuth request since it is directly involved in the signing process, so we’ll get it out of the way.</p>

                            <pre>def _get_base_string(resourceUrl, values, method="POST"):
        # In the format METHOD&amp;encoded(resource)&amp;parameter=value&amp;parameter=value&amp;...
        baseString = method + "&amp;" + url_encode(resourceUrl) + "&amp;"
        #The parameters and values should be sorted by name, and then by value.
        sortedKeys = sorted(values.keys())
        #We use sorted() as opposed to values.keys().sort() so we don't modify the original collection.</pre>

                            <p>Now, sortedKeys holds all the keys in the values dictionary in sorted order. Notice how we string them together with the URL-encoded equals sign and ampersand to delimit them.</p>
                            <pre>for i in range(len(sortedKeys)):
        baseString = baseString + url_encode(sortedKeys[i] + "=") + url_encode(url_encode(values[sortedKeys[i]]))</pre>

                            <p>Next, we take care of the end case. If this is the last parameter, we don’t add an ampersand, or we’ll have a trailing ampersand and the generated signature will be different from what is expected by the server, causing authorization to fail.</p>
                            <pre>#Don't put an encoded &amp; at the end of the string; trailing ampersands are not allowed here.
        if i &lt; len(sortedKeys) - 1:
            baseString = baseString + url_encode("&amp;")
    return baseString</pre>

                            <p>A few points to note are the following.</p>
                            <ul>
                                <li>We don’t have a url_encode function yet. We’ll write one later.</li>
                                <li>We use the sorted() function to sort the values.keys collection. This way, we get a copy of the sorted collection, as opposed to calling values.keys().sort() which does an “in place” sort, so it actually modifies the order of the original collection. We don’t use the .sort() approach since it is not safe to modify the collection when the caller may be expecting it to be completely unchanged.</li>
                                <li>The len() function returns the length of a collection. We use the range function, omitting the lower-boundary argument to imply “start from zero.” The upper-bounds is exclusive.</li>
                            </ul>

                        <h3>The OAuth Parameters</h3>
                            <p>There are several parameters that are part of the OAuth request. Most of them are self-explanatory, but a few to note are listed here.</p>
                            <ol>
                                <li>oauth_nonce: This parameter contains a “nonce” or “only once string”; it is a unique string that changes on each OAuth request. There is no specification on how the nonce should be constructed, but it’s important to make sure it changes on each call; it is how the server knows there are no duplicate requests.</li>
                                <li>oauth_token: This value changes based on the stage of the OAuth handshake. Before authorization and when getting a request token, this parameter is excluded entirely. When retrieving an access token, this parameter is set to the request token. Once an access token has been obtained, this parameter, for all future requests, is set to the access token.</li>
                            </ol>

                            <p>Notice that addAccessToken is an optional parameter. In Python, you can specify optional parameters by specifying their default values if the parameters are not passed.</p>

                            <pre>def _add_oauth_parameters(parameters, addAccessToken = True):
        parameters["oauth_consumer_key"] = consumerKey
        if (addAccessToken):
            parameters["oauth_token"] = accessToken
        parameters["oauth_version"] = "1.0"
        #Nonce in our case is a numeric value, but we need
        #to cast it to a string so it can be url-encoded.
        parameters["oauth_nonce"] = str(_get_nonce())
        parameters["oauth_timestamp"] = str(_get_timestamp())
        parameters["oauth_signature_method"] = "HMAC-SHA1"</pre>

                            <p>Since we are expecting a dictionary, we can add values to the dictionary by simply specifying the index as we have done. If you specify a key that does not exist, Python gracefully handles the error and adds the key quietly in the background, setting its value to what you specify. Be careful, since making a typographical error in the key will create a new key with no error; this has the potential for very nasty consequences.</p>

                            <p>Dictionaries let you index them using keys instead of integers. The order of the keys is <strong>undefined</strong> since they are implemented as hash tables, so if you iterate over a dictionary, don’t be surprised if the order of keys you are getting back is not the order in which you inserted the keys into the dictionary. The advantage to implementing the dictonary as a hash table is that there is a one-to-one mapping between keys and values, so fetching a value based on a key takes constant time.</p>

                        <h3>Generating a Nonce Value</h3>
                            <p>The nonce must be unique within a small time frame. Our nonce implementation will simply choose a number between 1 and 999,999,999, but this is not a recommended approach. As a bonus to enhance your oauth module, you should think of a way to generate a much stronger nonce value to minimize the chances of a duplicate nonce being sent within the allowable time frame.</p>

                            <pre>def _get_nonce():
        # Simply choose a number between 1 and 999,999,999
        r = random.randint(1, 999999999)
        return r</pre>

                            <p>The random module has a function called randint(), which accepts two arguments–the lower and upper-bounds of the generated random number, inclusive.</p>

                        <h3>Getting a UNIX Timestamp</h3>
                            <p>The oauth_timestamp field requires a <a href="http://www.unixtimestamp.com/index.php" target="_blank">UNIX timestamp</a>. Python lets us retrieve the current timestamp using the time module. We demonstrate this by filling in another function.</p>
                            <pre>def _get_timestamp():
        return int(time.time())</pre>

                            <p>Notice that we cast the return of time.time() to an integer. In actuality, the timestamp is a floating-point value since it accounts for fractional seconds as well, so the current timestamp may be 1333127158.005. However, we want the integer part only since APIs typically let slide some precision to account for a two to three minute inaccuracy.</p>

                            <p>The timestamp must be as current as possible. If your server clock is off by more than five minutes, this will result in authorization errors due to inaccurate timestamps. In the case of Twitter, the server will return an error like “Failed to validate oauth signature and token,” which doesn’t tell you much. However, if you’re sure you’ve constructed your parameters correctly, the only other place to look is at your timestamp. The site linked earlier has a handy tool for converting timestamps into human-readable date strings, and you can use this to see exactly what timestamp your program is sending to the API.</p>

                            <p>Other APIs tend to be more verbose, and may return something like “oauth_timestamp field is out of range. Accepted values are between X and Y.” You can translate these values to human-readable time values to find out by how much your clock is off, and adjust accordingly. Remember: the API server’s clock isn’t wrong, it’s your clock. Welcome to the world of APIs! No more setting your clock back to trick a program into unlocking its trial for an extra fifteen minutes. Now you have to choose between playing that game, or tweeting with your super-cool app.</p>

                        <h3>Hashing a String</h3>
                            <p>The next item to complete is getting the OAuth signature. Remember that the OAuth protocol we are following uses the HMAC-SHA1 hashing algorithm. Although the OAuth protocol itself does not specify what signature should be used (it’s open-ended,) the server should specify some guidelines. Twitter requires HMAC-SHA1. Since we are building this module mainly to work with Twitter, this is the hashing algorithm we will use. An excellent exercise for expansion of this module would be for you to allow for other hashing algorithms.</p>
                            <pre>def _get_signature(signingKey, stringToHash):</pre>

                            <p>When you want to hash something, Python provides the</p>
                            <pre>hashlibs</pre>

                            <p>module. This module contains several algorithms, including sha1, sha256, md5, etc.
We could have just created a sha1 object and given it the value to hash, but we actually want the HMAC version of sha1. Be aware of this distinction. The difference is that sha1 is a value-based hash, and the HMAC version accepts a “signing key” to use when encrypting the value. Since we have a key, we can’t simply use sha1 because all we will give it is the Base String, with no signing key. Recall that the signing key is composed of token credentials, typically</p>
                            <pre>consumer_secret&amp;access_token_secret</pre>

                            <p>To convert the sha1 hashing into HMAC-SHA1, we use the HMAC object from the</p>
                            <pre>hmac</pre>

                            <p>module. While Python is mostly case-insensitive, this is an exception to the rule. the actual module name is lower-case, but the object name, HMAC, is upper-case.</p>
                            <pre>hmacAlg = hmac.HMAC(signingKey, stringToHash, hashlib.sha1)</pre>

                            <p>When we instantiate the HMAC object, we give it the signing key and value (stringToHash.) The stringToHash is what will be encrypted using the signingKey. Next, we tell the HMAC object which base hash to use by passing the sha1 object to the HMAC object’s constructor.</p>
                            <pre>return base64.b64encode(hmacAlg.digest())</pre>

                            <p>Notice how we return the base-64 encoding of the resulting hash, contained in</p>
                            <pre>hmacAlg.digest()</pre>

                            <p>Originally, the .digest() method returns the hash in bytes (eight-bit values.) To make it human-readable, we apply base-64 encoding to it. The array of bytes is first strung together as a bit stream. Then, the encoding maps every six-bit subsection to a human-readable character. The character set contains 64 possibilities (2^6,) hence the term "base-64."</p>
                            
                        <h3>URL-encoding</h3>
                            <p>When we transmit special characters over the internet, they need to be encoded so that they do not get misrepresented as meaningful characters. For instance, you’ve probably seen a query string:</p>
                            <pre>http://mysite.com/?id=453&amp;relationship=bob&amp;mary</pre>

                            <p>The ampersand in a query string is used toseparate parts of the query. However, in the second field we have an ampersand embedded into the value. I.E. The relationship field is equal to bob&amp;mary. This will confuse the parser since ampersands separate parameters, and should not be directly embedded into parameters. But what if we actually wanted to put an ampersand in the value? This is where URL-encoding comes in.</p>

                            <p>URL-encoding converts special-purpose characters such as the ampersand into hexadecimal notation based on the character’s ASCII value. For instance, the ASCII value for a space (” “) character is 32. In binary, it looks like</p>
                            <pre>0010 0000</pre>

                            <p>which is 0×20 in hexadecimal notation, so the URL-encoded space character is</p>
                            <pre>%20</pre>

                            <p>You’ve probably seen URLs like www.site.com/my%20article.html. In actuality, this represents www.site.com/my article.html.</p>
                            <p>The ampersand (ASCII code 38)</p>
                            <pre>0010 0110</pre>
                            <p>is converted into</p>
                            <pre>%26</pre>

                            <p>The percent synbol in a URL indicates that the next two characters are a hex representation.</p>
                            <p>When URL-encoded, our URL will look like this:</p>
                            <pre>http://mysite.com/?id=453&amp;relationship=bob%26mary</pre>

                            <p>When the server receives this query, it will parse the parameters, and convert the %26 back into an ampersand. So the server will actually read this as bob&amp;mary.</p>

                            <p>Python provides a function to encode URLs, which is part of the</p>
                            <pre>urllib</pre>
                            <p>module. However, we make a small function around it, to also encode the slash (/) character. The function accepts a string to URL-encode, and returns the URL-encoded version. The difference is in the second argument to urllib.quote(). The second parameter dictates which characters to leave alone and not encode. By default, the parameter is set to slash (/.) Since we want to encode ALL characters that may get in the way, we override the default and pass the empty string to symbolize that no special characters should be left out of encoding.</p>

                            <pre>def url_encode(data):
        return urllib.quote(data, "")</pre>

                            <p>Refer back to the _get_base_string function. For the parameters, we call url_encode(url_encode(parameter)). The reason we have two url_encode functions is to URL-encode the percent symbol in some of the parameters. For instance, the callback URL should be encoded as</p>
                            <pre>http%3A%2F%2Fwww.example.com%2Fcallback</pre>

                            <p>However, we also need to URL-encode the percent symbols. Percent symbols, when encoded, become %25, so we get</p>
                            <pre>http%253A%252F%252Fwww.example.com%252Fcallback</pre>

                        <h3>Giving Authorization Parameters</h3>
                            <p>The question that’s probably driving you mad by this point is, “Ok, this is all fine and dandy, but how do I actually tell the server I’m authorized to do X Y or Z?” Good question!</p>

                            <p>OAuth specifies three ways to send credentials: on the query string (completely not recommended,) post parameters (ok, but may have problems,) and the authorization HTTP header (now we’re talking!)</p>

                            <p>For our module we use the authorization header. A header is at the front of an HTTP request that gives the server information about the type of request, the length in bytes of the request, etc. For OAuth, we add one more header. The header looks like this. I’ve inserted line breaks just for readability, but when building your header, you would not include these line breaks.</p>

                            <pre>Authorization: OAuth oauth_consumer_key="xxxx",
oauth_token="xxxx",
oauth_version="1.0",
oauth_signature="xxxx",
...</pre>

                            <p>Both the parameter name and value should be URL-encoded. Typically, URL-encoding the parameter name will have no effect, since parameter names are, by convention, URL friendly to start with. However, the parameter value may be altered, especially in the signature since the base-64 encoding may contain characters like</p>
                            <pre>{=, &amp;, /}</pre>

                            <p>The only parameters that will go into the header are those parameters that include “oauth_” in their names. Also, we include the oauth_signature parameter. This is the signature we got from calling _get_signature() that we built in the last few sections.</p>

                            <p>Once the server sees this header, it will collect all the oauth_ parameters and construct the Base String just as we did. It will leave out the oauth_signature parameter since this is not part of the Base String. The server will then compute the oauth_signature value (remember, it already has our consumer secret and token secret.) If the signature it computes matches the one we gave it, it knows the data is in tact, since only we have access to our secret tokens (they are not sent with the request; they are only used for signing the Base String.) This is the purpose of the oauth_signature (yes, we don’t do all the hashing for nothing!)</p>

                            <p>Next, we build the function to get the authorization header. You’ll see how to actually add the header to the request later on.</p>
                            <pre>def _build_oauth_headers(parameters):
        header = "OAuth "
        sortedKeys = sorted(parameters.keys()) #although not necessary
        for i in range(len(sortedKeys)):
            header = header + url_encode(sortedKeys[i]) + "=\"" + url_encode(parameters[sortedKeys[i]]) + "\""
            if i &lt; len(sortedKeys) - 1:
                header = header + ","
        return header</pre>

                        <h2>Exposed Functions</h2>
                            <p>Now we will focus on the functions that are intended to be used by the caller of the module. Although the OAuth process may seem long and drawn out and complicated and annoying, it’s actually not that bad. We will work with three functions only, which will handle everything from the initial, I-need-a-request-token handshake up to actually making requests with an access token.</p>

                            <h3>Request Token and Authorization URL</h3>
                                <p>So, you’ve just registered your application, and received your consumer key and consumer secret. Now what?</p>

                                <p>First, put your consumer key and secret into the consumerKey and consumerSecret variables. The module will use these throughout the OAuth handshake. These values will not change unless you force them to, so you can consider these two variables as constant. When you distribute your module,, make sure you clear these values or someone will be able to impersonate your application.</p>

                                <p>If you’d rather not embed the key and secret directly into the module, we will provide the first “exposed” function that will set these values for you.</p>

                                <pre>def setConsumerCreds(ckey, csecret):
        global consumerKey
        global consumerSecret
        consumerKey = ckey
        consumerSecret = csecret</pre>

                                <p>Ok, so now what?</p>
                                <p>Recall that the OAuth process starts by you requesting some stuff and then you have to redirect the user to some place and get back some other stuff.</p>

                                <p>The function we will implement will do two things. It will get a request token for you, and also give you the URL to which you should redirect the user. It will expect three parameters. The first is the resource url that will let us get the request token. The next parameter, endpointUrl, is where we will redirect the user. The final parameter, callbackUrl, is the address to which the API will do a callback and give us the verifier string. This is the first function where you will be able to see all the functions in the module work together.</p>

                                <pre>def get_authorization_url(resourceUrl, endpointUrl, callbackUrl):
        oauthParameters = {}
        _add_oauth_parameters(oauthParameters, False)
        oauthParameters["oauth_callback"] = callbackUrl</pre>

                                <p>We add oauth_callback explicitly to the OAuth parameter collection. It tells the server where to send the user once the application has been authorized.</p>

                                <pre>baseString = _get_base_string(resourceUrl, oauthParameters)
signingKey = consumerSecret + "&amp;"</pre>

                                <p>In this step, the key we use to sign the request is just the consumer secret followed by an ampersand. Later down the OAuth flow, the signing key changes slightly.</p>
                                <pre>oauthParameters["oauth_signature"] = _get_signature(signingKey, baseString)</pre>

                                <p>We add the oauth_signature parameter after we compute the Base String, since there is no oauth_signature parameter in the Base String because the signature doesn’t exist yet.</p>
                                <pre>headers = _build_oauth_headers(oauthParameters)</pre>

                                <p>This gives us a string in the format of the Authorization header.</p>
                                <pre>httpRequest = urllib2.Request(resourceUrl)
httpRequest.add_header("Authorization", headers)</pre>

                                <p>To communicate with a server, we use the Request object found in the urllib2 module, NOT urllib. Remember: urllib contains the functions to encode and decode URLs, and urllib2 contains the functions to interact with servers.</p>

                                <p>the Request object contains a .headers property which is a dictionary whose key is the header’s name and whose value is the header’s contents. We set this dictionary equal to the key Authorization and the value of the authorization header by using the function</p>
                                <pre>add_header()</pre>

                                <p>Next, we send the request to the server. If the request fails, we simply return the server response back to the caller and let them deal with the error message.</p>
                                <pre>try:
    httpResponse = urllib2.urlopen(httpRequest)
except urllib2.HTTPError, e:
    return "Response: %s" % e.read()
responseData = httpResponse.read()</pre>

                                <p>Urllib2 defines a function called urloen which sends the final request to the server. Then, we use the read function on the Response object we get back to read all the data the server sent us in response to our request. The data will look something like</p>
                                <pre>oauth_token=xxxx&amp;oauth_token_secret=xxxx&amp;confirm=true</pre>

                                <p>Next, we just parse the data.</p>
                                <pre>responseParameters = responseData.split('&amp;') #gives is a list with each parameter / value pair
for s in responseParameters: #these are strings, so we're iterating over a list of strings.
    if s.find("oauth_token_secret")  -1:
        requestTokenSecret = s.split('=')[1]
    else:
        if s.find("oauth_token")  -1:
            requestToken = s.split('=')[1]</pre>

                                <p>We search for oauth_token_secret first and then for oauth_token. Otherwise, if we searched for oauth_token and put oauth_token_secret down to lower priority, searching for oauth_token will match both oauth_token and oauth_token_secret, so we’d have tokens that are switched around.</p>
                                <pre>return endpointUrl + "?oauth_token=" + requestToken</pre>

                                <p>This is the URL we will redirect the user to. We provide the request token on the query string.</p>

                                <p>When this function ends, there will be two additional pieces of information you will need to store for the OAuth flow. These are the requestToken and requestTokenSecret variables. The module itself will not handle storing these items, so we’ll have to handle this in the test case we write later.</p>

                            <h3>Getting the Access Token</h3>
                                <p>Refer back to the OAuth flow, and you will see that we have accomplished two things so far. Getting a request token, and redirecting the user to authorize our application. The next function we will build assumes that the server just redirected back to our website at the URL we provided in the oauth_callback parameter. Remember that the module is not self-contained, so we need to give it all the data again, namely the request token and request token secret.</p>

                                <p>Also, when the server returns to our website, it will provide us with a value called the “verifier string,” seen as “oauth_verifier” on the query string.</p>
                                <pre>def get_access_token(resourceUrl, requestTok, requestTokSecret, oauth_verifier):
        global requestToken
        global requestTokenSecret
        global accessToken
        global accessTokenSecret
        requestToken = requestTok
        requestTokenSecret = requestTokSecret
        oauthParameters = {"oauth_verifier" : oauth_verifier, "oauth_token" : requestToken}
        _add_oauth_parameters(oauthParameters, False)
        baseString = _get_base_string(resourceUrl, oauthParameters)</pre>

                                <p>Notice how we add the verifier to oauth_verifier in the OAuth parameter collection. We also add the request token into the oauth_token parameter. This is because the OAuth specification states that when requesting an access token, the client (our application) must send the verifier string, along with the request token. These should be contained within the oauth_verifier and oauth_token fields, respectively.</p>

                                <p>If we set the secodn parameter to</p>
                                <pre>True</pre>

                                <p>the add_oauth_parameters function will add the access token to the oauth_token parameter. We don’t want this since we’re adding our own token, otherwise the oauth_token parameter will be set to "".</p>

                                <p>The rest of this function is almost identical to the last function we wrote.</p>
                                <pre>signingKey = consumerSecret + "&amp;" + requestTokenSecret
oauthParameters["oauth_signature"] = _get_signature(signingKey, baseString)
header = _build_oauth_headers(oauthParameters)
httpRequest = urllib2.Request(resourceUrl)
httpRequest.add_header("Authorization", header)
httpResponse = urllib2.urlopen(httpRequest)
responseParameters = httpResponse.read().split('&amp;')
for s in responseParameters:
    if s.find("oauth_token_secret")  -1:
        accessTokenSecret = s.split('=')[1]
    else:
        if s.find("oauth_token")  -1:
            accessToken = s.split('=')[1]</pre>

                                <p>The signature’s signing key is slightly different here. Instead of using</p>
                                <pre>consumerSecret&amp;</pre>
                                <p>we use</p>
                                <pre>consumerSecret&amp;requestTokenSecret</pre>

                                <p>This is because we now have full token credentials. In this stage we use the request token secret, but ultimately, our signing key will be the access token secret.</p>

                                <p>Once this method terminates, the accessToken and accessTokenSecret variables will be set. These should be stored permanently. Again, the module will not store the variables; this is up to us. The method also returns no value unlike the get_authorization_url method we wrote earlier.</p>

                            <h3>Sending Authorized Requests</h3>
                                <p>Now, we have our access token and access token secret. We can use these credentials to finally send requests to the server.</p>

                                <p>"But what happens to my request token, request token secret, and verifier string?" They go away. Once you’ve gotten here, these data are not needed anymore and you can get rid of them.</p>

                                <pre>def get_api_response(resourceUrl, method = "POST", parameters = {}):
        _add_oauth_parameters(parameters)
        baseString = _get_base_string(resourceUrl, parameters, method)
        signingKey = consumerSecret + "&amp;" + accessTokenSecret
        parameters["oauth_signature"] = _get_signature(signingKey, baseString)
        parameters2 = {}
        for s in sorted(parameters.keys()):
            if s.find("oauth_") == -1:
                parameters2[s] = parameters[s]
                del parameters[s]
        header = _build_oauth_headers(parameters)
        httpRequest = urllib2.Request(resourceUrl, urllib.urlencode(parameters2))
        httpRequest.add_header("Authorization" , header)
        httpResponse = urllib2.urlopen(httpRequest)
        respStr = httpResponse.read()</pre>

                                <p>The method parameter dictates the HTTP method to use. It defaults to</p>
                                <pre>POST</pre>
                                <p>The parameters dictionary dictates any additional parameters to add to the request besides the standard OAuth parameters. For instance, if you are tweeting something, you will provide the tweet in this collection as the parameter</p>
                                <pre>status</pre>

                                <p>Turn your attention to the folowing section of code:</p>
                                <pre>for s in sorted(parameters.keys()):
        if s.find("oauth_") == -1:
            parameters2[s] = parameters[s]
            del parameters[s]</pre>

                                <p>We remove all parameters from the collection that don’t begin with “oauth_”. This is because the OAuth specification states that only OAuth-specific parameters go into the Authorization header. Although we use all the parameters to build the Base String, we only use OAuth parameters to build the Authorization header. The rest of the parameters exist on the query string or in the post body of our request, whichever the API endpoint specifies. For Twitter, they go into the post body.</p>
            </section>
            
            <section role="region">        
                <h1 id="testsite">Test Site</h1>
                    <p>So far, we have built an OAuth module that runs independently and has high code reusability. You can import this module into any Python project and have full OAuth 1.0 capability. The next step is building a test site around this module.</p>

                    <p>We're going to use Django to accomplish this part of the tutorial. Note, however, that the module itself is written strictly in Python, so you do not need to have Django installed to use it. Now we are done building the module and are moving to testing.</p>

                    <p>At the end of this part you will have built a site that will let you send a tweet to your account.</p>

                    <h2>Coding a Test Site Using Django</h2>
                        <p>For our page-transition storage, we will take advantage of sessions. Setting up Django to use sessions is fairly straightforward. You can find detailed information <a href="https://docs.djangoproject.com/en/dev/topics/http/sessions/" target="_blank">on Django session objects here</a>. We will use the temporary files session storage. Django lets you store session data in a database, in the cache (please avoid that one because of short life-cycles,) or in the temporary directory on your system. The only reason we’re using sessions is to simplify things. For a production environment, you will be storing your access token and access token secret into a database, so that the next time the user visits your site, they do not have to log in to Twitter. Twitter does not expire the token ccredentials; the only way to invalidate them is if the user does so explicitly through their Twitter account or you use an API endpoint to invalidate their tokens.</p>

                        <p>To force Django to use the temporary files directory to store session data, find the SESSION_FILE_PATH setting in settings.py, and set it to None. I.E.:</p>
                        <pre>SESSION_FILE_PATH = None</pre>

                        <p>Next, find the SESSION_ENGINE setting and set it to “django.contrib.sessions.backends.file”. I.E.:</p>
                        <pre>SESSION_ENGINE = "django.contrib.sessions.backends.file"</pre>

                        <p>By setting SESSION_FILE_PATH to None, we tell Django to use the temporary directory to store session data. If you set the SESSION_FILE_PATH setting to something other than None, make sure your server has read and write permissions to that directory.</p>

                        <p>You should recall from your training that Django encourages “pretty URLs.” So the first step is for us to build our URL structure.</p>

                        <p>In urls.py:</p>
                        <pre>from djangoproj.views import getAuthUrl, callback_handler, tweet, update
urlpatterns = patterns('',
(r'^auth/$', getAuthUrl),
(r'^verify/$', callback_handler),
(r'^tweet/$', tweet),
(r'^update/$', update)
)</pre>

                        <p>This bit of code sets up four URLs:</p>
                        <ol>
                            <li>/auth/: This is where we will go to get a request token.
                            <li>/verify/: This is where Twitter will make a callback request to, and from where we will retrieve the verifier string.</li>
                            <li>/tweet/: This page will display a form for sending a tweet.</li>
                            <li>/update/: This page will show us the results of the tweet.</li>
                        </ol>

                        <h3>The Views</h3>
                            <p>As thus, we will also have four views in views.py.</p>
                            <pre>import oauth
from django.http import HttpResponse
from django.template import Context, RequestContext
from django.template.loader import get_template
def getAuthUrl(request):
        s = oauth.get_authorization_url("https://api.twitter.com/oauth/request_token",
        "https://api.twitter.com/oauth/authorize",
        "http://tux:12000/verify")
        request.session["request_token"] = oauth.requestToken
        request.session["request_token_secret"] = oauth.requestTokenSecret
        theTemplate = get_template("auth.txt")
        resp = theTemplate.render(Context({"authUrl" : s}))
        return HttpResponse(resp)</pre>

                            <p>Notice that when we call the get_authorization_url function, we use</p>
                            <pre>http://tux:12000/verify</pre>

                            <p>as the callback URL. Change this according to what port your server is running on.</p>

                            <p>Also notice that the resource URL is /request_token, and for the end point, we pass /authorize. This means that when we send an API request to get a request token, we are requesting to</p>
                            <pre>https://api.twitter.com/oauth/request_token</pre>
                            <p>and when we redirect the user, we are sending them to</p>
                            <pre>https://api.twitter.com/oauth/authorize</pre>

                            <p>The request token and secret gotten from Twitter is stored in the session object, for later retrieval.</p>
                            <p>The template auth.txt is stored in the templates directory, and is self-explanatory. It just displays a link for the user to click, built on the request token.</p>
                            <p>Next, we get an access token and secret, based on the verifier string in the previous view. So, the next view fires after Twitter calls back to /verify/:</p>

                            <pre>def callback_handler(request):
        s = request.GET["oauth_verifier"]
        r = request.session["request_token"]
        rs = request.session["request_token_secret"]
        oauth.get_access_token("https://api.twitter.com/oauth/access_token",
        r, rs, s)
        request.session["access_token"] = oauth.accessToken
        request.session["access_token_secret"] = oauth.accessTokenSecret
        theTemplate = get_template("verify.txt")
        resp = theTemplate.render(Context())
        return HttpResponse(resp)</pre>

                            <p>Notice how we retrieve values from the session before making an access token request. We then make the request for an access token, retrieve the oauth.accessToken and oauth.accessTokenSecret fields, and store those in the session for later retrieval.</p>

                            <p>request.GET is how you retrieve parameters from the query string. Recall from the discussion of the OAuth flow that when Twitter calls back to this page, it will look like</p>
                            <pre>http://tux:12000/verify?oauth_token=xxxx&amp;oauth_verifier=xxxx</pre>

                            <p>So the verifier string is on the query string, and we use request.GET["oauth_verifier"] to retrieve it.</p>

                            <p>We now have everything to make a request, so we move to the /tweet/ view:</p>
                            <pre>def tweet(request):
        theTemplate = get_template("tweet.txt")
        resp = theTemplate.render(RequestContext(request,
        {"accessToken" : request.session.get("access_token", ""),
        "accessTokenSecret" : request.session.get("access_token_secret", "")}))
        return HttpResponse(resp)</pre>

                            <ul>
                                <li>When we retrieve the session, we use the .get method instead of indexing the dictionary as usual. This way, if the session variable doesn’t exist, the application won’t crash, but just return an empty string. By doing this, you can simply start your server and go to server/tweet, enter your access token and secret manually, and send a tweet.<li>
                                <li>We use RequestContext instead of Context for the template. This is to protect against Cross-Site Forgery attacks. The details are a bit drawn out, but just keep in mind that if you wish to post forms between Django pages, you should use Request Context and not just Context.</li>
                            </ul>

                            <p>RequestContext takes one additional parameter, the HttpRequest object.</p>

                            <p>Once you click “Tweet,” you will be sent to /update/, whose view is next:</p>
                            <pre>def update(request):
        oauth.set_access_token(request.POST["access"], request.POST["secret"])
        s = oauth.get_api_response("https://api.twitter.com/1/statuses/update.json",
        "POST", {"status" : request.POST.get("status")})
        theTemplate = get_template("update.txt")
        resp = theTemplate.render(Context({"dump" : s}))
        return HttpResponse(resp)</pre>

                            <p>First, we give the module the access token and secret. Remember that when a new page loads, all data not saved is lost because the page is redrawn, so the oauth module has no record of the token information. Keep in mind that we built the module to not store anything externally so that it is more portable.</p>
                            <p>The API endpoint to send a tweet is </p>
                            <pre>/1/statuses/update.json</pre>

                            <p>We make a request and send it to the Twitter endpoint. The page will show us the response from Twitter.</p>

                            <p>If the tweet succeeded, you will get A LOT of JSON information, including the tweet’s ID, the time it was tweeted, and the actual tweet text. Twitter will also tell you if the tweet was truncated.</p>

                            <p>If you log in to your account, you will see the tweet appear in your timeline, with your application’s name next to it. Congratulations! You’ve just programmatically sent a tweet to your Twitter account!</p>
             </section>

             <section role="region">        
                <h1 id="summary">Summary</h1>
                    <p>In this tutorial you learned about Python’s urllib and urllib2 modules for encoding URLs and sending requests to servers. You saw how to build HTTP request headers and format them according to strict guidelines. In addition, you learned how to generate hashes of strings (a very useful topic in computer security.)</p>

                    <p>Finally, you integrated all this using Django and built a small but functional site that lets you send a tweet to your Twitter account, using sessions to store cross-page information instead of sending everything on the query string.</p>

                    <p>You now have a fully functional OAuth 1.0 module that you can use to interact with any API that uses the HMAC-SHA1 hashing algorithm and OAuth 1.0.</p>
             </section>
         </section>
    </main>
    
    <?php include('footer.html'); ?> <!-- footer.html -->

</body>
</html>