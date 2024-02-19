<?php include'db_connect.php';

$groupUser = $conn->query("SELECT users.group_id as gid FROM users where users.id =  '" . $_SESSION['login_id'] . "'");
$group_User = $groupUser->fetch_assoc()['gid'];
?>

<style>
    @media (max-width: 1375px)
        .wrapper {
            width: 1383px;
        }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-success" >
		<div class="card-header">

			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_document"><i class="fa fa-plus"></i>سند جدید</a>
			</div>

		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list"  style="direction: rtl;text-align: center">
				<colgroup >
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>شماره سند</th>
						<th>موضوع</th>
						<th>تاریخ سند</th>
                        <?php    if ($group_User == 9) { ?>
                            <th > گروه</th >
						<?php }?>
						<th>دسته بندی</th>
						<th>وضعیت</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$stat = array("","ثبت", "تایید", "ابطال");
					$where = "";
					if($_SESSION['login_type'] == 2){
						$where = " where user_group_id = '{$_SESSION["login_group_id"]}' ";
					}elseif($_SESSION['login_type'] == 3){
                        $where = " where user_id_created = '{$_SESSION["login_id"]}' ";
					}
					$qry = $conn->query("SELECT * FROM documents $where order by serial_id asc");
					while($row= $qry->fetch_assoc()):
                        $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
                        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                        $desc = strtr(html_entity_decode($row['description']),$trans);
                        $desc=str_replace(array("<li>","</li>"), array("",", "), $desc);

                        if (!is_null($row['category_doc'])){
                            $qry_user_group = $conn->query("SELECT category_name as cat_name FROM category_group where category_id = ".$row['category_doc']." LIMIT 1");
                            $row_group_user= $qry_user_group->fetch_assoc();
                        }
                    ?>
					<tr>
						<th class="text-center"  style="margin-left: 300px"><?php echo $i++ ?></th>
						<td><b><?php echo $row['serial_id'] ?></b></td>
<!--						<td><b>--><?php //echo $row['subject_doc'] ?><!--</b></td>-->
                        <td>
                            <p><b><?php echo ucwords($row['subject_doc']) ?></b></p>
                            <p class="truncate"><?php echo strip_tags($desc) ?></p>
                        </td>
						<td><b><?php echo date(" Y/m/d",strtotime($row['start_date'])) ?></b></td>
                        <?php
                        if ($group_User == 9){
                        ?>
                        <td class="text-center">
                            <?php
                            if ($row['group_doc'] == 1) {
                                echo "<span class='badge'>مزایده</span>";
                            }elseif ($row['group_doc'] == 2) {
                                echo "<span class='badge'>مناقصه</span>";
                            } elseif ($row['group_doc'] == 3) {
                                echo "<span class='badge '>روکش مالی</span>";
                            }else
                                echo "<span class='badge badge-primary'> </span>";
                            ?>
                        </td>
                        <?php } ?>

                        <?php  if ($group_User == 9){
                            if (is_null($row['category_doc'])){?>

                                <td><b><?php if(is_null($row['category_doc']) )  echo  "<span class='badge badge-primary'> </span>"; ?></b></td>
                        <?php
                            }else{
                                ?>
                                <td><b><?php echo  (!is_null($row['category_doc']) ) ? $row_group_user['cat_name'] :  "<span class='badge badge-primary'> </span>"; ?></b></td>                                <?php
                            }
                            }else{?>
						    <td><b><?php echo  (!is_null($row['category_doc'])) ? $row_group_user['cat_name'] :  "<span class='badge badge-primary'> </span>"; ?></b></td>
                        <?php }?>
						<td class="text-center">
                            <?php
                            if ($stat[$row['status_doc']] == 'ثبت') {
                                echo "<span class='badge badge-primary'>{$stat[$row['status_doc']]}</span>";
                            }elseif ($stat[$row['status_doc']] == 'ابطال') {
                                echo "<span class='badge badge-danger'>{$stat[$row['status_doc']]}</span>";
                            } elseif ($stat[$row['status_doc']] == 'تایید') {
                                echo "<span class='badge badge-success'>{$stat[$row['status_doc']]}</span>";
                            }
                            ?>
						</td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="text-align: center">
                                <?php
                                $sql="SELECT *  FROM tbl_uploads JOIN documents ON documents.file_doc_id = tbl_uploads.fileid where documents.serial_id =  '" . $row['serial_id'] . "'";
                                $result_set=mysqli_query($conn,$sql);



                                if (mysqli_num_rows($result_set) != 0) {
                                while (list($id, $name,$type,$size,$data) = mysqli_fetch_array($result_set)) {
                                ?>
		                                <a class="dropdown-item view_project" href="download.php?id=<?php echo urlencode($id); ?> data-id="<?php echo $row['document_id'] ?>">دانلود سند </a>
		                                <div class="dropdown-divider"></div>
                                <?php }    } ?>
		                      <a class="dropdown-item" href="./index.php?page=edit_document&id=<?php echo $row['document_id'] ?>">ویرایش</a>
                                <?php if($_SESSION['login_type'] != 3): ?>
		                             <div class="dropdown-divider"></div>
                                     <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php echo $row['document_id'] ?>">حذف</a>
		                        <?php endif; ?>
		                    </div>
						</td>
					</tr>
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()

	$('.delete_project').click(function(){
	_conf("آیا مطمئن هستید که این سند را حذف می کنید؟","delete_project",[$(this).attr('data-id')])
	})
	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_document',
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
</script>