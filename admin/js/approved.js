$(document).ready(function() {



    $('.btnProceed').on('click', function() {
        var req = $(this).data('req');

        $('#d_req_id').val(req.request_id || 'N/A');



        var modal = new bootstrap.Modal(document.getElementById('serviceProceedModal'));
        modal.show();

    });



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
        $('#sched_remarks').val(request.scheduled_remarks);


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
            url: 'fetch/fetch.data_analysis.php', // Server-side script to return data
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

                var buttons = document.querySelectorAll('button');
                buttons.forEach(function(button) {
                    if (button.innerHTML.includes('Cancel Request') ||
                        button.innerHTML.includes('Assign Schedule') ||
                        button.innerHTML.includes('Confirm Request')) {
                        button.style.display = 'none';
                    }
                });



                // Show the modal
                var modal = new bootstrap.Modal(document.getElementById(
                    'serviceRequestDetailsModal'));
                modal.show();
            },
            error: function() {
                console.log('Error fetching details.');
            }
        });

    });



    $('.btnMeeting').on('click', function() {
        var request = $(this).data('request');

        $('#m_req_id').val(request.request_id);

        $('#m_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
            'N/A');
        $('#m_service-type').val(request.service_type || 'N/A');
        $('#m_office-agency').val(request.office_agency || 'N/A');
        $('#m_agency-classification').val(request.agency_classification || 'N/A');
        $('#m_client-type').val(request.client_type || 'N/A');

        $('#m_from_date').val(request.sched_from_date || 'N/A');
        $('#m_to_date').val(request.sched_to_date || 'N/A');

        $('#m_purpose').val(request.selected_purposes || 'N/A');


        request_id = request.request_id;

        function fetch_meeting() {

            $.ajax({
                url: "table/table.meeting.php",
                method: "POST",
                data: {
                    request_id: request_id,

                },
                success: function(data) {
                    $('#meeting_table_modal').html(data);

                }
            });
        }
        fetch_meeting();



        var modal = new bootstrap.Modal(document.getElementById('serviceMeetingModal'));
        modal.show();

    });



    $(document).on('click', '#btnSaveMeetingForm', function(e) {
        // Prevent the default form submission
        e.preventDefault();
        // Set the form action to the desired URL
        $('#meeting_form').attr('action', 'function/service_action.meeting.php');

        // Submit the form asynchronously using AJAX
        $.ajax({
            type: "POST",
            url: $('#meeting_form').attr('action'),
            data: $('#meeting_form').serialize(),
            success: function(response) {
                if (response.trim() === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Meeting Record Saved!',
                    });


                    var selectElement = document.getElementById('patient_name');
                    $(selectElement).chosen('destroy');


                    // Set all inputs to readonly
                    $('#meeting_form input').prop('readonly', true);
                    $('#meeting_form textarea').prop('readonly', true);
                    $('#meeting_form select').prop('disabled',
                        true); //use 'disabled' for select elements
                    // Disable all buttons inside the form
                    // Temporarily hide the buttons

                    // $('#confirmPrenatalModal').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle the error response
                // Display SweetAlert error popup
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Form submission failed!',
                });
            }
        });
    });

});



$('.btnSpeaker').on('click', function() {
    var request = $(this).data('request');

    $('#sp_req_id').val(request.request_id);

    $('#sp_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
        'N/A');
    $('#sp_service-type').val(request.service_type || 'N/A');
    $('#sp_office-agency').val(request.office_agency || 'N/A');
    $('#sp_agency-classification').val(request.agency_classification || 'N/A');
    $('#sp_client-type').val(request.client_type || 'N/A');

    $('#sp_frosp_date').val(request.sched_frosp_date || 'N/A');
    $('#sp_to_date').val(request.sched_to_date || 'N/A');

    $('#sp_purpose').val(request.selected_purposes || 'N/A');
    // $('#d_additional_details').val(request.additional_purpose_details || 'N/A');

    // $('#d_remarks').val(request.scheduled_remarks || 'N/A');


    request_id = request.request_id;

    function fetch_speaker() {

        $.ajax({
            url: "table/table_sr_speaker.php",
            method: "POST",
            data: {
                request_id: request_id,

            },
            success: function(data) {
                $('#speaker_list_table').html(data);



            }
        });
    }
    fetch_speaker();


    serviceType = request.service_type;
    $.ajax({
        url: 'fetch/fetch.training.php', // Server-side script to return data
        type: 'POST',
        data: {
            service_type: serviceType,
            request_id: request.request_id
        },
        success: function(response) {
            // Assume response is JSON

            var details = JSON.parse(response);

            $('#service_title').val(details.title || '');
            $('#serviceVenue').val(details.venue || '');

            $('#fromDate').val(details.s_from || '');
            $('#toDate').val(details.s_to || '');

            //makeReadOnly(); // Call this function here

        },
        error: function() {
            console.log('Error fetching details.');
        }
    });



    var modal = new bootstrap.Modal(document.getElementById('serviceSpeakerModal'));
    modal.show();

});



$(document).on('click', '#btnSaveSpeaker', function(e) {
    // Prevent the default form submission
    e.preventDefault();

    // Set the form action to the desired URL
    $('#speaker_form').attr('action', 'function/service_action.speaker.php');

    // Submit the form asynchronously using AJAX
    $.ajax({
        type: "POST",
        url: $('#speaker_form').attr('action'),
        data: $('#speaker_form').serialize(),
        success: function(response) {
            if (response.trim() === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Training Record Saved!',
                });


                var selectElement = document.getElementById('patient_name');
                $(selectElement).chosen('destroy');


                // Set all inputs to readonly
                $('#speaker_form input').prop('readonly', true);
                $('#speaker_form textarea').prop('readonly', true);
                $('#speaker_form select').prop('disabled',
                    true); //use 'disabled' for select elements
                // Disable all buttons inside the form
                // Temporarily hide the buttons

                // $('#confirmPrenatalModal').modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response,
                });
            }
        },
        error: function(xhr, status, error) {
            // Handle the error response
            // Display SweetAlert error popup
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Form submission failed!',
            });
        }
    });
});