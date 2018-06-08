<html>
<head>
<script>
function playnext(){
var audio = document.getElementById("Demo");
audio.src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-9.mp3";
audio.play();
}
</script>
</head>
<body>
<button id = "b" onclick="cli();">Click</button>
<audio id="Demo" controls="">
<source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3" onended="playnext()">
</audio>
<div id ="a"></div>
</body>
</html>