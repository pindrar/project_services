<!DOCTYPE html>
<html>
<head>
	<title><?php getTitle($request) ?></title>
</head>
<body>
	<?php 
	generateHeader($id_fpr);
	render($id_fpr,$opt,$val,$page);
	?>
</body>
</html>