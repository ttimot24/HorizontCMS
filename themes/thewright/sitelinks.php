<nav class="navbar navbar-inverse" style="padding-top:0px;border-radius:0px;">
  <div class="container" style="margin-top:0px;">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!--<a class="navbar-brand" href="#">Brand</a>-->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

      <?php $all_pages = \App\Model\Page::activeMain(); ?>
      <?php 

      foreach($all_pages as $page){

        $class = $page->equals(Website::$_REQUESTED_PAGE)? "active": "";
        
        if(!$page->hasSubpages()){
         echo "<li class='".$class."'><a href='".str_slug($page->name)."'>".$page->name."</a></li>";
        }else{
          echo '<li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$page->name.'</a>
                  <ul class="dropdown-menu">';
              foreach($page->subpages as $subpage){  

                $class = $subpage->equals(Website::$_REQUESTED_PAGE)? "active": "";       
                echo "<li class='".$class."'><a href='".str_slug($subpage->name)."'>".$subpage->name."</a></li>";
              }
          
          echo '</ul>
                </li>';
         }

      }

      ?>
      </ul>


      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
