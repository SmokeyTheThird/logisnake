<?php
if (!isset($_SESSION)) session_start();
if (isset($_POST) && isset($_POST["level"]))
{
    include "filehandling.php";

    $data = read_data("passed.lsd", $_SESSION["user_key"], 0);


    if($data[0]==-1)
    {
        $data = [$_SESSION["user_key"], $_POST["steps"]];
    }
    else if(count($data) == $_POST["level"])
    {
        $data[] = $_POST["steps"];
    }
    else
    {
        if($data[$_POST["level"]]>$_POST["steps"])
        $data[$_POST["level"]] = $_POST["steps"]; 
    }
    
    write_data("passed.lsd", $data);
    
    if ($_SESSION["passed"] < $_POST["level"]) {
        $_SESSION["passed"] = $_POST["level"];
    }
    
    if(explode(" ", $_SESSION["level"])[1] < 5)
    {
        $_SESSION["level"] = "level " . ($_POST["level"]+1);
    }

    $_SESSION["content"] = $_POST["content"];

    header('Location:index.php');
}
?>
<main>
    <table id="palya">
    <?php
        $file_path = "lvl" . explode(" ", $_SESSION["level"])[1] . ".lsd";

        $file = fopen($file_path, "r");

        $rows = 13; 
        $cols = 23;

        if ($file) 
        {
            for ($i=0; $i <= $rows; $i++) 
            { 
                $line = fgets($file);
                $line = substr($line, 0, strlen($line)-1);
                $board[$i] = explode(" ", $line);
            }
        }

        for ($i=0; $i < $rows; $i++) { 
            echo "<tr>";
            for ($j=0; $j < $cols; $j++) {

                if($board[$i][$j]=='f')
                {
                    $flag = $i*$cols+$j;
                }
                else if(strlen($board[$i][$j]) == 2 && $board[$i][$j][1]=='t')
                {
                    $k=$i;
                    $l=$j;
                    $chi = 0;
                    $prev_k = $k;
                    $prev_l = $l;
                    $nake = array($k*$cols+$l);
                    do {
                        $back_up_k = $k;
                        $back_up_l = $l;
                     

                        switch($board[$k][$l][$chi]) {
                            case 'r':
                                $l = $l+1;
                                break;
                            case 'l':
                                $l = $l-1;
                                break;
                            case 'u':
                                $k = $k-1;
                                break;
                            case 'd':
                                $k = $k+1;
                                break;
                            default:
                                break;
                        }
                        if($prev_k == $k && $prev_l == $l)
                        {
                            $k = $back_up_k;
                            $l = $back_up_l;
                            if($chi%2 == 0)
                            {
                                $chi = 1;
                            }
                            else
                            {
                                $chi = 0;
                            }
                        }
                        else
                        {
                            $nake[] = $k*$cols+$l;
                        }

                        $prev_k = $back_up_k;
                        $prev_l = $back_up_l;

                    } while ($board[$k][$l][1]!='h');
                }
                echo "<td class='{$board[$i][$j]}'></td>";
            }
            echo "</tr>";
        }
        
        fclose($file);
    ?>
</table>
<form id="backform" action="index.php" method="post">
    <input type="hidden" name="content" value="menu">
    <span id="btnback" onclick="document.getElementById('backform').submit();">Back</span>
</form>
<div id="count">Steps: 0</div>
<div id="btnrestart" onclick="location.replace('index.php')">R</div>
<div id="win">
    <div>
        <?php
        if(explode(" ", $_SESSION["level"])[1] == 5)
        {
        ?>
        You completed the game!
        <?php
        }
        else
        {
            ?>
        You won!
        <form action="game.php" method="post">
            <input type="hidden" name="level" value="<?php echo explode(" ", $_SESSION["level"])[1];?>">
            <input type="hidden" name="content" value="game">
            <input type="hidden" name="steps" id="steps" value="">
            <button>Next level</button>
        </form>
        <?php
        }
        ?>
        <form action="game.php" method="post">
            <input type="hidden" name="level" value="<?php echo explode(" ", $_SESSION["level"])[1];?>">
            <input type="hidden" name="content" value="menu">
            <input type="hidden" name="steps" id="steps" value="">
        <button type="submit">Back</button>
</form>
    </div>
</div>
<div id="lost">
    <div>
        You lost!
        <button onclick="location.replace('index.php');">Restart</button>
        <form action="index.php" method="post">
            <input type="hidden" name="content" value="menu">
            <button type="submit">Back</button>
        </form>
    </div>
</div>
    <!-- <input type="hidden" id="flag" name="flag" value="3/8"> -->
    <script>
step = 0;
flag = <?php echo $flag; ?>;
snake = <?php echo json_encode($nake); ?>;
cells = document.getElementById("palya").getElementsByTagName("td");
height = document.getElementById("palya").getElementsByTagName("tr").length;
width = document.getElementById("palya").getElementsByTagName("tr")[0].cells.length;
over = false;

function remove_snake(sn)
{
    for (let index = 0; index < sn.length; index++) {
        while (cells[sn[index]].classList.length>0)
        {
            cells[sn[index]].classList.remove(cells[sn[index]].classList[0]);
        }
        cells[sn[index]].classList.add("n");
    }
}

function choose_block( prev, item, next)
{
    connect1 = item - prev;
    connect2 = item - next;
    if(connect1 == connect2)
    {
        console.log("error: lehetetlen kigyo");
        return "valami";
    }
    else if ((connect1 == 1 && connect2 == -1) || (connect1 == -1 && connect2 == 1)) 
    {  
        return("lr");
    }
    else if ((connect1 == 1 && connect2 == -width) || (connect1 == -width && connect2 == 1)) 
    {
        return("ld");    
    }
    else if ((connect1 == 1 && connect2 == width) || (connect1 == width && connect2 == 1) )
    {
        return("lu");
    }
    else if ((connect1 == width && connect2 == -width) || (connect1 == -width && connect2 == width))
    {
        return("ud");
    }
    else if((connect1 == width && connect2 == -1) || (connect1 == -1 && connect2 == width))
    {
        return("ur");
    }
    else if((connect1 == -width && connect2 == -1) || (connect1 == -1 && connect2 == -width))
    {
        return("dr");
    }
}

function litle_choose_block(item, next)
{
    connect = item-next;

    if (connect == 1)
    {
        return("l");
    }
    else if(connect == width)
    {
        return("u");
    }
    else if(connect == -1)
    {
        return("r");
    }
    else if(connect == -width)
    {
        return("d");
    }
}

function show_snake(sn)
{
    cells[sn[0]].classList.replace("n", litle_choose_block(sn[0], sn[1]) + "t");

    for (let index = 1; index < sn.length-1; index++) 
    {
        cells[sn[index]].classList.replace("n", choose_block(sn[index-1], sn[index], sn[index+1]))
    }

    cells[sn[sn.length-1]].classList.replace("n", litle_choose_block(sn[sn.length-2], sn[sn.length-1]) + "h");
}

function falling(sn)
{
    bottom = false;
    fall = true;
    for (let index = 0; index < sn.length; index++)
    {
        if (Math.floor((sn[index]+width)/width)>=height)
        {
            bottom = true;
        } 
        else
        {
            undersn = cells[sn[index]+width].classList;
            if (undersn.contains("p1") || undersn.contains("p2") || undersn.contains("p3") || undersn.contains("a")) 
            {
                fall = false;
            }
        }
    }
    if(fall && !bottom)
    {
        remove_snake(sn);
        for (let index = 0; index < sn.length; index++)
        {
            sn[index] = sn[index]+width;
        }
        show_snake(sn);
        falling(sn);
    }
    else if(bottom && fall)
    {
        document.getElementById("lost").style.display = "block";
        over = true;
    }
}

function check_win(sn)
{
    win = false;
    for (let index = 0; index < sn.length; index++)
    {
        if (sn[index] == flag)
        {
            cells[flag].classList.replace("f", "n");
            show_snake(sn);
            win = true;
        }
    }
    if (win) {
        document.getElementById("win").style.display = "block"
        document.getElementById("steps").value = step;
        over = true;
    }
}

function move_right()
{
    j = snake[snake.length-1]%width;
    i = (snake[snake.length-1]-j)/width;
    if(j<width-1)
    {
        
        contentclass = cells[snake[snake.length-1]+1].classList;
        if(contentclass[0]=="a")
        {
            remove_snake(snake);
            snake.push(i*width+j+1);
            contentclass.replace("a","n");
            show_snake(snake);
            step++;
            document.getElementById("count").innerHTML='Step: ' + step;
        }

        else if(contentclass[0]=="n" || contentclass[0][1]=='t' || contentclass[0]=="f")
        {
            remove_snake(snake);
            for (let index = 0; index < snake.length-1; index++) 
            {
                snake[index] = snake[index+1];
            }
            snake[snake.length-1] = snake[snake.length-1] + 1;
            step++;
            document.getElementById("count").innerHTML='Step: ' + step;
        }
        show_snake(snake);
        falling(snake);
        check_win(snake);
    }
}


function move_up()
{
    j = snake[snake.length-1]%width;
    i = (snake[snake.length-1]-j)/width;
    if(i>0)
    {
        
        contentclass = cells[snake[snake.length-1]-width].classList;
        if(contentclass[0]=="a")
        {
            remove_snake(snake);
            snake.push(i*width+j-width);
            contentclass.replace("a","n");
            show_snake(snake);
            step++;
            document.getElementById("count").innerHTML='Step: ' + step;
        }
        else if(contentclass[0]=="n" || contentclass[0][1]=='t' || contentclass[0]=="f")
        {
            remove_snake(snake);
            for (let index = 0; index < snake.length-1; index++) 
            {
                snake[index] = snake[index+1];
            }
            snake[snake.length-1] = snake[snake.length-1] - width;
            step++;
            document.getElementById("count").innerHTML='Step: ' + step;
        }
        show_snake(snake);
        falling(snake);
        check_win(snake);
    }
}

function move_left()
{
    j = snake[snake.length-1]%width;
    i = (snake[snake.length-1]-j)/width;
    if(j>0)
    {
        
        contentclass = cells[snake[snake.length-1]-1].classList;
        if(contentclass[0]=="a")
        {
            remove_snake(snake);
            snake.push(i*width+j-1);
            contentclass.replace("a","n");
            show_snake(snake);
            step++;
            document.getElementById("count").innerHTML='Step: ' + step;
        }
        else if(contentclass[0]=="n" || contentclass[0][1]=='t' || contentclass[0]=="f")
        {
            remove_snake(snake);
            for (let index = 0; index < snake.length-1; index++) 
            {
                snake[index] = snake[index+1];
            }
            snake[snake.length-1] = snake[snake.length-1] - 1;
            step++;
            document.getElementById("count").innerHTML='Step: ' + step;
        }
        show_snake(snake);
        falling(snake);
        check_win(snake);
    }
}

function move_down()
{
    j = snake[snake.length-1]%width;
    i = (snake[snake.length-1]-j)/width;
    if(i<height-1)
    {
        
        contentclass = cells[snake[snake.length-1]+width].classList;
        if(contentclass[0]=="a")
        {
            remove_snake(snake);
            snake.push(i*width+j+width);
            contentclass.replace("a","n");
            show_snake(snake);
            step++;
            document.getElementById("count").innerHTML='Step: ' + step;
        }
        else if(contentclass[0]=="n" || contentclass[0][1]=='t' || contentclass[0]=="f")
        {
            remove_snake(snake);
            for (let index = 0; index < snake.length-1; index++) 
            {
                snake[index] = snake[index+1];
            }
            snake[snake.length-1] = snake[snake.length-1] + width;
            step++;
            document.getElementById("count").innerHTML='Step: ' + step;
        }
        show_snake(snake);
        falling(snake);
        check_win(snake);
    }
}

window.addEventListener("keydown", function(e) {
    if(["Space","ArrowUp","ArrowDown","ArrowLeft","ArrowRight"].indexOf(e.code) > -1) {
        e.preventDefault();
    }
}, false);

document.addEventListener("keyup", function(event) {
    switch (event.key) {
        case "ArrowRight":
            if(!over)
            {
                move_right();
            }
            break;
        case "ArrowLeft":
            if(!over)
            {
                move_left();
            }
            break;
        case "ArrowUp":
            if(!over)
            {
                move_up();
            }
            break;
        case "ArrowDown":
            if(!over)
            {
                move_down();
            }
            break;
        case "r":
                location.replace("index.php");
            break;
    
        default:
            break;
    }
});
</script>
</main>