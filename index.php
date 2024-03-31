<?php
	if(!isset($_SESSION) || session_id() == "" || session_start() === PHP_SESSION_NONE)
	{
		session_start();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewpoint" content="width=device-width,initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body background="images/flashcard_2.jpg" class="body_deg">
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
				else
				{
			?>
					<li><a href="index.php">Home</a></li>
					<li><a href="register.php">Register</a></li>
					<li><a href="login.php">Login</a></li>
			<?php		
				}
			?>
			
		</ul>
	</nav>
</body>
</html>
	
