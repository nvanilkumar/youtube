<?php

$movie_list=array();
for($i=0; $i<5;$i++)
{
	$movie=array();
	for($j=0; $j<5;$j++)
	{
		array_push($movie,$j+1);
	}
	array_push($movie_list,$movie);	
}
echo '<pre>';
print_r($movie_list);