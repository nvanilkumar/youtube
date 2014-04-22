<?php


//**************************************
//     Page load Class List    //
//**************************************
 function getCategory($id)
{
 include('global.inc.php');	

 //$cat=$_POST['cat'];
 
 
					$sql="select * from categories";
					$result = $db->query($sql);
					
 					
					if(isset($id) and $id >0)
					{
						//To Bring Selected Category
					$sql1="select * from categories where catid=$id";
					$result1 = $db->query($sql1);
					$row1 = $result1->fetch();	
					$pieces = explode("-", $row1['catname']);
					echo '<option value="'.$cat.'" selected="selected" >'.$pieces[1].'</option>';
					}
					else
					{
						
					echo '<option value="0" selected="selected" disabled="disabled">Select a Category</option>';

					}
					
					
					
			 		while ($row = $result->fetch())
					{
					  $pieces = explode("-", $row['catname']);
 					echo '<option value="'.$row['catid'].'">'.$pieces[1]. '</option>';
					}
				    
					echo '<option value="others">others</option>';
		
						
}



 
//**************************************
//    view articals   //
//**************************************

function viewarticals($page)
{
	 include('global.inc.php');	
	 
	 $sql="select * from articles";
	 $result = $db->query($sql);
	 
	 $count=$result->size();
	 $pagecount=1;//2 records per page
	 $npages=ceil($count/$pagecount);
	 if($page<0 || $page>$npages)
	 $page=1;
	 $start = ($page-1)*$pagecount;
			
			
     if($npages==$page)
	 $pagecount=($count-$start);
	 
	 if($count>0)
	 {
	 	 $sql="select * from articles ORDER BY  aid DESC limit $start,$pagecount";
		 $result = $db->query($sql);
	 
	 while ($row = $result->fetch()) 
		{
			$output.='
			<tr> <td> '.$row['title']. '</td> 
			<td> <a href="updatearticle.php?&id='.$row['aid'].'" >Updat </a>
			<br/>
			<a href="deletearticle.php?&type=artdelete&id='.$row['aid'].'&type=articledelete" onclick="return confirmAction();" >Delete </a>
			</td>
			</tr>
			';
		}
		 $output.=pagination($page,$npages);
		$output.='</table>';
		
	 }
	 else
	 $output="no record found";
	echo $output;
}


 
//**************************************
//    pageination for articalses   //
//**************************************

//Page Numbers  curent page, No of pages count, query type, query id
 function pagination($cn,$count)
{
 	$prev=1;
	$next=1;
 	
	if($cn==1)
	$prev=$cn;
	else
	$prev=$cn-1;
	
	if($cn==$count)
	$next=$cn;
	else
	$next=$cn+1;
	
	 
	  
		  $output='
	 
	 
 
  <tr >
    <td colspan="2">
    <div class="pagenation">
    <ul>
    <li><a href="viewarticals.php?&page='.$prev.'">Prev</a></li>  
	';
	
		  if($count>0)
		 {
			for($i=1;$i<=$count;$i++)
			$output.='
			 <li><a href="viewarticals.php?&page='.$i.'">'.$i.'</a></li>
			 
			 ';
		  }//count if
 

      
	 $output.='
	 
	 
	  <li><a href="viewarticals.php?&page='.$next.'">Next</a></li>
	  
	  </ul>
    </div>
	
	</td>
	 
	</tr>
 ';
	 
	 
	 
	return $output; 
	
}


//**************************************
//    view articals   //
//**************************************

function viewcomments($aid)
{
	 include('global.inc.php');	
	 
 $sql="select * from comments where aid='$aid'";
$result = $db->query($sql);
$count=$result->size();
if($count>0)
{
	 
	$result = $db->query($sql);
	$output.='
		<div class="admincommentsbox">';
	while ($row = $result->fetch()) 
		{
		
		$output.='
		 
<table width="100%">
  <tr>
    <td><span>Name</span> : '.$row['uname'].'</td>
    <td align="right"c class=""><span>Date</span> : '.$row['date'].'</td>
  </tr>
  <tr>
    <td></td>
    <td align="right"><a href="deletearticle.php?&id='.$row[cid].'&type=ardel&aid='.$aid.'" onclick="return confirmAction();">Delete</a></td>
  </tr>
  <tr>
    <td colspan="2">
    comments'.$row['comments'].'
    </td>
  </tr>
</table>

 
		
		';
		}
		$output.='</div>';
		echo $output;
	
}

}
		



?>