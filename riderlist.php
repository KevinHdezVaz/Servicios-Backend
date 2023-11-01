<?php 
  require 'include/header.php';
  ?>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php'); ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->

<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
				<?php 
			if(isset($_GET['cashid']))
			{
				?>
				<h4 class="card-title">Manage Cash</h4>
				<?php 
			}
			else 
			{
				?>
                    <h4 class="card-title">Delivery Boy List</h4>
			<?php } ?>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
					   <?php 
			if(isset($_GET['cashid']))
			{
				?>
				
				
				<div class="card">
				
				
				                                <form method="post" enctype="multipart/form-data">
                                       <div class="card-body">
									   <?php $sales  = $con->query("select sum(total) as full_total from orders where status='entregado'  and p_method='Dinero en efectivo' and  rid=".$_GET['cashid']."")->fetch_assoc();
             $payout =   $con->query("select sum(amt) as full_payouts from tbl_cash where rid=".$_GET['cashid']."")->fetch_assoc();
                 
				
				$pb = 0;
				 if($sales['full_total'] == ''){$pb =  '0';}else {$pb  = number_format((float)($sales['full_total']) - $payout['full_payouts'], 2, '.', ''); } ?>
				 
									   <div class="form-group">
                                            <label><span class="text-danger">*</span> Remain  Cash</label>
                                            <input type="text" class="form-control" value="<?php echo $pb;?>"  name="remain" required="" readonly>
                                        </div>
										
										 <div class="form-group">
                                            <label><span class="text-danger">*</span> Received Cash</label>
                                            <input type="text" class="form-control" placeholder="Enter Received Cash"  name="rcash" required="">
                                        </div>
										
										 <div class="form-group">
                                            <label><span class="text-danger">*</span> Message</label>
                                            <input type="text" class="form-control" placeholder="Enter Message"  name="message" required="" >
                                        </div>
										
                                     
										
										
										<div class="col-12">
                                                <button type="submit" name="add_cash" class="btn btn-primary mb-2">Add Cash Collection</button>
                                            </div>
											</div>
                                    </form>
				                            </div>
											
											<?php 
	if(isset($_POST['add_cash']))
	{
		$rcash = $_POST['rcash'];
		$message = $_POST['message'];
		$rid = $_GET['cashid'];
$timestamp = date("Y-m-d H:i:s");
	   
	   
	  $con->query("insert into tbl_cash(`rid`,`message`,`amt`,`pdate`)values(".$rid.",'".$message."',".$rcash.",'".$timestamp."')")
	  
	  ?>
	  <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.info('Delivery Boy Cash Collect Successfully!!');
	setTimeout(function()
	{
		window.location.href="riderlist.php";
	},1500);
    
  });
  </script>
	  <?php 
		}
	?>
				<?php 
			}
			elseif(isset($_GET['hid']))
			{
				?>
				<table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                            <tr>
                                                <th>Sr No.</th>
												<th>Delivery Boy Name</th>
                                                
												 
												 <th>Received <br>Cash</th>
												 <th>Message</th>
                                                <th>Received <br>Date</th>
                                                

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
											 $stmts = $con->query("SELECT * FROM `rider` where id =".$_GET['hid']."")->fetch_assoc();
											 $stmt = $con->query("SELECT * FROM `tbl_cash` where rid =".$_GET['hid']."");
$i = 0;
while($row = $stmt->fetch_assoc())
{
	$i = $i + 1;
											?>
                                                <tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="align-middle">
                                                   <?php echo $stmts['name']; ?>
                                                </td>
												
                                                <td class="align-middle">
                                                  <?php echo $row['amt'].' '.$set['currency']; ?>
                                                </td>
                                                
                                               
				 <td class="align-middle">
                                                  <?php echo $row['message']; ?>
                                                </td>
												
												 <td class="align-middle">
                                                  <?php echo date("d M Y, h:i a", strtotime($row['pdate'])); ?>
                                                </td>
												
                                                </tr>
<?php } ?> 
                                        </tbody>
                            
                        </table>
				<?php 
			}
			else 
			{
				?>
                        <table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
								 <th>Sr No.</th>
                                   
                                    <th>Delivery Boy Name</th>
                                   <th>Delivery Boy Mobile</th>
								    <th>Delivery Boy Email</th>
									 <th>Delivery Boy Area</th>
									  <th>Delivery Boy Address</th>
									   <th>Delivery Boy Status</th>
									   <th>Delivery Boy App Status(On/Off)</th>
									    <th>Delivery Boy Total Reject</th>
										<th>Delivery Boy Total Accept</th>
										<th>Delivery Boy Total Complete</th>
										
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $jj = $con->query("select * from rider");
                                $i=0;
                                while($rkl = $jj->fetch_assoc())
                                {
                                    $i = $i + 1;
                                ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    
                                    <td><?php echo $rkl['name'];?></td>
                                   <td><?php echo $rkl['mobile'];?></td>
								   <td><?php echo $rkl['email'];?></td>
								   <td><?php $ad = $con->query("select * from area_db where id=".$rkl['aid']."")->fetch_assoc(); echo $ad['name'];?></td>
 <td><?php echo $rkl['address'];?></td> 								  
								  <td><?php if($rkl['status'] == 1){echo 'Active';}else {echo 'Deactive';}?></td> 
								    <td><?php if($rkl['a_status'] == 1) {echo 'On';}else {echo 'Off';}?></td> 
								   <td><?php echo $rkl['reject'];?></td>
								   <td><?php echo $rkl['accept'];?></td>
								   <td><?php echo $rkl['complete'];?></td>
                                    <td>
									<?php if($rkl['status'] == 0) {?>
									<a href="?status=1&rid=<?php echo $rkl['id'];?>">	<button class="btn btn-success shadow btn-xs sharp mr-1"   data-original-title="" title="">
                                           Make Active
                                        </button></a>
									<?php } else { ?>
								<a	href="?status=0&rid=<?php echo $rkl['id'];?>">	<button class="btn btn-danger shadow btn-xs sharp mr-1"  href="?status=0&rid=<?php echo $rkl['id'];?>" data-original-title="" title="">
                                            Make Deactive
                                        </button>
										</a>
									<?php } ?>
									<a href="?cashid=<?php echo $rkl['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="Manage Cash" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-money"></i></a>
												<a href="?hid=<?php echo $rkl['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="Cash Collection Log" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-history"></i></a>
										</td>
                                   
                                </tr>
                               <?php } ?>
                            </tbody>
                            
                        </table>
			<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
if(isset($_GET['status']))
{
$status = $_GET['status'];
$id = $_GET['rid'];

  $con->query("update rider set status=".$status." where id=".$id."");  
?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.info('Delivery Boy Status Update Successfully!!');
	setTimeout(function()
	{
		window.location.href="riderlist.php";
	},1500);
    
  });
  </script>
  <?php
}
?>



          </div>
        </div>

        

      </div>
    </div>
   
    <?php 
  require 'include/js.php';
  ?>
   
  </body>


</html>