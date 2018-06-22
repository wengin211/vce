<html>
<head>
<title>Answer</title>
<style>
table {
    border-collapse: collapse;
    border: 1px solid black;
}
</style>
</head>
<body>
<?php
	//Connect to DB
	$dbhost = getenv("MYSQL_SERVICE_HOST");
	$dbport = getenv("MYSQL_SERVICE_PORT");
	$dbuser = getenv("MYSQL_USER");
	$dbpwd  = getenv("MYSQL_PASSWORD");
	$dbname = getenv("MYSQL_DATABASE");
	$conn = mysqli_connect($dbhost.":".$dbport, $dbuser, $dbpwd, $dbname);
	if(!$conn){
		echo "Could not connect to database";
	} else{
		$sql = "SELECT count(QID) FROM vcedb.question";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0){
			if($row = mysqli_fetch_assoc($result)) {
				$QID = $row["count(QID)"];
			}	
		}
		$question = 1;	
		echo "<table border='1'><th>Question</th><th>Result</th>";
		while($question <= $QID){
			$sql1 = "SELECT answer,ismultiple FROM vcedb.question WHERE QID = $question";
			$result1 = mysqli_query($conn,$sql1);
			if(mysqli_num_rows($result1)>0){
				while($row = mysqli_fetch_assoc($result1)) {
					echo "<tr><td>$question</td>";
					if($row["ismultiple"]=="Y"){
						//store the choice in array
						$choices = [];
						foreach ($_POST[$question] as $checkbox){
							array_push($choices,$checkbox);
						}
						//store the answer in array
						$answermulti = $row["answer"];
						$answer = explode(",", $answermulti);
						$ans = serialize($answer);
						$choi = serialize($choices);
						if($ans == $choi){
							echo "<td><a href='showanswer.php?choice=".$choi."&ID=".$question."'>Correct</a></td></tr>";
						}
						else{
							echo "<td><a href='showanswer.php?choice=".$choi."&ID=".$question."'>Wrong</a></td></tr>";
						}
					}
					else{
						$choice = $_POST[$question];
						if($row["answer"]==$choice){
							echo "<td><a href='showanswer.php?choice=".$choice."&ID=".$question."'>Correct</a></td></tr>";
						}
						else{
							echo "<td><a href='showanswer.php?choice=".$choice."&ID=".$question."'>Wrong</a></td></tr>";
						}
					}
				}
			}
			++$question;
		}
	}
	mysqli_close($conn);
?>
</body>
</html>