<?php ?>
<style>
	#newsletter
	{
		margin: 10px auto;
		width: 80%;
	}
	.labelGrupos
	{
		margin: 0px 10px 0px 10px;
	}
	.inputPara
	{
		width: 647px;
	}
	#newsletter fieldset
	{
		width: 627px;
		-moz-border-radius: 6px;
		-webkit-border-radius: 6px;
		border-radius: 6px;
	}
	#btEnviar
	{
		width: 120px;
	}
</style>
<div id='newsletter'>
	<form name='formNews' action='<?= $this->here ?>/../enviar_msg' method='post'>
	
	<div class='registro'>
	<label>Para</label><?php echo $this->Form->input('Para',array('class'=>'inputPara','format'=>array('input'))); ?>
	<p style="margin: 0px; padding: 0px;">Use "," (vírgula) para separar os e-mails.</p>
	</div>
	<br />
	
	<div class='registro'>
	<?php echo $this->Form->input('Para(grupos)',array('fieldset'=>false,'class'=>'labelGrupos','type'=>'radio', 'options'=>$grupos)); ?>
	<p style="margin: 0px; padding: 0px;">Escolha um grupo de e-mail para enviar a mensagem.</p>
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
