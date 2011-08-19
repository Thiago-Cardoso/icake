<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>

	<title><?php if(isset($titulo)) echo $titulo; else echo $this->name.' - '.$this->action; ?></title>

	<?php echo $this->Html->meta('icon'); ?>

	<?php echo $this->Html->css('/jcake/css/jcake_layout.css'); ?>

	<?php echo $this->Html->script('/jcake/js/jquery-1.5.1.min')."\n"; ?>
	<?php echo $this->Html->script('/jcake/js/jquery.maskedinput-1.1.4.pack')."\n"; ?>
	<?php echo $this->Html->script('/jcake/js/jcake')."\n"; ?>
	<?php echo $this->Html->script('tiny_mce/tiny_mce_src')."\n"; ?>
	<?php if ($this->Session->check('usuario.id')) 
	{
		echo $this->Html->script('countdown/jquery.countdown.js')."\n";
		echo "\t".$this->Html->script('countdown/jquery.countdown-pt-BR.js')."\n";
	}
	?>

	<script type="text/javascript">
	var url = "<?php echo Router::url('/',true); ?>";
	$(document).ready (function()
	{
		<?php if (isset($tempoOn)) : ?>

		$("#regressivo").countdown({until: <?php echo $tempoOn; ?>, format: "MS"});
		setTimeout(function () { window.location='<?php echo Router::url('/',true).'usuarios/login'; ?>' }, <?php echo ($tempoOn*1000) ?>);
		<?php endif; ?>

		setTimeout(function(){ $("#flashMessage").fadeOut(4000); },3000);
		$("#ferramentas img").hover(function() { $(this).css("background-color","#5277AA") }).mouseout(function() { $(this).css("background-color","transparent") }) ;
		<?php echo $this->Visao->getOnReadView(); ?>
	});
	<?php if (in_array($this->action,array('editar','novo','excluir'))) : ?>
	tinyMCE.init({
		// Opções gerais
		language : "pt",
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Opções do tema
		theme_advanced_buttons1: "code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,cleanup,link,unlink,image,table,formatselect,fontselect,fontsizeselect,forecolor,backcolor,fullscreen",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		});
	<?php endif; ?>

	</script>

	<?php echo $scripts_for_layout; ?>

</head>
<body>
<div id="corpo">

	<div id="cabecalho">
		<?php echo $this->Session->flash(); ?>

		<?php if (isset($tempoOn)) : ?>
		<div id="contador">
			<span id='cTxt'>sua sessão expira em</span><span id="regressivo"></span>
		</div>
		<?php endif ?>

		<div id='sigla'>
			<a href='<?php echo Router::url('/',true); ?>'><?php echo SISTEMA; ?></a>

			<?php if (isset($this->name)) : ?> :: <a href="<?php echo mb_strtolower(Router::url('/',true).$this->name); ?>" ><?php echo isset($linkTit[1]) ? $linkTit[1] : ucfirst($this->name); ?></a><?php endif ?>
			<?php if ($this->action == 'index') $linkTit[2] = 'Principal'; ?>
			<?php if (isset($this->action)) : ?> :: <a href="<?php echo mb_strtolower(Router::url('/',true).$this->name.'/'.$this->action); ?>" ><?php echo isset($linkTit[2]) ? $linkTit[2] : ucfirst($this->action); ?></a><?php endif ?>

		</div>

		<?php if ($this->Session->check('usuario')) : ?>
		<div id='ferramentas'>
			<?php if (in_array('ADMINISTRADOR',$meusperfis)) : ?>
			<a href='<?php echo Router::url('/',true).'ferramentas'; ?>' title='Clique aqui para acessar ferramentas'><img id='ferFer' src='<?php echo Router::url('/',true).'img/bt_ferramentas.png'; ?>' border='0' /></a>
			<?php endif; ?>
			<a href='<?php echo Router::url('/',true).'relatorios'; ?>'  title='Clique aqui para acessar relatórios'> <img id='ferRel' src='<?php echo Router::url('/',true).'img/bt_relatorios.png'; ?>'  border='0' /></a>
		</div>

		<div id='menu'>
			<?php if (file_exists(APP.'views/elements/menu_modulos.ctp'))
				include_once(APP.'views/elements/menu_modulos.ctp'); 
			else 
				echo 'menu admin não encontrado em '.APP.'views/elements/menu_modulos.ctp';
			?>
		</div>

		<div id='menuLogin'>
			<a href='<?php echo Router::url('/',true).'usuarios/info'; ?>'><?php echo $this->Session->read('usuario.login'); ?></a>
			<a href='<?php echo Router::url('/',true).'usuarios/sair'; ?>'>sair</a>
		</div>
		<?php endif; ?>

		<div id='logocake'>
			<a href='http://www.cakephp.org' target='-blanck'><img src="<?php echo Router::url('/',true); ?>/jcake/img/cake.power.gif" border="none" alt="" /></a>
			<a href='http://www.jquery.com' target='-blanck'><img src="<?php  echo Router::url('/',true); ?>/jcake/img/jquery.power.gif" border="none" alt="" /></a>
		</div>

	</div>

	<div id="conteudo">
		<?php echo $content_for_layout; ?>

	</div>

</div>

<div id='sqlDump'>
<?php echo $this->element('sql_dump'); ?>

</div>

</body>
</html>
