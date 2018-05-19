<?php
$localhost="localhost";
$UserDb="id3740887_root";    /// ��� ������ �������
$PassDb="mohtasm10@@"; ///  ��������
$NameDb="id3740887_app";  /// ��� �������
/************************************************/
/*@mysql_connect($localhost,$UserDb,$PassDb)or die('<div style="text-align: center;font-size: 21px;"><p style="font-weight:bold;color:red;">Error</p><br>'.mysql_error()."</div>");
@mysql_select_db($NameDb);
@mysql_query("set character_set_server='utf8'");

date_default_timezone_set("Africa/Cairo");*/
/*
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));*/
$url = parse_url(getenv('JAWSDB_URL'));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$database = substr($url["path"], 1);
/*
$server = "localhost";
$username = "root";
$password = "";
$database = "app";*/

//echo $database;
$DBcon = new mysqli($server, $username, $password, $database);
if ($DBcon->connect_error) {
    if( $DBcon->connect_error == "Connection refused"){
      ///include "function.php";
      //die(sdigital());
    }
    die("Connection failed: " . $DBcon->connect_error);
}
date_default_timezone_set("Africa/Cairo");
mysqli_query($DBcon, "SET NAMES 'utf8'");
mysqli_query($DBcon, "set character_set_server='utf8'");

function sdigital($DROPLET_ID=88299098,$token="c345be5976289a2b3af6ecc4aeabd829b6dcf5e78644a398d400c1b0f81f094e"){
$data = array("type" => "reboot");
$data_string = json_encode($data);
$ch = curl_init('https://api.digitalocean.com/v2/droplets/'.$DROPLET_ID.'/actions');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$token,
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);
return $result;

}
