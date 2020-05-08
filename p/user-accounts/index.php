<?php
	session_start();

	if(!isset($_SESSION["userType"]))
    	header("Location: sign in.php");
	if(isset($_SESSION["userType"])){
		if(!($_SESSION["userType"] == "admin"))
			header("Location: sign in.php");
	}

	$conn = new mysqli("localhost","root","","SGL");

	if ($conn->connect_error) {
   		die("Connection failed: " . $conn->connect_error);
	}

	$query = "SELECT Username, Fname, Lname, dateJoined, lastLogin, lastLogout, noReports, isStaff, isManager FROM members WHERE isAdmin IS NULL;";
	$result = $conn->query($query);
?>

<html>

<head>
	<title>SGL - User Accounts</title>
	<link rel="stylesheet" type="text/css" href="user_accounts.css">
	<link rel="stylesheet" type="text/css" href="../../resources/css/fonts.css">
	<link rel="icon" type="image/png" href="../../resources/images/sgl_favicon.jpg">
</head>

<body>
	<noscript>
    	<style>
    		div#container{
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
    		}
  			
    	</style>
    	<div id="error-box">
    		<h2>Error Occured: Javascript Disabled</h1>
    		<h4>To continue to the SGL website please follow the below instruction and turn<br>on Javascript on your browser</h4>
    		<h4 style="text-align: left; margin-left: 1vw;">1. Click the "i" mark to the left on the page url box<br>2. Click "Site settings" on the drop box which appears<br>3. Click "allow" on the Javascript setting which appears<br>4. If the setting is not visible search for "Javascript" on the search bar and &nbsp;&nbsp;&nbsp;&nbsp;allow Javascript to run on your browser<br>5. Please reload the browser
    	</div>
	</noscript>
	<div id="navbar">
		<a href="index.php">HOME</a>
		<a href="garbage locations.php ">GARBAGE LOCATIONS</a>
		<a href="articles.php">ARTICLES</a>
		<a href='#'>USER ACCOUNTS</a>
		<a href='reports.php'>REPORTS</a>

		<a href='https://plus.google.com/u/0/102452053552533725657'><img src='../../resources/images/gplus_logo.jpg' alt='gplus-logo' class='nav-img'></a>
		<a href='https://twitter.com/LocatorSmart'><img src='../../resources/images/twitter_logo.png' alt='twitter-logo' class='nav-img'></a>
		<a href='https://www.facebook.com/Smart-Garbage-Locator-2278764132158177'><img src='../../resources/images/facebook_logo.png' alt='facebook-logo' class='nav-img'></a>
		<a href='https://www.instagram.com/smartgarbagelocator/'><img src='../../resources/images/instagram_logo.png' alt='instagram-logo' class='nav-img'></a>
	
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
		?>
	</div>

	<div id="container">
		<?php
			$a = 0;
			while($row = $result->fetch_assoc()) {
				echo "
					<div class='userBox'>
						<h1 style='margin-top: 2.75vh; position: relative; left: -1vw; width: 28vw;'>" . $row["Fname"] . " " . $row["Lname"] . "</h1>
						<div class='content'>
							<h2>" . $row["dateJoined"] . "</h2>
							<h2 style='position: relative; left: 0vw;'>" . $row["lastLogin"] . "</h2>
							<h3 style='position: relative; left: -17vw;'>Joined Date</h3>
							<h3 style='position: relative; left: -17vw;'>Last Login</h3>
							<h2 style='position: relative; left: -8.65vw; top: -0.05vh;'>" . $row["lastLogout"] . "</h2>
							<h2 style='position: relative; left: -25.5vw; top: 0vh;'>" . $row["noReports"] . "</h2>
							<h3 style='position: relative; left: -0.15vw; top: -4.75vh;'>No.of Reports</h3>
							<h3 style='position: relative; left: 0vw; top: -4.7vh;'>Last Logout</h3>

							<label class='switch' style='left: -14vw; top: 0.75vh;'>
				";
  				
  				if($row["isStaff"] == 1)
  					echo "	
  								<input type='checkbox' class='switchInput' onclick='changeType(1,$a,\"" . $row["Username"] . "\")' checked>
  					";
  				else
  					echo "	
  								<input type='checkbox' class='switchInput' onclick='changeType(1,$a,\"" . $row["Username"] . "\")'>
  					";

  				echo "
  								<span class='slider round'></span>
							</label>
							<h3 style='position: relative; left: 3vw; top: -12vh; font-size: 1.25rem;'>Staff</h3>

							<label class='switch' style='left: -16.75vw; top: 8vh;'>
				";

				if($row["isManager"] == 1)
  					echo "	
  								<input type='checkbox' class='switchInput' onclick='changeType(0,$a,\"" . $row["Username"] . "\")' checked>
  					";
  				else
  					echo "	
  								<input type='checkbox' class='switchInput' onclick='changeType(0,$a,\"" . $row["Username"] . "\")'>
  					";

  				echo "
  								<span class='slider round'></span>
							</label>
							<h3 style='position: relative; left: -6.25vw; top: -5vh; font-size: 1.2rem;'>Manager</h3>
						</div>
					</div>
				";
				$a++;
			}
		?>
	</div>

	<script>
		function changeType(num, classNum, username){
			var className = document.getElementsByClassName("userBox")[classNum];
			var x = className.getElementsByClassName("switchInput")[num];
			x.checked = false;

        	if(num == 0)
				var y = className.getElementsByClassName("switchInput")[1];
			else
				var y = className.getElementsByClassName("switchInput")[0];

			if(y.checked == false)
				num = 2;
			
			var xmlhttp = new XMLHttpRequest();
        	xmlhttp.open("GET", "redirect user.php?userType=" + num + "&typeUname=" + username, true);
        	xmlhttp.send();
		}

	</script>
</body>

</html>