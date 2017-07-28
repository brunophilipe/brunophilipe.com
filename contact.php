<?php
$banned_ips = array("195.2.240.106");
$denied = in_array($_SERVER['REMOTE_ADDR'], $banned_ips);
if ($denied)
{
	header(':', true, 403);

	echo "<title>403: Denied</title>";
	echo "This IP was banned for spam.";
	die;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bruno Philipe</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">

	<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="/assets/css/brunophilipe.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
	<div class="container">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-sm-12 content">
			<header>
				<h1>Bruno Philipe</h1>
				<p>Programmer and Web Developer.<br>Currently focused on iOS and OS X development.</p>
			</header>
			<ul class="menu">
				<li><a href="/">Home</a></li><li><a href="/about">About</a></li><li><a href="/contact">Contact</a></li><li><a href="http://blog.brunophilipe.com/">Blog</a></li>
			</ul>
			<div class="social">
				<a id="fb" class="tooltips" target="_blank" title="Facebook" href="https://facebook.com/brunophilipe"><span>Facebook</span></a>
				<a id="tw" class="tooltips" target="_blank" title="Twitter" href="https://twitter.com/brunophilipe"><span>Twitter</span></a>
				<a id="lf" class="tooltips" target="_blank" title="Last.fm" href="https://www.last.fm/user/brunoresende29"><span>Last.fm</span></a>
				<a id="li" class="tooltips" target="_blank" title="LinkedIn" href="https://www.linkedin.com/pub/bruno-philipe-resende-silva/33/416/ba7"><span>LinkedIn</span></a>
				<a id="gh" class="tooltips" target="_blank" title="GitHub" href="https://www.github.com/brunophilipe"><span>GitHub</span></a>
				<a id="bb" class="tooltips" target="_blank" title="BitBucket" href="https://bitbucket.org/brunophilipe"><span>BitBucket</span></a>
			</div>
			<hr>
<?php

if (isset($_GET['send']) && $_GET['send'] == 1) {
	$crdate = date("r");

	$status = (($_POST['name'] != "") && ($_POST['email'] != "") && ($_POST['message'] != ""));

	if ($status) {
		$email_s_name		= $_POST['name'];
		$email_s_email		= $_POST['email'];
		$email_s_message	= $_POST['message'];
		$email_s_ip			= $_SERVER['REMOTE_ADDR'];

		$email_to			= "Bruno Philipe <brunoph@me.com>";
		$email_subject		= "Message sent from contact form in your homepage.";
		$email_from			= "From: MailMe Contact Form <mailme@brunophilipe.com>\r\nContent-Type: text/html\r\nReply-To: $email_s_name <$email_s_email>\r\n";
		$email_message		=

		"<!DOCTYPE html><html><head><title>$email_subject</title>
		<style type='text/css'>
		div#message {font-family: \"Lucida Console\", Monaco, monospace;}
		body {font-family: \"Trebuchet MS\", Helvetica, sans-serif;}
		p#textarea {white-space: pre-line;}
		p#footer {font-size:9;}
		</style></head><body>
		<p>An user has contacted you trough the contact form in your Homepage.</p>
		<p>This message was created at $crdate.</p>
		<p>User information:</p>
		<ul>
			<li>Name: $email_s_name</li>
			<li>Email: $email_s_email</li>
			<li>IP: $email_s_ip</li>
		</ul>
		<div id='message'>
		<p>
		-------------------<br />
		User message begins<br />
		-------------------<br />
		</p>
		<p id='textarea'>
		$email_s_message
		</p>
		<p>
		-----------------<br />
		User message ends<br />
		-----------------<br />
		</p>
		</div>
		Best Regards.<br />
		<p id='footer'>MailMe Contact Form by Bruno Philipe</p>
		</body>
		</html>
		";

		$status = mail($email_to,$email_subject,$email_message,$email_from);
	}

	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";
	echo "<link rel=\"stylesheet\" href=\"contact.css\" type=\"text/css\" media=\"all\" />\n";

	if ($status) {
		echo "<div id=\"normalpage\">\n";
		echo "	<div class=\"block\">\n";
		echo "		<h4>Contact the Developer</h4>\n";
		echo "		<div class=\"detail about\" style=\"width:100%\">\n";
		echo "			<h5>Message Sent. Thank you!</h5>\n";
		echo "			<div>\n";
		echo "				<p>I can't promise I will reply to your message, but I promise I will read it. If you are waiting for any kind of answer, please be patient.</p>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
	} else {
		echo "<div id=\"normalpage\">\n";
		echo "	<div class=\"block\">\n";
		echo "		<h4>Contact the Developer</h4>\n";
		echo "		<div class=\"detail about\" style=\"width:100%\">\n";
		echo "			<h5>There was an error.</h5>\n";
		echo "			<div>\n";
		echo "				<p>There was an error sending the email. Please be sure you filled ALL the form fields. To try again click the Back button in your browser.</p>\n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "	</div>\n";
		echo "</div>\n";
	}
}

?>
			<hr>
			<footer>
				<p>&copy; Copyright Bruno Philipe 2014 &mdash; All Rights Reserved</p>
			</footer>
		</div>
	</div>
	<script type="text/javascript" src="/assets/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-30675692-1', 'brunophilipe.com');
	ga('send', 'pageview');

	</script>
</body>
</html>
