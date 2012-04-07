<?php ?>
<style>
	#newsletter
	{
		margin: 10px auto;
		width: 80%;
	}
</style>
<div id='newsletter'>
	<form name='formNews' action='' method='post'>
	
	<div class='registro'>
	<?php echo $this->Form->input('Para',array('type'=>'radio', 'options'=>$grupos)); ?>
	</div>
	<br />
	<div class='registro'>
	<label>Mensagem</label><br />
	<?php echo $this->Form->input('Mensagem',array('format'=>array('input'), 'type'=>'textarea','cols'=>90,'rows'=>10)); ?>
	</div>
	<br />
	<input type='submit' name='btEnviar' id='btEnviar' value='Enviar' />
	</form>
</div>
