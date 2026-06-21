<script>
    // START MODAL FEATURE
    $('#btnShowModal').on('click', function() {
        $('#methodAddModal').css('display', 'block').addClass('show');

        if ($('.modal-backdrop').length === 0) {
            $('body').append('<div class="modal-backdrop fade show"></div>');
        }

        $('body').addClass('modal-open').css('overflow', 'hidden');
    });

    // 2. Handler untuk Menutup Modal (Dipasang ke tombol Cancel)
    $('#methodAddModal').on('click', '[data-bs-dismiss="modal"]', function() {
        $('#methodAddModal').removeClass('show').css('display', 'none');

        $('.modal-backdrop').remove();

        $('body').removeClass('modal-open').css('overflow', '');
    });

    // Deklarasikan variabel global penampung instance modal edit
    var myEditMethodModal = null;

    // Handler saat tombol Edit di tabel diklik
    $(document).on('click', '#btnShowEditModal', function() {
        // A. Ambil semua data-attributes dari tombol yang diklik
        var id = $(this).data('id');
        var icon = $(this).data('icon');
        var title = $(this).data('title');
        var description = $(this).data('description');

        // B. Masukkan nilai tersebut ke dalam field input yang ada di dalam Modal Edit
        $('#edit_feature_id').val(id);
        $('#edit_feature_icon').val(icon);
        $('#edit_feature_title').val(title);
        $('#edit_feature_description').val(description);

        // C. Tampilkan modal secara manual
        $('#methodEditModal').css('display', 'block').addClass('show');
        if ($('.modal-backdrop').length === 0) {
            $('body').append('<div class="modal-backdrop fade show"></div>');
        }
        $('body').addClass('modal-open').css('overflow', 'hidden');
    });

    // Handler untuk Menutup Modal Edit (Tombol Cancel)
    $('#methodEditModal').on('click', '[data-bs-dismiss="modal"]', function() {
        $('#methodEditModal').removeClass('show').css('display', 'none');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
    });

    // END MODAL FEATURE

    // START MODAL PACKAGE
    $('#btnShowModalPrice').on('click', function() {
        $('#methodAddModalPrice').css('display', 'block').addClass('show');
        if ($('.modal-backdrop').length === 0) {
            $('body').append('<div class="modal-backdrop fade show"></div>');
        }
        $('body').addClass('modal-open').css('overflow', 'hidden');
    });

    $('#methodAddModalPrice').on('click', '[data-bs-dismiss="modal"]', function() {
        $('#methodAddModalPrice').removeClass('show').css('display', 'none');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
    });

    $(document).on('click', '#btnShowEditModalPrice', function() {
        // Ambil data dari atribut tombol
        var id = $(this).data('id');
        var cardNumber = $(this).data('card_number');
        var title = $(this).data('title');
        var price = $(this).data('price');
        var description = $(this).data('description');
        var feature = $(this).data('feature');
        var status = $(this).data('status');

        // Isi value ke form modal edit
        $('#edit_p_id').val(id);
        $('#edit_p_card_number').val(cardNumber);
        $('#edit_p_title').val(title);
        $('#edit_p_price').val(price);
        $('#edit_p_description').val(description);
        $('#edit_p_feature').val(feature);
        $('#edit_p_status').val(status);

        // Tampilkan modal secara manual
        $('#methodEditModalPrice').css('display', 'block').addClass('show');
        if ($('.modal-backdrop').length === 0) {
            $('body').append('<div class="modal-backdrop fade show"></div>');
        }
        $('body').addClass('modal-open').css('overflow', 'hidden');
    });

    // Handler tutup untuk modal edit
    $('#methodEditModalPrice').on('click', '[data-bs-dismiss="modal"]', function() {
        $('#methodEditModalPrice').removeClass('show').css('display', 'none');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
    });

    var table = $('.datatable2').DataTable({
        layout: {
            topStart: {
                buttons: [
                    'pageLength',
                    {
                        extend: 'excel',
                        text: 'download',
                        title: 'Databaseriset - Data Paket Langganan',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    }
                ]
            }
        }
    })

    var table = $('.datatable').DataTable({
        layout: {
            topStart: {
                buttons: [
                    'pageLength',
                    {
                        extend: 'excel',
                        text: 'download',
                        title: 'Databaseriset - Data Paket Langganan',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    }
                ]
            }
        }
    })
</script>
