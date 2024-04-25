<body>

    <?php include('include/navbar.php');?>
    <!-- ***** Header Area End ***** -->
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 15px;
        border: none;
    }

    .card-header {
        background-color: #ffffff;
        border-bottom: none;
        color: #333333;
        font-weight: 500;
        font-size: 1.5rem;
    }

    .form-label {
        font-weight: 500;
    }

    .btn-submit {
        background-color: #198754;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 10px;
    }

    .btn-submit:hover {
        background-color: #157347;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
    }

    .card-body {
        padding: 2rem;
    }
    </style>


    <section class="meetings-page" id="meetings">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container py-5">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="card shadow-sm">
                                            <div class="card-header text-center">
                                                Service Request Form
                                            </div>
                                            <div class="card-body">
                                                <p class="text-muted text-center">To ensure we understand your request
                                                    fully, kindly provide the requested information in the form below.
                                                    Your input is important for us to assist you effectively.</p>

                                                <form>
                                                    <div class="mb-3">
                                                        <label class="form-label">Personal Information</label>
                                                        <div class="row g-2">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    placeholder="First Name" value="Ronald">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Last Name" value="Fuentebella">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <input type="email" class="form-control" placeholder="Email"
                                                            value="ronaldxdale@gmail.com">
                                                    </div>

                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" placeholder="Contact"
                                                            value="09352232051">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Request Information</label>
                                                        <div class="row g-2">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control mb-3"
                                                                    placeholder="Office/Agency">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="form-select mb-3">
                                                                    <option selected>Type of Client</option>
                                                                    <option value="new">New</option>
                                                                    <option value="returning">Returning</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="form-select mb-3">
                                                                    <option selected>Request for</option>
                                                                    <option value="service">Service</option>
                                                                    <option value="information">Information</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="purposeTextarea" class="form-label">Purpose of
                                                            Request</label>
                                                        <textarea class="form-control" id="purposeTextarea" rows="4"
                                                            placeholder="Please describe the purpose of your request"></textarea>
                                                    </div>

                                                    <div class="text-center">
                                                        <button type="submit"
                                                            class="btn btn-submit w-100">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="main-button-red">
                                <a href="index.php">Back To Homepage</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('include/footer.php');?>

    </section>


    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
    //according to loftblog tut
    $('.nav li:first').addClass('active');

    var showSection = function showSection(section, isAnimate) {
        var
            direction = section.replace(/#/, ''),
            reqSection = $('.section').filter('[data-section="' + direction + '"]'),
            reqSectionPos = reqSection.offset().top - 0;

        if (isAnimate) {
            $('body, html').animate({
                    scrollTop: reqSectionPos
                },
                800);
        } else {
            $('body, html').scrollTop(reqSectionPos);
        }

    };

    var checkSection = function checkSection() {
        $('.section').each(function() {
            var
                $this = $(this),
                topEdge = $this.offset().top - 80,
                bottomEdge = topEdge + $this.height(),
                wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
                var
                    currentId = $this.data('section'),
                    reqLink = $('a').filter('[href*=\\#' + currentId + ']');
                reqLink.closest('li').addClass('active').
                siblings().removeClass('active');
            }
        });
    };

    $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function(e) {
        e.preventDefault();
        showSection($(this).attr('href'), true);
    });

    $(window).scroll(function() {
        checkSection();
    });
    </script>
</body>


</body>

</html>