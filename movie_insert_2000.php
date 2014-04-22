<?php

require_once('inc/mysql.class.php');
require_once('inc/global.inc.php');
function e($data)
{
    echo '<pre>';
    print_r($data);
    exit;
    
}

function d($data)
{
    echo '<pre>';
    print_r($data);
     
    
}

function month_conversion($month_text)
{
   
    switch ($month_text) {
    case "J
 A
 N":
        return 01;
        break;
    case "F
 E
 B":
        return 02;
        break;
    case "M
 A
 R":
        return 03;
        break;
     case "A
 P
 R":
     return 04;
     break;
    case "M
 A
 Y":
        return 05;
        break;
     case "J
 U
 N":
        return 06;
        break;
    case "J
 U
 L":
        return 07;
        break;
     case "A
 U
 G":
        return 08;
        break;
    case "S
 E
 P":
        return 09;
        break;
     case "O
 C
 T":
        return 10;
        break;
    case "N
 O
 V":
        return 11;
        break;
     case "D
 E
 C" :
        return 12;
        break;
    default:
       e($month_text); return 0;
        break;
    }   
}

function month_conversion2($month_text)
{
   
    switch ($month_text) {
    case "J
  A
  N":
        return 01;
        break;
    case "F
  E
  B":
        return 02;
        break;
    case "M
  A
  R":
        return 03;
        break;
     case "A
  P
  R":
     return 04;
     break;
    case "M
  A
  Y":
        return 05;
        break;
     case "J
  U
  N":
        return 06;
        break;
    case "J
  U
  L":
        return 07;
        break;
     case "A
  U
  G":
        return 08;
        break;
    case "S
  E
  P":
        return 09;
        break;
     case "O
  C
  T":
        return 10;
        break;
    case "N
  O
  V":
        return 11;
        break;
     case "D
  E
  C" :
        return 12;
        break;
    default:
       e($month_text); return 0;
        break;
    
}
    
}
/* 
http://en.wikipedia.org/wiki/List_of_Telugu_films_of_2000
http://en.wikipedia.org/wiki/List_of_Telugu_films_of_2001 --for this url reset the relase date to : '0000-00-00';

http://en.wikipedia.org/wiki/List_of_Telugu_films_of_2002
http://en.wikipedia.org/wiki/List_of_Telugu_films_of_2003
 * file:///C:/Users/Anil/Desktop/List%20of%20Telugu%20films%20of%202004%20-%20Wikipedia,%20the%20free%20encyclopedia.htm
 * http://en.wikipedia.org/wiki/List_of_Telugu_films_of_2005
 * http://en.wikipedia.org/wiki/List_of_Telugu_films_of_2004
 
 
 
 * * Issues to handle if movie does not have a url
 */
include('simplehtmldom/simple_html_dom.php');
$url_string = 'List of Telugu films of 2004 - Wikipedia, the free encyclopedia.htm';
$html = file_get_html($url_string);
//$html = file_get_contents($url_string, true);
 
$i=0;
$year=substr($url_string,-4);
 //$year='2004';
$movies_list= array();
$valuesArr = array();
foreach($html->find('table[class=wikitable] tr') as $tr)
{
   $tds = $tr->find('td');  
   
    $movie=array();
    $first_td=0;
    foreach($tds as $td)
    {
        
        $inner_table = $td->find('table',0);
        
        $td_style_data=$td->getAttribute('style');
        if (strpos($td_style_data,'background') !== false) //for month td
        {
            $month=month_conversion2($td->plaintext); 
        
        }else if(($td->rowspan >= 1)) { //for release date td
            //$release_day=$td->plaintext;
            $release_day=filter_var($td->plaintext, FILTER_SANITIZE_NUMBER_INT);//feach the number from the string
           
        }else if(!$inner_table)   { //other columns in the list 
            //td -> i -> a
            if(is_object($td->find('i a',0)))
            {
                $movie['url']=(isset($movie['url']))?$movie['url']:$td->find('i a',0)->href;
            } 
           //td -> a
            if(is_object($td->find('a',0)))
            {
                $movie['url']=(isset($movie['url']))?$movie['url']:$td->find('a',0)->href;
            } 
            $text=(strlen($td->plaintext) >1)?$td->plaintext:'';
 
            $movie['release_date']=(isset($movie['release_date']))?$movie['release_date']:$year.'-'.$month.'-'.$release_day;
            $movie['year']=(isset($movie['year']))?$movie['year']:$year;
            
            array_push($movie,$text); 
        } 
	$first_td++;	 
    }//end of td
     
    if((sizeof($movie) >1) &&(!is_null($movie) ))
    { 
        $cast=mysql_real_escape_string($movie[2]);
        $gener=mysql_real_escape_string($movie[3]);
        $note=mysql_real_escape_string($movie[4]);
        $valuesArr[] = "('$movie[year]', '$movie[0]', '$movie[1]'
             ,'$cast','$gener','$note','$movie[release_date]','$movie[url]')";	
    }
		

$i++;   	/*echo '<pre>';
//
//print_r($movie);
 if($i==5)
{

 	echo '<pre>';

print_r($movie);	
exit;
}  */
     
}//end of tr
echo '<pre>';
//print_r($valuesArr);

//print_r(json_encode($valuesArr));
  $sql = "INSERT INTO utm_movie ( utm_movie_year, utm_movie_title, utm_movie_director, utm_movie_cast, utm_movie_genre,utm_movie_note,utm_movie_release_date,utm_movie_url) VALUES "; 
 
   $sql .= implode(',', $valuesArr);
  echo $sql;
  // exit;
   $result=$db->query($sql); 

?>