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
            $a = $this->selectBlob($assigned_ID, $category);
            /*
            if($a['mime'] != null) {
                return $this->updateBlob($assigned_ID, $category, $filePath, $mime);
            }
            */
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

    public function selectBlob($assigned_ID, $category): array
    {
        $sql = "SELECT mime, data
                FROM files
                WHERE assigned_ID = '".$assigned_ID."' AND category = '".$category."';";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(":assigned_ID" => $assigned_ID, ":category" => $category));
        $stmt->bindColumn(2, $mime);
        $stmt->bindColumn(3, $data);

        $stmt->fetch(PDO::FETCH_BOUND);

        return array(
            "mime" => $mime,
            "data" => $data);

    }

    public function selectMultipleBlobs($assigned_ID, $category) : array
    {
        $sql = "SELECT mime, data
                FROM files
                WHERE assigned_ID = '".$assigned_ID."' AND category = '".$category."';";
        $result = $this->pdo->query($sql);
        return $result->fetch();
    }

    public function __destruct()
    {
        // close the database connection
        $this->pdo = null;
    }


}



