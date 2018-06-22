<html>
<head>
<title>VCE</title>
</head>
<body>
<form name="vce" action="checkanswer.php" method="post">
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
		$questionno = 1;
		$sql = "SELECT * FROM vcedb.question LEFT JOIN vcedb.answer ON question.QID = answer.QID ORDER BY RAND()";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)) {
				echo "<br><b>Question".$questionno."</b><br><br>";
				echo $row["question"]."<br>";
				if($row["img"]!=null){
					echo "<img src='/img/".$row["img"]."'><br><br>";
				}
				if($row["ismultiple"] == "Y"){
					$answerchoice = 'A';
					while($row[$answerchoice]!= null){
						echo "<input type='checkbox' id='".$row[$answerchoice]."' name='".$row["QID"]."[]' value='".$row[$answerchoice]."'>".$row[$answerchoice]."<br>";
						++$answerchoice;
					}
				}
				else{
					$answerchoice = 'A';
					while($row[$answerchoice]!= null){
						echo "<input type='radio' id='".$row[$answerchoice]."' name='".$row["QID"]."' value='".$row[$answerchoice]."'>".$row[$answerchoice]."<br>";
						++$answerchoice;
					}
				}
		
				++$questionno;		
			}
		}
	}
	mysqli_close($conn);
?>
<input type = "submit" value="submit">
</form>
</body>
</html>