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

<style>
/* Data privacy styles */
.data-privacy {
    font-family: 'Poppins', sans-serif;
    margin-top: 20px;
    font-size: 13px;
    color: #555;
}

.data-privacy p {
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 50px;
}

.data-privacy .checkbox {
    display: flex;
    align-items: center;
}

.data-privacy .checkbox input {
    margin-right: 10px;
}

.data-privacy .checkbox label {
    font-size: 13px;
}

.password-requirements {
    margin-top: 5px;
    font-size: 0.8em;
}

.requirement {
    color: #ff0000;
    margin: 2px 0;
}

.requirement::before {
    content: '✗ ';
}

.requirement.met {
    color: #00ff00;
}

.requirement.met::before {
    content: '✓ ';
}
</style>

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
                                <p class="step-number-content active">Please review and accept our data privacy
                                    agreement.</p>
                                <p class="step-number-content d-none">Enter your personal information to get closer to
                                    companies.</p>
                                <p class="step-number-content d-none">Inform companies about your current address.</p>
                                <p class="step-number-content d-none">Set up your account information.</p>
                            </div>
                            <ul class="progress-bar">
                                <li class="active">Data Privacy</li>
                                <li>Personal Information</li>
                                <li>Address</li>
                                <li>Account Info</li>
                            </ul>
                    </div>
                    <div class="right-side">

                        <div class="main active">
                            <small>
                                <img src="assets/images/serdac.png" style="width:50px" alt="School Logo 1"
                                    class="school-logo" />
                            </small>
                            <div class="text">
                                <h2>Data Privacy Agreement</h2>
                                <p>Please review our data privacy policy before proceeding.</p>
                            </div>
                            <div class="data-privacy">
                                <p>
                                    All information will remain secured and confidential within the organization and
                                    only authorized personnel shall have access to them. This is guided and in
                                    compliance with the Data Privacy
                                    Act of 2012. The act includes the right to object to the processing of your data,
                                    the right to access
                                    your data, the right to correct any inaccurate data, and the right to erasure or
                                    blocking of data.
                                </p>
                                <div class="checkbox">
                                    <input type="checkbox" id="agree" name="agree">
                                    <label for="agree">By clicking I Agree and proceeding with this online registration,
                                        you are
                                        giving us consent to collect your data.</label>
                                </div>
                            </div> <br>
                            <div class="buttons">


                                <button class="next_button" id="agreeButton">I Agree</button>

                            </div>
                        </div>


                        <div class="main ">
                            <small> <img src="assets/images/serdac.png" style="width:50px" alt="School Logo 1"
                                    class="school-logo" />
                            </small>
                            <div class="text">
                                <h2>Your Personal Information</h2>
                                <p>Enter your personal information to get closer to copanies.</p>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <input type="text" required id="user_name" name="fname">
                                    <span>First Name</span>
                                </div>
                                <div class="input-div">
                                    <input type="text" name="midname">
                                    <span>Middle Name</span>
                                </div>
                                <div class="input-div">
                                    <input type="text" required name="lname">
                                    <span>Last Name</span>
                                </div>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <input type="text" id="contact_no" name="contact_no" required maxlength="11"
                                        pattern="\d{11}" inputmode="numeric" title="Please enter exactly 11 digits"
                                        oninput="this.value = this.value.replace(/\D/g, '')">
                                    <span>Phone number</span>

                                </div>

                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <label for="sex-select">Sex*</label>
                                    <select id="sex-select" name="sex" required>
                                        <option value="" selected disabled>- Sex -</option>

                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>

                                    </select>

                                </div>
                                <div class="input-div">
                                    <label for="gender-select">Gender*</label>
                                    <select name="gender" id="gender-select" required>
                                        <option value="" selected disabled>- Gender -</option>
                                        <option value="Man">Man</option>
                                        <option value="Woman">Woman</option>
                                        <option value="Non-Binary">Non-Binary</option>
                                        <option value="Transgender">Transgender</option>
                                        <option value="Intersex">Intersex</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="input-div" id="custom-gender-div" style="display: none;">
                                    <label for="custom-gender">Specify Gender</label>
                                    <input type="text" id="custom-gender" name="custom_gender"
                                        placeholder="Enter your gender">
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
                                <button class="back_button">Back</button>
                                <button class="next_button">Next Step</button>
                            </div>
                        </div>
                        <div class="main ">
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

                        <div class="main ">
                            <div class="text">
                                <h2>Account Information</h2>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <input type="email" name="email" required>
                                    <span>Email: *</span>
                                </div>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <input type="password" class="form-control" name="password" id="password" required>
                                    <span>Password: *</span>
                                    <div class="password-requirements">
                                        <p id="length-check" class="requirement">At least 6 characters</p>
                                        <p id="number-check" class="requirement">Contains a number</p>
                                        <p id="symbol-check" class="requirement">Contains a symbol</p>
                                    </div>
                                </div>
                                <div class="input-div">
                                    <input type="password" class="form-control" name="confirm_pass"
                                        id="confirm-password" required>
                                    <span>Confirm Password: *</span>
                                    <p id="password-match" class="requirement">Passwords match</p>
                                </div>
                            </div>

                            <br>

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
                                <h2>Thank You <span class="shown_name"></span> for Registering!</h2>
                                <p style="color: #7a0014">We've sent an activation link to your email. Please check
                                    your inbox to complete the
                                    registration process.</p>

                                <div class="main-button-red">
                                    <a href="login.php">Return to login page</a>
                                </div>

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
    const barangaySelect = document.getElementById('barangay-select');
    const citySelect = document.getElementById('city-select');
    const provinceSelect = document.getElementById('province-select');
    const regionSelect = document.getElementById('region-select');

    let barangays = [];
    let cities = [];
    let provinces = [];
    let regions = [];

    // Load initial data
    fetch('js/ph-json/barangay.json')
        .then(response => response.json())
        .then(data => barangays = data)
        .catch(error => console.error('Error loading barangay data:', error));

    fetch('js/ph-json/city.json')
        .then(response => response.json())
        .then(data => cities = data)
        .catch(error => console.error('Error loading city data:', error));

    fetch('js/ph-json/province.json')
        .then(response => response.json())
        .then(data => provinces = data)
        .catch(error => console.error('Error loading province data:', error));

    fetch('js/ph-json/region.json')
        .then(response => response.json())
        .then(data => {
            regions = data;
            populateSelect(regionSelect, regions, 'region_name');
        })
        .catch(error => console.error('Error loading region data:', error));

    citySelect.addEventListener('change', function() {
        // Find the selected city's city_code
        const selectedCityCode = cities.find(city => city.city_name === this.value)?.city_code;

        // Filter the barangays based on the selected city_code
        const filteredBarangays = barangays.filter(barangay => barangay.city_code === selectedCityCode);
        populateSelect(barangaySelect, filteredBarangays, 'brgy_name');
    });

    provinceSelect.addEventListener('change', function() {
        // Find the selected province's province_code
        const selectedProvinceCode = provinces.find(province => province.province_name === this.value)
            ?.province_code;

        // Filter the cities based on the selected province_code
        const filteredCities = cities.filter(city => city.province_code === selectedProvinceCode);
        populateSelect(citySelect, filteredCities, 'city_name');
    });

    regionSelect.addEventListener('change', function() {
        const selectedRegionCode = regions.find(region => region.region_name === this.value)
            ?.region_code;
        const filteredProvinces = provinces.filter(province => province.region_code ===
            selectedRegionCode);
        populateSelect(provinceSelect, filteredProvinces, 'province_name');
        citySelect.innerHTML = '<option value="">Select City</option>'; // Reset city select
    });



    function populateSelect(selectElement, data, key) {
        selectElement.innerHTML = `<option value="">Select ${selectElement.id.split('-')[0]}</option>`;
        data.sort((a, b) => a[key].localeCompare(b[key])); // Sort alphabetically
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
document.addEventListener('DOMContentLoaded', function() {
    // DOM element references
    const form = document.getElementById('regForm');
    const nextButtons = document.querySelectorAll(".next_button");
    const backButtons = document.querySelectorAll(".back_button");
    const submitButton = document.querySelector(".submit_button");
    const mainForms = document.querySelectorAll(".main");
    const stepList = document.querySelectorAll(".progress-bar li");
    const stepNumber = document.querySelector(".step-number");
    const stepNumContent = document.querySelectorAll(".step-number-content");
    const agreeCheckbox = document.getElementById('agree');
    const agreeButton = document.getElementById('agreeButton');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const lengthCheck = document.getElementById('length-check');
    const numberCheck = document.getElementById('number-check');
    const symbolCheck = document.getElementById('symbol-check');
    const passwordMatch = document.getElementById('password-match');
    const genderSelect = document.getElementById('gender-select');
    const customGenderDiv = document.getElementById('custom-gender-div');
    const customGenderInput = document.getElementById('custom-gender');

    // Global variables
    let currentStep = 0;
    const symbolRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

    // Utility functions
    const isValidEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    const isValidPassword = (password) => password.length >= 6 && /\d/.test(password) && symbolRegex.test(
        password);

    function showAlert(icon, title, text) {
        return Swal.fire({
            icon,
            title,
            text,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    }

    // Password validation functions
    function updatePasswordRequirements() {
        const password = passwordInput.value;
        lengthCheck.classList.toggle('met', password.length >= 6);
        numberCheck.classList.toggle('met', /\d/.test(password));
        symbolCheck.classList.toggle('met', symbolRegex.test(password));
        checkPasswordMatch();
    }

    function checkPasswordMatch() {
        const isMatching = passwordInput.value === confirmPasswordInput.value && passwordInput.value !== '';
        passwordMatch.classList.toggle('met', isMatching);
        return isMatching;
    }

    // Form navigation functions
    function updateFormVisibility() {
        mainForms.forEach((form, index) => form.classList.toggle('active', index === currentStep));
    }

    function updateProgressBar() {
        stepNumber.textContent = currentStep + 1;
        stepList.forEach((step, index) => step.classList.toggle('active', index <= currentStep));
    }

    function updateStepContent() {
        stepNumContent.forEach((content, index) => {
            content.classList.toggle('active', index === currentStep);
            content.classList.toggle('d-none', index !== currentStep);
        });
    }

    // Updated Form validation function
    function validateForm() {
        const currentForm = mainForms[currentStep];
        const inputs = currentForm.querySelectorAll("input[required], select[required]");
        let isValid = true;

        inputs.forEach(input => {
            input.classList.remove('warning');
            if (input.value.trim() === '' || (input.tagName.toLowerCase() === 'select' && input
                    .value === '')) {
                isValid = false;
                input.classList.add('warning');
            }
        });

        if (!isValid) {
            showAlert('warning', 'Incomplete Form', 'Please fill in all required fields.');
            return false;
        }

        // Specific check for the Address step
        if (currentForm.querySelector('h2').textContent.trim().toLowerCase() === 'address') {
            const barangaySelect = document.getElementById('barangay-select');
            if (!barangaySelect || barangaySelect.value === '') {
                barangaySelect.classList.add('warning');
                showAlert('warning', 'Incomplete Address', 'Please select a barangay before proceeding.');
                return false;
            }
        }

        // Custom gender validation
        if (genderSelect && genderSelect.value === 'other') {
            if (!customGenderInput.value.trim()) {
                customGenderInput.classList.add('warning');
                showAlert('warning', 'Incomplete Information', 'Please specify your gender.');
                return false;
            }
        }

        // Account Information step validation
        if (currentForm.querySelector('h2').textContent.trim().toLowerCase() === 'account information') {
            const emailInput = currentForm.querySelector("input[type='email']");
            if (emailInput && !isValidEmail(emailInput.value)) {
                emailInput.classList.add('warning');
                showAlert('warning', 'Invalid Email', 'Please enter a valid email address.');
                return false;
            }

            if (!isValidPassword(passwordInput.value)) {
                passwordInput.classList.add('warning');
                showAlert('warning', 'Invalid Password',
                    'Password must be at least 6 characters long and contain at least one number and one symbol.'
                );
                return false;
            }

            if (!checkPasswordMatch()) {
                confirmPasswordInput.classList.add('warning');
                showAlert('warning', 'Password Mismatch', 'Passwords do not match.');
                return false;
            }
        }

        return true;
    }

    // Event listeners
    passwordInput.addEventListener('input', updatePasswordRequirements);
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);

    nextButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (validateForm()) {
                currentStep++;
                updateFormVisibility();
                updateProgressBar();
                updateStepContent();
            }
        });
    });

    backButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentStep--;
            updateFormVisibility();
            updateProgressBar();
            updateStepContent();
        });
    });

    submitButton.addEventListener('click', function(e) {
        e.preventDefault();
        if (!validateForm()) return;

        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we complete your registration.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const formData = new FormData(form);
        // Handle custom gender
        if (genderSelect.value === 'other') {
            formData.set('gender', customGenderInput.value.trim());
        }

        fetch('function/registration.action.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(response => {
                Swal.close();
                switch (response.trim()) {
                    case 'success':
                        showAlert('success', 'Success', 'Registration Completed!');
                        currentStep++;
                        updateFormVisibility();
                        const shownname = document.querySelector(".shown_name");
                        const username = document.getElementById('user_name');
                        if (shownname && username) shownname.textContent = username.value;
                        break;
                    case 'Email is already registered':
                        showAlert('info', 'Email Already Registered', response);
                        break;
                    default:
                        throw new Error(response);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                showAlert('error', 'Error', 'Form submission failed. Please try again.');
            });
    });

    agreeCheckbox.addEventListener('change', function() {
        agreeButton.disabled = !this.checked;
        agreeButton.style.backgroundColor = this.checked ? '' : '#ccc';
        agreeButton.style.cursor = this.checked ? 'pointer' : 'not-allowed';
    });

    agreeButton.addEventListener('click', function(e) {
        e.preventDefault();
        if (agreeCheckbox.checked) {
            currentStep = 1; // Set to 1 to move to Personal Information
            updateFormVisibility();
            updateProgressBar();
            updateStepContent();
        }
    });

    // New event listener for gender select
    if (genderSelect) {
        genderSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                customGenderDiv.style.display = 'block';
                customGenderInput.required = true;
            } else {
                customGenderDiv.style.display = 'none';
                customGenderInput.required = false;
                customGenderInput.value = ''; // Clear the custom input when not selected
            }
        });
    }

    // Initialize
    updatePasswordRequirements();
    agreeButton.disabled = true;
    agreeButton.style.backgroundColor = '#ccc';
    agreeButton.style.cursor = 'not-allowed';
});
</script>