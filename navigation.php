<!----======== CSS ======== -->
<link rel="stylesheet" href="style.css">
    
<!----===== Boxicons CSS ===== -->
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<link rel="icon" type="image/x-icon" href="https://holidayseva.com/wp-content/uploads/2024/06/cropped-holidayseva.com_favicon-1.png">

<!-- <nav class="sidebar close">  -->
<nav class="sidebar">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="https://holidayseva.com/wp-content/uploads/2024/06/cropped-holidayseva.com_favicon-1.png" alt="">
            </span>

            <div class="text logo-text">
                <span class="name">Holidayseva</span>
                <span class="profession">V 1.1.0</span>
            </div>
        </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

            <ul class="menu-links">
                <li class="nav-link" data-page="index.php">
                    <a href="index.php">
                    <i class='bx bxs-user-plus icon'></i>
                        <span class="text nav-text">Register</span>
                    </a>
                </li>

                <li class="nav-link" data-page="inquiry.php">
                    <a href="inquiry.php">
                    <i class='bx bx-phone-call icon' ></i>
                        <span class="text nav-text">Enquiry</span>
                    </a>
                </li>

                <li class="nav-link" data-page="invoice.php">
                    <a href="invoice.php">
                        <i class='bx bx-food-menu icon'></i>
                        <span class="text nav-text">Invoice</span>
                    </a>
                </li>

                <li class="nav-link" data-page="notifications.php">
                    <a href="#">
                        <i class='bx bx-bell icon'></i>
                        <span class="text nav-text">Notifications</span>
                    </a>
                </li>

                <li class="nav-link" data-page="analytics.php">
                    <a href="#">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Analytics</span>
                    </a>
                </li>

                <li class="nav-link" data-page="market_research.php">
                    <a href="market_research.php">
                    <i class='bx bx-check-shield icon'></i>
                        <span class="text nav-text">Competitors</span>
                    </a>
                </li>

                <li class="nav-link" data-page="wallets.php">
                    <a href="#">
                        <i class='bx bx-heart icon'></i>
                        <span class="text nav-text">Wallets</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="bottom-content">
            <li class="">
                <a href="#">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

            <li class="mode">
                <div class="sun-moon">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">Dark mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>
        </div>
    </div>
</nav>

<script>
    // JavaScript to add 'search-box' class to the current page li
    document.addEventListener("DOMContentLoaded", function() {
        const currentPage = window.location.pathname.split("/").pop(); // Get the current page name
        const menuLinks = document.querySelectorAll(".menu-links .nav-link");

        menuLinks.forEach(link => {
            const page = link.getAttribute("data-page"); // Get the data-page attribute
            if (page === currentPage) {
                link.classList.add("search-box");
            } else {
                link.classList.remove("search-box");
            }
        });
    });
</script>
