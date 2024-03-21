<!DOCTYPE html>
<html>

<head>
    <title>SERDAC-WMSU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="icon" type="image/x-icon" href="assets/images/serdac.ico">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>


</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="card">
                <div class="form">
                    <div class="left-side">
                        <form id="regForm" action="" method="post">
                            <div class="left-heading">
                                <h3>ACCOUNT REGISTRATION</h3>
                            </div>
                            <div class="steps-content">
                                <h3>Step <span class="step-number">1</span></h3>
                                <p class="step-number-content active">Enter your personal information to get closer to
                                    companies.</p>
                                <p class="step-number-content d-none">Get to know better by adding your
                                    diploma,certificate
                                    and education life.</p>
                                <p class="step-number-content d-none">Help companies get to know you better by telling
                                    then
                                    about your past experiences.</p>
                                <p class="step-number-content d-none">Add your profile piccture and let companies find
                                    youy
                                    fast.</p>
                            </div>
                            <ul class="progress-bar">
                                <li class="active">Personal Information</li>
                                <li>Address</li>
                                <li>Account Info</li>
                            </ul>
                    </div>
                    <div class="right-side">
                        <div class="main active">
                            <small> <img src="assets/images/serdac.png" style="width:50px" alt="School Logo 1"
                                    class="school-logo" />
                            </small>
                            <div class="text">
                                <h2>Your Personal Information</h2>
                                <p>Enter your personal information to get closer to copanies.</p>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <input type="text" required require id="user_name" name="fname">
                                    <span>First Name</span>
                                </div>
                                <div class="input-div">
                                    <input type="text" required name="midname">
                                    <span>Middle Name</span>
                                </div>
                                <div class="input-div">
                                    <input type="text" required name="lname">
                                    <span>Last Name</span>
                                </div>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <input type="text" required require name="contact_no">
                                    <span>Phone number</span>
                                </div>
                                <div class="input-div">
                                    <select name="gender">
                                        <option selected disabled>Select Gender...</option>

                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Prefer not to say">Prefer not to say</option>
                                        <option value="Prefer to self-describe">Prefer to self-describe</option>

                                    </select>
                                </div>

                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <label for="occupation-select">Occupation*</label>
                                    <select id="occupation-select" name="occupation" required>
                                        <option value="" selected disabled>- Occupation -</option>
                                        <option value="student">Student</option>
                                        <option value="employed_ft">Employed (Full-time)</option>
                                        <option value="employed_pt">Employed (Part-time)</option>
                                        <option value="self_employed">Self-employed</option>
                                        <option value="homemaker">Homemaker</option>
                                        <option value="retired">Retired</option>
                                        <option value="others">Others</option>
                                    </select>

                                </div>
                                <div class="input-div">
                                    <label for="education-level-select">Educational Level*</label>
                                    <select id="education-level-select" name="education_level" required>
                                        <option value="" selected disabled>- Educational Level -</option>
                                        <option value="no_schooling">No schooling</option>
                                        <option value="elementary">Elementary</option>
                                        <option value="high_school">High School</option>
                                        <option value="vocational">Vocational</option>
                                        <option value="college">College</option>
                                        <option value="postgraduate">Postgraduate</option>
                                    </select>

                                </div>
                            </div>

                            <div class="buttons">
                                <button class="next_button">Next Step</button>
                            </div>
                        </div>
                        <div class="main">
                            <small> <img src="assets/images/serdac.png" style="width:50px" alt="School Logo 1"
                                    class="school-logo" />
                            </small>
                            <div class="text">
                                <h2>Address</h2>
                                <p>Inform companies about your current address.</p>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <select name="region" id="region-select"></select>
                                </div>
                                <div class="input-div">
                                    <select name="province" id="province-select">
                                    </select>

                                </div>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <select name="city" id="city-select">
                                    </select>
                                </div>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <select name="barangay" id="barangay-select">
                                    </select>
                                </div>

                            </div>
                            <div class="buttons button_space">
                                <button class="back_button">Back</button>
                                <button class="next_button">Next Step</button>
                            </div>
                        </div>

                        <div class="main">
                            <small><i class="fa fa-smile-o"></i></small>
                            <div class="text">
                                <h2>Account Information</h2>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <input type="email" name="email" required require>
                                    <span>Email: *</span>
                                </div>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <input type="password" class="form-control" name="password" id="password" required>
                                    <span>Password: *</span>

                                </div>
                                <div class="input-div">
                                    <input type="password" class="form-control" name="confirm_pass"
                                        id="confirm-password" required>
                                    <span>Confirm Password: *</span>

                                </div>
                            </div>

                            <div class="buttons button_space">
                                <button class="back_button">Back</button>
                                <button class="submit_button">Submit</button>
                            </div>
                        </div>




                        <div class="main">
                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                            </svg>

                            <div class="text congrats">
                                <h2>Thank You Mr./Mrs. <span class="shown_name"></span> for Registering!</h2>
                                <p style="color: #7a0014">We've sent an activation link to your email. Please check
                                    your inbox to complete the
                                    registration process.</p>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>


<script>
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

    function populateSelect(selectElement, data, key) {
        selectElement.innerHTML = `<option value="">Select ${selectElement.id.split('-')[0]}</option>`;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item[key];
            option.textContent = item[key];
            selectElement.appendChild(option);
        });
    }
});
</script>





<script>
$(document).ready(function() {
    var next_click = document.querySelectorAll(".next_button");
    var main_form = document.querySelectorAll(".main");
    var step_list = document.querySelectorAll(".progress-bar li");
    var num = document.querySelector(".step-number");
    let formnumber = 0;

    next_click.forEach(function(next_click_form) {
        next_click_form.addEventListener('click', function() {
            if (!validateform()) {
                return false
            }
            formnumber++;
            updateform();
            progress_forward();
            contentchange();
        });
    });

    var back_click = document.querySelectorAll(".back_button");
    back_click.forEach(function(back_click_form) {
        back_click_form.addEventListener('click', function() {
            formnumber--;
            updateform();
            progress_backward();
            contentchange();
        });
    });

    var username = document.querySelector("#user_name");
    var shownname = document.querySelector(".shown_name");


    var submit_click = document.querySelectorAll(".submit_button");
    submit_click.forEach(function(submit_click_form) {
        submit_click_form.addEventListener('click', function(e) { // Added 'e' here
            e.preventDefault();
            // Set the form action to the desired URL
            $('#regForm').attr('action',
                'function/registration.action.php'); // Corrected form ID
            // Show the loading overlay
            // $('#loadingOverlay').show();
            // Submit the form asynchronously using AJAX
            $.ajax({
                type: "POST",
                url: $('#regForm').attr('action'), // Corrected form ID
                data: $('#regForm').serialize(), // Corrected form ID
                success: function(response) {
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Registration Completed!',
                        });
                        formnumber++; // Ensure this variable is defined elsewhere
                        shownname.innerHTML = username
                            .value; // Ensure 'username' is defined

                        updateform(); // Ensure this function is defined
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
        });
    });


    var heart = document.querySelector(".fa-heart");
    heart.addEventListener('click', function() {
        heart.classList.toggle('heart');
    });


    var share = document.querySelector(".fa-share-alt");
    share.addEventListener('click', function() {
        share.classList.toggle('share');
    });



    function updateform() {
        main_form.forEach(function(mainform_number) {
            mainform_number.classList.remove('active');
        })
        main_form[formnumber].classList.add('active');
    }

    function progress_forward() {
        // step_list.forEach(list => {

        //     list.classList.remove('active');

        // }); 


        num.innerHTML = formnumber + 1;
        step_list[formnumber].classList.add('active');
    }

    function progress_backward() {
        var form_num = formnumber + 1;
        step_list[form_num].classList.remove('active');
        num.innerHTML = form_num;
    }

    var step_num_content = document.querySelectorAll(".step-number-content");

    function contentchange() {
        step_num_content.forEach(function(content) {
            content.classList.remove('active');
            content.classList.add('d-none');
        });
        step_num_content[formnumber].classList.add('active');
    }


    function validateform() {
        validate = true;
        var validate_inputs = document.querySelectorAll(".main.active input");
        validate_inputs.forEach(function(vaildate_input) {
            vaildate_input.classList.remove('warning');
            if (vaildate_input.hasAttribute('require')) {
                if (vaildate_input.value.length == 0) {
                    validate = false;
                    vaildate_input.classList.add('warning');
                }
            }
        });
        return validate;

    }
});
</script>