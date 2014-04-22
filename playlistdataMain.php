<?php

function e($data)
{
    echo '<pre>';
    print_r($data);
    exit;
    
}

$json_string = 'https://gdata.youtube.com/feeds/api/playlists/VnCEiQqNkQrbVPQau0Z9kKcX3ZyKym8u?v=2&alt=json';

$jsondata = file_get_contents($json_string);
$obj = json_decode($jsondata, true);
//echo '<pre>'; print_r($obj);exit;
$playlistid=$obj['feed']['yt$playlistId']['$t'];
$obj=$obj['feed']['entry'];
$i=1;
//    foreach($obj as $movie)
//    {
//        
//        echo $i++.'.'. $movie['title']['$t'].'<br/>';
//        
//        
//
//    }exit;
//
//echo '<pre>';
//print_r($obj['feed']['entry']);exit;

?> 
 
 
 <html>

	<head> 
    	<title>Playlist Data </title>
         
    </head>
    <body>
    
    
    	<div id='content'>
         <label> Playlist Id</label> <?=$playlistid ?><br/>    
        <?php 
            
                foreach($obj as $movie)
                { ?>
            
         <?= $i++.'.' ?>   <a href='<?=$movie['link'][0]['href'] ?>'> <?=$movie['title']['$t'] ?></a> <br/>
         <label>Video id  : </label> <?=$movie['media$group']['yt$videoid']['$t'] ?>
         <br/>
        
         <div>
             <br/>
             <?php $details=$movie['media$group']['media$credit'];
           
             foreach($details as $cast)
             {
                
                if(array_search('Director', $cast) == 'role')
                {
                    $dic=$cast['$t'];
                }else if(array_search('Writer', $cast) == 'role')
                {
                    $writer=$cast['$t'];
                }else if(array_search('Producer', $cast) == 'role')
                {
                    $poc=$cast['$t'];
                }        
                        
             }    
             ?>
             Director: <?= $dic ?> <br/>
             Writer: <?= $writer ?> <br/>
             Producer: <?= $poc ?> <br/><br/>
            
           <?php  print_r($movie['media$group']['media$description']['$t']);  ?>
         
         </div> <br/>
         
                    
         <?php  }
        
        
        
        
        ?>
        </div>
    
    </body>
</html> 

 
 