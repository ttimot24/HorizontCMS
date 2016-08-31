<div class='container main-container' id='dashboard' style='margin-bottom: -35px;'> 

    <div class='row'>
      <div class='col-xs-12 col-sm-12 col-md-4'>

     <center></br></br><h3><?= $data['domain'] ?></h3>
      <p class='text-muted'><?= $this->language['server_ip']." ".$data['server_ip'] ?></p>
     <p class='text-muted'><?= $this->language['client_ip']." ".$data['client_ip'] ?></p></center>

    <hr>
    <div class='col-md-10 col-md-offset-1'><center>
    <h4><?= $this->language['disk_usage'] ?></h4>
    <div class="progress">

      <div class="progress-bar progress-bar-primary" style="width: <?= 100-$data['disk_space'] ?>%">
      <?= number_format(100-$data['disk_space'],2) ?>%
        <span class="sr-only">35% Complete (success)</span>
      </div>

    </div></center>
    </div>


     </div>


      <div class='col-xs-12 col-sm-12 col-md-4'><center>
          <img src=<?= $data['admin_logo']; ?> class='img img-responsive img-rounded' style='margin-bottom:-30px;max-height:300px;'/>
          
          </center>
        </div>

     <div class='clearfix visible-xs-block'></div>

      <div class='col-xs-12 col-sm-12 col-md-4'>   



        </br></br></br><center>
        <form class='form-inline' action='admin/search/index' method='POST'>
          <div class='form-group'>
            <div class='input-group'>
            <input type='text' class='form-control' name='search' id='exampleInputAmount' style='min-width:250px;'  placeholder='<?= $this->language['search_bar'] ?>' required>
               <div class='input-group-addon'>
                <button type='submit' class='btn btn-link btn-sm' style='padding:0px;'>
                <span class='glyphicon glyphicon-search' aria-hidden='true' ></span>
                </button>
                </div>
       
            </div>
          </div>
        </form>
        </center>


     
      <?php if($data['latest_version'] > $data['current_version']): ?>
        <div class="alert alert-warning alert-dismissible col-md-10 col-md-offset-1" role="alert" style='margin-top:5%;'>
    		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    		  <strong><?= $this->language['update_available']." v".$data['latest_version'] ?></strong><br><?= $this->language['update_message'] ?><br><br>
    		  <a href='admin/settings/updatecenter' class='btn btn-primary btn-block'><?= $this->language['update_now'] ?></a>
    		</div>
      <?php endif; ?>

         </div>
    </div>

    </br><center><h1><?= $this->language['welcome_message'] ?></h1></center>

	</br>
    <div class='container col-md-12'>
      <div class='row'>
        
        <div class='col-sm-4'>
          <div class='panel panel-primary'>
            <div class='panel-heading'>
              <h3 class='panel-title'><b><?= $this->language['posted_news_count'] ?></b><div class='pull-right'><i class='fa fa-newspaper-o'></i></div></h3>
            </div>
            <div class='panel-body'><center><font size='4'>
            <?= $data['blogposts']; ?>
           </font></center></div>
          </div>
        </div>


        <div class='col-sm-4'>
          <div class='panel panel-primary'>
            <div class='panel-heading'>
              <h3 class='panel-title'><b><?= $this->language['registered_users_count'] ?></b><div class='pull-right'><i class='fa fa-users'></i></div></h3>
            </div>
              <div class='panel-body'><center><font size='4'>
               <?= $data['users']; ?>
           </font></center></div>
          </div>
        </div>

        <div class='col-sm-4'>
          <div class='panel panel-primary'>
            <div class='panel-heading' >
              <h3 class='panel-title'><b><?= $this->language['visits_count'] ?></b><div class='pull-right'><i class='fa fa-binoculars'></i></div></h3>
            </div>
            <div class='panel-body'><center><font size='4'>
             <?= $data['visits']; ?>
           </font></center></div>
          </div>
        </div>

       
      </div>


    </div>



</div>

