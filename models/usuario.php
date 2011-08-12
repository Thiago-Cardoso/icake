<?php
/**
 * Model de usuários
 *
 * @package		icake
 * @subpackage	icake.model
 */
/**
 * @package		icake
 * @subpackage	icake.model
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
				
            )
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

	/**
	 * Confere se as duas senha digitadas estão iguais
	 * 
	 * @return	boolean
	 */
	public function confereSenha()
	{
		if (!empty($this->data['Usuario']['senha']) && isset($this->data['Usuario']['senha2']))
		{
			$senha  = Security::hash(Configure::read('Security.salt') . $this->data['Usuario']['senha']);
			$senha2 = Security::hash(Configure::read('Security.salt') . $this->data['Usuario']['senha2']);
			if ($senha != $senha2)
			{
				return false;
			} else $this->data['Usuario']['senha'] = $senha;
		} else
		{
			unset($this->data['Usuario']['senha']);
		}
		return true;
	}

	/**
	 * Executa código antes de salvar e depois de validar
	 * 
	 * Re-configura alguns campos do cadastro de usuários, como a caixa, usuário administrador sempre administrador
	 * 
	 * @param	array	$options
	 * @return	boolean
	 */
	public function beforeSave($options = array())
	{
		if (isset($this->data))
		{
			// configurando a caixa para alguns campos
			$this->data['Usuario']['nome']	= mb_strtoupper($this->data['Usuario']['nome']);
			$this->data['Usuario']['email'] = mb_strtolower($this->data['Usuario']['email']);
			$this->data['Usuario']['login'] = mb_strtolower($this->data['Usuario']['login']);

			// removendo máscara do celular
			$this->data['Usuario']['celular'] = ereg_replace('[- ]','',$this->data['Usuario']['celular']);

			// se está editando usuário admin, então ele sempre será admin
			if (isset($this->data['Usuario']['id']) && $this->data['Usuario']['id']==1)
			{
				$dataPerfil = isset($this->data['Perfil']['Perfil']) ? $this->data['Perfil']['Perfil'] : array();
				if ($dataPerfil)
				{
					if (!in_array('1',$dataPerfil))array_push($dataPerfil,'1');
				} else
				{
					$dataPerfil = array('1');
				}
				$this->data['Perfil']['Perfil'] = $dataPerfil;
			}
		}
		return true;
	}
}
?>
