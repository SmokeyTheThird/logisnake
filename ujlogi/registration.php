<?php
if (!isset($_SESSION)) session_start();
if (isset($_POST) && isset($_POST["_pswd"])) 
{
    if($_POST["_pswd2"]==$_POST["_pswd"])
    {
        
        include "filehandling.php";
        
        $data = read_data("users.lsd", $_POST["_username"], 1);
        
        if($data[1]==-1)
        {
            
            
            $data = [max_user_key("users.lsd")+1, $_POST["_username"], md5($_POST["_pswd"])];
            
            write_data("users.lsd", $data);
            
            $_SESSION["content"]="login";
        }
        else
        {
            $_SESSION["message"] = "Username is used!";
        }
    }
    else
    {
        $_SESSION["message"] = "Different passwords!";
    }
    header("Location:index.php", true, 301);
}
?>
<main>
    <form action="registration.php" method="post">

        <div class="formrow">
            Username:<br> <input type="text" name="_username" id="_username" required pattern="[a-zA-Z0-9]{4,10}" title="Please use alhpabets and numbers, dont use symbols. Minimum 4, maximum 10 character.">
        </div>
        <div class="formrow">
            Password:<br> <input type="password" name="_pswd" id="_pswd" required>
        </div>
        <div class="formrow">
            Password again:<br> <input type="password" name="_pswd2" id="_pswd2" required>
        </div>

        <button type="submit">Sign Up</button>
    </form>
    <form action="index.php" method="post">
        <input type="hidden" name="content" value="main">
        <button type="submit">Back</button>
    </form>
</main>