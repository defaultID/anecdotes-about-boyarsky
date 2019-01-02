<?php
include_once "../config.php";

class DbConnection
{
	protected $driver = 'mysql';
	protected $host = MYSQL_SERVER;
	protected $userName = MYSQL_USER;
	protected $password = MYSQL_PASSWORD;
	protected $dbName = MYSQL_DB;
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
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // ["name" => "Michael"]
		];

		try {
			$this->pdo = new PDO($dsn, $this->userName, $this->password, $options);
		} catch (PDOException $PDOException) {
			echo $PDOException->getMessage();
			exit(1);
		}
	}
}