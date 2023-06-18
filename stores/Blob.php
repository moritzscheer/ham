<?php

class blob {

    private PDO $db;

    public function __construct(PDO $db) {
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

    public function insertBlob($assigned_ID, $category, $filePath, $mime): bool {
        $this->db->beginTransaction();

        if($category === "profile_picture_small" || $category === "profile_picture_large") {
            $sql = "SELECT * FROM files WHERE assigned_ID = '".$assigned_ID."' AND category = '".$category."';";
            $result = $this->db->query($sql)->fetch();
            if($result !== false) {
                $result = $this->updateBlob($assigned_ID, $category, $filePath, $mime);
                $this->db->commit();
                return $result;
            }
        }

        $blob = fopen($filePath, 'rb');

        $sql = "INSERT INTO files(assigned_ID, category, mime, data) VALUES(:assigned_ID ,:category ,:mime, :data)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':assigned_ID', $assigned_ID);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':mime', $mime);
        $stmt->bindParam(':data', $blob, PDO::PARAM_LOB);

        $result = $stmt->execute();
        $this->db->commit();
        return $result;
    }

    function updateBlob($assigned_ID, $category, $filePath, $mime): bool {

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

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(":id" => $id));
        $stmt->bindColumn(1, $mime);
        $stmt->bindColumn(2, $data);

        $stmt->fetch(PDO::FETCH_BOUND);

        return array("mime" => $mime,
            "data" => $data);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM files WHERE id = '".$id."';";
        $this->db->exec($sql);
    }

    /**
     * @throws Exception
     */
    public function queryID($assigned_ID, $category) : array {
        $sql = "SELECT id
                FROM files
                WHERE assigned_ID = '".$assigned_ID."' AND category = '".$category."';";
        $stmt = $this->db->query($sql)->fetchAll();

        return ($stmt == null) ? throw new RuntimeException("could not find any"): $stmt;
    }
}



