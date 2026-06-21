{{-- modal feature --}}
    <div class="modal fade" id="methodAddModal" tabindex="-1" aria-labelledby="methodAddModalLabel" aria-hidden="true"
        style="z-index: 1055;">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header border-bottom-0 bg-light rounded-top-4 px-4 py-3">
                    <h5 class="modal-title fw-bold text-secondary" id="methodAddModalLabel">Add Fitur</h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <form action="{{ route('content.storef') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Icon</label>
                            <input type="text" name="icon"
                                class="form-control form-control-lg fs-6 bg-light border-secondary-subtle rounded-3"
                                placeholder="e.g., av_timer, smart_display ...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Title</label>
                            <input type="text" name="title"
                                class="form-control form-control-lg fs-6 border-secondary-subtle rounded-3"
                                placeholder="Add feature title ...">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted small">Description</label>
                            <textarea name="description" rows="3" class="form-control fs-6 border-secondary-subtle rounded-3"
                                style="resize: none;" placeholder="Description of the feature ..."></textarea>
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