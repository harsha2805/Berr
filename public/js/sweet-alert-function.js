// Success alert — returns a Promise that resolves after user clicks "OK"
function showSuccess(message = 'Operation successful', title = 'Success') {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        confirmButtonColor: '#198754' // Bootstrap green
    });
}

// Error alert — same logic
function showError(message = 'Something went wrong', title = 'Error') {
    return Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonColor: '#dc3545', // Bootstrap red
    });
}

function showErrorWithLogin(message = 'Something went wrong', title = 'Error') {
    const loginUrl = document.getElementById('app').dataset.loginUrl;

    return Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonColor: '#dc3545', // Bootstrap red
        footer: `<a href="${loginUrl}">SIGN UP/ SIGN IN?</a>`
    });
}

// Confirmation dialog — returns true/false based on user's choice
function confirmAction(message = 'Are you sure?', title = 'Please Confirm') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff3a3a',
        cancelButtonColor: '#3fc838',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => result.isConfirmed);
}

function toastMsg(icon, title, position) {
    return Swal.fire({
        toast: true,
        icon: icon,
        title: title,
        position: position,
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true
    });
}