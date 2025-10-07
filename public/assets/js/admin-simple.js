// SIMPLIFIED ADMIN NAVIGATION - FIX UI/UX ISSUES
document.addEventListener('DOMContentLoaded', function() {
    
    // Sidebar toggle functionality
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            // Save state
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
        });
        
        // Restore state
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('collapsed');
        }
    }
    
    // Mobile sidebar toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
        });
    }
    
    // Close mobile sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !e.target.closest('.sidebar-toggle')) {
                sidebar.classList.remove('mobile-open');
            }
        }
    });
    
    // Active nav links
    function updateActiveLink() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.admin-nav a');
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            
            // Check if current path matches link href
            const linkPath = new URL(link.href).pathname;
            if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
                link.classList.add('active');
            }
        });
    }
    
    // Update active link on page load
    updateActiveLink();
    
    // HTMX enhancements
    if (typeof htmx !== 'undefined') {
        
        // Simple loading state
        document.body.addEventListener('htmx:beforeSend', function(e) {
            if (e.target.closest('.admin-nav a')) {
                document.body.classList.add('htmx-loading');
            }
        });
        
        document.body.addEventListener('htmx:afterSettle', function(e) {
            document.body.classList.remove('htmx-loading');
            
            // Update active links after navigation
            setTimeout(updateActiveLink, 50);
            
            // Update page title if provided
            const newTitle = e.detail.xhr.getResponseHeader('HX-Title');
            if (newTitle) {
                document.title = newTitle;
            }
            
            // Smooth scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        // Error handling
        document.body.addEventListener('htmx:responseError', function(e) {
            console.error('HTMX Error:', e.detail);
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        });
        
        // Network error handling
        document.body.addEventListener('htmx:sendError', function(e) {
            console.error('Network Error:', e.detail);
            alert('Lỗi kết nối. Vui lòng kiểm tra internet.');
        });
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Toggle sidebar with Ctrl+B
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            if (sidebarToggle) {
                sidebarToggle.click();
            }
        }
    });
    
    // Smooth transitions
    const style = document.createElement('style');
    style.textContent = `
        .htmx-loading .admin-main {
            opacity: 0.8;
            pointer-events: none;
        }
        
        .htmx-loading::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, 
                transparent, 
                var(--accent), 
                transparent
            );
            z-index: 9999;
            animation: loading-bar 1s infinite;
        }
        
        @keyframes loading-bar {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    `;
    document.head.appendChild(style);
    
});

// Utility functions
window.AdminUtils = {
    
    // Navigate programmatically
    navigate: function(url) {
        if (typeof htmx !== 'undefined') {
            htmx.ajax('GET', url, {target: '#main-content'});
        } else {
            window.location.href = url;
        }
    },
    
    // Show notification
    notify: function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            background: var(--accent);
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
};