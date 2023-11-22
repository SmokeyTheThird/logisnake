<main>
    <div class="choose">
        <form action="index.php" method="post">
            <input type="hidden" name="content" value="menu">
            <input type="hidden" name="level" value="level 1">
            <button>level 1</button>
        </form>
        <form action="index.php" method="post">
            <input type="hidden" name="content" value="menu">
            <input type="hidden" name="level" value="level 2">
            <button <?php if($_SESSION["passed"] < 1){echo "disabled class='inactive'";}?> >level 2</button>
        </form>
        <form action="index.php" method="post">
            <input type="hidden" name="content" value="menu">
            <input type="hidden" name="level" value="level 3">
            <button <?php if($_SESSION["passed"] < 2){echo "disabled class='inactive'";}?> >level 3</button>
        </form>
        <form action="index.php" method="post">
            <input type="hidden" name="content" value="menu">
            <input type="hidden" name="level" value="level 4">
            <button <?php if($_SESSION["passed"] < 3){echo "disabled class='inactive'";}?> >level 4</button>
        </form>
        <form action="index.php" method="post">
            <input type="hidden" name="content" value="menu">
            <input type="hidden" name="level" value="level 5">
            <button  <?php if($_SESSION["passed"] < 4){echo "disabled class='inactive'";}?> >level 5</button>
        </form>
    </div>
</main>