<style>
.content-card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.content-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.banner-preview {
    max-width: 50%;
    /* Adjust as needed */
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    overflow: hidden;
}

.banner-preview img {
    max-width: 40%;
    max-height: 40%;
    object-fit: contain;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.custom-file-label::after {
    content: "Browse";
}
</style>

<?php

// Fetch the web details
$query = "SELECT * FROM web_details LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $webDetails = mysqli_fetch_assoc($result);
} else {
    // If no data found, initialize with empty strings
    $webDetails = [
        'about_us' => '',
        'mission' => '',
        'vision' => '',
        'goals' => '',
        'banner_image' => '' 
    ];
}

// Don't forget to free the result
mysqli_free_result($result);
?>
<form id="contentUpdateForm" method="post" action="update_web_details.php">


    <div class="container-fluid py-4">
        <h2 class="mb-4">Website Content Management</h2>
        <form id="contentUpdateForm" method="post" action="update_web_details.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card content-card">
                        <div class="card-body">
                            <h5 class="card-title">Banner Image</h5>
                            <?php if (!empty($webDetails['banner_image'])): ?>
                            <div class=" mb-3">
                                <img src="../assets/images/<?php echo htmlspecialchars($webDetails['banner_image']); ?>"
                                    alt="Current Banner" id="bannerPreview" class="img-fluid">
                            </div>
                            <?php endif; ?>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="bannerImage" name="banner_image"
                                    accept="image/*">
                                <label class="custom-file-label" for="bannerImage">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card content-card">
                        <div class="card-body">
                            <h5 class="card-title">About Us</h5>
                            <div class="form-group">
                                <textarea class="form-control" id="aboutUs" name="about_us" rows="5"
                                    placeholder="Enter About Us content"><?php echo htmlspecialchars($webDetails['about_us']); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card content-card">
                        <div class="card-body">
                            <h5 class="card-title">Mission</h5>
                            <div class="form-group">
                                <textarea class="form-control" id="mission" name="mission" rows="4"
                                    placeholder="Enter Mission statement"><?php echo htmlspecialchars($webDetails['mission']); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card content-card">
                        <div class="card-body">
                            <h5 class="card-title">Vision</h5>
                            <div class="form-group">
                                <textarea class="form-control" id="vision" name="vision" rows="4"
                                    placeholder="Enter Vision statement"><?php echo htmlspecialchars($webDetails['vision']); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card content-card">
                        <div class="card-body">
                            <h5 class="card-title">Goals</h5>
                            <div class="form-group">
                                <textarea class="form-control" id="goals" name="goals" rows="4"
                                    placeholder="Enter Goals"><?php echo htmlspecialchars($webDetails['goals']); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-lg">Update Content</button>
                </div>
            </div>
        </form>
    </div>
    <script>
    $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);

            // Preview the new image
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#bannerPreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    })

    document.getElementById('contentUpdateForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait while we update the content.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Get form data
        const formData = new FormData(this);

        // Send AJAX request
        fetch('function/update_web_details.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'The content has been updated successfully.',
                        confirmButtonColor: '#3085d6'
                    });
                } else {
                    throw new Error(data.message || 'Unknown error occurred');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.message || 'Something went wrong!',
                    confirmButtonColor: '#d33'
                });
            });
    });
    </script>