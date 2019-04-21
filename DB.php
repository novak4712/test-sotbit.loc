<?php

class DB
{
    public $dbCon;
    protected $dataBase;

    /*
     * конструктор подключения к базе данных
     */

    public function __construct($userName = 'root', $password = '', $host = 'localhost', $dbName = 'parserdb', $options = [])
    {
        $this->dbCon = true;
        try {
            $this->dataBase = new PDO("mysql:host={$host};dbname={$dbName};charset=utf8", $userName, $password, $options);
            $this->dataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dataBase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * отключение от базы данных
     */

    public function Dicsonect()
    {
        $this->dataBase = null;
        $this->dbCon = false;
    }

    /*
     * получение одной записи
     */

    public function getRow($query, $params = [])
    {
        try {
            $stmt = $this->dataBase->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * получение нескольких записей
     */
    public function getRows($query, $params = [])
    {
        try {
            $stmt = $this->dataBase->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * добавление в базу данных
     */
    public function insertRow($query, $params = [])
    {
        try {
            $stmt = $this->dataBase->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * обновление в базе данных
     */
    public function updateRow($query, $params = [])
    {
        $this->insertRow($query, $params);
    }

    /**
     * удаление из базы данных
     */
    public function deleteRow($query, $params = [])
    {
        $this->insertRow($query, $params);
    }
}