<?php
session_start();

if (!isset($_SESSION["userType"]))
  header("Location: sign in.php");
if (isset($_SESSION["userType"])) {
  if (!($_SESSION["userType"] == "admin") and !($_SESSION["userType"] == "volunteer"))
    header("Location: sign in.php");
}

$conn = new mysqli("localhost", "root", "", "SGL");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM reports WHERE username = '" . $_SESSION["uname"] . "';";
$result = $conn->query($query);
$noReports = $result->num_rows;
?>

<html>

<head>
  <title>SGL - Reports</title>
  <link rel="stylesheet" type="text/css" href="reports.css">
  <link rel="stylesheet" type="text/css" href="../../resources/css/fonts.css">
  <link rel="icon" type="image/png" href="../../resources/images/sgl_favicon.jpg">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<?php
if (isset($_GET["delReport"]))
  echo "<body onload='initSlides($noReports); showMyReports();'>";
else
  echo "<body onload='initSlides($noReports)'>";
?>
<noscript>
  <style>
    div#container,
    #navbar {
      display: none;
    }

    #error-box {
      width: 40vw;
      height: 35vh;
      background: #32CD32;
      border-radius: 2vw;
      margin: auto;
      margin-top: 30vh;
      text-align: center;
      padding-top: 0.25vh;
    }

    h2,
    h4 {
      font-family: Arial;
    }
  </style>
  <div id="error-box">
    <h2 style="width: 40vw;">Error Occured: Javascript Disabled</h1>
      <h4>To continue to the SGL website please follow the below instruction and turn<br>on Javascript on your browser</h4>
      <h4 style="text-align: left; margin-left: 1vw;">1. Click the "i" mark to the left on the page url box<br>2. Click "Site settings" on the drop box which appears<br>3. Click "allow" on the Javascript setting which appears<br>4. If the setting is not visible search for "Javascript" on the search bar and &nbsp;&nbsp;&nbsp;&nbsp;allow Javascript to run on your browser<br>5. Please reload the browser
  </div>
</noscript>
<div id="navbar">
  <a href="../../">HOME</a>
  <a href="../garbage-locations">GARBAGE LOCATIONS</a>
  <a href="../articles">ARTICLES</a>

  <?php
  if (isset($_SESSION["userType"])) {
    if ($_SESSION["userType"] == 'admin') {
      echo "<a href='../user-accounts'>USER ACCOUNTS</a>";
      echo "<a href='#'>REPORTS</a>";
    } else if ($_SESSION["userType"] == 'volunteer') {
      echo "<a href='#'>REPORTS</a>";
    }
  }
  ?>

  <a href='https://plus.google.com/u/0/102452053552533725657'><img src='../../resources/images/gplus_logo.jpg' alt='gplus-logo' class='nav-img'></a>
  <a href='https://twitter.com/LocatorSmart'><img src='../../resources/images/twitter_logo.png' alt='twitter-logo' class='nav-img'></a>
  <a href='https://www.facebook.com/Smart-Garbage-Locator-2278764132158177'><img src='../../resources/images/facebook_logo.png' alt='facebook-logo' class='nav-img'></a>
  <a href='https://www.instagram.com/smartgarbagelocator/'><img src='../../resources/images/instagram_logo.png' alt='instagram-logo' class='nav-img'></a>

  <?php
  if (isset($_SESSION["imageLocation"])) {
    echo "
					<a title='Log out' href='index.php?signout=yes'><img src='../../" . $_SESSION["imageLocation"] . "' alt='profile-pic' id='profile-pic' style='position: relative; left: 11vw; top: -1.1vh;''></a>
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

<div id="choice">
  <p onclick="showNewReport()">New Report</p>
  <p onclick="showMyReports()">My Reports</p>
</div>

<div id="myReports">
  <h5 id="backNewReport" onclick="showNewReport()">Create new report</h5>
  <?php
  if ($noReports == 0) {
    echo "<h5>You made no reports!</h5>";
  } else {
    $x = 0;
    while ($row = $result->fetch_assoc()) {
      if ($row["isApproved"] == 0)
        $status = "Submitted for approval";
      else
        $status = "Report approved";

      $reportImages = array();
      for ($i = 0; $i < $row["imageCount"]; $i++) {
        $a = $i + 1;
        $reportImages[$i] = $row["image$a"];
      }

      echo "
            <div class='report'>
              <img src='" . $row["profilePicLoc"] . "' alt='Profile-pic' id='profile-pic' style='position: relative; top: 0; left: 0; height: 5.25vh;''>
              <h2>" . $row['username'] . " <font color='red'>(Report Status: " . $status . ")</font></h2>
              <h2 style='position: relative; top: -3.8vh; left: 3vw;''>" . $row["submitDate"] . "</h2>
              <p>" . $row["description"] . "</p>
              <h3 onclick='showMap(" . $row["coordinates"] . ")'>Show Garbage Location on Map</h3>
              <h3 style='width: 11vw; left: 8.75vw; background: #31F064;' onclick='showNewReport(" . $row["id"] . "," . json_encode($reportImages) .  ",\"" . $row["description"] . "\"," . $row["coordinates"] . "," . $row["imageCount"] . ")'>Edit Report</h3>
              <h3 style='width: 11vw; left: 9vw; background: #FA8072;' onclick='deleteReport(" . $row["id"] . ")'>Delete Report</h3>
          ";

      for ($i = 0; $i < $row["imageCount"]; $i++) {
        $a = $i + 1;
        echo "
              <div class='mySlides fade'>
                <div class='numbertext'>" . $a . "/" . $row["imageCount"] . "</div>
                  <img src='" . $reportImages[$i] . "'>
                </div>
            ";
      }

      echo  "
              <h4 class='slideBtn' onclick='plusSlides(-1,$x)'>&lt;</h4>
              <h4 class='slideBtn' 
                style=' 
                  border-top-right-radius: 0;
                  border-radius: 0;
                  border-top-left-radius: 0.75vw;
                  border-bottom-left-radius: 0.75vw; 
                  position: relative;
                  top: -86vh;
                  left: 41.6vw;
                  padding-left: 0.75vw;
                  width: 2vw;
                ' onclick='plusSlides(1,$x)'>&gt;</h4>

            </div>
          ";

      $x++;
    }
  }
  ?>

  <div id="mapContainer">
    <div id="map2" style="position: fixed;"></div>
    <h6 id="closeBtn" onclick="closeMap()">X</h6>
  </div>

</div>

<div id="newReport">
  <div id="seperator"></div>
  <form action="../../php/redirect_user.php" method="POST" id="reportForm" enctype="multipart/form-data">
    <h2>1. Select garbage location photos (minimum 3 photos required),</h2>
    <div onclick="resetTextbox(0)" class="upload-btn-wrapper" style="margin-bottom: 2vw;">
      <input class="fileElements" type="file" name="uploadImg[]" accept="image/*" onchange="readURL(this,0);" />
      <img src="garbage.jpg" alt="garbage-img" class="garbage-img">
      <button class="formElements">+</button>
    </div>
    <div onclick="resetTextbox(1)" class="upload-btn-wrapper" style="margin-left: 2vw; margin-bottom: 2vw;">
      <input class="fileElements" type="file" name="uploadImg[]" accept="image/*" onchange="readURL(this,1);" />
      <img src="garbage.jpg" alt="garbage-img" class="garbage-img">
      <button class="formElements">+</button>
    </div>
    <div onclick="resetTextbox(2)" class="upload-btn-wrapper" style="margin-left: 2vw; margin-bottom: 2vw;">
      <input class="fileElements" type="file" name="uploadImg[]" accept="image/*" onchange="readURL(this,2);" />
      <img src="garbage.jpg" alt="garbage-img" class="garbage-img">
      <button class="formElements">+</button>
    </div><br>
    <div class="upload-btn-wrapper" style="margin-bottom: 2vw;">
      <input type="file" name="uploadImg[]" accept="image/*" onchange="readURL(this,3);" />
      <img src="garbage.jpg" alt="garbage-img" class="garbage-img">
      <button>+</button>
    </div>
    <div class="upload-btn-wrapper" style="margin-left: 2vw; margin-bottom: 2vw;">
      <input type="file" name="uploadImg[]" accept="image/*" onchange="readURL(this,4);" />
      <img src="garbage.jpg" alt="garbage-img" class="garbage-img">
      <button>+</button>
    </div>
    <div class="upload-btn-wrapper" style="margin-left: 2vw; margin-bottom: 2vw;">
      <input type="file" name="uploadImg[]" accept="image/*" onchange="readURL(this,5);" />
      <img src="garbage.jpg" alt="garbage-img" class="garbage-img">
      <button>+</button>
    </div>
    <h2>2. Description on the location,</h2>
    <textarea class="formElements" onclick="resetTextbox(3)" name="description" id="reportDesc"></textarea>
    <h2 style="position: relative; top: -156vh; left: 50vw;">3. Select garbage location (within colombo district).</h2>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map" onclick="resetTextbox(4)"></div>
    <h2 style="position: relative; top: -155vh; left: 50vw; color: green; font-size: 1rem;">Selected Location: </h2>
    <input type="text" id="address" value="Location Unset" disabled><br>
    <input type="hidden" id="address2" name="coordinates" class="formElements">

    <p id="errorMessage">&nbsp</p>
    <h4 style="padding-top: 0.8vh; height: 3.7vh;" onclick="hideNewReport()">BACK</h4>
    <input type="submit" id="submitBtn" value="REPORT" name="submitReport" style="top: -164.5vh; height: 4.5vh;">
  </form>

  <div id="reportLogBox">
    <h2>Report Status</h2>
    <h3 id="errorMessage2"></h3>
    <button onclick="hideErrorBox();">OK</button>
  </div>

  <?php
  if (isset($_SESSION["reportLog"])) {
    echo "
					<script>
						document.getElementById('reportLogBox').style.display = 'block';
            document.getElementById('choice').style.display = 'none';
            document.getElementById('newReport').style.display = 'block';
						document.getElementById('errorMessage2').innerHTML = '" . $_SESSION["reportLog"] . "';
					</script>
				";
    unset($_SESSION["reportLog"]);
  }
  ?>

</div>

<script>
  function resetTextbox(textNum) {
    var form = document.getElementsByClassName("formElements");
    if (textNum == 4)
      document.getElementById("address").style.border = "1px solid gray";
    else
    if (textNum == 0 || textNum == 1 || textNum == 2)
      form[textNum].style.border = "2px solid gray";
    else
      form[textNum].style.border = "1px solid gray";
    document.getElementById("errorMessage").innerHTML = "&nbsp";
  }

  var slideIndex = 1;

  $('#reportForm').submit(function() {
    var form = document.getElementsByClassName("formElements");
    var i, valLength;
    var submit = false;
    var isFilled = new Array();

    if (!editReportID) {
      for (i = 0; i < 5; i++) {
        if (i == 0 || i == 1 || i == 2)
          valLength = document.getElementsByClassName("fileElements")[i].value.trim().length;
        else
          valLength = form[i].value.trim().length;

        if (valLength == 0) {
          if (i == 4)
            document.getElementById("address").style.border = "2px solid red"
          else
            form[i].style.border = "2px solid red";
          document.getElementById("errorMessage").innerHTML = "Please fill above field(s)";
          isFilled[i] = false;
        } else {
          if (i == 0 || i == 1 || i == 2)
            form[i].style.border = "2px solid gray";
          else
            form[i].style.border = "1px solid gray";
          isFilled[i] = true;
        }
      }

      for (i = 0; i < 5; i++) {
        if (isFilled[i] == false) {
          submit = false;
          break;
        } else {
          submit = true;
        }
      }

      if (submit) {
        document.getElementById("errorMessage").innerHTML = "&nbsp";

        if (editReportID) {
          $('#reportForm').append("<input type='hidden' name='reportID' value='" + editReportID + "' />");
          $('#reportForm').append("<input type='hidden' name='editImages' value='" + JSON.stringify(editImages) + "' />");
          $('#reportForm').append("<input type='hidden' name='editImageCount' value='" + editImgCount + "' />");
          return true;
        } else
          return true;
      } else
        return false;
    } else {
      if (editReportID) {
        $('#reportForm').append("<input type='hidden' name='reportID' value='" + editReportID + "' />");
        $('#reportForm').append("<input type='hidden' name='editImages' value='" + JSON.stringify(editImages) + "' />");
        $('#reportForm').append("<input type='hidden' name='editImageCount' value='" + editImgCount + "' />");
        return true;
      } else
        return true;
    }
  });

  function deleteReport(reportID) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == 'true') {
          window.location.replace("reports.php?delReport=true");
        }
      }
    };

    xmlhttp.open("GET", "../../php/redirect_user.php?deleteReport=" + reportID, true);
    xmlhttp.send();
  }

  function initSlides(reportCount) {
    for (i = 0; i < reportCount; i++)
      showSlides(slideIndex, i);
  }

  function plusSlides(n, reportNo) {
    showSlides(slideIndex += n, reportNo);
  }

  function showSlides(n, reportNo) {
    var i;
    var report = document.getElementsByClassName("report")[reportNo];
    var slides = report.getElementsByClassName("mySlides");
    if (n > slides.length) {
      slideIndex = 1
    }
    if (n < 1) {
      slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
  }

  function showMap(lati, long) {
    document.getElementsByTagName("BODY")[0].style.pointerEvents = "none";
    var center = {
      lat: lati,
      lng: long
    };
    map2.setCenter(center);
    marker2.setPosition(center);
    document.getElementById("map2").style.display = "block";
    document.getElementById("closeBtn").style.display = "block";
    document.getElementById("report").style.top = "-88vh";
  }

  function closeMap() {
    document.getElementsByTagName("BODY")[0].style.pointerEvents = "auto";
    document.getElementById("map2").style.display = "none";
    document.getElementById("closeBtn").style.display = "none";
    document.getElementById("report").style.top = "0";
  }

  function hideErrorBox() {
    document.getElementById('reportLogBox').style.display = 'none';
  }

  var editImages = [];
  var x = 0;

  function readURL(input, num) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        document.getElementsByClassName("garbage-img")[num].src = e.target.result;
        document.getElementsByClassName("garbage-img")[num].style.width = "7.5vw";
        document.getElementsByClassName("garbage-img")[num].style.height = "15vh";
      }

      reader.readAsDataURL(input.files[0]);

      if (editReportID) {
        var imageRepeated = false;
        for (var i = 0; i < editImages.length; i++) {
          if (editImages[i] == num) {
            imageRepeated = true;
            break;
          }
        }

        if (!imageRepeated) {
          editImages[x] = num;
          x++;

          if (num > editImgCount - 1)
            editImgCount++;
        }
      }
    }
  }

  var editReportID;
  var editImgCount;

  function showNewReport(reportID, reportImages, reportDesc, reportLocLati, reportLocLong, imageCount) {
    if (reportID === undefined) {
      document.getElementById("choice").style.display = "none";
      document.getElementById("myReports").style.display = "none";
      document.getElementById("newReport").style.display = "block";
    } else {
      editImgCount = imageCount;
      for (var i = 0; i < reportImages.length; i++) {
        document.getElementsByClassName("garbage-img")[i].src = reportImages[i];
        document.getElementsByClassName("garbage-img")[i].style.width = "7.5vw";
        document.getElementsByClassName("garbage-img")[i].style.height = "15vh";
      }

      document.getElementById("reportDesc").innerHTML = reportDesc;

      var center = {
        lat: reportLocLati,
        lng: reportLocLong
      };
      map.setCenter(center);

      markers.forEach(function(marker) {
        marker.setMap(null);
      });
      markers = [];

      markers.push(new google.maps.Marker({
        position: center,
        map: map,
        icon: {
          fillOpacity: .2,
          strokeColor: 'white',
          strokeWeight: .5,
          scale: 10
        }
      }));

      setInputText(markers[0].getPosition());

      document.getElementById("submitBtn").value = "Edit";

      document.getElementById("myReports").style.display = "none";
      document.getElementById("newReport").style.display = "block";
      editReportID = reportID;
    }
  }

  function hideNewReport() {
    document.getElementById("choice").style.display = "block";
    document.getElementById("newReport").style.display = "none";
  }

  function showMyReports() {
    document.getElementById("choice").style.display = "none";
    document.getElementById("myReports").style.display = "block";
  }

  var map, marker, map2, marker2;
  var markers = [];

  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {
        lat: 6.908433739106624,
        lng: 80.10585777134702
      },
      zoom: 10
    });

    var colomboArea = [{
        lat: 6.9458307869960425,
        lng: 79.81988843526506
      },
      {
        lat: 6.9267395723900576,
        lng: 79.83459612758202
      },
      {
        lat: 6.923501800743371,
        lng: 79.84249255092186
      },
      {
        lat: 6.855923200771144,
        lng: 79.85940670843411
      },
      {
        lat: 6.838836817975508,
        lng: 79.86319010630359
      },
      {
        lat: 6.769974107958404,
        lng: 79.8803562439989
      },
      {
        lat: 6.7358800149262485,
        lng: 79.9462742127489
      },
      {
        lat: 6.7617917448121885,
        lng: 80.02180521860828
      },
      {
        lat: 6.786537696317864,
        lng: 80.05124172763658
      },
      {
        lat: 6.791120663009446,
        lng: 80.11269612612273
      },
      {
        lat: 6.773392811377184,
        lng: 80.1138977557614
      },
      {
        lat: 6.774074663882383,
        lng: 80.13106389345671
      },
      {
        lat: 6.797086620108308,
        lng: 80.14599843325163
      },
      {
        lat: 6.804285303317369,
        lng: 80.1996366099703
      },
      {
        lat: 6.817982010077289,
        lng: 80.2067623444824
      },
      {
        lat: 6.867409212073943,
        lng: 80.19491770947263
      },
      {
        lat: 6.8999601875751315,
        lng: 80.21122554028318
      },
      {
        lat: 6.9169254566911835,
        lng: 80.22971859094082
      },
      {
        lat: 6.936011213885195,
        lng: 80.23280849572598
      },
      {
        lat: 6.958844942745385,
        lng: 80.2283452999252
      },
      {
        lat: 6.979632894268997,
        lng: 80.21358242150723
      },
      {
        lat: 6.980655228741771,
        lng: 80.19607296105801
      },
      {
        lat: 6.973158057427923,
        lng: 80.16723384972988
      },
      {
        lat: 6.972646882285694,
        lng: 80.1327299129623
      },
      {
        lat: 6.960889700155161,
        lng: 80.11676540490566
      },
      {
        lat: 6.932091880352625,
        lng: 80.0965093624252
      },
      {
        lat: 6.910279342226906,
        lng: 80.09952750924344
      },
      {
        lat: 6.9281725142233785,
        lng: 80.04462314489012
      },
      {
        lat: 6.947598617851975,
        lng: 80.01441074254637
      },
      {
        lat: 6.9414522621908485,
        lng: 79.99446809540723
      },
      {
        lat: 6.950824340839704,
        lng: 79.94296968232129
      },
      {
        lat: 6.950824340839704,
        lng: 79.94211137543653
      },
      {
        lat: 6.962752170606522,
        lng: 79.88855302582715
      },
      {
        lat: 6.980472957586411,
        lng: 79.87070024262403
      },
      {
        lat: 6.962012800009313,
        lng: 79.85828539760155
      },
      {
        lat: 6.946634127051161,
        lng: 79.84135971680598
      },
      {
        lat: 6.9458307869960425,
        lng: 79.81988843526506
      }
    ];

    var colombo = new google.maps.Polyline({
      path: colomboArea,
      geodesic: true,
      strokeColor: '#FF0000',
      strokeOpacity: 1.0,
      strokeWeight: 2
    });
    colombo.setMap(map);

    //setting a listener for click event of map
    google.maps.event.addListener(map, 'click', function(event) {
      if (google.maps.geometry.poly.containsLocation(event.latLng, colombo)) {
        setInputText(event.latLng);

        markers.forEach(function(marker) {
          marker.setMap(null);
        });
        markers = [];

        markers.push(new google.maps.Marker({
          position: event.latLng,
          map: map,
          icon: {
            fillOpacity: .2,
            strokeColor: 'white',
            strokeWeight: .5,
            scale: 10
          }
        }));
      } else {
        setInputText(0);
      }
    });

    map2 = new google.maps.Map(document.getElementById('map2'), {
      center: {
        lat: -34.397,
        lng: 150.644
      },
      zoom: 12
    });

    marker2 = new google.maps.Marker({
      position: {
        lat: -34.397,
        lng: 150.644
      },
      map: map2
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        alert("no places");
        return;
      }

      // Clear out the old markers.
      markers.forEach(function(marker) {
        marker.setMap(null);
      });
      markers = [];

      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }

        if (google.maps.geometry.poly.containsLocation(place.geometry.location, colombo)) {
          var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

          // Create a marker for each place.
          markers.push(new google.maps.Marker({
            map: map,
            position: place.geometry.location
          }));

          setInputText(place.geometry.location);

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }

          map.fitBounds(bounds);
        } else
          setInputText(0);
      });
    });
  }

  function setInputText(position) {
    if (position == 0) {
      document.getElementById("address").value = "Invalid Location!";
      document.getElementById("address2").value = null;
    } else {
      document.getElementById("address").value = "lat: " + Math.round(position.lat() * 1000000000) / 1000000000 + ", lng: " + Math.round(position.lng() * 1000000000) / 1000000000;
      document.getElementById("address2").value = Math.round(position.lat() * 1000000000) / 1000000000 + "," + Math.round(position.lng() * 1000000000) / 1000000000;
    }
  }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnHmE_t_LqUyHRIea_3SELbmSiM1ILe9c&libraries=places&callback=initMap"></script>

</body>

</html>