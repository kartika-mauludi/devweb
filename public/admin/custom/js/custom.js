$('.modal').on('shown.bs.modal', function() {
    $(this).find('input[autofocus]').focus();
});

function showLoading() {
    Swal.fire({
        text: 'Loading...',
        imageUrl: '/assets/img/Spinner-1s-151px.svg',
        imageWidth: 100,
        imageHeight: 100,
        // allowOutsideClick: false,
        showConfirmButton: false
    });
}

function closeLoading() {
    Swal.close();
}