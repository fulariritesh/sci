          <section class="container-fluid gradient-bg profile-block py-4">
<div class="container">
	<div class="row">
	<div class="col-md-6 profileImage order-md-6">
			<div id="drop1"></div>
			<div id="drop2"></div>
			<div id="imageBlock-profile" class="shadow order-md-1">
				<img src="<?php echo get_field("image"); ?>" class="img-fluid" alt="profile pic">
			</div>
		</div>
		<div class="col-md-6 blockInfo-profile">
			<?php echo get_field("content"); ?>
		</div>
	</div>
</div>
</section>