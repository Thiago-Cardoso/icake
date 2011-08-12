<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>

	<title><?php echo $title_for_layout; ?></title>

	<?php echo $this->Html->meta('icon'); ?>

	<?php echo $this->Html->css(mb_strtolower(SISTEMA)); ?>

	<?php echo $this->Html->script('/jcake/js/jquery-1.5.1.min')."\n"; ?>

	<script type="text/javascript">
	$(document).ready (function()
	{
		setTimeout(function(){ $("#msg").fadeOut(4000); },3000);
		<?php if ($this->name != 'CakeError') echo $this->Visao->getOnReadView(); ?>
	});
	</script>

	<?php echo $scripts_for_layout; ?>
</head>
<body>
<div id="corpo">
	<div id="cabecalho">
		<div id='sigla'>
			<a href='<?php echo Router::url('/',true); ?>'><?php echo SISTEMA; ?></a>
		</div>

		<div id="logocake">
			<a href='http://www.cakephp.org' target='_blanck'><img src="<?php echo Router::url('/',true); ?>img/cake.power.gif"   border="none" alt="" /></a>
			<a href='http://www.jquery.com'  target='_blanck'><img src="<?php echo Router::url('/',true); ?>img/jquery.power.gif" border="none" alt="" /></a>
		</div>

		<div id='menu'>
			<?php if ($this->Session->check('usuario.id')) echo $this->Html->link('administração',array('plugin'=>null,'controller'=>'cidades','action'=>'listar')); else echo $this->Html->link('login',array('plugin'=>null,'controller'=>'usuarios','action'=>'login')); ?>
		</div>

	</div>

	<div id="conteudo">
		<?php echo $content_for_layout; ?>
	</div>

</div>
<?php echo $this->element('sql_dump'); ?>

</body>
</html>
