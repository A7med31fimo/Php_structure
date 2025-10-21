<body>
    <button id="themeToggle" class="theme-toggle" title="Toggle theme">🌙</button>

    <div class="page-wrap">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <div class="muted">Creative tech UI — outputs ATS-friendly CV</div>
            </div>
            <!-- 🌐 Navbar -->
            <nav class="navbar navbar-expand-lg shadow-sm px-4 py-2 glass-navbar">
                <div class="container-fluid">
                    <a class="navbar-brand fw-bold" href="/Php_structure/index.php">Fimo CV Builder</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item">
                                <a class="nav-link" href="/Php_structure/public/views/dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/Php_structure/public/views/preview_cv.php" target="_blank">Open sample CV</a>
                            </li>

                            <?php if (isset($_SESSION['user'])): ?>
                                <li class="nav-item">
                                    <a class="btn btn-outline-light btn-sm ms-3" href="/Php_structure/logout.php">Logout</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item"><a class="nav-link" href="/Php_structure/public/views/login.php">Login</a></li>
                                <li class="nav-item"><a class="nav-link" href="/Php_structure/public/views/register.php">Register</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>