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
			<hr class="sty2"/>
			<form action="add.php" method="post">
				<p><input id="oldurl" type="text" name="oldurl" align="middle" class="surl" value='Insert URL & Hit Enter!' onClick="if(!this._haschanged){this.value='';};this._haschanged=true;"></p>
				<p>Category: <label><select id="cat" name="cat">
					<option selected>(Undefined)</option>
					<option>Blog</option>
					<option>Crowdfunding</option>
					<option>Community forum</option>
					<option>Corporate site</option>
					<option>Dating site</option>
					<option>E-commerce</option>
					<option>Gaming site</option>
					<option>Government site</option>
					<option>Humor site</option>
					<option>Information/Wiki</option>
					<option>News site</option>
					<option>Porn site</option>
					<option>School site</option>
					<option>Social network</option>
					<option>Banking site</option>
				</select></label></p>
			</form>
				
		</div>
	</div>
</div>
</body>
</html>
