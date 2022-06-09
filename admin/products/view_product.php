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
// print_r($files);
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
<div class="content py-5 px-3 bg-gradient-navy">
	<h4 class="font-wight-bolder">Product Details</h4>
</div>
<div class="row mt-n4 align-items-center justify-content-center flex-column">
	<div class="col-lg-10 col-md-11 col-sm-12 col-xs-12">
		<div class="card rounded-0 shadow">
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
							<?php if($k > 0): ?>
							<div class="position-absolute" style="top:.2em;right:.7em">
								<button class="btn btn-flat btn-xs btn-danger bg-gradient-danger del_img" type="button" data-link="<?= str_replace(base_url,'', $file) ?>"><small><i class="fa fa-trash"></i></small></button>
							</div>
							<?php endif; ?>
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
					<div class="d-flex w-100 mb-3">
						<div class="col-3">Status:</div>
						<div class="col-9">
							<td class="text-center">
                                <?php if(isset($status)): ?>
									<?php if($status == 1): ?>
										<span class="badge badge-success px-3 rounded-pill">Active</span>
									<?php else: ?>
										<span class="badge badge-danger px-3 rounded-pill">Inactive</span>
									<?php endif; ?>
                                <?php else: ?>
										<span class="badge badge-light border px-3 rounded-pill">N/A</span>
                                <?php endif; ?>
                            </td>
						</div>
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
				<a class="btn btn-flat btn-sm btn-navy bg-gradient-navy border" href="./?page=products/manage_product&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-flat btn-sm btn-danger bg-gradient-danger" type="button" id="delete_product"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=products"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<hr class="mx-n3">
<div class="py-1 text-right">
	<button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
</div>
<script>
	$(function(){
		$('#delete_product').click(function(){
			_conf("Are you sure to delete this product permanently?","delete_product",['<?= isset($id) ? $id : '' ?>'])
		})
		$('.view-img').click(function(){
			var src = $(this).find('img.product-img').attr('src') 
			$('.view-img').parent().removeClass('border border-primary')
			$(this).parent().addClass('border border-primary')
			$('#product-thumbnail').attr('src', src)
		})
		$('.del_img').click(function(){
			var params = [];
				params.push("'"+$(this).attr('data-link')+"'")
			_conf("Are you sure to delete this image?", 'delete_image',params)
		})
	})
	function delete_product($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_product",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace("./?page=products");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	function delete_image($link){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_img",
			method:"POST",
			data:{path: $link},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					var img = $('.del_img[data-link = "'+$link+'"]').closest('.img-item')
					if(img.hasClass('border')){
						$('.view-img').first().trigger('click')
					}
					img.remove()
					alert_toast('Image has been deleted successfully.','success')
					$('.modal').modal('hide')
				}else{
					alert_toast("An error occured.",'error');
				}
				end_loader();

			}
		})
	}
</script>