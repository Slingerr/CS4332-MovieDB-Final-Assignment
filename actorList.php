<?php require "templates/header.php"; 
      require "../config.php";
      require "../common.php";
?>
        



<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>Actor List</h1>
    </div>

    <br><br>

    <form action="./movieInfo.php" id="addform" method="post">

        <table class="w3-table-all" style="width:100%">
        <tr>
        <th>Name</th> <th>Gender</th> <th>Number of Movies </th> 
        </tr>
        

        <?php    
            $pdo = new PDO($dsn, $username, $password, $options);
            $sql = "SELECT CONCAT(actor.actFN, ' ', actor.actLN) AS actName, actor.gender, actor.actorID, COUNT(moviecast.actorID) AS MoviesIn 
					FROM actor LEFT JOIN moviecast ON moviecast.actorID = actor.actorID 
					GROUP BY actor.actorID ORDER BY actor.actLN ASC;";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$actors = $stmt->fetchAll();

			foreach($actors as $actor):
				echo "<tr>";
				echo "<td>$actor[actName]</td>";
				echo "<td>$actor[gender]</td>";
				echo "<td>$actor[MoviesIn]</td>";
				echo "</tr>";
			endforeach;

        ?>
        </table>
    </form>
</div>
</body>
</html>