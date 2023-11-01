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
$sels = $con->query("select * from tbl_sale_item where id=".$_GET['edit']."");
$sels = $sels->fetch_assoc();
?>
<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Edit Flash Sale Item </h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

								

									<div class="form-group">
									<label for="cname">Select Flash Sale</label>
									<select name="sale" class="form-control">
									<option>Select Flash Sale</option>
									<?php
$fsale = $con->query("select * from tbl_sale");
while($row = $fsale->fetch_assoc())
{	
									?>
									<option value="<?php echo $row['id'];?>" <?php if($sels['saleid'] == $row['id']){echo 'selected';}?>><?php echo $row['name'];?></option>
<?php } ?>
									</select>
								</div>
								
								
								<div class="form-group">
									<label for="cname">Select Flash Product</label>
									<select name="product[]" class="form-control select2-multi-select" multiple required>
									
									<?php
$fsale = $con->query("select * from product");
$people = explode(',',$sels['pid']);
while($row = $fsale->fetch_assoc())
{	
									?>
									<option value="<?php echo $row['id'];?>" <?php if(in_array($row['id'], $people)){echo 'selected';}?>><?php echo $row['pname'];?></option>
<?php } ?>
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
							$sale = mysqli_real_escape_string($con,$_POST['sale']);
							$product = implode(',',$_POST['product']);
							
						
							
    $con->query("update tbl_sale_item set saleid='".$sale."',pid='".$product."' where id=".$_GET['edit']."");
?>
						
		<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.success('Flash Sale Item Update Successfully!!!');
    setTimeout(function()
	{
		window.location.href="flashitem.php";
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
					<h4 class="card-title" id="basic-layout-form">Add Flash Sale Item</h4>
					
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form" method="post" enctype="multipart/form-data">
							<div class="form-body">
								

								

								<div class="form-group">
									<label for="cname">Select Flash Sale</label>
									<select name="sale" class="form-control">
									<option>Select Flash Sale</option>
									<?php
$fsale = $con->query("select * from tbl_sale");
while($row = $fsale->fetch_assoc())
{	
									?>
									<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
<?php } ?>
									</select>
								</div>
								
								
								<div class="form-group">
									<label for="cname">Select Flash Product</label>
									<select name="product[]" class="form-control select2-multi-select" multiple required>
									
									<?php
$fsale = $con->query("select * from product");
while($row = $fsale->fetch_assoc())
{	
									?>
									<option value="<?php echo $row['id'];?>"><?php echo $row['pname'];?></option>
<?php } ?>
									</select>
								</div>
								
								
								
								
								
								
								
								
							
 
									


							

								
							</div>

							<div class="form-actions">
								
								<button type="submit" name="sub_cat" class="btn btn-raised btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Save
								</button>
							</div>
							
							<?php 
							if(isset($_POST['sub_cat'])){
							$sale = mysqli_real_escape_string($con,$_POST['sale']);
							$product = implode(',',$_POST['product']);
							
							
								

  $con->query("insert into  tbl_sale_item(`saleid`,`pid`)values(".$sale.",'".$product."')");
?>
						
						<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.success('Flash Sale Item Insert Successfully!!!');
    setTimeout(function()
	{
		window.location.href="flashitem.php";
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
 