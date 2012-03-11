<form action='<?= Router::url('/',true); ?>usuarios/autenticar' method='post' />

<div id='login'>
	<label>Login</label><input type='text' 		id='ed_login' name='form[ed_login]' />
	<?php $this->viewVars['onRead'] .= '$("#ed_login").focus();'."\n"; ?>
	<br />
	<label>Senha</label><input type='password' 	id='ed_senha' name='form[ed_senha]' />
	<br />
</div>

<div id='login_botoes'>
	<input type='submit' name='btEnviar' id='btEnviar' value='Enviar' />
</div>

</form>
