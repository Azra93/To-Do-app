
<?php
include '../db_conn.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body>


<?php

$id = $_GET['updateid'];

if(isset($_GET['updateid'])){

    $id = $_GET['updateid'];
    $stmt = $conn->prepare("SELECT * FROM todos WHERE id='{$id}'");
    $stmt->execute();

    $todo = $stmt->fetchAll();

    foreach ($todo as $row) {
        $idd = $row['id'];
        $title = $row['title'];
        $date = $row['date_time'];
        
    }

}

?>
<div class="main-section">
    <div class="add-section">
        <form action="" method="POST">
            <label for="title">Title: </label>
            <input type="text" name="title" value=<?php echo $title; ?> >
            <br>
            <label for="date">Date and time: </label>
            <input type="datetime-local" name="date" value="<?php echo $date; ?>" >
            <br>
            <input type="hidden" name="idd" value=<?php echo $idd; ?>>
            <button type="submit" name="submit">EDIT &nbsp; <span>&#43;</span></button>
            
        </form>
    </div>
</div>
</body>

<?php

if (isset($_POST['submit'])){
    $id = $_POST['idd'];
    $title = $_POST['title'];
    $date = $_POST['date'];

    $sql = "UPDATE todos SET 
    title ='{$title}',
    date_time ='{$date}' 
    WHERE id='{$id}'";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    if($stmt->rowCount()){ 
        header("Location: ../index.php");}
}