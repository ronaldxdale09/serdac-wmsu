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
                         <div class="form-group col-md-6">
                             <label for="user-id">Client</label>
                             <input type="text" class="form-control" id="p_user-name" readonly>
                         </div>

                         <!-- Service Type -->
                         <div class="form-group col-md-6">
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
                         <div class="form-group  col-md-4">
                             <label for="client-type">Client Type</label>
                             <input type="text" class="form-control" id="client-type" readonly>
                         </div>
                         <div class="col-4">
                             <div class="form-group">
                                 <label class="form-control-label required">From Date
                                     :</label>
                                 <input type="text" id="from_date" class="form-control" readonly>
                             </div>
                         </div>
                         <div class="col-4">
                             <div class="form-group">
                                 <label class="form-control-label required">To Date
                                     :</label>
                                 <input type="text" id="to_date" class="form-control" readonly>
                             </div>
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



        var modal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
        modal.show();

    });

});
 </script>