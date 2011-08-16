<?php echo $this->Html->css('principal'); ?>
<div id='info'>
	<div id='dadosUsuario'>
	<center><a href='<?php echo Router::url('/',true).'usuarios/editar/'.$this->Session->read('usuario.id'); ?>'>editar</a></center>
	<center><h2>Usuário</h2></center>
		<?php 
			$data = $this->Session->read('usuario');
			foreach($data as $_campo => $_valor)
			{
				switch($_campo)
				{
					case 'ultimo':
						if ($_valor!='0000-00-00 00:00:00') echo '<label>Último Acesso: </label> '.$this->Time->format('d/m/Y h:i:s',$_valor).'<br /><br />';
						break;
					default:
						if (!in_array($_campo,array('id','trocar')) ) echo '<label>'.$_campo.': </label> '.$_valor.'<br /><br />';
				}
			}
			?>
	</div>

	<div id='dadosPerfil'>
		<center><h2>Perfis</h2></center>
		<?php $data = $this->Session->read('meusperfis'); foreach($data as $_valor) echo ' - <strong>'.$_valor.'</strong><br />'; ?>
	</div>

</div>
