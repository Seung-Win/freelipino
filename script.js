document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const fname = document.getElementById('fname').value.trim();
    const mname = document.getElementById('mname').value.trim();
    const lname = document.getElementById('lname').value.trim();
    const address = document.getElementById('address').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const errorMessage = document.getElementById('errorMessage');

    if (fname === '' || mname === '' || lname === '' || address === '' || email === '' || password === '') {
        errorMessage.textContent = 'All fields are required.';
        return;
    }

    if (!validateEmail(email)) {
        errorMessage.textContent = 'Please enter a valid email address.';
        return;
    }

    if (password.length < 6) {
        errorMessage.textContent = 'Password must be at least 6 characters long.';
        return;
    }

    errorMessage.textContent = '';

    console.log('Form submitted successfully!');
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}


$(document).ready(function () {
    $('#createJobForm').on('submit', function (e) {
        e.preventDefault();
        // Handle job creation logic here
        $('#createJobModal').modal('hide');
    });

    $('#editJobModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var jobId = button.data('job-id');
        // Fetch and populate job data based on jobId
    });

    $('#editJobForm').on('submit', function (e) {
        e.preventDefault();
        // Handle job editing logic here
        $('#editJobModal').modal('hide');
    });
});

