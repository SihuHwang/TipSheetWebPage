<?php
  session_start();
  if(!isset($_SESSION['password'])){
    header("Location: https://cyber.caphub.org/index.php");
    exit();
  }

  if(isset($_GET['logout'])) {
    header("Location: https://cyber.caphub.org/index.php");
  }
?>


<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cyber.caphub.org/protected/style.css">
    <a href="https://cyber.caphub.org/protected/main.php"><img src="https://cyber.caphub.org/images/cyberban.png"></a>
    <div class="userid">
      <?php echo "" . $_SESSION['name'];?>
      <br>
      <?php 
        require "config1_m.php";
        $query = "SELECT team_id FROM users WHERE cap_id='". $_SESSION['capid'] . "'";
        $result = $conn1->query($query);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "Team ID: " . $row['team_id'];
            $_SESSION['team_id'] = $row['team_id'];
          }
        }
        $conn1->close();
      ?>
    </div>
    <div class="countmedown">
      <i><b><p id="countdown" style="margin-bottom: 0px;"></p></b></i>
    </div>
  </head>
  <body>
    <div class="menubar">
      <ul>
        <li><a href="https://cyber.caphub.org/protected/index.php">Tips Sheets</a></li>
       <!-- <li><a href="https://cyber.caphub.org/protected/scores.php">Scores</a></li> -->
        <?php if($_SESSION['privlv'] >= 2){ ?>
          <li><a href="https://cyber.caphub.org/protected/teams.php">Teams</a></li>
          <li><a href="https://cyber.caphub.org/protected/dashboard/dash.php">Dashboard</a></li>
        <?php } ?>
        <li><a href="https://cyber.caphub.org/protected/rounds.php">Rounds</a></li>
        <li><a href="https://cyber.caphub.org/protected/vulnCats.php">Vuln Cats</a></li>
        <li><a href="help.php">Help</a></li>
        <li><a href="?logout=1">Log out</a></li>
      </ul>
    </div>
    <div class="dropdownheader">
      <button class="dropbtn">Menu</button>
      <div class="dropdown-content">
        <li><a href="https://cyber.caphub.org/protected/index.php">Tips Sheets</a></li>
      <!--  <li><a href="https://cyber.caphub.org/protected/scores.php">Scores</a></li> -->
        <?php if($_SESSION['privlv'] >= 2){ ?>
          <li><a href="https://cyber.caphub.org/protected/teams.php">Teams</a></li>
          <li><a href="https://cyber.caphub.org/protected/dashboard/dash.php">Dashboard</a></li>
        <?php } ?>
        <li><a href="https://cyber.caphub.org/protected/rounds.php">Rounds</a></li>
        <li><a href="https://cyber.caphub.org/protected/vulnCats.php">Vuln Cats</a></li>
        <a href="help.php">Help</a>
        <a href="?logout=1">Log out</a>
      </div>
    </div>
  </body>
</html>


<script>
// Set the date we're counting down to
var countDownDate = new Date("March 17, 2023 06:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="countdown"
  document.getElementById("countdown").innerHTML ="Semifinals Live in:  " + days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
