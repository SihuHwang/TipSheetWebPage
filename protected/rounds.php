<?php
require "../includes/header.php";
?>


<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CyberHub Rounds</title>
  </head>
  <body>
    <br>
    <div class="row">
      <div class="leftside">
        <div class="sqmenubar">
          <ul>
            <li><a href="../includes/newround.php">New Round</a><li>
          </ul>
        </div>
      </div>
      <div class="middle">
      <table id="teams">
        <tr>
          <th>Round ID</th>
          <th>Team ID</th>
          <th>Status</th>
        </tr>
        <?php
          require "../includes/config1_m.php";
          $query = "SELECT * FROM rounds WHERE status='ACTIVE'";
          $result = $conn1->query($query);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>". $row['round_id'] . "</td>";
              echo "<td>" . $row['team_id'] . "</td>";
              echo "<td>" . $row['status'] . "</td>";
            }
          }
          $conn1->close();
        ?>
        </tr>
      </table>
    </div>
  </body>
</html>
