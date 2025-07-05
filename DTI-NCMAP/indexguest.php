<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTI Office Locator - Cebu Province</title>
    
    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <style>
        :root {
            --primary-color: #0D47A1;
            --primary-dark: #002171;
            --primary-light: #BBDEFB;
            --secondary-color: #2E7D32;
            --accent-color: #EF6C00;
            --purple-color: #6A1B9A;
            --text-dark: #333333;
            --text-medium: #555555;
            --text-light: #777777;
            --background-light: #f8f9fa;
            --white: #ffffff;
            --shadow-light: 0 2px 10px rgba(0,0,0,0.1);
            --shadow-medium: 0 4px 15px rgba(0,0,0,0.15);
            --transition-normal: all 0.3s ease;
            --border-radius-sm: 4px;
            --border-radius-md: 8px;
            --border-radius-lg: 12px;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Roboto', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
            line-height: 1.6;
            height: 100vh;
            overflow: hidden;
        }
        
        /* Header styles */
        .header {
            background-color: var(--white);
            box-shadow: var(--shadow-light);
            padding: 0.8rem 1.5rem;
            position: relative;
            z-index: 1000;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo {
            height: 50px;
            width: auto;
        }
        
        .title-section {
            display: flex;
            flex-direction: column;
        }
        
        .title-section h1 {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            line-height: 1.2;
        }
        
        .title-section p {
            font-size: 0.95rem;
            color: var(--text-medium);
            margin: 0;
        }
        
        .header-actions {
            display: flex;
            gap: 1rem;
        }
        
        /* Main container styles */
        .main-container {
            display: flex;
            height: calc(100vh - 70px);
            position: relative;
        }
        
        /* Sidebar styles */
        .sidebar {
            width: 350px;
            background-color: var(--white);
            box-shadow: var(--shadow-light);
            overflow-y: auto;
            transition: var(--transition-normal);
            z-index: 900;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar.collapsed {
            width: 0;
            overflow: hidden;
        }
        
        .search-section, .office-list-section {
            padding: 1.2rem;
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }
        
        .search-section h3, .office-list-section h3 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .search-controls {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        
        .search-input {
            padding: 0.7rem 1rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius-md);
            font-size: 0.95rem;
            width: 100%;
        }
        
        .form-row {
            display: flex;
            gap: 0.8rem;
        }
        
        .filter-select {
            flex: 1;
            padding: 0.7rem 0.5rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius-md);
            font-size: 0.9rem;
            background-color: var(--white);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.7rem 1rem;
            border-radius: var(--border-radius-md);
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition-normal);
            border: none;
            text-decoration: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--background-light);
            color: var(--text-medium);
            border: 1px solid #ddd;
        }
        
        .btn-secondary:hover {
            background-color: #e9ecef;
        }
        
        .office-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .office-item {
            background-color: var(--white);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-light);
            padding: 1rem;
            cursor: pointer;
            transition: var(--transition-normal);
            border: 1px solid #eee;
        }
        
        .office-item:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-2px);
        }
        
        .office-header {
            margin-bottom: 0.8rem;
        }
        
        .office-name {
            font-weight: 500;
            font-size: 1rem;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
        }
        
        .office-type {
            font-size: 0.85rem;
            color: white;
            margin-bottom: 0.3rem;
        }
        
        .office-region {
            display: inline-block;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }
        
        .office-address {
            font-size: 0.85rem;
            color: var(--text-medium);
            margin-bottom: 0.8rem;
        }
        
        .office-actions {
            display: flex;
            justify-content: flex-end;
        }
        
        /* Map container styles */
        .map-container {
            flex: 1;
            position: relative;
            overflow: hidden;
        }
        
        .map {
            height: 100%;
            width: 100%;
        }
        
        .map-controls {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 800;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .map-control-btn {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            background-color: var(--white);
            border: none;
            box-shadow: var(--shadow-light);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-normal);
        }
        
        .map-control-btn:hover {
            background-color: #f0f0f0;
        }
        
        .map-legend {
            position: absolute;
            bottom: 25px;
            left: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px 15px;
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-light);
            z-index: 800;
            font-size: 0.9rem;
        }
        
        .map-legend h4 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }
        
        .legend-marker {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-right: 8px;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        
        .legend-marker.regional {
            background-color: #1565C0;
        }
        
        .legend-marker.provincial {
            background-color: #2E7D32;
        }
        
        .legend-marker.field {
            background-color: #EF6C00;
        }
        
        .legend-marker.extension {
            background-color: #6A1B9A;
        }
        
        .legend-marker.negosyo {
            background-color: #303F9F;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1100;
            overflow-y: auto;
        }
        
        .modal-content {
            background-color: var(--white);
            margin: 2rem auto;
            width: 90%;
            max-width: 800px;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-medium);
            overflow: hidden;
            animation: modalFadeIn 0.3s;
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .modal-header {
            padding: 1.2rem 1.5rem;
            background-color: var(--primary-color);
            color: var(--white);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h2 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 500;
        }
        
        .modal-close {
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }
        
        .modal-body {
            padding: 1.5rem;
            max-height: 70vh;
            overflow-y: auto;
        }
        
        /* Office details styles */
        .office-detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .office-detail-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .office-detail-image {
            width: 100%;
            max-width: 400px;
            height: 200px;
            object-fit: cover;
            border-radius: var(--border-radius-md);
            margin-bottom: 1rem;
        }
        
        .office-detail-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .office-detail-badges {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .badge-primary {
            background-color: var(--primary-light);
            color: var(--primary-dark);
        }
        
        .badge-warning {
            background-color: #fff3e0;
            color: #e65100;
        }
        
        .info-section {
            margin-bottom: 1.5rem;
        }
        
        .info-section h4 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-item {
            display: flex;
            margin-bottom: 0.8rem;
            font-size: 0.95rem;
        }
        
        .info-item i {
            color: var(--primary-color);
                        margin-right: 0.8rem;
            min-width: 16px;
            margin-top: 3px;
        }
        
        .info-item strong {
            font-weight: 500;
            margin-bottom: 0.2rem;
            display: block;
        }
        
        /* Staff section styles */
        .office-staff-section {
            background-color: var(--background-light);
            border-radius: var(--border-radius-md);
            padding: 1.5rem;
            margin-top: 1rem;
        }
        
        .staff-section-header {
            margin-bottom: 1.2rem;
        }
        
        .staff-section-header h3 {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }
        
        .staff-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }
        
        .staff-card {
            background-color: var(--white);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-light);
            overflow: hidden;
            transition: var(--transition-normal);
            border: 1px solid #eee;
        }
        
        .staff-card:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-3px);
        }
        
        .staff-header {
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .staff-photo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }
        
        .staff-photo-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.5rem;
        }
        
        .staff-name-section {
            flex: 1;
        }
        
        .staff-name {
            font-size: 1rem;
            font-weight: 500;
            margin: 0 0 0.3rem 0;
            color: var(--text-dark);
        }
        
        .staff-position {
            font-size: 0.85rem;
            color: var(--text-medium);
            margin-bottom: 0.5rem;
        }
        
        .staff-type {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .staff-type-a {
            background-color: #e3f2fd;
            color: #1565C0;
        }
        
        .staff-type-b {
            background-color: #fff3e0;
            color: #e65100;
        }
        
        .staff-body {
            padding: 1rem;
        }
        
        .staff-info {
            margin-bottom: 1rem;
        }
        
        .staff-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }
        
        .staff-info-item i {
            color: var(--text-medium);
            margin-right: 0.5rem;
            min-width: 16px;
            margin-top: 3px;
        }
        
        .staff-actions {
            display: flex;
            justify-content: flex-end;
        }
        
        /* Staff details modal styles */
        .staff-detail-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .staff-detail-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-light);
        }
        
        .staff-detail-photo-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 2.5rem;
        }
        
        .staff-detail-info {
            flex: 1;
        }
        
        .staff-detail-name {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0 0 0.3rem 0;
            color: var(--text-dark);
        }
        
        .staff-detail-position {
            font-size: 1rem;
            color: var(--text-medium);
            margin-bottom: 0.8rem;
        }
        
        .staff-detail-badges {
            display: flex;
            gap: 0.5rem;
        }
        
        .staff-detail-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .staff-detail-section {
            margin-bottom: 1rem;
        }
        
        .staff-detail-section h4 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .staff-detail-item {
            display: flex;
            margin-bottom: 0.8rem;
        }
        
        .staff-detail-label {
            font-weight: 500;
            width: 80px;
            color: var(--text-medium);
        }
        
        .staff-detail-value {
            flex: 1;
        }
        
        .staff-services-list {
            padding-left: 1.5rem;
            margin-bottom: 0;
        }
        
        .staff-services-list li {
            margin-bottom: 0.5rem;
        }
        
        .staff-bio {
            line-height: 1.6;
            color: var(--text-medium);
        }
        
        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--primary-light);
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Alert styles */
        .alert {
            padding: 1rem;
            border-radius: var(--border-radius-md);
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
        }
        
        .alert-warning {
            background-color: #fff3e0;
            color: #e65100;
        }
        
        .alert-info {
            background-color: #e3f2fd;
            color: #0d47a1;
        }
        
        .alert i {
            margin-top: 0.2rem;
        }
        
        /* Cebu region styles */
        .cebu-region {
            background-color: #e3f2fd;
            color: #0d47a1;
            font-weight: 500;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        
        .other-region {
            background-color: #f5f5f5;
            color: #757575 !important;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        
        /* Improved Marker Popup Styles */
        .marker-popup {
            padding: 0;
            font-family: 'Roboto', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .popup-header {
            background-color: #f8f9fa;
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            border-radius: 4px 4px 0 0;
        }

        .popup-title {
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            line-height: 1.3;
        }

        .popup-badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        .popup-badge.regional-office {
            background-color: #e3f2fd;
            color: #0d47a1;
        }

        .popup-badge.provincial-office {
            background-color: #e8f5e9;
            color: #1b5e20;
        }

        .popup-badge.field-office {
            background-color: #fff3e0;
            color: #e65100;
        }

        .popup-badge.extension-office {
            background-color: #f3e5f5;
            color: #6a1b9a;
        }
        
        .popup-badge.negosyo-center {
            background-color: #e8eaf6;
            color: #303f9f;
        }

        .popup-body {
            padding: 15px;
        }

        .popup-info {
            margin-bottom: 10px;
        }

        .popup-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 8px;
            font-size: 13px;
            line-height: 1.4;
        }

        .popup-info-item i {
            color: #666;
            margin-right: 8px;
            min-width: 16px;
            margin-top: 2px;
        }

        .popup-info-item span {
            flex: 1;
            color: #333;
        }

        .popup-footer {
            padding: 10px 15px 15px;
            display: flex;
            gap: 8px;
            justify-content: space-between;
        }

        .popup-btn {
            flex: 1;
            text-align: center;
            padding: 6px 12px;
            font-size: 13px;
        }

        /* Override Leaflet's default popup styles */
        .leaflet-popup-content-wrapper {
            padding: 0;
            border-radius: 6px;
            box-shadow: 0 3px 14px rgba(0,0,0,0.2);
        }

        .leaflet-popup-content {
            margin: 0;
            width: 280px !important;
        }

        .leaflet-popup-tip {
            box-shadow: 0 3px 14px rgba(0,0,0,0.2);
        }

        .office-popup .leaflet-popup-close-button {
            padding: 8px;
            font-size: 18px;
            color: #666;
        }

        .office-popup .leaflet-popup-close-button:hover {
            color: #333;
        }
        
        /* Custom NC marker styles */
        .nc-marker-icon {
            background-color: #1976D2;
            color: white;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            border: 2px solid white;
        }
        
        /* Ensure popups don't overlap other markers */
        .leaflet-popup {
            z-index: 1000 !important;
        }
        
        .leaflet-marker-icon {
            z-index: 900;
        }
        
        .leaflet-marker-icon.active {
            z-index: 950;
        }
        
        /* Guest mode indicator */
        .guest-mode-indicator {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            color: #555;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .guest-mode-indicator i {
            color: #1976D2;
        }
        
        .login-link {
            margin-left: 8px;
            color: #1976D2;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link:hover {
            text-decoration: underline;
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .staff-list {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                width: 300px;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .header-actions {
                width: 100%;
            }
            
            .btn {
                width: 100%;
            }
            
            .main-container {
                height: calc(100vh - 120px);
            }
            
                        .sidebar {
                position: absolute;
                height: 100%;
                width: 280px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
            }
            
            .sidebar:not(.collapsed) {
                transform: translateX(0);
            }
            
            .form-row {
                flex-direction: column;
            }
            
            .map-legend {
                bottom: 10px;
                left: 10px;
                padding: 8px 12px;
            }
            
            .legend-item {
                margin-bottom: 4px;
                font-size: 0.8rem;
            }
            
            .modal-content {
                width: 95%;
                margin: 1rem auto;
            }
            
            .staff-detail-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .logo {
                height: 40px;
            }
            
            .title-section h1 {
                font-size: 1.2rem;
                color: white !important;
            }
            
            .title-section p {
                font-size: 0.85rem;
            }
            
            .search-section, .office-list-section {
                padding: 1rem;
            }
            
            .search-section h3, .office-list-section h3 {
                font-size: 1rem;
            }
            
            .office-detail-image {
                height: 150px;
            }
            
            .office-detail-title {
                font-size: 1.2rem;
            }
            
            .info-section h4 {
                font-size: 1rem;
            }
            
            .staff-detail-photo, .staff-detail-photo-placeholder {
                width: 80px;
                height: 80px;
            }
            
            .staff-detail-name {
                font-size: 1.2rem;
            }
            
            .staff-detail-position {
                font-size: 0.9rem;
            }
            
            .guest-mode-indicator {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="img/logos.png" alt="DTI Logo" class="logo">
                <div class="title-section">
                    <h1>Department of Trade and Industry</h1>
                    <p>Cebu Province Office Locator System</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="login.php" class="btn btn-primary">
                    <i class="fas fa-user-lock"></i> Admin Login
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- Search Section -->
            <div class="search-section">
                <h3><i class="fas fa-search"></i> Find DTI Offices</h3>
                <div class="search-controls">
                    <input type="text" id="searchInput" placeholder="Search by office name or location..." class="search-input">
                    <div class="form-row">
                        <select id="cityFilter" class="filter-select">
                            <option value="">All Cities/Municipalities</option>
                            <option value="Cebu City">Cebu City</option>
                            <option value="Mandaue City">Mandaue City</option>
                            <option value="Lapu-Lapu City">Lapu-Lapu City</option>
                            <option value="Talisay City">Talisay City</option>
                            <option value="Danao City">Danao City</option>
                            <option value="Toledo City">Toledo City</option>
                            <option value="Bogo City">Bogo City</option>
                            <option value="Carcar City">Carcar City</option>
                            <option value="Naga City">Naga City</option>
                            <option value="Argao">Argao</option>
                            <option value="Dalaguete">Dalaguete</option>
                            <option value="Santander">Santander</option>
                            <option value="Balamban">Balamban</option>
                            <option value="Tuburan">Tuburan</option>
                            <option value="Liloan">Liloan</option>
                            <option value="Consolacion">Consolacion</option>
                            <option value="Compostela">Compostela</option>
                            <option value="San Remigio">San Remigio</option>
                            <option value="Medellin">Medellin</option>
                        </select>
                        <select id="officeTypeFilter" class="filter-select">
                            <option value="">All Office Types</option>
                            <option value="Regional Office">Regional Office</option>
                            <option value="Provincial Office">Provincial Office</option>
                            <option value="Field Office">Field Office</option>
                            <option value="Extension Office">Extension Office</option>
                            <option value="Negosyo Center">Negosyo Center</option>
                        </select>
                    </div>
                    <button class="btn btn-secondary" onclick="clearFilters()">
                        <i class="fas fa-times"></i> Clear Filters
                    </button>
                </div>
            </div>

            <!-- Office List -->
            <div class="office-list-section">
                <h3><i class="fas fa-list"></i> DTI Offices (<span id="officeCount">24</span>)</h3>
                <div id="officeListEmpty" style="display: none;">
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i>
                        <span>No offices found matching your search criteria. Try adjusting your filters.</span>
                    </div>
                </div>
                <div class="office-list" id="officeList">
                    <!-- Office items will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="map-container">
            <div class="map-controls">
                <button class="map-control-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="map-control-btn" onclick="resetMapView()" title="Reset Map View">
                    <i class="fas fa-home"></i>
                </button>
                <button class="map-control-btn" onclick="toggleFullscreen()" title="Toggle Fullscreen">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
            <div class="map" id="map"></div>
            <div class="map-legend">
                <h4>Map Legend</h4>
                <div class="legend-item">
                    <span class="legend-marker regional"></span>
                    <span>Regional Office</span>
                </div>
                <div class="legend-item">
                    <span class="legend-marker provincial"></span>
                    <span>Provincial Office</span>
                </div>
                <div class="legend-item">
                    <span class="legend-marker field"></span>
                    <span>Field Office</span>
                </div>
                <div class="legend-item">
                    <span class="legend-marker extension"></span>
                    <span>Extension Office</span>
                </div>
                <div class="legend-item">
                    <span class="legend-marker negosyo"></span>
                    <span>Negosyo Center</span>
                </div>
            </div>
            
            <!-- Guest mode indicator -->
            <div class="guest-mode-indicator">
                <i class="fas fa-user"></i>
                <span>Guest Mode</span>
                <a href="login.php" class="login-link">Login as Admin</a>
            </div>
        </div>
    </div>

    <!-- Office Details Modal -->
    <div class="modal" id="officeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Office Details</h2>
                <button class="modal-close" onclick="closeModal()" aria-label="Close modal">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Office details will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Staff Details Modal -->
    <div class="modal" id="staffDetailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="staffDetailsTitle">Staff Details</h2>
                <button class="modal-close" onclick="closeStaffDetailsModal()" aria-label="Close modal">&times;</button>
            </div>
            <div class="modal-body" id="staffDetailsBody">
                <!-- Staff details will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <p>Loading DTI Cebu Office Map...</p>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Map initialization with Cebu focus
        let map;
        let officeMarkers = [];
        
        // Cebu province boundaries (approximate)
        const CEBU_CENTER = [10.3157, 123.8854]; // Approximate center of Cebu City
        const MIN_ZOOM = 9;  // Minimum zoom level to restrict panning
        const MAX_ZOOM = 18; // Maximum zoom level
        const INITIAL_ZOOM = 10;
        
        // Cebu province bounds (approximate)
        const CEBU_BOUNDS = [
            [9.4, 123.0],  // Southwest corner
            [11.3, 124.5]  // Northeast corner
        ];
        
        // Initialize the map when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            
            // Hide loading overlay after map loads
            setTimeout(function() {
                document.getElementById('loadingOverlay').style.display = 'none';
            }, 1500);
            
            // Initialize search and filter functionality
            document.getElementById('searchInput').addEventListener('input', filterOffices);
            document.getElementById('cityFilter').addEventListener('change', filterOffices);
            document.getElementById('officeTypeFilter').addEventListener('change', filterOffices);
        });
        
        function initMap() {
            // Create the map centered on Cebu
            map = L.map('map', {
                center: CEBU_CENTER,
                zoom: INITIAL_ZOOM,
                minZoom: MIN_ZOOM,
                maxZoom: MAX_ZOOM,
                maxBounds: CEBU_BOUNDS,
                maxBoundsViscosity: 1.0 // Prevents the map from being dragged outside bounds
            });
            
            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                noWrap: true // Prevents the map from repeating across the x-axis
            }).addTo(map);
            
            // Add neighboring provinces with subtle styling
            addNeighboringProvinces();
            
            // Add office markers
            addOfficeMarkers();
        }
        
        function addNeighboringProvinces() {
            // Add neighboring provinces with very subtle gray styling
            const neighboringProvinces = [
                {
                    "type": "Feature",
                    "properties": {
                        "name": "Bohol Province",
                        "region": "Region VII"
                    },
                    "geometry": {
                        "type": "Polygon",
                        "coordinates": [[
                            [123.7, 9.5],
                            [124.5, 9.5],
                            [124.5, 10.2],
                            [123.7, 10.2],
                            [123.7, 9.5]
                        ]]
                    }
                },
                {
                    "type": "Feature",
                    "properties": {
                        "name": "Negros Oriental",
                        "region": "Region VII"
                    },
                    "geometry": {
                        "type": "Polygon",
                        "coordinates": [[
                            [122.8, 9.0],
                            [123.4, 9.0],
                            [123.4, 10.5],
                            [122.8, 10.5],
                            [122.8, 9.0]
                        ]]
                    }
                }
            ];
            
            // Add neighboring provinces with very subtle gray styling
            L.geoJSON(neighboringProvinces, {
                style: {
                    color: '#9e9e9e',
                    weight: 1,
                    opacity: 0.3,
                    fillColor: '#f5f5f5',
                    fillOpacity: 0.1
                }
            }).addTo(map);
        }
        
        function createNCMarkerIcon(officeType) {
            // Create a custom HTML element for the marker
            const markerHtml = document.createElement('div');
            markerHtml.className = 'nc-marker-icon';
            
            // Set background color based on office type
            let bgColor = '#1976D2'; // Default blue
            
            switch(officeType) {
                case 'Regional Office':
                    bgColor = '#1565C0'; // Darker blue
                    break;
                case 'Provincial Office':
                    bgColor = '#2E7D32'; // Green
                    break;
                case 'Field Office':
                    bgColor = '#EF6C00'; // Orange
                    break;
                case 'Extension Office':
                    bgColor = '#6A1B9A'; // Purple
                    break;
                case 'Negosyo Center':
                    bgColor = '#303F9F'; // Indigo for Negosyo Centers
                    break;
            }
            
            markerHtml.style.backgroundColor = bgColor;
            
            // Add NC text
            markerHtml.innerHTML = 'NC';
            
            // Create a custom divIcon
            return L.divIcon({
                html: markerHtml,
                className: 'custom-nc-marker',
                iconSize: [36, 36],
                iconAnchor: [18, 36],
                popupAnchor: [0, -36]
            });
        }
        
        function addOfficeMarkers() {
            // Sample office data for Cebu
            const offices = [
                // Main DTI Offices
                {
                    id: 1,
                    name: "DTI Region VII - Regional Office",
                    type: "Regional Office",
                                        lat: 10.3157,
                    lng: 123.8854,
                    address: "3F LDM Building, MJ Cuenco Avenue, Cebu City",
                    city: "Cebu City",
                    contact: "(032) 253-3926",
                    email: "region7@dti.gov.ph",
                    head: "Dir. Maria Elena Arbon",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The DTI Region VII Regional Office oversees all trade and industry activities within Central Visayas. It provides various services to businesses and consumers in Cebu, Bohol, Negros Oriental, and Siquijor.",
                    services: ["Business Name Registration", "Consumer Protection", "Trade Promotion", "MSME Development", "Export Assistance"],
                    staffCount: 3
                },
                {
                    id: 2,
                    name: "DTI Cebu Provincial Office",
                    type: "Provincial Office",
                    lat: 10.3116,
                    lng: 123.9120,
                    address: "4F Robinsons Galleria Cebu, Gen. Maxilom Ave., Cebu City",
                    city: "Cebu City",
                    contact: "(032) 255-6971",
                    email: "cebu@dti.gov.ph",
                    head: "Dir. Rose Mae Quiñanola",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The DTI Cebu Provincial Office serves businesses and consumers in Cebu Province, providing various services to support local economic development.",
                    services: ["Business Name Registration", "Consumer Protection", "MSME Development", "Negosyo Center Services"],
                    staffCount: 5
                },
                {
                    id: 3,
                    name: "DTI Mandaue Field Office",
                    type: "Field Office",
                    lat: 10.3231,
                    lng: 123.9400,
                    address: "2F Mandaue City Hall, North Reclamation Area, Mandaue City",
                    city: "Mandaue City",
                    contact: "(032) 346-7252",
                    email: "mandaue@dti.gov.ph",
                    head: "Mr. John Santos",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The DTI Mandaue Field Office provides services to businesses and consumers in Mandaue City, focusing on local economic development and consumer protection.",
                    services: ["Business Name Registration", "Consumer Complaints", "MSME Development", "Business Advisory"],
                    staffCount: 2
                },
                {
                    id: 4,
                    name: "DTI Lapu-Lapu Extension Office",
                    type: "Extension Office",
                    lat: 10.3100,
                    lng: 123.9500,
                    address: "1F Lapu-Lapu City Hall, Pajo, Lapu-Lapu City",
                    city: "Lapu-Lapu City",
                    contact: "(032) 340-1456",
                    email: "lapulapu@dti.gov.ph",
                    head: "Ms. Elena Gomez",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The DTI Lapu-Lapu Extension Office serves businesses and consumers in Lapu-Lapu City, providing support for local entrepreneurs and ensuring consumer protection.",
                    services: ["Business Name Registration", "Consumer Protection", "MSME Development", "Export Assistance"],
                    staffCount: 2
                },
                {
                    id: 5,
                    name: "DTI Toledo Field Office",
                    type: "Field Office",
                    lat: 10.3780,
                    lng: 123.6420,
                    address: "Toledo City Hall Complex, Poblacion, Toledo City",
                    city: "Toledo City",
                    contact: "(032) 322-5868",
                    email: "toledo@dti.gov.ph",
                    head: "Ms. Patricia Mendoza",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The DTI Toledo Field Office serves businesses and consumers in Toledo City and nearby municipalities in western Cebu.",
                    services: ["Business Name Registration", "Consumer Protection", "MSME Development"],
                    staffCount: 2
                },
                {
                    id: 6,
                    name: "DTI Bogo Extension Office",
                    type: "Extension Office",
                    lat: 10.9822,
                    lng: 124.0021,
                    address: "Bogo City Hall, P. Rodriguez St., Bogo City",
                    city: "Bogo City",
                    contact: "(032) 251-2491",
                    email: "bogo@dti.gov.ph",
                    head: "Mr. Roberto Reyes",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The DTI Bogo Extension Office provides services to businesses and consumers in Bogo City and northern Cebu municipalities.",
                    services: ["Business Name Registration", "Consumer Protection", "MSME Development"],
                    staffCount: 1
                },
                
                // Negosyo Centers
                {
                    id: 7,
                    name: "Cebu City Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.2977,
                    lng: 123.9021,
                    address: "Ground Floor, SM City Cebu, North Reclamation Area, Cebu City",
                    city: "Cebu City",
                    contact: "(032) 254-7987",
                    email: "nccebu@dti.gov.ph",
                    head: "Ms. Anna Liza Patalinghug",
                    hours: "10:00 AM - 7:00 PM, Monday to Saturday",
                    description: "The Cebu City Negosyo Center provides business development services to MSMEs in Cebu City, helping entrepreneurs start and grow their businesses.",
                    services: ["Business Registration Assistance", "Business Advisory", "Access to Financing", "Market Linkage", "Business Skills Training"],
                    staffCount: 3
                },
                {
                    id: 8,
                    name: "Mandaue City Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.3344,
                    lng: 123.9428,
                    address: "J Centre Mall, A.S. Fortuna St., Mandaue City",
                    city: "Mandaue City",
                    contact: "(032) 346-0032",
                    email: "ncmandaue@dti.gov.ph",
                    head: "Mr. Carlos Villanueva",
                    hours: "9:00 AM - 6:00 PM, Monday to Friday",
                    description: "The Mandaue City Negosyo Center supports MSMEs in Mandaue City by providing business development services and facilitating access to government programs.",
                    services: ["Business Registration Assistance", "Business Advisory", "Access to Financing", "Market Linkage"],
                    staffCount: 2
                },
                {
                    id: 9,
                    name: "Lapu-Lapu City Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.3132,
                    lng: 123.9594,
                    address: "Gaisano Grand Mall Mactan, Basak, Lapu-Lapu City",
                    city: "Lapu-Lapu City",
                    contact: "(032) 495-2321",
                    email: "nclapulapu@dti.gov.ph",
                    head: "Ms. Joanna Cruz",
                    hours: "9:00 AM - 6:00 PM, Monday to Friday",
                    description: "The Lapu-Lapu City Negosyo Center assists MSMEs in Lapu-Lapu City, particularly focusing on export-oriented businesses and tourism-related enterprises.",
                    services: ["Business Registration Assistance", "Business Advisory", "Export Assistance", "Tourism Enterprise Development"],
                    staffCount: 2
                },
                {
                    id: 10,
                    name: "Talisay City Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.2447,
                    lng: 123.8500,
                    address: "Talisay City Hall Complex, Lawaan III, Talisay City",
                    city: "Talisay City",
                    contact: "(032) 272-3098",
                    email: "nctalisay@dti.gov.ph",
                    head: "Mr. Eduardo Lim",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Talisay City Negosyo Center provides business development services to MSMEs in Talisay City, helping entrepreneurs start and grow their businesses.",
                    services: ["Business Registration Assistance", "Business Advisory", "Access to Financing", "Skills Training"],
                    staffCount: 2
                },
                {
                    id: 11,
                    name: "Bogo City Negosyo Center",
                    type: "Negosyo Center",
                    lat: 11.0430,
                    lng: 123.9850,
                    address: "Bogo City Hall Complex, P. Rodriguez St., Bogo City",
                    city: "Bogo City",
                    contact: "(032) 251-2495",
                    email: "ncbogo@dti.gov.ph",
                    head: "Ms. Maria Theresa Ramos",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Bogo City Negosyo Center serves entrepreneurs in Bogo City and northern Cebu, providing business development services and assistance.",
                    services: ["Business Registration Assistance", "Business Advisory", "Access to Financing", "Skills Training"],
                    staffCount: 1
                },
                {
                    id: 12,
                    name: "Danao City Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.5580,
                    lng: 124.0240,
                    address: "Danao City Hall, Poblacion, Danao City",
                    city: "Danao City",
                    contact: "(032) 200-3423",
                    email: "ncdanao@dti.gov.ph",
                    head: "Mr. Joseph Tan",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Danao City Negosyo Center provides business development services to MSMEs in Danao City, focusing on manufacturing and industrial enterprises.",
                    services: ["Business Registration Assistance", "Business Advisory", "Manufacturing Support", "Skills Training"],
                    staffCount: 1
                },
                {
                    id: 13,
                    name: "San Remigio Negosyo Center",
                    type: "Negosyo Center",
                    lat: 11.0050,
                    lng: 123.9420,
                    address: "San Remigio Municipal Hall, Poblacion, San Remigio",
                    city: "San Remigio",
                    contact: "(032) 435-9090",
                    email: "ncsanremigio@dti.gov.ph",
                    head: "Ms. Angelica Flores",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The San Remigio Negosyo Center assists local entrepreneurs in San Remigio, particularly focusing on tourism-related businesses and agricultural enterprises.",
                    services: ["Business Registration Assistance", "Tourism Enterprise Development", "Agricultural Business Support"],
                    staffCount: 1
                },
                {
                    id: 14,
                    name: "Medellin Negosyo Center",
                    type: "Negosyo Center",
                    lat: 11.1290,
                    lng: 123.9650,
                    address: "Medellin Municipal Hall, Poblacion, Medellin",
                    city: "Medellin",
                    contact: "(032) 436-0512",
                    email: "ncmedellin@dti.gov.ph",
                    head: "Mr. Ricardo Santos",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Medellin Negosyo Center provides business development services to MSMEs in Medellin, with a focus on agricultural enterprises and food processing businesses.",
                    services: ["Business Registration Assistance", "Agricultural Business Support", "Food Processing Development"],
                    staffCount: 1
                },
                {
                    id: 15,
                    name: "Carcar City Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.1060,
                    lng: 123.6420,
                    address: "Carcar City Hall Complex, Poblacion III, Carcar City",
                    city: "Carcar City",
                    contact: "(032) 487-7425",
                    email: "nccarcar@dti.gov.ph",
                    head: "Ms. Lourdes Villanueva",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Carcar City Negosyo Center assists local entrepreneurs in Carcar City, particularly focusing on shoe manufacturing, food processing, and tourism-related businesses.",
                    services: ["Business Registration Assistance", "Product Development", "Market Access", "Skills Training"],
                    staffCount: 1
                },
                {
                    id: 16,
                    name: "Argao Negosyo Center",
                    type: "Negosyo Center",
                    lat: 9.8830,
                    lng: 123.6080,
                    address: "Argao Municipal Hall, Poblacion, Argao",
                    city: "Argao",
                    contact: "(032) 367-7539",
                    email: "ncargao@dti.gov.ph",
                    head: "Mr. Antonio Reyes",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Argao Negosyo Center provides business development services to MSMEs in Argao, focusing on food processing, handicrafts, and tourism-related enterprises.",
                    services: ["Business Registration Assistance", "Product Development", "Market Access", "Tourism Enterprise Development"],
                    staffCount: 1
                },
                {
                    id: 17,
                    name: "Dalaguete Negosyo Center",
                    type: "Negosyo Center",
                    lat: 9.7620,
                    lng: 123.5350,
                    address: "Dalaguete Municipal Hall, Poblacion, Dalaguete",
                    city: "Dalaguete",
                    contact: "(032) 484-8173",
                    email: "ncdalaguete@dti.gov.ph",
                    head: "Ms. Cristina Bautista",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                                        description: "The Dalaguete Negosyo Center assists local entrepreneurs in Dalaguete, particularly focusing on agricultural enterprises and tourism-related businesses.",
                    services: ["Business Registration Assistance", "Agricultural Business Support", "Tourism Enterprise Development"],
                    staffCount: 1
                },
                {
                    id: 18,
                    name: "Santander Negosyo Center",
                    type: "Negosyo Center",
                    lat: 9.4280,
                    lng: 123.3400,
                    address: "Santander Municipal Hall, Poblacion, Santander",
                    city: "Santander",
                    contact: "(032) 480-9174",
                    email: "ncsantander@dti.gov.ph",
                    head: "Mr. Fernando Diaz",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Santander Negosyo Center provides business development services to MSMEs in Santander, with a focus on tourism-related businesses and marine product enterprises.",
                    services: ["Business Registration Assistance", "Tourism Enterprise Development", "Marine Product Development"],
                    staffCount: 1
                },
                {
                    id: 19,
                    name: "Toledo City Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.3760,
                    lng: 123.6500,
                    address: "Toledo City Hall Complex, Poblacion, Toledo City",
                    city: "Toledo City",
                    contact: "(032) 322-5871",
                    email: "nctoledo@dti.gov.ph",
                    head: "Ms. Rosario Mendez",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Toledo City Negosyo Center assists local entrepreneurs in Toledo City, particularly focusing on mining-related businesses and agricultural enterprises.",
                    services: ["Business Registration Assistance", "Business Advisory", "Skills Training", "Market Access"],
                    staffCount: 1
                },
                {
                    id: 20,
                    name: "Balamban Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.4920,
                    lng: 123.7720,
                    address: "Balamban Municipal Hall, Poblacion, Balamban",
                    city: "Balamban",
                    contact: "(032) 465-9090",
                    email: "ncbalamban@dti.gov.ph",
                    head: "Mr. Ernesto Lim",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Balamban Negosyo Center provides business development services to MSMEs in Balamban, focusing on shipbuilding-related businesses and manufacturing enterprises.",
                    services: ["Business Registration Assistance", "Manufacturing Support", "Skills Training", "Market Access"],
                    staffCount: 1
                },
                {
                    id: 21,
                    name: "Tuburan Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.7230,
                    lng: 123.8250,
                    address: "Tuburan Municipal Hall, Poblacion, Tuburan",
                    city: "Tuburan",
                    contact: "(032) 463-8156",
                    email: "nctuburan@dti.gov.ph",
                    head: "Ms. Maricel Santos",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Tuburan Negosyo Center assists local entrepreneurs in Tuburan, particularly focusing on agricultural enterprises and food processing businesses.",
                    services: ["Business Registration Assistance", "Agricultural Business Support", "Food Processing Development"],
                    staffCount: 1
                },
                {
                    id: 22,
                    name: "Liloan Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.4000,
                    lng: 123.9950,
                    address: "Liloan Municipal Hall, Poblacion, Liloan",
                    city: "Liloan",
                    contact: "(032) 564-3251",
                    email: "ncliloan@dti.gov.ph",
                    head: "Mr. Javier Reyes",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Liloan Negosyo Center provides business development services to MSMEs in Liloan, focusing on manufacturing and tourism-related enterprises.",
                    services: ["Business Registration Assistance", "Business Advisory", "Tourism Enterprise Development"],
                    staffCount: 1
                },
                {
                    id: 23,
                    name: "Consolacion Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.3730,
                    lng: 123.9580,
                    address: "Consolacion Municipal Hall, Poblacion Oriental, Consolacion",
                    city: "Consolacion",
                    contact: "(032) 564-2314",
                    email: "ncconsolacion@dti.gov.ph",
                    head: "Ms. Teresa Lim",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Consolacion Negosyo Center assists local entrepreneurs in Consolacion, particularly focusing on retail and service-oriented businesses.",
                    services: ["Business Registration Assistance", "Business Advisory", "Skills Training", "Market Access"],
                    staffCount: 1
                },
                {
                    id: 24,
                    name: "Compostela Negosyo Center",
                    type: "Negosyo Center",
                    lat: 10.4580,
                    lng: 124.0120,
                    address: "Compostela Municipal Hall, Poblacion, Compostela",
                    city: "Compostela",
                    contact: "(032) 425-8377",
                    email: "nccompostela@dti.gov.ph",
                    head: "Mr. Ramon Garcia",
                    hours: "8:00 AM - 5:00 PM, Monday to Friday",
                    description: "The Compostela Negosyo Center provides business development services to MSMEs in Compostela, focusing on manufacturing and agricultural enterprises.",
                    services: ["Business Registration Assistance", "Manufacturing Support", "Agricultural Business Support"],
                    staffCount: 1
                }
            ];
            
            // Clear existing markers
            officeMarkers.forEach(marker => map.removeLayer(marker));
            officeMarkers = [];
            
            // Add markers for each office
            offices.forEach(office => {
                // Create custom NC marker icon
                const markerIcon = createNCMarkerIcon(office.type);
                
                // Get badge class based on office type
                let badgeClass = 'regional-office';
                switch(office.type) {
                    case 'Provincial Office':
                        badgeClass = 'provincial-office';
                        break;
                    case 'Field Office':
                        badgeClass = 'field-office';
                        break;
                    case 'Extension Office':
                        badgeClass = 'extension-office';
                        break;
                    case 'Negosyo Center':
                        badgeClass = 'negosyo-center';
                        break;
                }
                
                // Create improved popup content with better formatting
                const popupContent = `
                    <div class="marker-popup">
                        <div class="popup-header">
                            <h3 class="popup-title">${office.name}</h3>
                            <span class="popup-badge ${badgeClass}">${office.type}</span>
                        </div>
                        <div class="popup-body">
                            <div class="popup-info">
                                <div class="popup-info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>${office.address}</span>
                                </div>
                                <div class="popup-info-item">
                                    <i class="fas fa-phone"></i>
                                    <span>${office.contact}</span>
                                </div>
                            </div>
                        </div>
                        <div class="popup-footer">
                            <button class="btn btn-primary popup-btn" onclick="viewOfficeDetails(${office.id})">
                                <i class="fas fa-info-circle"></i> View Details
                            </button>
                        </div>
                    </div>
                `;
                
                const marker = L.marker([office.lat, office.lng], {icon: markerIcon})
                    .addTo(map)
                    .bindPopup(popupContent, {
                        maxWidth: 300,
                        minWidth: 280,
                        className: 'office-popup',
                        autoPanPadding: [50, 50],
                        offset: [0, -20]
                    });
                
                // Store reference to marker and office data
                marker.officeId = office.id;
                marker.officeData = office;
                officeMarkers.push(marker);
                
                // Add click event to zoom to office
                marker.on('click', function() {
                    // Make this marker appear on top of others
                    this._icon.classList.add('active');
                    
                    // Remove active class from other markers
                    officeMarkers.forEach(m => {
                        if (m !== this && m._icon) {
                            m._icon.classList.remove('active');
                        }
                    });
                    
                    zoomToOffice(office.lat, office.lng);
                });
                
                // Create office list item
                createOfficeListItem(office);
            });
            
            // Update office count
            document.getElementById('officeCount').textContent = offices.length;
        }
        
        function createOfficeListItem(office) {
            const officeList = document.getElementById('officeList');
            
            // Create office item element
            const officeItem = document.createElement('div');
            officeItem.className = 'office-item';
            officeItem.setAttribute('data-id', office.id);
            officeItem.setAttribute('data-name', office.name.toLowerCase());
            officeItem.setAttribute('data-type', office.type);
            officeItem.setAttribute('data-city', office.city);
            officeItem.setAttribute('data-address', office.address.toLowerCase());
            
            // Add click event to view office details
            officeItem.addEventListener('click', function() {
                viewOfficeDetails(office.id);
            });
            
            // Create office item HTML
            officeItem.innerHTML = `
                <div class="office-header">
                    <div class="office-name">${office.name}</div>
                    <div class="office-type">${office.type}</div>
                </div>
                <div class="office-region cebu-region">${office.city}</div>
                <div class="office-address">${office.address}</div>
                <div class="office-actions">
                    <button class="btn btn-primary" onclick="viewOfficeDetails(${office.id}); event.stopPropagation();">
                        <i class="fas fa-info-circle"></i> View Details
                    </button>
                </div>
            `;
            
            // Add to office list
            officeList.appendChild(officeItem);
        }
        
        function zoomToOffice(lat, lng) {
            // Zoom to the selected office
            map.setView([lat, lng], 16, {
                animate: true,
                duration: 1
            });
        }
        
        function resetMapView() {
            // Reset to default view of Cebu
            map.setView(CEBU_CENTER, INITIAL_ZOOM, {
                animate: true,
                duration: 1
            });
            
            // Close any open popups
            map.closePopup();
            
            // Remove active class from all markers
            officeMarkers.forEach(m => {
                if (m._icon) {
                    m._icon.classList.remove('active');
                }
            });
        }
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            
            // Update map size after sidebar toggle
            setTimeout(function() {
                map.invalidateSize();
            }, 300);
        }
        
        function toggleFullscreen() {
            const mapContainer = document.querySelector('.map-container');
            
            if (!document.fullscreenElement) {
                mapContainer.requestFullscreen().catch(err => {
                    console.error(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }
        
        function viewOfficeDetails(officeId) {
            // Find the office marker and zoom to it
            const marker = officeMarkers.find(m => m.officeId === officeId);
            if (marker) {
                const position = marker.getLatLng();
                const office = marker.officeData;
                
                // Zoom to the office location
                zoomToOffice(position.lat, position.lng);
                
                // Make this marker appear on top of others
                if (marker._icon) {
                    marker._icon.classList.add('active');
                    
                    // Remove active class from other markers
                    officeMarkers.forEach(m => {
                        if (m !== marker && m._icon) {
                            m._icon.classList.remove('active');
                        }
                    });
                }
                
                // Build services list HTML
                let servicesHtml = '';
                if (office.services && office.services.length > 0) {
                    servicesHtml = office.services.map(service => `<li>${service}</li>`).join('');
                } else {
                    servicesHtml = '<li>No specific services listed.</li>';
                }
                
                // Build office details HTML
                const officeDetailsHtml = `
                    <div class="office-detail-grid">
                        <div class="office-detail-header">
                            <img src="img/sample-office.jpg" alt="${office.name}" class="office-detail-image">
                            <h3 class="office-detail-title">${office.name}</h3>
                            <div class="office-detail-badges">
                                <span class="badge badge-primary">${office.type}</span>
                                <span class="badge badge-warning">${office.city}</span>
                            </div>
                        </div>
                        
                        <div class="office-detail-info">
                            <div class="info-section">
                                <h4><i class="fas fa-map-marker-alt"></i> Location Information</h4>
                                <div class="info-item">
                                    <i class="fas fa-building"></i>
                                    <div>
                                        <strong>Address:</strong>
                                        <div>${office.address}</div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-phone"></i>
                                    <div>
                                        <strong>Contact Number:</strong>
                                        <div>${office.contact}</div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                                                                <strong>Email:</strong>
                                        <div>${office.email}</div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <strong>Office Hours:</strong>
                                        <div>${office.hours}</div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-user-tie"></i>
                                    <div>
                                        <strong>Office Head:</strong>
                                        <div>${office.head}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-section">
                                <h4><i class="fas fa-info-circle"></i> About the Office</h4>
                                <p>${office.description}</p>
                            </div>
                            
                            <div class="info-section">
                                <h4><i class="fas fa-briefcase"></i> Services Offered</h4>
                                <ul>
                                    ${servicesHtml}
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Staff Section -->
                        <div class="office-staff-section" id="officeStaffSection">
                            <div class="staff-section-header">
                                <h3><i class="fas fa-users"></i> Office Staff (${office.staffCount})</h3>
                            </div>
                            
                            <div class="staff-list" id="staffList">
                                ${getStaffListHtml(officeId)}
                            </div>
                        </div>
                    </div>
                `;
                
                // Update modal content
                document.getElementById('modalTitle').textContent = office.name;
                document.getElementById('modalBody').innerHTML = officeDetailsHtml;
            }
            
            // Show office details modal
            document.getElementById('officeModal').style.display = 'block';
        }
        
        function getStaffListHtml(officeId) {
            // Sample staff data (in a real app, this would come from the server)
            const staffData = {
                // Regional Office Staff
                1: [
                    {
                        id: 1,
                        name: "Maria Santos",
                        position: "Division Chief, Business Development",
                        type: "NC Type A",
                        contact: "(032) 253-3926 loc. 101",
                        email: "maria.santos@dti.gov.ph",
                        photo: "img/sample-staff1.jpg",
                        services: ["Business Name Registration", "MSME Development", "Business Advisory", "Entrepreneurship Training"],
                        bio: "Maria Santos has been with DTI for over 10 years, specializing in business development and MSME support. She holds a Master's degree in Business Administration from the University of San Carlos and has extensive experience in helping small businesses grow and succeed in competitive markets."
                    },
                    {
                        id: 2,
                        name: "Roberto Reyes",
                        position: "Consumer Protection Officer",
                        type: "NC Type B",
                        contact: "(032) 253-3926 loc. 102",
                        email: "roberto.reyes@dti.gov.ph",
                        photo: "",
                        services: ["Consumer Complaints", "Product Standards", "Price Monitoring", "Fair Trade Laws Enforcement"],
                        bio: "Roberto Reyes has been working with DTI's Consumer Protection Group for 5 years. He specializes in handling consumer complaints and ensuring businesses comply with fair trade laws and product standards. He has a background in Law from the University of the Philippines."
                    },
                    {
                        id: 3,
                        name: "Elena Cruz",
                        position: "MSME Development Specialist",
                        type: "NC Type A",
                        contact: "(032) 253-3926 loc. 103",
                        email: "elena.cruz@dti.gov.ph",
                        photo: "img/sample-staff3.jpg",
                        services: ["MSME Development", "Business Mentoring", "Access to Finance", "Market Access Programs"],
                        bio: "Elena Cruz is an expert in MSME development with over 8 years of experience at DTI. She has helped hundreds of small businesses access financing, improve their operations, and expand to new markets. She holds a degree in Business Economics from the University of Cebu."
                    }
                ],
                // Provincial Office Staff
                2: [
                    {
                        id: 4,
                        name: "Juan Dela Cruz",
                        position: "Provincial Director",
                        type: "NC Type A",
                        contact: "(032) 255-6971 loc. 201",
                        email: "juan.delacruz@dti.gov.ph",
                        photo: "img/sample-staff4.jpg",
                        services: ["Business Development", "Investment Promotion", "Trade Facilitation"],
                        bio: "Juan Dela Cruz has been serving as the Provincial Director for 5 years. He has implemented numerous programs to support MSMEs in Cebu Province and has established strong partnerships with local government units and private sector organizations."
                    },
                    {
                        id: 5,
                        name: "Ana Reyes",
                        position: "Business Development Specialist",
                        type: "NC Type A",
                        contact: "(032) 255-6971 loc. 202",
                        email: "ana.reyes@dti.gov.ph",
                        photo: "img/sample-staff5.jpg",
                        services: ["Business Advisory", "Entrepreneurship Training", "Market Development"],
                        bio: "Ana Reyes specializes in business development and entrepreneurship training. She has conducted numerous workshops and seminars for MSMEs across Cebu Province, helping entrepreneurs improve their business skills and strategies."
                    },
                    {
                        id: 6,
                        name: "Pedro Santos",
                        position: "Consumer Protection Officer",
                        type: "NC Type B",
                        contact: "(032) 255-6971 loc. 203",
                        email: "pedro.santos@dti.gov.ph",
                        photo: "",
                        services: ["Consumer Complaints", "Product Standards", "Price Monitoring"],
                        bio: "Pedro Santos handles consumer protection concerns in Cebu Province. He ensures that businesses comply with fair trade laws and product standards, and addresses consumer complaints promptly and effectively."
                    },
                    {
                        id: 7,
                        name: "Maria Garcia",
                        position: "Trade Promotion Officer",
                        type: "NC Type B",
                        contact: "(032) 255-6971 loc. 204",
                        email: "maria.garcia@dti.gov.ph",
                        photo: "img/sample-staff7.jpg",
                        services: ["Trade Fairs", "Export Assistance", "Market Linkage"],
                        bio: "Maria Garcia organizes trade fairs and exhibitions to promote Cebu products locally and internationally. She also assists exporters in accessing new markets and complying with export requirements."
                    },
                    {
                        id: 8,
                        name: "Carlos Lim",
                        position: "MSME Development Officer",
                        type: "NC Type A",
                        contact: "(032) 255-6971 loc. 205",
                        email: "carlos.lim@dti.gov.ph",
                        photo: "",
                        services: ["Business Advisory", "Access to Finance", "Business Plan Development"],
                        bio: "Carlos Lim specializes in MSME development, helping small businesses access financing, improve their operations, and develop sound business plans. He has a background in Finance and has worked with various financial institutions before joining DTI."
                    }
                ],
                // Other offices with fewer staff
                3: [
                    {
                        id: 9,
                        name: "Javier Reyes",
                        position: "Field Office Head",
                        type: "NC Type A",
                        contact: "(032) 346-7252",
                        email: "javier.reyes@dti.gov.ph",
                        photo: "img/sample-staff9.jpg",
                        services: ["Business Registration", "Consumer Protection", "MSME Development"],
                        bio: "Javier Reyes leads the Mandaue Field Office, overseeing all DTI programs and services in Mandaue City. He has been with DTI for 7 years and has extensive experience in business development and consumer protection."
                    },
                    {
                        id: 10,
                        name: "Sophia Tan",
                        position: "Business Counselor",
                        type: "NC Type B",
                        contact: "(032) 346-7252",
                        email: "sophia.tan@dti.gov.ph",
                        photo: "",
                        services: ["Business Advisory", "Entrepreneurship Training", "Market Development"],
                        bio: "Sophia Tan provides business counseling and advisory services to MSMEs in Mandaue City. She conducts regular entrepreneurship training programs and helps businesses access new markets."
                    }
                ],
                4: [
                    {
                        id: 11,
                        name: "Elena Gomez",
                        position: "Extension Office Head",
                        type: "NC Type A",
                        contact: "(032) 340-1456",
                        email: "elena.gomez@dti.gov.ph",
                        photo: "img/sample-staff11.jpg",
                        services: ["Business Registration", "Export Assistance", "MSME Development"],
                        bio: "Elena Gomez leads the Lapu-Lapu Extension Office, focusing on supporting export-oriented businesses and tourism-related enterprises in Lapu-Lapu City. She has been with DTI for 6 years and has a background in International Business."
                    },
                    {
                        id: 12,
                        name: "Marco Diaz",
                        position: "Business Development Officer",
                        type: "NC Type B",
                        contact: "(032) 340-1456",
                        email: "marco.diaz@dti.gov.ph",
                        photo: "",
                        services: ["Business Advisory", "Tourism Enterprise Development", "Market Access"],
                        bio: "Marco Diaz specializes in tourism enterprise development and market access. He helps businesses in Lapu-Lapu City improve their products and services to meet the needs of tourists and export markets."
                    }
                ],
                // Add staff for other offices as needed
                5: [
                    {
                        id: 13,
                        name: "Patricia Mendoza",
                        position: "Field Office Head",
                        type: "NC Type A",
                        contact: "(032) 322-5868",
                        email: "patricia.mendoza@dti.gov.ph",
                        photo: "",
                        services: ["Business Registration", "Consumer Protection", "MSME Development"],
                        bio: "Patricia Mendoza leads the Toledo Field Office, overseeing all DTI programs and services in Toledo City. She has been with DTI for 5 years and has a background in Business Administration."
                    },
                    {
                        id: 14,
                        name: "Ricardo Flores",
                        position: "Business Development Officer",
                        type: "NC Type B",
                        contact: "(032) 322-5868",
                        email: "ricardo.flores@dti.gov.ph",
                        photo: "",
                        services: ["Business Advisory", "Entrepreneurship Training", "Market Development"],
                        bio: "Ricardo Flores provides business development services to MSMEs in Toledo City. He specializes in helping businesses in the mining and agricultural sectors improve their operations and access new markets."
                    }
                ],
                6: [
                    {
                        id: 15,
                        name: "Roberto Reyes",
                        position: "Extension Office Head",
                        type: "NC Type A",
                        contact: "(032) 251-2491",
                        email: "roberto.reyes@dti.gov.ph",
                        photo: "",
                        services: ["Business Registration", "Consumer Protection", "MSME Development"],
                        bio: "Roberto Reyes leads the Bogo Extension Office, providing DTI services to businesses and consumers in Bogo City and northern Cebu. He has been with DTI for 4 years and has a background in Public Administration."
                    }
                ],
                // Sample staff for Negosyo Centers
                7: [
                    {
                        id: 16,
                        name: "Anna Liza Patalinghug",
                        position: "Negosyo Center Business Counselor",
                        type: "NC Type A",
                        contact: "(032) 254-7987",
                        email: "anna.patalinghug@dti.gov.ph",
                        photo: "img/sample-staff16.jpg",
                        services: ["Business Registration Assistance", "Business Advisory", "Access to Financing"],
                        bio: "Anna Liza Patalinghug has been managing the Cebu City Negosyo Center for 3 years. She has extensive experience in business counseling and has helped hundreds of entrepreneurs start and grow their businesses."
                    },
                    {
                        id: 17,
                        name: "Michael Tan",
                        position: "Business Development Officer",
                        type: "NC Type B",
                        contact: "(032) 254-7987",
                        email: "michael.tan@dti.gov.ph",
                        photo: "",
                        services: ["Entrepreneurship Training", "Market Linkage", "Business Plan Development"],
                        bio: "Michael Tan conducts entrepreneurship training programs and helps businesses develop sound business plans. He also facilitates market linkages for MSMEs in Cebu City."
                    },
                    {
                        id: 18,
                        name: "Sophia Garcia",
                        position: "Information Officer",
                        type: "NC Type B",
                        contact: "(032) 254-7987",
                        email: "sophia.garcia@dti.gov.ph",
                        photo: "",
                        services: ["Information Dissemination", "Client Assistance", "Documentation"],
                        bio: "Sophia Garcia provides information on DTI programs and services to clients of the Cebu City Negosyo Center. She also assists in documenting the center's activities and success stories."
                    }
                ],
                8: [
                    {
                        id: 19,
                        name: "Carlos Villanueva",
                        position: "Negosyo Center Business Counselor",
                        type: "NC Type A",
                        contact: "(032) 346-0032",
                        email: "carlos.villanueva@dti.gov.ph",
                        photo: "",
                        services: ["Business Registration Assistance", "Business Advisory", "Access to Financing"],
                        bio: "Carlos Villanueva manages the Mandaue City Negosyo Center, providing business development services to MSMEs in Mandaue City. He has a background in Business Administration and has been with DTI for 4 years."
                    },
                    {
                        id: 20,
                        name: "Lourdes Santos",
                        position: "Business Development Officer",
                        type: "NC Type B",
                        contact: "(032) 346-0032",
                        email: "lourdes.santos@dti.gov.ph",
                        photo: "img/sample-staff20.jpg",
                        services: ["Entrepreneurship Training", "Market Linkage", "Business Plan Development"],
                        bio: "Lourdes Santos specializes in entrepreneurship training and market linkage. She helps businesses in Mandaue City improve their operations and access new markets."
                    }
                ]
                // Add more staff for other offices as needed
            };
            
                        // Get staff for the selected office
            const officeStaff = staffData[officeId] || [];
            
            if (officeStaff.length === 0) {
                return `<div class="alert alert-info">No staff information available for this office.</div>`;
            }
            
            // Build staff list HTML
            let staffListHtml = '';
            officeStaff.forEach(staff => {
                // Determine photo HTML
                let photoHtml = '';
                if (staff.photo) {
                    photoHtml = `<img src="${staff.photo}" alt="${staff.name}" class="staff-photo">`;
                } else {
                    photoHtml = `
                        <div class="staff-photo-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    `;
                }
                
                staffListHtml += `
                    <div class="staff-card" data-id="${staff.id}">
                        <div class="staff-header">
                            ${photoHtml}
                            <div class="staff-name-section">
                                <h4 class="staff-name">${staff.name}</h4>
                                <div class="staff-position">${staff.position}</div>
                                <span class="staff-type staff-type-${staff.type.includes('Type A') ? 'a' : 'b'}">${staff.type}</span>
                            </div>
                        </div>
                        <div class="staff-body">
                            <div class="staff-info">
                                <div class="staff-info-item">
                                    <i class="fas fa-phone"></i>
                                    <span>${staff.contact}</span>
                                </div>
                                <div class="staff-info-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>${staff.email}</span>
                                </div>
                            </div>
                            <div class="staff-actions">
                                <button class="btn btn-primary" onclick="viewStaffDetails(${staff.id}); event.stopPropagation();">
                                    <i class="fas fa-info-circle"></i> View Details
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            return staffListHtml;
        }
        
        function closeModal() {
            document.getElementById('officeModal').style.display = 'none';
        }
        
        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('cityFilter').value = '';
            document.getElementById('officeTypeFilter').value = '';
            
            // Reset the office list display
            filterOffices();
        }
        
        function filterOffices() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const cityFilter = document.getElementById('cityFilter').value;
            const typeFilter = document.getElementById('officeTypeFilter').value;
            
            // Get all office items
            const officeItems = document.querySelectorAll('.office-item');
            let visibleCount = 0;
            
            // Filter office items
            officeItems.forEach(item => {
                const officeName = item.getAttribute('data-name');
                const officeType = item.getAttribute('data-type');
                const officeCity = item.getAttribute('data-city');
                const officeAddress = item.getAttribute('data-address');
                
                // Check if office matches all filters
                const matchesSearch = officeName.includes(searchTerm) || officeAddress.includes(searchTerm);
                const matchesCity = !cityFilter || officeCity.includes(cityFilter);
                const matchesType = !typeFilter || officeType === typeFilter;
                
                // Show or hide based on filter results
                if (matchesSearch && matchesCity && matchesType) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Update office count
            document.getElementById('officeCount').textContent = visibleCount;
            
            // Show/hide empty message
            document.getElementById('officeListEmpty').style.display = 
                visibleCount === 0 ? 'block' : 'none';
        }
        
        function viewStaffDetails(staffId) {
            // Sample staff data (in a real app, this would come from the server)
            const allStaffData = {
                1: {
                    id: 1,
                    name: "Maria Santos",
                    position: "Division Chief, Business Development",
                    type: "NC Type A",
                    contact: "(032) 253-3926 loc. 101",
                    email: "maria.santos@dti.gov.ph",
                    services: ["Business Name Registration", "MSME Development", "Business Advisory", "Entrepreneurship Training"],
                    bio: "Maria Santos has been with DTI for over 10 years, specializing in business development and MSME support. She holds a Master's degree in Business Administration from the University of San Carlos and has extensive experience in helping small businesses grow and succeed in competitive markets.",
                    photo: "img/sample-staff1.jpg"
                },
                2: {
                    id: 2,
                    name: "Roberto Reyes",
                    position: "Consumer Protection Officer",
                    type: "NC Type B",
                    contact: "(032) 253-3926 loc. 102",
                    email: "roberto.reyes@dti.gov.ph",
                    services: ["Consumer Complaints", "Product Standards", "Price Monitoring", "Fair Trade Laws Enforcement"],
                    bio: "Roberto Reyes has been working with DTI's Consumer Protection Group for 5 years. He specializes in handling consumer complaints and ensuring businesses comply with fair trade laws and product standards. He has a background in Law from the University of the Philippines.",
                    photo: ""
                },
                // Add more staff data as needed
            };
            
            // Get staff data
            let staff = allStaffData[staffId] || null;
            
            // If staff not found in the sample data, try to find in the complete staff list
            if (!staff) {
                const staffData = {
                    // Regional Office Staff
                    1: [
                        {
                            id: 1,
                            name: "Maria Santos",
                            position: "Division Chief, Business Development",
                            type: "NC Type A",
                            contact: "(032) 253-3926 loc. 101",
                            email: "maria.santos@dti.gov.ph",
                            photo: "img/sample-staff1.jpg",
                            services: ["Business Name Registration", "MSME Development", "Business Advisory", "Entrepreneurship Training"],
                            bio: "Maria Santos has been with DTI for over 10 years, specializing in business development and MSME support. She holds a Master's degree in Business Administration from the University of San Carlos and has extensive experience in helping small businesses grow and succeed in competitive markets."
                        },
                        // More staff...
                    ],
                    // More offices...
                };
                
                for (const officeId in staffData) {
                    const officeStaff = staffData[officeId];
                    const foundStaff = officeStaff.find(s => s.id === staffId);
                    if (foundStaff) {
                        staff = foundStaff;
                        break;
                    }
                }
                
                if (!staff) {
                    alert("Staff information not found.");
                    return;
                }
            }
            
            // Build services list HTML
            let servicesHtml = '';
            if (staff.services && staff.services.length > 0) {
                servicesHtml = staff.services.map(service => `<li>${service}</li>`).join('');
            } else {
                servicesHtml = '<li>No specific services listed.</li>';
            }
            
            // Determine photo HTML
            let photoHtml = '';
            if (staff.photo) {
                photoHtml = `<img src="${staff.photo}" alt="${staff.name}" class="staff-detail-photo">`;
            } else {
                photoHtml = `
                    <div class="staff-detail-photo-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                `;
            }
            
            // Build staff details HTML
            const staffDetailsHtml = `
                <div class="staff-detail-header">
                    ${photoHtml}
                    <div class="staff-detail-info">
                        <h3 class="staff-detail-name">${staff.name}</h3>
                        <div class="staff-detail-position">${staff.position}</div>
                        <div class="staff-detail-badges">
                            <span class="staff-type staff-type-${staff.type.includes('Type A') ? 'a' : 'b'}">${staff.type}</span>
                        </div>
                    </div>
                </div>
                
                <div class="staff-detail-content">
                    <div class="staff-detail-section">
                        <h4><i class="fas fa-id-card"></i> Contact Information</h4>
                        <div class="staff-detail-item">
                            <div class="staff-detail-label">Phone:</div>
                            <div class="staff-detail-value">${staff.contact}</div>
                        </div>
                        <div class="staff-detail-item">
                            <div class="staff-detail-label">Email:</div>
                            <div class="staff-detail-value">${staff.email}</div>
                        </div>
                    </div>
                    
                    <div class="staff-detail-section">
                        <h4><i class="fas fa-briefcase"></i> Services Offered</h4>
                        <ul class="staff-services-list">
                            ${servicesHtml}
                        </ul>
                    </div>
                    
                    <div class="staff-detail-section">
                        <h4><i class="fas fa-user-circle"></i> Biography</h4>
                        <p class="staff-bio">
                            ${staff.bio}
                        </p>
                    </div>
                </div>
            `;
            
            // Update modal content
            document.getElementById('staffDetailsTitle').textContent = `${staff.name} - ${staff.position}`;
            document.getElementById('staffDetailsBody').innerHTML = staffDetailsHtml;
            
            // Show the modal
            document.getElementById('staffDetailsModal').style.display = 'block';
        }
        
        function closeStaffDetailsModal() {
            document.getElementById('staffDetailsModal').style.display = 'none';
        }
    </script>
    <script src="guest.js"></script>
</body>
</html>



