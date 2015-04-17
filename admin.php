<?php

/*
**************************************************************************************************************************
** CORAL Authentication Module v. 1.0
**
** Copyright (c) 2011 University of Notre Dame
**
** This file is part of CORAL.
**
** CORAL is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
**
** CORAL is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License along with CORAL.  If not, see <http://www.gnu.org/licenses/>.
**
**************************************************************************************************************************
*/


session_start();

include_once 'directory.php';

if (isset($_SESSION['loginID'])){
	$loginID=$_SESSION['loginID'];
}

$user = new User(new NamedArguments(array('primaryKey' => $loginID)));


if (($user->isAdmin) && ($user->getOpenSession())){

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CORAL Authentication</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
<link rel="SHORTCUT ICON" href="images/clownfishfavicon.ico" />
<script type="text/javascript" src="js/plugins/jquery.js"></script>
<script type="text/javascript" src="js/plugins/thickbox.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<noscript><font face=arial><?= _("JavaScript must be enabled in order for you to use CORAL. However, it seems JavaScript is either disabled or not supported by your browser. To use CORAL, enable JavaScript by changing your browser options, then")." <a href=''>"._("try again")."</a>."?></font></noscript>

<center>
<form name="reportlist" method="post" action="report.php">

	<br />


	<div style="width:451px; height:91px;background-image:url('images/authtitle.gif');background-repeat:no-repeat;text-align:right;">
	</div>

	<div class='bordered' style='width:447px;margin-left:2px;'>

		<br />
		<div class='headerText' style='text-align: left;margin:0px 60px 3px 60px;'><?= _("Users")?></div>
		<div class='smallDarkRedText' style='margin-bottom:5px;'>* <?= _("Login ID must match the login ID set up in the modules")?></div>


		<div style='text-align:left;margin:0px 60px 60px 60px;' id='div_users'>
		<br />
		<br />
		<img src='images/circle.gif'>  <span style='font-size:90%'><?= _("Processing...")?></span>
		</div>
	</div>
    <div class='boxRight'>
		<p class="fontText"><?= _("Change language:");?></p>
		<select name="lang" id="lang" class="dropDownLang">
			<?php
			$fr="<option value='fr' selected='selected'>"._("French")."</option><option value='en'>"._("English")."</option>";
			$en="<option value='fr'>"._("French")."</option><option value='en' selected='selected'>"._("English")."</option>";
			if(isset($_COOKIE["lang"])){
				if($_COOKIE["lang"]=='fr'){
					echo $fr;
				}else{
					echo $en;
				}
			}else{
				$defLang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
				if($defLang=='fr'){
					echo $fr;
				}else{
					echo $en;
				}
			}
			?>
		</select>
	</div>
	<div class='smallerText' style='text-align:center; margin-top:13px;'><a href='index.php'><?= _("Login page")?></a></div>


</form>


<br />
<br />


</center>
<br />
<br />
<script>
    /*
     * Functions to change the language with the dropdown
     */
    $("#lang").change(function() {
        setLanguage($("#lang").val());
        location.reload();
    });
    // Create a cookie with the code of language
    function setLanguage(lang) {
        var wl = window.location, now = new Date(), time = now.getTime();
        var cookievalid=86400000; // 1 day (1000*60*60*24)
        time += cookievalid;
        now.setTime(time);
        document.cookie ='lang='+lang+';path=/'+';domain='+wl.host+';expires='+now;
    }
</script>
<script type="text/javascript" src="js/admin.js"></script>

</body>
</html>


<?php

}else{

	if ($user->getOpenSession()){
		header('Location: index.php?service=admin.php&invalid');
	}else{
		header('Location: index.php?service=admin.php&admin');
	}
}

?>