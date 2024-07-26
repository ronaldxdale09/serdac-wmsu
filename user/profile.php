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
    <hr><div class="form-group">
    <div class="row">
        <div class="col-md-3 mb-3 mb-md-0">
            <label class="form-control-label"><!-- Label text if needed --></label>
        </div>
        <div class="col-md-9">
            <div class="d-flex flex-column flex-md-row">
                <button type="button" class="btn btn-primary btn-submit mb-2 mb-md-0 me-md-2">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-key"></i> Change Password
                </button>
            </div>
        </div>
    </div>
</div>



</form>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="changePasswordForm"  method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
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
    $('#changePasswordForm').submit(function(e) {
        e.preventDefault();

        var formData = {
            current_password: $('#currentPassword').val(),
            new_password: $('#newPassword').val(),
            confirm_password: $('#confirmPassword').val()
        };

        Swal.fire({
            title: 'Updating Password',
            text: 'Please wait while we update your password...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'function/update_password.php', // Adjust the URL as needed
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Your password has been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    $('#changePasswordModal').modal('hide'); // Hide the modal
                    $('#changePasswordForm')[0].reset(); // Reset the form
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating your password. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>