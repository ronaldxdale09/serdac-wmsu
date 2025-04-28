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

<link rel="stylesheet" href="css/publication.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<body>
    <?php include('include/navbar.php'); ?>
    <section class="publication-section">
        <div class="container">
            <h2 class="mb-4" style="color:#800000; font-weight:800; letter-spacing:1px;">E-Book Publications</h2>
            <div class="mb-3">
                <input type="text" id="publicationSearch" class="form-control" placeholder="Search e-books by title or author...">
            </div>
            <div class="alert alert-info mb-4" style="background:#f9ecec; color:#800000; border-left:5px solid #800000; font-size:1.04rem;">
                <strong>Note:</strong> For any book requests or if you wish to read a publication, please visit the <b>SERDAC Office</b> at Western Mindanao State University. Our staff will be happy to assist you with your research and reading needs.
            </div>
            <div class="publication-grid" id="publicationGrid">
                <!-- Cards will be rendered by JS -->
            </div>
            <nav aria-label="E-Book Pagination" class="mt-4">
                <ul class="pagination justify-content-center" id="publicationPagination"></ul>
            </nav>
        </div>
    </section>
    <!-- Modal for image popup -->
    <div class="publication-modal" id="publicationModal">
        <div class="publication-modal-content">
            <button class="publication-modal-close" id="publicationModalClose">&times;</button>
            <img src="" alt="E-Book Cover" class="publication-modal-img" id="publicationModalImg">
        </div>
    </div>
    <script>
    const publications = <?php echo $publications_json; ?>;
    const ITEMS_PER_PAGE = 8;
    let filtered = publications.slice();
    let currentPage = 1;

    function renderPublications() {
        const grid = document.getElementById('publicationGrid');
        grid.innerHTML = '';
        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const end = start + ITEMS_PER_PAGE;
        const pageItems = filtered.slice(start, end);
        if (pageItems.length === 0) {
            grid.innerHTML = '<p class="text-center w-100">No e-books found.</p>';
            return;
        }
        pageItems.forEach(pub => {
            const card = document.createElement('div');
            card.className = 'publication-card';
            card.innerHTML = `
                <img src="admin/images/ebook_cover/${pub.cover_page}" class="publication-img" alt="${pub.book_title} Cover" data-img="admin/images/ebook_cover/${pub.cover_page}">
                <div class="publication-body">
                    <div class="publication-title">${pub.book_title}</div>
                    <div class="publication-author"><i class="fas fa-user"></i> ${pub.author}</div>
                    <div class="publication-year"><i class="fas fa-calendar-alt"></i> ${pub.year_published}</div>
                </div>
            `;
            grid.appendChild(card);
        });
        // Re-bind modal logic for new images
        document.querySelectorAll('.publication-img').forEach(img => {
            img.addEventListener('click', function() {
                const modal = document.getElementById('publicationModal');
                const modalImg = document.getElementById('publicationModalImg');
                modal.classList.add('active');
                modalImg.src = this.getAttribute('data-img');
                modalImg.alt = this.alt;
            });
        });
    }
    function renderPagination() {
        const totalPages = Math.ceil(filtered.length / ITEMS_PER_PAGE);
        const pag = document.getElementById('publicationPagination');
        pag.innerHTML = '';
        if (totalPages <= 1) return;
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = 'page-item' + (i === currentPage ? ' active' : '');
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', function(e) {
                e.preventDefault();
                currentPage = i;
                renderPublications();
                renderPagination();
                window.scrollTo({top: document.getElementById('publicationGrid').offsetTop - 80, behavior: 'smooth'});
            });
            pag.appendChild(li);
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Modal popup logic
        const modal = document.getElementById('publicationModal');
        const modalImg = document.getElementById('publicationModalImg');
        const modalClose = document.getElementById('publicationModalClose');
        modalClose.addEventListener('click', function() {
            modal.classList.remove('active');
            modalImg.src = '';
        });
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                modalImg.src = '';
            }
        });
        // Search logic
        document.getElementById('publicationSearch').addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            filtered = publications.filter(pub =>
                pub.book_title.toLowerCase().includes(q) ||
                pub.author.toLowerCase().includes(q)
            );
            currentPage = 1;
            renderPublications();
            renderPagination();
        });
        renderPublications();
        renderPagination();
    });
    </script>
    <?php include('include/footer.php'); ?>
</body>
</html>