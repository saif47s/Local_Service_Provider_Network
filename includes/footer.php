<?php
if (!defined('MYSITE')) {
    header('location: ../index.php');
    die();
}
?>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

<!-- fontawesome icon -->
<script src="https://kit.fontawesome.com/ab8cb4ecd9.js" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
<!-- Bottom Navigation Bar for Mobile -->
<style>
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100vw;
        max-width: 100%;
        background-color: #fff;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        padding: 5px 0;
        z-index: 9999;
        flex-direction: row !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
    }

    .nav-item-link {
        flex: 1;
        /* Distribute space evenly */
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        color: #6c757d;
        font-size: 12px;
        text-decoration: none;
    }

    .nav-item-link.active {
        color: #0A2647;
        /* Theme Color */
        font-weight: bold;
    }

    .nav-item-link i {
        display: block;
        font-size: 20px;
        margin-bottom: 2px;
    }

    #installAppBtn {
        display: none;
        /* Hidden by default */
    }
</style>

<div class="bottom-nav d-flex d-md-none">
    <a href="index.php" class="nav-item-link">
        <i class="fas fa-home"></i>
        Home
    </a>
    <a href="mycart.php" class="nav-item-link">
        <i class="fas fa-shopping-cart"></i>
        Cart
    </a>
    <a href="customer/order.php" class="nav-item-link">
        <i class="fas fa-clipboard-list"></i>
        Orders
    </a>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
        <a href="customer/customer_profile.php" class="nav-item-link">
            <i class="fas fa-user"></i>
            Profile
        </a>
    <?php } else { ?>
        <a href="login.php" class="nav-item-link">
            <i class="fas fa-sign-in-alt"></i>
            Login
        </a>
    <?php } ?>

    <!-- Install Button (Icon) -->
    <a href="#" class="nav-item-link" id="installAppBtn">
        <i class="fas fa-download"></i>
        Install
    </a>
</div>

<script>
    let deferredPrompt;
    const installBtn = document.getElementById('installAppBtn');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Update UI to notify the user they can add to home screen
        installBtn.style.display = 'block';

        installBtn.addEventListener('click', (e) => {
            // hide our user interface that shows our A2HS button
            installBtn.style.display = 'none';
            // Show the prompt
            deferredPrompt.prompt();
            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
            });
        });
    });
</script>
</body>

</html>