import Swal from 'sweetalert2'


// reactivate subscription
if (document.getElementsByClassName('reactivate')) {
    let list = document.getElementsByClassName('reactivate');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let redirect = e.target.href;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to reactivate your subscription ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, reactivate!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Subscribed!',
                        'You are now subscribed.',
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
    });
}


// disable subscription
if (document.getElementsByClassName('unsubscribe')) {
    let list = document.getElementsByClassName('unsubscribe');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let redirect = e.target.href;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to unsubscribe ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, unsubscribe!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Unsubscribed!',
                        'The subscription has been cancelled.',
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
    });
}

