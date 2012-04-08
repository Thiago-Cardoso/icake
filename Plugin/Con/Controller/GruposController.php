<?php
/**
 * Controller para o cadastro de grupos
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
class GruposController extends ConAppController {
	/**
	 * Modelo
	 * 
	 * @var		array
	 * @access	public
	 */
	public $uses	= array('Con.Grupo');

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
				$edicaoCampos = array('Grupo.nome');
				break;
			case 'listar':
				$listaCampos = array('Grupo.nome');
				break;
		}

		$campos['Grupo']['nome']['tit'] 			= 'Nome';
		$campos['Grupo']['nome']['th']['width']		= '600px';
		$campos['Grupo']['nome']['focus'] 			= true;
		$campos['Grupo']['nome']['input']['style'] = 'width: 400px';

		$this->set(compact('campos','edicaoCampos','listaCampos'));
		parent::beforeRender();
	}
}
