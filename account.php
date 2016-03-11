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
				<li><a href="#" title="Home">Home</a></li>
				<li><a href="#" title="Account" class="active">Account</a></li>
				<li><a href="#" title="Links">Links</a></li>
				<li><a href="#" title="About">About</a></li>
			</ul>
		</div>
		<div id="main">
			<h3>Login / Register</h3>
			<?php
				session_start();
				
				if(isset($_POST['uname']) && isset($_POST['pword']))
				{		
					$usr = $_POST['uname'];
					$pwd = $_POST['pword'];
		
					if($usr && $pwd)
					{
						$conn = oci_pconnect('system', '31y$Ium#', 'localhost/XE') OR die 
							('Unable to connect to the database. Error: <!pre>' . print_r(oci_error(),1) . '<!/pre><!/body><!/html>');						
					
						$q="SELECT * FROM users";
						$s=oci_parse($conn,$q);
						oci_execute($s);
						
						$exists=false;
						
						while (oci_fetch($s)) {
							if((oci_result($s, 'USERNAME'))==$usr)
							{
								if(oci_result($s, 'PASSWORD')==$pwd)
								{
									$_SESSION['login_user']=$usr;
									
									echo "<p>Login successful!</p>";
								}
								
								else
								{
									echo "<p>Invalid password / Username already exists !</p>";
								}
								
								$exists=true;
							}
						}
						
						if(!$exists)
						{
							$_SESSION['login_user']=$usr;
							
							$sql = 'BEGIN insert_user(:name,:passwd); END;';
							$s = oci_parse($conn,$sql);

							//  Bind the input parameter
							oci_bind_by_name($s,':name',$usr,32);

							// Bind the output parameter
							oci_bind_by_name($s,':passwd',$pwd,32);

							// Assign a value to the input 
							//$name = 'Harry';

							oci_execute($s);
							
							/*$q="INSERT INTO users values (user_id_seq.nextval,'$usr','$pwd')";
							$s=oci_parse($conn,$q);
							oci_execute($s);*/
							echo "<p>User $usr registered succesfully!</p>";
						}
						
						oci_free_statement($s);
						oci_close($conn);
					}
				}
				
				if(isset($_POST['logout']))
				{
					echo "<p>Logged out!</p>";
					session_destroy();
				}
			?>
		</div>
	</div>
</div>
</body>
</html>
