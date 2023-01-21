<?php
require "../../includes/header.php";
?>

<script type="text/javascript">
	setInterval('location.reload()', 10000); //Reloads page every 10 seconds
</script>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CyberHub Teams</title>
  </head>
  <body>
    <br>
    <div class="row">
      <div class="leftside">
              <table id="teams">
        <tr>
        	<th>Team Name</th>
            <th>Team ID</th>
            <th>Windows-10</th>
            <th>Ubuntu</th>
            <th>Server</th>
            <th>Fedora</th>
          </tr>
        <?php
          require "../../includes/config1_m.php";
          $query = "SELECT team_id, team_name FROM teams WHERE status='ACTIVE'";
          $result = $conn1->query($query);

          if ($result->num_rows > 0) {
          	$os = array("windows-10", "ubuntu", "windows-server", "fedora");
          	$x = 0;
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>". $row['team_name'] . "</td>";
              echo "<td>" . $row['team_id'] . "</td>";

           	  for ($x = 0; $x <= 3; $x++) {
	             $query = "SELECT ROUND((SELECT COUNT(*) FROM comp_log WHERE team_id='" . $row['team_id'] . "' AND os='$os[$x]' AND checked=1)/(SELECT COUNT(*) FROM comp_log WHERE team_id='" . $row['team_id'] . "' AND os='$os[$x]')*100)";

	             $result1 = $conn1->query($query);
	             while ($row1 = $result1->fetch_assoc()) {
	             	foreach($row1 as $key => $value)
						{
				//		  echo $key." has the value". $value;
					//	  echo "<br>";
						  echo "<td>$value</td>";
						}
	             	
	         	 }
              }
            
            }
          }
          $conn1->close();
        ?>
        </tr>
      </table>
      </div>
      <div class="middle">
      </div>
  </body>
</html>
