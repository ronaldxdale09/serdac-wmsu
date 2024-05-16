<?php include('include/header.php'); ?>

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
        // Dummy data for publications
        const publications = [{
                id: 1,
                title: 'eBook 1',
                category: 'ebook',
                thumbnail: 'https://via.placeholder.com/150',
                author: 'Author 1',
                views: 123,
                description: 'Description for eBook 1'
            },
            {
                id: 2,
                title: 'Journal 1',
                category: 'journal',
                thumbnail: 'https://via.placeholder.com/150',
                author: 'Author 2',
                views: 234,
                description: 'Description for Journal 1'
            },
            {
                id: 3,
                title: 'eBook 2',
                category: 'ebook',
                thumbnail: 'https://via.placeholder.com/150',
                author: 'Author 3',
                views: 345,
                description: 'Description for eBook 2'
            },
            {
                id: 4,
                title: 'Journal 2',
                category: 'journal',
                thumbnail: 'https://via.placeholder.com/150',
                author: 'Author 4',
                views: 456,
                description: 'Description for Journal 2'
            },
            {
                id: 5,
                title: 'eBook 3',
                category: 'ebook',
                thumbnail: 'https://via.placeholder.com/150',
                author: 'Author 5',
                views: 567,
                description: 'Description for eBook 3'
            }
        ];

        function displayPublications(publications) {
            $('#publications-list').empty();
            publications.forEach(pub => {
                $('#publications-list').append(`
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="${pub.thumbnail}" alt="${pub.title}">
                            <div class="card-body">
                                <h5 class="card-title">${pub.title}</h5>
                                <p class="card-text">${pub.description}</p>
                            </div>
                            <div class="card-footer">
                                <p class="author">Author: ${pub.author}</p>
                                <p class="view-count"><i class="fa fa-eye"></i> ${pub.views} views</p>
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
            const filteredPublications = publications.filter(pub => pub.title.toLowerCase().includes(
                searchTerm));
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