    <!-- Edit Article Modal -->
    <div class="modal fade" id="editArticleModal" tabindex="-1" role="dialog" aria-labelledby="editArticleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editArticleModalLabel">Edit Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editArticleForm" action="function/articles_update.php" method='POST'
                        enctype="multipart/form-data">
                        <input type="hidden" id="edit_article_id" name="article_id">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="edit_title" class="required">Title:</label>
                                    <input type="text" class="form-control" id="edit_title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="edit_author" class="required">Author:</label>
                                    <input type="text" class="form-control" id="edit_author" name="author" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_subtitle" class="required">Subtitle:</label>
                            <input type="text" class="form-control" id="edit_subtitle" name="subtitle">
                        </div>
                        <div class="form-group">
                            <label for="edit_image" class="required">Image:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="edit_image" name="image"
                                    accept="image/*">
                                <label class="custom-file-label" for="edit_image">Choose file</label>
                            </div>
                            <div style="text-align: center;">
                                <img id="edit_image_preview" src="" alt="Current Image"
                                    style="max-width: 50%; margin-top: 10px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_content">Content:</label>
                            <textarea class="form-control" id="edit_content" name="content" rows="8"></textarea>
                        </div>
                        <button type="submit" name='updateArticle' class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Article Modal -->
    <div class="modal fade" id="deleteArticleModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleModalLabel">Delete Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editArticleForm" action="function/articles_update.php" method='POST'>

                    <div class="modal-body">
                        <p>Are you sure you want to delete this article?</p>

                        <input type="hidden" id="delete_article_id" name="article_id">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="deleteArticle" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>