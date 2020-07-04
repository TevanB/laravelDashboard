var express = require('express');
var fs = require('fs');
const opggScrape = require('opgg-scrape');
const cors = require('cors');
var request = require('request');
//var cheerio = require('cheerio');
var app     = express();
var jsdom = require("jsdom");
var path = require('path');
app.engine('html', require('ejs').renderFile);

//var $ = jQuery = require('jquery')(window);
//var html = fs.readFileSync(__dirname + '/public' +  file, 'utf8');
//var $ = cheerio.load(html);
var jsonPath = path.join('public', 'output.json');
//console.log(jsonPath);

var mysql = require('mysql');
var con = mysql.createConnection(process.env.JAWSDB_URL);
con.connect();

function updater(){
  //console.log(process.env.PORT);
  con.query('UPDATE ports SET name = '+process.env.PORT+' WHERE id = 1', function(err, rows, fields){
    if(err) throw err;
    //console.log(rows[0]);
  });
}
setInterval(updater, 5000);
const PORT = process.env.PORT || 3000;
app.use(express.json());
//app.use(cors);
//Scraping start
app.use(function(req, res, next){
  res.header("Access-Control-Allow-Origin", "*"); // update to match the domain you will make the request from
  res.header("Access-Control-Allow_methods", "GET, PUT, POST, DELETE");
  res.header("Access-Control-Allow-Headers", "Content-Type, x-socket-id");
  next();
});
app.get('/rankings/:name/:server', function(req, res){
      //console.log('get request heard');
	    //var parsedResults = [];
      ////console.log(req.params);
       opggScrape.getStats(req.params.name, {region: req.params.server, refresh: false}).then(stats => {
         ////console.log(req.params);
         //var path = './public/output.json';
         res.send(JSON.stringify(stats));

  	  	/*fs.writeFile('./public/output.json', JSON.stringify(stats, null, 4), function(err){
  	    	//console.log('Sraping data successfully written! - Check your project public/output.json file');
          //res.end();

  	    });*/
       });
       //res.send('test');

});

app.listen(PORT);

//console.log('Your node server start successfully.... on port '+PORT);

exports = module.exports = app;
