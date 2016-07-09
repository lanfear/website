<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Nosifer+Caps" />
	<?php
		echo $this->Html->meta('icon');

		echo $this->element('global/css');

		echo $this->element('global/js');

		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
</head>
