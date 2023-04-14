<?php
if(isset($_GET['file']))
{
	$file = $_GET['file'];

		header('Content-Type: application/pdf');
		header("Content-Disposition: attachment; filename=\"$file\"");
		readfile($file);

}
?>