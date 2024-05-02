 <!-- Modal -->
 <div class="modal fade" id="serviceRequestDetailsModal" tabindex="-1" role="dialog"
     aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header bg-dark text-white">
                 <h5 class="modal-title">Request Service Details</h5>
             </div>
             <div class="modal-body">

                 <form action="function/request.reject.php" method="post">

                     <input type="text" class="form-control" name="req_id" id="p_req_id" hidden>

                     <div class="form-row">
                         <!-- User ID -->
                         <div class="form-group col-md-2">
                             <label for="user-id">Request Status </label>
                             <input type="text" class="form-control" id="p_status" readonly>
                         </div>
                         <div class="form-group col-md">
                             <label for="user-id">Client</label>
                             <input type="text" class="form-control" id="p_user-name" readonly>
                         </div>

                         <!-- Service Type -->
                         <div class="form-group col-md">
                             <label for="service-type">Service Type</label>
                             <input type="text" class="form-control" id="service-type" readonly>
                         </div>
                     </div>

                     <div class="form-row">
                         <!-- Office Agency -->
                         <div class="form-group col-md-6">
                             <label for="office-agency">Office/Agency</label>
                             <input type="text" class="form-control" id="office-agency" readonly
                                 placeholder="Enter office/agency">
                         </div>

                         <!-- Agency Classification -->
                         <div class="form-group col-md-6">
                             <label for="agency-classification">Agency Classification</label>
                             <input type="text" class="form-control" id="agency-classification" readonly>
                         </div>
                     </div>



                     <div class="form-row">
                         <!-- Client Type -->
                         <div class="form-group  col-md-6">
                             <label for="client-type">Purpose</label>
                             <input type="text" class="form-control" id="purpose" readonly>
                         </div>
                     </div>

                     <!-- Purpose -->
                     <div class="form-group">
                         <label for="purpose">Additional Details </label>
                         <textarea readonly class="form-control" id="additional_details" rows="3"></textarea>
                     </div>



                     <div id='service-specific'> </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                 <button type="submit" name="reject" class="btn btn-danger"><i class="fas fa-times-circle"></i>
                     Cancel Request</button>
             </div>
         </div>

         </form>
     </div>
 </div>



 <script>
$(document).ready(function() {
    $('.btnView').on('click', function() {
        var request = $(this).data('request');

        $('#p_status').val(request.status);

        $('#p_user_id').val(request.user_id);
        $('#p_req_id').val(request.request_id);

        $('#p_user-name').val(request.fname + ' ' + request.lname);
        $('#service-type').val(request.service_type);
        $('#office-agency').val(request.office_agency);
        $('#agency-classification').val(request.agency_classification);
        $('#client-type').val(request.client_type);

        $('#from_date').val(request.sched_from_date);
        $('#to_date').val(request.sched_to_date);


        $('#purpose').val(request.selected_purposes);
        $('#additional_details').val(request.additional_purpose_details);


        // Clear previous service type content
        $('#service-specific').empty();




        // Load service-specific content based on service type
        var serviceTypeUrl = '';
        if (request.service_type === 'data-analysis') {
            serviceTypeUrl = 'modal/md.data_analysis.php';
        } else if (request.service_type === 'technical-assistance') {
            serviceTypeUrl = 'modal/md.tech_assist.php';
        } else if (request.service_type === 'technical-assistance') {
            serviceTypeUrl = '';
        }


        // Append the service-specific form to the div
        if (serviceTypeUrl) {
            $('#service-specific').load(serviceTypeUrl, function(response, status, xhr) {
                if (status === "error") {
                    console.log("Error loading the page: " + xhr.status + " " + xhr.statusText);
                }
            });
        }

        serviceType = request.service_type;
        $.ajax({
            url: 'user/fetch/fetch.data_analysis.php', // Server-side script to return data
            type: 'POST',
            data: {
                service_type: serviceType,
                request_id: request.request_id
            },
            success: function(response) {
                // Assume response is JSON
                // Parse and populate more specific fields if necessary
                if (serviceType === 'data-analysis') {
                    var details = JSON.parse(response);
                    $('#anaylsis-type').val(details.analysis_type);
                    $('#research-overview').val(details.overview);
                    $('#general-objective').val(details.g_objective);
                    $('#specific-objective').val(details.s_objective);

                    console.log(details)


                }
            },
            error: function() {
                console.log('Error fetching details.');
            }
        });



        // Determine whether to show or hide the Cancel Request button based on the status
        if (request.status.toLowerCase() === 'pending') {
            $('button[name="reject"]').show();
        } else {
            $('button[name="reject"]').hide();
        }



        var modal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
        modal.show();

    });

});
 </script>