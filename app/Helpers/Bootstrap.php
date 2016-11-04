<?php

class Bootstrap
{
    public static function delete_confirmation($modal_id, $header = null, $message = null, $footer = null)
    {
        echo "<div class='modal ".$modal_id."' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header modal-header-danger'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h4 class='modal-title'>".$header."</h4>
                  </div>
                  <div class='modal-body'>
                    <p>".$message."</p>
                  </div>
                  <div class='modal-footer'>".$footer.'</div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
                ';
    }

    public static function image_details($modal_id, $image)
    {
        echo "<div class='modal ".$modal_id."-modal-xl' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-xl'>
              <div class='modal-content'>

                  <div class='modal-header'>
                  <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                  </br>
                  <h2 class='modal-title'><center></center></h2>
                   </div>
                  <div class='modal-body'>
                  <section class='row'>";

        echo "<div class='col-md-6'> <a href='".$image."' target='_blank'>
                    <img src='".$image."' class='img img-thumbnail' style='max-height:500px;'></a></div>
                    <div class='col-md-6' valign='top'>
                    <h1>Properties</h1></br>";
        echo '<h4>File name: </h4> '.basename($image);
        echo '<h4>Path: </h4> '.$image;

        $size = getimagesize($image);
        $image_size = $size[3];
        $image_size_width = explode('width="', $image_size);
        $image_size_width = explode('"', $image_size_width[1]);

        $image_size_height = explode('height="', $image_size);
        $image_size_height = explode('"', $image_size_height[1]);

        echo '<h4>Size: </h4>'.$image_size_width[0].'X'.$image_size_height[0];

        echo '<h4>Extension: </h4>'.$size['mime'];

                   // echo "<h4>Url: </h4><a target='_blank' href='http://" .$_SERVER['SERVER_NAME'].BASE_DIR ."" .$image."'>http://" .$_SERVER['SERVER_NAME'].BASE_DIR ."" .$image ."</a>";


          echo '   </div>
                  </section>
                  </div>


              </div>
            </div>
          </div>';
    }

    public function modal()
    {
    }
}
