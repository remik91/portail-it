<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Portail IT</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- Custom Admin CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            padding: 70px 0 0;
            background-color: #343a40;
            color: #fff;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 10px 20px;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #495057;
        }

        .sidebar .nav-link.active {
            color: #fff;
            font-weight: bold;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 70px;
            /* Space for the top navbar */
        }

        .top-navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 56px;
            z-index: 1030;
        }

        .navbar-brand-sidebar {
            width: 250px;
            background-color: #212529;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            height: 56px;
            line-height: 56px;
        }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom top-navbar">
        <div class="container-fluid">
            <!-- This can be used for breadcrumbs or page titles if needed -->
            <span class="navbar-text">
                Panneau d'Administration
            </span>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">Retour au portail</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a class="navbar-brand-sidebar text-white text-decoration-none" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-shield-halved me-2"></i>PORTAIL ADMIN
        </a>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard
            </a>
            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">Gestion</h6>
            <a class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}"
                href="{{ route('admin.applications.index') }}">
                <i class="fas fa-rocket fa-fw me-2"></i>Applications
            </a>
            <a class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}"
                href="{{ route('admin.tags.index') }}">
                <i class="fas fa-tags fa-fw me-2"></i>Tags
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                href="{{ route('admin.categories.index') }}">
                <i class="fas fa-tags fa-fw me-2"></i>Catégories
            </a>
            <a class="nav-link {{ request()->routeIs('admin.entities.*') ? 'active' : '' }}"
                href="{{ route('admin.entities.index') }}">
                <i class="fas fa-tags fa-fw me-2"></i>Entités
            </a>
            <!-- Vous pouvez ajouter le lien pour les Entités ici -->
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                href="{{ route('admin.users.index') }}">
                <i class="fas fa-users fa-fw me-2"></i>Utilisateurs
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @include('admin.partials._toast')
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toastLiveExample = document.getElementById('liveToast')
        if (toastLiveExample) {
            const toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        }
    </script>
</body>

</html>
