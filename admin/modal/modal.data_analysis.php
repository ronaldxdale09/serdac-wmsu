 <!-- Modal -->
 <div class="modal fade" id="dataAnalysisDetails" tabindex="-1" role="dialog"
     aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header bg-dark text-white">
                 <h5 class="modal-title">Request Service Details</h5>
             </div>
             <div class="modal-body">
                 <!-- Form -->

                 <form action="function/request.action.php" method="post">

                     <input type="text" class="form-control" name="user_id" id="p_user_id" hidden>
                     <input type="text" class="form-control" name="req_id" id="p_req_id" hidden>
                     <input type="text" class="form-control" name="sched_date" id="p_sched_date" hidden>

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
                         <div class="form-group  col-md-6">
                             <label for="client-type">Client Type</label>
                             <input type="text" class="form-control" id="client-type" readonly>
                         </div>
                         <div class="form-group  col-md-6">
                             <label for="anaylsis-type">Analysis Type</label>
                             <input type="text" class="form-control" id="anaylsis-type" readonly>
                         </div>
                     </div>

                     <div class="container-research my-4 p-3 border">
                         <h3 class="header-research mb-3">Research Details</h3>
                         <div class="row">
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <label for="research-overview" class="form-control-label required">Research
                                         Overview:</label>
                                     <textarea id="research-overview"  class="form-control" readonly rows="3"></textarea>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="general-objective" class="form-control-label required">General
                                         Objective:</label>
                                     <textarea id="general-objective" name="general_objective" class="form-control"
                                        readonly rows="3"></textarea>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="specific-objective" class="form-control-label required">Specific
                                         Objectives:</label>
                                     <textarea id="specific-objective" name="specific_objective" class="form-control"
                                     readonly rows="3"></textarea>
                                 </div>
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
                     <hr>

                     <div class="selected_schedule"></div>
                     <br>


                     <div class="form-group">
                         <label for="remarks">Admin Remarks (Optional):</label>
                         <textarea class="form-control" id="remarks" name="remarks" rows="3"
                             placeholder="Enter any additional comments or information here."></textarea>
                     </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                 <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>
                     Cancel Request</button>
                 <button type="button" class="btn btn-success" id="confirm-service-request"><i
                         class="fas fa-calendar-alt"></i> Assign Schedule</button>
                 <button type="submit" name="confirm" hidden class="btn btn-warning text-dark" id="submit-request"><i
                         class="fas fa-check"></i> Confirm Request</button>
             </div>
         </div>

         </form>
     </div>
 </div>