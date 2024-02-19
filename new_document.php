<?php if (!isset($conn)) {
    include 'db_connect.php';



//    include 'date/jdf.php';
}

//$now = new DateTime();
//$rand = mt_rand(1000,999999);
//
//$timestamp = $now->getTimestamp();
//$unique = jdate("Ymd-His-$rand", $timestamp);

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
                        <label for="" class="control-label">شماره سند</label>
                        <input  <?php   if (isset($id)) echo 'disabled' ?> type="text" class="form-control form-control-sm" name="serial_id"
                               value="<?php echo isset($serial_id) ? $serial_id : "" ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">وضعیت</label>
                        <select name="status_doc" id="status_doc" class="custom-select custom-select-sm">
                            <option value="0" <?php echo isset($status_doc) && $status_doc == 0 ? 'selected' : '' ?>>
                            </option>
                            <option value="1" <?php echo isset($status_doc) && $status_doc == 1 ? 'selected' : '' ?>>ثبت
                            </option>
                            <option value="2" <?php echo isset($status_doc) && $status_doc == 2 ? 'selected' : '' ?>>تایید
                            </option>
                            <option value="3" <?php echo isset($status_doc) && $status_doc == 3 ? 'selected' : '' ?>>ابطال
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">تاریخ سند</label>
                        <input  type="text" class="form-control form-control-sm " id="start-date-id"
                               autocomplete="off" name="start_date" value="<?php echo isset($start_date) ?  date(" Y/m/d",strtotime($start_date)) : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">موضوع</label>
                        <input required type="text" class="form-control form-control-sm" name="subject_doc"
                               value="<?php echo isset($subject_doc) ? $subject_doc : '' ?>">
                    </div>
                </div>
                <?php
                    if ($group_User == 9){
                ?>
                    <div  class="col-md-3">
                        <div class="form-group">
                            <label for="" class="control-label">گروه</label><br>
                            <form id="myForm">
                                <input type="radio" id="action" onclick="change_action()"  name="radio1" <?php echo isset($group_doc) && $group_doc == 1 ? 'checked' : '' ?>>مزایده
                                <input style="margin-right: 10px" onclick="change_tender()"  type="radio" id="tender"  name="radio2" <?php echo isset($group_doc) && $group_doc == 2 ? 'checked' : '' ?>>مناقصه
                                <input style="margin-right: 10px" onclick="change_financial()" type="radio" id="financial"  name="radio3" <?php echo isset($group_doc) && $group_doc == 3 ? 'checked' : '' ?>>روکش مالی
                            </form>
                            <small id="pass_match" data-status=''></small>
                        </div>
                    </div>
                <?php
                    }
                    ?>
                <div class="col-md-4">
                    <div id="category" class="form-group" style="text-align: right;display: block">
                        <label for="" class="control-label">دسته بندی</label>
                        <select  id="group" class="form-control form-control-sm select2" name="category_doc">
                            <option></option>
                            <?php

                            if ($_SESSION['login_type'] == 0 || $_SESSION['login_type'] == 1 ){
                                $groups = $conn->query("SELECT DISTINCT category.category_id,category.category_name as n FROM category_group as category LEFT JOIN users ON users.group_id = category.user_group_id  LEFT JOIN user_group ON category.user_group_id = user_group.group_id ;");
                            }else{
                                $groups = $conn->query("SELECT DISTINCT category.category_id,category.category_name as n FROM category_group as category LEFT JOIN users ON users.group_id = category.user_group_id  LEFT JOIN user_group ON category.user_group_id = user_group.group_id  where category.user_group_id = ".$group_User."  ;");
                            }
                            while ($row = $groups->fetch_assoc()):
                                ?>
                                <option  value="<?php echo $row['category_id'] ?>" <?php echo isset($category_doc) && $category_doc == $row['category_id'] ? "selected" : '' ?>><?php echo ucwords($row['n']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="text-align: right">
                        <label for="" class="control-label">فایل</label>
                        <div class="custom-file">
                            <input type="file"  class="custom-file-input" id="customFile" name="img"  onchange="displayImg(this,$(this))">
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
                    $sql="SELECT *  FROM tbl_uploads JOIN documents ON documents.file_doc_id = tbl_uploads.fileid where documents.serial_id =  '" . $serial_id . "'";
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
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">توضیحات</label>
                        <textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
                                <?php echo isset($description) ? $description : '' ?>
                            </textarea>
                    </div>
                </div>

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
            url: 'ajax.php?action=save_document',
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