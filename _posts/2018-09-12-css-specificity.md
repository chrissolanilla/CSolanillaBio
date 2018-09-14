---
layout:     blog-post-template
title:      "CSS Specificity and why you shouldn't use !important."
date:       2018-09-10 10:00:00 -0400
categories: tech tutorial css
image:      2018-09-10-css-specificity.jpg
css:        2018-09-10-css-specificity.css
author:     "Keegan Berry"
---

CSS is frustrating to many. I think other than poor organization, a lot of the frustration has to do with not knowing how styles override other styles. It leads to confusion, messy and unorganized CSS, and a lot of hacks and convoluted CSS selectors. CSS Specificity helps us determine how styles interact with other conflicting styles.

## Cascading order
CSS Specificity allows us to determine which style selectors in our CSS take precedence. The first thing we need to take into account, however, is the Cascading Order. It sounds more complicated than it actually is, but essentially the Cascading Order has to do with how styles are overridden depending on their placement. To override a previously declared style, we simply have to declare it farther down in the document. But what if we have multiple documents, or styles placed in an external document and styles in the header of the HTML file? The Cascading Order helps us determine how styles will be overridden depending on their location. The order is as follows:

* Browser Default Styles
* External CSS Files (Linked or @import-ed)
* Internal CSS (in the <head>)
* Inline Styles (styles directly applied to elements)

It works kind of counter-intuitively, so just to explain further: inline styles override internal CSS, and internal css overrides external CSS files, and external CSS files override browser defaults. One way to think about it is like layers. The "closer" the style is to the element, the higher precedence it has. An inline style has the highest precedence because it’s literally written on the element. On the other hand, browser default styles (think Times New Roman, 16pt) are easily overwritten because they are farthest "away" from the element.

<img src="/assets/images/blog-imgs/2018-09-10-css-specificity/cascading-order.png" class="specificity-cascading-order" alt="CSS Cascading Order" title="CSS Cascading Order">

As an example let's say we had an HTML document with say, one paragraph tag, with the class of "intro" applied, like so:

<div class="code-sample">
<span class="code-sample-title">home.html</span>
<pre><code data-language="html">&lt;p class=&quot;intro&quot;&gt;
  Whoever is careless with the truth in small matters cannot be trusted with important matters.
&lt;/p&gt;
</code></pre>
</div>

In our CSS file, <code>content.css</code>, we have the following style definition:

<div class="code-sample">
<span class="code-sample-title">content.css</span>
<pre><code data-language="css">.intro {
  font-family: ‘Helvetica Neue’;
  color: green;
}
</code></pre>
</div>

When the paragraph is rendered in the browser it looks like this:

![Whoever is careless with the truth in small matters cannot be trusted with important matters.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-1-1.png "Whoever is careless with the truth in small matters cannot be trusted with important matters.")

Now, let's say we decided to add the following CSS into the <code><head></code> tag of the HTML document:

<div class="code-sample">
<span class="code-sample-title">content.css</span>
<pre><code data-language="css">.intro {
  color: navy;
}
</code></pre>
</div>

Now if we reload the browser, the paragraph looks like this:

![Whoever is careless with the truth in small matters cannot be trusted with important matters.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-1-2.png "Whoever is careless with the truth in small matters cannot be trusted with important matters.")

Now, as a final addition, let's add an inline style to the paragraph:

<div class="code-sample">
<span class="code-sample-title">home.html</span>
<pre><code data-language="html">&lt;p class=&quot;intro&quot; style=&quot;color: brown;&quot;&gt;
  Whoever is careless with the truth in small matters cannot be trusted with important matters.
&lt;/p&gt;
</code></pre>
</div>

If we reload the browser one final time, the paragraph looks like this:

![Whoever is careless with the truth in small matters cannot be trusted with important matters.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-1-3.png "Whoever is careless with the truth in small matters cannot be trusted with important matters.")

While not the most exciting example, you can see how the external CSS was overridden by the embedded CSS, and the embedded CSS was overridden by the inline style. This follows the Cascading Order, and it helps to keep in mind when thinking about Specificity.

## Specificity

With the Cascading Order, we were able to know how styles are overridden based on their location, in relation to the element. But what happens if we have multiple style selectors that both target the same element? Specificity allows us to determine which style takes precedence.

Let's go back to our paragraph example, but this time let's remove the inline style (since inline styles are generally not a good idea). While we're at it, let's go ahead and remove all the CSS declarations from the <code><head></code> as well as <code>content.css</code>. For the sake of this example, I'm also going to throw in another paragraph:

<div class="code-sample">
<pre><code data-language="html">&lt;body class=&quot;home&quot;&gt;
  &lt;p class=&quot;intro&quot;&gt;Whoever is careless with the truth in small matters cannot be trusted with important matters.&lt;/p&gt;

  &lt;p&gt;Excerpt from Albert Einstein's last statement, April, 1955, translated here into English from German.&lt;/p&gt;
&lt;/body&gt;
</code></pre>
</div>

Let's add a style to the now empty <code>content.css</code>:

<div class="code-sample">
<span class="code-sample-title">content.css</span>
<pre><code data-language="css">p {
  font-family: ‘Helvetica Neue’;
}
</code></pre>
</div>

This will style all p tags with the font Helvetica Neue. For paragraph tags with the intro class applied, let's make the text a little larger:

<div class="code-sample">
<span class="code-sample-title">content.css</span>
<pre><code data-language="css">p {
  font-family: 'Helvetica Neue';
  font-size: 18px;
}

.intro {
  font-size: 150%;
}
</code></pre>
</div>

So now, all paragraphs in our document will be displayed using the font Helvetica Neue, and any intro paragraph will be displayed with slightly larger type.

![Whoever is careless with the truth in small matters cannot be trusted with important matters. Excerpt from Albert Einstein's last statement, April, 1955, translated here into English from German.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-2-1.png "Whoever is careless with the truth in small matters cannot be trusted with important matters. Excerpt from Albert Einstein's last statement, April, 1955, translated here into English from German.")

Now, let's say someone took a look at our css and wanted to make the first selector a little more specific to the page.

<div class="code-sample">
<span class="code-sample-title">content.css</span>
<pre><code data-language="css">.home p {
  font-family: ‘Helvetica Neue’;
  font-size: 18px;
}

.intro {
  font-size: 150%;
}
</code></pre>
</div>

Now if we refresh the page, we’ll see this:

![Whoever is careless with the truth in small matters cannot be trusted with important matters. Excerpt from Albert Einstein's last statement, April, 1955, translated here into English from German.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-2-2.png "Whoever is careless with the truth in small matters cannot be trusted with important matters. Excerpt from Albert Einstein's last statement, April, 1955, translated here into English from German.")

You see what happened here? Both selectors are targeting the same element, but the 18px in the first p selector is overriding the intro selector. It defies the Cascade Order (we would expect the second to override the first), which can make it a little confusing. This is where knowing how Specificity works comes in handy.

### Calculating CSS Specificity

The CSS Specificity of a selector can be calculated by looking at what makes up the selector and counting the various components. Here’s a handy chart:

<img src="/assets/images/blog-imgs/2018-09-10-css-specificity/specificity-chart.png" class="specificity-chart" alt="How to calculate Specificity" title="CSS Cascading Order">

The Specificity is written as <code>a, b, c</code>. Why the comma-separated notation? This is because id selectors will ALWAYS outweigh classes, and classes will ALWAYS outweigh pseudo-elements. Confusing? Maybe. let's take another look at our example <code>content.css</code>:

<div class="code-sample">
<span class="code-sample-title">content.css</span>
<pre><code data-language="css">.home p {
  font-family: ‘Helvetica Neue’;
  font-size: 18px;
}

.intro {
  font-size: 150%;
}
</code></pre>
</div>

Let's break that down a little bit:

<img src="/assets/images/blog-imgs/2018-09-10-css-specificity/specif-calc-1-1.png" class="specificity-calculation" alt="Visualization of the specificity" title="Visualization of the specificity">

Using the Specificity formula, we can see that the first selector is <strong>(0, 1, 1)</strong> and the second selector is <strong>(0, 1, 0)</strong>. We can see the first selector clearly has a higher selector than the second, which is why the selector takes precedence.

Ok, so how can we make the intro selector override the <code>.home p</code> selector? What if we add an element to the selector? We really only want <code>intro</code> to apply to paragraphs, anyway:

<div class="code-sample">
<span class="code-sample-title">content.css</span>
<pre><code data-language="css">.home p {
  font-family: ‘Helvetica Neue’;
  font-size: 18px;
}

p.intro {
  font-size: 150%;
}
</code></pre>
</div>

<img src="/assets/images/blog-imgs/2018-09-10-css-specificity/specif-calc-1-2.png" class="specificity-calculation" alt="Visualization of the specificity" title="Visualization of the specificity">

Now when we look at the the specificity values, we’ll see they BOTH have <strong>(0, 1, 1)</strong>. So what happens now? In this case, the <strong>Cascading Order</strong> tells us that the <code>p.intro</code> selector will take precedence, because it occurs after the <code>.home p</code> selector. _It’s all coming together._

let's take a look at another example:

<div class="code-sample">
<span class="code-sample-title">quotes.html</span>
<pre><code data-language="html">&lt;body&gt;
  &lt;div class=&rdquo;container&rdquo; id=&rdquo;top&rdquo;&gt;
    &lt;p class=&rdquo;quote&rdquo;&gt;We don't make mistakes. We just have happy accidents.&lt;/p&gt;
  &lt;/div&gt;
&lt;/body&gt;
</code></pre>
</div>

<div class="code-sample">
<span class="code-sample-title">styles.css</span>
<pre><code data-language="css">body {
  font-family: 'Helvetica Neue';
  font-size: 18px;
}

#top p {
  font-style: normal;
}

.container p.quote {
  font-style: italic;
}
</code></pre>
</div>

Now let's see how that looks when we load it up in our browser:

![We don't make mistakes. We just have happy accidents.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-2-1.png "We don't make mistakes. We just have happy accidents.")

As you can see, the text is not italic, even though we have gotten pretty specific with our second selector. let's calculate the Specificity to figure out what’s going on:

**#top p:**

One id selector (#top), and one element selector (p). That gives us: <strong>(1, 0, 1)</strong>

**.container p.quote:**

Two class selectors and one element selector. That gives us: <strong>(0, 2, 1)</strong>

So, as you can see, the id on the first selector overrides the second. That’s because, as we established, ids ALWAYS override classes. If there’s one nugget I’d like for you to take away from this post, it’s that using id selectors in your css usually leads to complications down the line. If you stick with classes instead, things will go a lot smoother.

## !important, and why you shouldn’t use it

<hr class="gold">

Now that we understand how CSS Specificity and the Cascade Order work, let's throw a wrench into the situation with the !important rule. You can add <code>!important</code> onto the end of any css rule to give it special precedence. Any rule with <code>!important</code> added will override all other conflicting rules. Let's take a look:

<div class="code-sample">
<span class="code-sample-title">quotes.html</span>
<pre><code data-language="html">&lt;head&gt;
  &lt;style&gt;
    &lt;link rel=&rdquo;stylesheet&rdquo; type=&rdquo;text/css&rdquo; href=&rdquo;styles.css&rdquo;&gt;
    &lt;link rel=&rdquo;stylesheet&rdquo; type=&rdquo;text/css&rdquo; href=&rdquo;quotes.css&rdquo;&gt;
  &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
  &lt;div class=&rdquo;container&rdquo; id=&rdquo;top&rdquo;&gt;
    &lt;header class=&rdquo;top-header&rdquo;&gt;
      &lt;div class=&rdquo;quote-container&rdquo;&gt;
        &lt;p class=&rdquo;quote&rdquo;&gt;We don't make mistakes. We just have happy accidents.&lt;/p&gt;
        &lt;p&gt;There's nothing wrong with having a tree as a friend.&lt;/p&gt;
      &lt;/div&gt;
    &lt;/header&gt;
  &lt;/div&gt;
&lt;/body&gt;
</code></pre>
</div>

<div class="code-sample">
<span class="code-sample-title">styles.css</span>
<pre><code data-language="css">body {
  font-family: 'Helvetica Neue';
  font-size: 18px;
}

#top p {
  font-style: normal;
  color: green;
}

.container p.quote {
  font-style: italic;
}
</code></pre>
</div>

<div class="code-sample">
<span class="code-sample-title">quotes.css</span>
<pre><code data-language="css">p {
  color: orange;
}
</code></pre>
</div>

Notice in this example that I've included <strong>styles.css</strong> and <strong>quotes.css</strong> in the <code><head></code> of <strong>quotes.html</strong>. When rendered in the browser, this looks like the following:

![We don't make mistakes. We just have happy accidents. There's nothing wrong with having a tree as a friend.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-2-2.png "We don't make mistakes. We just have happy accidents. There's nothing wrong with having a tree as a friend.")

As you can see, the color of the text is green. The <code>p</code> selector in <code>quotes.css</code> attempts to select all p tags and set them to orange <strong>(0, 0, 1)</strong>, but the id of the <code>#top p</code> selector <strong>(1, 0, 1)</strong> takes precedence. What we could do technically is add <code>!important</code> to the <code>quotes.css p</code> selector. let's see what happens:

<div class="code-sample">
<span class="code-sample-title">quotes.css</span>
<pre><code data-language="css">p {
  color: orange !important;
}
</code></pre>
</div>

Now when we load it in the browser, we see:

![We don't make mistakes. We just have happy accidents. There's nothing wrong with having a tree as a friend.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-2-3.png "We don't make mistakes. We just have happy accidents. There's nothing wrong with having a tree as a friend.")

Ignoring the specificity and Cascade Order, the text is now orange. As you can see, <code>!important</code> overrides all other styles and “breaks through” the cascade order. If we go back to our visualization you can visualize it like this:

<img src="/assets/images/blog-imgs/2018-09-10-css-specificity/cascading-order-important.png" class="specificity-cascading-order" alt="CSS Cascading Order when !important is involved" title="CSS Cascading Order when !important is involved">

It skips over all the other style and directly influences its target element. It doesn’t follow the normal convention, which leads to confusing and frustrating CSS. <code>!important</code> gets even more complicated when more and more <code>!important</code>s are thrown on top of previous <code>!important</code>s. At that point, Chrome's Developer Tools will have a hard time showing you what's going on. And then you have to start digging into the source files to try to make sense of it, during which time you've lost your mind and thrown the computer out the window.

<img src="/assets/images/blog-imgs/2018-09-10-css-specificity/sigh.png" class="specificity-sigh" alt="Sigh..." title="Sigh...">

Anyway, back to our example. let's imagine we're a new developer on the project and decide to change the color of p tags to cyan. let's add the style in the <code><head></code> of <code>quotes.html</code>:

<div class="code-sample">
<span class="code-sample-title">quotes.html</span>
<pre><code data-language="html">&lt;head&gt;
  &lt;link rel=&rdquo;stylesheet&rdquo; type=&rdquo;text/css&rdquo; href=&rdquo;styles.css&rdquo;&gt;
  &lt;link rel=&rdquo;stylesheet&rdquo; type=&rdquo;text/css&rdquo; href=&rdquo;quotes.css&rdquo;&gt;
  &lt;style&gt;
    p {
      color: cyan;
    }
  &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
  &lt;div class=&rdquo;container&rdquo; id=&rdquo;top&rdquo;&gt;
    &lt;header class=&rdquo;top-header&rdquo;&gt;
      &lt;div class=&rdquo;quote-container&rdquo;&gt;
        &lt;p class=&rdquo;quote&rdquo;&gt;We don't make mistakes. We just have happy accidents.&lt;/p&gt;
        &lt;p&gt;There's nothing wrong with having a tree as a friend.&lt;/p&gt;
      &lt;/div&gt;
    &lt;/header&gt;
  &lt;/div&gt;
&lt;/body&gt;
</code></pre>
</div>

From what we’ve learned earlier about the Cascade Order, the text should be cyan now, right? Well, let's see:

![We don't make mistakes. We just have happy accidents. There's nothing wrong with having a tree as a friend.](/assets/images/blog-imgs/2018-09-10-css-specificity/test-2-4.png "We don't make mistakes. We just have happy accidents. There's nothing wrong with having a tree as a friend.")

Still orange. Maybe if we get more specific on our cyan p selector?

<div class="code-sample">
<span class="code-sample-title">quotes.css</span>
<pre><code data-language="css">body #top.container .top-container .quote-container p {
  color: cyan;
}
</code></pre>
</div>

Nope. Take a look at the Specificity calculation:

<img src="/assets/images/blog-imgs/2018-09-10-css-specificity/specif-calc-1-3.png" class="specificity-calculation-wide" alt="Visualization of the specificity" title="Visualization of the specificity">

Even though the cyan selector now has a specificity of <strong>(1, 3, 2)</strong>, the orange selector <strong>(0, 0, 1)</strong> with <strong>!important</strong> takes precedence. Imagine being a developer thrown onto this project, and you’re trying to figure out why the text is cyan. Sure, this one would be a simple because there’s only a few documents to sort through, but on a larger project, it could easily be very frustrating to find out why.

## Conclusion

To wrap up, I don’t think you necessarily need to calculate the specificity of all your selectors. But it helps to keep it in mind when you’re writing your CSS. Personally I try to avoid using id selectors when I can. The fact that they can override any class selector can make your CSS difficult to figure out pretty quickly. And once that starts, it’s only a matter of time before you or someone else may resort to using <code>!important</code> just to get something to work. Which, you know, is a pretty horrifying prospect. To summarize:

* Remember that id selectors always take priority over class selectors
* <code>!important</code> should never be used, but when you absolutely have to, use them sparingly (but don't use them!)
* Bonus tip: avoid using inline styles if you can
* Don't use <code>!important</code>

## Links & Notes

* [CSS Specificity: Things You Should Know](https://www.smashingmagazine.com/2007/07/css-specificity-things-you-should-know/)
* [W3C: Calculating a selector's specificity](https://www.w3.org/TR/selectors-3/#specificity)
* [CSS Tutorial #5: Cascading Order and Inheritance](https://www.mrc-productivity.com/techblog/?p=769)
* Note: This post was partially adapted from a presentation I gave on CSS Specificity
