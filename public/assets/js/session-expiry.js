// session_expiry.js

// Function to show the confirmation dialog
function showSessionExpiryConfirmation() {
    // Customize the message in the confirmation dialog
    const confirmationMessage = 'Your session is about to expire. Do you want to stay logged in?';

    // Show the confirmation dialog
    const userChoice = window.confirm(confirmationMessage);

    // Handle the user's choice
    if (userChoice) {
        // User clicked OK, stay logged in
        // Optionally, you may want to refresh the session on the server side
        // Make an AJAX request or redirect to a route that refreshes the session
    } else {
        // User clicked Cancel, log out
        // Redirect to the logout route or perform any other logout logic
        window.location.href = '/logout';
    }
}

// Set a timer to show the confirmation dialog 5 minutes before session expiry
const warningTime = 5 * 60 * 1000; // 5 minutes in milliseconds

setTimeout(function () {
    showSessionExpiryConfirmation();
}, sessionExpiryTime - warningTime);
