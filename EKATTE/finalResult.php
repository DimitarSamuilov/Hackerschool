<?php 
    
    $answer='';
    $db= new mysqli('localhost','****','****','EKATTE');
        if($db->connect_errno>0){
            echo $db->connect_error;
            die();
    }
    $count_args=0;
    $hint=mysqli_real_escape_string($db,$_POST["search"]);
    $select_table=mysqli_real_escape_string($db,$_POST["select_cat"]);
    $db->set_charset("utf8");   
    
    $query="select Ek_atte.NAME as grad ,Ek_obst.NAME  obstina , Ek_obl.NAME AS oblast ,Ek_tsb.NAME ,Ek_atte.KIND
    FROM Ek_atte 
    JOIN Ek_obst on Ek_atte.OBSTINA=Ek_obst.OBSTINA
    JOIN Ek_obl ON Ek_obst.OBLAST=Ek_obl.OBLAST
    JOIN Ek_tsb ON Ek_atte.TSB=Ek_tsb.TSB 
    WHERE ".$select_table.".NAME LIKE '".$hint."%';";
    
        if(!$result=$db->query($query)){
               echo $db->error;
        die();
    }
    while($row=$result->fetch_array(MYSQLI_NUM)){
        $answer=$answer.$row[0].'|'.$row[1].'|'.$row[2].'|'.$row[3].'|';
        if(!strcmp('1',$row[4])){
        $answer=$answer.'град|';
        }
        if(!strcmp('3',$row[4])){
        $answer=$answer.'село|';
        }
        if(!strcmp('7',$row[4])){
        $answer=$answer.'манастир|';
        }
    }
   $result->free();
    $db->close();
    echo $answer;
    die();
?>
