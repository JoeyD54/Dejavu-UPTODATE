<?php
include('config.php');
include('fetch.php');

//session_start();
	if($_SESSION['auth']=='true'){
		$username = $_SESSION['username'];
		$list_id = $_SESSION['list_id'];
	}
	else{
		header("location: index.php");
	}
?>
<html>
	<head>
		<title>Todo List</title>
		<script type="text/javascript">
			function edit_task(id){
				if(confirm('Edit task?')){
					window.location.href='edit_task.php?edit_task_id='+id;
				}
			}
			function delete_task(id){
				if(confirm('Delete task?')){
					window.location.href='home.php?delete_task_id='+id;
				}
			}
		</script>
	</head>
	
	<body>
	<!-- Logout -->
		<a href="logout.php"> Logout </a></br>
		<h2>Todo List Dashboard</h2>
		<h4>Welcome <?php echo $username?>!</h4>
		
	<!-- Display Task Overview -->
		<table class="data-table">
			<caption class="title">Task Overview</caption>
			<thead>
				<tr>
					<th>Status</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $totalNum[0] ?></td>
					<td>Total</td>
				</tr>
				<tr>
					<td><?php echo $lateNum[0] ?></td>
					<td>Late</td>
				</tr>
				<tr>
					<td><?php echo $pendNum[0] ?></td>
					<td>Pending</td>
				</tr>
				<tr>
					<td><?php echo $startedNum[0] ?></td>
					<td>Started</td>
				</tr>
				<tr>
					<td><?php echo $complNum[0] ?></td>
					<td>Completed</td>
				</tr>
			</tbody></table>
	<!-- Delete task code -->
		<?php
			if(isset($_GET['delete_task_id'])){
				$query = "DELETE FROM task WHERE task_id=".$_GET['delete_task_id'];
				mysqli_query($link, $query);
				header("Location: home.php");
			}
		?>

	<!-- Add task form -->
		<h4>Add Task</h4>
		<form action="add_task.php" method="post"> 
		<input type="text" name="task_name" placeholder="Task Name"required="required"></input><br> 
		<input type="date" name="due_date"required="required"></input><br>
		<label>Task Status</label>
		<select name= status_list id = "status_list" required="required">
			<option value = "1">Pending</option>
			<option value = "2">Started</option>
			<option value = "3">Completed</option>
			<option value = "4">Late</option>
		</select><br>
		<input type="submit" name="enter" value="Add Task"</input><br>
		</form>
		
	
		
	<!-- Display Task Table -->
		<h4>Todo List</h4>
		<!-- Filter Tasks Option -->
		<form action="home.php" method="POST">
			<label>Filter status</label>
			<select name="status_filter" id = "status_filter">
				<option value"all" >All</option>
				<option value"pending">Pending</option>
				<option value"started">Started</option>
				<option value"late">Late</option>
				<option value"completed">Completed</option>
			</select>
			<input type="submit" name="filter_button"></input><br>
		</form>
		
		<!-- Tasks Table -->
		<table class="data-table">
			<caption class="title">Todo List</caption>
			<thead>
				<tr>
					<th>Task ID</th>
					<th>Task Name</th>
					<th>Due Date</th>
					<th>Status</th>
					<th>Edit Status</th>
				</tr>
			</thead>
			<tbody>
		<!-- Get table data -->
			<?php // may be able to place in separate .php file
		/* fetch todo list from db with filter handling */
			/* Filter tasks */
			if(isset($_REQUEST['status_filter'])){
				$filter = $_POST['status_filter'];
				if($filter == 'Pending' || $filter == 'Started' || $filter == 'Completed' || $filter == 'Late'){
					$filter_query = "SELECT task_id, task_name, due_date, status FROM task WHERE status = '$filter' ORDER BY due_date";
				}
				else {
					$filter_query = "SELECT task_id, task_name, due_date, status FROM task WHERE '$list_id' ORDER BY due_date";
				}
				//echo "Status filter = " . "$filter"."<br>";
				//echo "Is set works";
			}
			else{
				//echo "default filter set<br>";
				//echo "List id: ".$_SESSION['list_id'];
				$filter_query = "SELECT task_id, task_name, due_date, status FROM task WHERE list_id = '$list_id' ORDER BY due_date";
			}
			$result = mysqli_query($link, $filter_query);
			while($row = mysqli_fetch_array($result)){
			/* Set task to late if past due */
				$date = date('Y-m-d H:i:s', time()); // current date
				if($row['due_date'] < $date){
					$changeStatus = "UPDATE task SET status = 4 WHERE due_date < '$date'";
					mysqli_query($link, $changeStatus);
				}
			?>
		<!-- Populate table fields -->	
				<tr>
				<td><?php echo $row['task_id'];?></td>
				<td><?php echo $row['task_name'];?></td>
				<td><?php echo date('m-d-y', strtotime($row['due_date']));?></td>
				<td><?php echo $row['status'];?></td>
				<td align="center"><a href="javascript:edit_task('<?php echo $row[0]; ?>')"><img src="edit.png" align="EDIT" /></a></td>
				<td align="center"><a href="javascript:delete_task('<?php echo $row[0]; ?>')"><img src="delete.png" align="DELETE" /></a></td>
				</tr>
				<?php
			} // close while loop
			?>
			</tbody></table>
	</body>
</html>