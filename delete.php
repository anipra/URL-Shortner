<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/vnd.microsoft.icon"/>
<title>URL Shortener</title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/script.js"></script>'
<style type="text/css">
	@font-face {font-family: Eurocorp; src: url('Eurocorp.ttf'); } 
	/* WRAPPER */
		#wrapper { width:1400px; margin:40px auto; }
	/* main contents with RGBA background (same colour as active tab) and three rounded corners */
		#main { clear:both; background: rgba(255,138,30,0.8); width:1100px; margin-left:150px;
		-moz-border-radius-topright: 12px; -moz-border-radius-bottomright: 12px; -moz-border-radius-bottomleft: 12px;
		-webkit-border-top-right-radius:12px; -webkit-border-bottom-right-radius:12px; -webkit-border-bottom-left-radius:12px;}
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
				<li><a href="#" title="Home">Home</a></li>
				<li><a href="#" title="User">Account</a></li>
				<li><a href="#" title="Links" class="active">Links</a></li>
				<li><a href="#" title="About">About</a></li>
			</ul>
		</div>
		<div id="main">
		<h3>My Links</h3>
		<hr class="sty2"/>

		<?php
			
			session_start();
	
			if(isset($_SESSION['login_user']))
			{
				$site="localhost";
				$usr=$_SESSION['login_user'];
				$conn = oci_pconnect('system', '31y$Ium#', 'localhost/XE') OR die 
					('Unable to connect to the database. Error: <!pre>' . print_r(oci_error(),1) . '<!/pre><!/body><!/html>');
					
				if(isset($_POST['delrow']))
				{
					$d=$_POST['delrow'];
					$q="DELETE FROM links where SHORT_URL='$site/$d'";
					$s = oci_parse($conn, $q);
					oci_execute ($s);
				}
		
				$q="select USER_ID from USERS where USERNAME='$usr'";
				$s = oci_parse($conn, $q);
				oci_execute ($s);
				$row=oci_fetch_array($s);
				$uid=$row[0];
		
				$q="select LINK_ID from MYURL where USER_ID=$uid";
				$s = oci_parse($conn, $q);
				oci_execute ($s);
				$row=oci_fetch_array($s);
		
				$q="select LINK_ID from MYURL where USER_ID=$uid";
				$s = oci_parse($conn, $q);
				oci_execute ($s);
		
				if($row[0]!=null)
				{
					echo "<form action='../delete.php' method='POST'>";
					echo "<table class='myT'>\n";
					echo "<tr><th><p style='font-size:150%'>Original URL</p></th><th><p style='font-size:150%'>Short URL</p></th><th><p style='font-size:150%'>Category</p></th><th><p style='font-size:150%'>Hits</p></th><th><p style='font-size:150%'>Delete Links</p></th></tr>";
			
					while(($row=oci_fetch_array($s))!=false)
					{
						$q1="select LONG_URL,SHORT_URL from LINKS where LINK_ID=$row[0]";
						$s1 = oci_parse($conn, $q1);
						oci_execute ($s1);
						$row1=oci_fetch_array($s1);
				
						$q2="select DETAIL_ID,HITS from DETAILS where LINK_ID=$row[0]";
						$s2=oci_parse($conn,$q2);
						oci_execute($s2);
						$row2=oci_fetch_array($s2);
						$hits=$row2[1];
				
						$q3="select TYPE from CATEGORY where DETAIL_ID=$row2[0]";
						$s3=oci_parse($conn,$q3);
						oci_execute($s3);
						$row3=oci_fetch_array($s3);
						$cat=$row3[0];
			
						if(strcmp ( substr($row1[1],0,10) , "localhost/" )==0)
						{
							$row1[1]=substr($row1[1], 10);
						}
		
						echo "<tr>\n";
						echo "<td><p><a href=$row1[0] target='_blank'><font color='white'>$row1[0]</font></a></p></td><td><p><a href=$row1[1] target='_blank'><font color='white'>$site/$row1[1]</font></a></p></td><td><p>$cat</p></td><td><p>$hits</p></td><td><p><input type='submit' style='width:100%' name='del' value='Delete'/></p></td><td><p><input type='hidden' style='width:100%' name='delrow' value='$row1[1]'/></p></td>";
						echo "</tr>";
			
					}

					echo "</table>\n";
					echo "</form>";

					oci_free_statement($s1);
					oci_free_statement($s2);
					oci_free_statement($s3);
				}
		
				else
				{
					echo "<p>No URLs shortened!</p>";
				}
				
				oci_free_statement($s);
				oci_close($conn);
			}
	
			else
			{
				echo "<p>Not logged in!</p>";
			}
		?>
		
		</div>
	</div>
</div>
</body>
</html>
