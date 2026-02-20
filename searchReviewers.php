<?php require "templates/header.php"; 
      require "../config.php";
      require "../common.php";
?>
        



<div class="w3-container w3-card-2" style="margin-left:26%">
    <div class="w3-container w3-card-2 w3-teal">
        <h1>User List</h1>
    </div>

    <br><br>

    <form action="./movieInfo.php" id="addform" method="post">

        <table class="w3-table-all" style="width:100%">
        <tr>
        <th>Username</th> <th>Number of Reviews </th> 
        </tr>
        

        <?php    
            $pdo = new PDO($dsn, $username, $password, $options);
            $sql = "SELECT reviewer.username, COUNT(rating.reviewerID) AS numReviews 
					FROM reviewer LEFT JOIN rating ON rating.reviewerID = reviewer.reviewerID 
					GROUP BY reviewer.reviewerID ORDER BY reviewer.reviewerID DESC;";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$actors = $stmt->fetchAll();

			foreach($actors as $actor):
				echo "<tr>";
				echo "<td>$actor[username]</td>";
				echo "<td>$actor[numReviews]</td>";
				echo "</tr>";
			endforeach;

        ?>
        </table>
    </form>
</div>
</body>
</html>