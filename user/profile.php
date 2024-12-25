<form>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">First name</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" name="fname" id="fname">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Middle Name</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" name="midname" id="midname">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Last name</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" name="lname" id="lname">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Email</label>
        <div class="col-lg-9">
            <input class="form-control" type="email" id="email" value="<?php echo $email; ?>" readonly>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Contact No</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" id="contact_no" name="contact_no">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Region</label>
        <div class="col-lg-9">
            <select class="form-control" name="region" id="region-select">
                <!-- Options will be populated dynamically -->
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">City</label>
        <div class="col-lg-6">
            <select class="form-control" name="city" id="city-input">
                <!-- Options will be populated dynamically -->
            </select>
        </div>
        <div class="col-lg-3">
            <select class="form-control" name="state" id="state-input">
                <!-- Options will be populated dynamically -->
            </select>
        </div>
    </div>
    <!-- <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Password</label>
        <div class="col-lg-9">
            <input class="form-control" type="password" id="password" value="11111122333">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
        <div class="col-lg-9">
            <input class="form-control" type="password" id="confirm-password" value="11111122333">
        </div>
    </div> -->
    <hr>
    <div class="form-group">
        <div class="row">
            <div class="col-md-3 mb-3 mb-md-0">
                <label class="form-control-label">
                    <!-- Label text if needed -->
                </label>
            </div>
            <div class="col-md-9">
                <div class="d-flex flex-column flex-md-row">
                    <button type="button" class="btn btn-primary btn-submit mb-2 mb-md-0 me-md-2">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <button type="button" class="btn btn-secondary" id="changePasswordBtn">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </div>
            </div>
        </div>
    </div>



</form>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the button and modal elements
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));

    // Add click event listener to the button
    changePasswordBtn.addEventListener('click', function() {
        changePasswordModal.show();
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const regionSelect = document.getElementById('region-select');
    const cityInput = document.getElementById('city-input');
    const stateInput = document.getElementById('state-input');

    let regions = [];
    let provinces = [];
    let cities = [];
    let barangays = [];

    // Load initial data
    fetch('js/ph-json/region.json')
        .then(response => response.json())
        .then(data => {
            regions = data;
            populateSelect(regionSelect, regions, 'region_name', '<?php echo $region; ?>');
        })
        .catch(error => console.error('Error loading region data:', error));

    fetch('js/ph-json/province.json')
        .then(response => response.json())
        .then(data => {
            provinces = data;
            populateSelect(stateInput, provinces, 'province_name', '<?php echo $province; ?>');
        })
        .catch(error => console.error('Error loading province data:', error));

    fetch('js/ph-json/city.json')
        .then(response => response.json())
        .then(data => {
            cities = data;
            populateSelect(cityInput, cities, 'city_name', '<?php echo $city; ?>');
        })
        .catch(error => console.error('Error loading city data:', error));

    function populateSelect(selectElement, data, key, selectedValue) {
        selectElement.innerHTML = `<option value="">Select ${selectElement.id.split('-')[0]}</option>`;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item[key];
            option.textContent = item[key];
            if (item[key] === selectedValue) {
                option.selected = true;
            }
            selectElement.appendChild(option);
        });
    }
});
</script>


<script>
$('.btn-submit').click(function(e) {
    e.preventDefault();

    var formData = {
        fname: $('#fname').val(),
        midname: $('#midname').val(),
        lname: $('#lname').val(),
        contact_no: $('#contact_no').val(),
        region: $('#region-select').val(),
        city: $('#city-input').val(),
        state: $('#state-input').val(),
        username: $('#username').val(),
        password: $('#password').val(),
        confirm_password: $('#confirm-password').val()
    };

    Swal.fire({
        title: 'Updating Profile',
        text: 'Please wait while we update your profile...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: 'function/update_profile.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: 'Your profile has been updated successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while updating your profile. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});


$(document).ready(function() {
    // Reset form when modal is closed
    $('#changePasswordModal').on('hidden.bs.modal', function() {
        $('#changePasswordForm')[0].reset();
        $('#passwordError').addClass('d-none').html('');
    });

    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();

        // Get form values
        const currentPassword = $('#currentPassword').val().trim();
        const newPassword = $('#newPassword').val().trim();
        const confirmPassword = $('#confirmPassword').val().trim();

        // Basic validation
        if (!currentPassword || !newPassword || !confirmPassword) {
            $('#passwordError').removeClass('d-none').html('All fields are required');
            return;
        }

        if (newPassword !== confirmPassword) {
            $('#passwordError').removeClass('d-none').html(
                'New password and confirm password do not match');
            return;
        }

        if (newPassword.length < 8) {
            $('#passwordError').removeClass('d-none').html(
                'New password must be at least 8 characters long');
            return;
        }

        // Disable form submission button
        $('#savePasswordBtn').prop('disabled', true);

        // Show loading state
        Swal.fire({
            title: 'Updating Password',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Send AJAX request
        $.ajax({
            url: 'function/update_password.php',
            type: 'POST',
            data: {
                current_password: currentPassword,
                new_password: newPassword,
                confirm_password: confirmPassword
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your password has been updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#changePasswordModal').modal('hide');
                        $('#changePasswordForm')[0].reset();
                    });
                } else {
                    $('#passwordError').removeClass('d-none').html(response.message ||
                        'An error occurred');
                    Swal.close();
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating your password. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            },
            complete: function() {
                // Re-enable form submission button
                $('#savePasswordBtn').prop('disabled', false);
            }
        });
    });
});
</script>