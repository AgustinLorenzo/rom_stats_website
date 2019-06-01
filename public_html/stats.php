<?php

// Load main includes
require_once('config.inc.php');

$totalInstalls = DB::queryFirstField('SELECT count(1) FROM zrom_stats');
$totalInstallsLast24h = DB::queryFirstField('SELECT count(1) FROM zrom_stats WHERE date_register > date_sub(now(), INTERVAL 24 HOUR)');
$totalUpdatesLast24h = DB::queryFirstField('SELECT count(1) FROM zrom_stats WHERE date_last_checking > date_sub(now(), INTERVAL 24 HOUR)');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ROM Statistics of @agustindev</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body>
    <div class="container">
      <!-- Page Header -->
      <div class="row">
        <div class="col"><div class="page-header"><h1>ROM Statistics of @agustindev</h1></div></div>
      </div>
<div class="row">
  <div class="col">
    <h2>Total Installs</h2>
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <tr><th>Type</th><th>Total</th></tr>
      </thead>
      <tbody>
        <tr><td>Total Installs</td><td><?=$totalInstalls?></td></tr>
        <tr><td>Installed last 24 Hours</td><td><?=$totalInstallsLast24h?></td></tr>
        <tr><td>Updated last 24 Hours</td><td><?=$totalUpdatesLast24h?></td></tr>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col">
    <h2>Installs by ROM</h2>
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <tr><th>ROM</th><th>Total</th></tr>
      </thead>
      <tbody>
      <?php
      $romList = DB::query('SELECT rom_name, rom_version, COUNT( 1 ) as rom_tot FROM  zrom_stats GROUP BY rom_name, rom_version ORDER BY 2 DESC LIMIT 0 , 50');

      foreach ($romList as $rom) {
      ?>
        <tr><td><?=$rom['rom_name']?></td><td><?=$rom['rom_tot']?></td></tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
  <div class="col">
    <h2>Installs by Device</h2>
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <tr><th>Device</th><th>Total</th></tr>
      </thead>
      <tbody>
      <?php
      $romList = DB::query('SELECT device_name, COUNT( 1 ) as rom_tot FROM  zrom_stats GROUP BY device_name ORDER BY 2 DESC LIMIT 0 , 50');

      foreach ($romList as $rom) {
      ?>
        <tr><td><?=$rom['device_name']?></td><td><?=$rom['rom_tot']?></td></tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
   <div class="col">
    <h2>Installs by Country</h2>
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <tr><th>Country</th><th>Total</th></tr>
      </thead>
      <tbody>
      <?php
      $list_country = DB::query('SELECT device_country,COUNT(1) AS total FROM zrom_stats GROUP BY device_country ORDER BY total DESC LIMIT 0,50;');

      foreach ($list_country as $country) {
      ?>
        <tr><td><?=$country['device_country']?></td><td><?=$country['total']?></td></tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
