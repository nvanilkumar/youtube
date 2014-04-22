<?
$json_string = 'https://gdata.youtube.com/feeds/api/playlists/VnCEiQqNkQrbVPQau0Z9kKcX3ZyKym8u?v=2&alt=json';

$jsondata = file_get_contents($json_string);
$obj = json_decode($jsondata, true);
//echo '<pre>'; print_r($obj);exit;
$obj=$obj['feed']['entry'];
$i=1;
    foreach($obj as $movie)
    {
      echo '<pre>';
print_r($movie);exit;
        //echo $i++.'.'. $movie['title']['$t'].'<br/>';
        

    }exit;

echo '<pre>';
print_r($obj['feed']['entry']);exit;

?> 
 
 
 <html>

	<head> 
    	<title>Playlist Data </title>
         <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
         <script>
		 
		 	$(document).ready(function(e) {
          
				
				    $.getJSON('https://gdata.youtube.com/feeds/api/playlists/VnCEiQqNkQrbVPQau0Z9kKcX3ZyKym8u?v=2&alt=json',		
					function(response)
					{
						alert(1);var i=0;
						$(response).find('.entry').each(function(){
							alert('test : '+ i +$( this ).text());	i++;
						});
						 
	   
						//$('#content').append('test'+response.length);
 
					});
 
					 
						 
            });
		 </script>
         
    </head>
    <body>
    
    
    	<div id='content'>
        </div>
    
    </body>
</html> 
 