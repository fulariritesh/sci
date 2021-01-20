<section class="container-fluid gradient-bg profile-block py-4">
<div class="container">
	<div class="row">
		<div class="col-sm-6 blockInfo">
			<?php echo get_field("content"); ?>
		</div>
		<div class="col-sm-6 profileImage">
			<div id="drop1"></div>
			<div id="drop2"></div>
			<div class="imageBlockLeft shadow-sm">
				<img src="<?php echo get_field("image"); ?>" class="img-fluid" alt="profile pic">
			</div>
		</div>
	</div>
</div>