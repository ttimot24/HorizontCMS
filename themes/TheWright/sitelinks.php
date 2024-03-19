<nav class="navbar navbar-inverse navbar-expand-lg navbar-dark bg-dark">
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
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="font-size: 14px;">
      <ul class="nav navbar-nav mr-auto">

        <?php

        $all_pages = \App\Model\Page::active()->main()->language("EN")->get();

        foreach ($all_pages as $page) {

          $class = $page->is(Website::$_REQUESTED_PAGE) ? "active" : "";

          if (!$page->hasSubpages()) {
            echo "<li class='nav-item " . $class . "'><a class='nav-link' href='" . $page->getSlug() . "'>" . $page->name . "</a></li>";
          } else {
            echo '<li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $page->name . '</a>
                  <ul class="dropdown-menu">';
            foreach ($page->subpages as $subpage) {

              $class = $subpage->is(Website::$_REQUESTED_PAGE) ? "active" : "";
              if ($subpage->isActive()) {
                echo "<li class='" . $class . "'><a class='dropdown-item' href='" . $subpage->getSlug() . "'>" . $subpage->name . "</a></li>";
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