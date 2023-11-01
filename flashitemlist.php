<?php 
  require 'include/header.php';
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

<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Flash Sale Item List</h4>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
								 <th>Sr No.</th>
                                    <th>Flash Sale Name</th>
									<th>Flash Sale Product Name</th>
									<th>Flash Sale Price</th>
									<th>Product Price</th>
                                     <th>Product Discount</th>
									 <th>Product Quantity</th>
                                    
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								if($_SESSION['ltype'] == 'vendor')
{
	$vendors = $vendor['id'];
}
else 
{
	$vendors = 0;
}
                                $sel = $con->query("select * from tbl_sale_item where post_id=".$vendors."");
                                $i=0;
                                while($row = $sel->fetch_assoc())
                                {
                                    $i= $i + 1;
                                ?>
                                <tr>
                                    
                                    <td><?php echo $i; ?></td>
                                    <td><?php  $flash = $con->query("select * from tbl_sale where id=".$row['saleid']."")->fetch_assoc(); echo $flash['name'];?></td>
									<td><?php  $flash = $con->query("select * from tbl_product_attribute where id=".$row['aid']."")->fetch_assoc();
                                               $flashs = $con->query("select * from product where id=".$flash['pid']."")->fetch_assoc();
									echo $flashs['pname'].' '.$flash['title'];?></td>
									<td><?php echo $row['flashprice'];?></td>
									<td><?php echo $row['price'];?></td>
                                     <td><?php echo $row['discount'];?></td>
									<td><?php echo $row['quantity'];?></td>
									<td>
									<a class="primary"  href="flashitem.php?edit=<?php echo $row['id'];?>" data-original-title="" title="">
                                            <i class="ft-edit font-medium-3"></i>
                                        </a>
										
									<a class="danger" href="?dele=<?php echo $row['id'];?>" data-original-title="" title="">
                                            <i class="ft-trash font-medium-3"></i>
                                        </a>
										
										</td>
                                   
                                </tr>
                               <?php } ?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
if(isset($_GET['dele']))
{
$con->query("delete from tbl_sale_item where id=".$_GET['dele']."");
?>
	<script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('Flash Sale Item Delete Successfully!!');
    setTimeout(function()
	{
		window.location.href="flashitemlist.php";
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