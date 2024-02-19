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
                    <col width="15%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                </colgroup>
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>شماره تیکت</th>
                    <th>موضوع</th>
                    <th>تاریخ ثبت</th>
                    <th >اختصاص به</th >
                    <th>مشکل</th>
                    <th>وضعیت</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $problem = array("","مشکلات نرم افزار", "کارتریج", "مشکلات سخت افزاری","شبکه/قطعی اینترنت","راهنمایی","پرینتر");
                $stat = array("","ثبت", "در حال بررسی", " بررسی دوباره","انجام شده","برگشت");
                $where = "";
                if($_SESSION['login_type'] == 0 || $_SESSION['login_type'] == 1){
                    $where = " where user_group_id = '{$_SESSION["login_group_id"]}' or  user_id_corrector = '{$_SESSION["login_group_id"]}' or  assign_to = '{$_SESSION["login_group_id"]}'";
                }elseif($_SESSION['login_type'] == 3){
                    $where = " where user_id_created = '{$_SESSION["login_id"]}' or  user_id_corrector = '{$_SESSION["login_group_id"]}' or  assign_to = '{$_SESSION["login_id"]}'";
                }
                $qry = $conn->query("SELECT * FROM ticket $where order by serial_id asc");
                while($row= $qry->fetch_assoc()):
                    $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
                    unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                    $desc = strtr(html_entity_decode($row['description']),$trans);
                    $desc=str_replace(array("<li>","</li>"), array("",", "), $desc);

                    if (!is_null($row['assign_to'])){


                        if ($_SESSION['login_type'] == 0 || $_SESSION['login_type'] == 1 ){
                            $qry_ticket_group = $conn->query("SELECT DISTINCT id,username as n FROM users  where id = ".$row['assign_to']."  union SELECT DISTINCT ticket.ticket_group_id,ticket.ticket_group_name as n FROM ticket_group as ticket where   ticket_group_id = ".$row['assign_to'].";");
                        }else{
                            $qry_ticket_group = $conn->query("SELECT DISTINCT ticket.ticket_group_id,ticket.ticket_group_name as n FROM ticket_group as ticket where   ticket_group_id = ".$row['assign_to'].";");
                        }
                        $row_group_ticket= $qry_ticket_group->fetch_assoc();
                    }

                    ?>
                    <tr>
                        <th class="text-center"  style="margin-left: 300px"><?php echo $i++ ?></th>
                        <td><b><?php echo $row['serial_id'] ?></b></td>
                        <!--						<td><b>--><?php //echo $row['subject_doc'] ?><!--</b></td>-->
                        <td>
                            <p><b><?php echo ucwords($row['subject_ticket']) ?></b></p>
                            <p class="truncate"><?php echo strip_tags($desc) ?></p>
                        </td>
                        <td><b><?php echo date(" Y/m/d",strtotime($row['start_date'])) ?></b></td>


                            <td><b><?php echo  (!is_null($row['assign_to'])) ? $row_group_ticket['n'] :  "<span class='badge badge-primary'> </span>"; ?></b></td>

                        <td class="text-center">
                            <?php
                            if ($problem[$row['problem_ticket']] == 'مشکلات نرم افزار') {
                                echo "<span class='badge badge-primary'>{$problem[$row['problem_ticket']]}</span>";
                            }elseif ($problem[$row['problem_ticket']] == 'کارتریج') {
                                echo "<span class='badge badge-primary'>{$problem[$row['problem_ticket']]}</span>";
                            } elseif ($problem[$row['problem_ticket']] == 'مشکلات سخت افزاری') {
                                echo "<span class='badge badge-primary'>{$problem[$row['problem_ticket']]}</span>";
                            }elseif ($problem[$row['problem_ticket']] == 'شبکه/قطعی اینترنت') {
                                echo "<span class='badge badge-primary'>{$problem[$row['problem_ticket']]}</span>";
                            }elseif ($problem[$row['problem_ticket']] == 'راهنمایی') {
                                echo "<span class='badge badge-primary'>{$problem[$row['problem_ticket']]}</span>";
                            }elseif ($problem[$row['problem_ticket']] == 'پرینتر') {
                                echo "<span class='badge badge-primary'>{$problem[$row['problem_ticket']]}</span>";
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if ($stat[$row['status_ticket']] == 'ثبت') {
                                echo "<span class='badge badge-dark'>{$stat[$row['status_ticket']]}</span>";
                            }elseif ($stat[$row['status_ticket']] == 'در حال بررسی') {
                                echo "<span class='badge badge-info'>{$stat[$row['status_ticket']]}</span>";
                            } elseif ($stat[$row['status_ticket']] == ' بررسی دوباره') {
                                echo "<span class='badge badge-warning'>{$stat[$row['status_ticket']]}</span>";
                            } elseif ($stat[$row['status_ticket']] == 'انجام شده') {
                                echo "<span class='badge badge-success'>{$stat[$row['status_ticket']]}</span>";
                            } elseif ($stat[$row['status_ticket']] == 'برگشت') {
                                echo "<span class='badge badge-danger'>{$stat[$row['status_ticket']]}</span>";
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



                               ?>
                                <a class="dropdown-item" href="./index.php?page=edit_ticket&id=<?php echo $row['ticket_id'] ?>">ویرایش</a>
                                <?php if($_SESSION['login_type'] != 3): ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php echo $row['ticket_id'] ?>">حذف</a>
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
            url:'ajax.php?action=delete_ticket',
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