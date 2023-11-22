<?php
function read_data($file_path, $value, $colnum)
{ 
    $file = fopen($file_path,"r");
    
    if($file)
    {
        $line  = fgets($file);
        $line = substr($line, 0, strlen($line)-1);
        $data = explode(" ", $line);
        while(!feof($file) && $data[$colnum]!=$value)
        {
            $line  = fgets($file);
            $line = substr($line, 0, strlen($line)-1);
            $data = explode(" ", $line);
        }
        if(feof($file))
        {
            $data[$colnum] = -1;
        }

        return $data;
    }
    else
    {
        echo "Nincs fajl megnyitva";
    }
    fclose($file);
}

function max_user_key($file_path)
{
    $file = fopen($file_path,"r");
    
    if($file)
    {
        $line  = fgets($file);
        $max_user_key = 0;
        while(!feof($file))
        {
            $line  = fgets($file);
            $data = explode(" ", $line);

            if($max_user_key < $data[0])
            {
                $max_user_key = $data[0];
            }
        }

        return $max_user_key;
    }
    else
    {
        echo "Nincs fajl megnyitva";
    }
    fclose($file);
}

function write_data($file_path, $data)
{

    $lines = file($file_path, FILE_IGNORE_NEW_LINES);

    $index = 0;
    while($data[0]!=explode(" ", $lines[$index])[0] && $index<count($lines))
    {
        $index++;
    }
    if($index<count($lines))
    {
        $lines[$index] = implode(" ", $data);
    }
    else
    {
       $lines[] = implode(" ", $data);
    }

    file_put_contents($file_path, implode("\n", $lines) . PHP_EOL);

}

?>