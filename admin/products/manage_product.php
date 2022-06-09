<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `product_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
	if(isset($id)){
		$meta = $conn->query("SELECT * FROM `product_meta` where product_id = '{$id}'");
		while($row = $meta->fetch_assoc()){
			$field[$row['field_id']] = $row['meta_value'];
		}
	}
}
?>
<style>
	legend.legend-sm {
		font-size: 1.4em;
	}
	#cimg{
		max-width: 100%;
		max-height: 20em;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="content py-5 px-3 bg-gradient-navy">
	<h4 class="font-wight-bolder"><?= isset($id) ? "Update Product Details" : "New Product Entry" ?></h4>
</div>
<div class="row mt-n4 align-items-center justify-content-center flex-column">
	<div class="col-lg-10 col-md-11 col-sm-12 col-xs-12">
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<form action="" id="product-form">
						<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="code" class="control-label">Code</label>
								<input type="text" name="code" id="code" class="form-control form-control-sm rounded-0" value="<?php echo isset($code) ? $code : ''; ?>"  required/>
							</div>
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="name" class="control-label">Name</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" value="<?php echo isset($name) ? $name : ''; ?>"  required/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<label for="description" class="control-label">Description</label>
								<textarea rows="4" name="description" id="description" class="form-control form-control-sm rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="status" class="control-label">Status</label>
								<select name="status" id="status" class="form-control form-control-sm rounded-0" required="required">
									<option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
									<option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
								</select>
							</div>
						</div>
						<fieldset class="border px-2 pb-2">
							<legend class="w-auto px-3">Product Information</legend>
							<?php 
							$categories = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1 and (COALESCE((SELECT count(id) FROM `field_list` where category_id = category_list.id and delete_flag = 0 and `status` = 1), 0)) > 0 order by `order` asc");
							while($row = $categories->fetch_assoc()):
							?>
							<fieldset class="border px-2 pb-2 mb-2">
								<legend class="w-auto px-3 legend-sm"><?= $row['name'] ?></legend>
								<div class="row">
									<?php 
									$fields = $conn->query("SELECT * FROM field_list where category_id = '{$row['id']}' and delete_flag = 0 and `status` = 1 order by `order` asc");
									while($frow = $fields->fetch_assoc()):
									?>
									<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<label for="field_<?= $frow['id'] ?>" class="control-label"><?= $frow['name'] ?></label>
										<textarea name="field[<?= $frow['id'] ?>]" id="field_<?= $frow['id'] ?>" rows="3" class="form-control form-control-sm rounded-0" style="resize:none" required="required"><?= isset($field[$frow['id']]) ? $field[$frow['id']] : '' ?></textarea>
									</div>
									<?php endwhile; ?>
								</div>
							</fieldset>
							<?php endwhile; ?>
						</fieldset>
						<fieldset class="border px-2 pb-2">
							<legend class="w-auto px-3">Product Images</legend>
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<label for="" class="control-label">Thubmnail</label>
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="customFile1" name="img" accept="image/png, image/jpeg" onchange="displayImg(this)">
										<label class="custom-file-label rounded-0" for="customFile1">Choose file</label>
									</div>
								</div>
								<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<img src="<?= validate_image(isset($thumbnail_path) ? $thumbnail_path : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail border p-0">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<label for="" class="control-label">Other Images</label>
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="customFile1" name="imgs[]" multiple accept="image/png, image/jpeg" onchange="displayImg2(this)">
										<label class="custom-file-label rounded-0" for="customFile1">Choose file</label>
									</div>
								</div>
								<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-flat btn-sm btn-navy bg-gradient-navy" form="product-form"><i class="fa fa-save"></i> Save</button>
				<?php if(isset($id)): ?>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=products/view_product&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-angle-left"></i> Cancel</a>
				<?php else: ?>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=products"><i class="fa fa-angle-left"></i> Cancel</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<script>
	function displayImg(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	$(input).siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
			$('#cimg').attr('src', '<?= validate_image(isset($thumbnail_path) ? $thumbnail_path : '') ?>');
			$(input).siblings('.custom-file-label').html('Choose File')
		}
	}
	function displayImg2(input) {
		var fnames = [];
		Object.keys(input.files).map(function(k){
			fnames.push(input.files[k].name)

		})
		$(input).siblings('.custom-file-label').html(fnames.join(", "))
	}
	$(document).ready(function(){
		$('#description').summernote({
			height: '15em',
			toolbar: [
				[ 'style', [ 'style' ] ],
				[ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
				[ 'fontname', [ 'fontname' ] ],
				[ 'fontsize', [ 'fontsize' ] ],
				[ 'color', [ 'color' ] ],
				[ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
				[ 'table', [ 'table' ] ],
				[ 'view', [ 'undo', 'redo', 'fullscreen', 'help' ] ]
			]
		})
		$('#product-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_product",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.replace('./?page=products/view_product&id='+resp.pid)
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                    }else{
						alert_toast("An error occured",'error');
					}
					end_loader()
				}
			})
		})

	})
</script>