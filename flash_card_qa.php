<?php
	include "db/config.php";
	if(!isset($_SESSION) || session_id() == "" || session_start() === PHP_SESSION_NONE)
	{
		session_start();
	}
	error_reporting(0);
	
	$query ="SELECT * FROM flash_card";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewpoint" content="width=device-width,initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<link href="css/flash_card_qa.css" rel="stylesheet" type="text/css">

</head>
<body onload="move('element')">
	<header>
		<nav>
			<label class="logo">Flash Card Application</label>
			<ul>
				<?php
					if(isset($_SESSION["name"]))
					{
				?>
						<li><span>Welcome <?=$_SESSION["name"] ?></span>&nbsp;&nbsp;<a href="logout.php">Logout</a></li>
				<?php
					}
				?>
			</ul>
		</nav>
	</header>
	

	<aside>
		<ul>
			<li>
				<a href="flashcard_list.php">Flash Card List</a>
			</li>
			<li>
				<a href="flash_card_qa.php">Flash Card View</a>
			</li>
		</ul>
	</aside>

	<div class="content1">
		<h1>Flash Card Q&A</h1>
		<main class="main-result wrapper" aria-label="flash card container">
			<?php
				$card =null;
				foreach ($result as $value) 
				{
					$question = $value['question'];
					$answer = $value['answer'];
					$card.="<div class='card' tabIndex='0'>
								<div class='card-front'>
									{$question}
								</div>
								<div class='card-back'>
									{$answer}
								</div>
							</div>";
				}
				echo $card;
			?>
		</main>
	</div>
	
</body>
</html>
	
