<?php
	session_start();
?>

<html>

<head>
	<title>SGL - Sign In</title>
	<link rel="stylesheet" type="text/css" href="../../resources/css/fonts.css">
	<link rel="stylesheet" type="text/css" href="sign_in.css">
	<link rel="icon" type="image/png" href="../../resources/images/sgl_favicon.jpg">
	<meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="460955423798-irpup8l4kap6nc4mdrutk873vb1dba9j.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
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
	<div id="container">
		<h1>SGL</h1>
		<h2>SMART GARBAGE LOCATOR</h2>
		<span id="content" style="display: block;">
			<h3 onclick="showRegister()" style="left: 4.75vw;" onclick="">Sign up</h3>
			<h3 onclick="showSignIn()">Login</h3>
			<p>OR</p>
			<div class="g-signin2" data-onsuccess="onSignIn" style="width: 315px; height: 40px; border-radius: 10px;" data-theme="dark"></div>
		</span>
		<div id="sign-in">
			<form action="../../php/redirect_user.php" name="signin" method="POST" onsubmit="return validate(0,2)">
				<p style="position: relative; left: 0;">Username: </p>
				<input type="text" name="Username2" style="position: relative; top: 2.5vh; left: 2vw;" onclick="resetTextbox(0,0)">
				<p style="position: relative; top: 4vh; left: -17.5vw;">Password: </p>
				<input type="text" name="Password2" style="position: relative; top: -1vh; left: 8vw;" onclick="resetTextbox(0,1)">
				<input type="submit" value="Sign In">
				<h3 onclick="hideSignIn()">Back</h3>
				<h5 class="errorMessageRegister"></h5>
			</form>
		</div>
		<img src="../../resources/images/recycle.png" alt="recycle-logo" id="image">
		<div id="register">
			<form action="../../php/redirect_user.php" name="register" method="POST" onsubmit="return validate(1,6)" enctype="multipart/form-data">
				<p style="top: 2.5vh;">First Name: </p>
				<input type="text" name="FirstName" style="position: relative; top: -2vh; left: 13.5vw;" onclick="resetTextbox(1,0)">
				<p style="top: -0.5vh;">Last Name: </p>
				<input type="text" name="LastName" style="position: relative; top: -2vh; left: 13.5vw;" onclick="resetTextbox(1,1)">
				<p style="top: -0.5vh;">Email: </p>
				<input type="text" name="Email" style="position: relative; top: -2vh; left: 13.5vw;" onclick="resetTextbox(1,2)">
				<p style="top: -0.5vh;">Username: </p>
				<input type="text" name="Username" style="left: 13.5vw;" onclick="resetTextbox(1,3)">
				<p style="top: -0.5vh;">Password: </p>
				<input type="text" name="Password" style="position: relative; left: 13.5vw;" onclick="resetTextbox(1,4)">
				<p style="top: -0.5vh;">Re-Password: </p>
				<input type="text" name="RePassword" style="position: relative; left: 13.5vw;" onclick="resetTextbox(1,5)">
				<p style="top: -0.5vh;">Profile Picture: </p>
				<input type="file" name="fileToUpload" accept="image/*">
				<input type="submit" value="Register" name="submitRegister">
				<h3 onclick="hideRegister()">Back</h3>
				<h5 class="errorMessageRegister"></h5>
			</form>
		</div>
	</div>

	<div id="loginErrorBox">
		<h2>Error Occured</h2>
		<h3 id="errorMessage"></h3>
		<button onclick="hideErrorBox();">OK</button>
	</div>

	<?php
		if(isset($_SESSION["loginError"])){
			echo "
				<script>
					document.getElementById('loginErrorBox').style.display = 'block';
					document.getElementById('errorMessage').innerHTML = '" . $_SESSION["loginError"] . "';
				</script>
			";
			unset($_SESSION["loginError"]);
		}
	?>

	 <script>
	 	function hideErrorBox(){
	 		document.getElementById('loginErrorBox').style.display = 'none';
	 	}
	 	
	 	function resetTextbox(formNum, textNum){
      		var form = document.forms[formNum];
	 		form[textNum].style.outlineColor = "transparent";
	 		document.getElementById("errorMessageRegister").innerHTML = "";
      	}

      	function validate(num,textCount){
	 		var form = document.forms[num];
	 		var i;
	 		var isFilled = new Array();

	 		for(i=0;i<textCount;i++){
	 			if(form[i].value.trim().length == 0){
	 				form[i].style.outlineColor = "red";
	 				isFilled[i] = false;
	 			}
	 			else
	 				isFilled[i] = true;
	 		}

	 		for(i=0;i<textCount;i++){
    			if(isFilled[i] == false){
    				document.getElementsByClassName("errorMessageRegister")[num].innerHTML = "Please fill above field(s)";
    				if(num == 0)
    					document.getElementById("image").style.top = "-2.2vh";
    				return false;
    			}
    			else{
    				form[i].style.outlineColor = "transparent";
    				document.getElementsByClassName("errorMessageRegister")[num].innerHTML = "";
    			}
    		}

    		if(num == 1){
    			if(form[4].value.trim().length < 8){
    				document.getElementsByClassName("errorMessageRegister")[num].innerHTML = "Password length too short. Minimum length is 8 letters";
    				form[4].style.outlineColor = "red";
    				return false;
    			}
    			else if(form[4].value != form[5].value){
    				document.getElementsByClassName("errorMessageRegister")[num].innerHTML = "Passwords do not match";
    				form[4].style.outlineColor = "red";
    				form[5].style.outlineColor = "red";
    				return false;
    			}
    		}

   			return true;
	 	}

	 	function showSignIn(){
	 		document.getElementById("content").style.display = "none";
	 		document.getElementById("sign-in").style.display = "block";
	 		document.getElementById("image").style.left = "11.5vw";
	 		document.getElementById("image").style.top = "0.2vh";
	 	}

	 	function hideSignIn(){
	 		document.getElementById("content").style.display = "block";
	 		document.getElementById("sign-in").style.display = "none";
	 		document.getElementById("image").style.left = "-8.5vw";
	 		document.getElementById("image").style.top = "20vh";
	 	}

	 	function showRegister(){
	 		document.getElementById("content").style.display = "none";
	 		document.getElementById("register").style.display = "block";
	 		document.getElementById("image").style.display = "none";
	 	}

	 	function hideRegister(){
	 		document.getElementById("content").style.display = "block";
	 		document.getElementById("register").style.display = "none";
	 		document.getElementById("image").style.display = "block";
	 	}

      	function onSignIn(googleUser) {
        	var profile = googleUser.getBasicProfile();
        	window.open("http://localhost/Smart%20Garbage%20Locator/redirect%20user.php?ID=" + profile.getId() + "&Username=" + profile.getName() + "&Fname=" + profile.getGivenName() + "&Lname=" + profile.getFamilyName() + "&Email=" + profile.getEmail() + "&ProfileImg=" + profile.getImageUrl(),"_self");
      	}

    </script>
</body>

</html>