
<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT f.*, c.name as `category` from `field_list` f inner join `category_list` c on f.category_id = c.id where f.id = '{$_GET['id']}' and f.delete_flag = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
		echo '<script>alert("field ID is not valid."); location.replace("./?page=fields")</script>';
	}
}else{
	echo '<script>alert("field ID is Required."); location.replace("./?page=fields")</script>';
}
?>
<style>
	#uni_modal .modal-footer{
		display:none !important;
	}
</style>
<div class="container-fluid">
	<dl>
		<dt class="text-muted">Category</dt>
		<dd class="pl-4"><?= isset($category) ? $category : "" ?></dd>
		<dt class="text-muted">Name</dt>
		<dd class="pl-4"><?= isset($name) ? $name : "" ?></dd>
		<dt class="text-muted">Status</dt>
		<dd class="pl-4">
			<?php if($status == 1): ?>
				<span class="badge badge-success px-3 rounded-pill">Active</span>
			<?php else: ?>
				<span class="badge badge-danger px-3 rounded-pill">Inactive</span>
			<?php endif; ?>
		</dd>
	</dl>
</div>
<hr class="mx-n3">
<div class="py-1 text-right">
	<button class="btn btn-flat btn-sm btn-light bg-gradient-light border" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
</div>