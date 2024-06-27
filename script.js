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
    alert('Registration successful!');
    // You can add more logic here to handle the form submission, such as sending the data to a server.
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}
