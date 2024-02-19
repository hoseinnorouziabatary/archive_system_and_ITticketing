<?php if(!isset($conn)){ include 'db_connect.php'; }


?>

<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
                        <div class="form-group" style="text-align: right">
                            <label for="" class="control-label">نام کاربری</label>
                            <input type="text" name="username" class="form-control form-control-sm" required value="<?php echo isset($username) ? $username : '' ?>">
                        </div>
						<div class="form-group" style="text-align: right">
							<label for="" class="control-label">نام</label>
							<input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
						</div>
						<div class="form-group" style="text-align: right">
							<label for="" class="control-label">نام خانوادگی</label>
							<input type="text"  name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
						</div>
						<?php if($_SESSION['login_type'] == 0): ?>
						<div class="form-group" style="text-align: right">
							<label for="" class="control-label">نقش کاربر</label>
							<select name="type" id="type" class="custom-select custom-select-sm">
								<option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>Employee</option>
								<option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Manager</option>
								<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>COO</option>
                                <option value="0" <?php echo isset($type) && $type == 0 ? 'selected' : '' ?>>Admin</option>
							</select>
						</div>
						<?php else: ?>
							<input type="hidden" name="type" value="3">
						<?php endif; ?>
                        <div class="form-group" style="text-align: right">
                            <label for="" class="control-label">گروه کاربری</label>
                            <select   class="form-control form-control-sm select2"  name="group_id" >
                                <option></option>
                                <?php
                                $groups = $conn->query("SELECT *,group_name as name FROM user_group  order by group_name asc ");
                                while($row= $groups->fetch_assoc()):
                                    ?>
                                    <option value="<?php echo $row['group_id'] ?>" <?php echo isset($group_id) && $group_id == $row['group_id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                                <?php endwhile; ?>

                            </select>
                            <small id="group_match" data-status=''></small>
                        </div>

						<div class="form-group" style="text-align: right">
							<label for="" class="control-label">تصویر پروفایل</label>
							<div class="custom-file">
		                      <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
		                      <label class="custom-file-label" for="customFile" style="text-align: left">Choose file</label>
		                    </div>
						</div>
						<div class="form-group d-flex justify-content-center align-items-center">
							<img src="<?php echo isset($avatar) ? 'assets/uploads/'.$avatar :'' ?>" alt="Avatar" id="cimg" class="img-fluid img-thumbnail ">
						</div>
					</div>
					<div class="col-md-6">
						
						<div class="form-group" style="text-align: right">
							<label class="control-label">ایمیل</label>
							<input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group" style="text-align: right">
							<label class="control-label">رمز عبور</label>
							<input type="password" class="form-control form-control-sm" name="password" <?php echo !isset($id) ? "required":'' ?>>
							<small><i><?php echo isset($id) ? "اگر نمی خواهید رمز عبور خود را تغییر دهید، این قسمت را خالی بگذارید":'' ?></i></small>
						</div>
						<div class="form-group" style="text-align: right">
							<label class="label control-label">تایید رمز عبور</label>
							<input type="password" class="form-control form-control-sm" name="cpass" <?php echo !isset($id) ? 'required' : '' ?>>
							<small id="pass_match" data-status=''></small>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">ذخیره</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">لغو</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">.رمز عبور مطابقت دارد</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">.رمز عبور مطابقت ندارد.</i>')
			}
		}
	})
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_user').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')

		if($('[name="password"]').val() != '' && $('[name="cpass"]').val() != ''){
			if($('#pass_match').attr('data-status') != 1){
				if($("[name='password']").val() !=''){
					$('[name="password"],[name="cpass"]').addClass("border-danger")
					end_load()
					return false;
				}
			}
		}

		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('داده ها با موفقیت ذخیره شدند',"success");
					setTimeout(function(){
						location.replace('index.php?page=user_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>.ایمیل از قبل وجود دارد</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>