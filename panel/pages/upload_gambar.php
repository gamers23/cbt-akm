<?php
	if(!isset($_COOKIE['beeuser'])){
	header("Location: ../../login.php");
}else{
include "../../config/server.php";
$uploaddir = '../../pictures/'; 
$namafile = basename($_FILES['uploadfile']['name']);
$file = $uploaddir . basename($_FILES['uploadfile']['name']); 
 if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
//$sql = mysqli_query($sqlconn,"update cbt_admin set XLogo = '$namafile'");
  echo "success"; 
} else {
//	echo "error";
}
}
?>