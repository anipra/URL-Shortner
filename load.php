<html>
<head>
	<?php
		$site="localhost";
		$code = $_GET['code'];
		$conn = oci_pconnect('system', '31y$Ium#', 'localhost/XE') OR die 
			('Unable to connect to the database. Error: <!pre>' . print_r(oci_error(),1) . '<!/pre><!/body><!/html>');
		
		$q="SELECT * FROM links WHERE short_url='$site/$code'";
		$s = oci_parse($conn, $q);
		oci_execute ($s);

		$row=oci_fetch_array($s);
		$url=$row[1];
	
		$q="select LINK_ID from LINKS where LONG_URL='$url'";
		$s = oci_parse($conn, $q);
		oci_execute ($s);
		$row=oci_fetch_array($s);
		$lid=$row[0];
		
		$q="select HITS from DETAILS where LINK_ID=$lid";
		$s = oci_parse($conn, $q);
		oci_execute ($s);
		$row=oci_fetch_array($s);
		$x=$row[0];
		++$x;
		
		$q = 'BEGIN update_hits(:hits, :linkid); END;';
		$s = oci_parse($conn, $q);
		oci_bind_by_name($s, ':linkid', $lid, 32);
		oci_bind_by_name($s, ':hits', $x, 32);
		
		
		/*$q="update DETAILS set HITS=$x where LINK_ID=$lid";
		$s = oci_parse($conn, $q);*/
		oci_execute ($s);

		
		oci_free_statement($s);
		oci_close($conn);
		
		//header("Location: $url");
		echo "<script type='text/javascript'>window.location ='$url'</script>";
		
	?>
</head>
</html>
