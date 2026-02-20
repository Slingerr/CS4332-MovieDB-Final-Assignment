<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */
	require "../config.php";
    require "../common.php";

    $pdo = new PDO($dsn, $username, $password, $options);



	$sql = "SELECT directorID, CONCAT(directFN, ' ', directLN) AS directName FROM director ORDER BY directName ASC";
	
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$directors = $stmt->fetchAll();
?>

<?php require "templates/header.php"; ?>


<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Search for director</h1>
    </div>
	
	<br><br>

    <form action="./searchDirector.php" id="addform" method="post">
	
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
		

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
		
        

        $sql = "SELECT CONCAT( director.directFN, ' ', director.directLN) AS directName , movie.title, movie.releastDate
				FROM director LEFT JOIN moviedirection ON moviedirection.directorID = director.directorID LEFT JOIN movie ON movie.movieID = movieDirection.movieID
				WHERE director.directorID = :directorID ORDER BY movie.releastDate ASC";
		$directorID = $_POST['directorID'];
        
        $statement = $connection->prepare($sql);
		$statement->bindParam(':directorID', $directorID, PDO::PARAM_STR);
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
        <h2>List of Directed Movies</h2>

        <table class="w3-table-all" style="width:100%">
            <thead>
                <tr>
                    <th>Title</th>
					<th>Released</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["title"]); ?></td>
				<td><?php echo escape($row["releastDate"]); ?></td>
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
