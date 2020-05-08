<?php
session_start();

$conn = new mysqli("localhost", "root", "", "SGL");

$query = "SELECT * FROM articles;";
$result = $conn->query($query);
?>

<html>

<head>
    <title>SGL - Articles</title>
    <link rel="stylesheet" type="text/css" href="articles.css">
    <link rel="stylesheet" type="text/css" href="../../resources/css/fonts.css">
    <link rel="icon" type="image/jpg" href="faviconNew.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <noscript>
        <style>
            div#container,
            .halfcircle,
            #about {
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
                color: black;
            }

            h4 {
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
        <a href="#">ARTICLES</a>

        <?php
        if (isset($_SESSION["userType"])) {
            if ($_SESSION["userType"] == 'admin') {
                echo "<a href='user accounts.php'>USER ACCOUNTS</a>";
                echo "<a href='reports.php'>REPORTS</a>";
            } else if ($_SESSION["userType"] == 'manager') {
                echo "<a href='incidents.php'>REPORTED INCIDENTS</a>";
            } else if ($_SESSION["userType"] == 'staff') {
                echo "<a href='approved reports.php'>APPROVED REPORTS</a>";
            } else if ($_SESSION["userType"] == 'volunteer') {
                echo "<a href='reports.php'>REPORTS</a>";
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
                    <a title='Log out' href='index.php?signout=yes'><img src='" . $_SESSION["imageLocation"] . "' alt='profile-pic' id='profile-pic' style='position: relative; left: 11vw; top: -1.1vh;''></a>
                    <script>
                        var x = document.getElementsByClassName('nav-img');
                        var i;
                        for(i=0; i<4; i++){
                            x[i].style.left = '-8.5vw';
                        }
                    </script>
                ";
        } else {
            echo "
                    <a href='sign in.php'><p>SIGN IN</p></a>
                ";
        }
        ?>

    </div>

    <?php
    if (isset($_SESSION["userType"])) {
        if (($_SESSION["userType"] == "admin"))
            echo "
                    <button onclick='showNewArticle()'>Create new article</button>
                ";
    }
    ?>
    <div id="newArticle">
        <form action="redirect user.php" id="articleForm" method="POST">
            <h1>Create article</h1>
            <h2>1. Heading of Article</h2>
            <input type=text name="articleHeading" onclick="resetTextbox(0)">
            <h2>2. Body of Article</h2>
            <textarea name="articleBody" id="reportDesc" onclick="resetTextbox(1)"></textarea>
            <p id="errorMessage">&nbsp</p>
            <input type="submit" name="submitArticle">
        </form>
        <h6 onclick="closeNewArticle()">X</h6>
    </div>

    <?php
    while ($row = $result->fetch_assoc()) {
        echo "
                <div class='article'>
                    <h1>" . $row["heading"] . "</h1>

                    <h2>By " . $row["username"] . "</h2>
                    <h2 style='margin-top: -2vh;'>Administrator</h2>
                    <h2 style='margin-top: -2vh;'>" . $row["submitDate"] . "</h2>

                    <p>" . $row["content"] . "</p>
                </div>
            ";
    }
    ?>

    <script>
        function resetTextbox(textNum) {
            var form = document.forms[0];
            form[textNum].style.border = "1px solid gray";
            document.getElementById("errorMessage").innerHTML = "&nbsp";
        }

        function showNewArticle() {
            document.getElementById("newArticle").style.display = "block";
            document.getElementById("newArticle").style.pointerEvents = "auto";
            document.getElementsByTagName("BODY")[0].style.pointerEvents = "none";
        }

        function closeNewArticle() {
            document.getElementById("newArticle").style.display = "none";
            document.getElementsByTagName("BODY")[0].style.pointerEvents = "auto";
        }

        $('#articleForm').submit(function() {
            var form = document.forms[0];
            var i;
            var submit = false;
            var isFilled = new Array();

            for (i = 0; i < 2; i++) {
                if (form[i].value.trim().length == 0) {
                    form[i].style.border = "2px solid red";
                    document.getElementById("errorMessage").innerHTML = "Please fill above field(s)";
                    isFilled[i] = false;
                } else {
                    form[i].style.border = "1px solid gray";
                    isFilled[i] = true;
                }
            }

            for (i = 0; i < 2; i++) {
                if (isFilled[i] == false) {
                    submit = false;
                    break;
                } else {
                    submit = true;
                }
            }

            if (submit) {
                document.getElementById("errorMessage").innerHTML = "&nbsp";
                $.post("redirect user.php", $("#articleForm").serialize(),
                    function(data) {
                        if (data == "false")
                            document.getElementById("errorMessage").innerHTML = "Article is already published!";
                        else
                            location.reload();
                    });
            }

            return false;
        });
    </script>
</body>

</html>