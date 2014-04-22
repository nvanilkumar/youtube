<?php
function e($data)
{
    echo '<pre>';
    print_r($data);
    exit;
    
}


include('simplehtmldom/simple_html_dom.php');
$url_string = 'http://en.wikipedia.org/wiki/Telugu_films_of_the_1980s';
$html = file_get_html($url_string);
 

$output = '<table border="1">
                <tr>
                    <td>title</td>
                    <td>Director</td>
                    <td>cast</td>
                    <td>genre</td>
                    <td>notes-2</td>
                     
                </tr>
            ';
 

foreach($html->find('table[class=wikitable] tr') as $tr){
    $output .= '<tr>';
    $tds = $tr->find('td');$i=1;
	//$year='';
    foreach($tds as $td)
    {
 
        $inner_table = $td->find('table',0);
 
		 if($td->colspan == 7)
		 {
			 $year=$td->plaintext;
			 
		 }
         if((!$inner_table) &&($td->colspan !=7))
         {  
            $text = trim($td->plaintext);
			$url='';
 			if(is_object($td->find('i a',0)))
			{
				$url='http://en.wikipedia.org/'.$td->find('i a',0)->href;
				$output .= '<td> <a href="'.$url.'"> ' . $td->plaintext .'</a> <br/> '.$year.'</td>';
			}else if(is_object($td->find('a',0))) {
                            $url='http://en.wikipedia.org/'.$td->find('a',0)->href;
			    $output .= '<td> <a href="'.$url.'"> ' . $td->plaintext .'</a> <br/> '.$year.'</td>';
                        
                        }else{
				 $output .= '<td>  ' . $td->plaintext .'</td>';
			
			}
  
           
        }  
    }
    $output .= '</tr>';
}

$output .= '</table>';

echo($output);

?>