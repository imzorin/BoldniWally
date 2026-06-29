<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
    <title>{{ $anime }} – KAA Watch</title>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0b0b0b; color: #e5e5e5; font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.5; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        button { background: none; border: none; color: inherit; cursor: pointer; font: inherit; }
        
        /* ===== SKELETON LOADING STYLES ===== */
        .skeleton-wrapper {
            display: contents;
        }
        
        .skeleton {
            background: #1a1a1a;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.03) 20%,
                rgba(255, 255, 255, 0.06) 40%,
                rgba(255, 255, 255, 0.03) 60%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .skeleton-player {
            aspect-ratio: 16 / 9;
            width: 100%;
            border-radius: 16px;
            background: #121212;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-player::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.05) 50%,
                transparent 100%
            );
            animation: shimmer 2.8s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-player .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.15);
            border: 2px solid rgba(59, 130, 246, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: rgba(59, 130, 246, 0.3);
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.4; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.05); }
        }
        
        .skeleton-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 4px 0;
        }
        
        .skeleton-control-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .skeleton-btn {
            height: 40px;
            border-radius: 40px;
            background: #161616;
            min-width: 80px;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-btn-small {
            min-width: 60px;
            height: 36px;
        }
        
        .skeleton-btn-icon {
            min-width: 44px;
            width: 44px;
            border-radius: 50%;
        }
        
        .skeleton-info {
            display: flex;
            gap: 24px;
            padding: 20px;
            background: #141414;
            border-radius: 16px;
            border: 1px solid #1f1f1f;
            margin-top: 8px;
        }
        
        .skeleton-poster {
            flex-shrink: 0;
            width: 160px;
            height: 225px;
            border-radius: 12px;
            background: #161616;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-poster::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-details {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .skeleton-title {
            height: 32px;
            width: 70%;
            border-radius: 8px;
            background: #161616;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-title::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-text {
            height: 16px;
            width: 100%;
            border-radius: 6px;
            background: #161616;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-text::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-text-short {
            width: 40%;
        }
        .skeleton-text-medium {
            width: 60%;
        }
        
        .skeleton-episodes {
            background: #141414;
            border-radius: 16px;
            padding: 16px 14px 20px;
            border: 1px solid #1f1f1f;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: sticky;
            top: 16px;
            max-height: calc(100vh - 32px);
            overflow-y: auto;
        }
        
        .skeleton-episodes::-webkit-scrollbar { width: 5px; }
        .skeleton-episodes::-webkit-scrollbar-track { background: #1e1e1e; border-radius: 8px; }
        .skeleton-episodes::-webkit-scrollbar-thumb { background: #3b3b3b; border-radius: 8px; }
        
        .skeleton-ep-header {
            display: flex;
            flex-direction: column;
            gap: 12px;
            border-bottom: 1px solid #1f1f1f;
            padding-bottom: 14px;
        }
        
        .skeleton-ep-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }
        
        .skeleton-group-btn {
            height: 30px;
            width: 72px;
            border-radius: 30px;
            background: #161616;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-group-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-ep-search {
            height: 36px;
            flex: 1;
            min-width: 100px;
            border-radius: 40px;
            background: #161616;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-ep-search::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-ep-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(72px, 1fr));
            gap: 8px;
        }
        
        .skeleton-ep-item {
            height: 40px;
            border-radius: 10px;
            background: #161616;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-ep-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-comments {
            background: #141414;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #1f1f1f;
            margin-top: 8px;
        }
        
        .skeleton-comment-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        
        .skeleton-comment-title {
            height: 24px;
            width: 140px;
            border-radius: 6px;
            background: #161616;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-comment-title::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-comment-input {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .skeleton-comment-input-field {
            flex: 1;
            height: 48px;
            border-radius: 40px;
            background: #161616;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-comment-input-field::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-comment-btn {
            height: 48px;
            width: 80px;
            border-radius: 40px;
            background: #1a2a4a;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-comment-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.1) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-comment-item {
            background: #161616;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-comment-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.04) 50%,
                transparent 100%
            );
            animation: shimmer 2.5s ease-in-out infinite;
            transform: translateX(-100%);
        }
        
        .skeleton-comment-user {
            height: 18px;
            width: 120px;
            border-radius: 4px;
            background: #1f1f1f;
            margin-bottom: 8px;
        }
        
        .skeleton-comment-text {
            height: 14px;
            width: 80%;
            border-radius: 4px;
            background: #1a1a1a;
        }
        
        /* Skeleton container - hidden by default, shown during loading */
        .skeleton-container {
            display: none;
            width: 100%;
        }
        
        .skeleton-container.is-loading {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        .skeleton-container .kaa-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }
        
        .skeleton-container .player-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
            min-width: 0;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Content visibility during loading */
        .content-container {
            opacity: 0;
            transition: opacity 350ms ease;
        }
        
        .content-container.is-visible {
            opacity: 1;
        }
        
        /* Responsive skeleton */
        @media (max-width: 820px) {
            .skeleton-container .kaa-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .skeleton-episodes {
                position: relative;
                top: 0;
                max-height: none;
                overflow-y: visible;
            }
            .skeleton-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 16px;
            }
            .skeleton-poster {
                width: 120px;
                height: 170px;
            }
            .skeleton-title {
                width: 90%;
                margin: 0 auto;
            }
            .skeleton-text {
                width: 100%;
            }
        }
        
        @media (max-width: 480px) {
            .skeleton-poster {
                width: 100px;
                height: 140px;
            }
            .skeleton-ep-grid {
                grid-template-columns: repeat(auto-fill, minmax(56px, 1fr));
                gap: 6px;
            }
            .skeleton-ep-item {
                height: 34px;
            }
            .skeleton-btn {
                min-width: 60px;
                height: 34px;
            }
            .skeleton-btn-small {
                min-width: 48px;
                height: 30px;
            }
            .skeleton-player .play-icon {
                width: 56px;
                height: 56px;
                font-size: 22px;
            }
        }
        
        /* ===== END SKELETON STYLES ===== */
        
        .kaa-app { display: flex; flex-direction: column; max-width: 1600px; margin: 0 auto; padding: 16px 16px 24px; gap: 20px; }
        
        /* ===== DESKTOP GRID LAYOUT ===== */
        .kaa-grid { 
            display: grid; 
            grid-template-columns: 1fr 340px; 
            gap: 24px; 
            align-items: start; 
        }
        
        /* Desktop: Episode panel on right side (sticky) */
        .ep-panel-desktop {
            display: block;
        }
        
        /* Hide mobile episode panel on desktop */
        .ep-panel-mobile {
            display: none;
        }
        
        .player-col { display: flex; flex-direction: column; gap: 16px; min-width: 0; }
        
        /* ===== EPISODE PANEL (Desktop) ===== */
        .ep-panel { 
            background: #141414; 
            border-radius: 16px; 
            padding: 16px 14px 20px; 
            border: 1px solid #2a2a2a; 
            box-shadow: 0 8px 24px rgba(0,0,0,0.6); 
            display: flex; 
            flex-direction: column; 
            gap: 16px; 
            position: sticky; 
            top: 16px; 
            max-height: calc(100vh - 32px); 
            overflow-y: auto; 
        }
        .ep-panel::-webkit-scrollbar { width: 5px; }
        .ep-panel::-webkit-scrollbar-track { background: #1e1e1e; border-radius: 8px; }
        .ep-panel::-webkit-scrollbar-thumb { background: #3b3b3b; border-radius: 8px; }
        
        /* ===== MOBILE/TABLET LAYOUT OVERRIDES ===== */
        @media (max-width: 820px) {
            /* Switch to single column */
            .kaa-grid { 
                grid-template-columns: 1fr; 
                gap: 16px; 
            }
            
            /* Show mobile episode panel, hide desktop one */
            .ep-panel-desktop {
                display: none;
            }
            .ep-panel-mobile {
                display: block;
                order: 2;
            }
            
            /* Mobile episode panel styling */
            .ep-panel-mobile .ep-panel {
                position: relative !important;
                top: 0 !important;
                max-height: none !important;
                overflow-y: visible !important;
                padding: 16px 14px;
            }
            
            /* Mobile toggle for episode panel */
            .ep-panel-mobile .ep-panel.collapsed .ep-grid, 
            .ep-panel-mobile .ep-panel.collapsed .ep-toolbar { 
                display: none; 
            }
            .ep-panel-mobile .ep-panel.collapsed .ep-header { 
                border-bottom: none; 
                padding-bottom: 0; 
            }
            .mobile-toggle { 
                display: flex; 
            }
            
            /* Reorder using flex order */
            .player-col {
                display: flex;
                flex-direction: column;
                gap: 16px;
                min-width: 0;
            }
            
            /* Video wrapper stays first */
            .video-wrapper {
                order: 1;
            }
            
            /* Controls stay second */
            .player-controls {
                order: 2;
            }
            
            /* Mobile episode panel is third */
            .ep-panel-mobile {
                order: 3;
            }
            
            /* Anime info is fourth */
            .anime-info {
                order: 4;
                margin-top: 0;
            }
            
            /* Comments are fifth */
            .comments-section {
                order: 5;
                margin-top: 0;
            }
            
            /* Mobile responsive overrides */
            .ep-panel-mobile .ep-panel {
                position: relative;
                top: 0;
                max-height: none;
                overflow-y: visible;
                padding: 16px 14px;
            }
            
            .ep-panel-mobile .ep-panel.collapsed .ep-grid, 
            .ep-panel-mobile .ep-panel.collapsed .ep-toolbar { 
                display: none; 
            }
            .ep-panel-mobile .ep-panel.collapsed .ep-header { 
                border-bottom: none; 
                padding-bottom: 0; 
            }
            .mobile-toggle { 
                display: flex; 
            }
            
            .ep-grid { 
                max-height: 320px; 
                grid-template-columns: repeat(auto-fill, minmax(64px, 1fr)); 
            }
            
            /* ===== OPTIMIZED MOBILE CONTROLS LAYOUT ===== */
            .player-controls { 
                display: flex;
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding: 0 4px;
            }
            
            /* First row: Prev/Next buttons */
            .nav-buttons { 
                display: flex;
                justify-content: center;
                gap: 12px;
                width: 100%;
            }
            
            /* Second row: Quality, Captions, Speed - HORIZONTAL LAYOUT */
            .control-group {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                flex-wrap: wrap;
                width: 100%;
            }
            
            /* Each control wrapper takes auto width */
            .quality-wrapper, 
            .captions-wrapper, 
            .speed-wrapper { 
                display: inline-flex;
                width: auto;
                flex-shrink: 0;
            }
            
            /* Buttons inside control wrappers should be compact */
            .quality-wrapper .nav-btn,
            .captions-wrapper .nav-btn,
            .speed-wrapper .nav-btn {
                padding: 8px 14px;
                font-size: 0.8rem;
                min-width: 60px;
                justify-content: center;
            }
            
            /* Third row: Auto Play and Auto Next toggles */
            .control-group.toggles { 
                display: flex;
                justify-content: center;
                gap: 6px;
                flex-wrap: wrap;
                width: 100%;
            }
            
            .control-group.toggles .nav-btn {
                padding: 8px 14px;
                font-size: 0.75rem;
            }
            
            /* Dropdowns on mobile should be positioned correctly */
            .quality-dropdown, 
            .captions-dropdown, 
            .speed-dropdown { 
                width: 100%; 
                left: 0; 
                right: 0; 
                transform: none; 
                position: absolute;
                top: calc(100% + 8px);
                z-index: 100;
            }
            
            .thumbnail-preview img { 
                max-width: 120px; 
            }
            .anime-info { 
                flex-direction: column; 
                align-items: center; 
                text-align: center; 
                gap: 16px; 
            }
            .anime-poster { 
                width: 120px; 
                height: 170px; 
            }
        }
        
        @media (max-width: 480px) {
            .kaa-app { 
                padding: 8px 8px 16px; 
                gap: 14px; 
            }
            
            .ep-grid { 
                grid-template-columns: repeat(auto-fill, minmax(56px, 1fr)); 
                gap: 6px; 
            }
            .ep-item { 
                font-size: 0.75rem; 
                padding: 6px 0; 
            }
            
            /* Even more compact for very small screens */
            .quality-wrapper .nav-btn,
            .captions-wrapper .nav-btn,
            .speed-wrapper .nav-btn {
                padding: 6px 10px;
                font-size: 0.7rem;
                min-width: 48px;
            }
            
            .nav-btn { 
                padding: 8px 12px; 
                font-size: 0.75rem; 
            }
            .toggle-btn { 
                padding: 6px 10px; 
                font-size: 0.7rem; 
            }
            
            .control-group {
                gap: 6px;
            }
            
            .thumbnail-preview img { 
                max-width: 80px; 
            }
            .anime-title { 
                font-size: 1.2rem; 
            }
            .anime-poster { 
                width: 100px; 
                height: 140px; 
            }
        }
        
        /* Special handling for very narrow screens (like small phones in portrait) */
        @media (max-width: 360px) {
            .quality-wrapper .nav-btn,
            .captions-wrapper .nav-btn,
            .speed-wrapper .nav-btn {
                padding: 5px 8px;
                font-size: 0.65rem;
                min-width: 40px;
            }
            
            .control-group {
                gap: 4px;
            }
            
            .nav-btn {
                padding: 6px 8px;
                font-size: 0.7rem;
            }
        }
        
        /* ===== END MOBILE/TABLET OVERRIDES ===== */
        
        .video-wrapper { position: relative; background: #000; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.8); aspect-ratio: 16 / 9; width: 100%; }
        .video-wrapper video { display: block; width: 100%; height: 100%; background: #000; outline: none; }
        
        /* Loading Overlay */
        .loading-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
            border-radius: 16px;
        }
        
        .loading-overlay.is-active {
            opacity: 1;
            pointer-events: auto;
        }
        
        .loading-overlay:not(.is-active) {
            display: none;
        }
        
        .loading-overlay .spinner-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }
        
        .loading-overlay .spinner {
            width: 56px;
            height: 56px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
        }
        
        .loading-overlay .loading-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            font-weight: 400;
            letter-spacing: 0.3px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* ===== DESKTOP CONTROLS LAYOUT (unchanged) ===== */
        .player-controls { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            flex-wrap: wrap; 
            gap: 12px; 
            padding: 0 4px; 
        }
        
        .control-group { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            flex-wrap: wrap; 
        }
        
        .control-group.toggles { 
            gap: 6px; 
        }
        
        .nav-buttons { 
            display: flex; 
            gap: 12px; 
        }
        
        .nav-btn { 
            background: #202020; 
            border: 1px solid #333; 
            padding: 10px 18px; 
            border-radius: 40px; 
            font-size: 0.9rem; 
            font-weight: 500; 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            transition: 0.2s; 
            color: #ddd; 
            white-space: nowrap; 
            position: relative; 
        }
        .nav-btn:hover:not(:disabled):not(.active-toggle) { background: #2c2c2c; border-color: #555; color: #fff; }
        .nav-btn:disabled { opacity: 0.4; cursor: not-allowed; }
        .nav-btn i { font-size: 1rem; }
        .toggle-btn { padding: 8px 14px; font-size: 0.8rem; background: #1a1a1a; border-color: #2a2a2a; }
        .toggle-btn.active-toggle { background: #2563eb; border-color: #2563eb; color: #fff; }
        .toggle-btn.active-toggle:hover { background: #1d4ed8; border-color: #1d4ed8; }
        .quality-wrapper, .captions-wrapper, .speed-wrapper { position: relative; display: inline-flex; }
        .quality-dropdown, .captions-dropdown, .speed-dropdown { display: none; position: absolute; top: calc(100% + 8px); right: 0; background: #1e1e1e; border: 1px solid #333; border-radius: 12px; padding: 8px; min-width: 120px; z-index: 100; box-shadow: 0 8px 24px rgba(0,0,0,0.8); animation: fadeIn 0.15s ease; }
        .quality-dropdown.open, .captions-dropdown.open, .speed-dropdown.open { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        .quality-option, .captions-option, .speed-option { display: block; width: 100%; padding: 8px 16px; background: transparent; border: none; border-radius: 8px; color: #ccc; font-size: 0.85rem; text-align: left; cursor: pointer; transition: 0.15s; }
        .quality-option:hover, .captions-option:hover, .speed-option:hover { background: #2a2a2a; color: #fff; }
        .quality-option.active-quality, .captions-option.active-caption, .speed-option.active-speed { background: #2563eb; color: #fff; }
        .captions-btn.has-subtitles { opacity: 1; cursor: pointer; }
        .captions-btn.has-subtitles:hover { background: #2c2c2c; border-color: #555; color: #fff; }
        .thumbnail-preview { display: none; position: absolute; bottom: 70px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.85); border-radius: 8px; padding: 4px; z-index: 999999; pointer-events: none; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 8px 24px rgba(0,0,0,0.8); width: auto; height: auto; }
        .thumbnail-preview img { display: block; max-width: 200px; height: auto; border-radius: 4px; }
        .thumbnail-preview .thumbnail-time { text-align: center; color: #fff; font-size: 0.75rem; padding: 4px 0 2px; font-weight: 500; }
        
        /* Fullscreen styles for video wrapper */
        .video-wrapper:-webkit-full-screen { width: 100%; height: 100%; }
        .video-wrapper:-moz-full-screen { width: 100%; height: 100%; }
        .video-wrapper:fullscreen { width: 100%; height: 100%; }
        
        .ep-header { display: flex; flex-direction: column; gap: 12px; border-bottom: 1px solid #282828; padding-bottom: 14px; }
        .ep-header h3 { font-size: 1.2rem; font-weight: 600; letter-spacing: -0.3px; color: #f0f0f0; }
        .ep-header h3 span { color: #6b8cff; font-weight: 500; }
        .ep-toolbar { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        .group-selector { display: flex; flex-wrap: wrap; gap: 6px; }
        .group-btn { background: #1f1f1f; border: 1px solid #2d2d2d; padding: 6px 14px; border-radius: 30px; font-size: 0.75rem; font-weight: 500; color: #aaa; transition: 0.15s; white-space: nowrap; }
        .group-btn.active { background: #2563eb; border-color: #2563eb; color: #fff; }
        .group-btn:hover:not(.active) { background: #2a2a2a; color: #ddd; }
        .ep-search { display: flex; align-items: center; background: #1e1e1e; border: 1px solid #2e2e2e; border-radius: 40px; padding: 0 12px; flex: 1 1 140px; min-width: 100px; }
        .ep-search i { color: #555; font-size: 0.85rem; margin-right: 6px; }
        .ep-search input { background: transparent; border: none; padding: 8px 0; color: #eee; font-size: 0.9rem; width: 100%; outline: none; }
        .ep-search input::placeholder { color: #555; font-weight: 300; }
        .ep-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(72px, 1fr)); gap: 8px; max-height: 380px; overflow-y: auto; padding-right: 4px; }
        .ep-grid::-webkit-scrollbar { width: 4px; }
        .ep-grid::-webkit-scrollbar-track { background: #1a1a1a; }
        .ep-grid::-webkit-scrollbar-thumb { background: #333; border-radius: 8px; }
        .ep-item { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 10px; padding: 8px 0; text-align: center; font-size: 0.85rem; font-weight: 500; color: #ccc; transition: 0.15s; cursor: pointer; }
        .ep-item:hover { background: #262626; border-color: #3d3d3d; color: #fff; }
        .ep-item.active { background: #2563eb; border-color: #2563eb; color: #fff; box-shadow: 0 0 0 1px #2563eb; }
        .ep-item.hidden { display: none; }
        .mobile-toggle { display: none; background: #1c1c1c; border: 1px solid #2c2c2c; border-radius: 40px; padding: 10px 20px; font-weight: 500; font-size: 0.95rem; gap: 10px; align-items: center; width: 100%; justify-content: center; }
        .mobile-toggle i { font-size: 1rem; transition: 0.2s; }
        .mobile-toggle.open i { transform: rotate(180deg); }

        /* Anime Info Section */
        .anime-info { background: #141414; border-radius: 16px; padding: 20px; border: 1px solid #2a2a2a; display: flex; gap: 24px; margin-top: 8px; }
        .anime-poster { flex-shrink: 0; width: 160px; height: 225px; border-radius: 12px; overflow: hidden; background: #1a1a1a; border: 1px solid #2a2a2a; }
        .anime-poster img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .anime-poster .no-poster { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #555; font-size: 2rem; }
        .anime-details { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 8px; }
        .anime-title { font-size: 1.6rem; font-weight: 700; color: #f0f0f0; line-height: 1.2; }
        .anime-synopsis { color: #ccc; font-size: 0.9rem; line-height: 1.6; margin-top: 4px; max-height: 120px; overflow-y: auto; padding-right: 8px; }
        .anime-synopsis::-webkit-scrollbar { width: 3px; }
        .anime-synopsis::-webkit-scrollbar-track { background: #1a1a1a; border-radius: 4px; }
        .anime-synopsis::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }

        /* Comments Section */
        .comments-section { background: #141414; border-radius: 16px; padding: 20px; border: 1px solid #2a2a2a; margin-top: 8px; }
        .comments-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .comments-header h4 { font-size: 1.1rem; font-weight: 600; color: #f0f0f0; }
        .comments-header h4 i { color: #6b8cff; margin-right: 8px; }
        .comments-header .comment-count { font-size: 0.85rem; color: #666; }
        .comment-input { display: flex; gap: 12px; margin-bottom: 16px; }
        .comment-input input { flex: 1; background: #1e1e1e; border: 1px solid #2e2e2e; border-radius: 40px; padding: 12px 16px; color: #eee; font-size: 0.9rem; outline: none; transition: 0.15s; }
        .comment-input input:focus { border-color: #2563eb; }
        .comment-input input::placeholder { color: #555; }
        .comment-input button { background: #2563eb; color: #fff; padding: 12px 24px; border-radius: 40px; font-weight: 600; font-size: 0.9rem; transition: 0.15s; white-space: nowrap; }
        .comment-input button:hover { background: #1d4ed8; }
        .comment-input button:disabled { opacity: 0.5; cursor: not-allowed; }
        .comment-list { display: flex; flex-direction: column; gap: 12px; max-height: 400px; overflow-y: auto; padding-right: 4px; }
        .comment-list::-webkit-scrollbar { width: 4px; }
        .comment-list::-webkit-scrollbar-track { background: #1a1a1a; border-radius: 8px; }
        .comment-list::-webkit-scrollbar-thumb { background: #333; border-radius: 8px; }
        .comment-item { background: #1a1a1a; border: 1px solid #282828; border-radius: 12px; padding: 14px 16px; }
        .comment-item .comment-user { font-weight: 600; color: #f0f0f0; font-size: 0.9rem; }
        .comment-item .comment-user i { color: #6b8cff; margin-right: 6px; }
        .comment-item .comment-time { font-size: 0.7rem; color: #555; margin-left: 8px; }
        .comment-item .comment-text { color: #ccc; font-size: 0.9rem; margin-top: 4px; line-height: 1.5; }
        .comment-empty { color: #555; text-align: center; padding: 20px 0; font-size: 0.9rem; }

        .text-muted { color: #6b6b6b; font-size: 0.8rem; }
        .mt-1 { margin-top: 6px; }
        .auto-badge { background: #2563eb; color: #fff; font-size: 0.6rem; padding: 2px 6px; border-radius: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body>
    <div class="kaa-app" id="app">
        <!-- ===== SKELETON LOADING ===== -->
        <div class="skeleton-container is-loading" id="skeletonContainer">
            <div class="kaa-grid">
                <div class="player-col">
                    <div class="skeleton-player">
                        <div class="play-icon"><i class="fas fa-play"></i></div>
                    </div>
                    <div class="skeleton-controls">
                        <div class="skeleton-control-group">
                            <div class="skeleton-btn" style="width:100px;"></div>
                            <div class="skeleton-btn" style="width:100px;"></div>
                        </div>
                        <div class="skeleton-control-group">
                            <div class="skeleton-btn skeleton-btn-small" style="width:70px;"></div>
                            <div class="skeleton-btn skeleton-btn-small" style="width:80px;"></div>
                            <div class="skeleton-btn skeleton-btn-small" style="width:60px;"></div>
                        </div>
                        <div class="skeleton-control-group">
                            <div class="skeleton-btn skeleton-btn-small" style="width:80px;"></div>
                            <div class="skeleton-btn skeleton-btn-small" style="width:80px;"></div>
                        </div>
                    </div>
                    <div class="skeleton-info">
                        <div class="skeleton-poster"></div>
                        <div class="skeleton-details">
                            <div class="skeleton-title"></div>
                            <div class="skeleton-text"></div>
                            <div class="skeleton-text skeleton-text-medium"></div>
                            <div class="skeleton-text skeleton-text-short"></div>
                            <div class="skeleton-text" style="width:90%;"></div>
                        </div>
                    </div>
                    <div class="skeleton-comments">
                        <div class="skeleton-comment-header">
                            <div class="skeleton-comment-title"></div>
                            <div class="skeleton-text" style="width:80px;height:18px;"></div>
                        </div>
                        <div class="skeleton-comment-input">
                            <div class="skeleton-comment-input-field"></div>
                            <div class="skeleton-comment-btn"></div>
                        </div>
                        <div class="skeleton-comment-item">
                            <div class="skeleton-comment-user"></div>
                            <div class="skeleton-comment-text"></div>
                        </div>
                        <div class="skeleton-comment-item">
                            <div class="skeleton-comment-user"></div>
                            <div class="skeleton-comment-text" style="width:70%;"></div>
                        </div>
                        <div class="skeleton-comment-item">
                            <div class="skeleton-comment-user"></div>
                            <div class="skeleton-comment-text" style="width:60%;"></div>
                        </div>
                    </div>
                </div>
                <div class="skeleton-episodes">
                    <div class="skeleton-ep-header">
                        <div class="skeleton-ep-toolbar">
                            <div class="skeleton-group-btn"></div>
                            <div class="skeleton-group-btn"></div>
                            <div class="skeleton-group-btn"></div>
                            <div class="skeleton-ep-search"></div>
                        </div>
                    </div>
                    <div class="skeleton-ep-grid">
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                        <div class="skeleton-ep-item"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ===== CONTENT ===== -->
        <div class="content-container" id="contentContainer">
            <div class="kaa-grid">
                <!-- ===== LEFT COLUMN: Player + Info + Comments ===== -->
                <div class="player-col">
                    <div class="video-wrapper" id="videoWrapper">
                        <video id="video" controls playsinline preload="metadata" style="width:100%;height:100%;background:#000;"></video>
                        <div class="thumbnail-preview" id="thumbnailPreview">
                            <img id="thumbnailImg" src="" alt="Preview" />
                            <div class="thumbnail-time" id="thumbnailTime">00:00</div>
                        </div>
                        <div class="loading-overlay" id="loadingOverlay">
                            <div class="spinner-container">
                                <div class="spinner"></div>
                                <div class="loading-text">Loading episode...</div>
                            </div>
                        </div>
                    </div>
                    <div class="player-controls">
                        <div class="nav-buttons">
                            <button class="nav-btn" id="prevBtn" disabled><i class="fas fa-chevron-left"></i> Prev</button>
                            <button class="nav-btn" id="nextBtn" disabled>Next <i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="control-group">
                            <div class="quality-wrapper">
                                <button class="nav-btn" id="qualityBtn" style="display:none;">
                                    <i class="fas fa-cog"></i> <span id="currentQualityLabel">Auto</span>
                                </button>
                                <div class="quality-dropdown" id="qualityDropdown">
                                    <button class="quality-option" data-level="-1">Auto</button>
                                </div>
                            </div>
                            <div class="captions-wrapper">
                                <button class="nav-btn captions-btn" id="captionsBtn" disabled>
                                    <i class="fas fa-closed-captioning"></i> <span id="captionsLabel">Captions</span>
                                </button>
                                <div class="captions-dropdown" id="captionsDropdown">
                                    <button class="captions-option active-caption" data-lang="off">Off</button>
                                </div>
                            </div>
                            <div class="speed-wrapper">
                                <button class="nav-btn" id="speedBtn">
                                    <i class="fas fa-gauge-high"></i> <span id="currentSpeedLabel">1x</span>
                                </button>
                                <div class="speed-dropdown" id="speedDropdown">
                                    <button class="speed-option" data-speed="0.25">0.25x</button>
                                    <button class="speed-option" data-speed="0.5">0.5x</button>
                                    <button class="speed-option" data-speed="0.75">0.75x</button>
                                    <button class="speed-option active-speed" data-speed="1">1x</button>
                                    <button class="speed-option" data-speed="1.25">1.25x</button>
                                    <button class="speed-option" data-speed="1.5">1.5x</button>
                                    <button class="speed-option" data-speed="1.75">1.75x</button>
                                    <button class="speed-option" data-speed="2">2x</button>
                                </div>
                            </div>
                        </div>
                        <div class="control-group toggles">
                            <button class="nav-btn toggle-btn" id="autoPlayToggle">
                                <i class="fas fa-play"></i> <span>Auto Play</span>
                            </button>
                            <button class="nav-btn toggle-btn" id="autoNextToggle">
                                <i class="fas fa-forward"></i> <span>Auto Next</span>
                                <span class="auto-badge">On</span>
                            </button>
                        </div>
                    </div>

                    <!-- ===== MOBILE EPISODE PANEL (hidden on desktop) ===== -->
                    <div class="ep-panel-mobile" id="epPanelMobile">
                        <div class="ep-panel" id="epPanel">
                            <button class="mobile-toggle" id="mobileToggle">
                                <span>Episodes</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="ep-header">
                                <div class="ep-toolbar">
                                    <div class="group-selector" id="groupSelector"></div>
                                    <div class="ep-search">
                                        <i class="fas fa-search"></i>
                                        <input type="text" id="epSearch" placeholder="Search ep #" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="ep-grid" id="epGrid">
                                @foreach($episodes as $ep)
                                    <a
                                        href="/kaa-watch/{{ $anime }}/{{ $ep['slug'] }}"
                                        class="ep-item episode-link {{ $ep['slug'] == $episode ? 'active' : '' }}"
                                        data-episode="{{ $ep['slug'] }}"
                                        data-number="{{ $ep['episode_number'] }}"
                                    >
                                        {{ $ep['episode_number'] }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="text-muted mt-1" style="text-align:right;">{{ count($episodes) }} episodes</div>
                        </div>
                    </div>

                    <!-- Anime Information Section -->
                    <div class="anime-info" id="animeInfo">
                        <div class="anime-poster">
                            @if(isset($poster) && $poster)
                                <img src="{{ $poster }}" alt="{{ $title ?? $anime }}" />
                            @else
                                <div class="no-poster"><i class="fas fa-film"></i></div>
                            @endif
                        </div>
                        <div class="anime-details">
                            <h1 class="anime-title">{{ $title ?? $anime }}</h1>
                            @if(isset($synopsis) && $synopsis)
                                <div class="anime-synopsis">{{ $synopsis }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="comments-section" id="commentsSection">
                        <div class="comments-header">
                            <h4><i class="fas fa-comments"></i> Comments</h4>
                            <span class="comment-count" id="commentCount">0 comments</span>
                        </div>
                        <div class="comment-input">
                            <input type="text" id="commentInput" placeholder="Write a comment..." />
                            <button id="commentSubmit" disabled>Post</button>
                        </div>
                        <div class="comment-list" id="commentList">
                            <div class="comment-empty">No comments yet. Be the first!</div>
                        </div>
                    </div>
                </div>

                <!-- ===== RIGHT COLUMN: Desktop Episode Panel ===== -->
                <div class="ep-panel-desktop">
                    <div class="ep-panel" id="epPanelDesktop">
                        <div class="ep-header">
                            <div class="ep-toolbar">
                                <div class="group-selector" id="groupSelectorDesktop"></div>
                                <div class="ep-search">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="epSearchDesktop" placeholder="Search ep #" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="ep-grid" id="epGridDesktop">
                            @foreach($episodes as $ep)
                                <a
                                    href="/kaa-watch/{{ $anime }}/{{ $ep['slug'] }}"
                                    class="ep-item episode-link {{ $ep['slug'] == $episode ? 'active' : '' }}"
                                    data-episode="{{ $ep['slug'] }}"
                                    data-number="{{ $ep['episode_number'] }}"
                                >
                                    {{ $ep['episode_number'] }}
                                </a>
                            @endforeach
                        </div>
                        <div class="text-muted mt-1" style="text-align:right;">{{ count($episodes) }} episodes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        (function() {
            "use strict";

            // ===== SKELETON CONTROLLER =====
            const skeletonContainer = document.getElementById('skeletonContainer');
            const contentContainer = document.getElementById('contentContainer');
            
            function showSkeleton() {
                skeletonContainer.classList.add('is-loading');
                contentContainer.classList.remove('is-visible');
            }
            
            function hideSkeleton() {
                contentContainer.classList.add('is-visible');
                setTimeout(() => {
                    skeletonContainer.classList.remove('is-loading');
                }, 100);
            }
            
            showSkeleton();
            
            const video = document.getElementById('video');
            
            function onContentReady() {
                hideSkeleton();
                video.removeEventListener('loadedmetadata', onContentReady);
                video.removeEventListener('canplay', onContentReady);
            }
            
            if (video.readyState >= 1) {
                setTimeout(onContentReady, 300);
            } else {
                video.addEventListener('loadedmetadata', onContentReady);
                setTimeout(() => {
                    if (skeletonContainer.classList.contains('is-loading')) {
                        onContentReady();
                    }
                }, 5000);
            }
            
            document.addEventListener('hls-manifest-parsed', function() {
                if (skeletonContainer.classList.contains('is-loading')) {
                    hideSkeleton();
                }
            }, { once: true });

            // ===== CENTRALIZED LOADING STATE MANAGEMENT =====
            const loadingOverlay = document.getElementById('loadingOverlay');
            let loadingTimeout = null;
            let isOverlayVisible = false;
            
            function showLoading() {
                if (loadingTimeout) {
                    clearTimeout(loadingTimeout);
                    loadingTimeout = null;
                }
                loadingOverlay.style.display = 'flex';
                requestAnimationFrame(() => {
                    loadingOverlay.classList.add('is-active');
                    isOverlayVisible = true;
                });
                console.log('[Loading] Overlay shown');
            }
            
            function hideLoading() {
                if (loadingTimeout) {
                    clearTimeout(loadingTimeout);
                    loadingTimeout = null;
                }
                if (!isOverlayVisible) {
                    console.log('[Loading] Overlay already hidden');
                    return;
                }
                loadingOverlay.classList.remove('is-active');
                isOverlayVisible = false;
                loadingTimeout = setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                    loadingTimeout = null;
                }, 300);
                console.log('[Loading] Overlay hidden');
            }
            
            function resetLoadingState() {
                if (loadingTimeout) {
                    clearTimeout(loadingTimeout);
                    loadingTimeout = null;
                }
                loadingOverlay.classList.remove('is-active');
                loadingOverlay.style.display = 'none';
                isOverlayVisible = false;
                console.log('[Loading] State reset');
            }

            // ===== AUTO-PLAY ENHANCEMENT =====
            let autoplayAttempted = false;
            let autoplayPending = false;
            let autoplayRetryCount = 0;
            const MAX_AUTOPLAY_RETRIES = 3;
            
            function safeAutoplay() {
                if (!video || !video.src || video.src === '') {
                    console.log('[Autoplay] Skipped - no video source');
                    return;
                }
                if (video.paused === false && video.currentTime > 0) {
                    console.log('[Autoplay] Already playing');
                    hideLoading();
                    return;
                }
                if (autoplayAttempted && video.paused) {
                    console.log('[Autoplay] Already attempted, user likely paused');
                    hideLoading();
                    return;
                }
                if (autoplayRetryCount >= MAX_AUTOPLAY_RETRIES) {
                    console.log('[Autoplay] Max retries reached, giving up');
                    hideLoading();
                    return;
                }
                console.log(`[Autoplay] Attempting autoplay (attempt ${autoplayRetryCount + 1}/${MAX_AUTOPLAY_RETRIES})`);
                autoplayPending = true;
                if (video.readyState < 2) {
                    console.log('[Autoplay] Video not ready, waiting for canplay');
                    video.addEventListener('canplay', function onCanPlay() {
                        video.removeEventListener('canplay', onCanPlay);
                        safeAutoplay();
                    }, { once: true });
                    return;
                }
                const playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise
                        .then(() => {
                            console.log('[Autoplay] Success! Video started playing');
                            autoplayAttempted = true;
                            autoplayPending = false;
                            autoplayRetryCount = 0;
                            hideLoading();
                        })
                        .catch(error => {
                            console.log('[Autoplay] Blocked by browser:', error.name);
                            autoplayPending = false;
                            autoplayRetryCount++;
                            if (!video.paused) {
                                hideLoading();
                                return;
                            }
                            if (error.name === 'NotAllowedError' || error.name === 'NotSupportedError') {
                                console.log('[Autoplay] Browser policy prevented autoplay. Waiting for user interaction.');
                                const resumeAutoplay = function() {
                                    console.log('[Autoplay] User interaction detected, retrying...');
                                    document.removeEventListener('click', resumeAutoplay);
                                    document.removeEventListener('touchstart', resumeAutoplay);
                                    document.removeEventListener('keydown', resumeAutoplay);
                                    setTimeout(() => {
                                        if (video.paused) {
                                            safeAutoplay();
                                        } else {
                                            hideLoading();
                                        }
                                    }, 300);
                                };
                                if (autoplayRetryCount === 1) {
                                    document.addEventListener('click', resumeAutoplay);
                                    document.addEventListener('touchstart', resumeAutoplay);
                                    document.addEventListener('keydown', resumeAutoplay);
                                    console.log('[Autoplay] Waiting for user interaction to resume playback');
                                }
                                setTimeout(() => {
                                    if (video.paused) {
                                        hideLoading();
                                    }
                                }, 1000);
                            } else if (error.name === 'AbortError') {
                                console.log('[Autoplay] Playback was aborted (normal during switching)');
                                autoplayRetryCount = Math.max(0, autoplayRetryCount - 1);
                            } else {
                                console.log('[Autoplay] Unexpected error:', error.message);
                                hideLoading();
                                showPlayHint();
                            }
                        });
                }
            }
            
            function showPlayHint() {
                if (!video.paused) return;
                if (document.querySelector('.play-hint')) return;
                const hint = document.createElement('div');
                hint.className = 'play-hint';
                hint.style.cssText = `
                    position: absolute;
                    bottom: 80px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: rgba(0,0,0,0.7);
                    color: #fff;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-size: 0.8rem;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                    pointer-events: none;
                    z-index: 20;
                    backdrop-filter: blur(4px);
                    border: 1px solid rgba(255,255,255,0.1);
                `;
                hint.textContent = 'Click anywhere to play';
                videoWrapper.appendChild(hint);
                setTimeout(() => { hint.style.opacity = '0.7'; }, 100);
                const removeHint = function() {
                    hint.style.opacity = '0';
                    setTimeout(() => {
                        if (hint.parentNode) hint.parentNode.removeChild(hint);
                    }, 300);
                    document.removeEventListener('click', removeHint);
                    document.removeEventListener('touchstart', removeHint);
                    document.removeEventListener('keydown', removeHint);
                    video.removeEventListener('play', removeHint);
                };
                document.addEventListener('click', removeHint);
                document.addEventListener('touchstart', removeHint);
                document.addEventListener('keydown', removeHint);
                video.addEventListener('play', removeHint);
                setTimeout(() => {
                    if (hint.parentNode) {
                        hint.style.opacity = '0';
                        setTimeout(() => {
                            if (hint.parentNode) hint.parentNode.removeChild(hint);
                        }, 300);
                    }
                }, 5000);
            }
            
            function resetAutoplayState() {
                autoplayAttempted = false;
                autoplayPending = false;
                autoplayRetryCount = 0;
                const hint = document.querySelector('.play-hint');
                if (hint && hint.parentNode) {
                    hint.parentNode.removeChild(hint);
                }
            }

            // ===== VIDEO EVENT LISTENERS =====
            video.addEventListener('play', function() {
                console.log('[Video] Play event triggered');
                hideLoading();
            });
            video.addEventListener('playing', function() {
                console.log('[Video] Playing event triggered');
                hideLoading();
            });
            video.addEventListener('canplay', function() {
                console.log('[Video] Can play event');
                if (!video.paused && video.currentTime > 0) {
                    hideLoading();
                }
            });
            video.addEventListener('loadedmetadata', function() {
                console.log('[Video] Metadata loaded');
                if (video.duration > 0) {
                    setTimeout(() => {
                        if (!video.paused || video.currentTime > 0) {
                            hideLoading();
                        }
                    }, 100);
                }
            });
            video.addEventListener('loadeddata', function() {
                console.log('[Video] Data loaded');
                if (!video.paused) {
                    hideLoading();
                }
            });
            video.addEventListener('error', function() {
                console.log('[Video] Error event, hiding overlay');
                hideLoading();
            });

            // ===== DOM REFS =====
            const videoWrapper = document.getElementById('videoWrapper');
            
            // Desktop episode panel
            const epGridDesktop = document.getElementById('epGridDesktop');
            const epSearchDesktop = document.getElementById('epSearchDesktop');
            const groupSelectorDesktop = document.getElementById('groupSelectorDesktop');
            
            // Mobile episode panel
            const epGrid = document.getElementById('epGrid');
            const epSearch = document.getElementById('epSearch');
            const groupSelector = document.getElementById('groupSelector');
            const epPanel = document.getElementById('epPanel');
            const mobileToggle = document.getElementById('mobileToggle');
            
            // Controls
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            const autoPlayToggle = document.getElementById('autoPlayToggle');
            const autoNextToggle = document.getElementById('autoNextToggle');
            const qualityBtn = document.getElementById('qualityBtn');
            const qualityDropdown = document.getElementById('qualityDropdown');
            const currentQualityLabel = document.getElementById('currentQualityLabel');
            const captionsBtn = document.getElementById('captionsBtn');
            const captionsDropdown = document.getElementById('captionsDropdown');
            const captionsLabel = document.getElementById('captionsLabel');
            const thumbnailPreview = document.getElementById('thumbnailPreview');
            const thumbnailImg = document.getElementById('thumbnailImg');
            const thumbnailTime = document.getElementById('thumbnailTime');
            const speedBtn = document.getElementById('speedBtn');
            const speedDropdown = document.getElementById('speedDropdown');
            const currentSpeedLabel = document.getElementById('currentSpeedLabel');

            const commentInput = document.getElementById('commentInput');
            const commentSubmit = document.getElementById('commentSubmit');
            const commentList = document.getElementById('commentList');
            const commentCount = document.getElementById('commentCount');

            // ===== EPISODE DATA =====
            const allEpisodes = @json($episodes);
            let currentSlug = @json($episode);
            const animeSlug = @json($anime);
            let currentEpNumber = null;
            const epMap = {};
            allEpisodes.forEach(ep => {
                epMap[ep.slug] = ep.episode_number;
                if (ep.slug === currentSlug) currentEpNumber = ep.episode_number;
            });

            // ===== LOCALSTORAGE KEYS =====
            const STORAGE_KEY = 'kaa_continue_watch';
            const AUTO_PLAY_KEY = 'kaa_auto_play';
            const AUTO_NEXT_KEY = 'kaa_auto_next';
            const QUALITY_KEY = 'kaa_quality';
            const SUBTITLE_KEY = 'kaa_subtitle_lang';
            const SPEED_KEY = 'kaa_speed';
            const COMMENTS_KEY = 'kaa_comments';

            // ===== CONTINUE WATCHING =====
            function saveProgress(slug, time) {
                try {
                    const data = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
                    if (!data[animeSlug]) data[animeSlug] = {};
                    data[animeSlug][slug] = Math.floor(time);
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
                } catch (_) {}
            }
            function getProgress(slug) {
                try {
                    const data = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
                    return data?.[animeSlug]?.[slug] || 0;
                } catch (_) { return 0; }
            }

            const savedTime = getProgress(currentSlug);
            if (savedTime > 0) {
                video.addEventListener('loadedmetadata', function onMeta() {
                    video.currentTime = savedTime;
                    video.removeEventListener('loadedmetadata', onMeta);
                }, { once: true });
            }

            let saveTimer = null;
            video.addEventListener('timeupdate', function() {
                if (video.duration && video.duration > 0 && !video.seeking) {
                    if (saveTimer) clearTimeout(saveTimer);
                    saveTimer = setTimeout(() => {
                        saveProgress(currentSlug, video.currentTime);
                    }, 2000);
                }
            });
            window.addEventListener('beforeunload', function() {
                if (video.currentTime > 0) saveProgress(currentSlug, video.currentTime);
            });

            // ===== AUTO PLAY / NEXT =====
            let autoPlayEnabled = localStorage.getItem(AUTO_PLAY_KEY) !== 'false';
            let autoNextEnabled = localStorage.getItem(AUTO_NEXT_KEY) !== 'false';
            let selectedQuality = parseInt(localStorage.getItem(QUALITY_KEY) || '-1');
            let selectedSubtitleLang = localStorage.getItem(SUBTITLE_KEY) || 'off';
            let currentSubtitles = [];
            let currentThumbnails = null;
            let selectedSpeed = parseFloat(localStorage.getItem(SPEED_KEY) || '1');

            function updateToggleUI() {
                autoPlayToggle.classList.toggle('active-toggle', autoPlayEnabled);
                autoNextToggle.classList.toggle('active-toggle', autoNextEnabled);
            }
            autoPlayToggle.addEventListener('click', function() {
                autoPlayEnabled = !autoPlayEnabled;
                localStorage.setItem(AUTO_PLAY_KEY, autoPlayEnabled);
                updateToggleUI();
                if (autoPlayEnabled && video.paused && video.src) {
                    safeAutoplay();
                }
            });
            autoNextToggle.addEventListener('click', function() {
                autoNextEnabled = !autoNextEnabled;
                localStorage.setItem(AUTO_NEXT_KEY, autoNextEnabled);
                updateToggleUI();
            });

            // ===== QUALITY MENU =====
            let hlsLevels = [];
            function populateQualityMenu(levels) {
                hlsLevels = levels || [];
                if (!hlsLevels.length) { qualityBtn.style.display = 'none'; return; }
                qualityBtn.style.display = 'inline-flex';
                qualityDropdown.innerHTML = '';
                const autoOption = document.createElement('button');
                autoOption.className = 'quality-option';
                autoOption.dataset.level = '-1';
                autoOption.textContent = 'Auto';
                if (selectedQuality === -1) {
                    autoOption.classList.add('active-quality');
                    currentQualityLabel.textContent = 'Auto';
                }
                qualityDropdown.appendChild(autoOption);
                const sortedLevels = [...hlsLevels].sort((a, b) => b.height - a.height);
                sortedLevels.forEach((level) => {
                    const option = document.createElement('button');
                    option.className = 'quality-option';
                    const actualLevel = hlsLevels.indexOf(level);
                    option.dataset.level = actualLevel;
                    option.textContent = level.height + 'p';
                    if (selectedQuality === actualLevel) {
                        option.classList.add('active-quality');
                        currentQualityLabel.textContent = level.height + 'p';
                    }
                    qualityDropdown.appendChild(option);
                });
            }

            qualityBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                qualityDropdown.classList.toggle('open');
            });
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.quality-wrapper')) qualityDropdown.classList.remove('open');
            });
            qualityDropdown.addEventListener('click', function(e) {
                const option = e.target.closest('.quality-option');
                if (!option) return;
                const level = parseInt(option.dataset.level);
                selectedQuality = level;
                localStorage.setItem(QUALITY_KEY, String(level));
                qualityDropdown.querySelectorAll('.quality-option').forEach(el => el.classList.remove('active-quality'));
                option.classList.add('active-quality');
                if (level === -1) currentQualityLabel.textContent = 'Auto';
                else {
                    const hlsLevel = hlsLevels[level];
                    if (hlsLevel) currentQualityLabel.textContent = hlsLevel.height + 'p';
                }
                if (window.__hls && window.__hls.levels) {
                    const hlsInstance = window.__hls;
                    if (level === -1) hlsInstance.currentLevel = -1;
                    else {
                        const targetHeight = hlsLevels[level]?.height;
                        if (targetHeight) {
                            const levelIndex = hlsInstance.levels.findIndex(l => l.height === targetHeight);
                            if (levelIndex !== -1) hlsInstance.currentLevel = levelIndex;
                        }
                    }
                }
                qualityDropdown.classList.remove('open');
            });

            // ===== SPEED CONTROL =====
            function applySpeed(speed) {
                video.playbackRate = speed;
                selectedSpeed = speed;
                localStorage.setItem(SPEED_KEY, String(speed));
                currentSpeedLabel.textContent = speed + 'x';
                speedDropdown.querySelectorAll('.speed-option').forEach(el => {
                    el.classList.toggle('active-speed', parseFloat(el.dataset.speed) === speed);
                });
            }
            speedBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                speedDropdown.classList.toggle('open');
            });
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.speed-wrapper')) speedDropdown.classList.remove('open');
            });
            speedDropdown.addEventListener('click', function(e) {
                const option = e.target.closest('.speed-option');
                if (!option) return;
                const speed = parseFloat(option.dataset.speed);
                applySpeed(speed);
                speedDropdown.classList.remove('open');
            });
            applySpeed(selectedSpeed);

            // ===== SUBTITLE MANAGEMENT =====
            function buildCaptionsMenu(subtitles) {
                captionsDropdown.innerHTML = '';
                const offOption = document.createElement('button');
                offOption.className = 'captions-option';
                offOption.dataset.lang = 'off';
                offOption.textContent = 'Off';
                if (!selectedSubtitleLang || selectedSubtitleLang === 'off') offOption.classList.add('active-caption');
                offOption.addEventListener('click', function() {
                    selectSubtitle('off');
                    captionsDropdown.classList.remove('open');
                });
                captionsDropdown.appendChild(offOption);
                subtitles.forEach(sub => {
                    const option = document.createElement('button');
                    option.className = 'captions-option';
                    option.dataset.lang = sub.language;
                    option.textContent = sub.name || sub.language;
                    if (selectedSubtitleLang === sub.language) option.classList.add('active-caption');
                    option.addEventListener('click', function() {
                        selectSubtitle(sub.language);
                        captionsDropdown.classList.remove('open');
                    });
                    captionsDropdown.appendChild(option);
                });
                captionsBtn.disabled = false;
                captionsBtn.classList.add('has-subtitles');
                updateCaptionsLabel();
            }

            function selectSubtitle(lang) {
                selectedSubtitleLang = lang;
                localStorage.setItem(SUBTITLE_KEY, lang);
                const tracks = video.textTracks;
                let foundTrack = false;
                for (let i = 0; i < tracks.length; i++) {
                    const track = tracks[i];
                    if (track.kind === 'subtitles') {
                        if (lang !== 'off' && track.language === lang) {
                            track.mode = 'showing';
                            foundTrack = true;
                        } else {
                            track.mode = 'hidden';
                        }
                    }
                }
                if (lang !== 'off' && !foundTrack && currentSubtitles.length) {
                    const sub = currentSubtitles.find(s => s.language === lang);
                    if (sub) {
                        addSubtitleTracks(currentSubtitles);
                        setTimeout(() => selectSubtitle(lang), 100);
                        return;
                    }
                }
                updateCaptionsLabel();
                const options = captionsDropdown.querySelectorAll('.captions-option');
                options.forEach(opt => {
                    opt.classList.remove('active-caption');
                    if (opt.dataset.lang === lang) opt.classList.add('active-caption');
                });
            }

            function updateCaptionsLabel() {
                if (!selectedSubtitleLang || selectedSubtitleLang === 'off') captionsLabel.textContent = 'Captions';
                else {
                    const sub = currentSubtitles.find(s => s.language === selectedSubtitleLang);
                    captionsLabel.textContent = sub ? sub.name || sub.language : selectedSubtitleLang;
                }
            }

            function addSubtitleTracks(subtitles) {
                console.log('ADD_SUBTITLE_TRACKS called with', subtitles?.length || 0, 'tracks');
                
                const existingTracks = video.querySelectorAll('track');
                console.log('Removing', existingTracks.length, 'existing tracks');
                existingTracks.forEach(track => {
                    if (track.kind === 'subtitles') track.remove();
                });
                
                setTimeout(() => {
                    console.log('After removal, textTracks.length =', video.textTracks.length);
                }, 50);
                
                if (!subtitles || !subtitles.length) {
                    captionsBtn.disabled = true;
                    captionsBtn.classList.remove('has-subtitles');
                    captionsLabel.textContent = 'Captions';
                    currentSubtitles = [];
                    return;
                }
                currentSubtitles = subtitles;
                
                subtitles.forEach((sub, index) => {
                    if (!sub.src || !sub.language) return;
                    const track = document.createElement('track');  
                    track.kind = 'subtitles';
                    track.label = sub.name || sub.language;
                    track.srclang = sub.language;
                    track.src = sub.src;
                    track.default = false;
                    
                    track.addEventListener('load', function() {
                        console.log('TRACK_LOADED', this.srclang, this.track?.cues?.length, 'cues');
                    });
                    track.addEventListener('error', function() {
                        console.log('TRACK_ERROR', this.srclang);
                    });
                    
                    video.appendChild(track);
                    console.log(`Added track ${index + 1}/${subtitles.length}:`, sub.language, sub.src);
                });
                
                setTimeout(() => {
                    console.log('After adding, textTracks.length =', video.textTracks.length);
                    for (let i = 0; i < video.textTracks.length; i++) {
                        const track = video.textTracks[i];
                        console.log(`Track ${i}:`, track.label, track.language, track.kind, 'cues:', track.cues?.length || 0);
                    }
                }, 200);
                
                setTimeout(() => {
                    const tracks = video.textTracks;
                    let foundSelected = false;
                    for (let i = 0; i < tracks.length; i++) {
                        const track = tracks[i];
                        if (track.kind === 'subtitles') {
                            if (selectedSubtitleLang && selectedSubtitleLang !== 'off' && track.language === selectedSubtitleLang) {
                                track.mode = 'showing';
                                foundSelected = true;
                                console.log('Set track to SHOWING:', track.language);
                            } else {
                                track.mode = 'hidden';
                            }
                        }
                    }
                    if (!foundSelected && selectedSubtitleLang !== 'off' && subtitles.length > 0) {
                        const selectedSub = subtitles.find(s => s.language === selectedSubtitleLang);
                        if (!selectedSub) {
                            selectedSubtitleLang = 'off';
                            localStorage.setItem(SUBTITLE_KEY, 'off');
                        }
                    }
                    buildCaptionsMenu(subtitles);
                    
                    setTimeout(() => {
                        console.log('FINAL TRACK STATES:');
                        for (let i = 0; i < video.textTracks.length; i++) {
                            console.log(
                                `Track ${i}:`,
                                video.textTracks[i].label,
                                video.textTracks[i].language,
                                'mode:', video.textTracks[i].mode,
                                'cues:', video.textTracks[i].cues?.length || 0
                            );
                        }
                    }, 1000);
                }, 300);
            }

            captionsBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (!this.disabled) captionsDropdown.classList.toggle('open');
            });
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.captions-wrapper')) captionsDropdown.classList.remove('open');
            });

            // ===== FULLSCREEN OVERRIDE =====
            const originalRequestFullscreen = video.requestFullscreen;
            
            video.requestFullscreen = function() {
                console.log('Redirecting fullscreen request from video to videoWrapper');
                if (videoWrapper.requestFullscreen) {
                    return videoWrapper.requestFullscreen();
                } else if (videoWrapper.webkitRequestFullscreen) {
                    return videoWrapper.webkitRequestFullscreen();
                } else if (videoWrapper.mozRequestFullScreen) {
                    return videoWrapper.mozRequestFullScreen();
                } else if (videoWrapper.msRequestFullscreen) {
                    return videoWrapper.msRequestFullscreen();
                }
                return originalRequestFullscreen.call(video);
            };
            
            if (video.webkitRequestFullscreen) {
                const originalWebkitRequestFullscreen = video.webkitRequestFullscreen;
                video.webkitRequestFullscreen = function() {
                    console.log('Redirecting webkit fullscreen request from video to videoWrapper');
                    if (videoWrapper.webkitRequestFullscreen) {
                        return videoWrapper.webkitRequestFullscreen();
                    }
                    return originalWebkitRequestFullscreen.call(video);
                };
            }

            // ===== THUMBNAIL PREVIEW =====
            function setupThumbnailPreview(thumbnailsUrl) {
                if (!thumbnailsUrl) return;
                currentThumbnails = thumbnailsUrl;
                let vttData = null;
                let lastCueIndex = -1;
                let lastImageUrl = '';
                let hideTimeout = null;
                let isHoveringTimeline = false;
                let imageBaseUrl = '';
                let thumbnailDataLoaded = false;

                try {
                    const urlParams = new URLSearchParams(thumbnailsUrl.split('?')[1]);
                    const originalUrl = urlParams.get('url');
                    if (originalUrl) {
                        const lastSlash = originalUrl.lastIndexOf('/');
                        if (lastSlash !== -1) {
                            imageBaseUrl = originalUrl.substring(0, lastSlash + 1);
                        }
                    }
                } catch (e) {
                    console.error('Failed to parse thumbnail URL:', e);
                }

                function loadVTTData() {
                    if (thumbnailDataLoaded) return;
                    fetch(thumbnailsUrl)
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch VTT');
                            return response.text();
                        })
                        .then(text => { 
                            vttData = parseVTT(text);
                            thumbnailDataLoaded = true;
                            console.log('PARSED_VTT', vttData.length, 'cues');
                        })
                        .catch(err => { 
                            console.error('Failed to load thumbnail VTT:', err); 
                        });
                }
                loadVTTData();

                function parseVTT(text) {
                    const lines = text.split('\n');
                    const cues = [];
                    let currentCue = null;
                    for (const line of lines) {
                        if (line.includes('-->')) {
                            const parts = line.trim().split(' --> ');
                            if (parts.length === 2) {
                                currentCue = {
                                    start: parseTime(parts[0]),
                                    end: parseTime(parts[1]),
                                    image: null,
                                    spriteCoords: null
                                };
                            }
                        } else if (currentCue && line.trim() && !line.startsWith('WEBVTT') && !line.startsWith('Kind:') && !line.startsWith('Language:')) {
                            const spriteMatch = line.match(/([^#\s]+\.(?:jpg|png))#xywh=([\d]+),([\d]+),([\d]+),([\d]+)/i);
                            if (spriteMatch) {
                                currentCue.image = spriteMatch[1];
                                currentCue.spriteCoords = {
                                    x: parseInt(spriteMatch[2]),
                                    y: parseInt(spriteMatch[3]),
                                    w: parseInt(spriteMatch[4]),
                                    h: parseInt(spriteMatch[5])
                                };
                                cues.push(currentCue);
                                currentCue = null;
                            } else {
                                const imgMatch = line.match(/([^\/\s]+\.(?:jpg|png))/i);
                                if (imgMatch) {
                                    currentCue.image = imgMatch[1];
                                    cues.push(currentCue);
                                    currentCue = null;
                                }
                            }
                        }
                    }
                    return cues;
                }

                function parseTime(timeStr) {
                    const parts = timeStr.split(':');
                    if (parts.length === 3) return parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + parseFloat(parts[2]);
                    else if (parts.length === 2) return parseInt(parts[0]) * 60 + parseFloat(parts[1]);
                    return parseFloat(timeStr);
                }

                function getTimelineRect() {
                    const videoRect = video.getBoundingClientRect();
                    const wrapperRect = videoWrapper.getBoundingClientRect();
                    const isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement);
                    const targetRect = isFullscreen ? wrapperRect : videoRect;
                    let rect = null;
                    try {
                        if (video.shadowRoot) {
                            const inputs = video.shadowRoot.querySelectorAll('input[type="range"]');
                            for (const input of inputs) {
                                const inputRect = input.getBoundingClientRect();
                                if (inputRect.width > 100 && inputRect.height > 0 && inputRect.height < 30) {
                                    rect = inputRect;
                                    break;
                                }
                            }
                        }
                    } catch (e) {}
                    if (!rect) {
                        const videoParent = video.parentElement;
                        if (videoParent) {
                            const candidates = videoParent.querySelectorAll('input[type="range"], [role="slider"], [class*="seek"], [class*="progress"]');
                            for (const el of candidates) {
                                const elRect = el.getBoundingClientRect();
                                if (elRect.width > 50 && elRect.height > 0 && elRect.height < 40) {
                                    if (elRect.left >= targetRect.left && elRect.right <= targetRect.right) {
                                        rect = elRect;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if (!rect) {
                        let controlsHeight = Math.min(60, targetRect.height * 0.10);
                        if (isFullscreen) {
                            controlsHeight = Math.min(70, targetRect.height * 0.12);
                        }
                        const timelineY = targetRect.bottom - controlsHeight;
                        rect = {
                            left: targetRect.left,
                            right: targetRect.right,
                            top: Math.max(targetRect.top, timelineY),
                            bottom: targetRect.bottom,
                            width: targetRect.width,
                            height: controlsHeight
                        };
                    }
                    return rect;
                }

                function isCursorOnTimeline(clientX, clientY) {
                    const rect = getTimelineRect();
                    if (!rect) return false;
                    const insideX = clientX >= rect.left && clientX <= rect.right;
                    const insideY = clientY >= rect.top && clientY <= rect.bottom;
                    return insideX && insideY;
                }

                let thumbnailListenersActive = false;

                function setupThumbnailListeners() {
                    if (thumbnailListenersActive) {
                        document.removeEventListener('mousemove', onDocumentMouseMove);
                        video.removeEventListener('mouseleave', onMouseLeave);
                    }
                    document.addEventListener('mousemove', onDocumentMouseMove);
                    video.addEventListener('mouseleave', onMouseLeave);
                    thumbnailListenersActive = true;
                }

                function positionThumbnail(e) {
                    const videoRect = video.getBoundingClientRect();
                    const wrapperRect = videoWrapper.getBoundingClientRect();
                    const isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement);
                    const targetRect = isFullscreen ? wrapperRect : videoRect;
                    const previewWidth = 200;
                    const displayWidth = targetRect.width;
                    const displayLeft = targetRect.left;
                    const leftPos = Math.max(10, Math.min(displayWidth - previewWidth - 10, (e.clientX - displayLeft) - previewWidth / 2));
                    thumbnailPreview.style.left = leftPos + 'px';
                    thumbnailPreview.style.transform = 'none';
                    const previewHeight = thumbnailPreview.offsetHeight || 214;
                    const controlsHeight = isFullscreen ? Math.min(80, targetRect.height * 0.12) : Math.min(60, targetRect.height * 0.10);
                    const topPosition = targetRect.height - previewHeight - controlsHeight - 20;
                    thumbnailPreview.style.top = topPosition + 'px';
                    thumbnailPreview.style.bottom = 'auto';
                }

                function onDocumentMouseMove(e) {
                    const onTimeline = isCursorOnTimeline(e.clientX, e.clientY);
                    if (!onTimeline) {
                        if (isHoveringTimeline) {
                            isHoveringTimeline = false;
                            scheduleHide();
                        }
                        return;
                    }
                    isHoveringTimeline = true;
                    if (hideTimeout) {
                        clearTimeout(hideTimeout);
                        hideTimeout = null;
                    }
                    if (!vttData || !vttData.length) {
                        if (!thumbnailDataLoaded) {
                            loadVTTData();
                        }
                        thumbnailPreview.style.display = 'none';
                        return;
                    }
                    const videoRect = video.getBoundingClientRect();
                    const displayWidth = videoRect.width;
                    const displayLeft = videoRect.left;
                    const x = Math.max(0, Math.min(1, (e.clientX - displayLeft) / displayWidth));
                    const duration = video.duration || 1;
                    const currentTime = x * duration;
                    let thumbnail = null;
                    let cueIndex = -1;
                    for (let i = 0; i < vttData.length; i++) {
                        const cue = vttData[i];
                        if (currentTime >= cue.start && currentTime <= cue.end) {
                            thumbnail = cue;
                            cueIndex = i;
                            break;
                        }
                    }
                    if (thumbnail) {
                        const imageFile = thumbnail.image.split('#')[0];
                        const directUrl = imageBaseUrl + imageFile;
                        const proxyUrl = '/kaa-thumbnail-image?url=' + encodeURIComponent(directUrl);
                        if (cueIndex !== lastCueIndex || lastImageUrl !== proxyUrl) {
                            lastCueIndex = cueIndex;
                            lastImageUrl = proxyUrl;
                            if (thumbnail.spriteCoords) {
                                const coords = thumbnail.spriteCoords;
                                thumbnailImg.style.objectFit = 'none';
                                thumbnailImg.style.objectPosition = `-${coords.x}px -${coords.y}px`;
                                thumbnailImg.style.width = coords.w + 'px';
                                thumbnailImg.style.height = coords.h + 'px';
                                thumbnailImg.style.maxWidth = 'none';
                                thumbnailImg.style.maxHeight = 'none';
                            } else {
                                thumbnailImg.style.objectFit = 'cover';
                                thumbnailImg.style.objectPosition = 'center';
                                thumbnailImg.style.width = '100%';
                                thumbnailImg.style.height = '100%';
                                thumbnailImg.style.maxWidth = '100%';
                                thumbnailImg.style.maxHeight = '100%';
                            }
                            thumbnailImg.onload = function() {
                                positionThumbnail(e);
                                thumbnailPreview.style.display = 'block';
                                thumbnailPreview.style.visibility = 'visible';
                                thumbnailPreview.style.opacity = '1';
                            };
                            thumbnailImg.onerror = function() {
                                if (this.src.includes('/kaa-thumbnail-image')) {
                                    this.src = directUrl;
                                }
                            };
                            thumbnailImg.src = proxyUrl;
                        } else {
                            positionThumbnail(e);
                            thumbnailPreview.style.display = 'block';
                            thumbnailPreview.style.visibility = 'visible';
                            thumbnailPreview.style.opacity = '1';
                        }
                        const minutes = Math.floor(currentTime / 60);
                        const seconds = Math.floor(currentTime % 60);
                        thumbnailTime.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                        thumbnailPreview.style.display = 'block';
                        thumbnailPreview.style.visibility = 'visible';
                        thumbnailPreview.style.opacity = '1';
                        thumbnailPreview.style.width = 'auto';
                        thumbnailPreview.style.height = 'auto';
                    } else {
                        thumbnailPreview.style.display = 'none';
                    }
                }

                function onMouseLeave(e) {
                    const rect = video.getBoundingClientRect();
                    const isOverVideo = (
                        e.clientX >= rect.left &&
                        e.clientX <= rect.right &&
                        e.clientY >= rect.top &&
                        e.clientY <= rect.bottom
                    );
                    if (!isOverVideo) {
                        isHoveringTimeline = false;
                        scheduleHide();
                    }
                }

                function scheduleHide() {
                    if (hideTimeout) clearTimeout(hideTimeout);
                    hideTimeout = setTimeout(() => {
                        if (!isHoveringTimeline) {
                            thumbnailPreview.style.display = 'none';
                            thumbnailPreview.style.visibility = 'hidden';
                            thumbnailPreview.style.opacity = '0';
                        }
                        hideTimeout = null;
                    }, 50);
                }

                setupThumbnailListeners();

                function handleFullscreenChange() {
                    const fsElement = document.fullscreenElement || document.webkitFullscreenElement;
                    console.log('Fullscreen change - element:', fsElement);
                    isHoveringTimeline = false;
                    if (hideTimeout) {
                        clearTimeout(hideTimeout);
                        hideTimeout = null;
                    }
                    thumbnailPreview.style.display = 'none';
                    thumbnailPreview.style.visibility = 'hidden';
                    thumbnailPreview.style.opacity = '0';
                    if (!thumbnailListenersActive) {
                        setupThumbnailListeners();
                    }
                }

                document.addEventListener('fullscreenchange', handleFullscreenChange);
                document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
                document.addEventListener('mozfullscreenchange', handleFullscreenChange);
                document.addEventListener('MSFullscreenChange', handleFullscreenChange);
                
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        if (!thumbnailListenersActive) {
                            setupThumbnailListeners();
                        }
                    }, 200);
                });

                document.addEventListener('click', function(e) {
                    if (!isCursorOnTimeline(e.clientX, e.clientY)) {
                        thumbnailPreview.style.display = 'none';
                        thumbnailPreview.style.visibility = 'hidden';
                        thumbnailPreview.style.opacity = '0';
                        isHoveringTimeline = false;
                        if (hideTimeout) {
                            clearTimeout(hideTimeout);
                            hideTimeout = null;
                        }
                    }
                });

                window.addEventListener('beforeunload', function() {
                    document.removeEventListener('mousemove', onDocumentMouseMove);
                    video.removeEventListener('mouseleave', onMouseLeave);
                    document.removeEventListener('fullscreenchange', handleFullscreenChange);
                    document.removeEventListener('webkitfullscreenchange', handleFullscreenChange);
                    document.removeEventListener('mozfullscreenchange', handleFullscreenChange);
                    document.removeEventListener('MSFullscreenChange', handleFullscreenChange);
                });

                console.log('Thumbnail preview setup complete - root fix applied');
            }

            // ===== AUTO-NEXT =====
            function setupAutoNext() {
                video.removeEventListener('ended', window._autoNextHandler);
                window._autoNextHandler = function() {
                    if (autoNextEnabled) {
                        const nextLink = getAdjacentLink(1);
                        if (nextLink) {
                            if (nextLink.classList.contains('hidden')) {
                                const epNum = parseInt(nextLink.dataset.number);
                                switchToGroupForEpisode(epNum);
                                setTimeout(() => {
                                    const updatedLink = document.querySelector(`.episode-link[data-episode="${nextLink.dataset.episode}"]`);
                                    if (updatedLink && !updatedLink.classList.contains('hidden')) updatedLink.click();
                                }, 100);
                            } else {
                                nextLink.click();
                            }
                        }
                    }
                };
                video.addEventListener('ended', window._autoNextHandler);
            }

            // ===== PREV / NEXT =====
            function getAdjacentLink(direction) {
                const allLinks = [...document.querySelectorAll('.episode-link')];
                const active = document.querySelector('.episode-link.active');
                if (!active) return null;
                const activeIdx = allLinks.indexOf(active);
                if (activeIdx === -1) return null;
                return allLinks[activeIdx + direction] || null;
            }
            function updateNavButtons() {
                prevBtn.disabled = !getAdjacentLink(-1);
                nextBtn.disabled = !getAdjacentLink(1);
            }
            prevBtn.addEventListener('click', function() {
                const link = getAdjacentLink(-1);
                if (link) {
                    if (link.classList.contains('hidden')) {
                        const epNum = parseInt(link.dataset.number);
                        switchToGroupForEpisode(epNum);
                        setTimeout(() => {
                            const updatedLink = document.querySelector(`.episode-link[data-episode="${link.dataset.episode}"]`);
                            if (updatedLink && !updatedLink.classList.contains('hidden')) updatedLink.click();
                        }, 100);
                    } else link.click();
                }
            });
            nextBtn.addEventListener('click', function() {
                const link = getAdjacentLink(1);
                if (link) {
                    if (link.classList.contains('hidden')) {
                        const epNum = parseInt(link.dataset.number);
                        switchToGroupForEpisode(epNum);
                        setTimeout(() => {
                            const updatedLink = document.querySelector(`.episode-link[data-episode="${link.dataset.episode}"]`);
                            if (updatedLink && !updatedLink.classList.contains('hidden')) updatedLink.click();
                        }, 100);
                    } else link.click();
                }
            });

            // ===== EPISODE GROUPING =====
            function getGroupRange(num) {
                const groupSize = 100;
                const start = Math.floor((num - 1) / groupSize) * groupSize + 1;
                const end = start + groupSize - 1;
                return { start, end, label: `${start}–${end}` };
            }
            function buildGroups() {
                const nums = allEpisodes.map(e => e.episode_number).sort((a,b) => a-b);
                if (!nums.length) return [];
                const groups = [];
                let currentGroup = null;
                for (const n of nums) {
                    const range = getGroupRange(n);
                    if (!currentGroup || currentGroup.start !== range.start) {
                        currentGroup = { start: range.start, end: range.end, label: range.label };
                        groups.push(currentGroup);
                    }
                }
                return groups;
            }
            let activeGroup = null;
            
            function renderGroups() {
                const groups = buildGroups();
                
                // Render desktop groups
                groupSelectorDesktop.innerHTML = '';
                groups.forEach(g => {
                    const btn = document.createElement('button');
                    btn.className = 'group-btn';
                    btn.dataset.start = g.start;
                    btn.dataset.end = g.end;
                    btn.textContent = g.label;
                    btn.addEventListener('click', function() {
                        const start = parseInt(this.dataset.start);
                        const end = parseInt(this.dataset.end);
                        activeGroup = { start, end, label: this.textContent };
                        groupSelectorDesktop.querySelectorAll('.group-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        applyGroupFilterDesktop();
                        if (epPanel.classList.contains('collapsed')) {
                            epPanel.classList.remove('collapsed');
                            mobileToggle.classList.remove('open');
                        }
                        updateNavButtons();
                    });
                    groupSelectorDesktop.appendChild(btn);
                });
                
                // Render mobile groups
                groupSelector.innerHTML = '';
                groups.forEach(g => {
                    const btn = document.createElement('button');
                    btn.className = 'group-btn';
                    btn.dataset.start = g.start;
                    btn.dataset.end = g.end;
                    btn.textContent = g.label;
                    btn.addEventListener('click', function() {
                        const start = parseInt(this.dataset.start);
                        const end = parseInt(this.dataset.end);
                        activeGroup = { start, end, label: this.textContent };
                        groupSelector.querySelectorAll('.group-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        applyGroupFilterMobile();
                        if (epPanel.classList.contains('collapsed')) {
                            epPanel.classList.remove('collapsed');
                            mobileToggle.classList.remove('open');
                        }
                        updateNavButtons();
                    });
                    groupSelector.appendChild(btn);
                });
                
                const currentNum = currentEpNumber || 1;
                const currentRange = getGroupRange(currentNum);
                
                // Update desktop groups
                const desktopBtns = groupSelectorDesktop.querySelectorAll('.group-btn');
                desktopBtns.forEach(btn => {
                    const start = parseInt(btn.dataset.start);
                    if (start === currentRange.start) {
                        btn.classList.add('active');
                        activeGroup = currentRange;
                    } else btn.classList.remove('active');
                });
                
                // Update mobile groups
                const mobileBtns = groupSelector.querySelectorAll('.group-btn');
                mobileBtns.forEach(btn => {
                    const start = parseInt(btn.dataset.start);
                    if (start === currentRange.start) {
                        btn.classList.add('active');
                        activeGroup = currentRange;
                    } else btn.classList.remove('active');
                });
                
                if (!groupSelectorDesktop.querySelector('.group-btn.active')) {
                    const first = groupSelectorDesktop.querySelector('.group-btn');
                    if (first) {
                        first.classList.add('active');
                        const s = parseInt(first.dataset.start);
                        const e = parseInt(first.dataset.end);
                        activeGroup = { start: s, end: e, label: first.textContent };
                    }
                }
                if (!groupSelector.querySelector('.group-btn.active')) {
                    const first = groupSelector.querySelector('.group-btn');
                    if (first) {
                        first.classList.add('active');
                        const s = parseInt(first.dataset.start);
                        const e = parseInt(first.dataset.end);
                        activeGroup = { start: s, end: e, label: first.textContent };
                    }
                }
                applyGroupFilterDesktop();
                applyGroupFilterMobile();
            }
            
            function applyGroupFilterDesktop() {
                if (!activeGroup) return;
                const items = epGridDesktop.querySelectorAll('.episode-link');
                items.forEach(el => {
                    const num = parseInt(el.dataset.number);
                    if (num >= activeGroup.start && num <= activeGroup.end) el.classList.remove('hidden');
                    else el.classList.add('hidden');
                });
                applySearchFilterDesktop();
                updateNavButtons();
            }
            
            function applyGroupFilterMobile() {
                if (!activeGroup) return;
                const items = epGrid.querySelectorAll('.episode-link');
                items.forEach(el => {
                    const num = parseInt(el.dataset.number);
                    if (num >= activeGroup.start && num <= activeGroup.end) el.classList.remove('hidden');
                    else el.classList.add('hidden');
                });
                applySearchFilterMobile();
                updateNavButtons();
            }
            
            function applySearchFilterDesktop() {
                const query = epSearchDesktop.value.trim();
                const items = epGridDesktop.querySelectorAll('.episode-link');
                items.forEach(el => {
                    const num = parseInt(el.dataset.number);
                    const matchGroup = activeGroup ? (num >= activeGroup.start && num <= activeGroup.end) : true;
                    const matchSearch = query === '' || num === parseInt(query);
                    if (matchGroup && matchSearch) el.classList.remove('hidden');
                    else el.classList.add('hidden');
                });
                updateNavButtons();
            }
            
            function applySearchFilterMobile() {
                const query = epSearch.value.trim();
                const items = epGrid.querySelectorAll('.episode-link');
                items.forEach(el => {
                    const num = parseInt(el.dataset.number);
                    const matchGroup = activeGroup ? (num >= activeGroup.start && num <= activeGroup.end) : true;
                    const matchSearch = query === '' || num === parseInt(query);
                    if (matchGroup && matchSearch) el.classList.remove('hidden');
                    else el.classList.add('hidden');
                });
                updateNavButtons();
            }
            
            function switchToGroupForEpisode(episodeNumber) {
                const range = getGroupRange(episodeNumber);
                if (!activeGroup || activeGroup.start !== range.start) {
                    activeGroup = range;
                    const desktopBtns = groupSelectorDesktop.querySelectorAll('.group-btn');
                    desktopBtns.forEach(btn => {
                        const start = parseInt(btn.dataset.start);
                        if (start === range.start) btn.classList.add('active');
                        else btn.classList.remove('active');
                    });
                    const mobileBtns = groupSelector.querySelectorAll('.group-btn');
                    mobileBtns.forEach(btn => {
                        const start = parseInt(btn.dataset.start);
                        if (start === range.start) btn.classList.add('active');
                        else btn.classList.remove('active');
                    });
                    applyGroupFilterDesktop();
                    applyGroupFilterMobile();
                    if (epPanel.classList.contains('collapsed')) {
                        epPanel.classList.remove('collapsed');
                        mobileToggle.classList.remove('open');
                    }
                    updateNavButtons();
                }
            }

            // ===== SEARCH =====
            epSearchDesktop.addEventListener('input', applySearchFilterDesktop);
            epSearch.addEventListener('input', applySearchFilterMobile);

            // ===== EPISODE CLICK (shared for both desktop and mobile) =====
            function handleEpisodeClick(e) {
                const link = e.currentTarget;
                showLoading();
                resetAutoplayState();
                if (video.currentTime > 0) saveProgress(currentSlug, video.currentTime);
                const newSlug = link.dataset.episode;
                const newNumber = parseInt(link.dataset.number);
                if (newSlug !== currentSlug) {
                    currentSlug = newSlug;
                    currentEpNumber = newNumber;
                    document.querySelectorAll('.episode-link').forEach(el => el.classList.remove('active'));
                    link.classList.add('active');
                    switchToGroupForEpisode(currentEpNumber);
                    updateNavButtons();
                }
            }
            
            document.querySelectorAll('.episode-link').forEach(link => {
                link.addEventListener('click', handleEpisodeClick);
            });

            // ===== MOBILE TOGGLE =====
            mobileToggle.addEventListener('click', function() {
                epPanel.classList.toggle('collapsed');
                this.classList.toggle('open');
            });
            if (window.innerWidth > 820) {
                epPanel.classList.remove('collapsed');
                mobileToggle.classList.remove('open');
            }

            // ===== COMMENTS SYSTEM =====
            function loadComments() {
                try {
                    const data = JSON.parse(localStorage.getItem(COMMENTS_KEY) || '{}');
                    const comments = data[animeSlug] || [];
                    renderComments(comments);
                    updateCommentCount(comments.length);
                    return comments;
                } catch (_) {
                    return [];
                }
            }

            function saveComments(comments) {
                try {
                    const data = JSON.parse(localStorage.getItem(COMMENTS_KEY) || '{}');
                    data[animeSlug] = comments;
                    localStorage.setItem(COMMENTS_KEY, JSON.stringify(data));
                } catch (_) {}
            }

            function renderComments(comments) {
                if (!comments || comments.length === 0) {
                    commentList.innerHTML = '<div class="comment-empty">No comments yet. Be the first!</div>';
                    return;
                }
                commentList.innerHTML = comments.map(comment => `
                    <div class="comment-item">
                        <div>
                            <span class="comment-user"><i class="fas fa-user"></i> ${escapeHtml(comment.user)}</span>
                            <span class="comment-time">${formatTime(comment.timestamp)}</span>
                        </div>
                        <div class="comment-text">${escapeHtml(comment.text)}</div>
                    </div>
                `).join('');
            }

            function updateCommentCount(count) {
                commentCount.textContent = count + ' comment' + (count !== 1 ? 's' : '');
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                const now = new Date();
                const diff = Math.floor((now - date) / 1000);
                if (diff < 60) return 'Just now';
                if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
                if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
                if (diff < 172800) return 'Yesterday';
                return date.toLocaleDateString();
            }

            function postComment() {
                const text = commentInput.value.trim();
                if (!text) return;
                const comments = loadComments();
                comments.push({
                    user: 'Guest',
                    text: text,
                    timestamp: Date.now()
                });
                saveComments(comments);
                renderComments(comments);
                updateCommentCount(comments.length);
                commentInput.value = '';
                commentSubmit.disabled = true;
            }

            commentInput.addEventListener('input', function() {
                commentSubmit.disabled = this.value.trim().length === 0;
            });

            commentInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (!commentSubmit.disabled) postComment();
                }
            });

            commentSubmit.addEventListener('click', postComment);
            loadComments();

            // ===== INIT =====
            renderGroups();
            document.querySelectorAll('.episode-link').forEach(el => {
                if (el.dataset.episode === currentSlug) el.classList.add('active');
                else el.classList.remove('active');
            });
            const curNum = currentEpNumber || 1;
            switchToGroupForEpisode(curNum);
            updateNavButtons();
            setupAutoNext();
            updateToggleUI();

            // ===== QUALITY CHECK =====
            let qualityCheckInterval = setInterval(() => {
                if (window.__hls && window.__hls.levels && window.__hls.levels.length > 0) {
                    const hlsInstance = window.__hls;
                    if (hlsInstance.levels.length > 0) {
                        populateQualityMenu(hlsInstance.levels);
                        if (selectedQuality !== -1) {
                            const targetHeight = hlsInstance.levels[selectedQuality]?.height;
                            if (targetHeight) {
                                const levelIndex = hlsInstance.levels.findIndex(l => l.height === targetHeight);
                                if (levelIndex !== -1) hlsInstance.currentLevel = levelIndex;
                            }
                        }
                        clearInterval(qualityCheckInterval);
                    }
                }
            }, 500);

            // ===== INITIAL SUBTITLES & THUMBNAILS =====
            const initialSubtitles = @json($subtitles ?? []);
            const initialThumbnails = @json($thumbnails ?? null);

            if (initialThumbnails)
                setupThumbnailPreview(initialThumbnails);

            if (initialSubtitles && initialSubtitles.length > 0) {
                if (selectedSubtitleLang === 'off' || !selectedSubtitleLang) {
                    selectedSubtitleLang = 'off';
                    localStorage.setItem(SUBTITLE_KEY, 'off');
                }
                if (video.readyState >= 2) {
                    addSubtitleTracks(initialSubtitles);
                } else {
                    video.addEventListener('loadedmetadata', function onLoad() {
                        addSubtitleTracks(initialSubtitles);
                        video.removeEventListener('loadedmetadata', onLoad);
                    });
                }
            } else {
                captionsBtn.disabled = true;
                captionsLabel.textContent = 'Captions';
            }
            if (initialThumbnails) setupThumbnailPreview(initialThumbnails);

            // ===== AUTOPLAY SETUP =====
            video.addEventListener('canplay', function onCanPlay() {
                console.log('[Autoplay] Video can play, attempting autoplay');
                if (autoPlayEnabled && video.paused) {
                    safeAutoplay();
                }
                video.removeEventListener('canplay', onCanPlay);
            });
            
            video.addEventListener('loadedmetadata', function onMeta() {
                console.log('[Autoplay] Video metadata loaded');
                if (autoPlayEnabled && video.paused && video.readyState >= 2) {
                    safeAutoplay();
                }
            });
            
            document.addEventListener('hls-manifest-parsed', function() {
                console.log('[Autoplay] HLS manifest parsed, attempting autoplay');
                if (autoPlayEnabled && video.paused) {
                    setTimeout(() => {
                        safeAutoplay();
                    }, 300);
                }
            });
            
            window.addEventListener('load', function() {
                console.log('[Autoplay] Page loaded, initial autoplay attempt');
                if (autoPlayEnabled && video.paused) {
                    setTimeout(() => {
                        safeAutoplay();
                    }, 500);
                }
            });

            // ===== EXPOSE =====
            window.__kaa = {
                showLoading,
                hideLoading,
                resetLoadingState,
                updateNavButtons,
                applyGroupFilterDesktop,
                applyGroupFilterMobile,
                switchToGroupForEpisode,
                getAdjacentLink,
                populateQualityMenu,
                selectedQuality,
                autoPlayEnabled,
                autoNextEnabled,
                addSubtitleTracks,
                setupThumbnailPreview,
                selectSubtitle,
                selectedSubtitleLang,
                currentSubtitles,
                safeAutoplay,
                resetAutoplayState
            };
            console.log('KAA UI ready with optimized mobile controls layout');
        })();
    </script>

    <!-- ====== ORIGINAL HLS / PLAYBACK CODE ====== -->
    <script>
        (function() {
            const video = document.getElementById('video');
            let hls;
            const manifestCache = {};

            async function getManifest(episode) {
                if (manifestCache[episode]) {
                    console.log('CACHE HIT', episode);
                    return manifestCache[episode];
                }
                const response = await fetch(`/kaa-manifest/{{ $anime }}/${episode}`);
                const data = await response.json();
                manifestCache[episode] = data.manifest;
                
                fetch('/kaa-cat?url=' + encodeURIComponent(data.manifest))
                    .then(r => r.text())
                    .then(text => {
                        const lines = text.split('\n');
                        const playlist = lines.find(l => l.trim() && !l.startsWith('#'));
                        if (playlist) fetch(playlist).catch(() => {});
                    })
                    .catch(() => {});
                return data.manifest;
            }

            async function prefetchNextEpisode(currentLink) {
                const links = [...document.querySelectorAll('.episode-link')];
                const index = links.indexOf(currentLink);
                const PREFETCH_COUNT = 2;
                for (let i = 1; i <= PREFETCH_COUNT; i++) {
                    const nextLink = links[index + i];
                    if (!nextLink) break;
                    const nextEpisode = nextLink.dataset.episode;
                    if (manifestCache[nextEpisode]) continue;
                    try {
                        const response = await fetch(`/kaa-manifest/{{ $anime }}/${nextEpisode}`);
                        const data = await response.json();
                        manifestCache[nextEpisode] = data.manifest;
                        fetch('/kaa-cat?url=' + encodeURIComponent(data.manifest)).catch(() => {});
                        console.log('PREFETCHED', nextEpisode);
                    } catch (e) {
                        console.error('PREFETCH FAILED', nextEpisode, e);
                    }
                }
                console.log('CACHE SIZE', Object.keys(manifestCache).length);
            }

            const firstManifest = '/kaa-cat?url=' + encodeURIComponent('{{ $manifest }}');

            document.querySelectorAll('.episode-link').forEach(link => {
                link.addEventListener('click', async function (e) {
                    e.preventDefault();
                    const episode = this.dataset.episode;
                    const episodeNumber = parseInt(this.dataset.number);
                    
                    try {
                        console.time('EPISODE_SWITCH');
                        console.log('Switching to episode:', episode);
                        
                        let subtitleData = null;
                        let thumbnailData = null;
                        
                        console.time('MANIFEST');
                        const manifest = await getManifest(episode);
                        console.timeEnd('MANIFEST');
                        
                        const manifestResponse = await fetch(`/kaa-manifest/{{ $anime }}/${episode}`);
                        const manifestData = await manifestResponse.json();
                        subtitleData = manifestData.subtitles || [];
                        thumbnailData = manifestData.thumbnails || null;
                        
                        console.log('Subtitle data for episode:', subtitleData.length, 'tracks');
                        
                        const newManifest = '/kaa-cat?url=' + encodeURIComponent(manifest);
                        
                        if (Hls.isSupported()) {
                            console.time('PLAYER_LOAD');
                            
                            if (hls) {
                                hls.stopLoad();
                                hls.detachMedia();
                                hls.destroy();
                                console.log('Old HLS destroyed');
                            }
                            
                            hls = new Hls({
                                enableWorker: true,
                                lowLatencyMode: false,
                                backBufferLength: 30,
                                maxBufferLength: 30,
                                maxMaxBufferLength: 60,
                                startLevel: -1,
                                capLevelToPlayerSize: false
                            });
                            window.__hls = hls;
                            
                            hls.loadSource(newManifest);
                            hls.attachMedia(video);
                            
                            let subtitlesAdded = false;
                            
                            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                                console.log('MANIFEST_PARSED - adding subtitles now');
                                
                                if (subtitleData && subtitleData.length > 0 && !subtitlesAdded) {
                                    subtitlesAdded = true;
                                    console.log('Adding subtitle tracks after HLS ready:', subtitleData.length);
                                    if (window.__kaa) {
                                        window.__kaa.addSubtitleTracks(subtitleData);
                                    }
                                }
                                
                                if (thumbnailData && window.__kaa && !subtitlesAdded) {
                                    window.__kaa.setupThumbnailPreview(thumbnailData);
                                }
                                
                                if (window.__kaa && window.__kaa.selectedQuality !== undefined) {
                                    const q = window.__kaa.selectedQuality;
                                    if (q === -1) {
                                        hls.currentLevel = -1;
                                    } else {
                                        const levels = hls.levels;
                                        if (levels && levels[q]) {
                                            const targetHeight = levels[q].height;
                                            const idx = levels.findIndex(l => l.height === targetHeight);
                                            if (idx !== -1) hls.currentLevel = idx;
                                        }
                                    }
                                }
                                
                                document.dispatchEvent(new Event('hls-manifest-parsed'));
                                
                                console.timeEnd('PLAYER_LOAD');
                                console.timeEnd('EPISODE_SWITCH');
                            });
                            
                            const onCanPlay = () => {
                                console.log('VIDEO_CANPLAY - fallback subtitle add');
                                if (subtitleData && subtitleData.length > 0 && window.__kaa && !subtitlesAdded) {
                                    const existingTracks = video.querySelectorAll('track');
                                    if (existingTracks.length === 0) {
                                        subtitlesAdded = true;
                                        console.log('Adding subtitles via canplay fallback');
                                        window.__kaa.addSubtitleTracks(subtitleData);
                                    }
                                }
                                video.removeEventListener('canplay', onCanPlay);
                            };
                            video.addEventListener('canplay', onCanPlay);
                            
                        } else {
                            video.src = newManifest;
                            video.addEventListener('loadedmetadata', function onLoad() {
                                if (subtitleData && subtitleData.length > 0 && window.__kaa) {
                                    window.__kaa.addSubtitleTracks(subtitleData);
                                }
                                if (thumbnailData && window.__kaa) {
                                    window.__kaa.setupThumbnailPreview(thumbnailData);
                                }
                                video.removeEventListener('loadedmetadata', onLoad);
                            });
                        }
                        
                        history.pushState({}, '', `/kaa-watch/{{ $anime }}/${episode}`);
                        document.querySelectorAll('.episode-link').forEach(el => el.classList.remove('active'));
                        this.classList.add('active');
                        
                        if (episodeNumber && window.__kaa && window.__kaa.switchToGroupForEpisode) {
                            window.__kaa.switchToGroupForEpisode(episodeNumber);
                        }
                        
                        prefetchNextEpisode(this);
                        
                    } catch (error) {
                        console.error('Episode switch error:', error);
                        if (window.__kaa) window.__kaa.hideLoading();
                    }
                });
            });

            if (Hls.isSupported()) {
                const startupStart = performance.now();
                hls = new Hls({
                    enableWorker: true,
                    lowLatencyMode: false,
                    backBufferLength: 30,
                    maxBufferLength: 30,
                    maxMaxBufferLength: 60,
                    startLevel: 0,
                    capLevelToPlayerSize: false
                });
                hls.on(Hls.Events.MANIFEST_PARSED, () => {
                    console.log('MANIFEST_PARSED', (performance.now() - startupStart).toFixed(0) + 'ms');
                    document.dispatchEvent(new Event('hls-manifest-parsed'));
                    setTimeout(() => {
                        if (video.paused && window.__kaa && window.__kaa.autoPlayEnabled) {
                            window.__kaa.safeAutoplay();
                        }
                    }, 500);
                });
                hls.on(Hls.Events.LEVEL_LOADED, () => {
                    console.log('LEVEL_LOADED', (performance.now() - startupStart).toFixed(0) + 'ms');
                });
                hls.on(Hls.Events.FRAG_LOADED, () => {
                    console.log('FRAG_LOADED', (performance.now() - startupStart).toFixed(0) + 'ms');
                });
                video.addEventListener('canplay', () => {
                    console.log('VIDEO_CANPLAY', (performance.now() - startupStart).toFixed(0) + 'ms');
                }, { once: true });
                hls.loadSource(firstManifest);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function () {
                    console.log('INITIAL VIDEO READY');
                });
            } else {
                video.src = firstManifest;
            }

            window.addEventListener('load', () => {
                const active = document.querySelector('.episode-link.active');
                if (active) {
                    setTimeout(() => { prefetchNextEpisode(active); }, 1000);
                }
            });

            window.__hls = hls;
        })();
    </script>
</body>
</html>