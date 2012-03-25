<?php
class DATABASE_CONFIG {
	/**
	 * Banco de dados Padrão
	 * 
	 * @var		array
	 * @access	public
	 * @link	http://book.cakephp.org/2.0/en/getting-started.html
	 */
	public $default = array();

	/**
	 * Banco de Dados Mysql
	 * 
	 * @var		array
	 * @access	public
	 * @link	http://book.cakephp.org/2.0/en/getting-started.html
	 */
	public $mysql = array
	(
		'datasource'=> 'Database/Mysql',
		'persistent'=> false,
		'host' 		=> 'localhost',
		'login' 	=> 'icake_us',
		'password' 	=> 'icake_67',
		'database' 	=> 'icake_bd',
		'encoding' 	=> 'utf8'
	);

	/**
	 * Banco de Dados PostreSQL
	 * 
	 * @var		array
	 * @access	public
	 * @link	http://book.cakephp.org/2.0/en/getting-started.html
	 */
	public $postgre = array
	(
		'datasource'=> 'Database/Postgres',
		'persistent'=> false,
		'host' 		=> 'localhost',
		'login' 	=> 'icakepg_us',
		'password' 	=> 'icakepg_67',
		'database' 	=> 'icakepg_bd',
		'encoding' 	=> 'utf8'
	);

	/**
	 * Re-definindo o banco de dados
	 * 
	 * @return	void
	 */
	public function __construct()
	{
		//$this->default = $this->mysql;
		$this->default = $this->postgre;
	}
}
