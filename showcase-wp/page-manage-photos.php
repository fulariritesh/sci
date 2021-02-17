<?php
/**
 * The template for displaying manage photos page
 *
 * @package Showcase
 */

get_header('edit-profile');
$obj_id = wp_get_current_user()->data->ID;
$data = get_user_meta($obj_id);
$user_info = get_userdata($obj_id);
?>
<style type="text/css">
	.photogrid {
		flex-direction: column;
	}
    .packery:after {
      content: ' ';
      display: block;
      clear: both;
    }

    .grid-item {
    	float: left;
    	width: calc(33% - 10px);
    	background: transparent;
    	border: none;
    	overflow: hidden;
        position: relative;
    	border: 10px solid transparent;
    }
    .packery-item {
        float: left;
        width: calc(33% - 10px);
        background: #e6e5e4;
        border: 2px solid #b6b5b4;
        position: relative;
        display: flex;
        flex-direction: column;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }
    .packery-item.is-dragging,
    /* Packery adds class while transitioning to drop position */
    .packery-item.is-positioning-post-drag {
      //background: #EA0;
      z-index: 2; /* keep dragged item on top */
    }
    .packery-drop-placeholder {
      outline: 3px dashed #444;
      outline-offset: -6px;
      /* transition position changing */
      -webkit-transition: -webkit-transform 0.2s;
              transition: transform 0.2s;
    }
</style> 
<div class="container" id="managephotos">
	<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-3 d-none d-lg-block">
				  <img src="/images/footer-logo-grey.png" alt="logo">
				</div>
				<div class="col-10 col-md-6">
				  <h5 class="modal-title text-lg-center" id="editIntroModalLabel">Manage Photos</h5>
				</div>
				<div class="col-2 col-md-3">
				  <button type="button" class="close" onclick="window.history.back();" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
				  <div class=" col-12 col-lg-11 mx-auto  mb-4">
				    <div class="card-body">
				      <form id="managephotos-form">
				        <div class="row">
				          <div class="col-sm-10">
				            <p class="text-muted">Tip: Click and drag photos to change their order or move between columns.</p>
				          </div>
				          <div class="col-sm-2 text-right">
				            <a id="init-bulkEdit" href="" data-toggle="modal" data-target="#bulkedit">
				              <i class="fas fa-pencil-alt  editicon"></i></a>
				              <a id="init-bulkdelete" href="" data-toggle="modal" data-target="#deletephoto">
				                <i class="fas fa-trash-alt  deleteicon"></i></a>
				            <a id="init-addphoto" href="" data-toggle="modal" data-target="#addphotos">
				              <i class="fas fa-plus-circle  addicon"></i></a>
				          </div>
				        </div>
				        <div class="container-fluid pt-2 px-0 ">
							<div id="imageGrid" class="imageGrid packery">
								<?php if (get_field('photos', 'user_' . $obj_id)) foreach ( get_field('photos', 'user_' . $obj_id) as $index => $obj): ?>
								<div class="packery-item" data-media-id="<?php echo $obj["ID"]; ?>" data-caption="<?php echo get_post($obj['ID'])->post_excerpt; ?>">
									<div class="imgContent">
										<img class="card-img-top" src="<?php echo $obj['url']; ?>" />
										<?php 
		                                if (get_field('moderated', 'attachment_' . $obj["ID"])) {
											switch (get_field('moderated', 'attachment_' . $obj["ID"])['value']) {
												case 'pending':
													echo "<div class='pending-status'>Pending</div>";
													break;
												case 'approved':
													echo "<div class='approved-status'><i class='fas fa-check'></i></div>";
													break;
												case 'rejected':
													echo "<div class='rejected-status'>Rejected</div>";
													break;
												default:
													break;
		                                    }
										} ?>
									</div>

									<div class="bulkselect-radio">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="">
										</div>
									</div>

									<div class="row managephotoicons">
										<div class="col-4 text-center py-3">
											<a alt="Edit Image" data-toggle="modal" data-target="#editcaption" data-backdrop="false">
												<i class="fas fa-pencil-alt"></i>
											</a>
										</div>
										<div class="col-4 text-center py-3">
											<a alt="Rotate" class="rotate-image">
												<i class="fas fa-undo"></i>
											</a>
										</div>
										<div class="col-4 text-center py-3">
											<a alt="Delete" class="delete-image">
												<i class="fas fa-trash-alt"></i>
											</a>
										</div>
									</div>
								</div>
								<?php endforeach;?>
							</div>
				        </div>
				        <div class="d-flex justify-content-around py-4">
				          <button class="btn btn-md btn-popup-cancel" onclick="window.history.back();">Cancel</button>
		                  <div class="submit">
		                        <button class="btn btn-lg btn-popup-save px-4">Save</button>
		                    </div>
				        </div>
				      </form>
				    </div>
				  </div>
				</div>
			</div>
	</div>	
</div>
<!--Add Photos Modal -->
<div class="modal fade" id="addphotos" tabindex="-1" aria-labelledby="addphotosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-md-3 d-none d-lg-block">
          <img src="/images/footer-logo-grey.png" alt="logo">
        </div>
        <div class="col-10 col-md-6">
          <h5 class="modal-title text-lg-center" id="editIntroModalLabel">Add Photo</h5>
        </div>
        <div class="col-2 col-md-3">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class=" col-12 col-lg-11 mx-auto">
            <div class="card-body">
              <form id="addphoto-form">
                <div class="row">
                  <div class="col-sm-12">
                    <p class="text-muted">
                    <ul>
                      <li>Great profile pics 101: full length, waist up & a natural looking!</li>
                      <li>Quality over quantity (save the selfies for social)</li>
                      <li>Include a range of photos that demonstrate your experience and versatillity</li>
                    </ul>
                    </p>
                    <div class="col-8 p-0 uploadphoto mx-auto text-center">
                    	<img id="uploadImage">
          						<label class="uploadimage">
          							<i class="fas fa-camera fa-3x"></i><br />
          							Select a Photo
          							<input type="file" id="file-input" class="" size="60">
          						</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8 pt-3 mx-auto px-0">
<!--                     <label class="col-12 ">Rotate</label>
                    <div class="btn-group btn-group-toggle col-4" data-toggle="buttons">
                      <label class="btn btn-rotate ccw active col-6">
                        <i class="fas fa-undo"></i>
                      </label>
                      <label class="btn btn-rotate cw col-6">
                        <i class="fas fa-undo fa-flip-horizontal"></i>
                      </label>
                    </div>

                    <label class="col-12 pt-3 ">Photo position on profile</label>
                    <div class="btn-group btn-group-toggle col-12 " data-toggle="buttons">
                      <label class="btn btn-secondary active col-6">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Top
                      </label>
                      <label class="btn btn-secondary col-6">
                        <input type="radio" name="options" id="option2" autocomplete="off"> Bottom
                      </label>
                    </div> -->
                    <label class="col-12 pt-3">Add a caption</label>
                    <div class="col-12">
                      <input type="text" id="addPhotosCaption" class="form-control" />
                    </div>

                  </div>
                </div>
            </div>
            <div class="d-flex justify-content-around py-4">
              <button class="btn btn-md btn-popup-cancel" data-dismiss="modal">Cancel</button>
              <div class="submit">
                <button class="btn btn-md btn-popup-save px-4">Save</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">


function handleFileSelect(evt) {
	var files = evt.target.files;
	var f = files[0];
	var reader = new FileReader();
	reader.onload = (function(theFile) {
		return function(e) {
			document.getElementById('uploadImage').src = e.target.result;
			document.querySelector(".uploadimage").classList.add('d-none');
		};
	})(f);
	reader.readAsDataURL(f);
}
(function(on){
    on("DOMContentLoaded", function(){
        window.$drag = new Packery( '.packery', {
            itemSelector: '.packery-item',
            gutter: 10,
            percentPosition: true
        });
        imagesLoaded(".packery-item img").on( 'progress', function() {
            $drag.layout();
        });  
        $drag.getItemElements().forEach( function( itemElem ) {
            var draggie = new Draggabilly( itemElem );
            $drag.bindDraggabillyEvents( draggie );
        });
        function orderItems() {
            $drag.getItemElements().forEach( function( itemElem, i ) {
                itemElem.setAttribute('data-order', i + 1);
            });
        }

        $drag.on( 'layoutComplete', orderItems );
        $drag.on( 'dragItemPositioned', orderItems );

    });
})(document.addEventListener);

</script>
<?php get_footer('edit-profile'); ?>