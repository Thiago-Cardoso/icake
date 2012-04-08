<?php
/**
 * Model Serie para módulo de contatos
 *
 * @package		contato
 * @subpackage	contato.Model
 */
/**
 * @package		contato
 * @subpackage	contato.Model
 */
class Email extends ConAppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 			= 'Email';

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
	public $order		 	= 'Email.email';

	/**
	 * Nome da tabela do banco de dados
	 * 
	 * @var		string
	 * @access	public
	 */
	public $useTable 		= 'emails';

	/**
	 * Regras de validação para cada campo do model
	 * 
	 * @var		array
	 * @access	public
	 */
	public $validate = array
	(
		'email' => array
		(
			1 	=> array
			(
				'rule' 		=> 'notEmpty',
				'required' 	=> true,
				'message' 	=> 'É necessário informar o nome do Contato!',
			),
			2 	=> array
			(
				'rule' 		=> 'isUnique',
				'required' 	=> true,
				'message' 	=> 'Este e-mail já foi cadastrado!',
			)
		)
	);

	/**
	 * Relacionamento n para n
	 * 
	 * @var		array
	 * @access	public
	 * @link	http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html#hasandbelongstomany-habtm
	 */
	public $hasAndBelongsToMany	= array
	(
		'Grupo' => array
		(
			'className'				=> 'Con.Grupo',
			'joinTable'				=> 'con_emails_con_grupos',
			'associationForeignKey' => 'con_grupo_id',
			'foreignKey'			=> 'con_email_id',
			'unique'				=> true
		)
	);
}

?>
