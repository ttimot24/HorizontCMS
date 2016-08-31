<?php



print "<div class='container'>
    <!-- The container for the list of example images -->
    <div id='links'>";

if($_GET['category']==''){
	$dirs = scandir("../../images/gallery");
    $i=0;

    foreach(array_slice($dirs,2) as $each){

    	if($i%2==0){print "<div style='clear:both;'></div>";}

    	$thumb = scandir("../../images/gallery/".$each);
    print "<div class='image_text'><a href='index.php?page=".$_GET['page'] ."&category=".$each."' title='".$each."'>";

        if(file_exists("../../images/gallery/" .$each."/" .$thumb[2]) && $thumb[2]!=''){
            $img = "../../images/gallery/".$each."/" .$thumb[2];
        }
        else{
             $img = "camera.png";
        }

        print "<img class='gallery_thumbs' src='".$img."' alt='".$each."' width='300' height='230'>
        		<div class='text'><center><i>".$each."</i></center></div>
    	   </a></div>";

    	$i++;   
	}
}
else{
	//print "<a href='index.php?page=".$_GET['page']."' style='font-size:12px;'><--Back to categories</a>";
    print "<h2>" .$_GET['category'] ."</h2>";
	$images = scandir("../../images/gallery/".$_GET['category']);
    $i=0;

    foreach(array_slice($images,2) as $each){

    	if($i%4==0){print "<div style='clear:both;'></div>";}

    print "<div style='float:left;height: 120px; width: 180px; overflow: hidden; margin-left:7px; margin-bottom:7px;'><a href='../../images/gallery/".$_GET['category']."/".$each."' title='".$each."' data-gallery>
        		<img src='../../images/gallery/".$_GET['category']."/".$each."' alt='".$each."' width='180'>
    	   </a></div>";

    	$i++;   
	}
}



print "</div>
    <br>
</div>";

/*
print "
<div id='blueimp-gallery' class='blueimp-gallery' data-use-bootstrap-modal='false'>
    <!-- The container for the modal slides -->
    <div class='slides'></div>

    <div class='modal fade'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title'></h4>
                </div>
                <div class='modal-body next'></div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-default pull-left prev'>
                        <i class='glyphicon glyphicon-chevron-left'></i>
                        Previous
                    </button>
                    <button type='button' class='btn btn-primary next'>
                        Next
                        <i class='glyphicon glyphicon-chevron-right'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>";*/


print "
<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id='blueimp-gallery' class='blueimp-gallery blueimp-gallery-controls' data-use-bootstrap-modal='false'>
    <!-- The container for the modal slides -->
    <div class='slides'></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class='title'></h3>
    <a class='prev'>‹</a>
    <a class='next'>›</a>
    <a class='close'>×</a>
    <a class='play-pause'></a>
    <ol class='indicator'></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class='modal fade'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' aria-hidden='true'>&times;</button>
                    <h4 class='modal-title'></h4>
                </div>
                <div class='modal-body next'></div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-default pull-left prev'>
                        <i class='glyphicon glyphicon-chevron-left'></i>
                        Previous
                    </button>
                    <button type='button' class='btn btn-primary next'>
                        Next
                        <i class='glyphicon glyphicon-chevron-right'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>";



print "
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script src='http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js'></script>
<script src='js/image_gallery/js/bootstrap-image-gallery.js'></script>";
//print "<script src='js/image_gallery/js/demo.js'></script>";





?>