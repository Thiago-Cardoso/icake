<br /><br />
<div id='instala'>
<center>
<?php echo $this->Form->create(null,array('url'=>Router::url('/',true).'ferramentas')); ?>
	
<?php echo $this->Form->input('tipo',array('id'=>'tipo','type'=>'hidden')); ?>

<p class='txtFer'>
Clique aqui para resetar todo o cache.<br />
<?php echo $this->Form->button('Limpar Cache',array('onclick'=>'$(\'#tipo\').val(\'limparCache\'); ','style'=>'width: 400px;')); ?>
</p>

<?php echo $this->Form->end(); ?>
<br />
<br />
<br />
<div id='msg' style='color: green; font-weight: bold; margin: 0px 0px 50px 0px;'>
<?php if (isset($msg)) echo $msg; $this->Visao->setOnReadView('setTimeout(function(){ $("#msg").fadeOut(4000); },3000);'); ?>
</div>

</center>
</div>
