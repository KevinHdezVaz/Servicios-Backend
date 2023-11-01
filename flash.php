<?php 
  require 'include/header.php';
  ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
  ?>
  


  <body data-col="2-columns" class=" 2-columns ">
      <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


     
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->
<?php if(isset($_GET['edit'])) {
$sels = $con->query("select * from tbl_sale where id=".$_GET['edit']."");
$sels = $sels->fetch_assoc();
?>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Edit Flash Sale</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

								

								<div class="form-group">
									<label for="cname">Flash Sale Name</label>
									<input type="text" id="aname" class="form-control"  value="<?php echo $sels['name'];?>" name="cname" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Flash Sale Start Date</label>
									<input type="date" id="sdate" class="form-control sdate"  value="<?php echo $sels['start_date'];?>" name="sdate" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Flash Sale Start Time</label>
									<input type="time" id="stime" class="form-control clockpicker"  value="<?php echo $sels['start_time'];?>" name="stime" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Flash Sale End Date</label>
									<input type="date" id="edate" class="form-control sdate"  value="<?php echo $sels['end_date'];?>" name="edate" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Flash Sale End Time</label>
									<input type="time" id="etime" class="form-control clockpicker"  value="<?php echo $sels['end_time'];?>" name="etime" required >
								</div>
								
							
 
									<div class="form-group">
									<label for="cname">Flash Sale Status</label>
									<select name="status" class="form-control">
									    <option value="1" <?php if($sels['status'] == 1){echo 'selected';}?>>Publish</option>
									    <option value="0" <?php if($sels['status'] == 0){echo 'selected';}?>>Unpublish</option>
									</select>
								</div>


							

								
							</div>

							<div class="form-actions">
								
								<button type="submit" name="up_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Save
								</button>
							</div>
							
							<?php 
							if(isset($_POST['up_cat'])){
							$cname = mysqli_real_escape_string($con,$_POST['cname']);
							$sdate = $_POST['sdate'];
							$stime = $_POST['stime'];
							$etime = $_POST['etime'];
							$edate = $_POST['edate'];
							$status = $_POST['status'];
							
							
    $con->query("update tbl_sale set name='".$cname."',status=".$status.",start_date='".$sdate."',start_time='".$stime."',end_time='".$etime."',end_date='".$edate."',expire=0 where id=".$_GET['edit']."");
?>
						
		<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.success('Flash Sale Update Successfully!!!');
    setTimeout(function()
	{
		window.location.href="flash.php";
	},1500);
  });
  </script>
  <?php
							
							}
							?>
						</form>
					</div>
				</div>
			</div>
		</div>

		
	</div>
<?php } else { ?>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Add Flash Sale</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

								

								<div class="form-group">
									<label for="cname">Flash Sale Name</label>
									<input type="text" id="aname" class="form-control"  name="cname" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Flash Sale Start Date</label>
									<input type="date" id="sdate" class="form-control sdate"  name="sdate" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Flash Sale Start Time</label>
									<input type="time" id="stime" class="form-control clockpicker"  name="stime" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Flash Sale End Date</label>
									<input type="date" id="edate" class="form-control sdate"   name="edate" required >
								</div>
								
								<div class="form-group">
									<label for="cname">Flash Sale End Time</label>
									<input type="time" id="etime" class="form-control clockpicker"  name="etime" required >
								</div>
								
							
 
									


							

								
							</div>

							<div class="form-actions">
								
								<button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Save
								</button>
							</div>
							
							<?php 
							if(isset($_POST['sub_cat'])){
							$cname = mysqli_real_escape_string($con,$_POST['cname']);
							$sdate = $_POST['sdate'];
							$stime = $_POST['stime'];
							$edate = $_POST['edate'];
							$etime = $_POST['etime'];
							

  $con->query("insert into  tbl_sale(`name`,`start_date`,`end_date`,`start_time`,`end_time`)values('".$cname."','".$sdate."','".$edate."','".$stime."','".$etime."')");
?>
						
						<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.success('Flash Sale Insert Successfully!!!');
    setTimeout(function()
	{
		window.location.href="flash.php";
	},1500);
  });
  </script>
  <?php 
							
							}
							?>
						</form>
					</div>
				</div>
			</div>
		</div>

		
	</div>
	<?php } ?>





          </div>
        </div>

        

      </div>
    </div>
    
   <?php 
  require 'include/js.php';
  ?>
    
 
  </body>


</html> 