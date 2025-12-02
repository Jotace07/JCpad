<?php 

$noteClass = new Notes();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['noteTitle']) && isset($_POST['noteContent']) && isset($_POST['saveNote']));
        $username = $_SESSION['username'];
        $title = $_POST['noteTitle'];
        $note = $_POST['noteContent'];
        $save = $noteClass->saveNotesByUsername($username, $title, $note);
        return $save;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['noteTitle']) && isset($_POST['noteContent']) && isset($_POST['updateNote']));
        $username = $_SESSION['username'];
        $title = $_POST['noteTitle'];
        $note = $_POST['noteContent'];
        $save = $noteClass->saveNotesByUsername($username, $title, $note);
        return $save;
}