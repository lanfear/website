<?php
/**
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>
<?php echo $this->element('global/html-start'); ?>
<?php echo $this->element('global/html-head'); ?>
<body>
	<div id="container">
		<?php echo $this->element('global/nav'); ?>
		<?php echo $this->element('global/header'); ?>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<?php echo $this->element('global/footer'); ?>
	</div>
	<?php echo $this->fetch('script'); ?>
</body>
<?php echo $this->element('global/html-end'); ?>