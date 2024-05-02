<form>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">First
            name</label>
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
        <label class="col-lg-3 col-form-label form-control-label">Last
            name</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" name="lname" id="lname">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Email</label>
        <div class="col-lg-9">
            <input class="form-control" type="email" value="<?php echo $email?>" readonly>
        </div>
    </div>


    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Address</label>
        <div class="col-lg-9">
            <select class="form-control" name="region" id="region-select">
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label"></label>
        <div class="col-lg-6">
            <input class="form-control" type="text" value="" placeholder="City">
        </div>
        <div class="col-lg-3">
            <input class="form-control" type="text" value="" placeholder="State">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Username</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" value="jhonsanmark">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Password</label>
        <div class="col-lg-9">
            <input class="form-control" type="password" value="11111122333">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label">Confirm
            password</label>
        <div class="col-lg-9">
            <input class="form-control" type="password" value="11111122333">
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label form-control-label"></label>
        <div class="col-lg-9">
            <input type="reset" class="btn btn-secondary" value="Cancel">
            <input type="button" class="btn btn-primary" value="Save Changes">
        </div>
    </div>
</form>


<script>
$(document).ready(function() {
    $('.btnRequirement').on('click', function() {
        var request = $(this).data('request');

        $('#r_req_id').val(request.request_id);

        $('#r_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
            'N/A');
        $('#r_service-type').val(request.service_type || 'N/A');
        $('#r_office-agency').val(request.office_agency || 'N/A');
        $('#r_agency-classification').val(request.agency_classification || 'N/A');
        $('#r_client-type').val(request.client_type || 'N/A');

        $('#r_fror_date').val(request.sched_fror_date || 'N/A');
        $('#r_to_date').val(request.sched_to_date || 'N/A');

        $('#r_purpose').val(request.selected_purposes || 'N/A');


        $('#m_purpose').val(request.selected_purposes || 'N/A');


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




        var modal = new bootstrap.Modal(document.getElementById('anaylsisReqModal'));
        modal.show();

    });

});
</script>

<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const regionSelect = document.getElementById('region-select');
    const provinceSelect = document.getElementById('province-select');
    const citySelect = document.getElementById('city-select');

    const barangaySelect = document.getElementById('barangay-select');

    let regions = [];
    let provinces = [];
    let cities = [];
    let barangays = [];

    // Load initial data
    fetch('js/ph-json/region.json')
        .then(response => response.json())
        .then(data => {
            regions = data;
            populateSelect(regionSelect, regions, 'region_name');
        })
        .catch(error => console.error('Error loading region data:', error));

    fetch('js/ph-json/province.json')
        .then(response => response.json())
        .then(data => provinces = data)
        .catch(error => console.error('Error loading province data:', error));

    fetch('js/ph-json/city.json')
        .then(response => response.json())
        .then(data => cities = data)
        .catch(error => console.error('Error loading city data:', error));

    fetch('js/ph-json/barangay.json')
        .then(response => response.json())
        .then(data => barangays = data)
        .catch(error => console.error('Error loading barangay data:', error));


    regionSelect.addEventListener('change', function() {
        const selectedRegionCode = regions.find(region => region.region_name === this.value)
            ?.region_code;
        const filteredProvinces = provinces.filter(province => province.region_code ===
            selectedRegionCode);
        populateSelect(provinceSelect, filteredProvinces, 'province_name');
        citySelect.innerHTML = '<option value="">Select City</option>'; // Reset city select
    });

    provinceSelect.addEventListener('change', function() {
        // Find the selected province's province_code
        const selectedProvinceCode = provinces.find(province => province.province_name === this.value)
            ?.province_code;

        // Filter the cities based on the selected province_code
        const filteredCities = cities.filter(city => city.province_code === selectedProvinceCode);
        populateSelect(citySelect, filteredCities, 'city_name');
    });

    citySelect.addEventListener('change', function() {
        // Find the selected city's city_code
        const selectedCityCode = cities.find(city => city.city_name === this.value)?.city_code;

        // Filter the barangays based on the selected city_code
        const filteredBarangays = barangays.filter(barangay => barangay.city_code === selectedCityCode);
        populateSelect(barangaySelect, filteredBarangays, 'brgy_name');
    });

    // Placeholder for barangay select event listener
    // ...

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

    fetch('js/ph-json/region.json')
        .then(response => response.json())
        .then(data => {
            regions = data;
            populateSelect(regionSelect, regions, 'region_name', '<?php echo $region; ?>');
        })
        .catch(error => console.error('Error loading region data:', error));

}

}); -->
</script>