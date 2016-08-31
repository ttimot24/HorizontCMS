<?php

/*
$menu_items = [
                  ["name" => "<span class='glyphicon glyphicon-th-large' aria-hidden='true'></span> ".LAN_MENU_0,"link" => "admin/dashboard/","class" => "active"],
                  
                  ["name" => LAN_MENU_1,"link" => "#","permission" => 'blogpost',"childs" => [
                                                                                  ["name" => "<i class='fa fa-newspaper-o'></i> " .LAN_MENU_1_1,"link" => "admin/blogpost/"],
                                                                                  ["name" => "<i class='fa fa-pencil'></i> " .LAN_MENU_1_2,"link" => "admin/blogpost/newpost"],
                                                                                  //["name" => "Comments","link" => "admin/blogpost/comment"],
                                                                                  ["name" => "<i class='fa fa-list-ul'></i> " .LAN_MENU_1_3,"link" => "admin/blogpost/category"],
                                                                                ]
                                                                            ],
                 ["name" => LAN_MENU_2,"link" => "#","permission" => 'user', "childs" => [
                                                                ["name" => "<i class='fa fa-users'></i> " .LAN_MENU_2_1,"link" => "admin/user"],
                                                                ["name" => "<i class='fa fa-user-plus'></i> " .LAN_MENU_2_2,"link" => "admin/user/add"],
                                                                ["name" => "<i class='fa fa-gavel'></i> " .LAN_MENU_2_3,"link" => "admin/usergroup"],
                                                              ]
                                                        ],
                 ["name" => LAN_MENU_3,"link" => "#","permission" => 'page', "childs" => [
                                                                ["name" => "<i class='fa fa-files-o'></i> " .LAN_MENU_3_1,"link" => "admin/page"],
                                                                ["name" => "<i class='fa fa-pencil-square-o'></i> " .LAN_MENU_3_2,"link" => "admin/page/create"],  
                                                              ]
                                                      ],
                 ["name" => LAN_MENU_4,"link" => "#", "permission" => 'media',"childs" => [
                                                                  ["name" => "<i class='fa fa-picture-o'></i> " .LAN_MENU_4_1,"link" => "admin/headerimages"],
                                                                  ["name" => "<i class='fa fa-folder-open-o'></i> " .LAN_MENU_4_2,"link" => "admin/filemanager"],
                                                                  ["name" => "<i class='fa fa-camera-retro'></i> " .LAN_MENU_4_3,"link" => "admin/gallery"],
                                                                  
                                                                ]
                                                    ],
                 ["name" => LAN_MENU_5,"link" => "#","permission" => 'themes&apps', "childs" => [
                                                                  ["name" => "<i class='fa fa-desktop'></i> " .LAN_MENU_5_1, "link" => "admin/theme"],
                                                                  ["name" => "<i class='fa fa-cubes'></i> " .LAN_MENU_5_2,"link" => "admin/plugin/"],
                                                                  ["name" => "<i class='fa fa-code'></i> " .LAN_MENU_5_3, "link" => "admin/develop"],
                                                                ]
                                                            ],
                  ];
*/


/*$installed_menus = Plugin::get_all_installed_plugin();

foreach($installed_menus as $menu){

  if(is_null($menu->level) && $menu->status==1){
    array_push($menu_items, array("name" => $menu->name, "link" => $_SYSTEM->base."?page=" .$menu->dir ."/".$menu->slug));
  }
  else if(!is_null($menu->level) && $menu->status==1){

      for($i=0;$i<count($menu_items);$i++){
         if($menu_items[$i]['name']==$menu->level){

            if(!isset($menu_items[$i]['childs'])){
              $menu_items[$i]['childs'] = array();
            }
            
              array_push($menu_items[$i]['childs'],array("name" => $menu->name,"link" =>  $_SYSTEM->base."?page=" .$menu->dir ."/".$menu->slug, "permission" => $menu->permission));
            
         }
      }



  }
}*/

?>

<style>
@media only screen and (min-width: 1200px) {
    .navbar{
      height:25px;
    }
}
</style>

<nav class='navbar navbar-inverse navbar-fixed-top'>
  <div class='container-fluid'>
    <div class='navbar-header'>
    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>                        
      </button>
      <a class='navbar-brand' href='admin/#'>
        <img src="storage/images/icons/world.png" style='max-height:170%;margin-top:-7px;float:left;'> <!--HorizontCMS <!-- SatelliteCMS -->
      </a>
    </div>
    <div>
    <div class='collapse navbar-collapse' id='myNavbar' style='overflow-x:hidden'>
      <ul class='nav navbar-nav'>

<?php

  $_USER = new User();
  $user = $_USER->get_instance(Session::get('id'));

  foreach($this->navigation->menu_items as $main_links){
     
      isset($main_links["permission"])?:$main_links['permission'] = 5;
      

      if($main_links["permission"]!=5 && !$user->has_permission($main_links["permission"])){
        continue;
      }


      if(isset($main_links["childs"])){
        echo "<li class='dropdown'>
                <a class='dropdown-toggle' data-toggle='dropdown' href='".$main_links['link']."'>".$main_links['name']."<span class='caret'></span></a>
                <ul class='dropdown-menu'>";
            
              foreach($main_links['childs'] as $sub_links){
                      isset($sub_links["permission"])?:$sub_links['permission'] = $main_links["permission"];

                      if($sub_links["permission"]!=5 && !$user->has_permission($sub_links["permission"])){continue;}
                      
                      echo  "<li><a href='".$sub_links['link']."'>".$sub_links['name']."</a></li>";
              }

        echo  "</ul>
            </li>";
      }
      else{

        isset($main_links['class'])?:$main_links['class'] = NULL;

        echo "<li class='".$main_links['class']."'>
                <a href='".$main_links['link']."'>".$main_links['name']."</a>
              </li>";

      }
    
  }


echo "</ul>";

?>


<?php $system = new System(); ?>

<ul class='nav navbar-nav navbar-right'>
 <!--       <li>
            <a href='' data-toggle='tooltip' data-placement='bottom' title='Link to the website'>
            <i class="fa fa-globe" aria-hidden="true" style='font-size: 1.3em;'></i> <b><?= $system->settings->title ?></b></a>
        </li>-->

  <li class='dropdown'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
              <i class="fa fa-bell" aria-hidden="true"></i>
            </a>
          <ul class='dropdown-menu' style='min-width:300px;'>

          <?php $notifications = $_USER->get_last(7); ?>

          <?php foreach($notifications as $each){
                  echo "<li style='height:50px;'><a href='".UrlManager::seo_url("admin/".$each->getClass()."/view/".$each->id)."'> <img class='img-circle' src='".$each->get_thumb()."' width=40> <b>".$each->username."</b> registered just now! </a></li>";
                }
          ?>

           <!-- <?php //foreach($this->navigation->alerts as $alert): ?>
              <li><a href='' style='height:42px;'><i class="fa fa-user" style="font-size:20px;" aria-hidden="true"></i> &nbsp<?= $alert[1] ?>&nbsp&nbsp&nbsp <small class='badge'>4 minutes ago</small></a></li>
            <?php //endforeach; ?>-->
            <li role="separator" class="divider"></li>
            <li><a href='admin/notifications'><center><b>See all notifications > </b></center></a></li>
          </ul>
  </li>



<!--
  <li class='dropdown'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                <img src='<?= $user->get_thumb() ?>' class='img-circle' style='max-height:30px;margin-top:-12px;margin-bottom:-12px;'> <b><?= $user->username ?></b>
            </a>
          <ul class='dropdown-menu' style='min-width:300px;padding:10px;'>
            <li class='bg-primary'><center>Your profile</center></li>
          	<li> 
          		<ul class='col-md-6'>
          			<img src='<?= $user->get_thumb() ?>' class='img-thumbnail img-circle'>
          		</ul>
 
 				<ul class='col-md-6'>
	          		<li class='text-primary'><b><?= $user->username ?></b>
	                <i><small>(<?= strtolower($user->get_rank()->name) ?></small>)</i></li>
                </ul>
			</li>


          </ul>
  </li>
       -->

<li>

<?php

echo "           <a href='admin/user/view/".$user->id."' rel='popover' data-cont='

                    <div><p class=\"pull-left\"><b>".$user->username."</b></p>
                         <p class=\"pull-right\"><b>".$user->get_rank()->name."</b></p>

                    </div>
                    
                    <br><br>

                    <ul class=\"list-group\">
					  
                    <a href=\"admin/inbox\">
					  <li class=\"list-group-item\">
					    <span class=\"badge\">0</span>
					    ".$this->language['inbox']."
					  </li>
					</a>
					  <a href=\"admin/user/update/".$user->id."\">
					  	<li class=\"list-group-item\">
						    ".$this->language['edit_profile']."
					 	 </li>
					  </a>



					</ul>

                      <hr style=\"margin-bottom:5px;\" />
                      <center><a href=\" admin/user/view/".$user->id." \">".$this->language['watch_full_profile']."</a></center>

              ' data-img='".$user->get_image()."' data-toggle='tooltip' data-placement='bottom' title='Your profile' >
            <img src='".$user->get_thumb()."' class='img-circle' style='object-fit:cover;height:32px;width:32px;margin-top:-12px;margin-bottom:-12px;'> <b>". $user->username ."</b>
            </a>";
            
 ?>       
      </li>


<?php if($user->has_permission('settings')): ?>  

      <li>
           <a href='admin/settings' data-toggle='tooltip' data-placement='bottom' title='<?= $this->language['settings']; ?>'>
            <span class='fa fa-cogs' aria-hidden='true' style='font-size: 1.3em;'></span>
           </a>
      </li>
<?php endif ?>

         <li class='dropdown'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
              <span class='glyphicon glyphicon-off' aria-hidden='true'></span>&nbsp&nbsp<span class='caret'></span>
            </a>
          <ul class='dropdown-menu'>
            <li><a style='cursor:pointer;' onclick='lock_screen();'><i class="fa fa-lock"></i> <?= $this->language['lock_screen'] ?></a></li>
            <li role="separator" class="divider"></li>
            <li><a href=''><i class="fa fa-external-link" aria-hidden="true"></i> <?= $this->language['visit_site']." ".$system->settings->title ?></a></li>
            <li><a href='admin/login/logout'><i class="fa fa-sign-out"></i> <?= $this->language['logout'] ?></a></li>
          </ul>
        </li>
    </ul>


    </div>
    </div>
  </div>
</nav>
