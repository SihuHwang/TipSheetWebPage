<?php
require "../includes/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_name = $_POST['field11'];
    $team_id = $_POST['field22'];
    $division = $_POST['field33'];
    $tests = $_POST['test'];

    foreach($_POST['test'] as $cap_id) {
    	require "config_m.php";
    	$query = "SELECT first_name, last_name FROM sq_members WHERE cap_id='$cap_id'";
    	$result = $conn->query($query);

	    if ($result->num_rows > 0) {
	      while($row = $result->fetch_assoc()) {
	      	$first_name = $row['first_name'];
	      	$last_name = $row['last_name'];

	      	require "config1_m.php";
	      	$query = "INSERT INTO users (first_name, last_name, cap_id, team_id) VALUES ('$first_name', '$last_name', $cap_id, '$team_id')";
		    $conn1->query($query);
		    $conn1->close();
	      }
	    }
	    $conn->close();
    }

    $query = "INSERT INTO teams (team_id, team_name, status, division) VALUES ('$team_id', '$team_name', 'ACTIVE', $division)";
    require "config1_m.php";
    $conn1->query($query);
    $conn1->close();
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
    <title>CyberHub Add Team</title>
  </head>
  <body>
	<div class="form-style-2">
		<div class="form-style-2-heading">Provide your information</div>
			<form action="addteam.php" method="post">
				<label for="field1"><span>Team Name <span class="required">*</span></span><input type="text" class="input-field" name="field11" value="" required/></label>
				<label for="field2"><span>Team ID <span class="required">*</span></span><input type="text" class="input-field" name="field22" value="" required/></label>
				<label for="field3"><span>Division</span><select name="field33" class="select-field">
					<option value="OP">Open</option>
					<option value="AS">All Service</option>
					<option value="MS">Middle School</option>
					<option value="ME">Mentor</option>
				</select></label>
				<?php
					require "config_m.php";
					$query = "SELECT * FROM sq_members WHERE cp=1";
		            $result = $conn->query($query);
		            $test = 0;
		            if ($result->num_rows > 0) {
		            	while($row = $result->fetch_assoc()) {
		            		echo "<br><input type='checkbox' name=test[] value='" . $row["cap_id"] . "' />"  . $row["first_name"] . " - " . $row["cap_id"] . "<br/>";
		            		$test++;
		            	}
		            }
				?>
				<label><span> </span><input type="submit" value="Submit" /></label>
			</form>
		</div>	
	</div>
  </body>
</html>
