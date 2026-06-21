<div class="modal fade" id="methodAddModalPrice" tabindex="-1" aria-labelledby="methodAddModalLabel" aria-hidden="true"
    style="z-index: 1055;">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-bottom-0 bg-light rounded-top-4 px-4 py-3">
                <h5 class="modal-title fw-bold text-secondary" id="methodAddModalLabel">Add Package</h5>
            </div>

            <div class="modal-body px-4 py-4">
                <form action="{{ route('content.storep') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Card Number</label>
                        <select name="card_number"
                            class="form-select form-select-lg fs-6 border-secondary-subtle rounded-3">
                            <option value="" selected disabled>Select card ...</option>
                            <option value="1">Card 1</option>
                            <option value="2">Card 2</option>
                            <option value="3">Card 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Title</label>
                        <input type="text" name="title"
                            class="form-control form-control-lg fs-6 border-secondary-subtle rounded-3"
                            placeholder="Add package title ...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Price</label>
                        <input type="number" step="any" name="price" min="0"
                            class="form-control form-control-lg fs-6 border-secondary-subtle rounded-3"
                            placeholder="e.g., 150000">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Description</label>
                        <textarea name="description" rows="2" class="form-control fs-6 border-secondary-subtle rounded-3"
                            style="resize: none;" placeholder="Description of the package ..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Feature</label>
                        <textarea name="feature" rows="3" class="form-control fs-6 border-secondary-subtle rounded-3"
                            style="resize: none;" placeholder="Features (e.g., Feature A, Feature B) ..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small">Status</label>
                        <select name="status"
                            class="form-select form-select-lg fs-6 border-secondary-subtle rounded-3">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top border-light-subtle">
                        <button type="button" class="btn btn-light border px-4 py-2 rounded-3 text-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-3 shadow-sm bg-gradient">
                            Save
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
