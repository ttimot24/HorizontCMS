<section class='container'>
<h2>File manager</h2>

	<!--<div class="col-md-12" >
	    <div>
	       	<button class='btn btn-primary pull-right'>New folder</button>
	    </div>
	</div>-->

<div class='panel panel-default col-md-3' style='padding:0px;'>
 <ul class="list-group">
  <li class="list-group-item">images</li>
  <li class="list-group-item">uploads</li>
  <li class="list-group-item">themes</li>
  <li class="list-group-item">plugins</li>
</ul>
</div>


<div class="panel panel-default col-md-9" >
          <div class="panel-body">
          	<ol class="breadcrumb">
			  <li><a href="#">root</a></li>
			  <li><a href="#"><?= str_replace("/","</a></li><li><a href='#'>",$data['current_dir']) ?></a></li>
			</ol>
            <?php 
            	foreach($data['files'] as $file){
            		echo "<div class='file col-md-2' style='overflow:hidden;height:140px;cursor:pointer;' ondblclick='window.location.href = \"admin/filemanager/dir/".$data['current_dir']."/".$file->name."\";'>";

            		$file_parts = pathinfo($file->name);

            		if(is_dir($data['current_dir'].$file->name)){
            			echo Html::img(Storage::$path.'/images/icons/dir.png',"style='width:100%;'  ");
            		}
            		else if($file_parts['extension']=='jpg' || $file_parts['extension']=='png'){
            			echo Html::img($data['current_dir'].$file->name,"style='object-fit:cover;width:100%;height:100px;' ondblclick='' ");
            		}
            		echo "<center><b>".$file->name."</b></center><br>";
            		echo "</div>";
            	}

            ?>

          </div>
        </div>

</section>


<style>

	.list-group-item:hover{
		border-radius: 0px;
		color:white;
		background-color: #337ab7;	
	}

	.file:hover{
		border-radius:3px;
		color:white;
		background-color: #337ab7;
	}
</style>