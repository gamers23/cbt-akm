<?php
include "../../config/server.php";

if($val == TRUE){
	if (mysqli_query($sqlconn, "select * from cbt_zona LIMIT 1")==TRUE){
	$skullogin= $log['XLogin'];
	$email=$log['XEmail'];
	$web=$log['XWeb'];
	$alamat=$log['XAlamat'];
	$tlp=$log['XTelp'];
	$h1=$log['XH1'];
	$h2=$log['XH2'];
	$h3=$log['XH3'];
	$cbt_header = mysqli_query($sqlconn, 'select * from cbt_header');
	$ch = mysqli_fetch_array($cbt_header);
	if (mysqli_query($sqlconn, "select * from cbt_sinc LIMIT 1")==TRUE){
		$hakakses=$ch['HakAkses'];
		$loginpanel=$ch['LoginPanel'];
	}else{
		$hakakses=0;
		$loginpanel=0;
	}
	
}else{$skullogin= $log['XLogin'];
	$email=$log['XEmail'];
	$web=$log['XWeb'];
	$alamat=$log['XAlamat'];
	$tlp=$log['XTelp'];
	$h1=$log['XH1'];
	$h2=$log['XH2'];
	$h3=$log['XH3'];
	$cbt_header = mysqli_query($sqlconn, 'select * from cbt_header');
	$ch = mysqli_fetch_array($cbt_header);	
	$hakakses="0";
	$loginpanel="0";
	
}}else{
$skull= "UJIAN BERBASIS KOMPUTER";
	$skullogin="pertama.jpg";
	$web="beesmart.my.id";
	$tlp="0000-00000";
	$h1="UJIAN BERBASIS KOMPUTER";
	$h2="BEESMART EDUCATION PARTNER";
	$h3="BEESMART-CBT Login";	
	$hakakses="0";
	$loginpanel="0";
	
}

if(isset($sqlconn)){} else {$pesan1 = "Tidak dapat Koneksi Database.";}
if (!$sqlconn) {die('Could not connect: '.mysqli_error($sqlconn));}
 
 ?>

 <!--
 <?php
include "../../config/server.php";
$sql = mysqli_query($sqlconn, "select * from cbt_admin");
$xadm = mysqli_fetch_array($sql);
$skulpic= $xadm['XLogo'];
$skulban= $xadm['XBanner'];
$skulnam= $xadm['XSekolah']; 
$skultin= $xadm['XTingkat']; 
$skulala= $xadm['XAlamat'];
$skultel= $xadm['XTelp']; 
$skulfax= $xadm['XFax'];
$skulema= $xadm['XEmail']; 
$skulweb= $xadm['XWeb'];
$skulkep= $xadm['XKepSek']; 
$skulweb= $xadm['XWeb'];
$skuladm= $xadm['XAdmin']; 
$admpic= $xadm['XPicAdmin']; 
$skulkode= $xadm['XKodeSekolah']; 
$skulnip1= $xadm['XNIPKepsek']; 
$skulnip2= $xadm['XNIPAdmin']; 
$skullogin= $xadm['XLogin'];


?>
 -->
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $skull; ?> | Administrator</title>
	<script language="JavaScript">
		var txt="<?php echo $skull; ?> | Administrator.....  ";
		/*var kecepatan=100;var segarkan=null;function bergerak() { document.title=txt;
		txt=txt.substring(1,txt.length)+txt.charAt(0);
		segarkan=setTimeout("bergerak()",kecepatan);}bergerak();*/
	</script>
		<link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="../../assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css">
        <link href="../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="../../assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
		<link href='../../images/icon.png' rel='icon' type='image/gif'/>
      
	

<!-- Custom Fonts -->
<style>
#ingat{width:100%; height:auto; background-color:#FBECF0; border:0; border-left:thick #FF0000 solid; padding-left:10; padding-top:15}
</style>

<script>
	function disableBackButton() {window.history.forward();}
	setTimeout("disableBackButton()", 0);
</script>
<script src="js/jquery-1.11.0.min.js">
function validateForm() {
    var x = document.forms["loginform"]["userz"].value;
    var y = document.forms["loginform"]["passz"].value;
    var peluru = '\u2022';
    if (x == null || x == "" || y == null || y == "") {
		document.getElementById("ingat").style.display = "block";
		document.getElementById("isine").textContent= peluru+"Username dan Password harus diisi";
        return false;
    }
}

</script>
<!-- Show Password -->
 
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="../../asset/bootstrap-show-password.js"></script>
<script>
    $(function() {
        $('#passz').password().on('show.bs.password', function(e) {
            $('#eventLog').text('On show event');
            $('#methods').prop('checked', true);
        }).on('hide.bs.password', function(e) {
                    $('#eventLog').text('On hide event');
                    $('#methods').prop('checked', false);
                });
        $('#methods').click(function() {
            $('#passz').password('toggle');
        });
    });
</script>
<!-- /Show Password -->
  </head>
<body class="login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset">
                    <div class="login-bg " style="background-image:url(images/<?php echo "$skullogin"; ?>">
                        <img class="login-logo" src="../../images/<?php echo $skulban; ?>" width="200"/> </div>
					
                </div>
				
                <div class="col-md-6 login-container bs-reset">
				<div class="login-header">
                    <div class="mt-element-ribbon bg-grey-steel">
                        <div class="ribbon ribbon-color-danger uppercase ribbon-shadow">Nama Server</div>
                        <div class="ribbon-content">
						<h3><?php echo $h1; ?><?php echo "&nbsp;-&nbsp;"."$skulkode"; ?></h3>
						<h4><?php echo $h2; ?></h4>
						<h5><?php echo "Web : ".$web." &nbsp;-&nbsp; Telp : ".$tlp; ?><!--<br><?php echo "Email: ".$email; ?>!--></h5>
						</div>
                    </div>
											
					
				</div>



									<div class="login-content" style="margin-top:15%">
															<h1><?php echo "$h3"; ?> </h1>
															<p> Selamat datang di Admin Panel CBTSync V.2.5 , Silahkan Masukan username dan password untuk login ke halaman administrator. </p>
															<div id="ingat" class="note-note danger" style="display:block"> 
																<?php 
																if($val == FALSE)
																{?>
																<font style=" padding:10px; font-size:16px ; color:#20202f;">Peringatan :</font>
																<p>
																
																
																<span id="isine" style="color:#CC3300; margin-left:10px;" ></span>
																<?php echo "Database belum terbentuk, Klik "; ?>	
																	<a href="buat_database.php" class="label" style="color:#ececfb; font-style:weight; background-color:#0080c0;"><strong>DISINI</strong> 
																</a><?php echo "&nbsp; untuk membuat Database."; ?>
																<?php 
																}
																?>
																</p> 
															</div>
											
											
											
											
								<form id="loginform"  name="loginform" onSubmit="return validateForm();" action="../pages/ceklogin.php" class="login-form" method="post">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span id="ingat"><?php echo "Username dan Password harus diisi "; ?>. </span>

                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Username" id="userz" name="userz" required /> </div>
                                <div class="col-xs-8">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" id="passz" name="passz" required / > </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
								<div class="switch-field">
								<!-- <input type="radio" id="switch_left" name="login" value="admin" checked/>
								<label for="switch_left"><font style="color:#99ccff">Admin</font></label>
								<input type="radio" id="switch_right" name="login" value="guru" />
								<label for="switch_right"><font style="color:#99ccff">Guru</font></label> -->
								
								<input type="radio" id="radio_admin" name="loginz" value="admin" checked /> 
								<label for="radio_admin">Admin</label>
								<?php if ($hakakses==0) {?>
								<input type="radio" id="radio_guru" name="loginz" value="siswa" /> 
								<label for="radio_guru">Siswa</label>
								<?php }?>
								<input type="radio" id="radio_siswa" name="loginz" value="guru" /> 
								<label for="radio_siswa">Guru</label>
								
								</div>
                                </div>
							<?php 
if(!$val == FALSE) {?>
                                <div class="col-sm-4 text-right">
                                   
                                  <button class="btn btn-success" id="showtoast" data-close="alert" type="submit">SUBMIT</button>
                                </div>
								<?php 
}
?>
                            </div>
                        </form>
                        <!-- BEGIN FORGOT PASSWORD FORM --><!-- END FORGOT PASSWORD FORM -->
                    </div>
                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset">
                               
                            </div>
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
								<p>Beesmart V5.2 - Copyright &copy; 2023 &nbsp;<a href="#">. </a> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		
			
		

 <!-- END : LOGIN PAGE 5-1 -->
        
		<script src="../../assets/global/plugins/respond.min.js"></script>
		<script src="../../assets/global/plugins/excanvas.min.js"></script> 

        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="../assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/login-5.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->

</script>
</body>
</html>
