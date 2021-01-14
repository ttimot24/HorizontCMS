<nav class="navbar navbar-inverse navbar-expand-lg navbar-dark bg-dark" style="padding-top:0px;border-radius:0px;">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed navbar-toggler pull-right" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar navbar-toggler-icon"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!--<a class="navbar-brand" href="#">Brand</a>-->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav mr-auto">

      <?php 

      $all_pages = \App\Model\Page::activeMain(); 

      foreach($all_pages as $page){
    
        if($page->language != \Config::get('app.locale')){continue;}

        $class = $page->equals(Website::$_REQUESTED_PAGE)? "active": "";
        
        if(!$page->hasSubpages()){
         echo "<li class='nav-item ".$class."'><a href='nav-link ".$page->getSlug()."'>".$page->name."</a></li>";
        }else{
          echo '<li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$page->name.'</a>
                  <ul class="dropdown-menu">';
              foreach($page->subpages as $subpage){  

                $class = $subpage->equals(Website::$_REQUESTED_PAGE)? "active": "";   
                if($subpage->isActive()){     
                  echo "<li class='".$class."'><a href='".$subpage->getSlug()."'>".$subpage->name."</a></li>";
                }
              }
          
          echo '</ul>
                </li>';
         }

      }

      ?>
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
