var page = require('webpage').create();
page.settings.userAgent = 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36';
var fs = require('fs');
var system = require('system');
var search = system.args[1].replace(" ", "+");

//var url = 'https://www.google.com/search?q=movie+sicario&biw=1680&bih=565&source=lnms&tbm=isch&sa=X&sqi=2&ved=0ahUKEwiLgdSYnLXKAhVC7mMKHWPdCxUQ_AUICSgE';

var url = 'https://www.google.com/search?q=' + search + '&biw=1680&bih=565&source=lnms&tbm=isch&sa=X&sqi=2&tbs=iar:t&ved=0ahUKEwiLgdSYnLXKAhVC7mMKHWPdCxUQ_AUICSgE';

//url = "https://www.google.com/search?site=webhp&tbm=isch&source=hp&ei=UqKVV8OZBJDajwPxpYnQBA&gs_l=mobile-gws-hp.3..0l5.5313.7822.0.7941.13.13.0.4.4.0.182.667.11j1.12.0....0...1c.1.64.mobile-gws-hp..1.10.286.0.PmH3cfz2anA&q=" + search;

url = "https://www.google.com/?gws_rd=ssl";
url = "http://www.drakestears.com";
console.log("starting request for: " + url);

page.open(url, function(status) {
  console.log("Status: " + status);
  if(status === "success") {
    page.render('example.png');
    console.log(page.content);
  }
  phantom.exit();
});

