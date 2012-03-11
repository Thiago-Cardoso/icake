<?php 
	// TUDO EM UTF-8
	header('Content-Type: text/html; charset=utf-8');

	// SE NÃO ESTÁ LOGADO, CARCA FORA
	if($this->name!='Usuario' && $this->action!='login' && !$this->Session->check('Usuario'))
	{
		if($this->name!='Ferramentas' && !in_array($this->action,array('instalabd','instalatb')))
		{
			$sessaoId = $this->Session->check('Usuario.id') ? $this->Session->read('Usuario.id') : null;
			if (!$sessaoId)
			{
				if ($this->name!='CakeError') die('<script>document.location.href="'.Router::url('/',true).'usuarios/login"</script>');
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?= $title_for_layout ?></title>

	<link rel="stylesheet" type="text/css" href="<?= Router::url('/',true); ?>css/default.css" />

	<script type="text/javascript" src="<?= Router::url('/',true); ?>js/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="<?= Router::url('/',true); ?>js/jquery.maskedinput-1.3.min.js"></script>
	<script type="text/javascript" src="<?= Router::url('/',true); ?>js/default.js"></script>
	<?php if (isset($this->plugin)) : ?>
	<script type="text/javascript" src="<?= Router::url('/',true).strtolower($this->plugin).'/'; ?>js/<?= strtolower($this->name) ?>.js"></script>
	<?php else : ?>
	<script type="text/javascript" src="<?= Router::url('/',true); ?>js/<?= strtolower($this->name) ?>.js"></script>
	<?php endif ?>

	<script type="text/javascript">
	var url = '<?= Router::url('/',true) ?>';
	$(document).ready(function()
	{
		setTimeout(function(){ $("#flash").fadeOut(4000); },3000)
		<?php echo $this->viewVars['onRead']; ?>

	});
    </script>

	<?php echo $scripts_for_layout; ?>


	<?php if (isset($this->plugin)) : ?>
	<link rel="stylesheet" type="text/css" href="<?= Router::url('/',true).strtolower($this->plugin).'/'; ?>css/<?= strtolower($this->name) ?>.css" />
	<?php else : ?>
	<link rel="stylesheet" type="text/css" href="<?= Router::url('/',true); ?>css/<?= strtolower($this->name) ?>.css" />
	<?php endif ?>

	<?php if ($this->Session->check('Usuario')) : ?>

	<!-- menu chili com jQuery -->
	<script type="text/javascript" src="<?= Router::url('/',true); ?>js/menu_chili/chili.pack.js"></script>
	<script type="text/javascript" src="<?= Router::url('/',true); ?>js/menu_chili/menu.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= Router::url('/',true); ?>js/menu_chili/javascript.css" />
	<link rel="stylesheet" type="text/css" href="<?= Router::url('/',true); ?>js/menu_chili/menu.css" />
	<!-- fim menu chili com jQuery -->
	<?php endif ?>

</head>
<body>

<div id="corpo">

	<div id="cabecalho">
		<div id='titulo'>
			<a href='<?= Router::url('/',true); ?>'><?= $SIGLA.' - '.$EMPRESA ?></a>
		</div>

		<div id='menu_admin'>
			<?php if ($this->Session->check('Usuario')) : ?>
			<ul>
				<li><a href='<?= Router::url('/',true); ?>usuarios/info'><?= $this->Session->read('Usuario.login') ?></a></li>
				<li>|</li>
				<li><a href='<?= Router::url('/',true); ?>usuarios/sair'>sair</a></li>
			</ul>
			<?php else : ?>
			<ul>
				<li><a href='<?= Router::url('/',true); ?>usuarios/login'>Login</a></li>
			</ul>
			<?php endif ?>

		</div>

		<?php if ($this->Session->check('Message.flash')) : ?>
		<div id='flash'><?php echo $this->Session->flash(); ?></div>
		<?php endif ?>

		<?php if ($this->Session->check('Usuario')) : ?>

		<div id='tit_cadastro'><?= isset($tit_cadastro)?$tit_cadastro:$this->name ?></div>

		<?php echo $this->element('menu'); ?>

		<?php endif ?>

	</div>

	<div id="pagina">
		<?php echo $content_for_layout; ?>
	</div>

	<div id='rodape'>
		Copyright © <?= $EMPRESA ?>.<br />
		<!-- FAVOR NÃO REMOVER -->
		<a href='http://www.cakephp.org/' target='_blank'><img src='<?= Router::url('/',true); ?>img/cake.power.gif' border='0' /></a>
		&nbsp;&nbsp;&nbsp;
		<a href='http://www.jquery.com/' target='_blank'><img src='<?= Router::url('/',true); ?>img/jquery.power.gif' border='0'  /></a>
		&nbsp;&nbsp;&nbsp;
		<a href='http://www.mysql.com/' target='_blank'><img src='<?= Router::url('/',true); ?>img/mysql.power.gif' border='0'  /></a>
		<!-- -->
	</div>

</div>

<div id='sqlDump'>
	<?php echo $this->element('sql_dump'); ?>
</div>

</body>
</html>
