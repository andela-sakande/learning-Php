<?php

/**
 * Created by PhpStorm.
 * User: sirolad
 * Date: 8/25/15
 * Time: 4:41 PM
 */
$server = "localhost";
$db_user = "root";
$db_pass = "root";
$db_name = "testsite";
?>
<html>
<head>
  <title></title>
</head>
<body>
<center>
<form method="get" action="search.php">
  <input type="text" name="search">
  <input type="submit" name="submit" value="search database">
</form>
</center>
<hr>
<u>Results:</u>&nbsp
<?php
if (isset($_REQUEST['submit'])) {
    $search = $_GET['search'];
    $terms = explode(" ", $search);
    $query = "SELECT * FROM users WHERE ";
    $i=0;
    foreach ($terms as $each) {
        $i++;
        if ($i == 1) {
            $query.= "name LIKE '%$each%'";
        } else {
            $query.= "OR name LIKE '%$each%'";
        }
    }
    mysqli_connect($server, $db_user, $db_pass) or die("Could not connect to server!");
    mysqli_select_db($db_name) or die("Could not connect to database!");
    $query = mysqli_query($query);
    $num = mysqli_num_rows($query);

    if ($num > 0 && $search != "") {
        echo "$num result(s) found for <b>$search</b> !";
        while ($row = mysqli_fetch_assoc($query)) {
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $password = $row['password'];

            echo "<br><h3>name: $name(id: $id)</h3>email: $email<br>password: $password<br>";
        }
    } else {
        echo "No results found!";
    }
    mysqli_close();
} else {
    echo "Please type any word!";
}
?>
<hr>

<?php include("links.php"); ?>

</body>

</html>