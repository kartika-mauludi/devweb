<div class="modal fade" id="methodEditModalPrice" tabindex="-1" aria-labelledby="methodEditModalLabel" aria-hidden="true"
    style="z-index: 1055;">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-bottom-0 bg-light rounded-top-4 px-4 py-3">
                <h5 class="modal-title fw-bold text-secondary" id="methodEditModalLabel">Edit Package</h5>
            </div>

            <div class="modal-body px-4 py-4">
                <form action="{{ route('content.updatep') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_p_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Card Number</label>
                        <select name="card_number" id="edit_p_card_number"
                            class="form-select form-select-lg fs-6 border-secondary-subtle rounded-3">
                            <option value="" disabled>Select card ...</option>
                            <option value="1">Card 1</option>
                            <option value="2">Card 2</option>
                            <option value="3">Card 3</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Title</label>
                        <input type="text" name="title" id="edit_p_title"
                            class="form-control form-control-lg fs-6 border-secondary-subtle rounded-3"
                            placeholder="Edit package title ...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Price</label>
                        <input type="number" step="any" name="price" id="edit_p_price" min="0"
                            class="form-control form-control-lg fs-6 border-secondary-subtle rounded-3"
                            placeholder="e.g., 150000">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Description</label>
                        <textarea name="description" id="edit_p_description" rows="2" 
                            class="form-control fs-6 border-secondary-subtle rounded-3"
                            style="resize: none;" placeholder="Description of the package ..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Feature</label>
                        <textarea name="feature" id="edit_p_feature" rows="3" 
                            class="form-control fs-6 border-secondary-subtle rounded-3"
                            style="resize: none;" placeholder="Features (e.g., Feature A, Feature B) ..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small">Status</label>
                        <select name="status" id="edit_p_status"
                            class="form-select form-select-lg fs-6 border-secondary-subtle rounded-3">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top border-light-subtle">
                        <button type="button" class="btn btn-light border px-4 py-2 rounded-3 text-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-3 shadow-sm bg-gradient">
                            Update
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>