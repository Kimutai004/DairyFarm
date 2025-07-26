<style>
.dashboard-layout {
    display: flex;
    min-height: 100vh;
    background: #f8f9fa;
}

.sidebar {
    width: 280px;
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
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.farm-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.farm-logo i {
    font-size: 2rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 50px;
    height: 50px;
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
    font-size: 1.5rem;
}

.user-name {
    font-weight: 600;
    font-size: 1.1rem;
}

.user-role {
    opacity: 0.8;
    font-size: 0.9rem;
}

.sidebar-menu {
    flex: 1;
    padding: 1rem 0;
}

.menu-section {
    margin-bottom: 1.5rem;
}

.menu-title {
    padding: 0 1.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    opacity: 0.7;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1.5rem;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
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
    width: 4px;
    background: rgba(255, 255, 255, 0.8);
}

.menu-item i {
    width: 20px;
    font-size: 1.1rem;
}

.menu-badge {
    margin-left: auto;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.quick-stats {
    margin-bottom: 1rem;
}

.quick-stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.stat-icon.primary {
    background: rgba(102, 126, 234, 0.3);
}

.stat-icon.success {
    background: rgba(40, 167, 69, 0.3);
}

.stat-label {
    font-size: 0.8rem;
    opacity: 0.8;
}

.stat-value {
    font-weight: 600;
    font-size: 0.9rem;
}

.action-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.action-link:hover {
    color: white;
    text-decoration: none;
}

.main-content {
    flex: 1;
    margin-left: 280px;
    padding: 2rem;
    background: #f8f9fa;
}

/* Mobile Sidebar Toggle */
.sidebar-toggle {
    display: none;
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1001;
    background: #667eea;
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 10px;
    font-size: 1.2rem;
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
        padding: 5rem 1rem 1rem;
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
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.page-subtitle {
    color: #6c757d;
    margin: 0;
    font-size: 1.1rem;
}

/* Farmer Card Styles */
.farmer-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: none;
    margin-bottom: 2rem;
}

.farmer-card .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 15px 15px 0 0;
    padding: 1rem 1.5rem;
}

.farmer-card .card-body {
    padding: 1.5rem;
}

.farmer-card .card-header h5 {
    margin: 0;
    font-weight: 600;
    color: #333;
}

/* Stats Cards */
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    border-left: 4px solid;
}

.stat-card.primary { border-left-color: #667eea; }
.stat-card.success { border-left-color: #28a745; }
.stat-card.warning { border-left-color: #ffc107; }
.stat-card.info { border-left-color: #17a2b8; }

.stat-card .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    display: block;
}

.stat-card .stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

/* Form Styles */
.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
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
    transform: translateY(-2px);
}

/* Table Styles */
.table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.table thead th {
    background: #f8f9fa;
    border: none;
    font-weight: 600;
    color: #333;
    padding: 1rem;
}

.table tbody td {
    border: none;
    padding: 1rem;
    vertical-align: middle;
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
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
    }
    
    .filter-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-sm {
        margin-bottom: 0.5rem;
    }
    
    .page-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .stats-overview {
        grid-template-columns: 1fr;
    }
    
    .main-content {
        padding: 1rem;
    }
}
</style>
