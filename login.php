<?php
	include "index.php";
	include "db/config.php";
	if(!isset($_SESSION) || session_id() == "" || session_start() === PHP_SESSION_NONE)
	{
		session_start();
	}
	
	$name=$email=$password=$conf_password="";
	$name_err=$email_err=$password_err=$conf_password="";
	$success_msg = $err_msg ="";
	$error = false;
	if(isset($_POST["submit"]))
	{
		$name = trim($_POST['username']);
		$email = trim($_POST['email']);
		$password = trim($_POST['pwd']);
		$pass= trim($_POST['pwd']);
		$conf_password = trim($_POST['conf_pass']);

		if($email == "")
		{
			$email_err = "Please Enter Email";
			$error = true;
		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			$email_err = "Invalid Email Format";
			$error = true;
		}

		if($password == "")
		{
			$password_err = "Please Enter Password";
			$error = true;
		}
		
		if(!$error)
		{
			$sql ="SELECT * FROM user WHERE email =:email";
			$statement = $connection->prepare($sql);
			$param = array(':email'=>$email);
			$statement->execute($param);
			$count = $statement->rowCount();
			if($count > 0)
			{
				$row = $statement->fetch();
				$pass = $row['password'];
				if(password_verify($password,$pass))
				{
					$_SESSION["name"] = $row['username'];
					header('location:flashcard_list.php');
				}
				else
				{
					$err_msg ="Incorrect Password";
				}
			}
			else
			{
				$err_msg ="Email is not registered";
			}
		}

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
	<link href="css/reg.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container">
		<h1>Login</h1>
		<div class="show_msg">
			<?php
				if(!empty($success_msg)){
			?>
				<div class="alert alert-success">
					<?= $success_msg ?>
				</div>
			<?php }
			?>
			<?php
				if(!empty($err_msg)){
			?>
				<div class="alert alert-danger">
					<?= $err_msg ?>
				</div>
			<?php }
			?>
		</div>	
		<form action="" method="POST">
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input type="text" class="form-control" name="email" value="<?=$email?>"
					id="email" placeholder="Enter Email">
				<div class="text-danger input-err"><?= $email_err ?></div>
			</div>
			<div class="mb-3">
				<label for="pwd" class="form-label">Password</label>
				<input type="password" class="form-control" name="pwd" value="<?=$password?>"
					id="pwd" placeholder="Enter Password">
				<div class="text-danger input-err"><?= $password_err ?></div>
			</div>
			<div class="text-center">
				<button type="submit" name="submit" class="btn btn-primary">Login</button>
			</div>
			<p>Not Registerd? Register <a href="register.php">here</a></p>
		</form>
	</div>

</body>
</html>

