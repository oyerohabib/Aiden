<?php

// Include necessary files

require_once( 'sources/bootstrap.php' );

extract($_GET);

// Return json if an AJAX request was made
if( !empty($ajax) ){
	$res = '';
	foreach ($GLOBALS['EVENTS'] as $y => $p) {
		if( !$q || stripos($p['title'], $q)!==FALSE || stripos($p['description'], $q)!==FALSE || stripos($p['location'], $q)!==FALSE || stripos($p['organisers'], $q)!==FALSE ){
			$res .= "
<tr>
	<td>${p['title']}</td>
	<td>" . date_format(date_create($p['date']), 'd\t\h F, Y') . "</td>
	<td>" . date_format(date_create($p['time']), 'h:i A') . "</td>
	<td><a href=\"display.php?i=$y\">View Details</a></td>
</tr>";
		}
	}

	die($res);
}

?>
<!DOCTYPE html>
<html>
<head>
	<script src="assets/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/font-awesome.min.css" />

	<title>Event List</title>
</head>
<body>
	<div class="w-100 mx-auto p-4" style="max-width: 600px;">
		<h3>Search</h3>
		<hr class="mb-4" />
		<div class="d-flex align-items-center mb-5">
			<div class="flex-grow-1">
				<input id="filter" placeholder="Search" class="form-control" />
			</div>
			<span id="load" class="ml-3"></span>
		</div>

		<h3>Results</h3>
		<hr class="mb-4" />
		<table class="table">
			<tr>
				<th>Event Title</th>
				<th>Date</th>
				<th>Time</th>
				<th></th>
			</tr>
			<tbody class="p2">
				<?php
				// Loop through the events array
				foreach ($GLOBALS['EVENTS'] as $y => $e) {
					# code...
				?>
				<tr>
					<td><?= $e['title'] ?></td>
					<td><?= date_format(date_create($e['date']), 'd\t\h F, Y') ?></td>
					<td><?= date_format(date_create($e['time']), 'h:i A') ?></td>
					<td><a href="display.php?i=<?= $y ?>">View Details</a></td>
				</tr>
				<?php } ?>
				<tr class="h">
					<td colspan="4" align="center">
						<div class="p-3 alert alert-warning">
							Search result is empty, try changing your search phrase.
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		
		<br/>
		<center>
			<small>&copy; Taskii 2020</small>
		</center><br/><br/>

		<script type="text/javascript">
			$('#filter').on('keyup', function(){
				clearTimeout(window.cp);
				window.cp = setTimeout(function(){
					$('#load').html('<i class="fa fa-2x fa-refresh fa-spin text-secondary"></i>');
					$.get('?ajax=1&q='+$('#filter').val(), function( data, status ){
						$('#load').html('<i class="fa fa-2x fa-check-circle text-success"></i>');
						if( status=='success' ){
							$('.p2>tr:not(.h)').remove();
							$('.h').before(data);
						} else {
							$('#load').html('<i class="fa fa-2x fa-exclamation-circle text-danger"></i>');
						}
					});
				}, 500);
			});
		</script>

		<style type="text/css">
			.h {
				display: none;
			}

			.h:only-child {
				display: table-row;
			}
		</style>
	</div>
</body>
</html>