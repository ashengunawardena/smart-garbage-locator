<?php
	session_start();

	$conn = new mysqli("localhost","root","","SGL");

	if ($conn->connect_error) {
   		die("Connection failed: " . $conn->connect_error);
	}

	$query = "SELECT coordinates FROM reports WHERE isApproved = 1;";
	$result = $conn->query($query);
?>

<html>

<head>
	<title>SGL - Garbage Locations</title>
	<link rel="stylesheet" type="text/css" href="garbage_locations.css">
	<link rel="stylesheet" type="text/css" href="../../resources/css/fonts.css">
	<link rel="icon" type="image/jpg" href="../../resources/images/sgl_favicon.jpg">
</head>

<body>
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
    		<h4 style="text-align: left; margin-left: 1vw; margin-top: -6vh;">1. Click the "i" mark to the left on the page url box<br>2. Click "Site settings" on the drop box which appears<br>3. Click "allow" on the Javascript setting which appears<br>4. If the setting is not visible search for "Javascript" on the search bar and &nbsp;&nbsp;&nbsp;&nbsp;allow Javascript to run on your browser<br>5. Please reload the browser</h4>
    	</div>
	</noscript>
	<div id="navbar">
		<a href="index.php">HOME</a>
		<a href="garbage locations.php">GARBAGE LOCATIONS</a>
		<a href="">ARTICLES</a>

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
					echo "<a href=''>APPROVED REPORTS</a>";
				}
				else if($_SESSION["userType"] == 'volunteer'){
					echo "<a href='reports.php'>REPORTS</a>";
				}
			}
		?>

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
			else
				echo "<a href='sign in.php'><p>SIGN IN</p></a>";
		?>
	</div>

	<div id="map"></div>

	<script>
		function initMap() {
        	map = new google.maps.Map(document.getElementById('map'), {
        		center: {lat: 6.8, lng: 80.10585777134702},
          		zoom: 11
        	});

        	var icon = {
    			url: "https://image.flaticon.com/icons/svg/148/148962.svg", 
    			scaledSize: new google.maps.Size(30, 30), 
    			origin: new google.maps.Point(0,0), 
    			anchor: new google.maps.Point(0, 0) 
			};

        	<?php
        		if($result->num_rows > 0){
        			while($row = $result->fetch_assoc()) {
        				$del = ","; 
						$token = strtok($row["coordinates"], $del); 
						$i=0;
						$coords = array();
						while ($token !== false){ 
							$coords[$i] = $token;
							$i++;
    						$token = strtok($del); 
						} 

        				echo "
        					marker = new google.maps.Marker({
            					position : {lat: " . $coords[0] . ", lng: " . $coords[1] . "},
            					map : map,
            					icon: icon
        					});
        				";
        			}
        		}
        	?>
    	}

	</script>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWp1vgfQxb2YfZFkOIXUq8cVLXdVOaFsA&callback=initMap"></script>
</body>

</html>