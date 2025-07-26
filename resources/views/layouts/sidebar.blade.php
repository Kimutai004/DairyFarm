<!-- Mobile Header (visible on mobile only) -->
<div class="mobile-header" id="mobileHeader">
    <div class="mobile-header-left">
        <div class="farm-logo">
            <i class="fas fa-cow"></i>
            <span>DairyFarm Pro</span>
        </div>
    </div>
    
    <div class="mobile-header-right">
        <button class="hamburger-menu" id="hamburgerToggle">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<!-- Mobile Navigation Menu (hidden by default) -->
<div class="mobile-nav-menu" id="mobileNavMenu">
    <div class="mobile-menu-header">
        <div class="user-info-mobile">
            <div class="user-avatar">
                @if(auth()->user()->profile_picture)
                    <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="Profile">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>
            <div class="user-details">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Farm Manager</div>
            </div>
        </div>
    </div>
    
    <div class="mobile-menu-content">
        <div class="mobile-menu-section">
            <div class="mobile-menu-title">Dashboard</div>
            <a href="{{ route('home') }}" class="mobile-menu-item active">
                <i class="fas fa-home"></i>
                <span>Overview</span>
            </a>
        </div>

        <div class="mobile-menu-section">
            <div class="mobile-menu-title">Livestock</div>
            <a href="{{ route('cattle.index') }}" class="mobile-menu-item">
                <i class="fas fa-cow"></i>
                <span>My Cattle</span>
            </a>
            <a href="{{ route('cattle.create') }}" class="mobile-menu-item">
                <i class="fas fa-plus-circle"></i>
                <span>Add Cattle</span>
            </a>
        </div>

        <div class="mobile-menu-section">
            <div class="mobile-menu-title">Production</div>
            <a href="{{ route('milk-production.index') }}" class="mobile-menu-item">
                <i class="fas fa-glass-whiskey"></i>
                <span>Milk Records</span>
            </a>
            <a href="{{ route('milk-production.create') }}" class="mobile-menu-item">
                <i class="fas fa-plus"></i>
                <span>Record Production</span>
            </a>
        </div>

        <div class="mobile-menu-section">
            <div class="mobile-menu-title">Health & Care</div>
            <a href="{{ route('health-records.index') }}" class="mobile-menu-item">
                <i class="fas fa-heartbeat"></i>
                <span>Health Records</span>
            </a>
            <a href="{{ route('health-records.create') }}" class="mobile-menu-item">
                <i class="fas fa-stethoscope"></i>
                <span>Health Check</span>
            </a>
        </div>

        <div class="mobile-menu-section">
            <div class="mobile-menu-title">Feeding</div>
            <a href="{{ route('feed-records.index') }}" class="mobile-menu-item">
                <i class="fas fa-wheat-awn"></i>
                <span>Feed Records</span>
            </a>
            <a href="{{ route('feed-records.create') }}" class="mobile-menu-item">
                <i class="fas fa-seedling"></i>
                <span>Record Feeding</span>
            </a>
        </div>

        <div class="mobile-menu-section">
            <div class="mobile-menu-title">Breeding</div>
            <a href="{{ route('breeding-records.index') }}" class="mobile-menu-item">
                <i class="fas fa-heart"></i>
                <span>Breeding Records</span>
            </a>
            <a href="{{ route('breeding-records.create') }}" class="mobile-menu-item">
                <i class="fas fa-venus-mars"></i>
                <span>Record Breeding</span>
            </a>
        </div>
    </div>
    
    <div class="mobile-menu-footer">
        <div class="mobile-quick-stats">
            <div class="mobile-quick-stat">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Today's Milk</div>
                    <div class="stat-value">
                        {{ number_format(\App\Models\MilkProduction::where('user_id', auth()->id())->whereDate('production_date', today())->sum('total_milk'), 1) }}L
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mobile-menu-actions">
            <a href="{{ route('logout') }}" class="mobile-action-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

<!-- Desktop Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="farm-logo">
            <i class="fas fa-cow"></i>
            <span>DairyFarm Pro</span>
        </div>
        <div class="user-info">
            <div class="user-avatar">
                @if(auth()->user()->profile_picture)
                    <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="Profile">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>
            <div class="user-details">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Farm Manager</div>
            </div>
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="menu-section">
            <div class="menu-title">Dashboard</div>
            <a href="{{ route('home') }}" class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Overview</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Livestock</div>
            <a href="{{ route('cattle.index') }}" class="menu-item">
                <i class="fas fa-cow"></i>
                <span>My Cattle</span>
                <span class="menu-badge">{{ \App\Models\Cattle::where('user_id', auth()->id())->count() }}</span>
            </a>
            <a href="{{ route('cattle.create') }}" class="menu-item">
                <i class="fas fa-plus-circle"></i>
                <span>Add Cattle</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Production</div>
            <a href="{{ route('milk-production.index') }}" class="menu-item">
                <i class="fas fa-glass-whiskey"></i>
                <span>Milk Records</span>
            </a>
            <a href="{{ route('milk-production.create') }}" class="menu-item">
                <i class="fas fa-plus"></i>
                <span>Record Production</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Health & Care</div>
            <a href="{{ route('health-records.index') }}" class="menu-item">
                <i class="fas fa-heartbeat"></i>
                <span>Health Records</span>
            </a>
            <a href="{{ route('health-records.create') }}" class="menu-item">
                <i class="fas fa-stethoscope"></i>
                <span>Health Check</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Feeding</div>
            <a href="{{ route('feed-records.index') }}" class="menu-item">
                <i class="fas fa-wheat-awn"></i>
                <span>Feed Records</span>
            </a>
            <a href="{{ route('feed-records.create') }}" class="menu-item">
                <i class="fas fa-seedling"></i>
                <span>Record Feeding</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Breeding</div>
            <a href="{{ route('breeding-records.index') }}" class="menu-item">
                <i class="fas fa-heart"></i>
                <span>Breeding Records</span>
            </a>
            <a href="{{ route('breeding-records.create') }}" class="menu-item">
                <i class="fas fa-venus-mars"></i>
                <span>Record Breeding</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="quick-stats">
            <div class="quick-stat">
                <div class="stat-icon primary">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Today's Milk</div>
                    <div class="stat-value">
                        {{ number_format(\App\Models\MilkProduction::where('user_id', auth()->id())->whereDate('production_date', today())->sum('total_milk'), 1) }}L
                    </div>
                </div>
            </div>

            <div class="quick-stat">
                <div class="stat-icon success">
                    <i class="fas fa-cow"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Active Cattle</div>
                    <div class="stat-value">
                        {{ \App\Models\Cattle::where('user_id', auth()->id())->where('status', 'active')->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-actions">
            <a href="{{ route('logout') }}" class="action-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

{{-- Include your CSS for sidebar responsiveness --}}
@include('layouts.sidebar-styles')

<!-- Sidebar JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerToggle = document.getElementById('hamburgerToggle');
    const mobileNavMenu = document.getElementById('mobileNavMenu');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    
    if (hamburgerToggle && mobileNavMenu && mobileMenuOverlay) {
        hamburgerToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            hamburgerToggle.classList.toggle('active');
            mobileNavMenu.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            document.body.classList.toggle('mobile-menu-open');
        });

        // Close menu when clicking overlay
        mobileMenuOverlay.addEventListener('click', function() {
            hamburgerToggle.classList.remove('active');
            mobileNavMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.classList.remove('mobile-menu-open');
        });

        // Close menu when clicking menu items
        const mobileMenuItems = mobileNavMenu.querySelectorAll('.mobile-menu-item');
        mobileMenuItems.forEach(item => {
            item.addEventListener('click', () => {
                hamburgerToggle.classList.remove('active');
                mobileNavMenu.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                document.body.classList.remove('mobile-menu-open');
            });
        });
    }

    // Set active navigation item based on current route
    const currentPath = window.location.pathname;
    const mobileMenuItems = document.querySelectorAll('.mobile-menu-item');
    const desktopMenuItems = document.querySelectorAll('.menu-item');
    
    // Remove all active classes first
    mobileMenuItems.forEach(item => item.classList.remove('active'));
    desktopMenuItems.forEach(item => item.classList.remove('active'));
    
    // Add active class based on current route
    mobileMenuItems.forEach(item => {
        if (item.getAttribute('href') === currentPath) {
            item.classList.add('active');
        }
    });
    
    desktopMenuItems.forEach(item => {
        if (item.getAttribute('href') === currentPath) {
            item.classList.add('active');
        }
    });
});
</script>
