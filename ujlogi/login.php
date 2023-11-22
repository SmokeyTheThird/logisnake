<?php
if (!isset($_SESSION)) session_start();
if (isset($_POST) && isset($_POST["_pswd"]))
{
    include "filehandling.php";

    $data = read_data("users.lsd", $_POST["_username"], 1);
    
    if($data[1]!=-1 && md5($_POST["_pswd"])==$data[2])
    {
        $_SESSION["content"]="menu";
        $_SESSION["username"]=$data[1];
        $_SESSION["user_key"]=$data[0];
        $data = read_data("passed.lsd", $_SESSION["user_key"], 0);
        if( $data[0] == $_SESSION["user_key"])
        {
            $_SESSION["passed"] = sizeof($data)-1;
            $_SESSION["level"] = "level " . sizeof($data);
            if(sizeof($data) -1 == 5)
            {
                $_SESSION["level"] = "level " . 5;
            }
        }
        else
        {
            $_SESSION["passed"] = 0;
            $_SESSION["level"] = "level 1";
        }
    }
    else
    {
        $_SESSION["message"] = "Invalid username or password!";
    }
    header('Location:index.php');
}
?>
<main>
    <form action="login.php" method="post">
        <div class="formrow">
            Username:<br> <input type="text" name="_username" id="_username" required pattern="[a-zA-Z0-9]{4,10}" title="Please use alhpabets and numbers, dont use symbols. Minimum 4, maximum 10 character.">
        </div>
        <div class="formrow">
            Password:<br> <input type="password" name="_pswd" id="_pswd" required>
        </div>
            <button type="submit">Login</button>
    </form>
    <form action="index.php" method="post">
        <input type="hidden" name="content" value="main">
        <button type="submit">Back</button>
    </form>
</main>