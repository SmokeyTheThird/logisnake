<main>
    <?php
    if(isset($_POST["level"]))
    {
        $_SESSION["level"] = $_POST["level"];
    }
    ?>
    <form action="index.php" method="post">
    <input type="hidden" name="content" value="game">
    <button >Start 
        <div class="level">
        <?php
        if($_SESSION["level"])
        {
            echo $_SESSION["level"];
        }
        ?>
        </div>
        </button>
        
  
    </form>
    <form action="index.php" method="post">
    <input type="hidden" name="content" value="levels">
    <button type="submit">Levels</button>
    </form>
    <form action="index.php" method="post">
    <input type="hidden" name="content" value="hint">
    <button type="submit">How to play</button>
    </form>
    <div class="user">
        <?php
        if($_SESSION["username"])
        {
            echo $_SESSION["username"];
        }
        ?> 
        <img class="btnexit" src="img/exit.png" onclick="location='logout.php'" alt="Exit" title="Exit">    
    </div>
</main>