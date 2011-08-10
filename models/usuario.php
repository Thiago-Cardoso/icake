<?php
/**
 * Model de usuários
 *
 * @package		exemploApp
 * @subpackage	exemploApp.model
 */
/**
 * @package		exemploApp
 * @subpackage	exemploApp.model
 */
class Usuario extends AppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 			= 'Usuario';

	/**
	 * Campo padrão do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $displayField 	= 'login';

	/**
	 * Campo de ordenação padrão
	 * 
	 * @var		string
	 * @access	public
	 */
	public $order		 	= 'Usuario.login';

	/**
	 * Regras de validação para cada campo do model
	 * 
	 * @var		array
	 * @access	public
	 */
	public $validate = array
	(
		'nome' => array
		(
			1 	=> array
			(
				'rule' 		=> 'notEmpty',
				'required' 	=> true,
				'message' 	=> 'É necessário informar o nome do Usuario!',
			)
		),
		'login' => array
		(
			1 => array
			(
				'rule'		=> 'notEmpty',
				'required'	=> true,
				'message'	=> 'É necessário informar o login do Usuário!',
			)
		),
	);

	/**
	 * Relacionamento entre as tabelas usuarios e perfis
	 * 
	 * @var		array
	 * @access	public
	 */
	public $hasAndBelongsToMany	= array
	(
		'Perfil' => array
		(
			'className'		=> 'Perfil',
			'joinTable'		=> 'usuarios_perfis',
			'associationForeignKey' => 'perfil_id',
			'foreignKey'	=> 'usuario_id',
			'unique'		=> true,
			'fields' 		=> 'id, nome'
		),
	);
}
?>
