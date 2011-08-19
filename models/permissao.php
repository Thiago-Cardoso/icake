<?php
/**
 * Model de permissões
 *
 * Objeto de segurança do sistema, controla o acesso de usuário ou perfil a determinadas ações.
 * 
 * @package		icake
 * @subpackage	icake.model
 */
/**
 * @package		icake
 * @subpackage	icake.model
 */
class Permissao extends AppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $name 			= 'Permissao';

	/**
	 * Campo padrão do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $displayField 	= 'controlador';

	/**
	 * Campo de ordenação padrão
	 * 
	 * @var		string
	 * @access	public
	 */
	public $order		 	= 'Permissao.controlador, Permissao.acao';

	/**
	 * Nome da tabela do banco de dados
	 * 
	 * @var		string
	 * @access	public
	 */
	public $useTable		= 'permissoes';

	/**
	 * Regras de validação para cada campo do model
	 * 
	 * @var		array
	 * @access	public
	 */
	public $validate = array
	(
		'controlador' => array
		(
			1 	=> array
			(
				'rule' 		=> 'notEmpty',
				'required' 	=> true,
				'message' 	=> 'É necessário informar o nome do Controlador!',
			)
		),
		'acao' => array
		(
			1 	=> array
			(
				'rule' 		=> 'notEmpty',
				'required' 	=> true,
				'message' 	=> 'É necessário informar o nome do Método!',
			)
		)
	);

	/**
	 * Relacionamentos n:n
	 * 
	 * @var		array
	 * @access	public
	 */
	public $hasAndBelongsToMany	= array
	(
		'Perfil' => array
		(
			'className'		=> 'Perfil',
			'joinTable'		=> 'permissoes_perfis',
			'associationForeignKey' => 'perfil_id',
			'foreignKey'	=> 'permissao_id',
			'unique'		=> true,
			'fields' 		=> 'id, nome'
		),
		'Usuario' => array
		(
			'className'		=> 'Usuario',
			'joinTable'		=> 'usuarios_permissoes',
			'associationForeignKey' => 'permissao_id',
			'foreignKey'	=> 'usuario_id',
			'unique'		=> true,
			'fields' 		=> 'id, nome'
		)
	);

	/**
	 * Executa código antes da validação
	 * 
	 * Perfis de administração não pode ter qualquer tipo de restrição.
	 * Usuário administrador, não pode ter qualquer tipo de restrição.
	 * 
	 * @param	array	$options	Opções passadas de model::save()
	 */
	public function beforeValidate($options = array())
	{
		if (isset($this->data))
		{
			// reconfigurando perfil, não restring perfil administrador de jeito nenhum
			$novoPerfil = array();
			if (isset($this->data['Perfil']['Perfil']) && is_array($this->data['Perfil']['Perfil']))
			{
				$dataPerfil = $this->data['Perfil']['Perfil'];
				foreach($dataPerfil as $_linha => $_codPerfil)
				{
					if ($_codPerfil != '1') array_push($novoPerfil,$_codPerfil);
				}
				$this->data['Perfil']['Perfil'] = $novoPerfil;
			}

			// reconfigurando usuarios, não restringe usuário administrador de jeito nenhum
			$novoUsuario = array();
			if (isset($this->data['Usuario']['Usuario']) && is_array($this->data['Usuario']['Usuario']))
			{
				$dataUsuario = $this->data['Usuario']['Usuario'];
				foreach($dataUsuario as $_linha => $_codUsuario)
				{
					if ($_codUsuario != '1') array_push($novoUsuario,$_codUsuario);
				}
				$this->data['Usuario']['Usuario'] = $novoUsuario;
			}
		}
		return true;
	}
}
?>
