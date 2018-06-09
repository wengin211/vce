<html>
<head>
<title>VCE</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
var vce = [];
var rando = [];
var questions = [];
var choices = [[]];
var answers = [];
	questions = [];
	choices = [ 
			  ]	
//Function for producing random numbers
function randno(){
	var randomnumber = questions.length;
	while(rando.length < randomnumber){
	generateRandom(randomnumber);
	}
}

function generateRandom(rand){
	var ran = rand;
	var randnumber = Math.floor(Math.random()*ran);
		for(var i = 0 ; i < rando.length ; i++){
			if(rando[i] == randnumber){
				return false;
			}
		}
	rando.push(randnumber);
}

function question(){
	document.getElementById('start').disabled = true;
	randno();
	var count = 0; //count for questions
	var a = 0; //array vertical
	var b = 0; //array horizontal
	var qc = 1; //div number for question
	var ac = 1; //div number for answer
	var doc;   //html code
	var qn = 0;
	
	while(count < questions.length){
		b = 0;
		createqdiv('q'+qc);
		qn = rando[a];
		doc = document.getElementById('q'+qc);
		doc.innerHTML = "<br>" + questions[qn];
			for (var i=0;i<choices[qn].length;i++,ac++,b++){
				createadiv('a'+ac);
				doc = document.getElementById('a'+ac);
				doc.innerHTML = "<input type='radio' name='Q"+ qc + "' value='"+choices[qn][b]+"'>"+choices[qn][b]+" <br>";
			}
		a++;
		qc++;
		count++;
	}
}

//Functions for creating question div
function createqdiv(que){
  var qu = que;
  $('#target').append($('<div/>', { id: qu, 'class' : 'ansbox'}))
}

//Functions for creating answer div
function createadiv(ans){
  var an = ans;
  $('#target').append($('<div/>', { id: an, 'class' : 'ansbox'}))
}

<!-- var openFile = function(event){
        //var input = event.target;
        //var reader = new FileReader();
        //reader.onload = function(){
          //var text = reader.result;
          //vce.push(text); 
          //console.log(reader.result.substring(0, 100000000000));
        //};
        //reader.readAsText(input.files[0]);
      //};
	   -->

</script>
</head>
<body>
<?php
$dbport = '3306';
$dbuser = getenv("MYSQL_USER");
$dbpwd = getenv("MYSQL_PASSWORD");
$dbname = getenv("MYSQL_DATABASE");
$connection = mysqli_connect($dbhost.":".$dbport, $dbuser, $dbpwd);
if (!$connection) {
  echo "Could not connect to database";
} else {
  echo "Connected to database.<br>";
}
?>
<!-- <input type='file' accept='text/plain' onchange='openFile(event)'><br> -->
<!--<p id='output'></p>-->

<input type="button" name="start" id="start" value="Start Test" onClick=''>

<div id="target">
</div>
</body>
</html>
