<!-- <html>

	<head> 
    	<title>Playlist Data </title>
         <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
         <script>
		 
		 	$(document).ready(function(e) {
          
				
				    $.getJSON('https://gdata.youtube.com/feeds/api/playlists/VnCEiQqNkQrbVPQau0Z9kKcX3ZyKym8u?v=2',		
					function(response)
					{
						
						
						 
					//alert(response);  
						$('#content').append('test'+response.length);
/*						alert(data.length);                        // 2
  alert(data[0].depot.intersection.second);  // "King"
  alert(data[0].vehicle[1].category);        // "Hybrid car"
  alert(data[1].depot.address.city);  */
		 
					});
 
					 
						 
            });
		 </script>
         
    </head>
    <body>
    
    
    	<div id='content'>
        </div>
    
    </body>
</html> -->

<!DOCTYPE html 
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Listing videos in a category</title>
  </head>
  <body>
    <?php
    // set feed URL
    // add category
    $feedURL = 'https://gdata.youtube.com/feeds/api/playlists/VnCEiQqNkQrbVPQau0Z9kKcX3ZyKym8u?v=2';
    
    // read feed into SimpleXML object
    $sxml = simplexml_load_file($feedURL);
    
    // get summary counts from opensearch: namespace
    $counts = $sxml->children('http://a9.com/-/spec/opensearchrss/1.0/');
    $total = $counts->totalResults;  
    ?>
    <h1><?php echo $sxml->title; ?></h1>
    <?php echo $total; ?> items found.
    <p/>
    <ol>
    <?php    
    // iterate over entries in category
    // print each entry's details
    foreach ($sxml->entry as $entry) {
      // get nodes in media: namespace for media information
      $media = $entry->children('http://search.yahoo.com/mrss/');
      
      // get video player URL
      $attrs = $media->group->player->attributes();
      $watch = $attrs['url']; 
      
      // get <yt:duration> node for video length
      $yt = $media->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->duration->attributes();
      $length = $attrs['seconds']; 
      
      // get <gd:rating> node for video ratings
      $gd = $entry->children('http://schemas.google.com/g/2005'); 
      if ($gd->rating) {
        $attrs = $gd->rating->attributes();
        $rating = $attrs['average']; 
      } else {
        $rating = 0; 
      } 
            
      // print record
      echo "<li>\n";
      echo "<a href=\"{$watch}\">{$media->group->title}</a>
      <br/>\n";
      echo sprintf("%0.2f", $length/60) . " min. | {$rating} user rating
      <br/>\n";
      echo "{$media->group->description}<p/>\n";
      echo "<p/></li>\n";
    }
    ?>
    </ol>
  </body>
</html>