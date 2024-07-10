<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

      

        <div class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Speaker List</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="modal"
                                    data-target="#createSpeakerModal">
                                    <i class="fa fa-user"></i> NEW SPEAKER
                                </button>
                                <hr>
                                <table class="table table-bordered table-hover table-striped" id='speaker_profile'>
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Specialization</th>
                                            <th scope="col">Occupation</th>

                                            <th scope="col">Contact #</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                 $results = mysqli_query($con, "SELECT * from speaker_profile"); ?>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_array($results)) { ?>
                                        <tr>
                                            <td><?php echo $row['speaker_id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['specialization']; ?></td>
                                            <td><?php echo $row['occupation']; ?></td>

                                            <td><?php echo $row['contact']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-dark btnEdit"
                                                    data-speaker='<?php echo json_encode($row); ?>'>
                                                    <i class="fa fa-book"></i> 
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div><!-- .animated -->
        </div><!-- .content -->


    </div>


</body>



<?php include('modal/speaker_profile.modal.php');?>


<?php include('include/footer.php');?>


<script>
$(document).ready(function() {
    var table = $('#speaker_profile').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print']
    });
});
</script>



<script>
$('.btnEdit').on('click', function() {
    var speaker = $(this).data('speaker');

    $('#updateSpeakerId').val(speaker.speaker_id);
    $('#updateSpeakerName').val(speaker.name);
    $('#updateSpeakerAddress').val(speaker.address);
    $('#updateSpeakerEmail').val(speaker.email);
    $('#updateSpeakerContact').val(speaker.contact);


    $.ajax({
        url: "table/speaker_list_talk.php",
        method: "POST",
        data: {
            speaker_id: speaker.speaker_id
        },
        success: function(data) {
            $('#speaker_list_talk').html(data);
        }
    });



    var modal = new bootstrap.Modal(document.getElementById('updateSpeakerModal'));
    modal.show();
});
$('.btnDelete').on('click', function() {

    var $tr = $(this).closest('tr');
    var data = $tr.children("td").map(function() {
        return $.trim($(this).text()); // Trimming the text content of each 'td'
    }).get();


    $('#deleteUserId').val(data[0]);

    // Show the Delete User modal
    var modal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
    modal.show();
});
</script>

</html>