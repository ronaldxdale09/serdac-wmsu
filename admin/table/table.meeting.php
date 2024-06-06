<style>
.meeting-accordion .meeting-panel {
    border-bottom: 1px solid #ccc;
}

.meeting-accordion .meeting-header {
    background: #a3c0f0;

    /* Light gray background */
    border-top: 1px solid #ddd;
}

.meeting-accordion .meeting-toggle {
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    padding: 12px 15px;
    font-size: 1rem;
    font-weight: bold;
    color: #242424;
    transition: background-color 0.3s ease;
}

.meeting-accordion .meeting-toggle:hover,
.meeting-accordion .meeting-toggle:focus {
    background-color: #d2d2d2;
    /* Slight highlight on hover/focus */
    text-decoration: none;
    /* No underline */
    outline: none;
}

.meeting-accordion .collapse:not(.show) {
    display: none;
}

.meeting-accordion .meeting-body {
    padding: 15px;
    background: #fff;
    transition: padding 0.3s ease;
}

.form-control,
.form-control:focus {
    border-radius: 4px;
    border: 1px solid #ced4da;
    box-shadow: none;
}

textarea.form-control {
    height: 80px;
}

/* 
.btn-danger,
.btn-primary {
    margin-top: 10px;
} */
</style>

<?php
include('../../function/db.php');

$request_id = $_POST['request_id'];
// Fetch initial meeting records along with user information
$query = "
    SELECT 
        sr_meeting.*, 
        users.fname, 
        users.lname, 
        users.email 
    FROM sr_meeting 
    INNER JOIN service_request ON sr_meeting.request_id = service_request.request_id
    INNER JOIN users ON service_request.user_id = users.user_id 
    WHERE sr_meeting.request_id = $request_id
";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

// Fetch meeting types from the database
$typeQuery = "SELECT mtype_id, meeting_type FROM d_meeting_type";
$typeResult = mysqli_query($con, $typeQuery);
if (!$typeResult) {
    die('Failed to retrieve meeting types: ' . mysqli_error($con));
}

$meetingTypes = [];
while ($typeRow = mysqli_fetch_assoc($typeResult)) {
    $meetingTypes[$typeRow['mtype_id']] = $typeRow['meeting_type'];
}


$modeOptions = [
    'face2face' => 'Face-to-Face',
    'online' => 'Online'
];

// Prepare the select HTML for meeting types
$selectHTML = '<select class="form-control" name="meeting_type[]">';
foreach ($meetingTypes as $key => $type) {
    $selectHTML .= "<option value=\"$key\">$type</option>";
}
$selectHTML .= '</select>';

// Prepare the select HTML for mode options
$modeSelectHTML = '<select class="form-control" name="mode[]">';
foreach ($modeOptions as $value => $text) {
    $modeSelectHTML .= "<option value=\"$value\">$text</option>";
}
$modeSelectHTML .= '</select>';

// Start the output with a div container for the accordion
$output = '<div id="meetingAccordion" class="meeting-accordion">';

$index = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $dateValue = date('Y-m-d\TH:i', strtotime($row['date_time']));
    $selectedTypeHTML = str_replace('value="' . $row['meeting_type'] . '"', 'value="' . $row['meeting_type'] . '" selected', $selectHTML);
    $selectedModeHTML = str_replace('value="' . $row['mode'] . '"', 'value="' . $row['mode'] . '" selected', $modeSelectHTML);
    $formattedDate = date('F j, Y', strtotime($row['date_time']));  
    $meetingType = $meetingTypes[$row['meeting_type']];  

    $output .= '
    <div class="meeting-panel">
        <div class="meeting-header" id="heading' . $index . '">
            <button type="button" class="meeting-toggle collapsed" data-toggle="collapse" data-target="#collapse' . $index . '" aria-expanded="false" aria-controls="collapse' . $index . '">
                <i class="fa fa-chevron-down"></i> ' . $meetingType . ' - ' . $formattedDate . '
            </button>
        </div>
        <div id="collapse' . $index . '" class="collapse" aria-labelledby="heading' . $index . '" data-parent="#meetingAccordion">
            <div class="meeting-body">
                <div><strong>Type:</strong> ' . $selectedTypeHTML . '</div>
                <div><strong>Date and Time:</strong><input type="datetime-local" class="form-control" name="date_time[]" value="' . $dateValue . '"></div> 
                <div><strong>Mode:</strong> ' . $selectedModeHTML . '</div>
                <div><strong>Remarks:</strong> <textarea class="form-control" name="remarks[]">' . htmlspecialchars($row['remarks'], ENT_QUOTES, 'UTF-8') . '</textarea></div>
                <div class="client-name" style="display:none;">' . $row['fname'] . ' ' . $row['lname'] . '</div>
                <div class="client-email" style="display:none;">' . $row['email'] . '</div>
                <br><button type="button" class="btn btn-danger remove-item"><i class="fa fa-trash"></i> Remove</button>
                <button type="button" class="btn btn-primary notify-email"><i class="fa fa-envelope"></i> Notify via Email</button>
            </div>
        </div>
    </div>';
    $index++;
}

echo $output;

?>





<script>
$(document).ready(function() {
    var index = $('.meeting-panel').length; // Initialize index based on existing panels

    // Add new meeting panel
    $('#addMeeting').click(function() {
        var newIndex = $('.meeting-panel')
            .length; // Fetch new index in case other meetings were added or removed

        // Create HTML for the new meeting accordion panel with "Set New Meeting" title
        var newPanel = $('<div class="meeting-panel">').append(
            $('<div class="meeting-header" id="heading' + newIndex + '">').html(
                '<button type="button" class="meeting-toggle collapsed" data-toggle="collapse" data-target="#collapse' +
                newIndex + '" aria-expanded="true" aria-controls="collapse' + newIndex +
                '">Set New Meeting</button>'
            ),
            $('<div id="collapse' + newIndex + '" class="collapse show" aria-labelledby="heading' +
                newIndex + '" data-parent="#meetingAccordion">').html(
                '<div class="meeting-body">' +
                '<div><strong>Type:</strong> ' + '<?php echo $selectHTML; ?>' + '</div>' +
                '<div><strong>Date and Time:</strong> <input type="datetime-local" class="form-control" name="date_time[]"></div>' +
                '<div><strong>Mode:</strong> ' + '<?php echo $modeSelectHTML; ?>' + '</div>' +
                '<div><strong>Remarks:</strong> <textarea class="form-control" placeholder="Enter meeting details, remarks, or the online meeting link" name="remarks[]"></textarea></div>' +
                '<br><button type="button" class="btn btn-danger remove-item"><i class="fa fa-trash"></i> Remove</button></div>'
            )
        );

        // Append new panel to the accordion and immediately show it
        $('#meetingAccordion').append(newPanel);
        $('#collapse' + newIndex).collapse('show'); // Ensure the new panel is opened
    });

    // Event delegation for removing items dynamically added to the DOM
    $(document).on('click', '.remove-item', function() {
        $(this).closest('.meeting-panel').remove();
    });

    // Initialize Bootstrap collapse functionality if needed
    // This ensures that dynamically added accordion components work properly
    $(document).on('show.bs.collapse', '.collapse', function() {
        $(this).siblings('.meeting-header').find('.meeting-toggle').attr('aria-expanded', 'true');
    });

    $(document).on('hide.bs.collapse', '.collapse', function() {
        $(this).siblings('.meeting-header').find('.meeting-toggle').attr('aria-expanded', 'false');
    });

    // Confirm Meeting Button Click Handler in serviceMeetingModal
    $('#btnSaveMeetingForm').on('click', function(e) {
        e.preventDefault();

        var formData = $('#meeting_form').serialize();

        $.ajax({
            url: 'function/service_action.meeting.php', // Your server script to handle meeting confirmation
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Meeting Record Successful',
                    text: 'The meeting has been successfully recorded.',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Populate the email notification modal with the meeting details
                        var meetingType = $('#m_service-type').val();
                        var meetingDateTime = $(
                            '#meeting_form input[name="date_time[]"]').val();
                        var meetingMode = $('#meeting_form select[name="mode[]"]')
                            .val(); // Get the value of the selected option
                        var meetingRemarks = $(
                            '#meeting_form textarea[name="remarks[]"]').val();
                        var clientName = $('#m_user-name').val();
                        var clientEmail = $('#m_email')
                            .val(); // Ensure this element exists in your form

                        var meetingContent = `
                            Dear ${clientName},

                            We are pleased to inform you about an upcoming meeting. Below are the details:

                            Type: ${meetingType}
                            Date and Time: ${new Date(meetingDateTime).toLocaleString('en-US', {
                                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit'
                            })}
                            Mode: ${meetingMode}
                            Remarks: ${meetingRemarks}

                            Please make sure to be available and prepared for this meeting. Should you have any questions or require further information, feel free to contact us.

                            Best regards,
                            SERDAC-WMSU
                        `;

                        $('#recipient-name').val(clientName);
                        $('#recipient-email').val(clientEmail);
                        $('#meeting-content').val(meetingContent);

                        // Manually hide all currently visible modals
                        $("[data-dismiss=modal]").trigger({
                            type: "click"
                        });

                        setTimeout(() => {
                            var modal = new bootstrap.Modal(document
                                .getElementById(
                                    'notifyEmailModal'));
                            modal.show();
                        }, 500);
                    }
                });


            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to save the meeting record.'
                });
                console.error('Error saving meeting record:', error);
            }
        });
    });

    // Notify Email Form Submission Handler
    $('#notifyEmailForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        // Display loading alert
        Swal.fire({
            title: 'Sending Email...',
            text: 'Please wait while we send the email notification.',
            icon: 'info',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'function/meeting_notification.php', // Update with your server script
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Email Sent',
                    text: 'The notification email has been sent successfully!'
                });

                $('#notifyEmailModal').modal('hide');
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to send the notification email.'
                });
                console.error('Error sending email notification:', error);
            }
        });
    });
});



// Notify via Email Button Click Handler
$(document).on('click', '.notify-email', function() {
    // Manually hide all currently visible modals
    $("[data-dismiss=modal]").trigger({
        type: "click"
    });

    // Wait for the hide transition to complete
    setTimeout(() => {
        var meetingBody = $(this).closest('.meeting-body');
        var meetingType = meetingBody.find('select[name="meeting_type[]"] option:selected')
            .text().trim(); // Assuming meeting type is in a select element
        var meetingDateTime = meetingBody.find('input[name="date_time[]"]').val();
        var meetingMode = meetingBody.find('select[name="mode[]"] option:selected').text()
            .trim(); // Assuming mode is in a select element
        var meetingRemarks = meetingBody.find('textarea[name="remarks[]"]').val();
        var clientName = meetingBody.find('.client-name').text()
            .trim(); // Assuming client name is in a .client-name element
        var clientEmail = meetingBody.find('.client-email').text()
            .trim(); // Assuming client email is in a .client-email element

        var meetingContent = `
            Dear ${clientName},

            We are pleased to inform you about an upcoming meeting. Below are the details:

            Type: ${meetingType}
            Date and Time: ${new Date(meetingDateTime).toLocaleString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            })}
            Mode: ${meetingMode}
            Remarks: ${meetingRemarks}

            Please make sure to be available and prepared for this meeting. Should you have any questions or require further information, feel free to contact us.

            Best regards,
            SERDAC-WMSU
        `;

        $('#recipient-name').val(clientName);
        $('#recipient-email').val(clientEmail);
        $('#meeting-content').val(meetingContent);

        var modal = new bootstrap.Modal(document.getElementById('notifyEmailModal'));
        modal.show();
    }, 500); // Adjust this timeout if necessary
});
</script>

<!-- end -->