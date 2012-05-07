<?php
	$campos['Usuario']['login']['tit'] 						= 'Login';

	$campos['Usuario']['ativo']['tit'] 						= 'Ativo';
	$campos['Usuario']['ativo']['th']['width']				= '50px';
	$campos['Usuario']['ativo']['td']['align']				= 'center';
	$campos['Usuario']['ativo']['input']['default']			= 1;
	$campos['Usuario']['ativo']['input']['options']			= array('1'=>'Sim', '0'=>'Não');

	$campos['Usuario']['trocar_senha']['tit'] 				= 'Trocar a Senha';
	$campos['Usuario']['trocar_senha']['input']['options']	= array('1'=>'Sim', '0'=>'Não');
	$campos['Usuario']['trocar_senha']['input']['default']	= 0;
	
	$campos['Usuario']['nome']['tit'] 						= 'Nome';
	$campos['Usuario']['nome']['input']['style']			= 'width: 500px; text-transform:uppercase;';

	$campos['Usuario']['email']['tit'] 						= 'e-mail';
	$campos['Usuario']['email']['input']['style']			= 'width: 500px; text-transform:lowercase;';

	$campos['Usuario']['celular']['tit'] 					= 'Celular';
	$campos['Usuario']['celular']['mascara'] 				= '(99)9999-9999';
	$campos['Usuario']['celular']['input']['style']			= 'width: 99px;';

	$campos['Usuario']['senha']['tit'] 						= 'Senha';
	$campos['Usuario']['senha']['input']['type']			= 'password';

	$campos['Usuario']['senha2']['tit'] 					= 'Repita a senha';
	$campos['Usuario']['senha2']['input']['type']			= 'password';


	$campos['Usuario']['cidade_id']['tit'] 					= 'Cidade';
	$campos['Usuario']['cidade_id']['input']['empty']		= '-- Escolha uma Cidade --';
	$campos['Usuario']['cidade_id']['input']['style']		= 'width: 500px;';
	$campos['Usuario']['cidade_id']['input']['default']		= 2302;

	$campos['Usuario']['estado_id']['tit'] 					= 'Estado';
	$campos['Usuario']['estado_id']['input']['empty']		= '-- Escolha um Estado --';
	$campos['Usuario']['estado_id']['input']['style']		= 'width: 500px;';
	$campos['Usuario']['estado_id']['combo'] 				= array('Usuario.cidade_id','cidades');
	$campos['Usuario']['estado_id']['input']['default']		= 1;

	$campos['Usuario']['restricoes']['tit'] 				= 'Restrições';
	$campos['Usuario']['restricoes']['input']['type']		= 'leitura';

	$campos['Usuario']['login']['th']['style'] 				= 'width: 100px;';
	$campos['Usuario']['login']['td']['style'] 				= 'text-align: center;';
	$campos['Usuario']['celular']['th']['style'] 			= 'width: 100px;';
	$campos['Usuario']['email']['th']['style'] 				= 'width: 200px;';

	$campos['Usuario']['perfil_id']['tit'] 					= 'Perfil';
	$campos['Usuario']['perfil_id']['input']['style']		= 'width: 300px;';
	$campos['Perfil']['nome']['tit'] 						= 'Perfil';

?>
