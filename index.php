<?php
/**
* Facebook Starter Kit - PHP/JS SDK HTML5 API STARTER TEMPLATE
*
* @package Facebook Starter Kit
* @author Jason Hamilton-Mascioli
* @since Version 0.1
*/
/**
* Examples highlight simple implementations of:
* Timeline
* Ref Plugin
* Authentication
* Like
* Send
* Subscribe
* Comments
* Activity Feed
* Recommendations
* Like Box
* Login Button
* Registration
* Facepile
* Livestream
* News Feed (Publish to Wall)
* Requests
*
* Some Quick Links:
* =================
* FB Documentation: https://developers.facebook.com/docs/
* FB Permissions List: https://developers.facebook.com/docs/authentication/permissions/
* FB Debugger and Page Cache Remover: https://developers.facebook.com/tools/debug
* Developer roadmap: http://developers.facebook.com/roadmap/
*/

// get facebook sdk
require 'facebook/src/facebook.php';

// setup facebook connection
$facebook = new Facebook(array(
  'appId'  => '  [APPID]',
  'secret' => '[Secret_KEY]',
));

// See if there is a user from a cookie
$user = $facebook->getUser();
$user_profile = array();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated and store in $user_profile.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
      // debug
      //echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# [APPNAME]: 
                  http://ogp.me/ns/apps/[APPNAME]#">
  <title>YOUR APP TITLE</title>
  <?php // this meta info below is for your TIMELINE APP ?>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# [APPNAME]: http://ogp.me/ns/fb/[APPNAME]#">
  <meta property="fb:app_id"      content="  [APPID]" /> 
  <meta property="og:type"        content="[APPNAME]:[APPOBJECTNAME]" /> 
  <meta property="og:url"         content="[URL TO THIS SCRIPT]" /> 
  <meta property="og:title"       content="OBJECT TITLE" /> 
  <meta property="og:description" content="" /> 
  <meta property="og:image"       content="[IMAGEPATH]" />
  <?php // end of meta info for TIMELINE ?>
  
  <script type="text/javascript">
  
  // AUTHENTICATION EXAMPLE 
  function login()
  {
    FB.login(function(response) {
      if (response.authResponse) {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
          console.log('Good to see you, ' + response.name + '.');
        });
      } else {
        console.log('User cancelled login or did not fully authorize.');
      }
    }, {scope: 'email,user_likes,publish_actions'}); 
  }
  
  // POST TO TIMELINE FUNCTION
  function postCook()
  {
    // TEST PULLING SOME INFO ABOUT USER
    FB.api('/me', function(response) {
      alert('Your name is ' + response.name);
      alert('Your email is ' + response.email);
    });
    
    FB.api(
      '/me/[APPNAME]:[APPACTION]?[APPOBJECT]=[APPURLTOTHISSCRIPT]',
      'post',
      function(response) {
        if (!response || response.error) {
          alert('Error occured');
        } else {
          alert('POST TO TIMELINE was successful! Action ID: ' + response.id);
        }
    });
  }
  </script>
</head>

<body>
<?php 
// LETS DO SOME PHP AND LOGIN CHECKING
if ($user_profile) { ?>
      [DEBUG] Your $user_profile array looks like: 
      <pre>            
        <?php print htmlspecialchars(print_r($user_profile, true)) ?>
        
        <br />Your Image: <img src="https://graph.facebook.com/<?=$user_profile['username']?>/picture">
        
      </pre> 
    <?php } else { ?>
     <input type="button" value="Login" onclick="login()" />
<?php } ?>
<div id="fb-root"></div>
<script>
// SETUP JS SDK
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '[APPID]', // App ID
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
      });
      FB.Event.subscribe('auth.login', function(response) {
                window.location.reload();
      });
      FB.Event.subscribe('auth.logout', function(response) {
                window.location.reload();
      });
    };

    // Load the SDK Asynchronously
    (function(d){
      var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
      js = d.createElement('script'); js.id = id; js.async = true;
      js.src = "//connect.facebook.net/en_US/all.js";
      d.getElementsByTagName('head')[0].appendChild(js);
    }(document));
</script>

<h3>TIMELINE</h3>
<?php
/**
SETUP
1. Goto https://developers.facebook.com/apps and create a new app
2. Goto Open Graph menu tab and select Getting Started ... define your action and object and edit them accordingly
3. Setup Aggregations and GET code for object type ... these object types are your pages meta data... each object should have its own page
Note: Remember to clear the cache using the debugger tool (https://developers.facebook.com/tools/debug) if you decide to change the meta data on the page

So
   - setup meta data on page with usual fb code
   - add function to call to action ... example..
   <script>
   FB.api(
     '/me/[APPNAME]:[APPACTION]?[APPOBJECT]=[URLTOTHISPAGE]',
     'post',
     function(response) {
       if (!response || response.error) {
         alert('Error occured');
       } else {
         alert('POST TO TIMELINE was successful! Action ID: ' + response.id);
       }
   });
   </script>
   <form>
       <input type="button" value="Post Action to Timeline" onclick="postCook()" />
   </form>
   - add to users timeline using this ... <fb:add-to-timeline></fb:add-to-timeline> 
*/
?>
<fb:add-to-timeline></fb:add-to-timeline>
<br /><br />
<form>
    <input type="button" value="Post Action to Timeline" onclick="postCook()" />
</form>

<h3>ACTIVITY for TIMELINE specifically</h3>  
<div class="fb-activity" data-site="[URLTOTHISPAGE]" data-app-id="[APPID]" data-action="[APPNAME]:[APPACTION]" data-width="300" data-height="300" data-header="true" data-recommendations="true"></div>

<?php
/**
Ref plugin to determine activity of specific fb plugin
<fb:activity ref="homepage"></fb:activity>
<iframe src="...&ref=homepage"></iframe>
will send to fb... http://www.facebook.com/l.php?fb_ref=homepage
*/
?>
  
<h3>LIKE</h3>
<?php // Social Plugins - https://developers.facebook.com/docs/plugins/ ?>
<?php
/**

The Like button lets a user share your content with friends on Facebook. When the user clicks the Like button on your site, a story appears in the user's friends' 
News Feed with a link back to your website.

When your Web page represents a real-world entity, things like movies, sports teams, celebrities, and restaurants, use the Open Graph protocol to specify information 
about the entity. If you include Open Graph tags on your Web page, your page becomes equivalent to a Facebook page. This means when a user clicks a Like button on your 
page, a connection is made between your page and the user. Your page will appear in the "Likes and Interests" section of the user's profile, and you have the ability 
to publish updates to the user. Your page will show up in same places that Facebook pages show up around the site (e.g. search), and you can target ads to people who 
like your content. Note: The count on the Like button will include all likes and shares whereas the like connection on the Graph API includes only the number of likes for the object.

There are two Like button implementations: XFBML and Iframe. The XFBML (also available in HTML5-compliant markup) version is more versatile, but requires use of the 
JavaScript SDK. The XFBML dynamically re-sizes its height according to whether there are profile pictures to display, gives you the ability (through the Javascript library) 
to listen for like events so that you know in real time when a user clicks the Like button, and it always gives the user the ability to add an optional comment to the like. 
If users do add a comment, the story published back to Facebook is given more prominence.

Note: The URLs in the code are protocol relative. This lets the browser to load the SDK over the same protocol (HTTP or HTTPS) as the containing page, which will 
prevent "Insecure Content" warnings. Missing http and https in the code is intentional.

Attributes

    href - the URL to like. The XFBML version defaults to the current page.
    send - specifies whether to include a Send button with the Like button. This only works with the XFBML version.
    layout - there are three options.
        standard - displays social text to the right of the button and friends' profile photos below. Minimum width: 225 pixels. Minimum increases by 40px if action is 'recommend' by and increases by 60px if send is 'true'. Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).
        button_count - displays the total number of likes to the right of the button. Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.
        box_count - displays the total number of likes above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.
    show_faces - specifies whether to display profile photos below the button (standard layout only)
    width - the width of the Like button.
    action - the verb to display on the button. Options: 'like', 'recommend'
    font - the font to display in the button. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
    colorscheme - the color scheme for the like button. Options: 'light', 'dark'
    ref - a label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_). The ref attribute causes two parameters to be added to the referrer URL when a user clicks a link from a stream story about a Like action:
        fb_ref - the ref parameter
        fb_source - the stream type ('home', 'profile', 'search', 'ticker', 'tickerdialog' or 'other') in which the click occurred and the story type ('oneline' or 'multiline'), concatenated with an underscore.


Meta Tags for Open Graph Tags
  
  og:title - The title of the entity.
  og:type - The type of entity. You must select a type from the list of Open Graph types.
  og:image - The URL to an image that represents the entity. Images must be at least 50 pixels by 50 pixels. Square images work best, but you are allowed to use images up to three times as wide as they are tall.
  og:url - The canonical, permanent URL of the page representing the entity. When you use Open Graph tags, the Like button posts a link to the og:url instead of the URL in the Like button code.
  og:site_name - A human-readable name for your site, e.g., "IMDb".
  fb:admins or fb:app_id - A comma-separated list of either the Facebook IDs of page administrators or a Facebook Platform application ID. At a minimum, include only your own Facebook ID.

<meta property="og:title" content="WEB DEVELOPMENT" />
<meta property="og:type" content="website" />
<meta property="og:url" content="[URL]" />
<meta property="og:image" content="[URLTOIMAGE]" />
<meta property="og:site_name" content="[COMPANYNAME]" />
<meta property="fb:admins" content="YOURPROFILEID" />

*/
?>
<div class="fb-like" data-href="http://www.google.com" data-send="true" data-width="450" data-show-faces="true" data-font="arial"></div>
  
<h3>SEND</h3>
<?php
/**
The Send Button allows users to easily send content to their friends. People will have the option to send your URL in a message to their Facebook friends, 
to the group wall of one of their Facebook groups, and as an email to any email address. While the Like Button allows users to share content with all of their 
friends, the Send Button allows them to send a private message to just a few friends.

The message will include a link to the URL specified in the send button, along with a title, image, and short description of the link. You can specify what is 
shown for the title, image, and description by using Open Graph meta tags.

The Send button requires the JavaScript SDK.

Attributes

    href - the URL to send.
    font - the font to display in the button. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
    colorscheme - the color scheme for the button. Options: 'light', 'dark'
    ref - a label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_). The ref attribute causes two parameters to 
    be added to the referrer URL when a user clicks a link from a stream story about a Send action:
        fb_ref - the ref parameter
        fb_source - the story type ('message', 'group', 'email') in which the click occurred.

*/
?>
<div class="fb-send" data-href="http://example.com"></div>

<h3>SUBSCRIBE</h3>
<?php
/**
The Subscribe button lets a user subscribe to your public updates on Facebook.

There are two Subscribe button implementations: XFBML and Iframe. The XFBML (also available in HTML5-compliant markup) version is more versatile, and requires 
use of the JavaScript SDK. The XFBML dynamically re-sizes its height according to whether there are profile pictures to display.

Attributes

    href - profile URL of the user to subscribe to. This must be a facebook.com profile URL.
    layout - there are three options.
        standard - displays social text to the right of the button and friends' profile photos below. Minimum width: 225 pixels. Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).
        button_count - displays the total number of subscribers to the right of the button. Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.
        box_count - displays the total number of subscribers above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.
    show_faces - specifies whether to display profile photos below the button (standard layout only)
    colorscheme - the color scheme for the plugin. Options: 'light' (default) and 'dark'
    font - the font to display in the plugin. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
    width - the width of the plugin.

*/
?>
<div class="fb-subscribe" data-href="https://www.facebook.com/zuck" data-show-faces="true" data-width="450"></div>

<h3>COMMENTS</h3>
<?php
/**
Comments Box is a social plugin that enables user commenting on your site. Features include moderation tools and distribution.

Social Relevance: Comments Box uses social signals to surface the highest quality comments for each user. Comments are ordered to show users the most 
relevant comments from friends, friends of friends, and the most liked or active discussion threads, while comments marked as spam are hidden from view.

Distribution: Comments are easily shared with friends or with people who like your Page on Facebook. If a user leaves the “Post to Facebook” box checked when 
she posts a comment, a story appears on her friends’ News Feed indicating that she’s made a comment on your website, which will also link back to your site.

Friends and people who like the Page can then respond to the discussion by liking or replying to the comment directly in the News Feed on Facebook or in the 
Comments Box on your site. Threads stay synced across Facebook and on the Comments Box on your site regardless of where the comment was made.

The mobile version will automatically show up when a mobile device user agent is detected. You can turn this behavior off by setting the mobile parameter to 
false. Please note: the mobile version ignores the width parameter, and instead has a fluid width of 100% in order to resize well in portrait/landscape switching 
situations. You may need to adjust your CSS for your mobile site to take advantage of this behavior. If preferred, you can still control the width via a container element.

Attributes

    href - the URL for this Comments plugin. News feed stories on Facebook will link to this URL.
    width - the width of the plugin in pixels. Minimum recommended width: 400px.
    colorscheme - the color scheme for the plugin. Options: 'light', 'dark'
    num_posts - the number of comments to show by default. Default: 10. Minimum: 1
    mobile - whether to show the mobile-optimized version. Default: auto-detect.
    
    Moderation
    <meta property="fb:admins" content="{YOUR_FACEBOOK_USER_ID}"/>
    <meta property="fb:app_id" content="{YOUR_APPLICATION_ID}"/>

*/
?>
<div class="fb-comments" data-href="http://example.com" data-num-posts="2" data-width="470"></div>

<h3>ACTIVITY FEED</h3>
<?php
/**
The Activity Feed plugin displays the most interesting recent activity taking place on your site. Since the content is hosted by Facebook, the plugin can display 
personalized content whether or not the user has logged into your site. The activity feed displays stories when users interact with content on your site, such as 
like, watch, read, play or any custom action. Activity is also displayed when users share content from your site in Facebook or if they comment on a page on your 
site in the Comments box. If a user is logged into Facebook, the plugin will be personalized to highlight content from their friends. If the user is logged out, the 
activity feed will show recommendations from across your site, and give the user the option to log in to Facebook.

The plugin is filled with activity from the user's friends. If there isn't enough friend activity to fill the plugin, it is backfilled with recommendations. If you 
set the recommendations param to true, the plugin is split in half, showing friends activity in the top half, and recommendations in the bottom half. If there is not 
enough friends activity to fill half of the plugin, it will include more recommendations.

The Activity Feed plugin can be configured in the following ways:

    App ID
    One or more action types
    Domain


Examples:
<fb:activity 
site="jerrycain.com"
app_id="118280394918580">
</fb:activity>

<fb:activity 
site="jerrycain.com"
action="critiqueapp:despise,critiqueapp:review,critiqueapp:grade">
</fb:activity>

<fb:activity 
site="jerrycain.com">
</fb:activity>

Attributes

    site - the domain for which to show activity; include just the full domain name, without http:// or a path. The XFBML version defaults to the current domain.
    action - a comma separated list of actions to show activities for.
    app_id - will display all actions, custom and global, associated with this app_id.
    width - the width of the plugin in pixels. Default width: 300px.
    height - the height of the plugin in pixels. Default height: 300px.
    header - specifies whether to show the Facebook header.
    colorscheme - the color scheme for the plugin. Options: 'light', 'dark'
    font - the font to display in the plugin. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
    border_color - the border color of the plugin.
    recommendations - specifies whether to always show recommendations in the plugin. If recommendations is set to true, the plugin will display recommendations in the bottom half.
    filter - allows you to filter which URLs are shown in the plugin. The plugin will only include URLs which contain the filter string in the first two path parameters of the URL. If nothing in the first two path parameters of the URL matches the filter, the URL will not be included. For example, if the 'site' 
    parameter is set to 'www.example.com' and the 'filter' parameter was set to '/section1/section2' then only pages which matched 'http://www.example.com/section1/section2/*' 
    would be included in the activity feed section of this plugin. 
    The filter parameter does not apply to any recommendations which may appear in this plugin (see above); Recommendations are based only on 'site' parameter.
    linktarget - This specifies the context in which content links are opened. By default all links within the plugin will open a new window. If you want the content links to open in the same window, you can set this parameter to _top or _parent. Links to Facebook URLs will always open in a new window.
    ref - a label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_). Specifying a value for the ref attribute adds the 'fb_ref' parameter to the any links back to your site which are clicked from within the plugin. Using 
    different values for the ref parameter for different positions and configurations of this plugin within your pages allows you to track which instances are performing the best.
    max_age - a limit on recommendation and creation time of articles that are surfaced in the plugins, the default is 0 (we don’t take age into account). Otherwise the valid values are 1-180, which specifies the number of days.


*/
?>
<div class="fb-activity" data-site="google.com" data-width="300" data-height="300" data-header="true" data-recommendations="true"></div>

<h3>RECOMMENDATIONS</h3>
<?php
/**

The Recommendations Box shows personalized recommendations to your users. Since the content is hosted by Facebook, the plugin can display personalized 
recommendations whether or not the user has logged into your site. To generate the recommendations, the plugin considers all the social interactions with 
URLs from your site. For a logged in Facebook user, the plugin will give preference to and highlight objects her friends have interacted with.

You must specify a domain for which to show recommendations. The domain is matched exactly, so a plugin with site=facebook.com would not include activity 
from developers.facebook.com or www.facebook.com. You cannot currently aggregate across multiple domains.

The Recommendations Box can be configured in the following ways:

    App ID
    One or more action types
    Domain


Examples:
<fb:recommendations 
  site="jerrycain.com"
  app_id="118280394918580">
</fb:recommendations>

<fb:recommendations 
  site="jerrycain.com"
  action="critiqueapp:despise,critiqueapp:review,critiqueapp:grade">
</fb:recommendations>

<fb:recommendations 
  site="jerrycain.com">
</fb:recommendations>

Attributes

    site - the domain to show recommendations for. The XFBML version defaults to the current domain.
    action - a comma separated list of actions to show recommendations for.
    app_id - will display recommendations for all types of actions, custom and global, associated with this app_id.
    width - the width of the plugin in pixels. Default width: 300px.
    height - the height of the plugin in pixels. Default height: 300px.
    header - specifies whether to show the Facebook header.
    colorscheme - the color scheme for the plugin. Options: 'light', 'dark'
    font - the font to display in the plugin. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
    border_color - the border color of the plugin.
    linktarget - This specifies the context in which content links are opened. By default all links within the plugin will open a new window. If you want the content links to open in 
    the same window, you can set this parameter to _top or _parent. Links to Facebook URLs will always open in a new window.
    ref - a label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_). Specifying a value for the 
    ref attribute adds the 'fb_ref' parameter to the any links back to your site which are clicked from within the plugin. Using different values 
    for the ref parameter for different positions and configurations of this plugin within your pages allows you to track which instances are performing the best.
    max_age - a limit on recommendation and creation time of articles that are surfaced in the plugins, the default is 0 (we don’t take age into account). Otherwise the valid values are 1-180, which specifies the number of days.

*/
?>
<div class="fb-recommendations" data-site="facebook.com" data-width="300" data-height="300" data-header="true"></div>

<h3>LIKE BOX</h3>
<?php
/**
The Like Box is a social plugin that enables Facebook Page owners to attract and gain Likes from their own website. The Like Box enables users to:

    See how many users already like this Page, and which of their friends like it too
    Read recent posts from the Page
    Like the Page with one click, without needing to visit the Page

The minimum supported plugin width is 292px.

Attributes

    href - the URL of the Facebook Page for this Like Box
    width - the width of the plugin in pixels. Default width: 300px.
    height - the height of the plugin in pixels. The default height varies based on number of faces to display, and whether the stream is displayed. With the stream displayed, and 10 faces the default height is 556px. With no faces, and no stream the default height is 63px.
    colorscheme - the color scheme for the plugin. Options: 'light', 'dark'
    show_faces - specifies whether or not to display profile photos in the plugin. Default value: true.
    stream - specifies whether to display a stream of the latest posts from the Page's wall
    header - specifies whether to display the Facebook header at the top of the plugin.
    border_color - the border color of the plugin.
    force_wall - for Places, specifies whether the stream contains posts from the Place's wall or just checkins from friends. Default value: false.

*/
?>
<div class="fb-like-box" data-href="http://www.facebook.com/platform" data-width="292" data-show-faces="true" data-stream="true" data-header="true"></div>

<h3>LOGIN BUTTON</h3>
<?php
/**
The Login Button shows profile pictures of the user's friends who have already signed up for your site in addition to a login button.

You can specify the maximum number of rows of faces to display. The plugin dynamically sizes its height; for example, if you specify a maximum of 
four rows of faces, and there are only enough friends to fill two rows, the height of the plugin will be only what is needed for two rows of faces.

Using the new JavaScript SDK, the plugin is available via the <fb:login-button> XFBML tag or the <div class="fb-login-button"> HTML tag.

Note: If the user is already logged in, no login button is shown.

Attributes

    show-faces - specifies whether to show faces underneath the Login button.
    width - the width of the plugin in pixels. Default width: 200px.
    max-rows - the maximum number of rows of profile pictures to display. Default value: 1.
    scope - a comma separated list of extended permissions. By default the Login button prompts users for their public information. If your application needs to access other parts of the user's profile
     that may be private, your application can request extended permissions. A complete list of extended permissions can be found here.
    registration-url - registration page url. If the user has not registered for your site, they will be redirected to the URL you specify in the registration-url parameter.

*/
?>
<div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1"></div>

<h3>REGISTRATION</h3>
<?php
/**
The Registration plugin allows users to easily sign up for your website with their Facebook account. The plugin is a simple iframe that you can drop into your page. When logged into Facebook, 
users see a form that is pre-filled with their Facebook information where appropriate.

The registration plugin gives you the flexibility to ask for additional information which is not available through the Facebook API (e.g. favorite movie). The plugin also allows
 users who do not have a Facebook account, or do not wish to sign up for your site using Facebook to use the same form as those who are connecting with Facebook. 
This eliminates the need to provide two separate login experiences.

Read here for login flows, fields and custom fields
https://developers.facebook.com/docs/plugins/registration/

*/
?>
  <iframe src="https://www.facebook.com/plugins/registration?
               client_id=113869198637480&
               redirect_uri=https%3A%2F%2Fdevelopers.facebook.com%2Ftools%2Fecho%2F&
               fields=name,birthday,gender,location,email"
          scrolling="auto"
          frameborder="no"
          style="border:none"
          allowTransparency="true"
          width="100%"
          height="330">
  </iframe>

<h3>FACEPILE</h3>
<?php
/**
The Facepile plugin displays the Facebook profile pictures of users who have connected with your page via a global or custom action, or can also be 
configured to display users that have signed up for your site.

If you want to display users who have connected to your page via an action, specify with the action parameter

<fb:facepile href="http://zhen.myfbse.com/rb-roastchicken.html" 
action="og_recipebox:planning_to_make" width="300" max_rows="1"></fb:facepile>

To display users who have liked your page, specify the URL of your page as the href parameter. To display users who have signed up for your site, 
specify your application id as the app_id parameter.

The plugin is available either via a simple iframe you can drop into your page, or if you are using the new JavaScript SDK, you can use the <fb:facepile> XFBML tag.

Attributes

    href - the URL of the page. The plugin will display photos of users who have liked this page.
    action - an action type. The plugin will display photos of users who have connected to your app via this action.
    app_id - if you want the plugin to display users who have connected to your site, specify your application id as this parameter. This parameter is only available in the iframe version of the Facepile. If you are using the XFBML version of the plugin, specify your application id when you initialize the Javascript library.
    max_rows - the maximum number of rows of faces to display. The XFBML version will dynamically size its height; if you specify a maximum of four rows of faces, but there are only enough friends to fill two rows, the XFBML version of the plugin will set its height for two rows of faces. Default: 1.
    width - width of the plugin in pixels. Default width: 300px.
    size - size of the photos and social context. Default size: medium.
    colorscheme - the color scheme for the like button. Options: 'light', 'dark'.

*/
?>
<div class="fb-facepile" data-href="http://google.com" data-max-rows="1" data-width="300"></div>


<h3>LIVESTREAM</h3>
<?php
/**
The Live Stream plugin lets users visiting your site or application share activity and comments in real time. Live Stream works best when you are running a real-time event, 
like live streaming video for concerts, speeches, or webcasts, live Web chats, webinars, massively multiplayer games.

The minimum supported plugin width is 400px.
*/
?>
<div class="fb-live-stream" data-event-app-id="  [APPID]" data-width="400" data-height="500" data-always-post-to-friends="false"></div>



<?php // SOCIAL CHANNELS ?>

<?php
/**
NEWS FEED (PUBLISH TO WALL)
The News Feed is shown immediately to users upon logging into Facebook, making it core to the Facebook experience. There are several ways you can publish 
content to the stream: Feed Dialog, Feed Graph object and Like Button.

Feed Dialog: Prompt Users to Publish

The recommended way to publish to the stream is with the Feed Dialog. Without requiring users to log into your application or grant any special permission, you 
can prompt users to publish stories about what they are doing in your application. If a user chooses to publish, the story will appear on the user’s profile and 
may appear to the user’s friends’ News Feeds.

Stories published from your application will include a link to your application, and can optionally include a rich attachment. Here is a basic example of how to 
prompt a user to publish a story:

Publish to a users wall:
curl -F 'access_token=...' \
     -F 'message=Facebook for Websites is super-cool.' \
     https://graph.facebook.com/<username>/feed
     
     OR 
     
     https://graph.facebook.com/<username>/feed:

*/
?>
<script>
FB.ui({ method: 'feed', 
            message: 'Facebook for Websites is super-cool'});
</script>


<?php
/**
REQUESTS

If you have built a Canvas or Mobile Web application, Requests are a great way to enable users to invite their friends to use your app. 
Requests integrate with Facebook notifications and dashboards, ensuring that a user will see the requests from their friends whenever they 
are on Facebook. You can also use requests to have a user notify their friends to take a specific action in your app, such as accepting a gift 
or helping the user complete a quest.

There are two types of requests that can be sent from an app:

    User-generated requests: These requests are confirmed by a user’s explicit action on a request dialog. These requests update the bookmark count 
    for the recipient. You send requests by using the Request Dialog.

    App-generated requests: These requests can be initiated and sent only to users who have authorized your app. Developers can send these requests 
    using the Graph API. You should use these requests to update the bookmark count to encourage a user to re-engage in the app (e.g., your friend 
    finished her move in a game and it’s now your turn).

The following HTML/JavaScript example shows how to create a User-generated request

USING PHP
$app_id = YOUR_APP_ID;
  $app_secret = YOUR_APP_SECRET;

  $token_url = "https://graph.facebook.com/oauth/access_token?" .
    "client_id=" . $app_id .
    "&client_secret=" . $app_secret .
    "&grant_type=client_credentials";

  $app_access_token = file_get_contents($token_url);

  $user_id = THE_CURRENT_USER_ID;

  $apprequest_url ="https://graph.facebook.com/" .
    $user_id .
    "/apprequests?message='INSERT_UT8_STRING_MSG'" . 
    "&data='INSERT_STRING_DATA'&"  .   
    $app_access_token . "&method=post";

  $result = file_get_contents($apprequest_url);
  echo("App Request sent?", $result);
  

The following PHP example demonstrates how to access the pending requests for a user and then delete the requests once you have completed any associated actions:
$app_id = 'YOUR_APP_ID';
   $app_secret = 'YOUR_APP_SECRET';

   $token_url = "https://graph.facebook.com/oauth/access_token?" .
     "client_id=" . $app_id .
     "&client_secret=" . $app_secret .
     "&grant_type=client_credentials";

   $access_token = file_get_contents($token_url);

   $signed_request = $_REQUEST["signed_request"]; 
   list($encoded_sig, $payload) = explode('.', $signed_request, 2);
   $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
   $user_id = $data["user_id"];

   //Get all app requests for user
   $request_url ="https://graph.facebook.com/" .
     $user_id .
     "/apprequests?" .
     $access_token;
   $requests = file_get_contents($request_url);

   //Print all outstanding app requests
   echo '<pre>';
   print_r($requests);
   echo '</pre>';

   //Process and delete app requests
   $data = json_decode($requests);
   foreach($data->data as $item) {
    $id = $item->id;
    $delete_url = "https://graph.facebook.com/" .
    $id . "?" . $access_token;

    $delete_url = $delete_url . "&method=delete";
    $result = file_get_contents($delete_url);
    echo("Requests deleted? " . $result);
   }
   
   
   Automatic Channels

   To drive more traffic to Facebook Platform applications and websites, in addition to the channels above, we 
   enable some distribution automatically as people use your applications. You do not need to do anything extra to enable 
   this distribution. Each automatic channel is designed to help engage users and our algorithms help surface the best content 
   for each user. As Facebook evolves as a product, expect these channels to change and improve. The current automatic channels include:

       Bookmarks
       Notifications
       Dashboards
       Usage Stories
       Search
   
   
*/
?>
<script>
FB.ui({ method: 'apprequests', 
       message: 'Here is a new Requests dialog...'});
</script>

<?php 
/**
ADDITIONAL DOCUMENTATION

GRAPH API using PHP SDK  -- https://developers.facebook.com/docs/reference/php/
DIALOGS - https://developers.facebook.com/docs/reference/dialogs/ 
FQL -  https://developers.facebook.com/docs/reference/fql/        
INTERNATIONALIZATION - https://developers.facebook.com/docs/internationalization/
ADS API - https://developers.facebook.com/docs/reference/ads-api/
CREDITS API - https://developers.facebook.com/docs/credits/
CHAT API - https://developers.facebook.com/docs/chat/Fi
*/
?>    
  
</body>
</html>