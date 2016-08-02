<?php get_header(); ?>
<?php wp_head(); ?>
<div id="main">
<div id="content">
<h1></h1>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h1><?php the_title(); ?></h1>
<h4>Posted on <?php the_time('F jS, Y') ?></h4>
<p><?php the_content(__('(more...)')); ?></p>
<hr> <?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
</div>
<?php get_sidebar(); ?>
</div>
<div id="delimiter">
</div>
<div id='menu'>
	<ul>
		<li><div id="div_date"	>
			Date<br>
			First: <input type="text" id="date_first"><br>
			Second: <input type="text" id="date_second"><br>
			<p id="date_message"></p>
			</div>
		</li>
		<li>
			<div id='div_city'>	
				<form>
					CityName<br><input id="city_name_field" type="text" name="city_name" onkeyup="show_result(this.value)"><br>
					<div id="livesearch"></div>
				</form>
			
			</div>
		</li>
		<li>
			<div id="div_wind">
				<form>
					Windspeed(m/s):<br>
					First:<input id="first_wind_field" type="text" name="first_wind" value=""><br>
					Second:<input id="second_wind_field" type="text" name="second_wind" value=""><br>
				</form>
				<p id ="wind_message"> </p>
			</div>
		</li>
		<li>
			<div id="div_temperature">
				<form>
					Temperature(&#x2103;):<br>
					First <input id="first_temperature_field" type="text" name="first_temp" value=""><br>
					Second<input id="second_temperature_field" type="text" name="second_temp" value=""><br>
				</form>
			<p id ="temperature_message"> </p>
			</div>
		</li>
	</ul>
</div>
<div id="marker_button_div">
	<button id="marker_button">Marker</button> 
</div>
<div>
    
<!--SEARCH-->
<script>
	$(document).ready(function(){
		$("#livesearch").hide();
			});
	function isNumber(num){
			return (!isNaN(num));
				}
	function show_result(str){
		if (str.length==0) 
			{
  				document.getElementById("livesearch").innerHTML="";
    			$("#livesearch").hide();
    			return;
			}
	$(document).ready(function(){
		$.post('/wordpress/wp-admin/admin-ajax.php',{
		'action':'live_search',
		'hint':str
		},function(data){
			//var parts=data.toString().split(',');	
			document.getElementById("livesearch").style.border="1px solid #A5ACB2";
			$("#livesearch").show();
			$("#livesearch").html(data);
						});
		});
	}
</script>
<!--DateFilter FILTER-->		
<script>/*
	$(document).ready(function(){
		$("#marker_button").click(function(){
			var date1=$("#date_first").val();
            var date2=$("#date_second").val();
			//alert("date1:"+date1+"date2:"+date2);
			$.post('/wordpress/wp-admin/admin-ajax.php',{'action':'add_marker_date',
			'date_first':date1,
			'date_second':date2},function(data){
				initMarker(data,false);
			});
		});
	});*/
</script>
<!--TEMPERATURE FILTER-->
<script>	
	$(document).on('keyup keypress', function(e) {
 			 var keyCode = e.keyCode || e.which;
 			 if (keyCode === 13) { 
   			 	e.preventDefault();
   			 	return false;
 			 }
		});
    /*
		$(document).ready(function(){
			$("#marker_button").click(function(){
				var first_temp=$("#first_temperature_field").val();
				var second_temp=$("#second_temperature_field").val();
				var date1=$("#date_first").val();
               	var date2=$("#date_second").val();
				first_temp=first_temp.replace(',','.');
				second_temp=second_temp.replace(',','.');
				if(date1==null||date2==null||date1==""||date2==""){
					$("#date_message").html("no date selected");
					return ;
				}
				if((first_temp==null||first_temp==""||second_temp==null||second_temp=="")){
					return ;
				}
				else if ((isNumber(first_temp))&&(isNumber(second_temp))){
					if(first_temp>second_temp){
						$("#temperature_message").html("first bigger than second");
							return ;
					}
					else {
						if(date1==null||date2==null||date1==""||date2==""){
						$("#date_message").html("no date selected");
						return ;
					}
						else{
						$("#temperature_message").html("");
						$.post('/wordpress/wp-admin/admin-ajax.php',{ 'action': 'add_marker_temperature' ,
						'first_temp':first_temp,
						 'second_temp':second_temp,
						'date_first':date1,'date_second':date2
							},function(data){
								//$("p").html(data);
								$("#date_message").html("");
								initMarker(data,false);
								
					
						});
						}
					}
				}
				else{
					$("#temperature_message").html("invalid input ");
					return;
				}
			});
		});*/
</script>
<!--WIND FILTER-->
<script>		/*
	$(document).ready(function(){
		$("#marker_button").click(function(){
			var wind_first=$("#first_wind_field").val();
			var wind_second=$("#second_wind_field").val();
			wind_first=wind_first.replace(',','.');
			wind_second=wind_second.replace(',','.');
			var date1=$("#date_first").val();
            var date2=$("#date_second").val();
				if((wind_first==null||wind_first==""||wind_second==null||wind_second=="")){
					return ;
				}
				else  if ((isNumber(wind_first))&&(isNumber(wind_second))){
					if(wind_first>wind_second){
						$("#wind_message").html("first number bigger than second");
							return ;
						}
					else{
						if(date1==null||date2==null||date1==""||date2==""){
							$("#date_message").html("no date selected");
							return ;
						}
						else{
							$("#wind_message").html("");
							$.post('/wordpress/wp-admin/admin-ajax.php',{ 
							'action': 'add_marker_wind' ,
							'first_wind':wind_first,
							'second_wind':wind_second,
							'date_first':date1,'date_second':date2
							},function(data){
								//$("p").html(data);
								initMarker(data,false);
							});
						}
					}
				}
				else {
					$("#wind_message").html("invalid input");
					return ;
				}
		});
	});*/
</script>
<!--JS ENTER BUTTON PRESS--><!--ENTER BUTTON PRESS-->
<script type="text/javascript">  
	$(document).ready(function(){
		$( function() {
            $("#date_second").datepicker(
			{
				dateFormat: "yy-mm-dd",
      			onSelect: function(selected) {
        			$("#date_first").datepicker("option","maxDate", selected)
    			}
			});
		});
	});
    $(document).ready(function(){
    	$( function() {
        	$( "#date_first" ).datepicker(
			{
			 	dateFormat: "yy-mm-dd",
      			onSelect: function(selected) {
        			$("#date_second").datepicker("option","minDate", selected)

    			}
			 });
        } );
    });
	$(document).ready(function(){
		$(document).keypress(function(e){
			if(e.which==13){
				$("#marker_button").trigger('click');
			}
		});
	});
               
</script>
<!--JS MARKERS-->
<script>
function initMarker(coordinates,isCity){
		var lat1=42.69;
		var lng1=23.30;
		var i=0;
		var count=0; 
		var center_to_marker=false;
		var infowindow=null;
		var contentString;
		var splitted=coordinates.split("|");
		while(i<splitted.length){
			contentString=
					'City:'+splitted[i+3]+'<br>'+
					'Temperature:'+splitted[i+2]+'&#x2103<br>'+
					'Wind Speed:'+splitted[i+4]+'m/s<br>'+
					'Pressure:'+splitted[i+7]+'hPa<br>'+
					'Clouds:'+splitted[i+5]+'%<br>'+
					'Last Update:'+splitted[i+6]+'<br>';
			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});	
			var marker=new google.maps.Marker({
					position:{lat:parseFloat(splitted[(i+1)]),lng:parseFloat(splitted[i])},
					map:map,
					title:splitted[i+3],
						
			});	
				if(splitted.length>6){
					if(center_to_marker==false&&isCity==false){
						map.setCenter(marker.getPosition());
						center_to_marker=true;
						map.setZoom(10);
				}
					if(center_to_marker==false&&isCity==true){
						map.setCenter(marker.getPosition());
						center_to_marker=true;
						map.setZoom(10);
					}
				}
				google.maps.event.addListener(marker, 'dblclick',(function(marker){
					return function(){
						map.setCenter(marker.getPosition());
						map.setZoom(10);
					};
				})(marker));
				google.maps.event.addListener(marker,'click', (function(marker,contentString,infowindow){ 
					return function() {
					infowindow.setContent(contentString);
					infowindow.open(map,marker);
					};
				})(marker,contentString,infowindow));  
				contentString=null;
				i=i+8;
		}
	}
</script>
<!--filter-->
    <script>
   $(document).ready(function(){
    $("#marker_button").click(function(){
        var city_name=$("#city_name_field").val();    
        var wind_first=$("#first_wind_field").val();
		var wind_second=$("#second_wind_field").val();
		wind_first=wind_first.replace(',','.');
		wind_second=wind_second.replace(',','.');
        var first_temp=$("#first_temperature_field").val();
		var second_temp=$("#second_temperature_field").val();
		var date1=$("#date_first").val();
        var date2=$("#date_second").val();
        if(parseFloat(first_temp)>parsefloat(second_temp)){
        first_temp=null;
            second_temp=null;
            $("#temperature_message").html("first temperature cannot be greater than second");
            
        }
         if(parseFloat(wind_first)>parsefloat(wind_second)){
        first_temp=null;
            second_temp=null;
            $("#wind_message").html("first windsepeed cannot be greater than the second");
            
        }
		first_temp=first_temp.replace(',','.');
		second_temp=second_temp.replace(',','.');
        $.post('/wordpress/wp-admin/admin-ajax.php',{
            'action':'add_marker',
            'hint':city_name,
            'wind1':wind_first,
            'wind2':wind_second,
            'temperature1':first_temp,
            'temperature2':second_temp,
            'date1':date1,
            'date2':date2
        },function(data){
        initMarker(data,false);
        });
    });
   });
    </script>
<!--CITY FILTER-->
<script>/*
	$(document).ready(function(){
		$("#marker_button").click(function(){
			var city_name=$("#city_name_field").val();
			var date1=$("#date_first").val();
			var date2=$("#date_second").val();
				if((city_name==null||city_name=="")){
					return ;
				}
				else {
					if(date1==null||date2==null||date1==""||date2==""){
						$("#date_message").html("no date selected");
						return ;
					}
						else{
					$.post('/wordpress/wp-admin/admin-ajax.php',
						   { 'action': 'add_marker_city' ,
							'hint':city_name,'date_first':date1,
							'date_second':date2
					},function(data){
					//	$("p").html(data);
						//alert("date1:"+date1);
						//alert("date2:"+date2);
						initMarker(data,true);
						$("#date_message").html("");
					});
						}
				}
		});
	});*/
</script>	
</div>
<!--INIT MAP-->
<div id="myMap"></div>
<script>
	var map;
	function initMap() {
		var center = {lat: 42.697365, lng: 23.303687};
		map = new google.maps.Map(document.getElementById('myMap'), {
			center: center,
			zoom: 3,	
		});
		
	}
</script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCu7fLSb6ljOfthHTTkPu5kCxDkDhrDHhs&libraries=places&callback=initMap'
				async defer></script>

<?php get_footer(); ?>
