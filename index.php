<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title> </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<style>
			a {
				padding:8px 16px;
				border:1px solid #ccc;
				color:#333;
				font-weight:bold;
			}
		</style>
    </head>
    <?php
		require "config.php";
		$member = new Member();
		$recordPerPage = 10;
		$page = '';
		if(isset($_GET["page"])) {
			$page = $_GET["page"];
		} else {
			$page = 1;
		}
		if(isset($_GET['firstname']) || isset($_GET['surname']) ) {
			$firstname = '';
			$surname = '';
			$email = '';
			if(isset($_GET['firstname'])) $firstname = $_GET['firstname'];
			if(isset($_GET['surname'])) $surname = $_GET['surname'];
			if(isset($_GET['email'])) $email = $_GET['email'];
			$filter = array(
				'firstname' => $firstname,
				'surname' => $surname,
				'email'  => $email
			);
			$teamMember = $member->getMember($filter);
			echo json_encode($teamMember);
		} else {
			$totalRecords = $member->getNumberOfMember();
			$startfFrom = ($page-1)*$recordPerPage;
			$teamMembers = $member->getMembers($recordPerPage, $startfFrom);
		}
		$membersSignUpByYear = $member->getMembersSingupByYear();
    ?>
    <body>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<?php if(isset($teamMembers)) { ?>
		<div class="container">
			<h3 align="center">Members List</h3><br />
			<div class="table-responsive">
			 <table class="table table-bordered">
				<tr>
					<td>ID</td>
					<td>Firstname</td>
					<td>Surname</td>
					<td>Email</td>
					<td>Gender</td>
					<td>Joined_date</td>
				</tr>
				<?php foreach($teamMembers as $teamMember) { ?>
				<tr>
					<td><?php echo $teamMember["id"]; ?></td>
					<td><?php echo $teamMember["firstname"]; ?></td>
					<td><?php echo $teamMember["surname"]; ?></td>
					<td><?php echo $teamMember["email"]; ?></td>
					<td><?php echo $teamMember["gender"]; ?></td>
					<td><?php echo $teamMember["joined_date"]; ?></td>
				</tr>
				<?php } ?>
			 </table>
			 <div align="center">
			 <br />
			 <?php
				$totalPages = ceil($totalRecords/$recordPerPage);
				$startLoop = $page;
				$difference = $totalPages - $page;
				if($difference <= 5) {
					$startLoop = $totalPages - 5;
				}
				$endLoop = $startLoop + 4;
				if($page > 1) {
					echo "<a href='index.php?page=1'>First</a>";
					echo "<a href='index.php?page=".($page - 1)."'><<</a>";
				}
				for($i=$startLoop; $i<=$endLoop; $i++) {
					echo "<a href='index.php?page=".$i."'>".$i."</a>";
				}
				if($page <= $endLoop) {
					echo "<a href='index.php?page=".($page + 1)."'>>></a>";
					echo "<a href='index.php?page=".$totalPages."'>Last</a>";
				}
			?>
				</div>
				<br /><br />
			   </div>
			</div>
		<?php } ?>
        <script>
			window.onload = function () {
				var data = '<?php echo json_encode($membersSignUpByYear); ?>';
				data = JSON.parse(data);
				var chart = new CanvasJS.Chart("chartContainer", {
					animationEnabled: true,

					title:{
						text:"Member Sign Up per Year"
					},
					axisX:{
						interval: 1,
						title: 'Year'
					},
					axisY2:{
						interlacedColor: "rgba(1,77,101,.2)",
						gridColor: "rgba(1,77,101,.1)",
						title: "Number of Sign Up"
					},
					data: [{
						type: "bar",
						axisYType: "secondary",
						color: "#014D65",
						dataPoints: data
					}]
				});
				chart.render();
			}
        </script>
    </body>
</html>
