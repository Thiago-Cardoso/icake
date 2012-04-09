<?php
/**
 * Controller para o cadastro de e-mails
 *
 * @copyright	Copyright 2008-2012, Adriano Carneiro de Moura
 * @link		http://github.com/adrianodemoura/icake 	Projeto iCake
 * @package		icake.contatos
 * @subpackage	icake.contatos.controller
 * @since		CakePHP(tm) v 2.1
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * @package			icake.contatos
 * @subpackage		icake.contatos.controller
 */
class EmailsController extends ConAppController {
	/**
	 * Modelo
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses	= array('Con.Email');

	/**
	 * Executa código antes da renderização da view
	 * 
	 * @return	void
	 */
	public function beforeRender()
	{
		switch($this->action)
		{
			case 'editar':
			case 'novo':
			case 'excluir':
			case 'imprimir':
				$edicaoCampos = array('Email.email','Grupo.Grupo');
				break;
			case 'listar':
				$listaCampos = array('Email.email');
				break;
		}

		$campos['Email']['email']['tit'] 			= 'e-mail';
		$campos['Email']['email']['th']['width']	= '600px';
		$campos['Email']['email']['focus'] 			= true;
		$campos['Email']['email']['input']['style'] = 'width: 400px';

		$this->set(compact('campos','edicaoCampos','listaCampos'));
		parent::beforeRender();
	}

	/**
	 * Exibe a tela de e-mails
	 * 
	 * @return	void
	 */
	public function newsletter() 
	{
		$this->loadModel('Con.Grupo');
		$Grupo = new Grupo();
		$grupos = $Grupo->find('list');

		$this->set(compact('grupos'));
	}

	/**
	 * Envia a mensagem de e-mail
	 * 
	 * @return	void
	 */
	public function enviar_msg()
	{
	}
}
