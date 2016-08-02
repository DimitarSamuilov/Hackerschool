<?php

// Set up

//Includes 

//Action & Filter Hooks
add_action('init', 'include_jQuery');
add_action('wp_ajax_live_search','search');
add_action('wp_ajax_nopriv_live_search',' search');
add_action('wp_head', 'import');
add_action('wp_ajax_nopriv_add_marker','get_final_filter_coordinates');
add_action('wp_ajax_add_marker','get_final_filter_coordinates');


function import(){
    echo ' <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">';
    echo '<script src="https://code.jquery.com/jquery-1.12.4.js"></script>';
    echo '<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>';
}

function search(){	
    $hint=$_POST["hint"];
    $coordinates='';
    $db= new mysqli('localhost','','','wordpress');
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $temp1=200;
        $temp2=300;	
        $sqlQuery='call wordpress.live_search(\''.$hint.'\');';
            if(!$result = $db->query($sqlQuery)){
                die('There was an error running the query [' . $db->error . ']');
            }
        $num=$result->num_rows;
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $coordinates=$coordinates.$row['cityName'].'<br>';
        }
        if(4==strlen($coordinates)){
            echo 'no luck';
        }
        else 
            echo $coordinates;
        $result->free();
        $db->close();
        die();
}
function include_jQuery() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
    }
}
function get_final_filter_coordinates(){
    $city_name=$_POST["hint"];
    $input1=$_POST["temperature1"];
	$input2=$_POST["temperature2"];
    $date1=$_POST["date1"];
    $date2=$_POST["date2"];
    $temperature1;
    $temperature2;
    if($input1!=null&&$input2!=null){
	$temperature1=floatval($input1);
	$temperature2=floatval($input2);
    $temperature1=$temperature1+273.15;
	$temperature2=$temperature2+273.15;
    }
    $input3=$_POST["wind1"];
	$input4=$_POST["wind2"];
    $wind1=floatval($input3);
	$wind2=floatval($input4);
    $filterCount=0;
    $coordinates='';
    $db= new mysqli('localhost','','','wordpress');
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
 $filterCount=0;
    $sqlQuery='SELECT * FROM wordpress.locations1 ';
    if($city_name!=null){
        if($filterCount==0){
        
        $sqlQuery=$sqlQuery.' where cityName ="'.$city_name.'"';
        $filterCount++;
        }
        else 
        {
               $sqlQuery=$sqlQuery.' and cityName ="'.$city_name.'"';
            $filterCount++;
        }
    }
 if($temperature2!=null){
        if($filterCount==0){
        
        $sqlQuery=$sqlQuery.' where  temperature <'.$temperature2.'';
        $filterCount++;
        }
        else 
        {
               $sqlQuery=$sqlQuery.'  and temperature <'.$temperature2;
             $filterCount++;
        }
    }
if($temperature1!=null){
        if($filterCount==0){
        
        $sqlQuery=$sqlQuery.'where temperature>'.$temperature1;
        $filterCount++;
        }
        else 
        {
               $sqlQuery=$sqlQuery.' and temperature>'.$temperature1;
             $filterCount++;
        }
    }
 if(($wind1!=null)){
        if($filterCount==0){
        
        $sqlQuery=$sqlQuery.' where windSpeed>'.$wind1;
             $filterCount++;
        
        }
        else 
        {
               $sqlQuery=$sqlQuery.' and windSpeed>'.$wind1;
             $filterCount++;
        }
    }
if(($wind2!=null)){
        if($filterCount==0){
        
        $sqlQuery=$sqlQuery.' where windSpeed<'.$wind2;
             $filterCount++;
        
        }
        else 
        {
               $sqlQuery=$sqlQuery.'  and windSpeed<'.$wind2;
             $filterCount++;
        }
    }
 if(($date1!=null)){
        if($filterCount==0){
        
        $sqlQuery=$sqlQuery.' where date(lastUpdate)>="'.$date1.'"';
           $filterCount++;
        
        }
        else 
        {
               $sqlQuery=$sqlQuery.' and date(lastUpdate)>="'.$date1.'"';
             $filterCount++;
        }
    }
if(($date2!=null)){
        if($filterCount==0){
        
        $sqlQuery=$sqlQuery.' where date(lastUpdate)<="'.$date2.'"';
             $filterCount++;
        
        }
        else 
        {
               $sqlQuery=$sqlQuery.' and date(lastUpdate)<="'.$date2.'"';
             $filterCount++;
        }
    }
    $sqlQuery=$sqlQuery.';';
    
				if(!$result = $db->query($sqlQuery)){
    				die('There was an error running the query [' . $db->error . ']');
				}
			$clesius_parse;
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$clesius_parse=floatval($row['temperature'])-273.15;
				$coordinates=$coordinates.$row['lon'].'|'.$row['lat'].'|'.$clesius_parse.'|'.$row['cityName'].'|'.$row['windSpeed'].'|'.$row['cloud'].'|'.$row['lastUpdate'].'|'.$row['pressure'].'|'.$row['hour_of'].'|';
				
			}
			$result->free();
			$db->close();
			echo $coordinates;
			die();
	
}
?>


