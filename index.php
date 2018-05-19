<?php
include "inc/config.php";
include "inc/function.php";
include "inc/header.php";
$Gapp = isv("app");
if($Gapp){
if($Gapp == "home"){
include "inc/home.php";
}else if($Gapp == "video"){
include "inc/video.php";
}else if($Gapp == "contact"){
  include "inc/contact.php";
}else if($Gapp == "cat"){
include "inc/cat.php";
} else if($Gapp == "about" || $Gapp == "privacy" ){
include "inc/about.php";
}else{
include "inc/signup.php";
}



}else{
include "inc/home.php";
}


include "inc/footer.php";

?>