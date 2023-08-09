<?php header("Refresh:3"); ?>
<?php
$getter = file_get_contents('security_status.txt', true);
if ($getter == Arm) {
  $nick="Armed";
  $nickstyle="#5cb85c";
} else {
  $nick="Disarmed";
  $nickstyle="#d9534f";
}
?>


<?php
  function Arm() {
    $myfile = fopen("security_status.txt", "w") or die("Unable to open file!");
    $txt = "Arm";
    fwrite($myfile, $txt);
    fclose($myfile);
  }

  if (isset($_GET['arm'])) {
    Arm();
  }
?>

<?php
  function Disarm() {
    $myfile = fopen("security_status.txt", "w") or die("Unable to open file!");
    $txt = "Disarm";
    fwrite($myfile, $txt);
    fclose($myfile);
  }

  if (isset($_GET['disarm'])) {
    Disarm();
  }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bennett Home Security System</title>

    <!-- Bootstrap core CSS -->

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/custom.css" rel="stylesheet">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

<?php

$basement= shell_exec('gpio read 21');
if ($basement == 1) {
  $basement_status="Closed";
  $basement_style="table-success";
} else {
  $basement_status="Open";
  $basement_style="table-danger";
}

$garage= shell_exec('gpio read 22');
if ($garage == 1) {
  $garage_status="Closed";
  $garage_style="table-success";
} else {
  $garage_status="Open";
  $garage_style="table-danger";
}

$front= shell_exec('gpio read 27');
if ($front == 1) {
  $front_status="Closed";
  $front_style="table-success";
} else {
  $front_status="Open";
  $front_style="table-danger";
}

$glass= shell_exec('gpio read 3');
if ($glass == 1) {
  $glass_status="No Glass";
  $glass_style="table-success";
} else {
  $glass_status="Glass Break";
  $glass_style="table-danger";
}

$motion= shell_exec('gpio read 4');
if ($motion == 1) {
  $motion_status="No Motion";
  $motion_style="table-success";
} else {
  $motion_status="Motion";
  $motion_style="table-danger";
}

$kitchen = exec("gpio read 5");
if ($kitchen == 1) {
  $kitchen_status="Closed";;
  $kitchen_style="table-success";;
} else {
  $kitchen_status="Open";;
  $kitchen_style="table-danger";;
}

?>

    <!-- Custom styles for this template -->
  </head>
  <body class="bg-light">
<header class="bd-header bg-dark py-3 d-flex align-items-stretch border-bottom border-dark">
</header>
</br>

<h1 class="text-center" style =color:<?php echo $nickstyle; ?> ><?php echo $nick;?></h1>

        <div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Zone</th>
            <th scope="col">Status</th>
          </tr>
          </thead>
          <tbody>
          <tr class=" <?php echo $front_style;?>" >
            <th scope="row">Front Door</th>
            <td><?php echo $front_status; ?></td>
          </tr>
          <tr class=" <?php echo $kitchen_style;?>" >
            <th scope="row">Kitchen Door</th>
            <td><?php echo $kitchen_status; ?></td>
          </tr>
          <tr class=" <?php echo $garage_style;?>" >
            <th scope="row">Garage Door</th>
            <td><?php echo $garage_status; ?></td>
          </tr>

          <tr class=" <?php echo $basement_style;?>" >
            <th scope="row">Basement Door / Windows</th>
            <td><?php echo $basement_status; ?></td>
          </tr>
          </tbody>
        </table>
        </div>

        <div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Zone</th>
            <th scope="col">Status</th>
          </tr>
          </thead>
          <tbody>
	    <tr class=" <?php echo $glass_style;?>" >
            <th scope="row">Glass Break</th>
            <td><?php echo $glass_status; ?></td>
          </tr>
          <tr class=" <?php echo $motion_style;?>" >
            <th scope="row">Basement Motion</th>
            <td><?php echo $motion_status; ?></td>
          </tr>
          </tbody>
        </table>
        </div>

</br></br>
<div class="container">
  <div class="row">
    <div class="col">
      <a href='index.php?arm=true' class="btn btn-success">&nbsp;&nbsp;Arm System&nbsp;&nbsp;</a>
    </div>
    <div class="col">
      <a href='index.php?disarm=true' class="btn btn-danger">Disarm System</a>
    </div>
  </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>

  </body>
</html>
