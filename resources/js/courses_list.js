import Swal from 'sweetalert2'


if (document.getElementsByClassName('disable_channel')) {
    let list = document.getElementsByClassName('disable_channel');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let redirect = e.target.href;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to disable your channel ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, disable it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Disabled!',
                        'Your channel has been disabled.',
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

if (document.getElementsByClassName('enable_channel')) {
    let list = document.getElementsByClassName('enable_channel');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let redirect = e.target.href;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to enable your channel ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, enable it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Enabled!',
                        'Your channel has been enabled.',
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

if (document.getElementById('delete_channel')) {
    document.getElementById('delete_channel').addEventListener('click', (e) => {
        e.preventDefault();
        let redirect = e.target.href;
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

    });
}

if (document.getElementsByClassName('course_remove')) {
    let list = document.getElementsByClassName('course_remove');
    Array.from(list).forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            let redirect = e.target.href;
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this course ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Deleted!',
                        'The course has been deleted.',
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
