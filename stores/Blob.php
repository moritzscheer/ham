<?php

class blob {

    private $pdo = null;

    public function __construct()
    {
        $user = "root";
        $pw = null;
        $dsn = "sqlite:sqlite-pdo-blob.db";
        $id = "id INTEGER PRIMARY KEY AUTOINCREMENT,"; // SQLite-Syntax

        try {
            $this->pdo = new PDO($dsn, $user, $pw);
            $sql = "CREATE TABLE IF NOT EXISTS files (". $id .
                "    assigned_ID int(11) NOT NULL," .
                "    category VARCHAR(255) NOT NULL," .
                "    mime VARCHAR(255) NOT NULL," .
                "    data BLOB NOT NULL);";
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertBlob($assigned_ID, $category, $filePath, $mime): bool
    {
        if($category === "profile_picture_small" || $category === "profile_picture_large") {
            $sql = "SELECT * FROM files WHERE assigned_ID = '".$assigned_ID."' AND category = '".$category."';";
            $result = $this->pdo->query($sql)->fetch();
            if($result !== false) {
                return $this->updateBlob($assigned_ID, $category, $filePath, $mime);
            }
        }

        $blob = fopen($filePath, 'rb');

        $sql = "INSERT INTO files(assigned_ID, category, mime, data) VALUES(:assigned_ID ,:category ,:mime, :data)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':assigned_ID', $assigned_ID);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':mime', $mime);
        $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);

        return $stmt->execute();
    }

    function updateBlob($assigned_ID, $category, $filePath, $mime): bool
    {

        $blob = fopen($filePath, 'rb');

        $sql = "UPDATE files
                SET mime = :mime,
                    data = :data
                WHERE assigned_ID = :assigned_ID AND category = :category;";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':assigned_ID', $assigned_ID);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':mime', $mime);
        $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);


        return $stmt->execute();
    }

    /**
     * @throws Exception
     */
    public function selectBlob($id) {

        $sql = "SELECT mime,
                        data
                   FROM files
                  WHERE id = :id;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(":id" => $id));
        $stmt->bindColumn(1, $mime);
        //$stmt->bindColumn(2, $data, PDO::PARAM_LOB); bis 2021
        $stmt->bindColumn(2, $data);

        $stmt->fetch(PDO::FETCH_BOUND);

        return array("mime" => $mime,
            "data" => $data);
    }


    /**
     * @throws Exception
     */
    public function queryID($assigned_ID, $category) : array
    {
        $sql = "SELECT id
                FROM files
                WHERE assigned_ID = '".$assigned_ID."' AND category = '".$category."';";
        $stmt = $this->pdo->query($sql)->fetchAll();

        return ($stmt == null) ? throw new RuntimeException("could not find any"): $stmt;
    }

    public function __destruct()
    {
        // close the database connection
        $this->pdo = null;
    }


}



