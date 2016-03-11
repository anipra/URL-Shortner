<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/vnd.microsoft.icon"/>
<title>URL Shortener</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/script.js"></script>
<style type="text/css">
  @font-face {font-family: Eurocorp; src: url('Eurocorp.ttf'); } 
</style>
</head>
<body>
<div id="wrapper">
	<h1 style="font-family:Eurocorp;">URL SHORTENER<small>The easiest way to tweet!</small></h1>
	&nbsp;&nbsp;
	<hr class="sty1" width="80%"/>
	&nbsp;&nbsp;
	<div id="content">
		<div id="menu">
			<ul>
				<li><a href="#" title="Home" class="active">Home</a></li>
				<li><a href="#" title="User">Account</a></li>
				<li><a href="#" title="Links">Links</a></li>
				<li><a href="#" title="About">About</a></li>
			</ul>
		</div>
		<div id="main">
			<h3>Home</h3>
				<p>
					<?php
						session_start();
					
						if(isset($_POST['oldurl']) && isset($_POST['cat']))
						{
							$url = $_POST['oldurl'];
							$cat = $_POST['cat'];
		
							if($url)
							{
								$conn = oci_pconnect('system', '31y$Ium#', 'localhost/XE') OR die 
									('Unable to connect to the database. Error: <!pre>' . print_r(oci_error(),1) . '<!/pre><!/body><!/html>');
								$site="localhost";
								$charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
								$len =5;
								$strl=strlen($charset);
								$numrows =1;
								$code=0;
								
								while($numrows !=0 )
								{
									if($numrows==0)
									{
										break;
									}
									
									for($i=0;$i<=$len;$i++)
									{
										$rand = rand() % $strl;
										$temp = substr($charset, $rand, 1);
										$code .= $temp;
									}
			
									$q="SELECT * FROM links WHERE short_url='$site/$code'";
									$s = oci_parse($conn, $q);
									oci_execute ($s);
									$numrows = oci_num_rows($s);
								}
								
								$q="INSERT INTO links VALUES (link_id_seq.nextval,'$url','$site/$code')";
								$s = oci_parse($conn, $q);
								oci_execute ($s);

								echo "<p>Your NEW shortened URL: </p>";
								echo "<form><p><input type='text' name='targetme' id='targetme' class='tb2' size='40' value='$site/$code' onclick='javascript:this.form.targetme.focus();this.form.targetme.select();'></p></form>";
								
								$q="select link_id from links where SHORT_URL = '$site/$code'";
								$s=oci_parse($conn,$q);
								oci_execute($s);
								$row = oci_fetch_array($s);
								$lid=$row[0];
								
								
								$q = 'BEGIN insert_details(:long); END;';
								$s = oci_parse($conn, $q);
								oci_bind_by_name($s, ':long', $lid, 32);
								
								/*$q="insert into details(detail_id, link_id, hits) values (detail_id_seq.nextval, $lid, 0)";
								$s=oci_parse($conn,$q);*/
								oci_execute($s);
								
								$q="select max(detail_id) from DETAILS";
								$s=oci_parse($conn,$q);
								oci_execute($s);
								$row = oci_fetch_array($s);
								$did=$row[0];
								
								/*$q = 'BEGIN insert_details(:long); END;';
								$s = oci_parse($conn, $q);
								oci_bind_by_name($s, ':long', $lid, 32);*/
								
								$q = 'BEGIN insert_category(:detailid, :category); END;';
								$s = oci_parse($conn, $q);
								oci_bind_by_name($s,':detailid', $did, 32);
								oci_bind_by_name($s, ':category', $cat, 32);
								
								/*$q="insert into CATEGORY(CATEGORY_ID, DETAIL_ID, TYPE) values (category_id_seq.nextval, $did, '$cat')";
								$s=oci_parse($conn,$q);*/
								oci_execute($s);
								
								if(isset($_SESSION['login_user']))
								{
									$usr=$_SESSION['login_user'];
									$q="select USER_ID from users where username='$usr'";
									$s=oci_parse($conn,$q);
									oci_execute($s);
									$row=oci_fetch_array($s);
									$uid=$row[0];
									
									$q = 'BEGIN insert_myurl(:linkid, :userid); END;';
									$s = oci_parse($conn, $q);
									oci_bind_by_name($s,':linkid', $lid, 32);
									oci_bind_by_name($s, ':userid', $uid, 32);
									
									/*$q="insert into MYURL (URL_ID,LINK_ID,USER_ID) values (url_id_seq.nextval,$lid,$uid)";
									$s=oci_parse($conn,$q);*/
									oci_execute($s);
								}
								
								oci_free_statement($s);
								oci_close($conn);
							}
						}
						
					?>
				</p>
		</div>
	</div>
</div>
</body>
</html>
