<?php
/**
 * Model Serie para módulo de histórico
 *
 * @package		historico
 * @subpackage	historico.Model
 */
/**
 * @package		historico
 * @subpackage	historico.Model
 */
class Contato extends ConAppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 			= 'Contato';

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
	public $order		 	= 'Contato.nome';

	/**
	 * Nome da tabela do banco de dados
	 * 
	 * @var		string
	 * @access	public
	 */
	public $useTable 		= 'contatos';

	/**
	 * Limpar máscara dos campos ao salvar
	 * 
	 * @var		array
	 * @accces	public
	 */
	public $limparCampos	= array('tel1','tel2','tel3','aniversario');

	/**
	 * Ignorar maiúscula ao salvar
	 * 
	 * @var		array
	 * @accces	public
	 */
	public $ignorarCampos	= array('twitter','facebook','gtalk','msn','obs');

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
				'message' 	=> 'É necessário informar o nome do Contato!',
			),
			2 	=> array
			(
				'rule' 		=> 'isUnique',
				'required' 	=> true,
				'message' 	=> 'Esta Série já foi cadastrado!',
			)
		),
		'email' => array
		(
			2 	=> array
			(
				'rule' 		=> 'isUnique',
				'required' 	=> true,
				'message' 	=> 'Este e-mail já foi cadastrado!',
			)
			
		)
	);

	/**
	 * Relacionamento 1 para n
	 * 
	 * @var		array
	 * @access	public
	 */
	public $belongsTo = array(
		'Estado' => array(
			'className' 	=> 'Estado',
			'foreignKey' 	=> 'estado_id',
			'conditions' 	=> '',
			'fields' 		=> 'Estado.id, Estado.nome'
		),
		'Cidade' => array(
			'className' 	=> 'Cidade',
			'foreignKey' 	=> 'cidade_id',
			'conditions' 	=> '',
			'fields' 		=> 'Cidade.id, Cidade.nome'
		)
	);
}

?>
