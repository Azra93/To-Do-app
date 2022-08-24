<?php

require '../db_conn.php';

if(isset($_POST['title']) && $_POST['date']){
    
    $title = $_POST['title'];
    $date = $_POST['date'];

    if(empty($title)){
        header("Location: ../index.php?mess=error");
    }else{
        //$stmt = $conn->prepare("INSERT INTO todos(title, date_time) VALUE('$title', '$date')");
        $stmt = "INSERT INTO todos(title, date_time) VALUE('$title', '$date')";
        $res = $conn->exec($stmt);

        if($res){
            header("Location: ../index.php?mess=succes");
        }else{
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
}else{
    header("Location: ../index.php?mess=error");
}