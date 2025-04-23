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
        'banner_image' => '' ,
        'org_email' => '',
        'org_contact' => ''
    ];
}

// Don't forget to free the result
mysqli_free_result($result);
?>

<form class="content-form" method="post" action="function/content.update.php" enctype="multipart/form-data">
    <!-- Banner Image Section -->
    <div class="content-group">
        <label class="content-label">Banner Image</label>
        <p class="content-description">Upload a high-quality image for your website banner</p>
        <div class="editor-container">
            <input type="file" class="form-control" name="banner_image" accept="image/*">
            <?php if(isset($webDetails['banner_image']) && !empty($webDetails['banner_image'])): ?>
            <div class="content-image-preview">
                <img src="../assets/images/<?php echo htmlspecialchars($webDetails['banner_image']); ?>" alt="Current Banner">
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- About Us Section -->
    <div class="content-group">
        <label class="content-label">About Us</label>
        <p class="content-description">Describe your organization and its mission</p>
        <div class="editor-container">
            <div class="editor-toolbar">
                <button type="button" class="editor-tool" title="Bold"><i class="fas fa-bold"></i></button>
                <button type="button" class="editor-tool" title="Italic"><i class="fas fa-italic"></i></button>
                <button type="button" class="editor-tool" title="Link"><i class="fas fa-link"></i></button>
            </div>
            <textarea class="content-textarea" name="about_us" placeholder="Enter your about us content"><?php echo isset($webDetails['about_us']) ? htmlspecialchars($webDetails['about_us']) : ''; ?></textarea>
        </div>
        <div class="content-counter">0/1000 characters</div>
    </div>

    <!-- Mission Section -->
    <div class="content-group">
        <label class="content-label">Mission</label>
        <p class="content-description">State your organization's mission</p>
        <div class="editor-container">
            <div class="editor-toolbar">
                <button type="button" class="editor-tool" title="Bold"><i class="fas fa-bold"></i></button>
                <button type="button" class="editor-tool" title="Italic"><i class="fas fa-italic"></i></button>
                <button type="button" class="editor-tool" title="List"><i class="fas fa-list"></i></button>
            </div>
            <textarea class="content-textarea" name="mission" placeholder="Enter your mission statement"><?php echo isset($webDetails['mission']) ? htmlspecialchars($webDetails['mission']) : ''; ?></textarea>
        </div>
        <div class="content-counter">0/500 characters</div>
    </div>

    <!-- Vision Section -->
    <div class="content-group">
        <label class="content-label">Vision</label>
        <p class="content-description">Share your organization's vision for the future</p>
        <div class="editor-container">
            <div class="editor-toolbar">
                <button type="button" class="editor-tool" title="Bold"><i class="fas fa-bold"></i></button>
                <button type="button" class="editor-tool" title="Italic"><i class="fas fa-italic"></i></button>
                <button type="button" class="editor-tool" title="List"><i class="fas fa-list"></i></button>
            </div>
            <textarea class="content-textarea" name="vision" placeholder="Enter your vision statement"><?php echo isset($webDetails['vision']) ? htmlspecialchars($webDetails['vision']) : ''; ?></textarea>
        </div>
        <div class="content-counter">0/500 characters</div>
    </div>

    <!-- Goals Section -->
    <div class="content-group">
        <label class="content-label">Goals</label>
        <p class="content-description">List your organization's main objectives</p>
        <div class="editor-container">
            <div class="editor-toolbar">
                <button type="button" class="editor-tool" title="Bold"><i class="fas fa-bold"></i></button>
                <button type="button" class="editor-tool" title="Italic"><i class="fas fa-italic"></i></button>
                <button type="button" class="editor-tool" title="List"><i class="fas fa-list"></i></button>
            </div>
            <textarea class="content-textarea" name="goals" placeholder="Enter your organizational goals"><?php echo isset($webDetails['goals']) ? htmlspecialchars($webDetails['goals']) : ''; ?></textarea>
        </div>
        <div class="content-counter">0/1000 characters</div>
    </div>

    <!-- Contact Information Section -->
    <div class="content-group">
        <label class="content-label">Contact Information</label>
        <p class="content-description">Provide your contact details</p>
        
        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" value="<?php echo isset($webDetails['org_email']) ? htmlspecialchars($webDetails['org_email']) : ''; ?>" placeholder="Enter your email address">
        </div>
        
        <div class="form-group">
            <label class="form-label">Contact Number</label>
            <input type="tel" class="form-control" name="contact" value="<?php echo isset($webDetails['org_contact']) ? htmlspecialchars($webDetails['org_contact']) : ''; ?>" placeholder="Enter your contact number">
        </div>
    </div>

    <!-- Form Actions -->
    <div class="content-actions">
        <button type="button" class="btn btn-content btn-content-secondary">
            <i class="fas fa-undo"></i>
            Reset Changes
        </button>
        <button type="submit" name="update_content" class="btn btn-content btn-content-primary">
            <i class="fas fa-save"></i>
            Save Changes
        </button>
    </div>
</form>

<script>
$(document).ready(function() {
    // Character counter functionality
    $('.content-textarea').on('input', function() {
        const maxLength = $(this).attr('name') === 'about_us' || $(this).attr('name') === 'goals' ? 1000 : 500;
        const currentLength = $(this).val().length;
        $(this).closest('.content-group').find('.content-counter').text(`${currentLength}/${maxLength} characters`);
    });

    // Trigger initial character count
    $('.content-textarea').trigger('input');

    // Editor toolbar functionality
    $('.editor-tool').click(function() {
        const textarea = $(this).closest('.editor-container').find('textarea');
        const start = textarea.prop('selectionStart');
        const end = textarea.prop('selectionEnd');
        const text = textarea.val();
        let format = '';

        switch($(this).attr('title')) {
            case 'Bold':
                format = '**';
                break;
            case 'Italic':
                format = '_';
                break;
            case 'Link':
                format = '[](url)';
                break;
            case 'List':
                format = '\n- ';
                break;
        }

        if (format === '\n- ') {
            textarea.val(text.substring(0, start) + format + text.substring(end));
            textarea.prop('selectionStart', start + format.length);
            textarea.prop('selectionEnd', start + format.length);
        } else if (format === '[](url)') {
            const selectedText = text.substring(start, end);
            const replacement = `[${selectedText}](url)`;
            textarea.val(text.substring(0, start) + replacement + text.substring(end));
        } else {
            textarea.val(text.substring(0, start) + format + text.substring(start, end) + format + text.substring(end));
        }
        
        textarea.focus();
        textarea.trigger('input');
    });

    // Reset button functionality
    $('.btn-content-secondary').click(function() {
        if(confirm('Are you sure you want to reset all changes?')) {
            location.reload();
        }
    });
});
</script>