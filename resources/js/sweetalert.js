// resources/js/sweetalert.js
import Swal from 'sweetalert2';

window.addEventListener('load', () => {
    // Check for a success message in the session
    const successMessage = document.getElementById('success-message');
    
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: successMessage.textContent,
        });
    }
});
