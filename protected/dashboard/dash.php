<?php
require "../../includes/header.php";


require "../../includes/config1_m.php";
$query = "SELECT * FROM comp_log WHERE team_id='". $_SESSION['team_id'] . "' AND os='windows-10' AND round_id=(SELECT round_id FROM rounds WHERE team_id='" . $_SESSION['team_id'] . "')";
$result = $conn1->query($query);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if ($row['checked'] == "1") {
     echo "<br><input type='checkbox' class='thecheckbox' id='" . $row["id"] . "' checked/>"  . $row["item"] . "<br/>"; 
    } else {echo "<br><input type='checkbox' class='thecheckbox' id='" . $row["id"] . "'/>"  . $row["item"] . "<br/>";}
  }
}
?>

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
        <div class="sqmenubar">
      </div>
      <div class="middle">
      <table id="teams">
        <tr>
         <th>Team Name</th>
            <th>Team ID</th>
            <th>Windows Comp.</th>
            <th>Ubuntu Comp.</th>
          </tr>
        <?php
          require "../includes/config1_m.php";
          $query = "SELECT * FROM teams WHERE status='ACTIVE'";
          $result = $conn1->query($query);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>". $row['team_name'] . "</td>";
              echo "<td>" . $row['team_id'] . "</td>";
              echo "<td>" . $row['division'] . "</td>";
              echo "<td>" . $row['unique_id'] . "</td>";

              $query = "SELECT * FROM users WHERE team_id='" . $row['team_id'] . "'";
              $result1 = $conn1->query($query);
              $members = "";
              while($row1 = $result1->fetch_assoc()) { 
                $members = $row1['first_name'] . ", " . $members;
              }
              echo "<td>$members</td>";
            }
          }
          $conn1->close();
        ?>
        </tr>
      </table>
    </div>
  </body>
</html>
