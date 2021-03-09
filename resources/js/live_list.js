import Swal from 'sweetalert2'

document.getElementById('buttonDeleteChannel').addEventListener('click', (e) => {
    e.preventDefault();
    let redirect = e.target.parentNode.href;
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete your channel ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Deleted!',
                'Your channel has been delete.',
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
})
if (document.getElementById('cancel-live')) {
    document.getElementById('cancel-live').addEventListener('click', (e) => {
        e.preventDefault();
        let redirect = '#';
        if (typeof e.target.href === 'undefined') {
            redirect = e.target.parentNode.href;
        } else {
            redirect = e.target.href;
        }
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to cancel this live ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Deleted!',
                    'The live has been cancelled.',
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
    })
}