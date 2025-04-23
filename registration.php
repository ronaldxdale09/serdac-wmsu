<!DOCTYPE html>
<html>

<head>
    <title>SERDAC-WMSU - Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="icon" type="image/x-icon" href="assets/images/serdac.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
    margin-top: 10px;
    font-size: 0.8em;
}

.requirement {
    margin: 2px 0;
}

.requirement::before {
    content: '• ';
}

.requirement.met {
    color: #32a852;
}

.requirement.met::before {
    content: '✓ ';
}

.password-requirements-label {
    display: block;
    font-size: 0.85em;
    color: #666;
    margin-bottom: 5px;
}
</style>

<?php 
include('function/db.php'); 
function getOptions($table, $valueColumn, $textColumn) {
    global $con;
    $options = "";
    $sql = "SELECT $valueColumn, $textColumn FROM $table ORDER BY id DESC";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $options .= "<option value='" . htmlspecialchars($row[$valueColumn]) . "'>" . htmlspecialchars($row[$textColumn]) . "</option>";
        }
    }
    return $options;
}

$genderOptions = getOptions("r_genders", "gender", "gender");
$occupationOptions = getOptions("r_occupations", "occupation", "occupation");
$educationOptions = getOptions("r_education_levels", "education_level", "education_level");

$con->close();
?>

<body>
    <div class="container">
        <div class="card">
            <div class="form">
                <div class="left-side">
                    <div class="left-heading">
                        <h3>Create Your Account</h3>
                        <p>Join SERDAC-WMSU community</p>
                    </div>
                    <div class="steps-content">
                        <h3>Step <span class="step-number">1</span></h3>
                        <p class="step-number-content active">Review and accept our data privacy agreement.</p>
                        <p class="step-number-content d-none">Fill in your personal information.</p>
                        <p class="step-number-content d-none">Provide your current address details.</p>
                        <p class="step-number-content d-none">Set up your account credentials.</p>
                    </div>
                    <ul class="progress-bar">
                        <li class="active">Data Privacy</li>
                        <li>Personal Info</li>
                        <li>Address</li>
                        <li>Account</li>
                    </ul>
                </div>

                <div class="right-side">
                    <form id="regForm" action="" method="post">
                        <!-- Step 1: Data Privacy -->
                        <div class="main active">
                            <small>
                                <img src="assets/images/serdac.png" alt="SERDAC Logo" />
                            </small>
                            <div class="text">
                                <h2>Data Privacy Agreement</h2>
                                <p>Please review our data privacy policy before proceeding.</p>
                            </div>
                            <div class="data-privacy">
                                <p>All information will remain secured and confidential within the organization and only authorized personnel shall have access to them. This is guided and in compliance with the Data Privacy Act of 2012. The act includes the right to object to the processing of your data, the right to access your data, the right to correct any inaccurate data, and the right to erasure or blocking of data.</p>
                                <div class="checkbox">
                                    <input type="checkbox" id="agree" name="agree">
                                    <label for="agree">By clicking I Agree and proceeding with this online registration, you are giving us consent to collect your data.</label>
                                </div>
                            </div>
                            <div class="buttons">
                                <button class="next_button" id="agreeButton">I Agree</button>
                            </div>
                        </div>

                        <!-- Step 2: Personal Information -->
                        <div class="main">
                            <small>
                                <img src="assets/images/serdac.png" alt="SERDAC Logo" />
                            </small>
                            <div class="text">
                                <h2>Personal Information</h2>
                                <p>Tell us about yourself</p>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <label for="fname">First Name</label>
                                    <input type="text" id="fname" name="fname" required>
                                </div>
                                <div class="input-div">
                                    <label for="midname">Middle Name</label>
                                    <input type="text" id="midname" name="midname">
                                </div>
                                <div class="input-div">
                                    <label for="lname">Last Name</label>
                                    <input type="text" id="lname" name="lname" required>
                                </div>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <label for="contact_no">Phone Number</label>
                                    <input type="text" id="contact_no" name="contact_no" required>
                                </div>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <label for="sex-select">Sex</label>
                                    <select id="sex-select" name="sex" required>
                                        <option value="" selected disabled>Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="input-div">
                                    <label for="gender-select">Gender Identity</label>
                                    <select name="gender" id="gender-select" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <?php echo $genderOptions; ?>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="input-div" id="custom-gender-div" style="display: none;">
                                    <label for="custom-gender">Specify Gender</label>
                                    <input type="text" id="custom-gender" name="custom_gender" placeholder="Enter your gender">
                                </div>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <label for="occupation-select">Occupation</label>
                                    <select id="occupation-select" name="occupation" required>
                                        <option value="" selected disabled>Select Occupation</option>
                                        <?php echo $occupationOptions; ?>
                                    </select>
                                </div>
                                <div class="input-div">
                                    <label for="education-level-select">Educational Level</label>
                                    <select id="education-level-select" name="education_level" required>
                                        <option value="" selected disabled>Select Educational Level</option>
                                        <?php echo $educationOptions; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="buttons">
                                <button class="back_button">Back</button>
                                <button class="next_button">Next Step</button>
                            </div>
                        </div>

                        <!-- Step 3: Address -->
                        <div class="main">
                            <small>
                                <img src="assets/images/serdac.png" alt="SERDAC Logo" />
                            </small>
                            <div class="text">
                                <h2>Address Information</h2>
                                <p>Provide your current address details</p>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <label for="region-select">Region</label>
                                    <select name="region" id="region-select" required></select>
                                </div>
                                <div class="input-div">
                                    <label for="province-select">Province</label>
                                    <select name="province" id="province-select" required></select>
                                </div>
                            </div>
                            <div class="input-text">
                                <div class="input-div">
                                    <label for="city-select">City/Municipality</label>
                                    <select name="city" id="city-select" required></select>
                                </div>
                                <div class="input-div">
                                    <label for="barangay-select">Barangay</label>
                                    <select name="barangay" id="barangay-select" required></select>
                                </div>
                            </div>

                            <div class="buttons">
                                <button class="back_button">Back</button>
                                <button class="next_button">Next Step</button>
                            </div>
                        </div>

                        <!-- Step 4: Account Information -->
                        <div class="main">
                            <small>
                                <img src="assets/images/serdac.png" alt="SERDAC Logo" />
                            </small>
                            <div class="text">
                                <h2>Account Information</h2>
                                <p>Set up your login credentials</p>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="input-text">
                                <div class="input-div">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" required>
                                    <div class="password-requirements">
                                        <p id="length-check" class="requirement">At least 6 characters</p>
                                        <p id="number-check" class="requirement">Contains a number</p>
                                        <p id="symbol-check" class="requirement">Contains a symbol</p>
                                    </div>
                                </div>
                                <div class="input-div">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input type="password" id="confirm-password" name="confirm_pass" required>
                                    <div class="password-requirements">
                                        <p id="password-match" class="requirement">Passwords match</p>
                                    </div>
                                </div>
                            </div>

                            <div class="buttons">
                                <button class="back_button">Back</button>
                                <button class="submit_button">Create Account</button>
                            </div>
                        </div>

                        <!-- Success Step -->
                        <div class="main">
                            <div class="success-animation">
                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                                </svg>
                            </div>
                            <div class="text congrats">
                                <h2>Welcome to SERDAC-WMSU!</h2>
                                <p>We've sent an activation link to your email. Please check your inbox to complete the registration process.</p>
                                <div class="buttons">
                                    <button type="button" onclick="window.location.href='login.php'" class="next_button">Go to Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Keep your existing JavaScript code -->
</body>

</html>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>


<script>
document.getElementById('contact_no').addEventListener('input', function(e) {
    // Remove non-digit characters
    let input = this.value.replace(/\D/g, '');


    // Limit to 11 digits
    input = input.slice(0, 11);

    // Format the number as 09XX-XXX-XXXX
    if (input.length > 4) {
        input = input.slice(0, 4) + '-' + input.slice(4);
    }
    if (input.length > 8) {
        input = input.slice(0, 8) + '-' + input.slice(8);
    }

    this.value = input;
});

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
            const romanOrder = {
                'I': 1,
                'II': 2,
                'III': 3,
                'IV': 4,
                'V': 5,
                'VI': 6,
                'VII': 7,
                'VIII': 8,
                'IX': 9,
                'X': 10,
                'XI': 11,
                'XII': 12,
                'XIII': 13
            };

            regions = data.sort((a, b) => {
                const aName = a.region_name,
                    bName = b.region_name;
                const aFirstLetter = aName[0],
                    bFirstLetter = bName[0];
                // First, sort by the first letter
                if (aFirstLetter !== bFirstLetter) {
                    return aFirstLetter.localeCompare(bFirstLetter);
                }
                // If first letters are the same, sort regions with Roman numerals
                const aMatch = a.region_code.match(/Region\s+(\w+)/);
                const bMatch = b.region_code.match(/Region\s+(\w+)/);
                if (aMatch && bMatch) {
                    return (romanOrder[aMatch[1]] || 0) - (romanOrder[bMatch[1]] || 0);
                }

                // For non-Roman numeral regions, maintain their relative order
                return data.indexOf(a) - data.indexOf(b);
            });

            populateRegion(regionSelect, regions, 'region_name');
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




    function populateRegion(selectElement, data, key) {
        const type = selectElement.id.split('-')[0];
        selectElement.innerHTML =
            `<option value="">Select ${type.charAt(0).toUpperCase() + type.slice(1)}</option>`;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item[key];
            option.textContent = item[key];
            selectElement.appendChild(option);
        });
    }

    function populateSelect(selectElement, data, key) {
        const type = selectElement.id.split('-')[0];
        data.sort((a, b) => a[key].localeCompare(b[key]));
        selectElement.innerHTML =
            `<option value="">Select ${type.charAt(0).toUpperCase() + type.slice(1)}</option>`;
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
    const passwordRequirements = document.querySelector('.password-requirements');
    const confirmPasswordRequirements = document.querySelector(
        '.input-div:nth-child(2) .password-requirements');

    // Global variables
    let currentStep = 0;
    const symbolRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

    // Utility functions
    const isValidEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

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

    function validatePassword() {
        const password = passwordInput.value;
        let isValid = true;
        let unmetRequirements = [];

        if (password.length < 6) {
            isValid = false;
            unmetRequirements.push('At least 6 characters');
        }
        if (!/\d/.test(password)) {
            isValid = false;
            unmetRequirements.push('Contains a number');
        }
        if (!symbolRegex.test(password)) {
            isValid = false;
            unmetRequirements.push('Contains a symbol');
        }
        if (password !== confirmPasswordInput.value) {
            isValid = false;
            unmetRequirements.push('Passwords match');
        }

        return {
            isValid,
            unmetRequirements
        };
    }



    function showUnmetRequirements(unmetRequirements) {
        passwordRequirements.style.display = 'block';
        confirmPasswordRequirements.style.display = 'block';

        document.querySelectorAll('.requirement').forEach(req => {
            const requirementText = req.textContent.trim();
            if (unmetRequirements.includes(requirementText)) {
                req.style.display = 'block';
                req.classList.remove('met');
            } else {
                req.style.display = 'none';
            }
        });
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

            const { isValid, unmetRequirements } = validatePassword();
            if (!isValid) {
                passwordInput.classList.add('warning');
                confirmPasswordInput.classList.add('warning');
                showUnmetRequirements(unmetRequirements);
                showAlert('warning', 'Invalid Password', 'Please check the password requirements.');
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
                return response.json(); // Expecting a JSON response from the server
            })
            .then(response => {
                Swal.close();
                if (response.status === 'success') {
                    showAlert('success', 'Success', 'Registration Completed!');
                    currentStep++;
                    updateFormVisibility();
                    const shownname = document.querySelector(".shown_name");
                    const username = document.getElementById('user_name');
                    if (shownname && username) shownname.textContent = username.value;
                } else {
                    showAlert('info', 'Registration Failed', response.message);
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