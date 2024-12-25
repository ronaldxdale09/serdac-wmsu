<!-- Modal for Form Details -->
<style>
/* Modal Styles */
.modal-custom-header {
    color: white;
    padding: 1.5rem;
}

.modal-custom-body {
    background-color: #f8f9fa;
    padding: 1.5rem;
}

.stats-card {
    transition: all 0.3s ease;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.question-card {
    border-left: 4px solid #1a237e;
    margin-bottom: 1.5rem;
    background: white;
    padding: 1rem;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.response-distribution {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    margin-top: 1rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #1a237e;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
}

.progress-custom {
    height: 8px;
    border-radius: 4px;
}

.response-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: inline-block;
}

.modal-spinner {
    padding: 3rem;
    text-align: center;
}

.date-badge {
    background: #e3f2fd;
    color: #1565c0;
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-size: 0.9rem;
}

.type-badge {
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-weight: 500;
}
</style>

<div class="modal fade" id="formDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-custom-header text-light">
                <h5 class="modal-title "><i class="fas fa-clipboard-list me-2"></i>Assessment Details & Summary Report
                </h5>
            </div>
            <div class="modal-body modal-custom-body">
                <div id="modalLoadingSpinner" class="modal-spinner">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">Loading assessment details...</p>
                </div>

                <div id="modalContent">
                    <!-- Overview Section -->
                    <div class="card mb-4">
                        <div class="card-body" id="formBasicInfo">
                            <!-- Basic info will be loaded here -->
                        </div>
                    </div>

                    <!-- Statistics Section -->
                    <div class="row mb-4" id="statsSection">
                        <!-- Stats cards will be loaded here -->
                    </div>

                    <!-- Questions Section -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i>Questions and Responses</h6>
                            <span class="badge bg-primary" id="totalQuestions"></span>
                        </div>
                        <div class="card-body" id="questionsList">
                            <!-- Questions will be loaded here -->
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>


$(document).on('click', '.view-details', function() {
var formId = $(this).data('id');

// Clear previous content
$('#formBasicInfo, #questionsList, #responseAnalytics, #statsSection').empty();

// Show modal and loading spinner
$('#modalContent').hide();
$('#modalLoadingSpinner').show();
var formDetailsModal = new bootstrap.Modal(document.getElementById('formDetailsModal'));
formDetailsModal.show();

// Fetch form details
$.ajax({
url: 'fetch/modal_report_assessment_form.php',
method: 'GET',
data: { formId: formId },
dataType: 'json',
success: function(data) {
if (data.error) {
Swal.fire({
icon: 'error',
title: 'Error',
text: data.error
});
return;
}

// Populate Basic Info
$('#formBasicInfo').html(`
<h4 class="mb-3">${data.form.title}</h4>
<div class="alert alert-light">
    <p class="mb-2">${data.form.description || 'No description available'}</p>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="stats-card p-3">
            <span class="type-badge ${getTypeClass(data.form.form_type)}">${data.form.form_type}</span>
            <div class="mt-2">
                <small class="text-muted">Form Category:</small>
                <br>${data.form.is_quiz ? 'Quiz Assessment' : 'Regular Assessment'}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card p-3">
            <div class="date-badge mb-2">
                <i class="far fa-calendar-alt"></i> Date Range
            </div>
            <div>Start: ${formatDate(data.form.start_date)}</div>
            <div>End: ${formatDate(data.form.end_date)}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Response Rate</div>
                    <div class="stat-value">${data.stats.completion_rate.toFixed(1)}%</div>
                </div>
                <div class="text-end">
                    <small class="text-muted">Responses</small>
                    <div class="h5 mb-0">${data.stats.total_responses}/${data.form.quota}</div>
                </div>
            </div>
            <div class="progress progress-custom mt-2">
                <div class="progress-bar" role="progressbar"
                    style="width: ${Math.min(data.stats.completion_rate, 100)}%"></div>
            </div>
        </div>
    </div>
</div>
`);

// Populate Questions
let questionsHtml = '';
data.questions.forEach((question, index) => {
questionsHtml += `
<div class="question-card">
    <div class="d-flex justify-content-between">
        <h6 class="mb-3">Question ${index + 1}: ${question.question_text}</h6>
        <span class="badge bg-primary">${question.question_type.replace('_', ' ')}</span>
    </div>
    ${question.options ? `
    <div class="options-section mb-3">
        <strong>Options:</strong>
        <div class="mt-2">
            ${question.options.split(',').map(option =>
            `<span class="response-badge bg-light">${option.trim()}</span>`
            ).join(' ')}
        </div>
    </div>
    ` : ''}
    <div class="response-distribution">
        <h6 class="mb-3">Response Distribution</h6>
        <div class="row">
            ${question.response_distribution.map(dist => `
            <div class="col-md-6 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <span>${dist.response_text}</span>
                    <span class="badge bg-primary">${dist.count} responses</span>
                </div>
                <div class="progress progress-custom mt-1">
                    <div class="progress-bar" role="progressbar"
                        style="width: ${(dist.count / data.stats.total_responses * 100)}%"></div>
                </div>
            </div>
            `).join('')}
        </div>
    </div>
</div>
`;
});
$('#questionsList').html(questionsHtml);
$('#totalQuestions').text(`${data.questions.length} Questions`);

// Hide spinner and show content
$('#modalLoadingSpinner').hide();
$('#modalContent').show();
},
error: function(xhr, status, error) {
Swal.fire({
icon: 'error',
title: 'Error',
text: 'Failed to fetch form details. Please try again.'
});
$('#formDetailsModal').modal('hide');
}
});
});

// Helper functions
function getTypeClass(formType) {
const types = {
'Survey': 'bg-success text-white',
'Pre Assessment': 'bg-primary text-white',
'Post Assessment': 'bg-info text-white'
};
return types[formType] || 'bg-secondary text-white';
}

function formatDate(dateString) {
const options = { year: 'numeric', month: 'short', day: 'numeric' };
return new Date(dateString).toLocaleDateString(undefined, options);
}

// Reset modal on close
$('#formDetailsModal').on('hidden.bs.modal', function() {
$('#formBasicInfo, #questionsList, #responseAnalytics, #statsSection').empty();
$('#modalContent').hide();
$('#modalLoadingSpinner').show();
});



</script>