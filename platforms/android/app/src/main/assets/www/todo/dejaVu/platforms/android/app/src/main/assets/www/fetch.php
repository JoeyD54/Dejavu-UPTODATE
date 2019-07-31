<?php
session_start();
$list_id = $_SESSION['list_id'];

	/* count total number of tasks */
		$query = "SELECT COUNT(task_id) FROM task WHERE list_id = '$list_id'";
		$total = mysqli_query($link, $query );
		$totalNum = mysqli_fetch_array($total);
		//echo "$totalNum[0] : Total tasks<br/>"; *for testing 
	/* count pending tasks */
		$query = "SELECT COUNT(task_id) FROM task WHERE list_id = '$list_id' AND status = 1";
		$pend = mysqli_query($link, $query);
		$pendNum = mysqli_fetch_array($pend);
		if($pendNum[0]==NULL){$pendNum = '0';} // if no tasks with status exist set to 0
		//echo "$pendNum[0] : Pending tasks<br/>"; *for testing
	/* count started tasks */
		$query = "SELECT COUNT(task_id) FROM task WHERE list_id = '$list_id' AND status = 2";
		$started = mysqli_query($link, $query);
		$startedNum = mysqli_fetch_array($started);
		if($startedNum[0]==NULL){$startedNum = '0';} 
		//echo "$startedNum[0] : Started tasks<br/>"; *for testing
	/* count completed tasks */
		$query = "SELECT COUNT(task_id) FROM task WHERE list_id = '$list_id' AND status = 3";
		$compl = mysqli_query($link, $query);
		$complNum = mysqli_fetch_array($compl);
		if($complNum[0]==NULL){$complNum = '0';} 
		//echo "$complNum[0] : Completed tasks<br/>"; *for testing
	/* count late tasks */
		$query = "SELECT COUNT(task_id) FROM task WHERE list_id = '$list_id' AND status = 4";
		$late = mysqli_query($link, $query);
		$lateNum = mysqli_fetch_array($late);
		if($lateNum[0]==NULL){$lateNum = '0';} 
		//echo "$lateNum[0] : Late tasks<br/>"; *for testing
	
	
?>