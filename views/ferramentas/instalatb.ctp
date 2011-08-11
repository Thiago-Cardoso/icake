<?php $this->Visao->setOnReadView('$("#FerramentaNome").focus();'); ?>
<div id='instala'>

<?php echo $this->Form->create(null,array('url'=>Router::url('/',true).'ferramentas/instalatb')); ?>
<input type="hidden" name="data[Ferramenta][tipo]" id="tipo" />

<p class='txtFer'>
Clique em <strong>enviar</strong> para executar a instalação da aplicação exemplo.
<br />
<br />
<?php echo $this->Form->input('nome' ,array('div'=>null, 'label'=>'Nome Administrador')); ?>
<?php echo $this->Form->input('email' ,array('div'=>null, 'label'=>'e-mail Administrador')); ?>
<?php echo $this->Form->input('login',array('div'=>null, 'label'=>'Login Administrador', 'value'=>'admin')); ?>
<?php echo $this->Form->input('senha',array('div'=>null, 'label'=>'Senha Administrador', 'type'=>'password')); ?>
<?php echo $this->Form->input('senha2',array('div'=>null, 'label'=>'redigite a senha', 'type'=>'password')); ?>
</p>
<br /><br /><br /><br /><br /><br />

<div id='enviar'>
<center><?php echo $this->Form->end('Enviar'); ?></center>
</div>

<div id='msg' style='color: green; font-weight: bold; margin: 0px 0px 50px 0px;'>
<?php if (isset($msg)) echo $msg; $this->Visao->setOnReadView('setTimeout(function(){ $("#msg").fadeOut(4000); },3000);'); ?>
</div>

</div>
