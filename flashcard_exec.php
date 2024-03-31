<?php
session_start();
error_reporting(0);
include "db/config.php";

	if(isset($_POST['delete']))
	{
		$id = $_POST['delete'];

		try
		{
			$query="DELETE FROM flash_card WHERE id =:id";
			$param = array(':id'=>$id);
			$statement = $connection->prepare($query);
			$result = $statement->execute($param);
			if($result)
			{
				$_SESSION['message'] = 'Delete Successfully';
				header("location:flashcard_list.php");
				exit(0);
			}
			else
			{
				$_SESSION['message'] = 'Delete Unsuccessfully';
				header("location:flashcard_list.php");
				exit(0);
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessge();
		}
	}

	if(isset($_POST['save']))
	{
		$question = $_POST['question'];
		$answer = $_POST['answer'];
		$description = $_POST['description'];
		

		$query ="INSERT INTO flash_card(question,answer,description) VALUES(:question,:answer,:description)";
		$param = array(':question'=>$question,':answer'=>$answer,':description'=>$description);

		$statement = $connection->prepare($query);
		$result = $statement->execute($param);

		if($result)
		{
			$_SESSION['message'] = 'Save Successfully';
			header("location:flashcard_list.php");
			exit(0);
		}
		else
		{
			$_SESSION['message'] = 'Save Unsuccessfully';
			header("location:flashcard_list.php");
			exit(0);
		}

	}

	if(isset($_POST['update']))
	{
		$id = $_POST['update_id'];
		$question = $_POST['question'];
		$answer = $_POST['answer'];
		$description = $_POST['description'];

		$query ="UPDATE flash_card SET question=:question,answer=:answer,description=:description WHERE id=:id";
		$param = array(':question'=>$question,':answer'=>$answer,':description'=>$description,':id'=>$id);
		$statement = $connection->prepare($query);
		$result = $statement->execute($param);
		if($result)
		{
			$_SESSION['message'] = 'Update Successfully';
			header("location:flashcard_list.php");
			exit(0);
		}
		else
		{
			$_SESSION['message'] = 'Update Unsuccessfully';
			header("location:flashcard_list.php");
			exit(0);
		}
	}
?>