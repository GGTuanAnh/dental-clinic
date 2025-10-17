// Optimized JavaScript for Dental Clinic Admin
document.addEventListener('DOMContentLoaded', function() {
    
    // Cache DOM elements
    const dashboardCache = new Map();
    
    // Debounce function for search
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Optimized AJAX helper with caching
    function fetchWithCache(url, options = {}) {
        const cacheKey = url + JSON.stringify(options);
        const cachedData = dashboardCache.get(cacheKey);
        
        if (cachedData && (Date.now() - cachedData.timestamp) < 60000) { // 1 minute cache
            return Promise.resolve(cachedData.data);
        }
        
        return fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                ...options.headers
            },
            ...options
        })
        .then(response => response.json())
        .then(data => {
            dashboardCache.set(cacheKey, {
                data: data,
                timestamp: Date.now()
            });
            return data;
        });
    }
    
    // Lazy load dashboard stats
    function loadDashboardStats() {
        const statsContainer = document.getElementById('dashboard-stats');
        if (!statsContainer) return;
        
        // Show loading state
        statsContainer.classList.add('loading');
        
        fetchWithCache('/admin?doctorDashboard=1&range=7')
            .then(data => {
                updateStatsDisplay(data);
                statsContainer.classList.remove('loading');
            })
            .catch(error => {
                console.error('Failed to load dashboard stats:', error);
                statsContainer.classList.remove('loading');
            });
    }
    
    // Update stats display efficiently
    function updateStatsDisplay(data) {
        if (!data.metrics) return;
        
        const elements = {
            today: document.getElementById('appointments-today'),
            confirmed: document.getElementById('appointments-confirmed'),
            completed: document.getElementById('appointments-completed'),
            revenue: document.getElementById('total-revenue')
        };
        
        // Batch DOM updates
        requestAnimationFrame(() => {
            if (elements.today) elements.today.textContent = data.metrics.today || 0;
            if (elements.confirmed) elements.confirmed.textContent = data.metrics.confirmed || 0;
            if (elements.completed) elements.completed.textContent = data.metrics.completed || 0;
            if (elements.revenue) elements.revenue.textContent = `${(data.metrics.revenue || 0).toLocaleString('vi-VN')} VND`;
        });
    }
    
    // Optimized table search
    const searchInput = document.getElementById('table-search');
    if (searchInput) {
        const debouncedSearch = debounce(function(searchTerm) {
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm.toLowerCase()) ? '' : 'none';
            });
        }, 300);
        
        searchInput.addEventListener('input', function() {
            debouncedSearch(this.value);
        });
    }
    
    // Optimized status filter
    const statusFilter = document.getElementById('status-filter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('tbody tr');
            
            requestAnimationFrame(() => {
                rows.forEach(row => {
                    const statusCell = row.querySelector('.status-badge');
                    if (!statusCell) return;
                    
                    const rowStatus = statusCell.textContent.trim().toLowerCase();
                    row.style.display = (!selectedStatus || rowStatus === selectedStatus) ? '' : 'none';
                });
            });
        });
    }
    
    // Auto-refresh dashboard every 5 minutes
    if (document.getElementById('dashboard-stats')) {
        setInterval(loadDashboardStats, 300000); // 5 minutes
        loadDashboardStats(); // Initial load
    }
    
    // Optimize form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner"></span> Processing...';
            }
        });
    });
    
    // Intersection Observer for lazy loading
    const lazyElements = document.querySelectorAll('[data-lazy]');
    if (lazyElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const src = element.dataset.lazy;
                    if (src) element.src = src;
                    observer.unobserve(element);
                }
            });
        });
        
        lazyElements.forEach(el => observer.observe(el));
    }
    
    // Clear cache periodically
    setInterval(() => {
        dashboardCache.clear();
    }, 600000); // 10 minutes
    
});

// Performance monitoring
if ('performance' in window) {
    window.addEventListener('load', function() {
        setTimeout(() => {
            const perfData = performance.getEntriesByType('navigation')[0];
            if (perfData && perfData.loadEventEnd > 2000) {
                console.warn('Page load time is slow:', perfData.loadEventEnd + 'ms');
            }
        }, 0);
    });
}