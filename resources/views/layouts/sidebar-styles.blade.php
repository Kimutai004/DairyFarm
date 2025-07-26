<style>
.dashboard-layout {
    display: flex;
    min-height: 100vh;
    background: #f8f9fa;
}

.sidebar {
    width: 260px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    left: 0;
    top: 0;
    z-index: 1000;
    overflow-y: auto;
}

.sidebar-header {
    padding: 1.2rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.farm-logo {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.8rem;
}

.farm-logo i {
    font-size: 1.6rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: background 0.3s ease;
    position: relative;
}

.user-info:hover {
    background: rgba(255, 255, 255, 0.1);
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-avatar i {
    font-size: 1.2rem;
}

.user-details {
    flex: 1;
}

.user-name {
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.2rem;
}

.user-role {
    opacity: 0.8;
    font-size: 0.8rem;
}

.dropdown-arrow {
    margin-left: auto;
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

.user-info.active .dropdown-arrow {
    transform: rotate(180deg);
}

/* User Dropdown Menu */
.user-dropdown {
    position: absolute;
    top: 100%;
    left: 1.2rem;
    right: 1.2rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 1001;
    margin-top: 0.5rem;
}

.user-dropdown.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 1rem;
    color: #333;
    text-decoration: none;
    transition: background 0.3s ease;
    border-radius: 6px;
    margin: 0.3rem;
    font-size: 0.85rem;
}

.dropdown-item:first-child {
    margin-top: 0.5rem;
}

.dropdown-item:last-child {
    margin-bottom: 0.5rem;
}

.dropdown-item:hover {
    background: #f8f9fa;
    color: #333;
    text-decoration: none;
}

.dropdown-item i {
    width: 16px;
    font-size: 0.9rem;
    opacity: 0.7;
}

.dropdown-divider {
    height: 1px;
    background: #e9ecef;
    margin: 0.5rem 1rem;
}

.sidebar-menu {
    flex: 1;
    padding: 0.8rem 0;
}

.menu-section {
    margin-bottom: 1.2rem;
}

.menu-title {
    padding: 0 1.2rem;
    font-size: 0.7rem;
    font-weight: 600;
    opacity: 0.7;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.4rem;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.6rem 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    font-size: 0.9rem;
}

.menu-item:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    text-decoration: none;
}

.menu-item.active {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.menu-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: rgba(255, 255, 255, 0.8);
}

.menu-item i {
    width: 18px;
    font-size: 1rem;
}

.menu-badge {
    margin-left: auto;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.2rem 0.4rem;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 600;
}

.sidebar-footer {
    padding: 1.2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.quick-stats {
    margin-bottom: 0.8rem;
}

.quick-stat {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 0.8rem;
}

.stat-icon {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
}

.stat-icon.primary {
    background: rgba(102, 126, 234, 0.3);
}

.stat-icon.success {
    background: rgba(40, 167, 69, 0.3);
}

.stat-label {
    font-size: 0.75rem;
    opacity: 0.8;
}

.stat-value {
    font-weight: 600;
    font-size: 0.85rem;
}

.action-link {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.6rem 0;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 0.85rem;
}

.action-link:hover {
    color: white;
    text-decoration: none;
}

.main-content {
    flex: 1;
    margin-left: 260px;
    padding: 1.5rem;
    background: #f8f9fa;
}

/* Mobile Sidebar Toggle */
.sidebar-toggle {
    display: none;
    position: fixed;
    top: 0.8rem;
    left: 0.8rem;
    z-index: 1001;
    background: #667eea;
    color: white;
    border: none;
    padding: 0.6rem;
    border-radius: 8px;
    font-size: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Sidebar Overlay for Mobile */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
        padding: 4rem 1rem 1rem;
    }
    
    .sidebar-toggle {
        display: block;
    }
    
    .sidebar-overlay.active {
        display: block;
    }
}

/* Page Header Styles */
.page-header {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    margin-bottom: 1.5rem;
}

.page-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.page-subtitle {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

/* Farmer Card Styles */
.farmer-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    border: none;
    margin-bottom: 1.5rem;
}

.farmer-card .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0;
    padding: 1rem 1.25rem;
}

.farmer-card .card-body {
    padding: 1.25rem;
}

.farmer-card .card-header h5 {
    margin: 0;
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

/* Stats Cards */
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    text-align: center;
    border-left: 3px solid;
}

.stat-card.primary { border-left-color: #667eea; }
.stat-card.success { border-left-color: #28a745; }
.stat-card.warning { border-left-color: #ffc107; }
.stat-card.info { border-left-color: #17a2b8; }

.stat-card .stat-number {
    font-size: 1.6rem;
    font-weight: 700;
    color: #333;
    display: block;
}

.stat-card .stat-label {
    color: #6c757d;
    font-size: 0.85rem;
    margin-top: 0.4rem;
}

/* Form Styles */
.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.4rem;
    font-size: 0.9rem;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e9ecef;
    padding: 0.6rem 0.8rem;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

.btn-light {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    color: #495057;
}

.btn-light:hover {
    background: #e9ecef;
    border-color: #dee2e6;
}

.btn-secondary {
    background: #6c757d;
    border: none;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

/* Table Styles */
.table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
}

.table thead th {
    background: #f8f9fa;
    border: none;
    font-weight: 600;
    color: #333;
    padding: 0.8rem;
    font-size: 0.9rem;
}

.table tbody td {
    border: none;
    padding: 0.8rem;
    vertical-align: middle;
    font-size: 0.85rem;
}

.table tbody tr {
    border-bottom: 1px solid #f8f9fa;
}

.table tbody tr:last-child {
    border-bottom: none;
}

/* Filter Controls */
.filter-controls {
    background: white;
    padding: 1.25rem;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    margin-bottom: 1.5rem;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    align-items: end;
}

/* Status Badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-badge.active {
    background: #d4edda;
    color: #155724;
}

.status-badge.inactive {
    background: #f8d7da;
    color: #721c24;
}

.status-badge.sick {
    background: #fff3cd;
    color: #856404;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Pagination */
.pagination {
    justify-content: center;
    margin-top: 2rem;
}

.page-link {
    border-radius: 10px;
    margin: 0 0.25rem;
    border: 1px solid #e9ecef;
    color: #667eea;
}

.page-link:hover {
    background: #667eea;
    border-color: #667eea;
    color: white;
}

.page-item.active .page-link {
    background: #667eea;
    border-color: #667eea;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h5 {
    margin-bottom: 1rem;
    color: #495057;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-overview {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.8rem;
    }
    
    .filter-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-sm {
        margin-bottom: 0.4rem;
    }
    
    .page-header {
        padding: 1.2rem;
        text-align: center;
    }
    
    .page-title {
        font-size: 1.4rem;
    }
    
    .main-content {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .stats-overview {
        grid-template-columns: 1fr;
        gap: 0.6rem;
    }
    
    .page-header {
        padding: 1rem;
    }
    
    .page-title {
        font-size: 1.2rem;
    }
    
    .farmer-card .card-body {
        padding: 1rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
}
    
    .main-content {
        padding: 1rem;
    }
}
</style>
