<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    top: 0;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}

	/* Style for Recent Payments Box */
	#recent-payments {
		background-color: #4CAF50; /* Green background */
		color: white; /* White text */
		border-radius: 10px; /* Rounded corners */
		padding: 20px; /* Padding inside the box */
	}

	#recent-payments .inner h3 {
		font-size: 24px;
	}

	#recent-payments:hover {
		background-color: #45a049; /* Slightly darker green on hover */
	}
</style>

<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Welcome back ". $_SESSION['login_name']."!"  ?>
                    <hr>

                    <div class="container">
                        <div class="row">
                            <!-- Total Students -->
                            <div class="col-lg-4 mb-2">
                                <div class="card-box bg-blue">
                                    <div class="icon">
                                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                    </div>
                                    <div class="inner">
                                        <h3> 1 </h3>
                                        <p> Total Students </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Courses -->
                            <div class="col-lg-4">
                                <div class="card-box bg-green">
                                     <div class="icon text-white">
                                        <i class="fa fa-certificate " aria-hidden="true"></i>
                                    </div>
                                    <div class="inner">
                                        <h3> 1 </h3>
                                        <p> Total Courses</p>
                                    </div>
                                </div>
                            </div>

                            <!-- New Admissions -->
                            <div class="col-lg-4">
                                <div class="card-box bg-orange">
                                      <div class="icon">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    </div>
                                    
                                    <div class="inner">
                                        <h3> 1 </h3>
                                        <p> New Admissions </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Users -->
                            <div class="col-lg-4 ">
                                <div class="card-box bg-red">
                                    <div class="icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="inner">
                                        <h3> 1 </h3>
                                        <p> Total Users </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Payments (Clickable Box with Color) -->
                            <div class="col-lg-8">
                                <div class="card-box" id="recent-payments" style="cursor: pointer;">
                                    <div class="inner">
                                        <h3> Recent Payments </h3>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Recent Payments -->
                        </div>
                    </div>
                </div>
            </div>      			
        </div>
    </div>
</div> 

<!-- Modal for Recent Payments -->
<div class="modal fade" id="recentPaymentsModal" tabindex="-1" role="dialog" aria-labelledby="recentPaymentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="recentPaymentsModalLabel">Recent Payments Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-condensed table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Date</th>
                    <th>ID No.</th>
                    <th>EF No.</th>
                    <th>Name</th>
                    <th>Paid Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;
                $payments = $conn->query("SELECT p.*,s.name as sname, ef.ef_no,s.id_no FROM payments p inner join student_ef_list ef on ef.id = p.ef_id inner join student s on s.id = ef.student_id order by unix_timestamp(p.date_created) desc ");
                if($payments->num_rows > 0):
                while($row=$payments->fetch_assoc()):
                ?>
                <tr>
                    <td class="text-center"><?php echo $i++ ?></td>
                    <td><?php echo date("M d,Y H:i A",strtotime($row['date_created'])) ?></td>
                    <td><?php echo $row['id_no'] ?></td>
                    <td><?php echo $row['ef_no'] ?></td>
                    <td><?php echo ucwords($row['sname']) ?></td>
                    <td class="text-right"><?php echo number_format($row['amount'],2) ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <th class="text-center" colspan="6">No data.</th>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    // Trigger modal on box click
    $('#recent-payments').on('click', function() {
        $('#recentPaymentsModal').modal('show');
    });
</script>
