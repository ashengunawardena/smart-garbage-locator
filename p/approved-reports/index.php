<?php
	session_start();
	
	if(!isset($_SESSION["userType"]))
    header("Location: sign in.php");
	if(isset($_SESSION["userType"])){
		if(!($_SESSION["userType"] == "staff"))
			header("Location: sign in.php");
	}

	$conn = new mysqli("localhost","root","","SGL");

	if ($conn->connect_error) {
   		die("Connection failed: " . $conn->connect_error);
	}

	$query = "SELECT flagColor, coordinates FROM reports WHERE isApproved = 1;";
	$result = $conn->query($query);
?>

<html>

<head>
	<title>SGL - Garbage Locations</title>
	<link rel="stylesheet" type="text/css" href="approved_reports.css">
	<link rel="stylesheet" type="text/css" href="../../resources/css/fonts.css">
	<link rel="icon" type="image/jpg" href="../../resources/images/sgl_favicon.jpg">
</head>

<body onload="fillDetails()">
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
		<a href="articles.php">ARTICLES</a>
		<a href='#'>APPROVED REPORTS</a>

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

	<div id="map"></div>

	<div id='details'>
		<h1 class='colorBlack' style='font-size: 1.5rem;'>Reports Summary</h1>

		<h2 style='font-size: 1.25rem;' id='colorGreen'>Clean up within 2 days,</h2>
    <p class="noReports"></p>
		<ol id="greenList">
		</ol>

		<h2 style='font-size: 1.25rem;' id='colorBlue'>Clean up within 1 day,</h2>
    <p class="noReports"></p>
		<ol id="blueList">
		</ol>
			
		<h2 style='font-size: 1.25rem;' id='colorRed'>Clean up immediately,</h2>
    <p class="noReports"></p>
		<ol id="redList">
		</ol>
	</div>

	<script>
		function fillDetails(){
			var i;

      if(greenAddress[0]){
			 for(i=0;i<greenAddress.length;i++){
				var list = document.createElement("li");
				var node = document.createTextNode(greenAddress[i]);
				list.appendChild(node);

				var element = document.getElementById("greenList");
			 	element.appendChild(list);
			 }
      }
      else
        document.getElementsByClassName("noReports")[0].innerHTML = "No reports!";

      if(blueAddress[0]){
			 for(i=0;i<blueAddress.length;i++){
				var list = document.createElement("li");
				var node = document.createTextNode(blueAddress[i]);
				list.appendChild(node);

				var element = document.getElementById("blueList");
				element.appendChild(list);
			 }
      }
      else
        document.getElementsByClassName("noReports")[1].innerHTML = "No reports!";  

      if(redAddress[0]){
			 for(i=0;i<redAddress.length;i++){
				var list = document.createElement("li");
				var node = document.createTextNode(redAddress[i]);
				list.appendChild(node);

				var element = document.getElementById("redList");
				element.appendChild(list);
			 }
      }
      else
        document.getElementsByClassName("noReports")[2].innerHTML = "No reports!";

		}

		function initMap() {
        	var map = new google.maps.Map(document.getElementById('map'), {
        		center: {lat: 6.8, lng: 80.10585777134702},
          		zoom: 11
        	});

        	var geocoder = new google.maps.Geocoder;
        	var infowindow = new google.maps.InfoWindow;

        	var greenFlag = {
    			url: "green-flag.png", 
    			scaledSize: new google.maps.Size(30, 30), 
    			origin: new google.maps.Point(0,0), 
    			anchor: new google.maps.Point(0, 0) 
			};

			var redFlag = {
    			url: "https://img.icons8.com/color/2x/filled-flag.png", 
    			scaledSize: new google.maps.Size(30, 30), 
    			origin: new google.maps.Point(0,0), 
    			anchor: new google.maps.Point(0, 0) 
			};

			var blueFlag = {
    			url: "blue-flag.png", 
    			scaledSize: new google.maps.Size(30, 30), 
    			origin: new google.maps.Point(0,0), 
    			anchor: new google.maps.Point(0, 0) 
			};


        	<?php
        		$blueCount = 0;
        		$greenCount = 0;
        		$redCount = 0;

        		if($result->num_rows > 0){
        			$s = 0;
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

						if($row["flagColor"] == "blue"){
							$flag = "blueFlag";
							$blueCount++;
						}
						elseif($row["flagColor"] == "green"){
							$flag = "greenFlag";
							$greenCount++;
						}
						else{
							$flag = "redFlag";
							$redCount++;
						}

        				echo "
        					marker$s = new google.maps.Marker({
            					position : {lat: " . $coords[0] . ", lng: " . $coords[1] . "},
            					map : map,
            					icon: $flag
        					});

        					getAddress(geocoder, marker$s, \"$flag\")

        					marker$s.addListener('click', function() {
        						map.setZoom(15);
          						map.setCenter(marker$s.getPosition());
          						geocodeLatLng(geocoder, map, infowindow, marker$s);
        					});
        				";
        				$s++;
        			}
        		}
        	?>
    	}

    	<?php
    		echo"
    			var blueAddress = [$blueCount];
    			var redAddress = [$redCount];
    			var greenAddress = [$greenCount];
    		";
    	?>

    	var b=0;
    	var g=0;
    	var r=0;

    	function getAddress(geocoder, marker, flagColor){
    		geocoder.geocode({'location': marker.getPosition()}, function(results, status) {
          		if (status === 'OK') {
            		if (results[0]) {
            			if(flagColor == "blueFlag"){
              				blueAddress[b] = results[0].formatted_address;
              				b++;
              			}
              			if(flagColor == "redFlag"){
              				redAddress[r] = results[0].formatted_address;
              				r++;
              			}
              			if(flagColor == "greenFlag"){
              				greenAddress[g] = results[0].formatted_address;
              				g++;
              			}
            		} else {
              			if(flagColor == "blueFlag"){
              				blueAddress[b] = "No address found!";
              				b++;
              			}
              			if(flagColor == "redFlag"){
              				redAddress[r] = "No address found!";
              				r++;
              			}
              			if(flagColor == "greenFlag"){
              				greenAddress[g] = "No address found!";
              				g++;
              			}
            		}
          		} else {
            		window.alert('Geocoder failed due to: ' + status);
          		}
        	});
    	}

    	function geocodeLatLng(geocoder, map, infowindow, marker) {
        	geocoder.geocode({'location': marker.getPosition()}, function(results, status) {
          		if (status === 'OK') {
            		if (results[0]) {
              			infowindow.setContent(results[0].formatted_address);
              	 		infowindow.open(map, marker);
            		} else {
              			window.alert('No results found');
            		}
          		} else {
            		window.alert('Geocoder failed due to: ' + status);
          		}
        	});
        }

	</script>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWp1vgfQxb2YfZFkOIXUq8cVLXdVOaFsA&callback=initMap"></script>
</body>

</html>