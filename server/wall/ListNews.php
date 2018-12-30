<?php

class ListNews
{
	protected $tableName = 'anecdotes_table';
	protected $numLimit = 5; // Кол-во записей, которые мы подгружаем за 1 раз
    protected $offset = 0; // Откуда начинаем выборку в базе данных

    /** @var null|DbConnection */
    protected $db;

    function __construct(DbConnection $db)
    {
        // Сохраняем зависимость (подключение к БД)
        $this->db = $db;
    }

    public function getData($offset)
    {
        $prepare = $this->db->getPdo()->prepare(
            "SELECT * FROM `{$this->tableName}` ORDER BY  `$this->tableName`.`id` DESC  LIMIT :offsetParam, :limitParam");
        $prepare->bindValue(':offsetParam', ($offset === null) ? $this->offset : $offset, PDO::PARAM_INT);
        $prepare->bindValue(':limitParam', $this->numLimit, PDO::PARAM_INT);
        $prepare->execute();
        return $prepare->fetchAll();
    }

    /**
     * Метод заполняет БД
     */
    public function fillTable()
    {
        for ($i = 0; $i < 10; $i++) {
            $time = time() - rand(1000, 30000);
            $prepare = $this->db->getPdo()->prepare("INSERT INTO `{$this->tableName}` VALUES (null, 'Новость $i', 'Текст новости $i', 'Gleb', $time)");

            // Выполянем запрос к БД
            $prepare->execute();
        };
    }
}