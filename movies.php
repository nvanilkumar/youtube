<?

function e($data)
{
    echo '<pre>';
    print_r($data);
    exit;
    
}

include('simplehtmldom/simple_html_dom.php');
$url_string = 'http://en.wikipedia.org/wiki/Telugu_films_of_the_1940s';

$html = file_get_html($url_string);
//$ret = $html->find('.wikitable');
//e($ret);
$table = array();
$i=0;

 
foreach($html->find('table.wikitable tr') as $row) {
   // e($row);
    $time='';$artist='';$title='';
   
 
    if( $row->find('td')->tag =='td' ) 
    //if($row->find('td') 
    {
        
         
       // e($row->find('td'));
        $time =(strlen($row->find('td',0)->plaintext) >0 )? $row->find('td',0)->plaintext:''; 
        $artist = (strlen($row->find('td',1)->plaintext) > 0)?$row->find('td',1)->plaintext:'';
        $title = (strlen($row->find('td',2)->plaintext)> 0 )?$row->find('td',2)->plaintext:'';
        $table[$i]['title']=$time;
        $table[$i]['Director']=$artist;
        $table[$i]['Cast']   =  $title;  $i++; 
        if($i==20){
            e($row->find('td'));
            return;}
    }
    
     
}

e($table);
 

//METHOD 2

//$link="http://en.wikipedia.org/wiki/Telugu_films_of_the_1940s";
//$content=file_get_contents($link);
//
//$table='<table class="wikitable" ';
//$contentEx=explode('class="wikitable"',$content);
//$contentEx1=explode("</table>",$contentEx[1]);
//$table.=$contentEx1[0].'</table>';
//e($table);
 

?> 
 
 
 <html>

	<head> 
    	<title>Playlist Data </title>
         
    </head>
    <body>
    
    
    	<div id='content'>
            
     <?php  //echo '<pre>'; print_r($ret);?>
        
        </div>
    
    </body>
</html> 

 
 