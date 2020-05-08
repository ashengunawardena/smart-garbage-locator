<?php
	session_start();

	if(!isset($_SESSION["userType"]))
    header("Location: sign in.php");
	if(isset($_SESSION["userType"])){
		if(!($_SESSION["userType"] == "manager"))
			header("Location: sign in.php");
	}

	$conn = new mysqli("localhost","root","","SGL");

	if ($conn->connect_error) {
   		die("Connection failed: " . $conn->connect_error);
	}

	$query = "SELECT * FROM reports WHERE isApproved = 0;";
	$result = $conn->query($query);
	$noReports = $result->num_rows;
?>

<html>

<head>
	<title>SGL - Reported Incidents</title>
	<link rel="stylesheet" type="text/css" href="incidents.css">
	<link rel="stylesheet" type="text/css" href="../../resources/css/fonts.css">
	<link rel="icon" type="image/png" href="../../resources/images/sgl_favicon.jpg">
</head>

<?php
	echo "<body onload='initSlides($noReports)'>";
?>
	<noscript>
    	<style>
    		div#container,#navbar{
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
    			top: 0;
    			width: 39vw;
    			height: auto;
    			left: 0;
    			color: black;
    			font-size: 1.1rem;
    		}
  			h2:hover, h4:hover{
  				cursor: context-menu;
  			}

    	</style>
    	<div id="error-box">
    		<h2 style="width: 40vw; font-size: 1.25rem;">Error Occured: Javascript Disabled</h2>
    		<h4 style="top: -2vh;">To continue to the SGL website please follow the below instruction and turn on Javascript on your browser</h4>
    		<h4 style="text-align: left; margin-left: 1vw;">1. Click the "i" mark to the left on the page url box<br>2. Click "Site settings" on the drop box which appears<br>3. Click "allow" on the Javascript setting which appears<br>4. If the setting is not visible search for "Javascript" on the search bar &nbsp;&nbsp;&nbsp; and allow Javascript to run on your browser<br>5. Please reload the browser</h4>
    	</div>
	</noscript>
	<div id="navbar">
		<a href="../../">HOME</a>
		<a href="../garbage-locations">GARBAGE LOCATIONS</a>
		<a href="../articles">ARTICLES</a>
		<a href="#">REPORTED INCIDENTS</a>

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

	<div id="mapContainer">
		<div id="map" style="position: fixed;"></div>
		<h6 onclick="closeMap()">X</h6>
	</div>

	<div id="flagType">
		<h2 style="text-align: center;">Approval of Reported Incident</h2>
		<h2 style="margin-bottom: 3vh;">Please choose corresponding flag to state how soon the garbage must be collected,</h2>
		<label class="switch">
  			<input type="checkbox" id="input1" onclick="choice(0,2,3)">
  			<span class="slider round"></span>
		</label>
		<h2 style="color: green; float: left; left: -1.25vw;">Cleanup within 2 days</h2>
		<label class="switch">
  			<input type="checkbox" id="input2" onclick="choice(1,1,3)">
  			<span class="slider round"></span>
		</label>
		<h2 style="color: blue; float: left; left: -1.25vw;">Cleanup within 1 day</h2>
		<label class="switch">
  			<input type="checkbox" id="input3" onclick="choice(2,1,2)">
  			<span class="slider round"></span>
		</label>
		<h2 style="color: red; float: left; left: -1.25vw;">Cleanup immediately</h2>
		<h6 onclick="approveReport()">Approve Incident</h6>
		<h6 style="font-family: arial; background: gold; width: 2vw; font-size: 1.5rem; top: -27vh; left: 17vw;" onclick="hideFlagType()">X</h6>
	</div>

	<?php
		if($noReports == 0){
			echo "<h5>No reports to be approved!</h5>";
		}
		else{
			$x = 0;
			while($row = $result->fetch_assoc()) {
        		echo "
        			<div class='report'>
						<img src='" . $row["profilePicLoc"] . "' alt='Profile-pic' id='profile-pic' style='position: relative; top: 0; left: 0; height: 5.25vh;''>
						<h2>" . $row['username'] . "</h2>
						<h2 style='position: relative; top: -3.8vh; left: 3vw;''>" . $row["submitDate"] . "</h2>
						<p>" . $row["description"] . "</p>
		
						<h3 onclick='showMap(" . $row["coordinates"] . ")'>Show Garbage Location on Map</h3>
						<h3 style='width: 11vw; left: 8.75vw; background: #31F064;' onclick='showFlagType(" . $row["id"] . ")'>Approve Incident</h3>
						<h3 style='width: 11vw; left: 9vw; background: #FA8072;' onclick='approveReport(1," . $row["id"] . ")'>Reject Incident</h3>
  				";

  				for($i=0;$i<$row["imageCount"];$i++){
  					$a = $i+1;
  					echo "
  						<div class='mySlides fade'>
    						<div class='numbertext'>" . $a . "/" . $row["imageCount"] . "</div>
    						<img src='" . $row["image$a"] . "'>
  						</div>
  					";
  				}

				echo	"<h4 onclick='plusSlides(-1,$x)'>&lt;</h4>
						<h4 style='	border-top-right-radius: 0;
									border-bottom-right-radius: 0;
									border-top-left-radius: 0.75vw;
									border-bottom-left-radius: 0.75vw;
									position: relative;
									top: -101.5vh;
									left: 84.8vw;
									padding-left: 0.75vw;
									width: 2vw;
				  								' onclick='plusSlides(1,$x)'>&gt;</h4>

					</div>
        		";

        		$x++;
    		}
		}
	?> 

    <script>

    	var slideIndex = 1;

    	function initSlides(reportCount){
			for(i=0;i<reportCount;i++){
				showSlides(slideIndex,i);
			}
		}

		function plusSlides(n,reportNo) {
 			showSlides(slideIndex += n,reportNo);
		}

		function showSlides(n,reportNo) {
  			var i;
  			var report = document.getElementsByClassName("report")[reportNo];
  			var slides = report.getElementsByClassName("mySlides");
  			if (n > slides.length) {slideIndex = 1} 
  			if (n < 1) {slideIndex = slides.length}
  			for (i = 0; i < slides.length; i++) {
      			slides[i].style.display = "none"; 
  			}
  			slides[slideIndex-1].style.display = "block"; 
		}

     	var map, marker, color;

     	function choice(colorNum,inputn1,inputn2){
     		var colors = ["green", "blue", "red"];
     		color = colors[colorNum];
     		var inputNum1 = "input" + inputn1;
     		var inputNum2 = "input" + inputn2; 
     		document.getElementById(inputNum1).checked = false;
     		document.getElementById(inputNum2).checked = false;
     	}

     	var userid=2;

     	function showFlagType(id){
     		document.getElementById("flagType").style.display = "block";
     		userid=id;
     	}

     	function hideFlagType(){
     		document.getElementById("flagType").style.display = "none";
     	}

     	function approveReport(reject,uid){

     		var xmlhttp = new XMLHttpRequest();
        	xmlhttp.onreadystatechange = function() {
            	if (this.readyState == 4 && this.status == 200) {
                	if(this.responseText == 'true'){
                		location.reload();
                	}
            	}
        	};

        	if(reject==1)
     			xmlhttp.open("GET", "redirect user.php?delete=1&userId=" + uid, true);
   			else
        		xmlhttp.open("GET", "redirect user.php?flag=" + color + "&userId=" + userid , true);
        	
        	xmlhttp.send();
     	}
      	
      	function showMap(lati, long){
      		document.getElementsByTagName("BODY")[0].style.pointerEvents = "none";
      		var center = {lat: lati, lng: long};
    		map.setCenter(center);
     		marker.setPosition(center);
      		document.getElementById("map").style.display = "block";
      		document.getElementById("report").style.top = "-88vh";
    	}

    	function closeMap(){
      		document.getElementsByTagName("BODY")[0].style.pointerEvents = "auto";
      		document.getElementById("map").style.display = "none";
      		document.getElementById("report").style.top = "0";
    	}

    	function initMap() {
        	map = new google.maps.Map(document.getElementById('map'), {
        		center: {lat: -34.397, lng: 150.644},
        		zoom: 12
        	});

       		marker = new google.maps.Marker({
            	position : {lat: -34.397, lng: 150.644},
            	map : map
        	});
    	}
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWp1vgfQxb2YfZFkOIXUq8cVLXdVOaFsA&callback=initMap"></script>

</body>

</html>