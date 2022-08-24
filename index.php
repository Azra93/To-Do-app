<?php
    require "db_conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <div class="main-section">
        <div class="img">
            <img src="img/todo.png" width="200px">
        </div>
        <div class="add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){?>
                    <input type="text" name="title" style="border-color: #ff6666" placeholder="This field is required">
                    <br>
                    <input type="datetime-local" name="date">
                    <br>
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                <?php }else{ ?>

                    <input type="text" name="title" placeholder="What do you need to do?">
                    <br>
                    <input type="datetime-local" name="date">
                    <br>
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>
                
                <?php } ?>
            </form>
        </div>
        <?php
            $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>
        <div class="show-todo-section">
            <?php
                if($todos->rowCount() <= 0){
            ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/img1.png" width="300px">
                        <img src="img/gif1.gif" width="150px">
                    </div>
                </div>
            <?php } ?>  
                <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)){ ?>
                <div class="todo-item">
                
                    <span 
                    id="<?php echo $todo['id']?>"
                    class="remove-to-do">x</span>
                    <a href="app/update.php?updateid= <?php echo $todo['id']?>">
                            <img src="img/pen.png" width="13px" height="13px">
                    </a>
                    <?php if($todo['checked']){?>
                
                        <input type="checkbox"
                                class="check-box" 
                                data-todo-id ="<?php echo $todo['id']; ?>"
                                checked>
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>

                    <?php }else { ?>
                        <input type="checkbox"
                        data-todo-id ="<?php echo $todo['id']; ?>"
                         class="check-box">
                        <h2><?php echo $todo['title'] ?></h2>
                    <?php } ?>
                        <br>
                        <small>created: <?php echo $todo['date_time'] ?></small>
                        
                <br>
                    
                </div>  
           <?php } ?>
        </div>
    </div>


        

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">

    </script>
    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php",
                    {
                        id: id
                    },
                    (data) => {
                        if(data){
                            $(this).parent().hide(600);
                        }

                    }
                );

            });
            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php',
                    {
                        id: id
                    },
                    (data) =>{
                        if(data != 'error'){
                            const h2 = $(this).next();
                            if( data === '1'){
                                h2.removeClass('checked');
                            }else{
                                h2.addClass('checked');
                            }
                        }
                    }
                
                );

            });
        });
    </script>
</body>
</html>