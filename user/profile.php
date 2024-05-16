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
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Username</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" id="username" value="jhonsanmark">
        </div>
    </div>
    <div class="form-group row">
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
    </div>
    <hr>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label"></label>
        <div class="col-lg-9">
            <input type="button" class="btn btn-primary btn-submit" value="Save Changes">
        </div>
    </div>
</form>



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
$(document).ready(function() {
    $('.btnRequirement').on('click', function() {
        var request = $(this).data('request');

        $('#r_req_id').val(request.request_id);

        $('#r_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
            'N/A');
        $('#r_service-type').val(request.service_type || 'N/A');
        // Show or hide the button based on the request status
        if (request.status.toLowerCase() === 'completed') {
            $('#btnUploadDoc').hide();
            $('.file-uploader').hide();

        } else {
            $('#btnUploadDoc').show();
            $('.file-uploader').show();

        }
        request_id = request.request_id;

        function fetch_files() {

            $.ajax({
                url: "table_fetch/anaylsis_files_fetch.php",
                method: "POST",
                data: {
                    request_id: request_id,

                },
                success: function(data) {
                    $('#upload_document_list').html(data);

                }
            });
        }
        fetch_files();

        function fetch_result() {
            $.ajax({
                url: "table_fetch/anaylsis_files_fetch_result.php",
                method: "POST",
                data: {
                    request_id: request_id,

                },
                success: function(data) {
                    $('#upload_document_result').html(data);

                }
            });
        }
        fetch_result();
        var modal = new bootstrap.Modal(document.getElementById('anaylsisReqModal'));
        modal.show();
    });
});


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
</script>