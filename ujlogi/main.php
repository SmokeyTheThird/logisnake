<?php
/* session_start();
var_dump($_POST);
if (isset($_POST) && isset($_POST["content"])) 
{
    echo "lefut";
    $_SESSION["content"]=$_POST["content"];
    header("index.php");
} */
?>
<main>
<form action="index.php" method="post">
    <input type="hidden" name="content" value="login">
    <button type="submit" >
        Login
    </button>
</form>    
<form action="index.php" method="post">
    <input type="hidden" name="content" value="registration">
    <button type="submit" >
        Sign Up
    </button>
</form>  
    <?php
    
    ?>
</main>
<footer>The site uses COOKIES. If you use this site you accept this. We don't store any data by COOKIES.<br>GitHub link: <a href="https://github.com/SmokeyTheThird/logisnake</footer>" target="_blank" > https://github.com/SmokeyTheThird/logisnake</a>