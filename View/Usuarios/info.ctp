<?php $this->viewVars['tit_cadastro'] = 'Usuários'; ?>
<div id='info'>
	<div id='dadosUsuario'>
	<p class='tit'>
		<?php
			if ($this->Session->read('Usuario.perfil') == 'ADMINISTRADOR')
				echo $this->Html->Link('fechar', array('controller'=>'usuarios', 'action'=>'listar', null) );
			else
				echo $this->Html->Link('fechar', array('controller'=>'usuarios', 'action'=>'editar/'.$this->Session->read('Usuario.id'), null ) );
		?>
	</p>
	<center><h2>Usuário</h2></center>
		<?php 
			$data = $this->Session->read('Usuario');
			$data['Restricoes'] = array('F','G','I');
			foreach($data as $_campo => $_valor)
			{
				switch($_campo)
				{
					case 'ultimo':
						if ($_valor!='0000-00-00 00:00:00') echo '<label>Último Acesso: </label> '.date('d/m/Y h:i:s',mktime(substr($_valor,11,2), substr($_valor,14,2), substr($_valor,17,2), substr($_valor,5,2), substr($_valor,8,2), substr($_valor,0,4) )).'<br /><br />';
						break;
					case 'Restricoes':
						if (count($_valor))
						{
							$opcoes_restricao = Configure::read('RESTRICOES');
							echo '<label>Restrições: </label>';
							foreach($_valor as $_letra) echo $opcoes_restricao[$_letra].', ';
							echo '<br /><br />';
						} else echo 'não veio nada<br />';
						break;
					case 'Perfis':
						if (count($_valor))
						{
							echo '<label>Perfis: </label>';
							foreach($_valor as $_perfil) echo $_perfil.', ';
							echo '<br /><br />';
						}
						break;
					default:
						if (!in_array($_campo,array('id','trocar')) && !empty($_valor)) echo '<label>'.ucfirst($_campo).': </label> '.$_valor.'<br /><br />';
				}
			}
			?>
	</div>
</div>
