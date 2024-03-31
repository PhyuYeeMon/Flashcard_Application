<?php
	include "index.php";
	include "db/config.php";

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

		if($name == "")
		{
			$name_err = "Please Enter Name";
			$error = true;
		}

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
		else
		{
			$sql ="SELECT * FROM user WHERE email =:email";
			$statement = $connection->prepare($sql);
			$param = array(':email'=>$email);
			$statement->execute($param);
			$count = $statement->rowCount();
			if($count > 0)
			{
				$email_err ="Email has Already";
				$error = true;
			}

		}

		if($password == "")
		{
			$password_err = "Please Enter Password";
			$error = true;
		}

		if($conf_password == "")
		{
			$conf_password_err = "Please Enter Confirm Password";
			$error = true;
		}

		if($password !="" && $conf_password !="")
		{
			if($password != $conf_password)
			{
				$conf_password_err = "Password do not match";
				$error = true;
			}
		}

		if(!$error)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);
			try
			{
				$query="INSERT INTO user(username,email,password) VALUES(:username,:email,:password)";
				$statement = $connection->prepare($query);
				$param = array(':username'=>$name,':email'=>$email,':password'=>$password);
				$statement->execute($param);
				$success_msg = "Registration Successful.Please Login <a href='login.php'>here</a>";
				$password ="";
				$conf_password ="";
			}
			catch(Exception $e)
			{
				$err_msg = $e->getMessge();
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
		<h1>Registration</h1>
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
				<label for="name" class="form-label">Name</label>
				<input type="text" class="form-control" name="username" value="<?=$name?>"
					id="username" placeholder="Enter Name">
				<div class="text-danger input-err"><?= $name_err ?></div>
			</div>
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
			<div class="mb-3">
				<label for="conf_pass" class="form-label">Confirm Password</label>
				<input type="password" class="form-control" name="conf_pass" value="<?=$conf_password?>"
					id="conf_pass" placeholder="Enter Confirm Password">
				<div class="text-danger"><?= $conf_password_err ?></div>
			</div>
			<div class="form-check">
				<input class="form-check-input" name="" id="" type="checkbox" value="checkedvalue" onclick = "showPwd()">Show Password
			</div>
			<div class="text-center">
				<button type="submit" name="submit" class="btn btn-primary">Register</button>
			</div>
			<p>Already Register? Login <a href="login.php">here</a></p>
		</form>
	</div>

	<script>
		function showPwd()
		{
			var pwd = document.getElementById("pwd");
			var con_pass = document.getElementById("conf_pass");

			if(pwd.type === "text")
				pwd.type = "password";
			else
				pwd.type = "text";

			if(con_pass.type === "text")
				con_pass.type = "password";
			else
				con_pass.type = "text";
		}
	</script>
</body>
</html>