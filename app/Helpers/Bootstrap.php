<?php

class Bootstrap{



    public static function delete_confirmation($args){

      echo "<div id='".$args['id']."' class='modal' tabindex='-1'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header modal-header-danger bg-danger'>
                    <h4 class='modal-title text-white'>".$args['header']."</h4>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
                    <p>".$args['body']."</p>
                  </div>
                  <div class='modal-footer'>".$args['footer'];
                
                  if(isset($args['cancel'])){
                    echo "<button type='button' class='btn btn-default' data-bs-dismiss='modal'>".$args['cancel']."</button>";
                  }
                
                  echo "</div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
                ";


    }


    public static function image_details($modal_id,$image){

      $size = getimagesize($image);
      $image_size = $size[3];
      $image_size_width = explode("width=\"",$image_size);
      $image_size_width = explode("\"",$image_size_width[1]);

      $image_size_height = explode("height=\"",$image_size);
      $image_size_height = explode("\"",$image_size_height[1]);

      echo '<div id="modal-xl-'.$modal_id.'"  class="modal '.$modal_id.'-modal-xl" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <section class="row">';

            echo "<div class='col-md-6'> <a href='".$image."' target='_blank'>
            <img src='".$image."' class='img img-thumbnail' style='max-height:500px;'></a></div>
            <div class='col-md-6' valign='top'>
            <h1>Properties</h1></br>";
            echo "<h4>File name: </h4> " .basename($image);
            echo "<h4>Path: </h4> <a href='".$image."' target='_blank'>" .$image."</a>";

            echo "<h4>Size: </h4>" .$image_size_width[0] ."X" .$image_size_height[0];

            echo "<h4>Extension: </h4>" .$size['mime'];

     echo '</div>
          </section>

            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>';


    }

}