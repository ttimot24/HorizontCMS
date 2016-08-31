
<div class='container main-container'>
<div class='row'>
<div class='col-md-12'>

<h2 class='pull-left'>Categories:</h2>



<form action='admin/category/add' class='form-inline' role='form' method='POST'>
<div style='text-align:right;'>
</br>
<label for='cat'>Add category:</label> 
	<div class='form-group'>
		<div class='col-sm-6'>  
			<input type='text' class='form-control' id='cat' name='name' placeholder='Enter new category' required>
	</div></div> 
<div class='form-group'>
 <button type='submit' class='btn btn-primary'>Add</button> 
 </div>
 </div></form>
 
<table class='table table-hover' style='margin-top:5%;'>
    <thead>
      <tr>
      	<th>Id</th>
      	<th>Category name</th>
        <th>Posts</th>
        <th><center>Action</center></th>
      </tr>
    </thead><tbody>

<?php 


	foreach($data['all_category'] as $each){
	echo  "<tr>
			<td>" .$each->id."</td>
	        <td>" .$each->name."</td>";      

	echo "<td><span class='badge'>".$each->count_posts()."</span></td>";

	echo   "<td><center>";

	        echo "<div class='btn-group' role='group'>
         		<a href='admin/category/edit/".$each->id."' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>Edit</a>
           		<a href='admin/category/delete/".$each->id."' type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
       		</div>";

	      echo "</center></td></tr>";
	}


?>



	</tbody>
  </table>

</div>
</div>
</div>
