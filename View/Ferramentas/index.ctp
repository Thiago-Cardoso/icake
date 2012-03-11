<?php ?>
<br /><br />
<div id='instala'>
<center>
<?php echo $this->Form->create(null,array('url'=>Router::url('/',true).'ferramentas')); ?>
	
<?php echo $this->Form->input('tipo',array('id'=>'tipo','type'=>'hidden')); ?>
<!--
<p class='txtFer'>
Clique aqui para resetar todo o cache.
<?php echo $this->Form->button('Limpar Cache',array('onclick'=>'$(\'#tipo\').val(\'limparCache\'); ','style'=>'width: 140px;')); ?>
</p>
-->
<p class='txtFer'>
Digite o nome do plugin a ser instalado:<br /><br />
<?php echo $this->Form->button('Instalar Plugin',array('onclick'=>'$(\'#tipo\').val(\'instalarPlugin\'); ','style'=>'width: 140px;')); ?>
<input type='text' name='plugin' id='plugin' value='<?= isset($nomePlugin) ? $nomePlugin : ''; ?>' style='float: left; width: 270px;'/>
</p>

<?php echo $this->Form->end(); ?>
<br />
<br />
<br />
</center>
</div>

<center>
<div id='msg' style='float: left; color: green; font-weight: bold; position: absolute; left: 50%; margin-left: -480px; width: 900px;'>
<?php if (isset($msg)) echo $msg; $this->viewVars['onRead'] = 'setTimeout(function(){ $("#msg").fadeOut(4000); },3000);'."\n"; ?>
</div>
</center>
