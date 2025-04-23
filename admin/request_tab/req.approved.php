  <?php
                    $results = mysqli_query($con, "SELECT 
                    sr.request_id,
                    sr.status,
                    sr.service_type,
                    sr.office_agency,
                    sr.agency_classification,
                    sr.client_type,
                    sr.selected_purposes,
                    sr.additional_purpose_details,
                    sr.request_date,
                    sr.scheduled_date,
                    sr.ongoing_date,
                    sr.inviteCode,
                    sr.scheduled_remarks,
                    sr.inprogress_remarks,
                    sr.cancelled_remarks,
                    u.fname,
                    u.midname,
                    u.lname,
                    u.email,
                    MAX(sm.date_time) AS latest_meeting_date,
                    COUNT(sm.meet_id) AS meeting_count
                FROM service_request sr
                LEFT JOIN users u ON sr.user_id = u.user_id
                LEFT JOIN sr_meeting sm ON sr.request_id = sm.request_id
                WHERE sr.status = 'Approved'
                GROUP BY sr.request_id
                ORDER BY latest_meeting_date DESC, sr.request_date DESC;");
                            ?><div class="custom-table-container">
      <div class="table-header">
          <div class="table-title">
              <h2>Scheduled Requests</h2>
              <p class="text-muted"><?php echo date('F j, Y'); ?></p>
          </div>
          <div class="table-controls">
              <div class="btn-group">
                  <button class="btn btn-outline-secondary btn-export" data-type="excel">
                      <i class="fas fa-file-excel"></i> Excel
                  </button>
                  <button class="btn btn-outline-secondary btn-export" data-type="pdf">
                      <i class="fas fa-file-pdf"></i> PDF
                  </button>
                  <button class="btn btn-outline-secondary btn-export" data-type="print">
                      <i class="fas fa-print"></i> Print
                  </button>
              </div>
          </div>
      </div>

      <div class="table-responsive">
          <table class="table" id="service_sched_table" style="width: 100%">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Status</th>
                      <th>Next Meeting</th>
                      <th>Service</th>
                      <th>Client</th>
                      <th>Agency</th>
                      <th>Remarks</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  <?php while ($row = mysqli_fetch_array($results)) { 
                                            $status_color = match($row['status']) {
                                                'Pending' => 'badge-warning',
                                                'Approved' => 'badge-primary',
                                                'Rejected' => 'badge-danger',
                                                default => 'badge-secondary'
                                            };
                        
                                            $type_color = match($row['service_type']) {
                                                'data-analysis' => 'badge-success',
                                                'capability-training' => 'badge-primary',
                                                'technical-assistance' => 'badge-dark',
                                                default => 'badge-secondary'
                                            };
                        
                                            $client = htmlspecialchars($row['fname'] . ' ' . $row['lname']);
                                            $meeting_date = $row['latest_meeting_date'] ? 
                                                date('M j, Y, h:i A', strtotime($row['latest_meeting_date'])) : 
                                                'No meeting scheduled';
                                        ?>
                  <tr>
                      <td class="text-muted">#<?php echo str_pad($row['request_id'], 4, '0', STR_PAD_LEFT); ?></td>
                      <td><span class="badge <?php echo $status_color; ?>"><?php echo $row['status']; ?></span></td>
                      <td>
                          <div class="meeting-info">
                              <i class="fas fa-calendar-alt text-muted"></i>
                              <span><?php echo $meeting_date; ?></span>
                          </div>
                      </td>
                      <td><span class="badge <?php echo $type_color; ?>"><?php echo $row['service_type']; ?></span></td>
                      <td class="client-info">
                          <div class="d-flex align-items-center">
                              <span class="client-name"><?php echo $client; ?></span>
                          </div>
                      </td>
                      <td><?php echo htmlspecialchars($row['office_agency']); ?></td>
                      <td>
                          <div class="remarks-cell">
                              <?php echo htmlspecialchars($row['scheduled_remarks'] ?? 'No remarks'); ?>
                          </div>
                      </td>
                      <td>
                          <div class="action-buttons">
                              <button type="button" class="btn btn-icon btn-primary btnView"
                                  data-request='<?php echo htmlspecialchars(json_encode($row)); ?>'
                                  title="View Details">
                                  <i class="fas fa-book"></i>
                              </button>
                              <button type="button" class="btn btn-icon btn-secondary btnMeeting"
                                  data-request='<?php echo htmlspecialchars(json_encode($row)); ?>'
                                  title="Manage Meetings">
                                  <i class="fas fa-calendar"></i>
                                  <?php if($row['meeting_count'] > 0): ?>
                                  <span class="badge badge-light"><?php echo $row['meeting_count']; ?></span>
                                  <?php endif; ?>
                              </button>
                              <?php if ($row['service_type'] == 'capability-training'): ?>
                              <button type="button" class="btn btn-icon btn-dark btnSpeaker"
                                  data-request='<?php echo htmlspecialchars(json_encode($row)); ?>'
                                  title="Manage Speakers">
                                  <i class="fas fa-users"></i>
                              </button>
                              <?php endif; ?>
                              <button type="button" class="btn btn-icon btn-success btnProceed"
                                  data-req='<?php echo htmlspecialchars(json_encode($row)); ?>' title="Proceed">
                                  <i class="fas fa-arrow-right"></i>
                              </button>
                          </div>
                      </td>
                  </tr>
                  <?php } ?>
              </tbody>
          </table>
      </div>
  </div>

  <script>
$(document).ready(function() {
    var table = $('#service_sched_table').DataTable({
        responsive: true,
        scrollX: false,
        autoWidth: false,
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        columnDefs: [{
                width: '60px',
                targets: 0
            }, // Assuming ID is the first column
            {
                width: 'auto',
                targets: '_all'
            }
        ]
    });

    $(window).on('resize', function() {
        table.columns.adjust().draw();
    });
});
$(document).ready(function() {


    // Proceed Button Click Handler
    $('.btnProceed').on('click', function() {
        var req = $(this).data('req');
        $('#d_req_id').val(req.request_id || 'N/A');

        var modal = new bootstrap.Modal(document.getElementById('serviceProceedModal'));
        modal.show();
    });

    // View Button Click Handler
    $('.btnView').on('click', function() {
        var request = $(this).data('request');

        populateViewModal(request);
        loadServiceSpecificContent(request.service_type);
        fetchDataAnalysisDetails(request.service_type, request.request_id);


        enableModalElements('serviceRequestDetailsModal');
        var modal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
        modal.show();
    });

    // Meeting Button Click Handler
    $('.btnMeeting').on('click', function() {
        var request = $(this).data('request');

        populateMeetingModal(request);
        fetchMeetingDetails(request.request_id);


        var modalId = 'serviceMeetingModal';
        var modalElement = document.getElementById(modalId);

        var modal = new bootstrap.Modal(modalElement);
        modal.show();

        enableModalElements(modalId);

    });

    // Save Meeting Form Handler
    $(document).on('click', '#btnSaveMeetingForm', function(e) {
        e.preventDefault();
        submitForm('meeting_form', 'function/service_action.meeting.php', 'Meeting Record Saved!');
    });

    // Speaker Button Click Handler
    $('.btnSpeaker').on('click', function() {
        var request = $(this).data('request');

        populateSpeakerModal(request);
        fetchSpeakerDetails(request.request_id);
        fetchTrainingDetails(request.service_type, request.request_id);

        var modal = new bootstrap.Modal(document.getElementById('serviceSpeakerModal'));
        modal.show();
    });

    // Save Speaker Form Handler
    $(document).on('click', '#btnSaveSpeaker', function(e) {
        e.preventDefault();
        submitForm('speaker_form', 'function/service_action.speaker.php', 'Training Record Saved!');
    });
});

// Functions to Populate Modals
function populateViewModal(request) {
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
    $('#sched_remarks').val(request.scheduled_remarks);
    $('#service-specific').empty();
}

function populateMeetingModal(request) {
    $('#m_req_id').val(request.request_id);
    $('#m_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname : 'N/A');
    $('#m_email').val(request.email);

    $('#m_service-type').val(request.service_type || 'N/A');
    $('#m_office-agency').val(request.office_agency || 'N/A');
    $('#m_agency-classification').val(request.agency_classification || 'N/A');
    $('#m_client-type').val(request.client_type || 'N/A');
    $('#m_from_date').val(request.sched_from_date || 'N/A');
    $('#m_to_date').val(request.sched_to_date || 'N/A');
    $('#m_purpose').val(request.selected_purposes || 'N/A');
}

function populateSpeakerModal(request) {
    $('#sp_req_id').val(request.request_id);
    $('#sp_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname : 'N/A');
    $('#sp_service-type').val(request.service_type || 'N/A');
    $('#sp_office-agency').val(request.office_agency || 'N/A');
    $('#sp_agency-classification').val(request.agency_classification || 'N/A');
    $('#sp_client-type').val(request.client_type || 'N/A');
    $('#sp_frosp_date').val(request.sched_frosp_date || 'N/A');
    $('#sp_to_date').val(request.sched_to_date || 'N/A');
    $('#sp_purpose').val(request.selected_purposes || 'N/A');
}

// Functions to Load and Fetch Content
function loadServiceSpecificContent(serviceType) {
    var serviceTypeUrl = '';
    if (serviceType === 'data-analysis') {
        serviceTypeUrl = 'modal/md.data_analysis.php';
    } else if (serviceType === 'technical-assistance') {
        serviceTypeUrl = 'modal/md.tech_assist.php';
    }

    if (serviceTypeUrl) {
        $('#service-specific').load(serviceTypeUrl, function(response, status, xhr) {
            if (status === "error") {
                console.error("Error loading the page: " + xhr.status + " " + xhr.statusText);
            }
        });
    }
}

function fetchDataAnalysisDetails(serviceType, requestId) {
    if (serviceType === 'data-analysis') {
        $.ajax({
            url: 'fetch/fetch.data_analysis.php',
            type: 'POST',
            data: {
                service_type: serviceType,
                request_id: requestId
            },
            success: function(response) {
                var details = JSON.parse(response);
                $('#anaylsis-type').val(details.analysis_type);
                $('#research-overview').val(details.overview);
                $('#general-objective').val(details.g_objective);
                $('#specific-objective').val(details.s_objective);

                console.log(details);

                $('button').each(function() {
                    if ($(this).text().includes('Cancel Request') || $(this).text().includes(
                            'Assign Schedule') || $(this).text().includes('Confirm Request')) {
                        $(this).hide();
                    }
                });
            },
            error: function() {
                console.error('Error fetching details.');
            }
        });
    }
}

function fetchMeetingDetails(requestId) {
    $.ajax({
        url: "table/table.meeting.php",
        method: "POST",
        data: {
            request_id: requestId
        },
        success: function(data) {
            $('#meeting_table_modal').html(data);
        }
    });
}

function fetchSpeakerDetails(requestId) {
    $.ajax({
        url: "table/table_sr_speaker.php",
        method: "POST",
        data: {
            request_id: requestId
        },
        success: function(data) {
            $('#speaker_list_table').html(data);
        }
    });
}

function fetchTrainingDetails(serviceType, requestId) {
    $.ajax({
        url: 'fetch/fetch.training.php',
        type: 'POST',
        data: {
            service_type: serviceType,
            request_id: requestId
        },
        success: function(response) {
            var details = JSON.parse(response);
            $('#service_title').val(details.title || '');
            $('#serviceVenue').val(details.venue || '');
            $('#fromDate').val(details.s_from || '');
            $('#toDate').val(details.s_to || '');
        },
        error: function() {
            console.error('Error fetching details.');
        }
    });
}

// Function to Submit Form
function submitForm(formId, actionUrl, successMessage) {
    $('#' + formId).attr('action', actionUrl);
    $.ajax({
        type: "POST",
        url: $('#' + formId).attr('action'),
        data: $('#' + formId).serialize(),
        success: function(response) {
            if (response.trim() === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: successMessage,
                });


                // Set all inputs to readonly
                $('#' + formId + ' input').prop('readonly', true);
                $('#' + formId + ' textarea').prop('readonly', true);
                $('#' + formId + ' select').prop('disabled', true); // use 'disabled' for select elements
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response,
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Form submission failed!',
            });
        }
    });
}
  </script>