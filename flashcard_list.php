<?php
	include "db/config.php";
	if(!isset($_SESSION) || session_id() == "" || session_start() === PHP_SESSION_NONE)
	{
		session_start();
	}
	error_reporting(0);
	
	$start = 0;
	$page_size = 5;
	$query ="SELECT * FROM flash_card";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$count = $statement->rowCount();
	$page_number = ceil($count / $page_size);
	if(isset($_GET['page-nr']))
	{
		$page = $_GET['page-nr'] - 1;
		$start = $page * $page_size;
	}

	$query ="SELECT * FROM flash_card LIMIT $start,$page_size";
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
	<script src="jquery/jquery.js"></script>
	<link href="css/flash_card_list.css" rel="stylesheet" type="text/css">
	
</head>
<body>
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
				<a href="books_page.php">Flash Card View</a>
			</li>
		</ul>
	</aside>

	<div class="content1">
		<h1>Flash Card List</h1>

		<!-- Insert Modal -->
		<div class="modal fade" id="insertdata" tabindex="-1" 
			aria-labelledby="insertdataLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      	<div class="modal-header">
			        <h1 class="modal-title fs-5" id="insertdataLabel">Add Flash Card</h1>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<form action="flashcard_exec.php" method="POST">
			      	<div class="modal-body">
				       	<div class="form-group mb-3">
				       		<label for="">Question For Front Side</label>
				       		<input type="text" name="question" class="form-control" placeholder="Enter Question">
				       	</div>
				       	<div class="form-group mb-3">
				       		<label for="">Answer For Back Side</label>
				       		<input type="text" name="answer" class="form-control" placeholder="Enter Answer">
				       	</div>
				       	<div class="form-group mb-3">
				       		<label for="">Description</label>
				       		<textarea class="form-control" name="description" placeholder="Enter Description"></textarea>
				       	</div>
			      	</div>
				    <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" name="save" class="btn btn-primary">Save
				        </button>
				    </div>
				</form>
		    </div>
		  </div>
		</div>
		<!-- END Modal -->

		<!-- Edit Modal -->
		<div class="modal fade" id="editdata" tabindex="-1" 
			aria-labelledby="editdataLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      	<div class="modal-header">
			        <h1 class="modal-title fs-5" id="editdataLabel">Edit Flash Card</h1>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<form action="flashcard_exec.php" method="POST">
			      	<div class="modal-body">
			      		<input type="hidden" name="update_id" id="update_id">
				       	<div class="form-group mb-3">
				       		<label for="">Question For Front Side</label>
				       		<input type="text" name="question" id="question" class="form-control" placeholder="Enter Question">
				       	</div>
				       	<div class="form-group mb-3">
				       		<label for="">Answer For Back Side</label>
				       		<input type="text" name="answer" id="answer" class="form-control" placeholder="Enter Answer">
				       	</div>
				       	<div class="form-group mb-3">
				       		<label for="">Description</label>
				       		<textarea class="form-control" name="description" 
				       		id="description" placeholder="Enter Description"></textarea>
				       	</div>
			      	</div>
				    <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				        <button type="submit" name="update" class="btn btn-primary">Update
				        </button>
				    </div>
				</form>
		    </div>
		  </div>
		</div>
		<!-- END Modal -->

		<div class="row">
			<div class="col-md-12 mt-4">
				<?php if(isset($_SESSION['message'])) : ?>
					<h5 class="alert alert-success"><?= $_SESSION['message']; ?>
					</h5>
				<?php 
					unset($_SESSION['message']);
					endif
				?>
				<div class="card">
					<div class="card-header" height="10%">
						<h1>
							<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#insertdata">Add Admin</button>
						</h1>
					</div>


					<div class="card-body">
						<table class="table table bordered table-striped">
							<thead>
								<tr>
									<th style="padding: 20px; font-size: 15px;">ID</th>
									<th style="padding: 20px; font-size: 15px;">Question</th>
									<th style="padding: 20px; font-size: 15px;">Answer</th>
									<th style="padding: 20px; font-size: 15px;">Description</th>
									<th style="padding: 20px; font-size: 15px;"  colspan="2">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if($result)
									{
										foreach($result as $row)
										{ 
								?>
								<tr>
									<td class="flashId" style="padding: 20px; font-size: 14px;">
										<?= $row['id'] ?></td>
									<td style="padding: 20px; font-size: 14px;">
										<?= $row['question'] ?></td>
									<td style="padding: 20px; font-size: 14px;">
										<?= $row['answer'] ?></td>
									<td style="padding: 20px; font-size: 14px;">
										<?= $row['description'] ?></td>
									
									<td colspan="2" style="padding: 20px;">
										<form action="flashcard_exec.php" method="POST">
											<a href="" class="btn btn-primary edit-data">Edit</a>
											<button type="submit" 
												name="delete" 
												value="<?= $row['id'];?>" class="btn btn-danger" style="font-size: 16px;">Delete
										</form>
									</td>
								</tr>

								<?php
										}
									}
									else
									{ 
								?>
									<tr>
										<td>
											<td colspan="4">No Record Found
										</td>
									</tr>
								<?php
									}
								?>
								
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
		<div class="page-info">
			<?php
				if(!isset($_GET['page-nr']))
				{
					$page = 1;
				}
				else
				{
					$page = $_GET['page-nr'];
				}
			?>
			Showing <?php echo $page ?> of <?=$page_number ?> pages

			<div class="pagi">
				<div class="pagination">
					<a href="?page-nr=1"><<</a>
					
					<div class="page-numbers">
						<?php
							for($i = 1;$i<=$page_number;$i++)
							{
						?>
								<a href="?page-nr=<?php echo $i?>"><?=$i ?></a>
						<?php
							}
						?>
					</div>
					<a href="?page-nr=<?php echo $page_number?>">>></a>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('.edit-data').click(function(e){
				e.preventDefault();
				$('#editdata').modal('show');
				$tr = $(this).closest('tr');
				var data = $tr.children("td").map(function(){
					return $(this).text();
				}).get();
				//console.log(data[1].trim());
				$('#update_id').val(data[0].trim());
				$('#question').val(data[1].trim());
				$('#answer').val(data[2].trim());
				$('#description').val(data[3].trim());
			})
		})
	</script>
</body>
</html>
	
