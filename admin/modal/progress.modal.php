



 <div class="modal fade" id="reqserviceDetails" tabindex="-1" role="dialog"
     aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header bg-dark text-white">
                 <h5 class="modal-title">Request Service Details</h5>
             </div>
             <div class="modal-body">

                 <div class="form-row">
                     <!-- User ID -->
                     <div class="form-group col-md-6">
                         <label for="user-id">Client</label>
                         <input type="text" class="form-control" id="d_user-name" readonly>
                     </div>

                     <!-- Service Type -->
                     <div class="form-group col-md-6">
                         <label for="service-type">Service Type</label>
                         <input type="text" class="form-control" id="d_service-type" readonly>
                     </div>
                 </div>


                 <div class="form-row">
                     <!-- Office Agency -->
                     <div class="form-group col-md-6">
                         <label for="office-agency">Office/Agency</label>
                         <input type="text" class="form-control" id="d_office-agency" readonly
                             placeholder="Enter office/agency">
                     </div>

                     <!-- Agency Classification -->
                     <div class="form-group col-md-6">
                         <label for="agency-classification">Agency Classification</label>
                         <input type="text" class="form-control" id="d_agency-classification" readonly>
                     </div>
                 </div>


                 <div class="form-row">
                     <!-- Client Type -->
                     <div class="form-group  col-md-4">
                         <label for="client-type">Client Type</label>
                         <input type="text" class="form-control" id="d_client-type" readonly>
                     </div>
              

                 </div>
                 <div class="form-row">
                     <!-- Client Type -->
                     <div class="form-group  col-md-6">
                         <label for="client-type">Purpose</label>
                         <input type="text" class="form-control" id="d_purpose" readonly>
                     </div>
                 </div>

                 <!-- Purpose -->
                 <div class="form-group">
                     <label for="purpose">Additional Details </label>
                     <textarea readonly class="form-control" id="d_additional_details" rows="3"></textarea>
                 </div>
                 <hr>

                 <div class="d_selected_schedule"></div>
                 <br>

                 <div class="form-group">
                     <label for="remarks">Admin Remarks (Optional):</label>
                     <textarea readonly class="form-control" id="d_remarks" rows="3"></textarea>
                 </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
         </div>


     </div>
 </div>
