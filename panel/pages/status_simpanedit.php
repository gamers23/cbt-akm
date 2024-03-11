<?php ob_start();
if(!isset($_COOKIE['beeuser'])){
	header("Location: login.php");}
    }else{
include "../../config/server.php";
$tokenujian = $_POST['tokenujian'];
$statustoken = $_POST['statustoken'];

$query=mysqli_query($sqlconn,"update cbt_ujian set XStatusToken='$statustoken' where XTokenUjian='$tokenujian'");
header('location:index.php');
}
?>
