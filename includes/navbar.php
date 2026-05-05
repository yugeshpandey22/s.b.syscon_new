<?php
// includes/navbar.php matched to sbsyscon.in layout
?>
<link rel="stylesheet" href="../assets/css/navbar.css">

<!-- Top Logo Strip (Both Desktop & Mobile Now) -->
<div class="top-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo Area -->
            <a href="index.php" class="logo-area">
                <img src="../assets/images2/headerlogo.png" alt="S.B. Syscon Logo" class="img-fluid" style="max-height: 80px;">
            </a>
            
            <!-- Contact Info (Desktop Only Wrapper) -->
            <div class="d-flex gap-4 align-items-center contact-info-group d-none d-lg-flex">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-phone-alt text-danger fs-4"></i>
                    <div>
                        <small class="d-block text-muted" style="line-height:1;">Call Us</small>
                        <span class="fw-bold text-dark">+91-129-4065600</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-envelope text-danger fs-4"></i>
                    <div>
                        <small class="d-block text-muted" style="line-height:1;">Email Us</small>
                        <span class="fw-bold text-dark">info@sbsyscon.in</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="https://www.sbsmart.in" target="_blank" class="btn-sbsmart">
                        <i class="fas fa-shopping-cart me-2"></i>
                        <span>SB SMART SHOP</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Red Navigation Bar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <!-- Mobile Logo HIDDEN (It's now on top) -->
        <a class="navbar-brand d-lg-none d-none" href="index.php">
            <img src="../assets/images2/headerlogo.png" alt="S.B. Syscon" height="40">
        </a>
        
        <!-- Toggle Button Centered -->
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="principals.php">Principals</a></li>
                <li class="nav-item"><a class="nav-link" href="journey.php">Journey</a></li>
                <li class="nav-item"><a class="nav-link" href="achievements.php">Achievements</a></li>
                <li class="nav-item"><a class="nav-link" href="clientele.php">Clientele</a></li>
                <li class="nav-item"><a class="nav-link" href="exports.php">Exports</a></li>
                <li class="nav-item"><a class="nav-link" href="pricelists.php">Price Lists</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav>
