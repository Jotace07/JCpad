<?php 



class CrudController {

    public $noteClass;

    public function __construct(){
        $this->noteClass = new Notes();
    }

    public function saveNotes(){
        $username = $_SESSION['username'];
        $title = $_POST['noteTitle'];
        $note = $_POST['noteContent'];
        $save = $this->noteClass->saveNotesByUsername($username, $title, $note);
        return $save;
    }

    public function getNotes(){
        $username = $_SESSION['username'];
        $save = $this->noteClass->getNotesByUsername($username);
        echo json_encode($save);
    }

    public function updateNotes(){
        $username = $_SESSION['username'];
        $title = $_POST['noteTitle'];
        $note = $_POST['noteContent'];
        $save = $this->noteClass->saveNotesByUsername($username, $title, $note);
        return $save;
    }

    public function deleteNotes(){
        $username = $_SESSION['username'];
        $title = $_POST['noteTitle'];
        $save = $this->noteClass->deleteNotesByUsername($username, $title);
        return $save;
    }


}