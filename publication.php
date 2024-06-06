<?php include('include/header.php'); 

// Fetch data from the repo_ebooks table
$query = "SELECT book_id, book_title, author, year_published, cover_page FROM repo_ebooks";
$result = mysqli_query($con, $query);

$publications = [];
while ($row = mysqli_fetch_assoc($result)) {
    $publications[] = $row;
}

// Convert PHP array to JSON
$publications_json = json_encode($publications);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<style>
.card {
    margin-bottom: 20px;
}

.card img {
    height: 200px;
    object-fit: cover;
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
}

.card-text {
    font-size: 0.95rem;
}

.card-footer {
    background-color: #f8f9fa;
}

.view-count,
.author {
    font-size: 0.85rem;
}
</style>

<body>
    <?php include('include/navbar.php'); ?>
    <section class="heading-page header-text" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>CONTACT US</h2>
                    <h6>If you have any questions or concerns, please feel free to reach out to us.</h6>

                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <h2 class="mb-4">Publications</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="search" class="form-control" placeholder="Search for publications...">
            </div>
            <div class="col-md-3">
                <select id="filterCategory" class="form-control">
                    <option value="">Filter by Category</option>
                    <option value="ebook">eBook</option>
                    <option value="journal">Journal</option>
                </select>
            </div>
        </div>

        <div class="row" id="publications-list">
            <!-- Cards will be populated here by JavaScript -->
        </div>
    </div>

    <?php include('include/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Get publications data from PHP
        const publications = <?php echo $publications_json; ?>;

        function displayPublications(publications) {
            $('#publications-list').empty();
            publications.forEach(pub => {
                $('#publications-list').append(`
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img class="card-img-top" src="admin/images/ebook_cover/${pub.cover_page}" alt="${pub.book_title}">
                            <div class="card-body">
                                <h5 class="card-title">${pub.book_title}</h5>
                                <p class="card-text">Year Published: ${pub.year_published}</p>
                            </div>
                            <div class="card-footer">
                                <p class="author">Author: ${pub.author}</p>
                                <p class="view-count"><i class="fa fa-eye"></i> Views</p>
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        // Initial display of publications
        displayPublications(publications);

        // Search functionality
        $('#search').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            const filteredPublications = publications.filter(pub => pub.book_title.toLowerCase()
                .includes(searchTerm));
            displayPublications(filteredPublications);
        });

        // Filter functionality
        $('#filterCategory').on('change', function() {
            const filterCategory = $(this).val();
            const filteredPublications = filterCategory ? publications.filter(pub => pub.category ===
                filterCategory) : publications;
            displayPublications(filteredPublications);
        });
    });
    </script>
</body>

</html>