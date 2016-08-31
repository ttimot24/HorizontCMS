<div class='container main-container'>


<h1>Develop theme</h1>
<div id='project'></div>
<a type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='.create_new_theme' style='margin-right:10px;'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Create new theme</a>
<a type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='.open_theme'><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span> &nbsp&nbspOpen theme</a>
</br>
<br>
<a type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='.create_new' style='margin-right:10px;'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Create new plugin</a>
<a type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='.open_theme'><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span> &nbsp&nbspOpen plugin</a>
</br>
<br>
<a type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='.create_new' style='margin-right:10px;'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Create new language</a>
<a type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='.open_theme'><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span> &nbsp&nbspOpen language</a>
</br>


<div class='modal create_new_theme' id='create_new' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog  modal-lg'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>New theme</h4>
      </div>
      <form class='form-horizontal' role='form' action='admin/develop/newtheme' method='POST'>
      <div class='modal-body'>
      	<section class='row'>
      	<div class='col-md-6'>
        <div class='col-md-12'>
        <div class='form-group'>
            <label class='control-label' for='theme_name'>Theme name:</label>        
            <input type='text' name='pj_name' class='form-control' id='theme_name' placeholder='Enter project name' required/>
          </div>

          <div class='form-group'>
            <label class='control-label' for='theme_description'>Description:</label>        
            <textarea type='text' name='theme_description' class='form-control' id='theme_description' placeholder='Enter description here' ></textarea>
          </div>

          </div>
		    </div>
        <div class='col-md-6'>
          <div class='col-md-12'>
          <div class='form-group'>
            <label class='control-label' for='theme_name'>Author name:</label>        
            <input type='text' name='author_name' class='form-control' id='author_name' placeholder='Enter your name' />
          </div>

          <div class='form-group'>
            <label class='control-label' for='author_url'>Author Url:</label>        
            <input type='text' name='author_url' class='form-control' id='author_url' placeholder='Enter your url' />
          </div>

          </div>
        </div>
		</section>
      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Start developing</button>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class='modal open_theme' id='open_theme' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Open theme</h4>
      </div>
      <div class='modal-body'>
    
<ul class='list-group'>
<?php
      foreach($data['dirs'] as $each){

      	echo "<li class='list-group-item col-md-3'>
        <a href='admin/develop/opentheme/".$each->dir_name."'>" 
        .Html::img($each->image,"class='col-md-6' style='height:80px;'") ."<br>". $each->dir_name ."</a>
        </li>";
    

      }
?>
</ul>


        </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->











</div><br><br>