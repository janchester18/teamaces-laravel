<!-- resources/views/loading.blade.php -->
<div id="loading-screen" class="fade-in">
    <div class="spinner"></div>
</div>

<style>
    body {
        margin: 0;
        background-color: white; /* Set background to white */
    }

    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 1); /* Fully white background */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease; /* Fade transition */
    }

    .spinner {
        border: 8px solid rgba(0, 0, 255, 0.1); /* Light blue border */
        border-left-color: #007BFF; /* Main blue color */
        border-right-color: #0056b3; /* Darker blue for contrast */
        border-top-color: #66b3ff; /* Lighter blue for additional effect */
        border-radius: 50%;
        width: 50px; /* Size of the spinner */
        height: 50px; /* Size of the spinner */
        animation: spin 1s linear infinite; /* Spinning animation */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Fade-out class */
    .fade-out {
        opacity: 0;
    }

    /* Fade-in animation */
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.5s forwards; /* Fade-in animation */
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }
</style>

<script>
    // Ensure the loading screen fades in first
    window.onload = function() {
        const loadingScreen = document.getElementById('loading-screen');
        setTimeout(() => {
            loadingScreen.classList.add('fade-out'); // Add fade-out class
            setTimeout(() => {
                loadingScreen.style.display = 'none'; // Hide after fade out
                document.getElementById('content').style.display = 'block';
            }, 500); // Match timeout to CSS transition duration
        }, 100); // Delay to ensure initial fade-in is visible
    };
</script>
