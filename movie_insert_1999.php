<?php

require_once('inc/mysql.class.php');
require_once('inc/global.inc.php');
function e($data)
{
    echo '<pre>';
    print_r($data);
    exit;
    
}
/* http://en.wikipedia.org/wiki/Telugu_films_of_the_1930s
 http://en.wikipedia.org/wiki/Telugu_films_of_the_1940s
 http://en.wikipedia.org/wiki/Telugu_films_of_the_1950s
 http://en.wikipedia.org/wiki/Telugu_films_of_the_1960s
 http://en.wikipedia.org/wiki/Telugu_films_of_the_1970s
 http://en.wikipedia.org/wiki/Telugu_films_of_the_1980s
 http://en.wikipedia.org/wiki/Telugu_films_of_the_1990s
 
 */
include('simplehtmldom/simple_html_dom.php');
$url_string = 'http://en.wikipedia.org/wiki/Telugu_films_of_the_1990s';
$html = file_get_html($url_string);
 
 $i=0;
$movies_list= array();
$valuesArr = array();
foreach($html->find('table[class=wikitable] tr') as $tr){
    $tds = $tr->find('td'); 
	$movie=array(); 
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
			//td -> i -> a
 			if(is_object($td->find('i a',0)))
			{
 				//array_push($movie,$td->find('i a',0)->href);
				//array_push($movie,$year);
				$movie['url']=(isset($movie['url']))?$movie['url']:$td->find('i a',0)->href;
	 		} 
			
			//td -> a
 			if(is_object($td->find('a',0)))
			{
 				//array_push($movie,$td->find('a',0)->href);
				//array_push($movie,$year);
				$movie['url']=(isset($movie['url']))?$movie['url']:$td->find('i a',0)->href;
				
 			} 
			
			$movie['year']=$year; 
			$text=(strlen($td->plaintext) >1)?$td->plaintext:'';
			array_push($movie,$text); 
         } 
		 
    }//end of td
	 
    
	if((sizeof($movie) >1) &&(!is_null($movie) ))
	{ 
		//array_push($movies_list,$movie);
		$cast=mysql_real_escape_string($movie[2]);
		$gener=mysql_real_escape_string($movie[3]);
		$note=mysql_real_escape_string($movie[4]);
		 
		
		$valuesArr[] = "('$movie[year]', '$movie[0]', '$movie[1]'
		 ,'$cast','$gener','$note','$movie[url]')";	
	}
		

$i++;  /*	echo '<pre>';

print_r($movie);
 if($i==50)
{

 	echo '<pre>';

print_r($movie);	exit;
}*/ 
     
}//end of tr
echo '<pre>';
print_r($valuesArr);
 $sql = "INSERT INTO utm_movie ( utm_movie_year, utm_movie_title, utm_movie_director, utm_movie_cast, utm_movie_genre,utm_movie_note,utm_movie_url) VALUES "; 
 
   $sql .= implode(',', $valuesArr);
   echo $sql;exit;
   $result=$db->query($sql);

?>