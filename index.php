<?php
function getUserIP() {
  if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
  }
  $client = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote = $_SERVER['REMOTE_ADDR'];
  if (filter_var($client, FILTER_VALIDATE_IP)) {
    $ip = $client;
  } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
    $ip = $forward;
  } else {
    $ip = $remote;
  }
  return $ip;
}
$ip = getUserIP();
$ipnya = $ip;
$jo = file_get_contents("http://ipwho.is/$ipnya");
$joe = json_decode($jo, true);
$isp = $joe["connection"]["isp"];
$city = $joe["city"];
$country = $joe["country"];
$flag = $joe["flag"]["emoji"];
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>What's My IP? - Check Your IP Address</title>
  <meta charset="utf-8">
  <link rel="canonical" href="<?php echo $actual_link ?>" />
<meta content="width=device-width,initial-scale=1,shrink-to-fit=no" name="viewport">
<meta name="description" content="What's My IP? - Check your IP Address here">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<style>
  body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    color: #b0bec5;
    display: table;
    position: fixed;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif
  }

  .container {
    text-align: center;
    display: table-cell;
    vertical-align: middle
  }

  .content {
    text-align: center;
    display: inline-block
  }

  .title {
    font-size: 4.3vw;
    font-weight: 700
  }

  .data {
    font-size: 3.2vw
  }

  .localip {
    font-size: 3.1vw;
    margin-bottom: 40px
  }

  .info {
    font-size: 3vw
  }
</style>
</head>
<body>
<div class="container">
<div class="content">
<div class="title">
<?php echo $ip ?>
</div>
<div class="data">
<p>
<small>Country: <?php echo $country ?> <?php echo $flag ?> | City: <?php echo $city ?> <br>ISP: <?php echo $isp ?> </small>
</p>
</div>
<p class="localip" id="localip">
DNS Server: Checking...
</p>
<div class="info">
<p>
<small>Created by <a href="//caliph.my.id" style="color:#b0bec5">Caliph</a>
</small>
</p>
</div>
</div>
</div>
<script>
fetch("https://edns.ip-api.com/json")
.then(a => a.json().then(r => {
document.getElementById("localip").innerHTML = "DNS Server: " + (r.dns.geo)
}))
</script>
</body>
</html>
