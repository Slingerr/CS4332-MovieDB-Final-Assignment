<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
    require "../config.php";
    require "../common.php";
	
    $pdo = new PDO($dsn, $username, $password, $options);
	
	$sql = "SELECT actorID, CONCAT(actFN, ' ', actLN) AS actName FROM actor";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$actors = $stmt->fetchAll();
	
	$sql = "SELECT movieID, title FROM movie";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$movies = $stmt->fetchAll();
?>

<?php require "templates/header.php"; ?>

<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Add an Actor's Role</h1>
    </div>

    <br><br>

    <form action="./addRole.php" id="addform" method="post">
    <label for="movieID"> Movie </label>
	<select class="w3-select w3-border" name="movieID">
    <option value="" disabled selected>Choose Movie</option>
	 <?php foreach($movies as $movie): ?>
			<option value="<?= $movie['movieID']; ?>"><?= $movie['title']; ?></option>
	 <?php endforeach; ?>
	 </select>
	 
	 <br><br>
	 
	<label for="actorID"> Actor </label>
	<select class="w3-select w3-border" name="actorID">
    <option value="" disabled selected>Choose Actor</option>
	 <?php foreach($actors as $actor): ?>
			<option value="<?= $actor['actorID']; ?>"><?= $actor['actName']; ?></option>
	 <?php endforeach; ?>
	 </select>
	 
	 <br><br>
	 <label for="role">Role</label>
    <input class="w3-input w3-border w3-round" type="text" name="role" id="role">
    
	<input type="hidden" name="hide" value="1">

    <br><br>
    <input class="w3-btn w3-green" type="submit">
    <br><br>

    </form>

<?php
	if (isset($_POST['hide'])) {
		
	$local_actorID=$_POST['actorID'];
	$local_movieID=$_POST['movieID'];
	$local_role=$_POST['role'];

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
		
        
        $new_user = array(
            "actorID" => $local_actorID,
            "movieID"  => $local_movieID,
			"role" => $local_role
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "moviecast",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
	
   echo $local_role . " was successfully added!";

}
?>