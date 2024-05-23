
<!-- Modal -->
<div class="modal fade" id="serviceRequestModal" tabindex="-1" role="dialog" aria-labelledby="serviceRequestModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceRequestModalLabel">New Service Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reqForm" action="function/admin.request.action.php" method="post">
                    <div class="form-card">
                        <h5 class="sub-heading">Select Service</h5>
                        <input type="text" id="selected-service" name="service_type" value="data-analysis" hidden>
                        <div class="row px-1 radio-group" style="display: flex; justify-content: center;">
                            <div class="card-block text-center radio selected" style="flex: 1; margin: 5px;"
                                data-option="data-analysis">
                                <div class="image-icon">
                                    <img class="icon icon1" src="../assets/images/predictive-chart.png">
                                </div>
                                <p class="sub-desc">DATA ANALYSIS</p>
                            </div>
                            <div class="card-block text-center radio" style="flex: 1; margin: 5px;"
                                data-option="capability-training">
                                <div class="image-icon">
                                    <img class="icon icon1" src="../assets/images/analysis.png">
                                </div>
                                <p class="sub-desc">CAPABILITY TRAINING</p>
                            </div>
                            <div class="card-block text-center radio" style="flex: 1; margin: 5px;"
                                data-option="technical-assistance">
                                <div class="image-icon">
                                    <img class="icon icon1 fit-image" src="https://i.imgur.com/ynKYPkk.png">
                                </div>
                                <p class="sub-desc">TECHNICAL ASSISTANCE</p>
                            </div>
                        </div>
                        <br>
                        <div id="service-content"></div>
                        <button type="submit"  class="btn btn-sm btn-success submit">Submit<span
                                class="fa fa-long-arrow-right"></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    function loadServiceContent(serviceType) {
        $.ajax({
            url: `field_request/field.${serviceType}.php`,
            type: 'GET',
            success: function(response) {
                $('#service-content').html(response);
            },
            error: function() {
                $('#service-content').html('<p>Error loading the service content.</p>');
            }
        });
    }

    // Initially load data analysis content
    loadServiceContent('data-analysis');

    $('.radio-group .radio').click(function() {
        $('.radio-group .radio').removeClass('selected');
        $(this).addClass('selected');
        const selectedService = $(this).data('option');
        $('#selected-service').val(selectedService);
        loadServiceContent(selectedService);
    });

    // $('.submit').click(function(event) {
    //     event.preventDefault();
    //     // Add your form submission logic here
    // });
});
</script>