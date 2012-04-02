<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?= $title_for_layout ?></title>

	<link rel="stylesheet" type="text/css" href="<?= Router::url('/',true); ?>css/default.css" />

</head>

<body onload='window.print()'>
	
<?php echo $content_for_layout; ?>

</body>
</html>

