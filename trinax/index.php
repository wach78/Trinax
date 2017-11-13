<?php
require_once ('src/view.php');
require_once ('src/callapi.php');
$apicalls = new callapi();
$view = new view();
?>
<!DOCTYPE html>
<html>
	<head> 
		<meta charset="UTF-8">
		<link href = "https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
		<link href = "css/main.css" rel = "stylesheet">
		<title>Christer Vadman</title>
	
	
	</head>
	
	<body>
	

	
	<div id="tabs">
	
		<ul>
		    <li><a href="#listTR">Lista tidsrapporter</a></li>
		    <li><a href="#createTR">Skapa tidsrapporter</a></li>
		</ul>
	

		<div id="listTR">
		<?php
			$view->showFilterFrm();
		?>
		<div id="tbllistTRplaceholder">
			
		</div>
		
		</div>
	
		<div id="createTR">
		
			<?php 
			
			$view->showCreateTimeReporteFrm();
			
			?>
		
		</div>
	
	</div> <!-- tabs -->
	

 

	
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" ></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	
	
	<script src="js/main.js"></script>
	
	<script>
	
	</script>
	</body>
</html>