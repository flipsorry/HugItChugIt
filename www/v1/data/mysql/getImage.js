
var page = require('webpage').create();
page.settings.userAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53';
var fs = require('fs');
var system = require('system');
var search = system.args[1].replace(" ", "+");

//var url = 'https://www.google.com/search?q=movie+sicario&biw=1680&bih=565&source=lnms&tbm=isch&sa=X&sqi=2&ved=0ahUKEwiLgdSYnLXKAhVC7mMKHWPdCxUQ_AUICSgE';

var url = 'https://www.google.com/search?q=' + search + '&biw=1680&bih=565&source=lnms&tbm=isch&sa=X&sqi=2&tbs=iar:t&ved=0ahUKEwiLgdSYnLXKAhVC7mMKHWPdCxUQ_AUICSgE';

page.open(url, function(status) {
  console.log("Status: " + status);
  if(status === "success") {
    //page.render('example.png');
    console.log(page.content);
    phantom.exit();
  }
});

