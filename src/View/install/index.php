<div class='container' style='margin-top:-4.5%;'>
  <div class='jumbotron'>
    <h1>HorizontCMS <small>by Timot</small></h1>      
    <p>The CMS that fit exactly to your needs.</p></br> 
    <?php 
      require(VIEW_DIR."default/messages.php");
    ?>
    <p>

 <?php if($data['enable_continue']){ 
   
   echo "<a class='btn btn-primary btn-lg' href='admin/install/step1' >

      &nbsp&nbsp&nbspInstall HorizontCMS&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>

    </a>";

  }
  else{
   echo "<a class='btn btn-success btn-lg' href='' >

      &nbsp&nbsp<i class='fa fa-refresh' aria-hidden='true'></i>&nbspRefresh&nbsp&nbsp&nbsp

    </a>";
    }

  ?>

    </p>     
  </div>

<div class='row'>

  <div class='col-sm-6 col-md-4'><center>
      <span class='glyphicon glyphicon-pencil' aria-hidden='true' style='font-size:3em;'></span>
      <div class='caption'>
        <h3>Blogging</h3>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum</p>
      </div></center>
  </div>

  <div class='col-sm-6 col-md-4'><center>
      <span class='glyphicon glyphicon-user' aria-hidden='true' style='font-size:3em;'></span>
      <div class='caption'>
        <h3>User handling</h3>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum</p>
      </div></center>
  </div>

  <div class='col-sm-6 col-md-4'><center>
      <span class='glyphicon glyphicon-file' aria-hidden='true' style='font-size:3em;'></span>
      <div class='caption'>
        <h3>File handling</h3>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum</p>
      </div>
  </div></center>
</div>

</div>