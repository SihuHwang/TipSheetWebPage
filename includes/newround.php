<?php
require "../includes/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $round_id = $_POST['field11'];

    foreach($_POST['test'] as $team_id) {
	  require "config1_m.php";
	  $query = "INSERT INTO rounds (round_id, team_id, status) VALUES ('$round_id', '$team_id', 'ACTIVE')";
	  $conn1->query($query);

	  //Add New Checklist Items
	  $table = array(
            array("SELECT * FROM win_ten",),
            array("SELECT * FROM ubuntu"),
            array("SELECT * FROM win_server"),
            array("SELECT * FROM ciso"),
          );
	  for ($x = 0; $x <= 3; $x++) {
	    $value = $table[$x][0];
		$result1 = $conn1->query($value);

    	if ($result1->num_rows > 0) {
			while($row1 = $result1->fetch_assoc()) {
		 		$query1 = "INSERT INTO comp_log (round_id, team_id, os, item) VALUES ('$round_id', '$team_id', 'windows-10', '" . $row1['item'] . "')";
		 		$conn1->query($query1);
		 	}
	 	}
	  }
	  $conn1->close();
	}
}
?>

<style type="text/css">
.form-style-2{
	max-width: 500px;
	padding: 20px 12px 10px 20px;
	font: 13px Arial, Helvetica, sans-serif;
}
.form-style-2-heading{
	font-weight: bold;
	font-style: italic;
	border-bottom: 2px solid #ddd;
	margin-bottom: 20px;
	font-size: 15px;
	padding-bottom: 3px;
}
.form-style-2 label{
	display: block;
	margin: 0px 0px 15px 0px;
}
.form-style-2 label > span{
	width: 100px;
	font-weight: bold;
	float: left;
	padding-top: 8px;
	padding-right: 5px;
}
.form-style-2 span.required{
	color:red;
}
.form-style-2 .tel-number-field{
	width: 40px;
	text-align: center;
}
.form-style-2 input.input-field, .form-style-2 .select-field{
	width: 48%;	
}
.form-style-2 input.input-field, 
.form-style-2 .tel-number-field, 
.form-style-2 .textarea-field, 
 .form-style-2 .select-field{
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	border: 1px solid #C2C2C2;
	box-shadow: 1px 1px 4px #EBEBEB;
	-moz-box-shadow: 1px 1px 4px #EBEBEB;
	-webkit-box-shadow: 1px 1px 4px #EBEBEB;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	padding: 7px;
	outline: none;
}
.form-style-2 .input-field:focus, 
.form-style-2 .tel-number-field:focus, 
.form-style-2 .textarea-field:focus,  
.form-style-2 .select-field:focus{
	border: 1px solid #0C0;
}
.form-style-2 .textarea-field{
	height:100px;
	width: 55%;
}
.form-style-2 input[type=submit],
.form-style-2 input[type=button]{
	border: none;
	padding: 8px 15px 8px 15px;
	background: #FF8500;
	color: #fff;
	box-shadow: 1px 1px 4px #DADADA;
	-moz-box-shadow: 1px 1px 4px #DADADA;
	-webkit-box-shadow: 1px 1px 4px #DADADA;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
}
.form-style-2 input[type=submit]:hover,
.form-style-2 input[type=button]:hover{
	background: #EA7B00;
	color: #fff;
}
</style>

<html>
  <head>
    <title>CyberHub New Round</title>
  </head>
  <body>
	<div class="form-style-2">
		<div class="form-style-2-heading">Provide your information</div>
			<form action="newround.php" method="post">
				<label for="field1"><span>Round ID <span class="required">*</span></span><input type="text" class="input-field" name="field11" value="" required/></label>
				<?php
					require "config1_m.php";
					$query = "SELECT team_id, team_name FROM teams WHERE status='ACTIVE'";
					$result = $conn1->query($query);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<br><input type='checkbox' name=test[] value='" . $row["team_id"] . "' />"  . $row["team_name"] . " - " . $row["team_id"] . "<br/>";
						}
					}
				?>
				<label><span> </span><input type="submit" value="Submit" /></label>
			</form>
		</div>	
	</div>
  </body>
</html>
