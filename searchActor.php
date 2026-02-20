<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */
	require "../config.php";
    require "../common.php";

    $pdo = new PDO($dsn, $username, $password, $options);



	$sql = "SELECT actorID, CONCAT(actor.actFN, ' ', actor.actLN) AS actName FROM actor";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$actors = $stmt->fetchAll();
?>

<?php require "templates/header.php"; ?>


<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Search for Actor</h1>
    </div>
	
	<br><br>

    <form action="./searchActor.php" id="addform" method="post">
	
	<label for="actorID"> Actor </label>
	<select class="w3-select w3-border" name="actorID">
	 <?php foreach($actors as $actor): ?>
			<option value="<?= $actor['actorID']; ?>"><?= $actor['actName']; ?></option>
	 <?php endforeach; ?>
	 </select>
	 
    <input type="hidden" name="hide" value="1">

        <br><br>
        <input class="w3-btn w3-green" type="submit">
        <br><br>

    </form>
	
	<?php
	if (isset($_POST['hide'])) {
		

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
		
        

        $sql = "SELECT CONCAT( actor.actFN, ' ', actor.actLN) AS actName , movie.title, moviecast.role
				FROM actor LEFT JOIN moviecast ON moviecast.actorID = actor.actorID LEFT JOIN movie ON movie.movieID = moviecast.movieID
				WHERE actor.actorID = :actorID";
		$actorID = $_POST['actorID'];
        
        $statement = $connection->prepare($sql);
		$statement->bindParam(':actorID', $actorID, PDO::PARAM_STR);
        $statement->execute();
		
		$result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php  
if (isset($_POST['hide'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Roles</h2>

        <table class="w3-table-all" style="width:100%">
            <thead>
                <tr>
                    <th>Title</th>
					<th>Role</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["title"]); ?></td>
				<td><?php echo escape($row["role"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
	<br>
    <?php } else { 
        echo "No roles found";
     } 
} ?> 
</div>
</body>
