<?php

class DbConnection
{
	protected $driver = 'mysql';
	protected $host = 'localhost';
	protected $userName = 'root';
	protected $password = '';
	protected $dbName = 'f0144844_anecdotes_db';
	protected $charset = 'utf8';

	/** @var null|PDO */
	protected $pdo;

	/**
	* @return null|PDO
	*/
	public function getPdo()
	{
		return $this->pdo;
	}

	function __construct()
	{
		$dsn = $this->driver . ':host=' . $this->host . ';dbname=' . $this->dbName . ';charset=' . $this->charset;

		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Для отображения ошибок и исключений
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // ["name" => "Igor"]
		];

		try {
			$this->pdo = new PDO($dsn, $this->userName, $this->password, $options);
		} catch (PDOException $PDOException) {
			echo $PDOException->getMessage();
			exit(1);
		}
	}
}