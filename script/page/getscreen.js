var d1=new Date();
var page = require('webpage').create(),
  address, output, size;
if (phantom.args.length !=2) {
  console.log('args count error!');
  phantom.exit();
} else {
  address = 'http://ecd.ecc.com/pg/workshop.php?act=preview&ch_id='+phantom.args[0]+'&page_id='+phantom.args[1];
  output = './file/screen/ch'+phantom.args[0]+"_pg_"+phantom.args[1]+'.png';
  page.viewportSize = { width: 1024, height: 768 };
  page.open(address, function (status) {
    if (status !== 'success') {
    console.log('Unable to load the address!');
    } else {
    window.setTimeout(function () {
      page.render(output);
      var d2=new Date();
      //console.log((d2.getTime() - d1.getTime())/1000);
      console.log(output);
      phantom.exit();
    }, 100);
    }
  });
}