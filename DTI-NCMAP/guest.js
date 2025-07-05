/**
 * Guest mode specific functionality for DTI Office Locator
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar in collapsed state on mobile
    if (window.innerWidth < 768) {
        document.getElementById('sidebar').classList.add('collapsed');
    }
    
    // Add event listeners for modals to close when clicking outside
    window.addEventListener('click', function(event) {
        const officeModal = document.getElementById('officeModal');
        const staffModal = document.getElementById('staffDetailsModal');
        
        if (event.target === officeModal) {
            closeModal();
        }
        
        if (event.target === staffModal) {
            closeStaffDetailsModal();
        }
    });
    
    // Add keyboard event listener to close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
            closeStaffDetailsModal();
        }
    });
    
    // Add a welcome message for guest users
    setTimeout(function() {
        showGuestWelcomeMessage();
    }, 2000);
});

/**
 * Shows a welcome message for guest users
 */
function showGuestWelcomeMessage() {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-info-circle toast-icon"></i>
            <div class="toast-message">
                <strong>Welcome to Guest Mode!</strong>
                <p>You can view office and staff information, but some features are limited. Login as admin for full access.</p>
            </div>
            <button class="toast-close" onclick="this.parentElement.parentElement.remove();">&times;</button>
        </div>
    `;
    
    // Add to document
    document.body.appendChild(toast);
    
    // Auto-remove after 8 seconds
    setTimeout(function() {
        if (document.body.contains(toast)) {
            toast.remove();
        }
    }, 8000);
}

/**
 * Handles errors when loading images
 */
function handleImageError(img) {
    img.onerror = null;
    img.src = 'img/placeholder.jpg';
}

// Add CSS for toast notifications
const style = document.createElement('style');
style.textContent = `
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 2000;
        max-width: 350px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease-out forwards;
    }
    
    .toast-content {
        display: flex;
        align-items: flex-start;
        padding: 15px;
    }
    
    .toast-icon {
        color: #1976D2;
        font-size: 20px;
        margin-right: 12px;
        margin-top: 2px;
    }
    
    .toast-message {
        flex: 1;
    }
    
    .toast-message strong {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }
    
    .toast-message p {
        margin: 0;
        color: #666;
        font-size: 14px;
        line-height: 1.4;
    }
    
    .toast-close {
        background: none;
        border: none;
        color: #999;
        font-size: 18px;
        cursor: pointer;
        padding: 0 5px;
        margin-left: 10px;
    }
    
    .toast-close:hover {
        color: #333;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
