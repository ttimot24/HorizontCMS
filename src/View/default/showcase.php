<div class='col-md-5 pull-right well hidden-xs' style='margin-right:7%;'>
<div id="carousel-example-generic" class="carousel slide " data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">

    <div class="item active">
      <a href='http://www.eterfesztival.hu'>
      <!--<img src="images/websites/eter.png" alt="...">-->
      <img src="<?= Storage::get('images/website','eter.png') ?>" alt="...">
      </a>
      <div class="carousel-caption">
        <h3>Éter Plusz</h3>
        <p>More than 1300 registered users.</p>
      </div>
    </div>


    <div class="item">
       <img src="<?= Storage::get('images/website','lavyl.png') ?>" alt="...">
      <div class="carousel-caption">
        <h3>Lavyl Ocean</h3>
        <p>Couple of plugins</p>
      </div>
    </div>

    <div class="item">
       <img src="<?= Storage::get('images/website','klub21.png') ?>" alt="...">
      <div class="carousel-caption">
        <h3>Klub 21</h3>
        <p>Themes</p>
      </div>
    </div>

  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>