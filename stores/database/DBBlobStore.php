<?php

namespace stores\database;

use Exception;
use PDO;
use RuntimeException;

class DBBlobStore {

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;

        $sql = "CREATE TABLE IF NOT EXISTS files (".
               "    id INTEGER PRIMARY KEY AUTOINCREMENT," .
               "    assigned_ID int(11) NOT NULL," .
               "    category VARCHAR(255) NOT NULL," .
               "    mime VARCHAR(255) NOT NULL," .
               "    data BLOB NOT NULL
        );";
        $db->exec($sql);
    }

    public function create($assigned_ID, $category, $filePath, $mime): void
    {
        if($category === "profile_small" || $category === "profile_large") {
            $sql = "SELECT * FROM files WHERE assigned_ID = '".$assigned_ID."' AND category = '".$category."';";
            $result = $this->db->query($sql)->fetch();
            if($result !== false) {
                $this->update($assigned_ID, $category, $filePath, $mime);
            }
        }

        $blob = fopen($filePath, 'rb');

        $sql = "INSERT INTO files(assigned_ID, category, mime, data) VALUES(:assigned_ID ,:category ,:mime, :data)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':assigned_ID', $assigned_ID);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':mime', $mime);
        $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);

        $stmt->execute();
    }

    /**
     * @param $assigned_ID
     * @param $category
     * @param $filePath
     * @param $mime
     * @return void
     */
    public function update($assigned_ID, $category, $filePath, $mime): void
    {
        $blob = fopen($filePath, 'rb');

        $sql = "UPDATE files
                SET mime = :mime,
                    data = :data
                WHERE assigned_ID = :assigned_ID AND category = :category;";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':assigned_ID', $assigned_ID);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':mime', $mime);
        $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);

        $stmt->execute();
    }

    /**
     * @throws Exception
     */
    public function findOne($id): ?string
    {
        $sql = "SELECT mime,
                        data
                   FROM files
                  WHERE id = :id;";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(":id" => $id));
        $stmt->bindColumn(1, $mime);
        $stmt->bindColumn(2, $data);

        $stmt->fetch(PDO::FETCH_BOUND);

        if($mime !== null && $data !== null) {
            return "data:" . $mime . ";base64," . base64_encode($data);
        } else {
            return null;
        }
    }

    /**
     * methode to delete an image
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $sql = "DELETE FROM files WHERE id = '".$id."';";
        $this->db->exec($sql);
    }

    /**
     * @param $assigned_ID
     * @param $category
     * @return array
     */
    public function queryID($assigned_ID, $category) : array
    {
        $sql = "SELECT id
                FROM files
                WHERE assigned_ID = '".$assigned_ID."' AND category = '".$category."';";
        $stmt = $this->db->query($sql)->fetchAll();

        return ($stmt == null) ? throw new RuntimeException("could not find any"): $stmt;
    }

    /**
     * @param $assigned_ID
     * @return array
     */
    public function queryOwnIDs($assigned_ID) : array
    {
        $sql = "SELECT id
                FROM files
                WHERE assigned_ID = '".$assigned_ID."';";
        $stmt = $this->db->query($sql)->fetchAll();

        return ($stmt == null) ? throw new RuntimeException("could not find any"): $stmt;
    }
}



