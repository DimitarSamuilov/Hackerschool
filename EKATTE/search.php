<?php 
    $answer='';
    $db= new mysqli('localhost','**','**','EKATTE');
        if($db->connect_errno>0){
            echo $db->connect_error;
            die();
    }
    $count_args=0;
    $search=mysqli_real_escape_string($db,$_POST["search"]);
    $db->set_charset("utf8");
    $query="SELECT NAME FROM Ek_atte
        WHERE NAME LIKE '".$search."%'
        limit 10;";
        if(!$result=$db->query($query)){
               echo $db->error;
        die();
    }
    while($row=$result->fetch_array(MYSQLI_ASSOC)){
        $answer=$answer.$row['NAME'].'|';
    }
    $query="SELECT NAME FROM Ek_obl
        WHERE NAME LIKE '".$search."%'
        limit 10;";
        if(!$result=$db->query($query)){
               echo $db->error;
        die();
    }
    while($row=$result->fetch_array(MYSQLI_ASSOC)){
        $answer=$answer.$row['NAME'].'|';
    }
$query="SELECT NAME FROM Ek_obst
        WHERE NAME LIKE '".$search."%'
        limit 10;";
        if(!$result=$db->query($query)){
               echo $db->error;
        die();
    }
    while($row=$result->fetch_array(MYSQLI_ASSOC)){
        $answer=$answer.$row['NAME'].'|';
    }
   $result->free();
    $db->close();
    echo $answer;
    die();
?>
