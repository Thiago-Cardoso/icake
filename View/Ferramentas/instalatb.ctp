<?php echo $this->Html->css('ferramentas'); ?>
<div id='instala'>

<?php echo $this->Form->create(null,array('id'=>'formInstala', 'url'=>Router::url('/',true).'ferramentas/instalatb')); ?>
<input type="hidden" name="data[Ferramenta][tipo]" id="tipo" />

<p class='txtFer'>
Clique em <strong>enviar</strong> para executar a instalação da aplicação exemplo.
<br />
<br />
<?php echo $this->Form->input('nome' ,array('div'=>null, 'label'=>'Nome Administrador', 'value'=>'ADMINISTRADOR')); ?>
<br /><br />
<?php echo $this->Form->input('email' ,array('div'=>null, 'label'=>'e-mail Administrador', 'value'=>'admin@admin.com.br')); ?>
<br /><br />
<?php echo $this->Form->input('login',array('div'=>null, 'label'=>'Login Administrador', 'value'=>'admin')); ?>
<br /><br />
<?php echo $this->Form->input('senha',array('div'=>null, 'label'=>'Senha Administrador', 'type'=>'password',)); ?>
<?php $this->viewVars['onRead'] .= '$("#FerramentaSenha").focus();'."\n"; ?>
<br /><br />
<?php echo $this->Form->input('senha2',array('div'=>null, 'label'=>'Confirme a senha', 'type'=>'password', )); ?>
</p>
<br /><br />

<div id='enviar'>
	<center>
		<input type='submit' name='btEnviar' value='Enviar' onclick='javascript: $("#instala").fadeOut(); $("#msg").fadeIn();' />
	</center>
</div>

</div>
<div id='msg' style='text-decoration: blink; display: none; text-align: center; margin: 50px auto; width: 500px;'>*** AGUARDE ***</div>
