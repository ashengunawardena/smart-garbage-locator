<?php
session_start();
include 'mail.php';
date_default_timezone_set("Asia/Colombo");

$conn = new mysqli("localhost", "root", "", "SGL");

//login to the system
if (isset($_POST['Username2']) and isset($_POST['Password2'])) {
  $Username = $_POST['Username2'];
  $EncryptedPassword = crypt($_POST['Password2'], '$1$XgER5723$');

  $query = "SELECT Fname,Lname,Email,isAdmin,isManager,isStaff,imageLocation FROM members WHERE Username='" . $Username . "' AND Password='" . $EncryptedPassword . "';";
  $result = $conn->query($query);

  if ($result->num_rows == 1) {
    $query = "UPDATE members SET lastLogin='" . date('Y-m-d H:i:s') . "' WHERE Username='" . $Username . "';";
    $conn->query($query);

    $_SESSION["username"] = $Username;

    $row = $result->fetch_assoc();

    $_SESSION["isSignedIn"] = 'true';
    $imageL = $row["imageLocation"];
    if (strlen($imageL) < 5) {
      $_SESSION["imageLocation"] = "resources/images/default_profile_pic.jpg";
      echo "same";
    } else {
      $_SESSION["imageLocation"] = $imageL;
      echo $imageL;
    }

    if ($row["isAdmin"] == 1) {
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
      $_SESSION["userType"] = 'admin';
      $_SESSION["uname"] = $row["Fname"] . " " . $row["Lname"];
    } elseif ($row["isManager"] == 1) {
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
      $_SESSION["userType"] = 'manager';
    } elseif ($row["isStaff"] == 1) {
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
      $_SESSION["userType"] = 'staff';
    } else {
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
      $_SESSION["userType"] = 'volunteer';
      $_SESSION["uname"] = $row["Fname"] . " " . $row["Lname"];
    }
  } else {
    $_SESSION["loginError"] = "Incorrect User Details!";
    header("Location: ../p/sign-in");
  }
}


//manual sign in
if (isset($_POST['FirstName']) and isset($_POST['LastName']) and isset($_POST['Email']) and isset($_POST['Username']) and isset($_POST['Password'])) {
  $Fname = htmlspecialchars($_POST['FirstName'], ENT_QUOTES);
  $Lname = htmlspecialchars($_POST['LastName'], ENT_QUOTES);
  $Email = htmlspecialchars($_POST['Email'], ENT_QUOTES);
  $Uname = htmlspecialchars($_POST['Username'], ENT_QUOTES);
  $EncryptedPassword = crypt(htmlspecialchars($_POST['Password'], ENT_QUOTES), '$1$XgER5723$');

  $query = "INSERT INTO members (Username, Password, Fname, Lname, Email, dateJoined, lastLogin) VALUES ('" . $Uname . "','" . $EncryptedPassword . "','" . $Fname . "','" . $Lname . "','" . $Email . "','" . date('Y-m-d')  . "','" . date('Y-m-d H:i:s') . "');";

  if ($conn->query($query) === TRUE) {
    $_SESSION["username"] = $Uname;
    $_SESSION["userType"] = 'volunteer';
    $_SESSION["email"] = $Email;
    $_SESSION["isSignedIn"] = 'true';
    $_SESSION["uname"] = $Fname . " " . $Lname;
    $_SESSION["imageLocation"] = "ProfileImages/defaultPic.jpg";

    if (isset($_FILES["fileToUpload"])) {
      $target_dir = "C:/xampp/htdocs/Smart Garbage Locator/ProfileImages/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      if (isset($_POST["submitRegister"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          echo "File is not an image.";
          $uploadOk = 0;
        }
      }

      if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
      }
      // Allow certain file formats
      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          $imageLoc = htmlspecialchars("ProfileImages/" . $_FILES["fileToUpload"]["name"], ENT_QUOTES);
          $query2 = "UPDATE members SET imageLocation = '" . $imageLoc . "' WHERE Username = '" . $Uname . "';";
          if ($conn->query($query2) === FALSE) {
            $_SESSION["loginError"] = "Profile picture not accepted! Please change it manually";
            header("Location: ../p/sign-in");
          } else {
            $_SESSION["imageLocation"] = $imageLoc;
          }
        } else {
          $_SESSION["loginError"] = "Profile picture not accepted! Please change it manually";
          header("Location: ../p/sign-in");
        }
      }
    }

    header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
  } else {
    $_SESSION["loginError"] = "Registration Error Occured!";
    header("Location: ../p/sign-in");
  }
}


//google sign in
if (isset($_GET['ID']) and isset($_GET['Username']) and isset($_GET['Fname']) and isset($_GET['Lname']) and isset($_GET['Email'])) {
  $GoogleID = $_GET['ID'];
  $Username = $_GET['Username'];
  $Fname = $_GET['Fname'];
  $Lname = $_GET['Lname'];
  $Email = $_GET['Email'];
  $ProfileImg = $_GET['ProfileImg'];

  $query = "SELECT isAdmin,isManager,isStaff,imageLocation FROM members WHERE GoogleID='" . $GoogleID . "';";
  $result = $conn->query($query);

  if ($result->num_rows == 1) {
    $query = "UPDATE members SET lastLogin='" . date('Y-m-d H:i:s') . "' WHERE GoogleID='" . $GoogleID . "';";
    $conn->query($query);

    // $_SESSION["email"] = $Email;
    $_SESSION["googleID"] = $GoogleID;
    $_SESSION["isSignedIn"] = 'true';

    $row = $result->fetch_assoc();

    $_SESSION["imageLocation"] = $ProfileImg;

    if ($row["isAdmin"] == 1) {
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
      $_SESSION["userType"] = 'admin';
      $_SESSION["uname"] = $Fname . " " . $Lname;
    } elseif ($row["isManager"] == 1) {
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
      $_SESSION["userType"] = 'manager';
    } elseif ($row["isStaff"] == 1) {
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
      $_SESSION["userType"] = 'staff';
    } else {
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
      $_SESSION["userType"] = 'volunteer';
      $_SESSION["uname"] = $Fname . " " . $Lname;
    }
  } elseif ($result->num_rows == 0) {
    $Password = getRandomPassword();
    $encryptedPassword = crypt($Password, '$1$XgER5723$');
    $query2 = "INSERT INTO members (GoogleID, Username, Password, Fname, Lname, Email, dateJoined, lastLogin, imageLocation) VALUES ('" . $GoogleID . "','" . $Username . "','" . $encryptedPassword . "','" . $Fname . "','" . $Lname . "','" . $Email . "','" . date('Y-m-d') . "','" . date('Y-m-d H:i:s') . "','" . $ProfileImg . "');";

    if ($conn->query($query2) === TRUE) {
      $_SESSION["googleID"] = $GoogleID;
      $_SESSION["userType"] = 'volunteer';
      $_SESSION["email"] = $Email;
      $_SESSION["isSignedIn"] = 'true';
      $_SESSION["uname"] = $Fname . " " . $Lname;
      $_SESSION["imageLocation"] = $ProfileImg;

      sendMail($Email, 'Manual User Login Credentials for SGL', "Dear " . $Fname . " " . $Lname . ",<br><br>Thankyou for Registering as a volunteer on Smart Garbage Locator.<br><br> We look forward to creating a cleaner and greener Sri Lanka with your support towards Smart Garbage Locator.<br><br> Please use the below user credentials for manual user login,<br><br> Username = $Username <br> Password = $Password");
      header("Location: http://localhost/Smart%20Garbage%20Locator/index.php");
    } else {
      $_SESSION["loginError"] = "Registration Error Occured!";
      header("Location: sign in.php");
    }
  }
}

function getRandomPassword()
{
  $array = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'x', 'y', 'w', 'z');
  return random_int(100, 999) . $array[random_int(0, 23)] . $array[random_int(0, 23)] . random_int(100, 400) . $array[random_int(0, 23)];
}


//submission of a new report
if (isset($_POST['submitReport'])) {

  $numberOfFilesUploaded = 0;

  for ($i = 0; $i < 6; $i++) {
    if (strlen($_FILES['uploadImg']['name'][$i]) > 2)
      ++$numberOfFilesUploaded;
  }

  if (!isset($_POST['reportID'])) {
    if ($numberOfFilesUploaded < 3) {
      $_SESSION["reportLog"] = "Please provide more than three photos!";
      header("Location: reports.php");
      exit(0);
    }
  }
  // else{

  // $target_dir = "C:/xampp/htdocs/Smart Garbage Locator/GarbageLocations/";
  // $target_dir = "../resources/images/garbage_locations";
  $target_dir = "C:/xampp/htdocs/Smart Garbage Locator/resources/images/garbage_locations";
  if (!isset($_POST['reportID'])) {
    for ($i = 0; $i < $numberOfFilesUploaded; $i++) {
      $target_file = $target_dir . basename($_FILES["uploadImg"]["name"][$i]);

      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["uploadImg"]["tmp_name"][$i]);
      if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
      }

      if ($_FILES["uploadImg"]["size"][$i] > 500000000) {
        $uploadOk = 0;
      }

      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $uploadOk = 0;
      }

      if ($uploadOk == 0) {
        $_SESSION["reportLog"] = "Garbage location photo(s) not accepted!";
        header("Location: reports.php");
        exit(0);
      }
    }
  } else {
    $editImageLoc = json_decode($_POST["editImages"], true);
    for ($i = 0; $i < $numberOfFilesUploaded; $i++) {
      $target_file = $target_dir . basename($_FILES["uploadImg"]["name"][$editImageLoc[$i]]);

      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["uploadImg"]["tmp_name"][$editImageLoc[$i]]);
      if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
      }

      if ($_FILES["uploadImg"]["size"][$editImageLoc[$i]] > 500000000) {
        $uploadOk = 0;
      }

      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $uploadOk = 0;
      }

      if ($uploadOk == 0) {
        $_SESSION["reportLog"] = "Garbage location photo(s) not accepted!";
        header("Location: reports.php");
        exit(0);
      }
    }
  }

  $desc = htmlspecialchars($_POST['description'], ENT_QUOTES);
  $coords = htmlspecialchars($_POST['coordinates'], ENT_QUOTES);
  $submitDate = date('Y-m-d H:i:s');

  if (!isset($_POST['reportID']))
    $query = "INSERT INTO reports (description,coordinates,username,submitDate,profilePicLoc,imageCount) VALUES ('" . $desc . "','" . $coords . "','" . $_SESSION["uname"] . "','" . $submitDate . "','" . $_SESSION["imageLocation"] . "'," . $numberOfFilesUploaded . ");";
  else
    $query = "UPDATE reports SET description = '" . $desc . "', coordinates = '" . $coords . "', submitDate = '" . $submitDate . "', imageCount = " . $_POST["editImageCount"] . ", isApproved = 0 WHERE id = " . $_POST["reportID"] . ";";

  if ($conn->query($query)) {

    if (!isset($_POST['reportID'])) {
      if (isset($_SESSION["username"]))
        $query = "UPDATE members, (SELECT noReports, Username FROM members WHERE Username = '" . $_SESSION["username"] . "') t2
              SET members.noReports = t2.noReports + 1
              WHERE members.Username = t2.Username;";
      else
        $query = "UPDATE members, (SELECT noReports, Username FROM members WHERE GoogleID = '" . $_SESSION["googleID"] . "') t2
              SET members.noReports = t2.noReports + 1
              WHERE members.Username = t2.Username;";

      $conn->query($query);
    }


    if (!isset($_POST['reportID'])) {
      for ($i = 0; $i < $numberOfFilesUploaded; $i++) {
        $target_file = $target_dir . basename($_FILES["uploadImg"]["name"][$i]);
        move_uploaded_file($_FILES["uploadImg"]["tmp_name"][$i], $target_file);
        $a = $i + 1;
        $imageLoc = htmlspecialchars("GarbageLocations/" . $_FILES["uploadImg"]["name"][$i], ENT_QUOTES);

        $query2 = "UPDATE reports SET image$a = '" . $imageLoc . "' WHERE username = '" . $_SESSION["uname"] .
          "' AND submitDate = '" . $submitDate . "';";
        $conn->query($query2);

        // $query2 = "UPDATE reports SET image$a = '" . $imageLoc . "' WHERE username = '" . $_SESSION['uname'] . 
        //   "' AND submitDate = '" . $submitDate . "';";
        // $conn->query($query2);
      }
    } else {
      for ($i = 0; $i < $numberOfFilesUploaded; $i++) {
        $target_file = $target_dir . basename($_FILES["uploadImg"]["name"][$editImageLoc[$i]]);
        move_uploaded_file($_FILES["uploadImg"]["tmp_name"][$editImageLoc[$i]], $target_file);
        $a = $editImageLoc[$i] + 1;
        $imageLoc = htmlspecialchars("GarbageLocations/" . $_FILES["uploadImg"]["name"][$editImageLoc[$i]], ENT_QUOTES);
        $query2 = "UPDATE reports SET image$a = '" . $imageLoc . "' WHERE id = " . $_POST["reportID"] . ";";
        $conn->query($query2);
      }
    }

    $_SESSION["reportLog"] = "Report successfully submitted for approval!";
    header("Location: ../p/reports");
    exit(0);
  } else {
    $_SESSION["reportLog"] = "Report submission error!";
    header("Location: reports.php");
    exit(0);
  }
}




if (isset($_GET["flag"])) {
  $query = "UPDATE reports SET isApproved=1,flagColor='" . $_GET["flag"] . "' WHERE id=" . $_GET["userId"] . ";";
  if ($conn->query($query))
    echo "true";
  else
    echo "false";
}

if (isset($_GET["delete"])) {
  $query = "DELETE FROM reports WHERE id=" . $_GET["userId"] . ";";
  if ($conn->query($query))
    echo "true";
  else
    echo "false";
}

if (isset($_GET["userType"]) and isset($_GET["typeUname"])) {
  if ($_GET["userType"] == 0)
    $query = "UPDATE members
        SET isManager = 1, isStaff = NULL
        WHERE Username = '" . $_GET["typeUname"] . "';";
  elseif ($_GET["userType"] == 1)
    $query = "UPDATE members
        SET isManager = NULL, isStaff = 1
        WHERE Username = '" . $_GET["typeUname"] . "';";
  else
    $query = "UPDATE members
        SET isManager = NULL, isStaff = NULL
        WHERE Username = '" . $_GET["typeUname"] . "';";

  if ($conn->query($query))
    echo "true";
  else
    echo "false";
}

if (isset($_GET["deleteReport"])) {
  $query = "DELETE FROM reports WHERE id = " . $_GET["deleteReport"] . ";";

  if ($conn->query($query))
    echo "true";
  else
    echo "false";
}

if (isset($_POST["articleHeading"])) {
  $head = htmlspecialchars($_POST["articleHeading"], ENT_QUOTES);
  $body = htmlspecialchars($_POST["articleBody"], ENT_QUOTES);

  $query = "INSERT INTO articles (heading, content, submitDate, username) VALUES ('" . $head . "','" . $body . "','" . date('Y-m-d H:i:s') . "','" . $_SESSION['uname'] . "');";

  if ($conn->query($query))
    echo "true";
  else
    echo "false";
}
