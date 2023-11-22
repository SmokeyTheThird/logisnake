<?php
session_start();
if(isset($_POST) && isset($_POST["content"]))
{
    $_SESSION["content"]=$_POST["content"];
}
if(!isset($_SESSION["content"]))
{
    $_SESSION["content"]="main";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <title>LogiSnake</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="board.css">
</head>
<body>
    <div class="wrapper">
        <header></header>
<?php
if(isset($_SESSION["message"]))
{
?>
    <div class="message">
        <?php
        echo $_SESSION["message"];
        unset($_SESSION["message"]);
        ?>
    </div>
<?php
}
include($_SESSION["content"].".php");
?>
    </div>
</body>
</html>