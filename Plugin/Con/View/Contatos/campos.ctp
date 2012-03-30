<?php
	$campos['Contato']['nome']['tit']				        = 'Contato';
	$campos['Contato']['nome']['focus']			            = true;
	$campos['Contato']['nome']['input']['style']	        = 'width: 500px;  text-transform: uppercase;';
	
	$campos['Contato']['endereco']['tit']				    = 'Endereco';
	$campos['Contato']['endereco']['input']['style']		= 'width: 500px; text-transform: uppercase;';	

	$campos['Contato']['email']['tit']				        = 'e-mail';

	$campos['Contato']['sexo']['tit']				        = 'Sexo';
	$campos['Contato']['sexo']['th']['width']		        = '80px';
	$campos['Contato']['sexo']['td']['align']		        = 'center';
	$campos['Contato']['sexo']['input']['options']['F']		= 'Feminino';
	$campos['Contato']['sexo']['input']['options']['M']		= 'Masculino';

	$campos['Contato']['tel1']['tit']				        = 'Tel.Residêncial';
	$campos['Contato']['tel1']['mascara']			        = '(99)9999-9999';
	$campos['Contato']['tel1']['input']['style']	        = 'width: 99px;';
	$campos['Contato']['tel1']['th']['width']		        = '110px';
	$campos['Contato']['tel1']['td']['align']		        = 'center';
	
	$campos['Contato']['tel2']['tit']				        = 'Tel.Comercial';
	$campos['Contato']['tel2']['mascara']			        = '(99)9999-9999';
	$campos['Contato']['tel2']['input']['style']	        = 'width: 99px;';
	$campos['Contato']['tel2']['th']['width']		        = '110px';
	$campos['Contato']['tel2']['td']['align']		        = 'center';

	$campos['Contato']['tel3']['tit']				        = 'Celular';
	$campos['Contato']['tel3']['mascara']			        = '(99)9999-9999';
	$campos['Contato']['tel3']['input']['style']	        = 'width: 99px;';
	$campos['Contato']['tel3']['th']['width']		        = '110px';
	$campos['Contato']['tel3']['td']['align']		        = 'center';


	$campos['Contato']['bairro']['tit']				        = 'Bairro';
	$campos['Contato']['bairro']['th']['width']		        = '100px';
	$campos['Contato']['bairro']['td']['align']		        = 'center';
	$campos['Contato']['bairro']['input']['style']			= 'width: 200px; text-transform: uppercase;';

	$campos['Contato']['aniversario']['tit']				= 'Aniversário';
	$campos['Contato']['aniversario']['mascara']			= '99/99';
	$campos['Contato']['aniversario']['th']['width']		= '40px';
	$campos['Contato']['aniversario']['td']['align']		= 'center';
	$campos['Contato']['aniversario']['input']['style']		= 'width: 50px; text-align: center;';

	$campos['Contato']['obs']['tit']						= 'Obs';
	$campos['Contato']['obs']['input']['style']				= 'width: 500px;';


	$campos['Cidade']['nome']['tit'] 						= 'Cidade';
	$campos['Cidade']['nome']['th']['style']				= 'width: 200px';
	$campos['Contato']['cidade_id']['tit'] 					= 'Cidade';
	$campos['Contato']['cidade_id']['input']['empty']		= '-- Escolha uma Cidade --';
	$campos['Contato']['cidade_id']['input']['style']		= 'width: 500px;';
	$campos['Contato']['cidade_id']['input']['default']		= 2302;

	$campos['Estado']['nome']['tit'] 						= 'Estado';
	$campos['Estado']['nome']['th']['style']				= 'width: 150px';
	$campos['Contato']['estado_id']['tit'] 					= 'Estado';
	$campos['Contato']['estado_id']['input']['empty']		= '-- Escolha um Estado --';
	$campos['Contato']['estado_id']['input']['style']		= 'width: 500px;';
	$campos['Contato']['estado_id']['combo'] 				= array('Contato.cidade_id','cidades');
	$campos['Contato']['estado_id']['input']['default']		= 1;

    $campos['Contato']['cep']['tit']				        = 'Cep';
	$campos['Contato']['cep']['th']['width']		        = '30px';
	$campos['Contato']['cep']['td']['align']		        = 'center';
	$campos['Contato']['cep']['mascara']			        = '99999-999';
	$campos['Contato']['cep']['input']['style']	            = 'width: 80px;';

	$campos['Contato']['uf']['tit']				            = 'Uf';
	$campos['Contato']['uf']['th']['width']		            = '30px';
	$campos['Contato']['uf']['td']['align']		            = 'center';
	$campos['Contato']['uf']['input']['style']	            = 'width: 30px; text-align: center; text-transform: uppercase;';
	
?>
