<?php
include_once "../config.php";

class DbConnection
{
	protected $driver = 'mysql';
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
		$dsn = $this->driver . ':host=' . MYSQL_SERVER . ';dbname=' . MYSQL_DB . ';charset=' . $this->charset;

		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Для отображения ошибок и исключений
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // ["name" => "Michael"]
		];

		try {
			$this->pdo = new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD, $options);
		} catch (PDOException $PDOException) {
			echo $PDOException->getMessage();
			exit(1);
		}
	}
}