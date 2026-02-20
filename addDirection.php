<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
    require "../config.php";
    require "../common.php";
	
    $pdo = new PDO($dsn, $username, $password, $options);
	
	$sql = "SELECT directorID, CONCAT(directFN, ' ', directLN) AS directName FROM director";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$directors = $stmt->fetchAll();
	
	$sql = "SELECT movieID, title FROM movie";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$movies = $stmt->fetchAll();
?>

<?php require "templates/header.php"; ?>

<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Add Movie's Director</h1>
    </div>

    <br><br>

    <form action="./addDirection.php" id="addform" method="post">
    <label for="movieID"> Movie </label>
	<select class="w3-select w3-border" name="movieID">
    <option value="" disabled selected>Choose Movie</option>
	 <?php foreach($movies as $movie): ?>
			<option value="<?= $movie['movieID']; ?>"><?= $movie['title']; ?></option>
	 <?php endforeach; ?>
	 </select>
	 
	 <br><br>
	 
	<label for="directorID"> Director </label>
	<select class="w3-select w3-border" name="directorID">
    <option value="" disabled selected>Choose Director</option>
	 <?php foreach($directors as $director): ?>
			<option value="<?= $director['directorID']; ?>"><?= $director['directName']; ?></option>
	 <?php endforeach; ?>
	 </select>
    
	<input type="hidden" name="hide" value="1">

    <br><br>
    <input class="w3-btn w3-green" type="submit">
    <br><br>

    </form>
<?php
	if (isset($_POST['hide'])) {
		
	$local_directorID=$_POST['directorID'];
	$local_movieID=$_POST['movieID'];

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "directorID" => $local_directorID,
            "movieID"  => $local_movieID
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "moviedirection",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
	
		$statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
	
	echo "Direction was successfully added!";
}
?>
</div>
</body>
</html>