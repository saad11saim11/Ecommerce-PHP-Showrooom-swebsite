<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `product_list` where id = '{$_GET['id']}' and delete_flag = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
		if(isset($id)){
			$meta = $conn->query("SELECT * FROM `product_meta` where product_id = '{$id}'");
			while($row = $meta->fetch_assoc()){
				$field[$row['field_id']] = $row['meta_value'];
			}
		}
    }else{
		echo '<script>alert("product ID is not valid."); location.replace("./?page=products")</script>';
	}
}else{
	echo '<script>alert("product ID is Required."); location.replace("./?page=products")</script>';
}
$files[]= validate_image(isset($thumbnail_path) ? $thumbnail_path : '');
if(isset($id)){
	$fopen = scandir(base_app."uploads/products/$id/");
	foreach($fopen as $fname){
		if(in_array($fname,array('.','..')))
			continue;
		$files[]= validate_image("uploads/products/$id/".$fname);
	}
}
?>
<style>
	#product-thumbnail{
		max-width:100%;
		max-height:23em;
		object-fit:scale-down;
		object-position:center center;
	}
	.product-img{
		width:100%;
		max-height:10em;
		object-fit:cover;
		object-position:center center;
	}
</style>
<section class="py-5 mt-4">
	<div class="container">
		<div class="content py-5 px-3 bg-gradient-primary">
			<h2><b><?= isset($name) ? $name : '' ?></b></h2>
		</div>
		<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
			<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
				<div class="card rounded-0">
					<div class="card-body">
						<div class="container-fluid">
							<div class="text-center">
								<img src="<?= validate_image(isset($thumbnail_path) ? $thumbnail_path : '') ?>" alt="" class="img-thumbnail p-0 border rounded-0" id="product-thumbnail">
							</div>
							<div class="position-relative overflow-auto d-flex w-100 py-2">
								<?php foreach($files as $k => $file): ?>
								<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 position-relative  <?= $k == 0 ? 'border border-primary' : '' ?> img-item">
									<a href="javascript:void(0)" class="view-img">
										<img src="<?= ($file) ?>" alt="" class="img-thumbnail p-0 border product-img rounded-0">
									</a>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="d-flex w-100">
								<div class="col-3">Code:</div>
								<div class="col-9"><?= isset($code) ? $code : '' ?></div>
							</div>
							<div class="d-flex w-100">
								<div class="col-3">Product Name:</div>
								<div class="col-9"><?= isset($name) ? $name : '' ?></div>
							</div>
							<div class="d-flex w-100">
								<div class="col-3">Description:</div>
								<div class="col-9"><?= isset($description) ? htmlspecialchars_decode($description) : '' ?></div>
							</div>
							<h4 class="mb-0 text-center"><b>Product Information</b></h4>
							<hr>
							<?php 
								$categories = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1 and (COALESCE((SELECT count(id) FROM `field_list` where category_id = category_list.id and delete_flag = 0 and `status` = 1), 0)) > 0 order by `order` asc");
								while($row = $categories->fetch_assoc()):
							?>
							<div class="d-flex w-100">
								<div class="col-12 border m-0 bg-gradient-dark text-center font-weight-bolder"><?= $row['name'] ?></div>
							</div>
								<?php 
									$fields = $conn->query("SELECT * FROM field_list where category_id = '{$row['id']}' and delete_flag = 0 and `status` = 1 order by `order` asc");
									while($frow = $fields->fetch_assoc()):
								?>
								<div class="d-flex w-100">
									<div class="col-4 border m-0 bg-gradient-secondary font-weight-bolder"><?= $frow['name'] ?></div>
									<div class="col-8 border m-0"><?= isset($field[$frow['id']]) ? $field[$frow['id']] : 'N/A' ?></div>
								</div>
								<?php endwhile; ?>
							<?php endwhile; ?>
						</div>
					</div>
					<div class="card-footer py-1 text-center">
						<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?p=products"><i class="fa fa-angle-left"></i> Back to List</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$(function(){
		$('.view-img').click(function(){
			var src = $(this).find('img.product-img').attr('src') 
			$('.view-img').parent().removeClass('border border-primary')
			$(this).parent().addClass('border border-primary')
			$('#product-thumbnail').attr('src', src)
		})
	})
</script>