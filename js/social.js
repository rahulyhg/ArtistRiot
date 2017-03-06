
$(document).ready(function() {
	

window.fbAsyncInit = function() {
        FB.init({
          appId      : '1427059004241068',
          xfbml      : true,
          cookie     : true,
          version    : 'v2.1'
        });
    };
      

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


$.ajaxSetup({ cache: true });
$.getScript('//connect.facebook.net/en_UK/all.js', function(){
  FB.init({
	  appId: '1427059004241068',
	  status: true,
      cookie: true // enable cookies to allow the server to access 
  });
}); 

/*************** Twitter share button *********************/

!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
if(!d.getElementById(id)){js=d.createElement(s);
js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');


!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);
js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
fjs.parentNode.insertBefore(js,fjs);}}
(document, 'script', 'twitter-wjs');


});