<?php
	if(!isset($_COOKIE['beeuser'])){
	header("Location: login.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style>
.left {float: left; width: 75%;}
.right { float: right; width: 23%;}
.group:after {content:"";display: table;clear: both;}
img {
    max-width: 100%;
    height: auto;
}
@media screen and (max-width: 480px) {
    .left, 
    .right {
        float: none;
        width: auto;
		margin-top:10px;		
    }	
}
</style>
<script type="text/javascript" src="./js/jquery.gdocsviewer.min.js"></script> 
<!--
<script type="text/javascript"> 
/*<![CDATA[*/
$(document).ready(function() {
	$('a.embed').gdocsViewer({width: 600, height: 750});
	$('#embedURL').gdocsViewer();
});
/*]]>*/
</script> 
-->
    <link href="css/nedna.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <script src="./js/jquery.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
  
  <script type="text/javascript"
  src="../../mesin/MathJax/MathJax.js?config=AM_HTMLorMML-full"></script>

<!-- script untuk refresh/reload mathjax setiap content baru !-->
   <script>
  MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
</script>
<!-- script untuk refresh/reload mathjax setiap content baru !-->
<body style="width:90%; margin:0 auto;margin-top:50px; ">
<?php
include "../../config/server.php";
include "../../config/fungsi_tgl.php";
?>

<?php
$var_soal = "$_REQUEST[idsoal]";

$sql0 = mysqli_query($sqlconn,"select m.*, p.*,k.*, p.XKodeJurusan as XKodeJurusan, p.XKodeKelas as XKodeKelas, p.XTglBuat as TglBuat from cbt_paketsoal p 
		LEFT JOIN cbt_mapel m on m.XKodeMapel = p.XKodeMapel 
		LEFT JOIN cbt_kelas k ON k.XKodeKelas = p.XKodeKelas
	
		where p.XKodeSoal = '$var_soal'"); 
$p = mysqli_fetch_array($sql0);
$namamapel = $p['XNamaMapel'];
$kodesoal = $p['XKodeSoal'];
$namakelas=$p['XKodeKelas'];

$namaguru=$p['XGuru'];
$tglbuat=indonesian_date($p['TglBuat']);
$kodekelas = $p['XKodeKelas'];
$kodejurusan = $p['XKodeJurusan'];

if($kodekelas=="ALL") {
	$kelas="ALL";
} else {
	$kelas=$namakelas;
};

if($kodejurusan=="ALL") {
	$jurusan="ALL";
} else {$jurusan=$kodejurusan;};

$sql1 = mysqli_query($sqlconn,"SELECT Nama FROM cbt_user WHERE Username='$namaguru'");
$u=mysqli_fetch_array($sql1);
$namapembuat = $u['Nama'];

$sqladmin = mysqli_query($sqlconn,"SELECT * FROM cbt_admin");
$s = mysqli_fetch_array($sqladmin);
$logo = $s['XLogo'];
$namasekolah =$s['XSekolah'];
 $skul = $s['XTingkat'];
if ($skul=="SMA" || $skul=="MA"||$skul=="STM"){$rombel="Jurusan";}else{$rombel="Rombel";}
	
if(str_replace(" ","",$logo)==""){
$logo = "tut.jpg";} else { $foto = "$logo";}
?>
<div class="group">
        <div class="panel panel-default">
			<div class="panel-heading">
				<iframe src="<?php echo "print_banksoal.php?idsoal=$_REQUEST[idsoal]"?>" style="display:none;" name="frame"></iframe>
				<a href="?modul=daftar_soal">
					<button type="button" class="btn btn-default btn-small" style="margin-top:5px; margin-bottom:5px">
						<i class="fa fa-arrow-circle-left"></i> Kembali ke Daftar Bank Soal</i>
					</button>
				</a>
				<button type="button" class="btn btn-warning btn-small" onClick="frames['frame'].print()" style="margin-top:5px; margin-bottom:5px">
					<i class="glyphicon glyphicon-print"></i> Cetak Bank Soal
				</button>
				
            </div>
            
			<div class="panel-body">
				<table width="100%" border="0">
					<tr>
					<h3 class="panel-title" align="center">DATA BANK SOAL</h3>					
					</tr>
					<br/>
					<tr>
						<td rowspan="5" width="150">
							<img src="../../images/<?php echo $logo; ?>" width="78%" height="70" />                         </div></td>
						<td width=300>Mata Pelajaran | Kode Soal</td>
						<td >: &nbsp;<?php echo "$namamapel | $kodesoal"; ?></td>                
					</tr>
					<tr>
						<td>Kelas - <?php echo $rombel;?> </td>
						<td>: &nbsp;
						<?php echo "$kelas - $jurusan "; ?></td>
					</tr>
					<tr>
						<td>Pembuat Soal</td>
						<td>: &nbsp;<?php echo $namapembuat; ?></td>
					</tr>
					<tr>
						<td>Tanggal Pembuatan</td>
						<td>: &nbsp;<?php echo $tglbuat; ?></td>
					</tr>
					<tr>
						<td>Satuan Pendidikan</td>
						<td>: &nbsp;<?php echo $namasekolah; ?></td>
					</tr>
				</table>
		  </div>
        </div>  
</div>

<link href="../dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../lib/jquery.min.js"></script>
<script type="text/javascript" src="../dist/jplayer/jquery.jplayer.min.js"></script>

<div class="panel panel-default">
	<div class="panel-heading">
		<table>
			<tr>
				<td>
					<h3 class="panel-title">
						Soal Pilihan Ganda
					</h3>
					
				</td>
				<td>
				</td>
			</tr>
		</table>
	</div>
	<div class="panel-body">
		<table>
			<?php
			$nomer = 1;
			$sql = mysqli_query($sqlconn,"SELECT * FROM cbt_soal s 
					LEFT JOIN cbt_paketsoal p ON p.XKodeSoal = s. XKodeSoal  
					WHERE p.XKodeSoal = '$var_soal' order by XNomerSoal");				
			while($sp = mysqli_fetch_array($sql))
			{	
				$jumpil = $sp['XJumPilihan'];
				$js = $sp['XJenisSoal'];
				
				if(!$sp['XGambarTanya']=='')
				{
					$gambarsoalnye = "<br><br><img src='../../pictures/$sp[XGambarTanya]'  align=center><br>";
				}
				else
				{
					$gambarsoalnye = "";
				}
				if(!$sp['XAudioTanya']=='')
				{
					$audiosoalnye = "$sp[XAudioTanya]<br>";} else {$audiosoalnye = "";
				}
				if(!$sp['XVideoTanya']=='')
				{
					$videosoalnye = "$sp[XVideoTanya]<br>";
				} 
				else 
				{
					$videosoalnye = "";
				}
				
				if(str_replace(" ","",$sp['XGambarJawab1'])=='')
				{
					$ambilfile1 = "";
				}
				else
				{
					if(file_exists("../../pictures/$sp[XGambarJawab1]"))
					{
						$ambilfile1 = "<img src=../../pictures/$sp[XGambarJawab1] >";
					} 
					else
					{
						$ambilfile1 = "<img src=images/kross.png> $sp[XGambarJawab1] tidak belum diUpload";
					}
				}
				
				if(str_replace(" ","",$sp['XGambarJawab2'])=='')
				{
					$ambilfile2 = "";
				}
				else
				{
					if(file_exists("../../pictures/$sp[XGambarJawab2]"))
					{
						$ambilfile2 = "<img src=../../pictures/$sp[XGambarJawab2] >";
					} 
					else
					{
						$ambilfile2 = "<img src=images/kross.png> $sp[XGambarJawab2] tidak belum diUpload";
					}
				}
				if(str_replace(" ","",$sp['XGambarJawab3'])=='')
				{
					$ambilfile3 = "";
				}
				else
				{
					if(file_exists("../../pictures/$sp[XGambarJawab3]"))
					{
						$ambilfile3 = "<img src=../../pictures/$sp[XGambarJawab3] >";
					} 
					else
					{
						$ambilfile3 = "<img src=images/kross.png> $sp[XGambarJawab3] tidak belum diUpload";
					}
				}
				if(str_replace(" ","",$sp['XGambarJawab4'])=='')
				{
					$ambilfile4 = "";
				}
				else
				{
					if(file_exists("../../pictures/$sp[XGambarJawab4]"))
					{
						$ambilfile4 = "<img src=../../pictures/$sp[XGambarJawab4] >";
					} 
					else
					{
						$ambilfile4 = "<img src=images/kross.png> $sp[XGambarJawab4] tidak belum diUpload";
					}
				}
				
				if(str_replace(" ","",$sp['XGambarJawab5'])=='')
				{
					$ambilfile5 = "";
				}
				else
				{
					if(file_exists("../../pictures/$sp[XGambarJawab5]"))
					{
						$ambilfile5 = "<img src=../../pictures/$sp[XGambarJawab5] >";
					} 
					else
					{
						$ambilfile5 = "<img src=images/kross.png> $sp[XGambarJawab5] tidak belum diUpload";
					}
				}
				
				if($js=='2')
				{
					$katsoal = "Esai/Uraian";
									//echo "<p>Pertanyaan : $_REQUEST[jum] asdasd $xadm[Urut] $js</p>";		
					$soalnye = strip_tags($sp['XTanya']);							
					echo "<p>$soalnye</p>
						 <p>$gambarsoalnye</p>";
				}
				
				elseif($jumpil=='3')
				{ 						
					//$katsoal = "Pilihan Ganda (3 Pilihan Jawaban)";<p>Pertanyaan : $katsoal dengan Opsi Jawaban $_REQUEST[jum]</p>
						if($sp['XKunciJawaban']=='1'){$kunci1 = "<img src='images/benar.png' width=20px>";} else {$kunci1="";}
						if($sp['XKunciJawaban']=='2'){$kunci2 = "<img src='images/benar.png' width=20px>";} else {$kunci2="";}
						if($sp['XKunciJawaban']=='3'){$kunci3 = "<img src='images/benar.png' width=20px>";} else {$kunci3="";}
										

							$Jawab1 = str_replace("<p>","",$sp['XJawab1']);
							$Jawab1 = str_replace("</p>","",$Jawab1);		
							$Jawab1 = str_replace("<span class='fontstyle0'>","",$Jawab1);	
							$Jawab1 = str_replace("</span>","",$Jawab1);
							$Jawab1 = str_replace("<br /><br />","",$Jawab1);
									
							$Jawab2 = str_replace("<p>","",$sp['XJawab2']);
							$Jawab2 = str_replace("</p>","",$Jawab2);		
							$Jawab2 = str_replace("<span class='fontstyle0'>","",$Jawab2);	
							$Jawab2 = str_replace("</span>","",$Jawab2);
							$Jawab2 = str_replace("<br /><br />","",$Jawab2);
									
							$Jawab3 = str_replace("<p>","",$sp['XJawab3']);
							$Jawab3 = str_replace("</p>","",$Jawab3);		
							$Jawab3 = str_replace("<span class='fontstyle0'>","",$Jawab3);	
							$Jawab3 = str_replace("</span>","",$Jawab3);
							$Jawab3 = str_replace("<br /><br />","",$Jawab3);									


							$soalnye=$sp['XTanya'];											
							$soalnye = str_replace("<span class='fontstyle0'>","",$soalnye);	
							$soalnye = str_replace("</span>","",$soalnye);
							$soalnye = str_replace("`","'",$soalnye);
							$soalnye = str_replace("<p>&nbsp;</p>","",$soalnye);									
								echo "	
									<table width=100% border=0>
										<tr>
											<td width=30px valign=top><p>$nomer.</p></td>
											<td colspan=2 valign=top>$soalnye </td>
											<p>$gambarsoalnye</p>
										</tr>
										<tr>											
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>A.</td>
											<td colspan=2 valign=top>$ambilfile1 $Jawab1 $kunci1</td>
										</tr>
										<tr>
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>B.</td>
											<td colspan=2 valign=top>$ambilfile2 $Jawab2 $kunci2 </td>
										</tr>
										<tr>
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>C.</td>
											<td colspan=2 valign=top>$ambilfile3 $Jawab3 $kunci3</td>
										</tr>
										<br/>
										</table>";
				} 
				
				elseif($jumpil=='4')
				{ 						
					//$katsoal = "Pilihan Ganda (4 Pilihan Jawaban)";<p>Pertanyaan : $katsoal dengan Opsi Jawaban $_REQUEST[jum]</p>
						if($sp['XKunciJawaban']=='1'){$kunci1 = "<img src='images/benar.png' width=20px>";} else {$kunci1="";}
						if($sp['XKunciJawaban']=='2'){$kunci2 = "<img src='images/benar.png' width=20px>";} else {$kunci2="";}
						if($sp['XKunciJawaban']=='3'){$kunci3 = "<img src='images/benar.png' width=20px>";} else {$kunci3="";}
						if($sp['XKunciJawaban']=='4'){$kunci4 = "<img src='images/benar.png' width=20px>";} else {$kunci4="";}
									
										
							$Jawab1 = str_replace("<p>","",$sp['XJawab1']);
							$Jawab1 = str_replace("</p>","",$Jawab1);		
							$Jawab1 = str_replace("<span class='fontstyle0'>","",$Jawab1);	
							$Jawab1 = str_replace("</span>","",$Jawab1);
							$Jawab1 = str_replace("<br /><br />","",$Jawab1);
									
							$Jawab2 = str_replace("<p>","",$sp['XJawab2']);
							$Jawab2 = str_replace("</p>","",$Jawab2);		
							$Jawab2 = str_replace("<span class='fontstyle0'>","",$Jawab2);	
							$Jawab2 = str_replace("</span>","",$Jawab2);
							$Jawab2 = str_replace("<br /><br />","",$Jawab2);
									
							$Jawab3 = str_replace("<p>","",$sp['XJawab3']);
							$Jawab3 = str_replace("</p>","",$Jawab3);		
							$Jawab3 = str_replace("<span class='fontstyle0'>","",$Jawab3);	
							$Jawab3 = str_replace("</span>","",$Jawab3);
							$Jawab3 = str_replace("<br /><br />","",$Jawab3);									
									
							$Jawab4 = str_replace("<p>","",$sp['XJawab4']);
							$Jawab4 = str_replace("</p>","",$Jawab4);		
							$Jawab4 = str_replace("<span class='fontstyle0'>","",$Jawab4);	
							$Jawab4 = str_replace("</span>","",$Jawab4);
							$Jawab4 = str_replace("<br /><br />","",$Jawab4);

															
								$soalnye=$sp['XTanya'];											
								$soalnye = str_replace("<span class='fontstyle0'>","",$soalnye);	
								$soalnye = str_replace("</span>","",$soalnye);
								$soalnye = str_replace("`","'",$soalnye);
								$soalnye = str_replace("<p>&nbsp;</p>","",$soalnye);									
									echo "	
										<table width=100% border=0>
										<tr>
											<td width=30px valign=top><p>$nomer.</p></td>
											<td colspan=2 valign=top>$soalnye </td>
											<p>$gambarsoalnye</p>
										</tr>
										<tr>											
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>A.</td>
											<td colspan=2 valign=top>$ambilfile1 $Jawab1 $kunci1</td>
										</tr>
										<tr>
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>B.</td>
											<td colspan=2 valign=top>$ambilfile2 $Jawab2 $kunci2 </td>
										</tr>
										<tr>
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>C.</td>
											<td colspan=2 valign=top>$ambilfile3 $Jawab3 $kunci3</td>
										</tr>
										<tr>
											<td width=30px>&nbsp;</td>
											<td width=20px valign=top>D.</td>
											<td colspan=2 valign=top>$ambilfile4 $Jawab4 $kunci4 </td>			
										</tr><br/>
										</table>";
				} 
				elseif($jumpil=='5')
				{ 
					//$katsoal = "Pilihan Ganda (5 Pilihan Jawaban)";<p>Pertanyaan : $katsoal dengan Opsi Jawaban $_REQUEST[jum]</p>
						if($sp['XKunciJawaban']=='1'){$kunci1 = "<img src='images/benar.png' width=20px>";} else {$kunci1="";}
						if($sp['XKunciJawaban']=='2'){$kunci2 = "<img src='images/benar.png' width=20px>";} else {$kunci2="";}
						if($sp['XKunciJawaban']=='3'){$kunci3 = "<img src='images/benar.png' width=20px>";} else {$kunci3="";}
						if($sp['XKunciJawaban']=='4'){$kunci4 = "<img src='images/benar.png' width=20px>";} else {$kunci4="";}
						if($sp['XKunciJawaban']=='5'){$kunci5 = "<img src='images/benar.png' width=20px>";} else {$kunci5="";}
																	
									
							$Jawab1 = str_replace("<p>","",$sp['XJawab1']);
							$Jawab1 = str_replace("</p>","",$Jawab1);		
							$Jawab1 = str_replace("<span class='fontstyle0'>","",$Jawab1);	
							$Jawab1 = str_replace("</span>","",$Jawab1);
							$Jawab1 = str_replace("<br /><br />","",$Jawab1);
									
							$Jawab2 = str_replace("<p>","",$sp['XJawab2']);
							$Jawab2 = str_replace("</p>","",$Jawab2);		
							$Jawab2 = str_replace("<span class='fontstyle0'>","",$Jawab2);	
							$Jawab2 = str_replace("</span>","",$Jawab2);
							$Jawab2 = str_replace("<br /><br />","",$Jawab2);
									
							$Jawab3 = str_replace("<p>","",$sp['XJawab3']);
							$Jawab3 = str_replace("</p>","",$Jawab3);		
							$Jawab3 = str_replace("<span class='fontstyle0'>","",$Jawab3);	
							$Jawab3 = str_replace("</span>","",$Jawab3);
							$Jawab3 = str_replace("<br /><br />","",$Jawab3);									
									
							$Jawab4 = str_replace("<p>","",$sp['XJawab4']);
							$Jawab4 = str_replace("</p>","",$Jawab4);		
							$Jawab4 = str_replace("<span class='fontstyle0'>","",$Jawab4);	
							$Jawab4 = str_replace("</span>","",$Jawab4);
							$Jawab4 = str_replace("<br /><br />","",$Jawab4);
									
							$Jawab5 = str_replace("<p>","",$sp['XJawab5']);
							$Jawab5 = str_replace("</p>","",$Jawab5);		
							$Jawab5 = str_replace("<span class='fontstyle0'>","",$Jawab5);	
							$Jawab5 = str_replace("</span>","",$Jawab5);
							$Jawab5 = str_replace("<br /><br />","",$Jawab5);
									
								$soalnye=$sp['XTanya'];
								$soalnye = str_replace("<p>","",$soalnye);
								$soalnye = str_replace("</p>","",$soalnye);		
								$soalnye = str_replace("<span class='fontstyle0'>","",$soalnye);	
								$soalnye = str_replace("</span>","",$soalnye);
								$soalnye = str_replace("`","'",$soalnye);
								$soalnye = str_replace("<p>&nbsp;</p>","",$soalnye);	
									echo "	
										<table width=100% border=0>
										<tr>
											<td width=30px valign=top><p>$nomer.</p></td>
											<td colspan=2 valign=top>$soalnye</td>
											<p>$gambarsoalnye</p>
										</tr>
										<tr>											
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>A.</td>
											<td colspan=2 valign=top>$ambilfile1 $Jawab1 $kunci1 </td>
										</tr>
										<tr>
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>B.</td>
											<td colspan=2 valign=top>$ambilfile2 $Jawab2 $kunci2 </td>
										</tr>
										<tr>
											<td width=30px valign=top>&nbsp;</td>
											<td width=20px valign=top>C.</td>
											<td colspan=2 valign=top>$ambilfile3 $Jawab3 $kunci3 </td>
										</tr>
										<tr>
											<td width=30px>&nbsp;</td>
											<td width=20px valign=top>D.</td>
											<td colspan=2 valign=top>$ambilfile4 $Jawab4 $kunci4 </td>	
										<tr>
											<td width=30px>&nbsp;</td>
											<td width=20px valign=top>E.</td>
											<td colspan=2 valign=top>$ambilfile5 $Jawab5 $kunci5 </td>											
										</tr><br/>";
				} 
				
				$nomer++;
			}			

			?>
		</table>                              
	</div>
</div>
</div>
</div>
</body>
</html>	
				
