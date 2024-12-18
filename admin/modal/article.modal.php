<!-- Edit Article Modal -->
<div class="modal fade" id="editArticleModal" tabindex="-1" role="dialog" aria-labelledby="editArticleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editArticleModalLabel">
                    <i class="fas fa-edit"></i> Edit Article
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editArticleForm" action="function/articles_update.php" method='POST'
                    enctype="multipart/form-data">
                    <input type="hidden" id="edit_article_id" name="article_id">

                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="edit_title" class="form-label required">Title</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="edit_author" class="form-label required">Author</label>
                                <input type="text" class="form-control" id="edit_author" name="author" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="edit_subtitle" class="form-label required">Subtitle</label>
                                <input type="text" class="form-control" id="edit_subtitle" name="subtitle" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_type" class="form-label">Type</label>
                                <select class="form-select" id="edit_type" name="type">
                                    <option value="Announcement">Announcement</option>
                                    <option value="Meeting">Meeting</option>
                                    <option value="Article">Article</option>
                                    <option value="Event">Event</option>
                                    <option value="News">News</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_image" class="form-label required">Featured Image</label>
                        <div class="image-upload-container">
                            <div class="custom-file-upload">
                                <input type="file" class="custom-file-input" id="edit_image" name="image"
                                    accept="image/*">
                                <label class="custom-file-label" for="edit_image">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choose file</span>
                                </label>
                            </div>
                            <div class="selected-file" id="selected-file-name">No file chosen</div>
                        </div>
                        <div class="image-preview-container">
                            <img id="edit_image_preview" src="" alt="Current Image">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_content" class="form-label required">Content</label>
                        <textarea class="form-control" id="edit_content" name="content" rows="8"></textarea>
                    </div>

                    <div class="modal-footer border-0 px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" name='updateArticle' class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Delete Article Modal -->
<div class="modal fade" id="deleteArticleModal" tabindex="-1" role="dialog" aria-labelledby="deleteArticleModalLabel"
    aria-hidden="true">
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