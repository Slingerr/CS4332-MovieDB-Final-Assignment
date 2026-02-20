<?php require "templates/header.php"; ?>


<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Add New Actor/Director</h1>
    </div>
	

 <form action="./addActorDirector.php" id="addform" method="post">
  
  <br>

    <input class="w3-radio" type="radio" name="persontype" value="Actor" checked>
    <label>Actor</label>

    <input class="w3-radio" type="radio" name="persontype" value="Director">
    <label>Director</label>

    <br><br>




      <label>First Name</label>
        <input class="w3-input w3-border w3-round" type="text" name="firstname" form="addform">

        <label>Last Name</label>
        <input class="w3-input w3-border w3-round" type="text" name="lastname" form="addform">

        <br><br>

        <input class="w3-radio" type="radio" name="gender" value="M" checked>
        <label>Male</label>

        <input class="w3-radio" type="radio" name="gender" value="F">
        <label>Female</label>

        <br><br>
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
	
   $local_persontype=$_POST['persontype'];
   $local_gender=$_POST['gender'];
   $local_firstname=$_POST['firstname'];
   $local_lastname=$_POST['lastname'];

   if($local_lastname!="" && $local_firstname !=""){
    try  {
        $connection = new PDO($dsn, $username, $password, $options);
		
		if($local_persontype == "Director"){
			$sql = "INSERT INTO director (directFN, directLN) VALUES ('$local_firstname', '$local_lastname')";
		}else if($local_persontype == "Actor"){
			$sql = "INSERT INTO actor (actFN, actLN, gender) VALUES ('$local_firstname', '$local_lastname', '$local_gender')";
		}
        $statement = $connection->prepare($sql);
        $statement->execute();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
	
   echo $local_persontype . " " . $local_firstname . " " . $local_lastname . " was successfully add!";
   }else{
	   echo "Make sure all fields are filled out!";
   }
   
}
?>

