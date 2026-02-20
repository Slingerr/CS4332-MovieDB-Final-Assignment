<?php require "templates/header.php"; ?>

<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Add New Reviewer</h1>
    </div>

    <br><br>

    <form action="./addReviewer.php" id="addform" method="post">
        <label>Username</label>
        <input class="w3-input w3-border w3-round" type="text" name="username" form="addform">
		
		<input type="hidden" name="hide" value="1">

        <br><br>
        <input class="w3-btn w3-green" type="submit">
        <br><br>

    </form>

<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['hide'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
		
        
        $new_user = array(
            "username" => $_POST['username']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "reviewer",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
	
	echo $_POST['username'] . " was successfully added!";
}
?>
</div>
</body>
</html>