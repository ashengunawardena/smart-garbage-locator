<?php
	session_start();
	if(isset($_GET["signout"])){
		date_default_timezone_set("Asia/Colombo");
		$conn = new mysqli("localhost","root","","SGL");

		if(isset($_SESSION["username"]))
			$query = "UPDATE members SET lastLogout='" . date('Y-m-d H:i:s') . "' WHERE Username='" . $_SESSION["username"] . "';";
		else
			$query = "UPDATE members SET lastLogout='" . date('Y-m-d H:i:s') . "' WHERE GoogleID='" . $_SESSION["googleID"] . "';";

        $conn->query($query);

        session_destroy();
		header("Location: index.php");
	}
?>

<html>

<head>
	<title>SGL - Home</title>
	<link rel="stylesheet" type="text/css" href="home.css">
	<link rel="stylesheet" type="text/css" href="resources/css/fonts.css">
	<link rel="icon" type="image/jpg" href="resources/images/sgl_favicon.jpg">
</head>

<body onload="setQuote()">
	<noscript>
    	<style>
    		div#container,.halfcircle,#about{
    			display: none;
    		}
    		#error-box{
    			width: 40vw;
    			height: 35vh;
    			background: #32CD32;
    			border-radius: 2vw;
    			margin: auto;
    			margin-top: 30vh;
    			text-align: center;
    			padding-top: 0.25vh;
    		}
    		h2,h4{
    			font-family: Arial;
    			color: black;
    		}
  			h4{
  				font-size: 1rem;
  			}
    	</style>
    	<div id="error-box">
    		<h2>Error Occured: Javascript Disabled</h2>
    		<h4 style="margin-top: 12vh;">To continue to the SGL website please follow the below instruction and turn<br>on Javascript on your browser</h4>
    		<h4 style="text-align: left; margin-left: 1vw; margin-top: -6vh;">1. Click the "i" mark to the left on the page url box<br>2. Click "Site settings" on the drop box which appears<br>3. Click "allow" on the Javascript setting which appears<br>4. If the setting is not visible search for "Javascript" on the search bar and &nbsp;&nbsp;&nbsp;&nbsp;allow Javascript to run on your browser<br>5. Please reload the browser
    		</h4>
    	</div>
	</noscript>
	<div id="container">
		<img src="resources/images/recycle.png" alt="recycle-image">
		<div id="left-triangle"></div>
		<div id="navbar">
			<a href="#">HOME</a>
			<a href="p/garbage-locations">GARBAGE LOCATIONS</a>
			<a href="p/articles">ARTICLES</a>

			<?php
				if(isset($_SESSION["userType"])){
					if($_SESSION["userType"] == 'admin'){
						echo "<a href='user accounts.php'>USER ACCOUNTS</a>";
						echo "<a href='reports.php'>REPORTS</a>";
					}
					else if($_SESSION["userType"] == 'manager'){
						echo "<a href='incidents.php'>REPORTED INCIDENTS</a>";
					}
					else if($_SESSION["userType"] == 'staff'){
						echo "<a href='approved reports.php'>APPROVED REPORTS</a>";
					}
					else if($_SESSION["userType"] == 'volunteer'){
						echo "<a href='p/reports'>REPORTS</a>";
					}
				}
			?>
			
			<a href='https://plus.google.com/u/0/102452053552533725657'><img src='resources/images/gplus_logo.jpg' alt='gplus-logo' class='nav-img'></a>
			<a href='https://twitter.com/LocatorSmart'><img src='resources/images/twitter_logo.png' alt='twitter-logo' class='nav-img'></a>
			<a href='https://www.facebook.com/Smart-Garbage-Locator-2278764132158177'><img src='resources/images/facebook_logo.png' alt='facebook-logo' class='nav-img'></a>
			<a href='https://www.instagram.com/smartgarbagelocator/'><img src='resources/images/instagram_logo.png' alt='instagram-logo' class='nav-img'></a>

			<?php
				if(isset($_SESSION["imageLocation"])){
					echo "
						<a title='Log out' href='index.php?signout=yes'><img src='" . $_SESSION["imageLocation"] . "' alt='profile-pic' id='profile-pic' style='position: relative; left: 11vw; top: -1.1vh;''></a>
						<script>
							var x = document.getElementsByClassName('nav-img');
							var i;
							for(i=0; i<4; i++){
								x[i].style.left = '-8.5vw';
							}
						</script>
					";
				}
				else{
					echo "
						<a href='p/sign-in'><p>SIGN IN</p></a>
					";
				}
			?>

		</div>
		<div id="content">
			<h1>SGL</h1>
			<h2>SMART GARBAGE LOCATOR</h2>
			<h3>Towards a Greener and Cleaner Colombo</h3>
			<p id="quotes"></p>
			<p style="margin-top: -1.5vh;">--Green Quotes--</p>
		</div>
	</div>

	<div class="halfcircle">
		<div class="halfcircle-Top"></div>
		<div class="halfcircle-Bottom"></div>
		<p onclick="displayAbout(0)">M</p>
		<h4>Mission</h4>
	</span>
	</div>
	<div class="halfcircle">
		<div class="halfcircle-Top"></div>
		<div class="halfcircle-Bottom"></div>
		<p onclick="displayAbout(1)">A</p>
		<h4>About</h4>
	</div>
	<div class="halfcircle">
		<div class="halfcircle-Top"></div>
		<div class="halfcircle-Bottom"></div>
		<p onclick="displayAbout(2)">V</p>
		<h4>Vission</h4>
	</div>

	<div id="about">
		<h1 id="abt-head">About</h1>
		<p id="abt-cont"></p>
		<h2 onclick="closeAbout()">Close</h2>
	</div>

	<script>
		var quoteTimer = setInterval(setQuote, 4000);

		var greenQuotes = ["If you can't clean your sorrounding, then don't make it dirty", "I only feel angry when I see waste. When I see people throwing away things we could use", "Time spent among trees is never time wasted"];

		var i = 0;
		function setQuote(){
			document.getElementById("quotes").innerHTML = greenQuotes[i];
			i++;

			if(i>2)
				i=0;
		}

		var about_header = ["Mision", "About", "Vission"];
		var about_content = ["mission", "Founded in 2018, we are a non-profit digital technology based group with the aim of creating a digital network which helps efficient finding of improperly disposed garbage locations by respective garbage disposal organizations which will aid create a Green and Clean SriLanka.<br><br> Garbage disposal organizations will be provided with accurate and real-time information on improperly disposed garbage locations through an efficient and effective process, which also involves the general public of Sri Lanka.", "mission"];
		
		function displayAbout(num){
			document.getElementById("about").style.display = "block";
			document.getElementById("abt-head").innerHTML = about_header[num];
			document.getElementById("abt-cont").innerHTML = about_content[num];
		}

		function closeAbout(){
			document.getElementById("about").style.display = "none";
		}
	</script>
</body>

</html>