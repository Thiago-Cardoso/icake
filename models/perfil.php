<?php
/**
 * Model para perfis
 *
 * @package		icake
 * @subpackage	icake.model
 */
/**
 * @package		icake
 * @subpackage	icake.model
 */
class Perfil extends AppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 			= 'Perfil';

	/**
	 * Campo padrão do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $displayField 	= 'nome';

	/**
	 * Campo de ordenação padrão
	 * 
	 * @var		string
	 * @access	public
	 */
	public $order		 	= 'Perfil.nome';

	/**
	 * Nome da tabela no banco de dados
	 * 
	 * @var		string
	 * @access	public
	 */
	public $useTable		= 'perfis';

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
				'message' 	=> 'É necessário informar o nome do Perfil!',
			)
		)
	);

	/**
	 * Relacionamento 1 para n
	 */
	public $hasAndBelongsToMany	= array
	(
		'Usuario' => array
		(
			'className'		=> 'Usuario',
			'joinTable'		=> 'usuarios_perfis',
			'associationForeignKey' => 'usuario_id',
			'foreignKey'	=> 'perfil_id',
			'unique'		=> true,
			'fields' 		=> 'Usuario.id, Usuario.nome'
		),
	);
}

?>
