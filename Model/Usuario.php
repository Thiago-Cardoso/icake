<?php
/**
 * Model para o cadastro de Usuários
 *
 * @copyright	Copyright 2008-2012, Adriano Carneiro de Moura
 * @link		http://github.com/adrianodemoura/icake 	Projeto iCake
 * @package		icake
 * @subpackage	icake.Model
 * @since		CakePHP(tm) v 2.1
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * @package			icake
 * @subpackage		icake.Model
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
	 * Ignorar campos no AppModel
	 * 
	 * @var		array
	 * @access	public
	 */
	public $ignorarCampos	= array('login','email','senha');

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
			'notEmpty' => array
			(
				'rule'		=> 'notEmpty',
				'required'	=> true,
				'message'	=> 'É necessário informar o login do Usuário!',
			),
			'isUnique' => array(
				'rule' => 'isUnique', // http://book.cakephp.org/pt/view/1166/isUnique
				'message' => 'Este login já está sendo usado !'
			)
		),
		'senha'	=> array
            (
				1	=> array
				(
					'rule'		=> 'notEmpty',
					'required'	=> true,
					'message'	=> 'A senha é obrigatória !',
					'on'		=> 'create'
				),
				2	=> array
				(
					'rule'		=> 'confereSenha', 
					'message'	=> 'A senhas não estão iguais'
				)
            ),
		'email' => array(
			/**
			 *  Multiplas regras por campo 
			 *  http://book.cakephp.org/pt/view/1151/Multiple-Rules-per-Field
			 */
			'notEmpty' => array(
				'rule' => 'notEmpty', // http://book.cakephp.org/pt/view/1173/notEmpty
				'message' => 'O campo email não pode ser vazio.'
			),
			'email' => array(
				'rule' => array('email', false), // http://book.cakephp.org/pt/view/1161/email
				'message' => 'Insira um email válido.'
			),
			'isUnique' => array(
				'rule' => 'isUnique', // http://book.cakephp.org/pt/view/1166/isUnique
				'message' => 'Já existe um  usuário com este e-mail.'
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

	/**
	 * Relacionamento n para n
	 * 
	 * @var		array
	 * @access	public
	 * @link 	http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html#hasandbelongstomany-habtm
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
		)
	);

	/**
	 * Confere se as duas senha digitadas estão iguais
	 * 
	 * @return	boolean
	 */
	public function confereSenha()
	{
		if (!empty($this->data['Usuario']['senha']) && isset($this->data['Usuario']['senha2']))
		{
			$senha  = $this->data['Usuario']['senha'];
			$senha2 = $this->data['Usuario']['senha2'];
			if ($senha != $senha2)
			{
				return false;
			} else 
			{
				$this->data['Usuario']['trocar_senha'] 	= false;
			}
		} else
		{
			unset($this->data['Usuario']['senha']);
		}
		return true;
	}

	/**
	 * Executa código antes de salvar e depois de validar
	 * 
	 * - Re-configura alguns campos do cadastro de usuários, como caixa alta ou baixa.
	 * 
	 * - O Usuário administrador sempre será administrador, não pode tirá-lo deste perfil.
	 * 
	 * - O Usuário administrador deve estar sempre ativo.
	 * 
	 * @param	array	$options
	 * @return	boolean
	 */
	public function beforeSave($options = array())
	{
		if (isset($this->data))
		{
			// configurando a caixa para alguns campos
			if (isset($this->data['Usuario']['nome'])) $this->data['Usuario']['nome']	= mb_strtoupper($this->data['Usuario']['nome']);
			if (isset($this->data['Usuario']['email'])) $this->data['Usuario']['email'] = mb_strtolower($this->data['Usuario']['email']);
			if (isset($this->data['Usuario']['login'])) $this->data['Usuario']['login'] = mb_strtolower($this->data['Usuario']['login']);

			// encriptando a senha
			if (isset($this->data['Usuario']['senha']))
			{
				App::uses('Security', 'Utility');
				$this->data['Usuario']['senha'] = Security::hash(Configure::read('Security.salt') . $this->data['Usuario']['senha']);
			}

			// se está editando usuário admin, então ele sempre será admin
			if (isset($this->data['Usuario']['id']) && $this->data['Usuario']['id']==1)
			{
				// sempre ativo
				$this->data['Usuario']['ativo'] 		= true;
				$this->data['Usuario']['trocar_senha'] 	= false;
				$this->data['Perfil']['Perfil']['0']	= 1;
				//debug($this->data[$this->name]);
			}
		}
		return parent::beforeSave($options);
	}

	/**
	 * Executa código antes de deletar
	 * 
	 * - Usuário administrador não pode ser deltado.
	 * 
	 * @param	array	$cascade	Se verdadeiro deleta os registros de dependência também.
	 * @link 	http://book.cakephp.org/view/1048/Callback-Methods#beforeDelete-1054
	 */
	public function beforeDelete($cascade = true) 
	{
		if (isset($this->id) && $this->id == 1)
		{
			return false;
		}
		return true;
	}
}
?>
