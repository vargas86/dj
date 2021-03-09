import Swal from 'sweetalert2'
if (document.getElementById('delete-profile')) {
    document.getElementById('delete-profile').addEventListener('click', function (e) {
        e.preventDefault();
        let redirect = e.target.href;
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete your account ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Deleted!',
                    'Your account has been delete.',
                    'success'
                );
                window.location = redirect;
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    'Cancelled',
                    '',
                    'error'
                )
            }
        })
    });
}