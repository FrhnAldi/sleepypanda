<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2>Admin Site</h2>
        <button class="close-sidebar" id="closeSidebar">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="sidebar-link-text">Dashboard</span>
        </a>
        
        <a href="{{ route('jurnal') }}" class="sidebar-link {{ request()->routeIs('jurnal') ? 'active' : '' }}">
            <span class="sidebar-link-text">Jurnal</span>
        </a>
        
        <a href="{{ route('report') }}" class="sidebar-link {{ request()->routeIs('report') ? 'active' : '' }}">
            <span class="sidebar-link-text">Report</span>
        </a>
        
        <!-- Database User with Dual Function Dropdown -->
        <div class="sidebar-dropdown">
            <div class="sidebar-link-wrapper {{ request()->routeIs('database.user') ? 'active' : '' }}">
                <a href="{{ route('database.user') }}" class="sidebar-link-dual">
                    <span class="sidebar-link-text">Database User</span>
                </a>
                <button class="dropdown-toggle-btn" id="databaseUserToggle">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </div>
            <div class="dropdown-menu" id="databaseUserMenu">
                <a href="{{ route('database.user') }}?action=update" class="dropdown-item">
                    <span>Update Data</span>
                </a>
                <a href="{{ route('database.user') }}?action=reset" class="dropdown-item">
                    <span>Reset Password</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Logout Button in Sidebar -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
            @csrf
            <button type="submit" class="btn-logout-sidebar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Content Wrapper -->
<div class="main-content" id="mainContent">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <div class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('images/pandalo.png') }}" alt="Sleepy Panda" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                </div>
                <span class="logo-text">Sleepy Panda</span>
            </div>

            <div class="search-bar">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input type="text" class="search-input" placeholder="Search">
            </div>
        </div>

        <div class="nav-right">
            <span class="user-name">Halo, {{ auth()->user()->name ?? 'Guest' }}</span>
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}</div>
        </div>
    </nav>

<style>
    /* Main Content Wrapper for Push Effect */
    .main-content {
        margin-left: 0;
        width: 100%;
        max-width: 100vw;
        transition: margin-left 0.3s ease, width 0.3s ease, max-width 0.3s ease;
        min-height: 100vh;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .main-content.pushed {
        margin-left: 324px;
        width: calc(100% - 324px);
        max-width: calc(100vw - 324px);
    }

    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        left: -324px;
        top: 0;
        width: 324px;
        height: 100vh;
        background: #2C2E4E;
        z-index: 2000;
        transition: left 0.3s ease;
        overflow-y: auto;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
    }

    .sidebar.active {
        left: 0;
    }

    .sidebar-header {
        padding: 35px 30px 30px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-header h2 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .close-sidebar {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }

    .close-sidebar:hover {
        color: #ffffff;
    }

    .sidebar-nav {
        padding: 20px 30px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        flex: 1;
    }

    /* Regular Sidebar Links */
    .sidebar-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px 20px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        background: transparent;
        border: 1.5px solid rgba(255, 255, 255, 0.15);
        position: relative;
    }

    .sidebar-link-text {
        position: relative;
        z-index: 1;
    }

    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        transform: translateX(5px);
    }

    .sidebar-link.active {
        background: rgba(102, 126, 234, 0.12);
        border-color: rgba(102, 126, 234, 0.4);
        color: #8b9cff;
    }

    .sidebar-link.active:hover {
        background: rgba(102, 126, 234, 0.18);
        border-color: rgba(102, 126, 234, 0.5);
    }

    /* Dual Function Dropdown Styles */
    .sidebar-dropdown {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .sidebar-link-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0;
        border-radius: 12px;
        border: 1.5px solid rgba(255, 255, 255, 0.15);
        background: transparent;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .sidebar-link-wrapper:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .sidebar-link-wrapper.active {
        background: rgba(102, 126, 234, 0.12);
        border-color: rgba(102, 126, 234, 0.4);
    }

    .sidebar-link-wrapper.active:hover {
        background: rgba(102, 126, 234, 0.18);
        border-color: rgba(102, 126, 234, 0.5);
    }

    .sidebar-link-dual {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px 20px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        background: transparent;
    }

    .sidebar-link-wrapper.active .sidebar-link-dual {
        color: #8b9cff;
    }

    .sidebar-link-dual:hover {
        color: #ffffff;
    }

    .dropdown-toggle-btn {
        background: transparent;
        border: none;
        border-left: 1px solid rgba(255, 255, 255, 0.15);
        color: rgba(255, 255, 255, 0.85);
        cursor: pointer;
        padding: 18px 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .dropdown-toggle-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
    }

    .sidebar-link-wrapper.active .dropdown-toggle-btn {
        border-left-color: rgba(102, 126, 234, 0.3);
        color: #8b9cff;
    }

    .dropdown-toggle-btn svg {
        transition: transform 0.3s ease;
    }

    .dropdown-toggle-btn.open svg {
        transform: rotate(180deg);
    }

    .dropdown-menu {
        display: none;
        flex-direction: column;
        gap: 10px;
        padding: 0;
        margin: 0;
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.3s ease;
    }

    .dropdown-menu.show {
        display: flex;
        max-height: 300px;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 20px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.03);
        border: 1.5px solid rgba(255, 255, 255, 0.15);
    }

    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        transform: translateX(5px);
    }

    /* Sidebar Footer for Logout */
    .sidebar-footer {
        padding: 20px 30px 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        margin-top: auto;
    }

    .btn-logout-sidebar {
        width: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-logout-sidebar:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    /* Navbar Styles */
    .navbar {
        background: #20223F;
        padding: 20px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
        backdrop-filter: blur(10px);
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .hamburger {
        width: 30px;
        height: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        transition: 0.3s;
        z-index: 1100;
    }

    .hamburger:hover {
        opacity: 0.8;
    }

    .hamburger span {
        width: 100%;
        height: 3px;
        background: white;
        border-radius: 2px;
        transition: 0.3s;
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(6px, 6px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(6px, -6px);
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .logo-text {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .search-bar {
        position: relative;
    }

    .search-input {
        background: #20223F;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        padding: 10px 20px 10px 45px;
        color: white;
        font-size: 14px;
        width: 350px;
        outline: none;
        transition: 0.3s;
    }

    .search-input:focus {
        background: #20223F;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.4);
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        cursor: pointer;
    }

    .user-name {
        font-size: 15px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
    }

    /* Responsive Styles */
    @media (max-width: 968px) {
        .search-input {
            width: 200px;
        }
        
        .sidebar {
            width: 280px;
            left: -280px;
        }
        
        .main-content.pushed {
            margin-left: 0;
            width: 100%;
        }
    }

    @media (max-width: 640px) {
        .navbar {
            padding: 15px 20px;
        }

        .search-bar {
            display: none;
        }

        .user-name {
            display: none;
        }
        
        .sidebar {
            width: 250px;
            left: -250px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const closeSidebar = document.getElementById('closeSidebar');
        const databaseUserToggle = document.getElementById('databaseUserToggle');
        const databaseUserMenu = document.getElementById('databaseUserMenu');

        // Toggle sidebar
        hamburger.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('pushed');
            hamburger.classList.toggle('active');
            
            setTimeout(function() {
                window.dispatchEvent(new Event('resize'));
            }, 300);
        });

        // Close sidebar
        function closeSidebarFunc() {
            sidebar.classList.remove('active');
            mainContent.classList.remove('pushed');
            hamburger.classList.remove('active');
            
            setTimeout(function() {
                window.dispatchEvent(new Event('resize'));
            }, 300);
        }

        closeSidebar.addEventListener('click', closeSidebarFunc);

        // Toggle dropdown menu (icon button only)
        if (databaseUserToggle) {
            databaseUserToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                databaseUserToggle.classList.toggle('open');
                databaseUserMenu.classList.toggle('show');
            });
        }

        // Close sidebar on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                closeSidebarFunc();
            }
        });

        // Close sidebar when clicking regular sidebar links
        const sidebarLinks = document.querySelectorAll('.sidebar-link:not(.sidebar-link-dual)');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                setTimeout(closeSidebarFunc, 100);
            });
        });

        // Close sidebar when clicking dropdown items
        const dropdownItems = document.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                setTimeout(closeSidebarFunc, 100);
            });
        });
    });
</script>