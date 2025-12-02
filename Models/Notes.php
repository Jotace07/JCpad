<?php

class Notes {

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function saveNotesByUsername($username, $title, $note){
        $sql = "INSERT INTO notes (username,title,note) VALUES (:username, :title, :note)";
        $save = $this->db->prepare($sql);
        $save ->bindParam(':username', $username);
        $save ->bindParam(':title', $title);
        $save ->bindParam(':note', $note);
        $save->execute();
        $note = $save->fetchAll();
        return $note;
    }

    public function getNotesByUsername($username){
        $sql = "SELECT * FROM notes WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $note = $stmt->fetchAll();
        return $note;
    }

    public function updateNotesByUsername($username, $oldTitle, $newTitle, $newNote){
        $sql = "UPDATE notes SET title = :newTitle, note = :newNote WHERE username = :username AND title = :oldTitle";
        $save = $this->db->prepare($sql);
        $save ->bindParam(':username', $username);
        $save ->bindParam(':newTitle', $newTitle);
        $save ->bindParam(':newNote', $newNote);
        $save->bindParam(':oldTitle', $oldTitle);
        $save->execute();
        // $note = $save->fetchAll();
        // return $note;
    }
    
    public function deleteNotesByUsername($username,$title){
        $sql = "DELETE FROM notes WHERE username = :username AND title = :title";
        $delete = $this->db->prepare($sql);
        $delete ->bindParam(':username', $username);
        $delete ->bindParam(':title', $title);
        $delete->execute();
        $note = $delete->fetchAll();
        return $note;
    }

    public function __destruct(){
    }

}