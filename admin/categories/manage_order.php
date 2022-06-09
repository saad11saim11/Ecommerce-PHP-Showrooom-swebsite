<?php require_once('./../../config.php') ?>
<link href="<?= base_url ?>plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<script src="<?= base_url ?>plugins/jquery-ui/jquery-ui.min.css"></script>
<style>
    #category-list .list-group-item{
        cursor:move !important;
    }
</style>
<div class="container-fluid">
    <form action="" id="category-order-form">
        <div id="category-list" class="list-group rounded-0">
            <?php 
            $categories = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 order by `order` asc");
            while($row = $categories->fetch_assoc()):
            ?>
            <div class="list-group-item list-group-item-action border">
                <input type="hidden" name="cid[]" value="<?= $row['id'] ?>">
                <span class="fa fa-arrows-alt-v mr-2"></span><b><?= $row['name'] ?></b>&nbsp;
                <?php if($row['status'] == 1): ?>
                    <small class="badge badge-success px-3 rounded-pill">Active</small>
                <?php else: ?>
                    <small class="badge badge-danger px-3 rounded-pill">Inactive</small>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#category-list').sortable()
        $('#category-order-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_order_category",
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
                        location.reload()
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