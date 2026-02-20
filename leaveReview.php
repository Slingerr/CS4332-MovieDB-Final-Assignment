<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
    require "../config.php";
    require "../common.php";
	
    $pdo = new PDO($dsn, $username, $password, $options);
	
	$sql = "SELECT reviewerID, username FROM reviewer";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$reviewers = $stmt->fetchAll();
	
	$sql = "SELECT movieID, title FROM movie";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$movies = $stmt->fetchAll();

?>

<?php require "templates/header.php"; ?>


<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Rate A Movie</h1>
    </div>
	

 <form action="./leaveReview.php" id="addform" method="post">
  

    <br><br>

    <label for="movieID"> Movie </label>
	<select class="w3-select w3-border" name="movieID">
    <option value="" disabled selected>Choose Movie</option>
	 <?php foreach($movies as $movie): ?>
			<option value="<?= $movie['movieID']; ?>"><?= $movie['title']; ?></option>
	 <?php endforeach; ?>
	 </select>
	 
	 
	 <br><br>
	 
	<label for="reviewerID"> Reviewer </label>
	<select class="w3-select w3-border" name="reviewerID">
    <option value="" disabled selected>Choose Reviewer</option>
	 <?php foreach($reviewers as $reviewer): ?>
			<option value="<?= $reviewer['reviewerID']; ?>"><?= $reviewer['username']; ?></option>
	 <?php endforeach; ?>
	 </select>
	 
	 <br><br>
	 
    <label for="score"> Score </label>
	<br>
	<input class="w3-radio" type="radio" name="score" value="1">
    <label>1</label>

    <input class="w3-radio" type="radio" name="score" value="2">
    <label>2</label>
	
	<input class="w3-radio" type="radio" name="score" value="3">
    <label>3</label>
	
	<input class="w3-radio" type="radio" name="score" value="4">
    <label>4</label>
	
	<input class="w3-radio" type="radio" name="score" value="5">
    <label>5</label>


        <br>
	<input type="hidden" name="hide" value="1">

        <br><br>
        <input class="w3-btn w3-green" type="submit">
        <br><br>

    </form>

<?php
if (isset($_POST['hide'])) {

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "movieID" => $_POST['movieID'],
            "reviewerID"  => $_POST['reviewerID'],
			"score" => $_POST['score']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "rating",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
	
	echo "Review was successfully added!";
}
?>
</div>
</body>
</html>