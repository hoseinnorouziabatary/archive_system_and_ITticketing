<?php include'db_connect.php';


?>

<div class="col-lg-12">
	<div class="card card-outline card-success" >
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_user"> کاربر جدید<i class="fa fa-plus"></i> </a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list"  style="direction: rtl;text-align: center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>نام و نام خانوادگی</th>
						<th>نام کاربری</th>
                        <th>ایمیل</th>
						<th>نقش کاربر</th>
                        <th style="width: 5px;">وضعیت کاربر</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$type = array("Admin","Coo","Project Manager","Employee");
					$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name,username FROM users order by concat(firstname,' ',lastname) asc");
					$qry_user_group = $conn->query("SELECT *  FROM user_group  ");
                    $row_user_group= $qry_user_group->fetch_assoc();

                    while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php echo $row['username'] ?></b></td>
                        <td><b><?php echo $row['email'] ?></b></td>
						<td><b><?php echo $type[$row['type']] ?></b></td>
						<td><label class="checkbox">
                                <input type="checkbox" name="checkactive" <?php if ($row['status'] == "active") echo 'checked value="1"' ?> value="0" onchange="change_active_user(<?php echo $row['id'] ?>,$(this).val())"   id="active">
                            </label></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="text-align: center">
		                      <a class="dropdown-item view_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
		                    </div>
						</td>
					</tr>
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable()

	$('.view_user').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> جزئیات","view_user.php?id="+$(this).attr('data-id'))
	})
	$('.delete_user').click(function(){
	_conf("آیا مطمئن هستید که این کاربر را حذف می کنید؟","delete_user",[$(this).attr('data-id')])
	})
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("داده ها با موفقیت حذف شدند",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
    function change_active_user($id,$val){
        start_load()
        $.ajax({
            url:'ajax.php?action=change_active_user',
            method:'POST',
            data:{id:$id,val:$val},
            success:function(resp){
                if(resp==1){
                    alert_toast("وضعیت با موفقیت تغییر یافت",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)

                }
            }
        })
    }
</script>