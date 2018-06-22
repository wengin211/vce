<html>
<head>
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
		$sql = "SELECT max(QID) FROM vcedb.question";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)> 0 ){
			while($row = mysqli_fetch_assoc($result)) {
				$idno = $row["max(QID)"];
			}
		}
		if($idno == null){
			$idno = 1;
		}
		else{
			$idno += 1;
		}
		//check if img name duplicated
		$sql1 = "SELECT img FROM vcedb.question";
		$result1 = mysqli_query($conn,$sql1);
		if(mysqli_num_rows($result1)> 0 ){
			if($row = mysqli_fetch_assoc($result1)) {
				$img = $row["img"];
			}
		}
		if($img == $_POST["img"]&&$img != null &&$_POST["img"]!=null){
			echo "The img name is duplicated with the existing one. <a href='javascript:window.history.back();'> Please click here to the previous page.</a>";
		}
		else if ($_POST["question"]==null||$_POST["answer"]==null||$_POST["nochoice"]==null||$_POST["A"]==null||$_POST["B"]==null||$_POST["C"]==null||$_POST["D"]==null){
			echo "<a href='javascript:window.history.back();'>Please fill in the the required text field.</a>";
		}
		else{
			$sql2 = "INSERT INTO question(QID,question,ismultiple,answerno,answer,img) VALUES ($idno,'".$_POST["question"]."','".$_POST["ismultiple"]."','".$_POST["nochoice"]."','".$_POST["answer"]."','".$_POST["img"]."')";
			$result2 = mysqli_query($conn,$sql2);
			if($_POST["E"] == null){
				$sql3 = "INSERT INTO answer(A,B,C,D,QID) VALUES ('".$_POST["A"]."','".$_POST["B"]."','".$_POST["C"]."','".$_POST["D"]."',$idno)";
			}
			else if($_POST["F"] == null){
				$sql3 = "INSERT INTO answer(A,B,C,D,E,QID) VALUES ('".$_POST["A"]."','".$_POST["B"]."','".$_POST["C"]."','".$_POST["D"]."','".$_POST["E"]."',$idno)";
			}
			else if($_POST["G"] == null){
				$sql3 = "INSERT INTO answer(A,B,C,D,E,F,QID) VALUES ('".$_POST["A"]."','".$_POST["B"]."','".$_POST["C"]."','".$_POST["D"]."','".$_POST["E"]."','".$_POST["F"]."',$idno)";
			}
			else if($_POST["H"] == null){
				$sql3 = "INSERT INTO answer(A,B,C,D,E,F,G,QID) VALUES ('".$_POST["A"]."','".$_POST["B"]."','".$_POST["C"]."','".$_POST["D"]."','".$_POST["E"]."','".$_POST["F"]."','".$_POST["G"]."',$idno)";
			}
			else{
				$sql3 = "INSERT INTO answer(A,B,C,D,E,F,G,H,QID) VALUES ('".$_POST["A"]."','".$_POST["B"]."','".$_POST["C"]."','".$_POST["D"]."','".$_POST["E"]."','".$_POST["F"]."','".$_POST["G"]."','".$_POST["H"]."',$idno)";
			}
			$result3 = mysqli_query($conn,$sql3);
			if($result2 && $result3){
				echo "New question created. <a href='createquestion.html'>Click here to create a new question</a>";
			}
			else{
				echo "Question failed to create: ". mysqli_error($conn);
			}
		}
	}
	mysqli_close($conn);
?>
</body>
</html>