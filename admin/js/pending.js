$(document).ready(function() {
    $('.btnEdit').on('click', function() {
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



                document.querySelectorAll('button').forEach(function(button) {
                    if (button.innerHTML.includes('Cancel Request') ||
                        button.innerHTML.includes('Assign Schedule')) {
                        button.style.display = 'inline-block'; // Show the buttons
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





    $(document).ready(function() {
        var serviceRequestModal = new bootstrap.Modal(document.getElementById(
            'serviceRequestDetailsModal'));
        var scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));

        document.getElementById('assign-sched').addEventListener('click', function() {
            console.log("Hiding service request modal and showing schedule modal.");
            serviceRequestModal.hide();
            scheduleModal.show();
        });

        document.getElementById('confirm-schedule').addEventListener('click', function() {
            var selectedDateTime = document.getElementById('schedule-date').value;
            console.log("Selected DateTime: " + selectedDateTime);

            if (selectedDateTime) {
                var formattedDateTime = new Date(selectedDateTime).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                document.getElementById('p_sched_date').value = selectedDateTime;
                document.querySelector('.selected_schedule').innerHTML =
                    '<h5>Selected Schedule</h5><p>' + formattedDateTime + '</p>';

                var submitBtn = document.getElementById('submit-request');
                submitBtn.removeAttribute('hidden');
                console.log("Submit button should now be visible.");

                scheduleModal.hide();
            } else {
                alert('Please select a date and time.');
            }
        });
    });



    $(document).ready(function() {
        var table = $('#service_request_table').DataTable({
            dom: 'Bfrtip',
            buttons: ['excelHtml5', 'pdfHtml5', 'print']
        });
    });


});