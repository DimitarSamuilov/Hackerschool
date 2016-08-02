<html>
    <head>
        <title>EKATTE</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    </head>
    <body>
        <p></p>
        <script>
           
            $(document).ready(function(){
                 var select_cat='Ek_atte';
                $(document).on('keyup keypress', function(e) {
 			        var keyCode = e.keyCode || e.which;
 			        if (keyCode === 13) { 
   			 	        e.preventDefault();
   			 	        return false;
 			        }  
		       });
                $(document).keypress(function(e){
			        if(e.which==13){
				        $("#get_info").trigger('click');
			        }
		        });
                
                $.widget( "custom.catcomplete", $.ui.autocomplete, {
                    _create: function() {
                        this._super();
                        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
                    },
                    _renderMenu: function( ul, items ) {
                        var that = this,
                        currentCategory = "";
                $.each( items, function( index, item ) {
                    var li;
                    if ( item.category != currentCategory ) {
                        ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                        currentCategory = item.category;
                    }
                    li = that._renderItemData( ul, item );
                    if ( item.category ) {
                        li.attr( "aria-label", item.category + " : " + item.label );
                    }
                });
                }
            });
                $('#search').keyup(function(){
                    var search=$('#search').val();
                    var selecter='Ek_atte';
                    var array=[];
                        $.post('search.php',{
                            search:search,
                            selecter:selecter
                        },function(data){
                             array=[];
                            array=fill_search_array(data,array);
                            
                       
                       $('#search').catcomplete({
                          delay: 0,
                        source:array,
                           select:function(event,ui){
                            select_cat=ui.item.category;
                               
                               if(select_cat=='Град:'){
                                select_cat='Ek_atte';
                               }
                               else if(select_cat=='Община:'){
                                select_cat='Ek_obst';
                               }
                               else  if(select_cat=='Област:'){
                                select_cat='Ek_obl';
                               }
                               else {
                               select_cat='Ek_atte';
                               }
                              //alert(select_cat);
                            
                           }
                                });
                           
                       });
                });
                $('#get_info').click(function(){
                 
                    var search=$('#search').val(); 
                   
                    if(search==null||search==''){
                        alert('не е въведена информация в полето');
                        return ;
                    }
                    $.post('finalResult.php',{
                            search:search,
                            select_cat:select_cat
                    },function(data){
                    
                    display(data);
                    });
                });
            });
            
            function fill_search_array(data,array){
                var splitted=data.split('|');
                //var result=[];
                var i=0;
                var str;
                var obj;
                while(i<splitted.length){
                    str=splitted[i];
                     obj={label:str, category: 'Град:'};
                    array.push(obj);
                    str=splitted[i+1];
                     obj={label:str, category: 'Община:'};
                    array.push(obj);
                    str=splitted[i+2];
                     obj={label:str, category: 'Област:'};
                    array.push(obj);
                    i=i+3;
                }
                i=0;
                array.sort(function (a,b){
                if(a.category<b.category)
                {
                    return -1;
                }
                if(a.category>b.category)
                {
                    return 1;
                }
                 return 0;   
                })
                return array;
            
            
            
            }
             function display(data){
                var i=0;
                var information=data.split('|');
                //alert(information.length);
                if(information.length==1){
                    alert ('Няма резултати за въведените полета ');
                    return;
                }
                else {
                    var table='<table id="info_table"><tr><th>Населено място</th><th>Вид</th><th>Община</th><th>Област</th><th>Териториални статистически бюра</th></tr>';
                    while(i<information.length-5){
                        table=table+'<tr><th>'+information[i]+'</th><th>'+information[i+4]+'</th><th>'+information[i+1]+'</th><th>'+information[i+2]+'</th><th>'+information[i+3]+'</th></tr>';
                        i=i+5;
                }
                    table=table+'</table>';
                    $("#info_holder").html(table);
                }
            }
        </script>
        <div class="ui-widget">
            <form  accept-charset="UTF-8">
                <label for="search">Търси: </label>
                <input id="search">

            </form>    
            <button id="get_info">Информация</button>
        </div>
        <div id="info_holder"></div>
        <p></p>
    </body>
</html>
