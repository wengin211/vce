<html>
<head>
<title>Result</title>
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
		$question = $_GET["ID"];
		$choice = $_GET["choice"];
		$sql = "SELECT * FROM vcedb.question LEFT JOIN vcedb.answer ON question.QID = answer.QID WHERE question.QID = $question";
		$result = mysqli_query($conn,$sql);
		//if(mysqli_num_rows($result)>0){
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)) {
				echo "<br><b>Question".$question."</b><br><br>";
				echo $row["question"]."<br>";
				if($row["img"]!=null){
					echo "<img src='/img/".$row["img"]."'><br><br>";
				}
				if($row["ismultiple"] == "Y"){
					$answerchoice = 'A';
					$answermulti = $row["answer"];
					$answer = explode(",", $answermulti);
					$ans = serialize($answer);
					while($row[$answerchoice]!= null){
						if($ans == $choice){
							if(in_array($answerchoice,$answer)){
								echo "<input type='checkbox' id='".$row[$answerchoice]."' name='".$row["QID"]."[]' value='".$row[$answerchoice]."' disabled checked><b><font color='green'>".$row[$answerchoice]."</font></b><br>";
							}
							else{
								echo "<input type='checkbox' id='".$row[$answerchoice]."' name='".$row["QID"]."[]' value='".$row[$answerchoice]."' disabled>".$row[$answerchoice]."<br>";
							}
							++$answerchoice;
						}
						else{
							$choi = unserialize($choice);
							for($i=0;$i<$row["answerno"];++$i,++$answerchoice){
								if(in_array($answerchoice,$choi)){
									if(in_array($answerchoice,$answer)){
										echo "<input type='checkbox' id='".$row[$answerchoice]."' name='".$row["QID"]."[]' value='".$row[$answerchoice]."' disabled checked><b><font color='green'>".$row[$answerchoice]."</font></b><br>";
									}
									else{
										echo "<input type='checkbox' id='".$row[$answerchoice]."' name='".$row["QID"]."[]' value='".$row[$answerchoice]."' disabled checked><b><font color='red'>".$row[$answerchoice]."</font></b><br>";
									}
								}
								else{
									if(in_array($answerchoice,$answer)){
										echo "<input type='checkbox' id='".$row[$answerchoice]."' name='".$row["QID"]."[]' value='".$row[$answerchoice]."' disabled><b><font color='green'>".$row[$answerchoice]."</font></b><br>";
									}
									else{
										echo "<input type='checkbox' id='".$row[$answerchoice]."' name='".$row["QID"]."[]' value='".$row[$answerchoice]."' disabled>".$row[$answerchoice]."<br>";
									}
								}
								
							}	
						}	
					}
				}
				else{
					$answerchoice = 'A';
					while($row[$answerchoice]!= null){
						if($choice == $row['answer']){
							if($choice == $answerchoice){
								echo "<input type='radio' id='".$row[$answerchoice]."' name='".$row["QID"]."' value='".$row[$answerchoice]."' disabled checked><b><font color = 'green'>".$row[$answerchoice]."</font></b><br>";
							}
							else{
								echo "<input type='radio' id='".$row[$answerchoice]."' name='".$row["QID"]."' value='".$row[$answerchoice]."' disabled>".$row[$answerchoice]."<br>";
							}
						}
						else{						
							if($row['answer'] == $answerchoice){
								echo "<input type='radio' id='".$row[$answerchoice]."' name='".$row["QID"]."' value='".$row[$answerchoice]."' disabled><b><font color = 'green'>".$row[$answerchoice]."</font></b><br>";
							}
							else if($answerchoice == $choice){
								echo "<input type='radio' id='".$row[$answerchoice]."' name='".$row["QID"]."' value='".$row[$answerchoice]."' disabled checked><b><font color = 'red'>".$row[$answerchoice]."</font></b><br>";
							}
							else{
								echo "<input type='radio' id='".$row[$answerchoice]."' name='".$row["QID"]."' value='".$row[$answerchoice]."' disabled>".$row[$answerchoice]."<br>";
							}
						}
						++$answerchoice;
					}
				}
			}
		}
	}
?>
</body>
</html>