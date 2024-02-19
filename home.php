
<?php include('db_connect.php');


?>
<?php

$twhere = "";
if ($_SESSION['login_type'] != 1)
    $twhere = "  ";
?>

<!-- Info boxes -->
<div class="col-12">
    <div class="card">
        <div class="card-body" style="    text-align: right;">
            <?php echo "!" . $_SESSION['login_name'] . " " ?>خوش آمدید
        </div>
    </div>
</div>
<hr>
<?php

$where = "";
if($_SESSION['login_type'] == 2){
    $where = " where user_group_id = '{$_SESSION["login_group_id"]}' ";
}elseif($_SESSION['login_type'] == 3){
    $where = " where user_group_id = '{$_SESSION["login_group_id"]}' and user_id_created = '{$_SESSION["login_id"]}' ";
}
$where2 = "";
if($_SESSION['login_type'] == 2){
    $where = " where user_group_id = '{$_SESSION["login_group_id"]}' ";
}elseif($_SESSION['login_type'] == 3){
    $where = " where user_group_id = '{$_SESSION["login_group_id"]}' and user_id_created = '{$_SESSION["login_id"]}' ";
}
?>

<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-success" style="direction: rtl">
            <div class="card-header">
                <b style="text-align: right">لیست اسناد</b>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-hover">
                        <colgroup>
                            <col width="5%">
                            <col width="20%">
                            <col width="15%">
                            <col width="15%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                        <th>#</th>
                        <th>شماره سند</th>
                        <th>تاریخ سند</th>
                        <th>وضعیت</th>
                        <th>Action</th>

                        </thead>
                        <tbody>
                        <?php
                        $i = 1;

                        $stat = array("","ثبت", "تایید", "ابطال");
                        $where = "";
                        if($_SESSION['login_type'] == 2){
                            $where = " where user_group_id = '{$_SESSION["login_group_id"]}' ";
                        }elseif($_SESSION['login_type'] == 3){
                            $where = " where user_group_id = '{$_SESSION["login_group_id"]}' and user_id_created = '{$_SESSION["login_id"]}' ";
                        }
                        $qry = $conn->query("SELECT * FROM documents $where order by serial_id asc");
                        while ($row = $qry->fetch_assoc()):

                            ?>
                            <tr>
                                <td>
                                    <?php echo $i++ ?>
                                </td>
                                <td>
                                    <a>
                                        <?php echo $row['serial_id'] ?>
                                    </a>
                                    <br>
                                    <small>
                                         <?php echo ucwords($row['subject_doc']) ?>
                                    </small>
                                </td>

                                <td class="project-state">
                                    <?php echo date(" Y/m/d",strtotime($row['start_date'])) ?>
                                </td>
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
                                <td>
                                    <a class="btn btn-primary btn-sm" style="    width: 75px;" href="./index.php?page=edit_document&id=<?php echo $row['document_id'] ?>">
                                        <i class="fas fa-folder">
                                        </i>
                                        نمایش
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM documents $where")->num_rows; ?></h3>

                        <p>تعداد سندها</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-layer-group"></i>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>
