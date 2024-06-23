document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);

    const error = urlParams.get('error');

    if (error) {
        document.getElementById('error-message').innerHTML = error;
    }

    const username = urlParams.get('variable');

    if (username != null) {
        document.getElementById('username').setAttribute('value', username);
    }
})