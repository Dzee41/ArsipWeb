<form action="{{ route('category-update.categoryUpdate') }}" method="POST">
    @method('POST')
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body body-jquery-edit">
            <div class="row">
                <input id="item-id" type="hidden" name="item_id" value="{{ $item->id }}">
                <div class="col mb-3">
                    <label for="category_name{{ $item->id }}" class="form-label">Category</label>
                    <input value="{{ $item->category_name }}" autofocus name="category_name" type="text"
                        id="category_name{{ $item->id }}" class="form-control" placeholder="Category" />
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="used_for{{ $item->id }}" class="form-label">USED
                        FOR</label>
                    <p class="text-muted m-0">(Description)</p>
                    <textarea name="used_for" id="used_for{{ $item->id }}" cols="10" rows="5" class="form-control">{{ $item->used_for }}</textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</form>
