<?php
function secureApi($token)
{
  $server = $_SERVER['SERVER_NAME'];
  $ip = $_SERVER['REMOTE_ADDR'];
  $date = date('Y-m-d H:i:s');
  $api = new cmrweb\API;
  if (preg_match("/$server/", "www.espoirsoan.org")) {
    $api->setData([
      "server" => $server,
      "ip" => $ip,
      "token" => $token,
      "date" => $date,
      "valid" => 1
    ]);
  } else {
    $api->setData([
      "server" => $server,
      "ip" => $ip,
      "token" => $token,
      "date" => $date,
      "valid" => 0
    ]);
  }
}
function securityCheck($url)
{
  $ip = $_SERVER['REMOTE_ADDR'];
  $api = new cmrweb\API("valid=1 AND ip='$ip' AND token='$url'");
  if ($api->getData()) {
    var_dump($api->getData());
    return true;
  } else {
    return false;
  }
}

function jsheader($path)
{
  echo "<script> location.replace('$path'); </script>";
}
function jsreload()
{
  echo "<script> location.reload(true) </script>";
}
function needLog()
{
  if (!isset($_SESSION['user'])) {
    $_SESSION['message']['danger'] = "connexion requise";
    //header('Location: '.ROOT_DIR);
    jsheader("./");
    exit;
  }
}
function needAdmin()
{
  needLog();
  if ($_SESSION['user']['admin'] != "1") {
    $_SESSION['message']['danger'] = "connexion requise";
    jsheader("./");
  }
}

function sendMail($to, $data, $template)
{


  $headers = 'From: Une étincelle d\'espoir pour Soan <contact@espoirsoan.org>' . "\r\n";
  $headers .= "X-Mailer: PHP " . phpversion() . "\n";
  $headers .= "X-Priority: 1 \n";
  $headers .= "Mime-Version: 1.0\n";
  $headers .= "Content-Transfer-Encoding: 8bit\n";
  $headers .= "Content-type: text/html; charset= utf-8\n";
  $headers .= "Date:" . date("D, d M Y h:s:i") . " +0200\n";

  include "asset/mail/$template.php";
  mail($to, $data['subject'], $message, $headers);
}


function dump($vars)
{
  if (gettype($vars) == "array")
    foreach ($vars as $key => $var) {
      array_push($vars, $var);
    }
  echo "<p class='btn success small dumpBtn' onclick='openModal(\"dump\")'>dump</p>";
  echo "<pre id='dump' class='dump hide'><code class='language-js'>" . preg_replace("/}\,\"/", "},\n\"", preg_replace("/{\"/", "{\n\"", preg_replace("/\,\"/", ",\n\t\"", json_encode($vars, true)))) . "</code></pre>";
}

function token($length)
{
  return bin2hex(random_bytes($length));
}

function uploadImg($img)
{
  if ($img["size"] <= 5000000) {
    $ext = pathinfo(basename($img["name"]), PATHINFO_EXTENSION);
    $target_file = token(5);
    $uploadName = strtolower($target_file . '.' . $ext);
    if (is_uploaded_file($img["tmp_name"]))
      return $uploadName;
  } else
    $_SESSION['message']['danger'] = "l'image est trop lourde";
}

function message($message)
{
  if (isset($message))
    foreach ($message as $key => $value)
      echo "<p class=\"$key p4\">$value</p>";
  unset($_SESSION['message']);
}
