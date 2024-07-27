<form action="{{ route('categories.categoryStore') }}" method="POST">
    @method('POST')
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="category_name" class="form-label">Category</label>
                    <input autofocus name="category_name" type="text" id="category_name" class="form-control"
                        placeholder="Enter Name" />
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="used_for" class="form-label">USED FOR</label>
                    <p class="text-muted m-0">(Description)</p>
                    <textarea name="used_for" id="used_for" cols="10" rows="5" class="form-control"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" class="btn btn-primary">Save Category</button>
        </div>
    </div>
</form>
