<?php include('db_connect.php'); ?>
<style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.3); /* IE */
        -moz-transform: scale(1.3); /* FF */
        -webkit-transform: scale(1.3); /* Safari and Chrome */
        -o-transform: scale(1.3); /* Opera */
        transform: scale(1.3);
        padding: 10px;
        cursor: pointer;
    }
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                <h5>Total Students: <span id="student_count"><?php
                    // Fetch and display the student count
                    $count_query = $conn->query("SELECT COUNT(*) as total_students FROM student");
                    $total_students = $count_query->fetch_assoc()['total_students'];
                    echo $total_students;
                ?></span></h5>
            </div>
        </div>
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Students</b>
                        <span class="float:right"><a class="btn btn-primary col-md-1 col-sm-6 float-right" href="javascript:void(0)" id="new_student">
                            <i class="fa fa-plus"></i> New 
                        </a></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>ID No.</th>
                                    <th>Name</th>
                                    <th>Information</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $student = $conn->query("SELECT * FROM student ORDER BY name ASC");
                                while($row = $student->fetch_assoc()): 
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td><?php echo $row['id_no'] ?></td>
                                    <td><?php echo ucwords($row['name']) ?></td>
                                    <td>
                                        <p>Email: <?php echo $row['email'] ?></p>
                                        <p>Contact #: <?php echo $row['contact'] ?></p>
                                        <p>Address: <?php echo $row['address'] ?></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-primary edit_student" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger delete_student" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>	
</div>

<style>
    td {
        vertical-align: middle !important;
    }
    td p {
        margin: unset;
    }
    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>

<script>
    $(document).ready(function() {
        $('table').dataTable();
    });

    $('#new_student').click(function() {
        uni_modal("New Student", "manage_student.php", "mid-large", function() {
            updateStudentCount(); // Update the student count after adding a student
        });
    });

    $('.edit_student').click(function() {
        uni_modal("Manage Student Details", "manage_student.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_student').click(function() {
        _conf("Are you sure to delete this Student?", "delete_student", [$(this).attr('data-id')]);
    });

    function delete_student($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_student',
            method: 'POST',
            data: { id: $id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    updateStudentCount(); // Update the student count after deletion
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }

    function updateStudentCount() {
        $.ajax({
            url: 'ajax.php?action=get_student_count',
            method: 'GET',
            success: function(resp) {
                $('#student_count').text(resp);
            }
        });
    }
</script>
