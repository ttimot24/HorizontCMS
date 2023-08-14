    <?php
    $size = getimagesize($image);
    $image_size = $size[3];
    $image_size_width = explode("width=\"", $image_size);
    $image_size_width = explode("\"", $image_size_width[1]);
    
    $image_size_height = explode("height=\"", $image_size);
    $image_size_height = explode("\"", $image_size_height[1]);
    ?>

    <div id="modal-xl-{{ $modal_id }}" class="modal {{ $modal_id }}-modal-xl" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <section class="row">

                        <div class='col-4'> <a href='{{ $image }}' target='_blank'>
                                <img src='{{ $image }}' class='img img-thumbnail' style='max-height:500px;'></a>
                        </div>
                        <div class='col-8' valign='top'>
                            <div class="card">
                                <div class="card-header">
                                    <h2>Properties</h2>
                                </div>
                                <div class="card-body">
                                    <h4>File name: </h4> {{ basename($image) }}
                                    <h4>Path: </h4> <a href='{{ $image }}'
                                        target='_blank'>{{ $image }}</a>

                                    <h4>Size: </h4> {{ $image_size_width[0] . 'X' . $image_size_height[0] }}

                                    <h4>Extension: </h4> {{ $size['mime'] }}
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
