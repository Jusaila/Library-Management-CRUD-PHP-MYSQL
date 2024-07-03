<?php
    if(isset($_SESSION['message'])) :
?>

    <div class="alert alert-warning alert-dismissible fade show" id="flash-message" role="alert">
        <strong></strong> <?= $_SESSION['message']; ?>
    </div>
<!-- session-time set -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
    </script>
<?php 
    unset($_SESSION['message']);
    endif;
?>