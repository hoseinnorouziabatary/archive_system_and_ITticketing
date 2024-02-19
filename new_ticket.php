<?php if (!isset($conn)) {
    include 'db_connect.php';



//    include 'date/jdf.php';
}

$now = new DateTime();
$rand = mt_rand(10,999);

$timestamp = $now->getTimestamp();
$unique = jdate("Ymd-His-$rand", $timestamp);

$groupUser = $conn->query("SELECT users.group_id as gid FROM users where users.id =  '" . $_SESSION['login_id'] . "'");
$group_User = $groupUser->fetch_assoc()['gid'];


?>
<style>
    .os-padding {
        top: 25px;
    }</style>
<div class="card card-outline card-primary" style=" direction: rtl;text-align: right;">
    <div class="card-body">
        <form action="" id="manage-project">

            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">شماره تیکت</label>
                        <input  readonly type="text" class="form-control form-control-sm" name="serial_id"
                                                                           value="<?php echo isset($serial_id) ? $serial_id : $unique ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">وضعیت</label>
                        <select <?php echo isset($id) ? 'disabled' : '' ?>   name="status_ticket" id="status_ticket" class="custom-select custom-select-sm">
                            <option value="0" <?php echo isset($status_ticket) && $status_ticket == 0 ? 'selected' : '' ?>>
                            </option>
                            <option value="1"  <?php echo isset($status_ticket) && $status_ticket == 1 ? 'selected' : 'selected' ?>>ثبت
                            </option>
                            <option value="2" <?php echo !isset($id) ? 'disabled' : '' ?> <?php echo isset($status_ticket) && $status_ticket == 2 ? 'selected' : '' ?>>در حال بررسی
                            </option>
                            <option value="3" <?php echo !isset($id) ? 'disabled' : '' ?> <?php echo isset($status_ticket) && $status_ticket == 3 ? 'selected' : '' ?>> بررسی دوباره
                            </option>
                            <option value="4" <?php echo !isset($id) ? 'disabled' : '' ?> <?php echo isset($status_ticket) && $status_ticket == 4 ? 'selected' : '' ?>>انجام شده
                            </option>
                            <option value="5" <?php echo !isset($id) ? 'disabled' : '' ?> <?php echo isset($status_ticket) && $status_ticket == 5 ? 'selected' : '' ?>>برگشت
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">تاریخ ثبت</label>
                        <input <?php echo isset($id) ? 'disabled' : '' ?>  type="text" class="form-control form-control-sm " id="start-date-id"
                                autocomplete="off" name="start_date" value="<?php echo isset($start_date) ?  date(" Y/m/d",strtotime($start_date)) : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">موضوع</label>
                        <input  <?php echo isset($id) ? 'disabled' : '' ?> required type="text" class="form-control form-control-sm" name="subject_ticket"
                               value="<?php echo isset($subject_ticket) ? $subject_ticket : '' ?>">
                    </div>
                </div>


                <div class="col-md-4">
                    <div id="category" class="form-group" style="text-align: right;display: block">
                        <label for="" class="control-label">اختصاص به</label>
                        <select  <?php echo isset($id) ? 'disabled' : '' ?>  id="group" class="form-control form-control-sm select2" name="assign_to">
                            <option></option>
                            <?php

                            if (!$id){
                                if ($_SESSION['login_type'] == 0 || $_SESSION['login_type'] == 1 ){
                                    $groups = $conn->query("SELECT DISTINCT id,username as n FROM users ;");
                                }else{
                                    $groups = $conn->query("SELECT DISTINCT ticket.ticket_group_id,ticket.ticket_group_name as n FROM ticket_group as ticket where  ticket_group_id = 3;");
                                }
                            }else{
                                $query = $conn->query("SELECT ticket.assign_to as assign,ticket.assign_to_client as client_assign FROM ticket  where ticket.ticket_id =  '" . $id . "'");
                                $q = $query->fetch_assoc();


                                    if ($q['client_assign']){
                                        $groups = $conn->query("SELECT DISTINCT id ,username as n FROM users  where id = '".$q['client_assign']."' ;");
                                    }else{

                                        $groups = $conn->query("SELECT DISTINCT ticket.ticket_group_id as id,ticket.ticket_group_name as n FROM ticket_group as ticket where  ticket_group_id = ".$q['assign']."");
                                    }

                            }


                            while ($row = $groups->fetch_assoc()):
                                ?>
                                <option <?php echo isset($id) ? 'disabled' : '' ?> <?php   if ($_SESSION['login_type'] != 0  ) echo 'selected '; ?>   value="<?php  echo $row['n'] ?>" <?php  if ($_SESSION['login_type'] == 0 || $_SESSION['login_type'] == 1 ){  echo  isset($assign_to) && $assign_to == $row['id'] ? "selected" : '' ;}else { echo isset($assign_to) && $assign_to == $row['id'] ? "selected" : '' ;} ?>><?php echo $row['n'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">مشکلات</label>
                        <select  <?php echo isset($id) ? 'disabled' : '' ?>   name="problem_ticket" id="problem_ticket" class="custom-select custom-select-sm">
                            <option value="0" <?php echo isset($problem_ticket) && $problem_ticket == 0 ? 'selected' : '' ?>>
                            </option>
                            <option value="1"   <?php echo isset($problem_ticket) && $problem_ticket == 1 ? 'selected' : '' ?>>مشکلات نرم افزار
                            </option>
                            <option value="2" <?php echo isset($problem_ticket) && $problem_ticket == 2 ? 'selected' : '' ?>>کارتریج
                            </option>
                            <option value="3" <?php echo isset($problem_ticket) && $problem_ticket == 3 ? 'selected' : '' ?>>مشکلات سخت افزاری
                            </option>
                            <option value="4" <?php echo isset($problem_ticket) && $problem_ticket == 4 ? 'selected' : '' ?>>شبکه/قطعی اینترنت
                            </option>
                            <option value="5" <?php echo isset($problem_ticket) && $problem_ticket == 5 ? 'selected' : '' ?>>راهنمایی
                            </option>
                            <option value="6" <?php echo isset($problem_ticket) && $problem_ticket == 6 ? 'selected' : '' ?>>پرینتر
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="text-align: right">
                        <label for="" class="control-label">فایل</label>
                        <div class="custom-file">
                            <input  <?php echo isset($id) ? 'disabled' : '' ?> type="file"  class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
                            <label class="custom-file-label"  for="customFile" style="text-align: left">
                                <?php
                                if (isset($serial_id)){
                                    $filequery = $conn->query("SELECT tbl_uploads.filename as f FROM tbl_uploads JOIN documents ON documents.file_doc_id = tbl_uploads.fileid where documents.serial_id =  '" . $serial_id . "'");
                                    $file = $filequery->fetch_assoc();
                                }

                                echo isset($file['f']) ? $file['f'] : 'Choose file';

                                ?></label>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($id)){
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" " class="control-label">دانلود فایل</label><br>
                            <?php
                            $sql="SELECT *  FROM tbl_uploads JOIN ticket ON ticket.file_ticket_id = tbl_uploads.fileid where ticket.serial_id =  '" . $serial_id . "'";
                            $result_set=mysqli_query($conn,$sql);

                            if (mysqli_num_rows($result_set) != 0) {
                                while (list($id, $name,$type,$size,$data) = mysqli_fetch_array($result_set)) {
                                    ?>
                                    <tr bgcolor="#D6E5FB" style="word-wrap: break-word; font-family:Trebuchet MS;color: #FF6600; font-size:15px;">

                                        <td>
                                            <?php

                                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                                            if($ext=="doc"||$ext=="docx")
                                            {
                                                echo '<img src="assets\img\word.png" alt="word.png" width="40px" height="40px"/>';


                                            }

                                            else if($ext=="pdf"||$ext=="PDF")
                                            {
                                                echo '<img src="assets\img\pdf.png" alt="word.png" width="40px" height="40px"/>';
                                            }

                                            else if($ext=="xls"||$ext=="xlsx"||$ext=="XLSX"||$ext=="XLS")
                                            {
                                                echo '<img src="assets\img\excel.png" alt="word.png" width="40px" height="40px"/>';

                                            }



                                            else if($ext=="jpeg"||$ext=="jpg"||$ext=="png"||$ext=="JPEG"||$ext=="JPG"||$ext=="PNG"||$ext=='gif'||$ext=='GIF')
                                            {
                                                echo '<img src="assets\img/photo.png" alt="word.png" width="40px" height="40px"/>';
                                            }

                                            else{
                                                echo '<img src="assets\img\misc.png" alt="word.png" width="40px" height="40px"/>';

                                            }

                                            ?></td>

                                        <td><a  href="download.php?id=<?php echo urlencode($id); ?>"
                                            ><?php urlencode($name);?>Download</a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php }?>
                <?php

                ?>
                    <div  class="col-md-12">
                        <div  class="form-group">
                            <label  for="" class="control-label">توضیحات</label>
                            <textarea    name="description" id="" cols="30" rows="10" class="summernote form-control">
                                    <?php echo isset($description) ? $description : '' ?>
                                </textarea>
                        </div>
                    </div>

                <?php

                ?>

            </div>
        </form>
    </div>

    <div class="card-footer border-top border-info">
        <div class="d-flex w-100 justify-content-center align-items-center">
            <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project" style="    border-radius: 0.25rem;">ذخیره</button>
            <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" style="    border-radius: 0.25rem;"
                    onclick="location.href='index.php?page=document_list'">لغو
            </button>
        </div>
    </div>
</div>
</div>
<script>

    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#manage-project').submit(function (e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_ticket',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    alert_toast('داده ها با موفقیت ذخیره شدند', "success");
                    setTimeout(function () {
                        location.href = 'index.php?page=document_list'
                    }, 2000)
                }else{
                    alert_toast(resp, "error");
                    end_load()
                }
            }
        })
    })

    function change_action() {
        const $check = document.getElementById("action").checked;
        if ($check === true){
            document.getElementById("category").style.display = "none";
            document.getElementById("action").checked = true;
            document.getElementById("tender").checked = false;
            document.getElementById("financial").checked = false;
        }
    }
    function change_tender() {
        const $tender = document.getElementById("tender").checked;
        if ($tender === true){
            document.getElementById("category").style.display = "block";
            document.getElementById("action").checked = false;
            document.getElementById("tender").checked = true;
            document.getElementById("financial").checked = false;
        }
    }
    function change_financial() {
        const $financial = document.getElementById("financial").checked;
        if($financial === true){
            document.getElementById("category").style.display = "block";
            document.getElementById("action").checked = false;
            document.getElementById("tender").checked = false;
            document.getElementById("financial").checked = true;
        }
    }


    kamaDatepicker("start-date-id", {
        buttonsColor: "red",
        forceFarsiDigits: true,
        markToday: true,
        markHolidays: true,
        highlightSelectedDay: true,
        sync: true,
        gotoToday: true,
        placeholder: "تاریخ  را وارد نمایید"
    });



</script>