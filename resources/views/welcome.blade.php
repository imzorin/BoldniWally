<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BoldNiwally · Anime Streaming</title>
  <!-- Bootstrap 5 & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    /* ----- ROOT VARIABLES ----- */
    :root {
      --bg-dark: #050816;
      --bg-sidebar: #0B1020;
      --bg-card: #111827;
      --bg-card-hover: #1a2332;
      --bg-input: #1a2332;
      --text-primary: #e8e8e8;
      --text-secondary: #94a3b8;
      --text-muted: #64748b;
      --border-color: rgba(59, 130, 246, 0.15);
      --border-hover: #3B82F6;
      --accent-color: #2563EB;
      --accent-secondary: #3B82F6;
      --accent-light: #60A5FA;
      --accent-glow: rgba(37, 99, 235, 0.25);
      --rating-color: #fbbf24;
      --header-height: 64px;
      --hero-min-height: calc(100vh - var(--header-height));
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background-color: var(--bg-dark);
      color: var(--text-primary);
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* scrollbar */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: var(--bg-dark); }
    ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--accent-color); }

    /* layout */
    .app-container { display: flex; flex-direction: column; min-height: 100vh; }

    /* ===== HEADER (sticky, minimal - hidden) ===== */
    .app-header {
      display: none;
    }

    /* ============================================================== */
    /*  HERO SECTION - Premium Collapsible for All Devices           */
    /* ============================================================== */
    .hero-header {
      position: relative;
      width: 100%;
      padding: 0.5rem 0 1.5rem 0;
      background: radial-gradient(ellipse at 50% 0%, rgba(37,99,235,0.08) 0%, transparent 70%),
                  radial-gradient(ellipse at 50% 100%, rgba(37,99,235,0.05) 0%, transparent 50%),
                  var(--bg-dark);
      border-bottom: 1px solid var(--border-color);
      overflow: hidden;
      min-height: var(--hero-min-height);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: min-height 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                  padding 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 0.5s ease,
                  margin 0.5s ease;
      will-change: min-height, padding, opacity, margin;
    }

    /* Collapsed state */
    .hero-header.collapsed {
      min-height: 0 !important;
      height: 0 !important;
      padding: 0 !important;
      opacity: 0;
      border-bottom: none;
      pointer-events: none;
      margin: 0;
      overflow: hidden;
    }

    /* subtle star particles */
    .hero-header::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: 
        radial-gradient(1px 1px at 10% 20%, rgba(255,255,255,0.04), transparent),
        radial-gradient(1px 1px at 30% 70%, rgba(255,255,255,0.03), transparent),
        radial-gradient(1.5px 1.5px at 60% 15%, rgba(255,255,255,0.05), transparent),
        radial-gradient(1px 1px at 80% 50%, rgba(255,255,255,0.03), transparent),
        radial-gradient(1px 1px at 20% 90%, rgba(255,255,255,0.04), transparent),
        radial-gradient(1.2px 1.2px at 70% 80%, rgba(255,255,255,0.03), transparent);
      background-size: 200% 200%;
      pointer-events: none;
      z-index: 0;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 2rem;
      width: 100%;
      transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 0.5s ease;
      will-change: transform, opacity;
    }

    .hero-header.collapsed .hero-content {
      transform: scale(0.8);
      opacity: 0;
      pointer-events: none;
    }

    /* ===== PREMIUM COMPACT STICKY HEADER ===== */
    .compact-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 999;
      background: rgba(11, 16, 32, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(59, 130, 246, 0.08);
      padding: 0 1.5rem;
      height: var(--header-height);
      display: none;
      align-items: center;
      justify-content: space-between;
      transform: translateY(-100%);
      transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 0.4s ease,
                  box-shadow 0.4s ease;
      will-change: transform, opacity;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
      gap: 1rem;
    }

    .compact-header.visible {
      transform: translateY(0);
      display: flex;
      opacity: 1;
    }

    /* Left section: menu + hero banner + brand */
    .compact-header .compact-left {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      flex: 1;
      min-width: 0;
    }

    /* ===== UNIFIED ACTION BUTTONS ===== */
    .compact-header .action-btn {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.06);
      color: var(--text-secondary);
      font-size: 1.2rem;
      padding: 0.5rem 0.6rem;
      border-radius: 10px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 40px;
      min-height: 40px;
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      flex-shrink: 0;
    }

    .compact-header .action-btn:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(59, 130, 246, 0.2);
      color: var(--text-primary);
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .compact-header .action-btn:active {
      transform: scale(0.92);
      background: rgba(255, 255, 255, 0.02);
    }

    .compact-header .action-btn i {
      font-size: 1.2rem;
      line-height: 1;
    }

    /* Hero banner thumbnail */
    .compact-header .compact-hero-banner {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      overflow: hidden;
      flex-shrink: 0;
      border: 1px solid rgba(59, 130, 246, 0.12);
      background: var(--bg-input);
      position: relative;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }

    .compact-header .compact-hero-banner:hover {
      border-color: rgba(59, 130, 246, 0.3);
      transform: scale(1.02);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .compact-header .compact-hero-banner img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    /* Brand text */
    .compact-header .compact-brand {
      display: flex;
      flex-direction: column;
      line-height: 1.15;
      min-width: 0;
      cursor: pointer;
    }

    .compact-header .compact-brand .brand-name {
      font-size: 1.1rem;
      font-weight: 700;
      letter-spacing: -0.3px;
      background: linear-gradient(135deg, #ffffff 30%, #60A5FA 70%, #2563EB 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      white-space: nowrap;
      transition: font-size 0.3s ease;
    }

    .compact-header .compact-brand .brand-sub {
      font-size: 0.55rem;
      font-weight: 400;
      letter-spacing: 1.8px;
      text-transform: uppercase;
      color: rgba(148, 163, 184, 0.6);
      white-space: nowrap;
    }

    .compact-header .compact-brand .brand-jp {
      font-size: 0.5rem;
      font-weight: 300;
      letter-spacing: 0.5px;
      color: rgba(100, 116, 139, 0.4);
      white-space: nowrap;
      display: none;
    }

    /* Right section: actions */
    .compact-header .compact-actions {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      flex-shrink: 0;
    }

    /* ===== SIMPLIFIED SEARCH OVERLAY ===== */
    .search-overlay {
      position: fixed;
      top: var(--header-height);
      left: 0;
      right: 0;
      z-index: 998;
      background: rgba(11, 16, 32, 0.97);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      padding: 0.75rem 1.5rem;
      border-bottom: 1px solid rgba(59, 130, 246, 0.06);
      transform: translateY(-100%);
      opacity: 0;
      transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 0.35s ease;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
      pointer-events: none;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .search-overlay.open {
      transform: translateY(0);
      opacity: 1;
      pointer-events: auto;
    }

    .search-overlay .search-form {
      flex: 1;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      max-width: 600px;
      margin: 0 auto;
      width: 100%;
    }

    .search-overlay .search-form .search-input {
      flex: 1;
      background: var(--bg-input);
      border: 1px solid var(--border-color);
      color: var(--text-primary);
      border-radius: 50px;
      padding: 0.6rem 1.2rem;
      font-size: 0.95rem;
      height: 44px;
      transition: all 0.3s ease;
      width: 100%;
    }

    .search-overlay .search-form .search-input:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
      outline: none;
      background: var(--bg-input);
      color: var(--text-primary);
    }

    .search-overlay .search-form .search-input::placeholder {
      color: var(--text-secondary);
      font-weight: 300;
    }

    /* Close button - unified styling */
    .search-overlay .search-close {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.06);
      color: var(--text-secondary);
      font-size: 1.1rem;
      padding: 0.4rem 0.5rem;
      border-radius: 10px;
      transition: all 0.3s ease;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      min-height: 36px;
      flex-shrink: 0;
    }

    .search-overlay .search-close:hover {
      color: var(--text-primary);
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(59, 130, 246, 0.2);
    }

    /* ===== ANIMATIONS - Initial load only ===== */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    /* Animation classes - only applied on initial load */
    .animate-hero-artwork {
      animation: fadeInUp 0.8s ease forwards;
    }
    .animate-hero-brand {
      animation: fadeInScale 0.7s ease 0.15s forwards;
      opacity: 0;
    }
    .animate-hero-sub {
      animation: fadeIn 0.6s ease 0.3s forwards;
      opacity: 0;
    }
    .animate-hero-jp {
      animation: fadeIn 0.6s ease 0.4s forwards;
      opacity: 0;
    }
    .animate-hero-search {
      animation: fadeInUp 0.7s ease 0.5s forwards;
      opacity: 0;
    }
    .animate-hero-fade {
      animation: fadeIn 0.8s ease 0.6s forwards;
      opacity: 0;
    }

    /* large character artwork */
    .hero-artwork {
      width: 100%;
      max-width: 900px;
      margin: 0 auto 1.2rem auto;
      display: block;
      filter: drop-shadow(0 8px 40px rgba(37,99,235,0.2));
      transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 0.5s ease,
                  margin 0.5s ease;
      will-change: transform, opacity, margin;
    }

    .hero-team {
      display: block;
      width: 100%;
      height: auto;
      object-fit: contain;
      max-height: 520px;
      image-rendering: auto;
      background: transparent;
    }

    /* brand centerpiece */
    .hero-brand {
      margin: 0.75rem 0 0.25rem 0;
      line-height: 1.2;
      transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 0.5s ease,
                  margin 0.5s ease;
      will-change: transform, opacity, margin;
    }
    .hero-brand .brand-name {
      font-size: 5rem;
      font-weight: 800;
      letter-spacing: -1px;
      background: linear-gradient(135deg, #ffffff 30%, #60A5FA 70%, #2563EB 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-shadow: 0 0 40px rgba(37,99,235,0.4);
      display: inline-block;
      filter: drop-shadow(0 4px 20px rgba(37,99,235,0.3));
      transition: font-size 0.4s ease;
    }
    .hero-brand .brand-sub {
      display: block;
      font-size: 1.5rem;
      font-weight: 400;
      letter-spacing: 6px;
      text-transform: uppercase;
      color: var(--text-secondary);
      margin-top: 0.15rem;
      opacity: 0.85;
      transition: font-size 0.4s ease, opacity 0.4s ease;
    }
    .hero-brand .brand-jp {
      display: block;
      font-size: 1.3rem;
      font-weight: 300;
      letter-spacing: 3px;
      color: var(--text-muted);
      margin-top: 0.2rem;
      font-family: 'Hiragino Sans', 'Yu Gothic', sans-serif;
      transition: font-size 0.4s ease, opacity 0.4s ease;
    }

    /* search bar in hero */
    .hero-search {
      max-width: 700px;
      margin: 1.5rem auto 0.2rem auto;
      width: 100%;
      transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 0.5s ease,
                  margin 0.5s ease;
      will-change: transform, opacity, margin;
    }
    .hero-search .search-form {
      position: relative;
      width: 100%;
    }
    .hero-search .search-form .form-control {
      background-color: rgba(26, 35, 50, 0.7);
      backdrop-filter: blur(6px);
      border: 1px solid var(--border-color);
      color: var(--text-primary);
      border-radius: 60px;
      padding: 0.9rem 2rem;
      font-size: 1.05rem;
      transition: all 0.3s ease;
      height: 60px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.4);
    }
    .hero-search .search-form .form-control::placeholder {
      color: var(--text-secondary);
      font-weight: 300;
      font-size: 1rem;
    }
    .hero-search .search-form .form-control:focus {
      background-color: rgba(26, 35, 50, 0.9);
      border-color: var(--accent-color);
      box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2), 0 8px 40px rgba(0,0,0,0.5);
      color: var(--text-primary);
    }
    .hero-search .search-form .btn-search {
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      background: linear-gradient(135deg, #2563EB, #3B82F6);
      border: none;
      border-radius: 60px;
      padding: 0.7rem 2rem;
      color: white;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.3s ease;
      box-shadow: 0 8px 30px rgba(37, 99, 235, 0.4);
      height: 46px;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }
    .hero-search .search-form .btn-search:hover {
      transform: translateY(-50%) translateY(-2px);
      box-shadow: 0 12px 40px rgba(37, 99, 235, 0.6);
    }

    /* smooth transition from hero to content */
    .hero-fade {
      height: 40px;
      background: linear-gradient(to bottom, var(--bg-dark) 0%, transparent 100%);
      opacity: 0.5;
      margin-top: -20px;
      pointer-events: none;
      position: relative;
      z-index: 1;
      transition: opacity 0.5s ease, height 0.5s ease, margin 0.5s ease;
    }

    .hero-header.collapsed + .hero-fade {
      opacity: 0;
      height: 0;
      margin: 0;
      padding: 0;
    }

    /* ----- rest of existing layout (sidebar, main, cards) ----- */
    .app-body { display: flex; flex: 1; }
    .app-sidebar { width: 220px; background-color: var(--bg-sidebar); border-right: 1px solid var(--border-color); padding: 1.5rem 0; flex-shrink: 0; position: sticky; top: var(--header-height); height: calc(100vh - var(--header-height)); overflow-y: auto; }
    .sidebar-nav { display: flex; flex-direction: column; gap: 0.25rem; padding: 0 0.75rem; }
    .sidebar-nav .nav-link { color: var(--text-secondary); font-weight: 500; padding: 0.6rem 1rem; transition: all 0.3s ease; text-decoration: none; border-radius: 10px; display: flex; align-items: center; gap: 0.75rem; font-size: 0.9rem; cursor: pointer; }
    .sidebar-nav .nav-link i { font-size: 1.1rem; width: 1.4rem; text-align: center; }
    .sidebar-nav .nav-link:hover { color: var(--text-primary); background: rgba(59, 130, 246, 0.08); transform: translateX(4px); }
    .sidebar-nav .nav-link.active { background: linear-gradient(135deg, #2563EB, #3B82F6); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); }
    .sidebar-nav .nav-link.active i { color: white; }

    .app-main { flex: 1; padding: 1.5rem 2rem; min-width: 0; }
    .app-releases { width: 280px; padding: 1.5rem 1.5rem 1.5rem 0; flex-shrink: 0; position: sticky; top: var(--header-height); height: calc(100vh - var(--header-height)); overflow-y: auto; }
    .section-title { color: var(--text-primary); font-weight: 700; font-size: 1.3rem; margin-bottom: 1.2rem; letter-spacing: -0.3px; }

    /* cards, releases, continue, etc */
    .anime-card { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; transition: all 0.3s ease; height: 100%; position: relative; }
    .anime-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(37, 99, 235, 0.25); border-color: var(--border-hover); }
    .anime-card .card-img-top { aspect-ratio: 2/3; object-fit: cover; width: 100%; background-color: var(--bg-input); transition: transform 0.3s ease; }
    .anime-card:hover .card-img-top { transform: scale(1.02); }
    .anime-card .card-body { padding: 0.75rem; }
    .anime-card .card-title { color: var(--text-primary); font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.3; min-height: 2.6rem; }
    .anime-card .card-link { text-decoration: none; color: inherit; display: block; }
    .anime-card .card-link:hover { color: inherit; }
    .anime-card .badge-type { background: linear-gradient(135deg, #2563EB, #3B82F6); color: white; font-size: 0.6rem; padding: 0.2rem 0.6rem; font-weight: 600; border-radius: 4px; letter-spacing: 0.3px; text-transform: uppercase; }
    .anime-card .badge-episode { background-color: var(--bg-input); color: var(--text-secondary); font-size: 0.6rem; padding: 0.2rem 0.6rem; font-weight: 500; border-radius: 4px; border: 1px solid var(--border-color); }
    .anime-card .badge-rating { background-color: var(--rating-color); color: #1a1a1e; font-size: 0.6rem; padding: 0.2rem 0.6rem; font-weight: 700; border-radius: 4px; }
    .anime-card .badge-rating i { font-size: 0.5rem; margin-right: 2px; }
    .anime-card .card-meta { display: flex; flex-wrap: wrap; gap: 0.35rem; align-items: center; }

    .release-item { display: flex; align-items: center; padding: 0.6rem 0.75rem; background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 0.6rem; transition: all 0.3s ease; text-decoration: none; color: var(--text-primary); gap: 0.75rem; }
    .release-item:hover { background-color: var(--bg-card-hover); border-color: var(--border-hover); transform: translateX(4px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15); color: var(--text-primary); }
    .release-item .release-thumb { width: 48px; height: 72px; object-fit: cover; border-radius: 4px; background-color: var(--bg-input); flex-shrink: 0; }
    .release-item .release-info { flex: 1; min-width: 0; }
    .release-item .release-title { font-size: 0.8rem; font-weight: 600; margin-bottom: 0.15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.2; }
    .release-item .release-time { font-size: 0.7rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.25rem; }
    .release-item .release-badge { background: linear-gradient(135deg, #2563EB, #3B82F6); color: white; font-size: 0.55rem; padding: 0.15rem 0.5rem; border-radius: 50px; font-weight: 600; flex-shrink: 0; text-transform: uppercase; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2); }

    .continue-card { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; padding: 0.75rem; display: flex; align-items: center; gap: 1rem; transition: all 0.3s ease; text-decoration: none; color: var(--text-primary); height: 100%; }
    .continue-card:hover { background-color: var(--bg-card-hover); border-color: var(--border-hover); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37, 99, 235, 0.15); color: var(--text-primary); }
    .continue-card .continue-thumb { width: 64px; height: 96px; object-fit: cover; border-radius: 4px; background-color: var(--bg-input); flex-shrink: 0; }
    .continue-card .continue-info { flex: 1; min-width: 0; }
    .continue-card .continue-title { font-size: 0.9rem; font-weight: 600; margin-bottom: 0.15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .continue-card .continue-episode { font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.5rem; }
    .continue-card .btn-resume { background: linear-gradient(135deg, #2563EB, #3B82F6); color: white; border: none; padding: 0.3rem 1.2rem; font-size: 0.8rem; font-weight: 600; border-radius: 50px; transition: all 0.3s ease; display: inline-block; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); }
    .continue-card .btn-resume:hover { transform: scale(1.02); box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35); color: white; }

    .stat-card { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; padding: 1rem 0.75rem; text-align: center; transition: all 0.3s ease; height: 100%; }
    .stat-card:hover { border-color: var(--border-hover); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37, 99, 235, 0.1); }
    .stat-card .stat-icon { font-size: 1.8rem; margin-bottom: 0.25rem; display: block; }
    .stat-card .stat-number { font-size: 1.5rem; font-weight: 700; color: var(--text-primary); display: block; }
    .stat-card .stat-label { font-size: 0.75rem; color: var(--text-secondary); font-weight: 500; display: block; margin-top: 0.1rem; }

    .recent-item { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 6px; padding: 0.6rem 0.75rem; transition: all 0.3s ease; text-decoration: none; color: var(--text-primary); display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; }
    .recent-item:hover { background-color: var(--bg-card-hover); border-color: var(--border-hover); color: var(--text-primary); }
    .recent-item .recent-title { font-weight: 500; font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; }
    .recent-item .recent-meta { color: var(--text-secondary); font-size: 0.75rem; white-space: nowrap; }
    .recent-item .recent-time { color: var(--text-muted); font-size: 0.7rem; white-space: nowrap; }

    .pagination-custom { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; justify-content: center; padding: 0.5rem 0; }
    .pagination-custom .btn { min-width: 48px; height: 48px; background-color: var(--bg-card); border: 1px solid #1E293B; color: #CBD5E1; font-weight: 500; padding: 0 1.2rem; transition: all 0.3s ease; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; }
    .pagination-custom .btn:hover { transform: translateY(-2px); border-color: var(--accent-color); color: var(--text-primary); background-color: var(--bg-card-hover); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15); }
    .pagination-custom .btn-primary { background: linear-gradient(135deg, #2563EB, #3B82F6); border-color: transparent; color: white; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35); }
    .pagination-custom .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(37, 99, 235, 0.45); background: linear-gradient(135deg, #2563EB, #3B82F6); border-color: transparent; color: white; }
    .pagination-custom .btn:disabled { opacity: 0.5; pointer-events: none; }

    .view-more-btn { display: block; text-align: center; padding: 0.5rem; background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-secondary); text-decoration: none; font-weight: 500; font-size: 0.85rem; transition: all 0.3s ease; margin-top: 0.5rem; }
    .view-more-btn:hover { background-color: var(--bg-card-hover); border-color: var(--border-hover); color: var(--text-primary); }
    .view-more-btn i { margin-left: 0.3rem; transition: transform 0.3s ease; }
    .view-more-btn:hover i { transform: translateX(4px); }

    /* ============================================================
       SKELETON - Matches final 2-card layout
       ============================================================ */
    .skeleton-grid .row {
      --bs-gutter-x: 0.5rem;
      --bs-gutter-y: 0.5rem;
    }
    
    .skeleton-card {
      background: var(--bg-card);
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid var(--border-color);
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    
    .skeleton-card .skeleton-img {
      aspect-ratio: 2/3;
      width: 100%;
      background: linear-gradient(90deg, #1a2332 25%, #2a3344 50%, #1a2332 75%);
      background-size: 200% 100%;
      animation: shimmer 1.2s infinite;
    }
    
    .skeleton-card .skeleton-body {
      padding: 0.75rem;
      flex: 1 1 auto;
      display: flex;
      flex-direction: column;
      gap: 0.45rem;
    }
    
    .skeleton-card .skeleton-text {
      height: 12px;
      background: linear-gradient(90deg, #1a2332 25%, #2a3344 50%, #1a2332 75%);
      background-size: 200% 100%;
      animation: shimmer 1.2s infinite;
      border-radius: 4px;
    }
    
    .skeleton-card .skeleton-text.title-line {
      height: 16px;
      min-height: 2.2em;
    }
    
    .skeleton-card .skeleton-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 0.4rem 0.35rem;
      margin-top: auto;
      padding-top: 0.1rem;
    }
    
    .skeleton-card .skeleton-badge {
      height: 20px;
      width: 45px;
      background: linear-gradient(90deg, #1a2332 25%, #2a3344 50%, #1a2332 75%);
      background-size: 200% 100%;
      animation: shimmer 1.2s infinite;
      border-radius: 20px;
    }
    
    .skeleton-card .skeleton-badge.year {
      width: 35px;
    }
    
    @keyframes shimmer {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }

    .fade-enter { opacity: 0; transition: opacity 0.18s ease; }
    .fade-enter-active { opacity: 1; }
    #contentContainer { transition: opacity 0.18s ease; }

    /* ============================================================== */
    /*  RESPONSIVE: Compact Header & Hero Behavior                   */
    /* ============================================================== */

    /* Desktop (>= 992px) */
    @media (min-width: 992px) {
      .compact-header {
        display: flex;
      }
      
      .app-header {
        display: none !important;
      }
      
      .hero-header {
        min-height: calc(100vh - var(--header-height));
        padding: 1rem 0 2rem 0;
      }
      
      .hero-header.collapsed {
        min-height: 0 !important;
        height: 0 !important;
        padding: 0 !important;
        opacity: 0;
        border-bottom: none;
        pointer-events: none;
        margin: 0;
        overflow: hidden;
      }
      
      .hero-header.collapsed .hero-content {
        transform: scale(0.8);
        opacity: 0;
        pointer-events: none;
      }
      
      .app-sidebar {
        top: var(--header-height);
        height: calc(100vh - var(--header-height));
      }
      
      .app-releases {
        top: var(--header-height);
        height: calc(100vh - var(--header-height));
      }

      .search-overlay .search-form {
        max-width: 500px;
      }
    }

    /* Mobile (< 992px) */
    @media (max-width: 991.98px) {
      .compact-header {
        display: flex;
        padding: 0 1rem;
        height: 60px;
      }
      
      .app-header {
        display: none !important;
      }
      
      .hero-header {
        min-height: calc(100vh - var(--header-height));
        padding: 0.5rem 0 1.5rem 0;
      }
      
      .hero-header.collapsed {
        min-height: 0 !important;
        height: 0 !important;
        padding: 0 !important;
        opacity: 0;
        border-bottom: none;
        pointer-events: none;
        margin: 0;
        overflow: hidden;
      }
      
      .hero-header.collapsed .hero-content {
        transform: scale(0.8);
        opacity: 0;
        pointer-events: none;
      }
      
      .app-body {
        display: block;
      }
      .app-sidebar {
        display: none;
        position: fixed;
        top: var(--header-height);
        left: 0;
        bottom: 0;
        width: 280px;
        background-color: var(--bg-sidebar);
        border-right: 1px solid var(--border-color);
        z-index: 999;
        padding-top: 1rem;
        height: calc(100vh - var(--header-height));
        overflow-y: auto;
      }
      .app-sidebar.open {
        display: block;
      }
      .app-main {
        padding: 1rem;
        width: 100%;
        flex: none;
        padding-top: 0.5rem;
      }
      .app-releases {
        position: static;
        width: 100%;
        max-width: 100%;
        height: auto;
        padding: 0;
        margin: 24px 0;
        background: transparent;
        border: none;
        box-shadow: none;
        overflow: visible;
        flex-shrink: 1;
        border-top: none;
      }
      .app-releases .release-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        width: 100%;
        padding: 0;
        margin: 0;
      }
      .app-releases .release-item {
        width: 100%;
        max-width: 100%;
        display: flex;
        align-items: center;
        padding: 14px;
        margin: 0;
        border-radius: 12px;
        gap: 14px;
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        box-sizing: border-box;
        transition: all 0.3s ease;
      }
      .app-releases .release-item:hover {
        transform: translateX(0);
        background-color: var(--bg-card-hover);
        border-color: var(--border-hover);
      }
      .app-releases .release-thumb {
        width: 56px;
        height: 80px;
        flex-shrink: 0;
        border-radius: 6px;
      }
      .app-releases .release-title {
        font-size: 0.9rem;
        font-weight: 600;
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
        line-height: 1.3;
        margin-bottom: 4px;
      }
      .app-releases .release-time {
        font-size: 0.75rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 4px;
      }
      .app-releases .release-badge {
        flex-shrink: 0;
        font-size: 0.6rem;
        padding: 4px 10px;
      }
      .app-releases .view-more-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 100%;
        margin-top: 18px;
        padding: 14px;
        border-radius: 12px;
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-sizing: border-box;
      }
      .app-releases .view-more-btn:hover {
        background-color: var(--bg-card-hover);
        border-color: var(--border-hover);
        color: var(--text-primary);
      }
      .app-releases .view-more-btn i {
        margin-left: 6px;
        transition: transform 0.3s ease;
      }
      .app-releases .view-more-btn:hover i {
        transform: translateX(4px);
      }
      
      /* Skeleton mobile - 2 cards per row */
      .skeleton-grid .row .col-3.col-md-2.col-xl-2 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
      }
      
      /* Compact header mobile adjustments */
      .compact-header .compact-brand .brand-name {
        font-size: 0.95rem;
      }
      .compact-header .compact-hero-banner {
        width: 36px;
        height: 36px;
      }
      .compact-header .action-btn {
        font-size: 1.1rem;
        padding: 0.4rem 0.5rem;
        min-width: 36px;
        min-height: 36px;
      }
      .compact-header .compact-brand .brand-jp {
        display: none;
      }

      .search-overlay {
        padding: 0.5rem 1rem;
        top: 60px;
      }
      .search-overlay .search-form .search-input {
        height: 40px;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
      }
      .search-overlay .search-close {
        min-width: 32px;
        min-height: 32px;
        font-size: 1rem;
        padding: 0.3rem 0.4rem;
      }
    }

    @media (max-width: 480px) {
      .compact-header {
        padding: 0 0.75rem;
        height: 56px;
        gap: 0.5rem;
      }
      .compact-header .compact-brand .brand-name {
        font-size: 0.85rem;
      }
      .compact-header .compact-brand .brand-sub {
        font-size: 0.45rem;
        letter-spacing: 1.2px;
      }
      .compact-header .compact-hero-banner {
        width: 32px;
        height: 32px;
        border-radius: 8px;
      }
      .compact-header .action-btn {
        font-size: 1rem;
        padding: 0.3rem 0.4rem;
        min-width: 32px;
        min-height: 32px;
        border-radius: 8px;
      }
      .compact-header .compact-left {
        gap: 0.5rem;
      }

      .search-overlay {
        padding: 0.4rem 0.75rem;
        top: 56px;
      }
      .search-overlay .search-form .search-input {
        height: 36px;
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
      }
      .search-overlay .search-close {
        min-width: 28px;
        min-height: 28px;
        font-size: 0.9rem;
        padding: 0.2rem 0.3rem;
      }
    }

    /* Responsive hero sizes */
    @media (max-width: 1200px) {
      .hero-artwork { max-width: 750px; }
      .hero-team { max-height: 450px; }
      .hero-brand .brand-name { font-size: 4.2rem; }
      .hero-brand .brand-sub { font-size: 1.3rem; }
      .hero-brand .brand-jp { font-size: 1.1rem; }
    }

    @media (max-width: 768px) {
      .hero-artwork { max-width: 400px; }
      .hero-team { max-height: 280px; }
      .hero-brand .brand-name { font-size: 2.8rem; }
      .hero-brand .brand-sub { font-size: 0.95rem; letter-spacing: 3px; }
      .hero-brand .brand-jp { font-size: 0.85rem; }
      .hero-search .search-form .form-control {
        height: 52px;
        font-size: 0.95rem;
        padding: 0.7rem 1.5rem;
      }
      .hero-search .search-form .btn-search {
        height: 40px;
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
      }
    }

    @media (max-width: 576px) {
      .hero-artwork { max-width: 300px; }
      .hero-team { max-height: 220px; }
      .hero-brand .brand-name { font-size: 2.2rem; }
      .hero-brand .brand-sub { font-size: 0.8rem; letter-spacing: 2px; }
      .hero-brand .brand-jp { font-size: 0.75rem; }
      .hero-search .search-form .form-control {
        height: 46px;
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
      }
      .hero-search .search-form .btn-search {
        height: 36px;
        padding: 0.3rem 1rem;
        font-size: 0.75rem;
        right: 4px;
      }
    }

    @media (max-width: 400px) {
      .hero-artwork { max-width: 230px; }
      .hero-team { max-height: 170px; }
      .hero-brand .brand-name { font-size: 1.8rem; }
      .hero-brand .brand-sub { font-size: 0.7rem; letter-spacing: 1.5px; }
      .hero-brand .brand-jp { font-size: 0.65rem; }
    }
  </style>
</head>
<body>
<div class="app-container">
  <!-- ===== PREMIUM COMPACT STICKY HEADER ===== -->
  <header class="compact-header" id="compactHeader">
    <div class="compact-left">
      <!-- Hamburger button -->
      <button class="action-btn" id="mobileNavToggleCompact" aria-label="Toggle navigation">
        <i class="bi bi-list"></i>
      </button>
      
      <!-- Small hero banner crop -->
      <div class="compact-hero-banner" onclick="window.scrollTo({top:0,behavior:'smooth'})" style="cursor:pointer;">
        <img src="/images/my-team.png?v={{ time() }}" alt="BoldniWally" loading="lazy">
      </div>
      
      <!-- Brand text -->
      <div class="compact-brand" onclick="window.scrollTo({top:0,behavior:'smooth'})" style="cursor:pointer;">
        <span class="brand-name">BoldniWally</span>
        <span class="brand-sub">ANIME STREAMING</span>
        <span class="brand-jp">アニメを楽しもう</span>
      </div>
    </div>
    
    <div class="compact-actions">
      <!-- Search button -->
      <button class="action-btn" id="searchToggleCompact" aria-label="Search">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </header>

  <!-- ===== SIMPLIFIED SEARCH OVERLAY (No Search Button) ===== -->
  <div class="search-overlay" id="searchOverlay">
    <form action="/search" method="GET" class="search-form" id="searchFormOverlay">
      <input 
        type="text" 
        name="q" 
        class="search-input" 
        id="searchInputOverlay"
        placeholder="Search anime, genres, titles..." 
        autocomplete="off"
        required>
    </form>
    <button class="search-close" id="searchClose" aria-label="Close search">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

  <!-- ===== HERO SECTION (collapsible on all devices) ===== -->
  <section class="hero-header" id="heroSection">
    <div class="hero-content">
      <!-- Large centered character artwork -->
      <div class="hero-artwork" id="heroArtwork">
        <img
          src="/images/my-team.png?v={{ time() }}"
          alt="BoldniWally Hero"
          class="hero-team"
          onerror="console.log('FAILED', this.src)"
          onload="console.log('LOADED', this.src)">
      </div>

      <!-- BoldniWally Branding centerpiece -->
      <div class="hero-brand" id="heroBrand">
        <span class="brand-name" id="heroTitle">BoldniWally</span>
        <span class="brand-sub" id="heroSub">ANIME STREAMING</span>
        <span class="brand-jp" id="heroJp">アニメを楽しもう</span>
      </div>

      <!-- Search bar -->
      <div class="hero-search" id="heroSearch">
        <form action="/search" method="GET" class="search-form" id="searchFormHero">
          <input type="text" name="q" class="form-control" placeholder="Search anime, genres, titles..." required>
          <button type="submit" class="btn-search"><i class="bi bi-search"></i> Search</button>
        </form>
      </div>
    </div>
    <!-- soft fade into content -->
    <div class="hero-fade" id="heroFade"></div>
  </section>

  <!-- BODY (sidebar + main + releases) -->
  <div class="app-body">
    <!-- Sidebar -->
    <aside class="app-sidebar" id="appSidebar">
      <nav class="sidebar-nav">
        <a class="nav-link active" id="nav-home" data-section="home" href="/"><i class="bi bi-house-fill"></i> Home</a>
        <a class="nav-link" id="nav-anime-directory" data-section="anime-directory" href="/anime-directory"><i class="bi bi-grid-3x3-gap-fill"></i> All Anime</a>
        <a class="nav-link" id="nav-popular" data-section="popular" href="/popular"><i class="bi bi-fire"></i> Popular</a>
        <a class="nav-link" id="nav-top-rated" data-section="top-rated" href="/top-rated"><i class="bi bi-star-fill"></i> Top Rated</a>
        <a class="nav-link" id="nav-current-season" data-section="current-season" href="/current-season"><i class="bi bi-calendar-event"></i> Current Season</a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="app-main">
      <div id="contentContainer">
        <!-- default home content (server-rendered) -->
        @include('sections.home')
      </div>
    </main>

    <!-- Today's Releases -->
    @if(!empty($todayReleases))
    <aside class="app-releases">
      <h5 class="section-title">Today's Releases</h5>
      <div class="release-list">
        @php $releasesToShow = array_slice($todayReleases, 0, 10); @endphp
        @foreach($releasesToShow as $anime)
        <a href="/kaa-anime/{{ $anime['slug'] ?? '' }}" class="release-item">
          <img src="https://kaa.lt/image/poster/{{ $anime['poster'] ?? '' }}.webp" class="release-thumb" alt="{{ $anime['title'] }}" loading="lazy" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'72\'%3E%3Crect width=\'48\' height=\'72\' fill=\'%232a2a2e\'/%3E%3C/svg%3E'">
          <div class="release-info">
            <div class="release-title">{{ $anime['title'] }}</div>
            <div class="release-time"><i class="bi bi-clock"></i> {{ $anime['time'] ?? 'Today' }}</div>
          </div>
          <span class="release-badge">New</span>
        </a>
        @endforeach
        <a href="/schedule" class="view-more-btn">View More <i class="bi bi-arrow-right"></i></a>
      </div>
    </aside>
    @endif
  </div>
</div>

<script>
  (function() {
    "use strict";

    const content = document.getElementById('contentContainer');
    const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    const mobileToggle = document.getElementById('mobileNavToggle');
    const mobileToggleCompact = document.getElementById('mobileNavToggleCompact');
    const sidebar = document.getElementById('appSidebar');
    const searchForm = document.getElementById('searchFormHero');
    const searchFormHeader = document.getElementById('searchFormHeader');
    const searchFormOverlay = document.getElementById('searchFormOverlay');
    
    // Compact header elements
    const compactHeader = document.getElementById('compactHeader');
    const searchToggleCompact = document.getElementById('searchToggleCompact');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchInputOverlay = document.getElementById('searchInputOverlay');
    const searchClose = document.getElementById('searchClose');
    
    // Hero section
    const heroSection = document.getElementById('heroSection');

    // Cache original home HTML
    const originalHomeHTML = content.innerHTML;

    // ===== HERO COLLAPSE ON SCROLL (all devices) =====
    let isHeroCollapsed = false;
    let scrollTimeout = null;

    function handleHeroScroll() {
      const scrollY = window.scrollY;
      const heroHeight = heroSection ? heroSection.offsetHeight : 0;
      const triggerPoint = heroHeight * 0.1;
      
      if (scrollY > triggerPoint && !isHeroCollapsed) {
        heroSection.classList.add('collapsed');
        compactHeader.classList.add('visible');
        isHeroCollapsed = true;
      } else if (scrollY <= triggerPoint && isHeroCollapsed) {
        heroSection.classList.remove('collapsed');
        compactHeader.classList.remove('visible');
        isHeroCollapsed = false;
        // Close search overlay if open
        if (isSearchOpen) toggleSearch(false);
      }
    }

    function throttledScroll() {
      if (scrollTimeout) {
        window.cancelAnimationFrame(scrollTimeout);
      }
      scrollTimeout = window.requestAnimationFrame(() => {
        handleHeroScroll();
        scrollTimeout = null;
      });
    }

    // ===== SIMPLIFIED SEARCH TOGGLE =====
    let isSearchOpen = false;

    function toggleSearch(open) {
      if (open !== undefined) {
        isSearchOpen = open;
      } else {
        isSearchOpen = !isSearchOpen;
      }
      
      if (isSearchOpen) {
        searchOverlay.classList.add('open');
        // Auto-focus the input
        setTimeout(() => {
          if (searchInputOverlay) {
            searchInputOverlay.focus();
            // Place cursor at the end if there's text
            const len = searchInputOverlay.value.length;
            searchInputOverlay.setSelectionRange(len, len);
          }
        }, 350);
      } else {
        searchOverlay.classList.remove('open');
        // Clear the input after close animation
        setTimeout(() => {
          if (searchInputOverlay) {
            searchInputOverlay.value = '';
          }
        }, 400);
      }
    }

    // ===== INITIAL LOAD ANIMATIONS =====
    function triggerEntranceAnimations() {
      const heroArtwork = document.getElementById('heroArtwork');
      const heroBrand = document.getElementById('heroBrand');
      const heroTitle = document.getElementById('heroTitle');
      const heroSub = document.getElementById('heroSub');
      const heroJp = document.getElementById('heroJp');
      const heroSearch = document.getElementById('heroSearch');
      const heroFade = document.getElementById('heroFade');

      if (heroArtwork) {
        heroArtwork.classList.add('animate-hero-artwork');
      }
      if (heroTitle) {
        heroTitle.classList.add('animate-hero-brand');
      }
      if (heroSub) {
        heroSub.classList.add('animate-hero-sub');
      }
      if (heroJp) {
        heroJp.classList.add('animate-hero-jp');
      }
      if (heroSearch) {
        heroSearch.classList.add('animate-hero-search');
      }
      if (heroFade) {
        heroFade.classList.add('animate-hero-fade');
      }

      setTimeout(() => {
        if (heroArtwork) heroArtwork.classList.remove('animate-hero-artwork');
        if (heroTitle) heroTitle.classList.remove('animate-hero-brand');
        if (heroSub) heroSub.classList.remove('animate-hero-sub');
        if (heroJp) heroJp.classList.remove('animate-hero-jp');
        if (heroSearch) heroSearch.classList.remove('animate-hero-search');
        if (heroFade) heroFade.classList.remove('animate-hero-fade');
      }, 2000);
    }

    let isInitialLoad = true;

    if (document.readyState === 'complete') {
      triggerEntranceAnimations();
    } else {
      window.addEventListener('load', triggerEntranceAnimations);
    }

    // ===== SKELETON =====
    function skeletonGrid(count = 12) {
      let html = '<div class="skeleton-grid"><div class="row g-2">';
      for (let i = 0; i < count; i++) {
        html += `
          <div class="col-3 col-md-2 col-xl-2">
            <div class="skeleton-card">
              <div class="skeleton-img"></div>
              <div class="skeleton-body">
                <div class="skeleton-text title-line"></div>
                <div class="skeleton-meta">
                  <div class="skeleton-badge"></div>
                  <div class="skeleton-badge year"></div>
                </div>
              </div>
            </div>
          </div>
        `;
      }
      html += '</div></div>';
      return html;
    }

    function watchSkeleton() {
      return `
        <div class="watch-skeleton">
          <div class="player-placeholder mb-4" style="aspect-ratio:16/9;background:var(--bg-card);border-radius:12px;border:1px solid var(--border-color);display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:1.2rem;"><i class="bi bi-play-circle me-2"></i> Loading player...</div>
          <div class="row">
            <div class="col-lg-8">
              <div class="skeleton-text tall" style="width:60%;margin-bottom:12px;"></div>
              <div class="skeleton-text" style="width:40%;"></div>
              <div class="mt-4"><div class="skeleton-text" style="height:60px;"></div></div>
              <div class="mt-4"><h6 class="text-secondary">Episodes</h6><div class="episode-list-skeleton d-flex flex-wrap gap-2">${Array(8).fill('<div class="epi-skel" style="width:60px;height:36px;background:var(--bg-card);border-radius:6px;border:1px solid var(--border-color);"></div>').join('')}</div></div>
            </div>
            <div class="col-lg-4"><div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-text"></div></div></div>
          </div>
        </div>
      `;
    }

    async function loadRemoteSection(url, sectionKey, pushState = true) {
      if (isSearchOpen) toggleSearch(false);
      
      const isWatch = url.includes('/kaa-watch/') || url.includes('/watch/');
      content.style.opacity = '0';
      content.innerHTML = isWatch ? watchSkeleton() : skeletonGrid(12);
      content.style.opacity = '1';

      try {
        const fetchUrl = new URL(url, window.location.origin);
        fetchUrl.searchParams.set('section', '1');

        const resp = await fetch(fetchUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!resp.ok) throw new Error('Network error');
        const html = await resp.text();

        content.style.opacity = '0';
        setTimeout(() => {
          content.innerHTML = html;
          content.style.opacity = '1';
          bindPaginationForCurrentSection();
          setActiveSidebar(sectionKey);
          if (pushState) {
            try {
              const cleanUrl = url.split('?')[0] + (url.includes('?') ? '?' + url.split('?')[1] : '');
              window.history.pushState({ section: sectionKey }, '', cleanUrl);
            } catch(e) {}
          }
        }, 80);
      } catch (err) {
        content.style.opacity = '0';
        setTimeout(() => {
          content.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle-fill me-2"></i> Unable to load content. Please try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            ${skeletonGrid(6)}
          `;
          content.style.opacity = '1';
        }, 80);
      }
    }

    function restoreHome(pushState = true) {
      if (isSearchOpen) toggleSearch(false);
      
      content.style.opacity = '0';
      setTimeout(() => {
        content.innerHTML = originalHomeHTML;
        content.style.opacity = '1';
        setActiveSidebar('home');
        bindPaginationForCurrentSection();
        if (pushState) {
          try { window.history.pushState({ section: 'home' }, '', '/'); } catch(e) {}
        }
        if (window.innerWidth <= 991.98) sidebar.classList.remove('open');
        if (isInitialLoad) {
          triggerEntranceAnimations();
        }
        if (isHeroCollapsed) {
          heroSection.classList.remove('collapsed');
          compactHeader.classList.remove('visible');
          isHeroCollapsed = false;
        }
      }, 80);
    }

    function setActiveSidebar(sectionKey) {
      sidebarLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('data-section') === sectionKey) {
          link.classList.add('active');
        }
      });
    }

    function bindPaginationForCurrentSection() {
      document.querySelectorAll('[data-page]').forEach(btn => {
        btn.removeEventListener('click', handlePaginationClick);
        btn.addEventListener('click', handlePaginationClick);
      });
      document.querySelectorAll('a[href*="/kaa-watch/"], a[href*="/watch/"]').forEach(link => {
        link.removeEventListener('click', handleWatchClick);
        link.addEventListener('click', handleWatchClick);
      });
    }

    function handlePaginationClick(e) {
      e.preventDefault();
      const btn = this;
      const page = btn.dataset.page;
      if (!page) return;
      let baseUrl = btn.dataset.url || window.location.pathname;
      if (baseUrl.includes('?page=')) baseUrl = baseUrl.split('?page=')[0];
      else if (baseUrl.includes('&page=')) baseUrl = baseUrl.split('&page=')[0];
      const url = baseUrl.includes('?') ? baseUrl + '&page=' + page : baseUrl + '?page=' + page;
      const section = btn.dataset.section || 'anime-directory';
      loadRemoteSection(url, section);
      const top = content.getBoundingClientRect().top + window.pageYOffset - 20;
      window.scrollTo({ top, behavior: 'smooth' });
    }

    function handleWatchClick(e) {
      e.preventDefault();
      const url = this.href;
      loadRemoteSection(url, 'watch');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Sidebar navigation
    sidebarLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const href = this.getAttribute('href');
        const section = this.getAttribute('data-section') || 'home';
        if (section === 'home' || href === '/') { 
          restoreHome(true); 
          return; 
        }
        if (href) { 
          loadRemoteSection(href, section); 
          if (window.innerWidth <= 991.98) sidebar.classList.remove('open');
        }
      });
    });

    // Search forms - handle submission
    function handleSearch(e, form) {
      e.preventDefault();
      const query = form.querySelector('input[name="q"]').value.trim();
      if (!query) return;
      const url = '/search?q=' + encodeURIComponent(query);
      loadRemoteSection(url, 'search');
      window.scrollTo({ top: 0, behavior: 'smooth' });
      if (isSearchOpen) toggleSearch(false);
    }

    // Handle search submission from all forms
    if (searchForm) searchForm.addEventListener('submit', function(e) { handleSearch(e, this); });
    if (searchFormHeader) searchFormHeader.addEventListener('submit', function(e) { handleSearch(e, this); });
    if (searchFormOverlay) searchFormOverlay.addEventListener('submit', function(e) { handleSearch(e, this); });

    // Watch clicks (delegated)
    document.addEventListener('click', function(e) {
      const link = e.target.closest('a[href*="/kaa-watch/"], a[href*="/watch/"]');
      if (link) { 
        e.preventDefault(); 
        loadRemoteSection(link.href, 'watch'); 
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });

    // ===== MOBILE TOGGLES =====
    if (mobileToggle && sidebar) {
      mobileToggle.addEventListener('click', function(e) { 
        e.stopPropagation(); 
        sidebar.classList.toggle('open'); 
      });
    }
    
    if (mobileToggleCompact && sidebar) {
      mobileToggleCompact.addEventListener('click', function(e) { 
        e.stopPropagation(); 
        sidebar.classList.toggle('open'); 
      });
    }
    
    document.addEventListener('click', function(e) {
      if (window.innerWidth <= 991.98 && 
          !sidebar.contains(e.target) && 
          e.target !== mobileToggle && 
          e.target !== mobileToggleCompact &&
          !mobileToggle?.contains(e.target) &&
          !mobileToggleCompact?.contains(e.target)) {
        sidebar.classList.remove('open');
      }
    });

    // ===== COMPACT HEADER SEARCH =====
    if (searchToggleCompact) {
      searchToggleCompact.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleSearch();
      });
    }
    
    if (searchClose) {
      searchClose.addEventListener('click', function() {
        toggleSearch(false);
      });
    }
    
    // Close search on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && isSearchOpen) {
        toggleSearch(false);
      }
    });
    
    // Close search on outside click
    document.addEventListener('click', function(e) {
      if (isSearchOpen && 
          !searchOverlay.contains(e.target) && 
          e.target !== searchToggleCompact &&
          !searchToggleCompact?.contains(e.target)) {
        toggleSearch(false);
      }
    });

    // ===== SCROLL HANDLER =====
    window.addEventListener('scroll', throttledScroll, { passive: true });
    
    setTimeout(() => {
      handleHeroScroll();
    }, 100);

    // ===== RESIZE HANDLER =====
    let resizeTimeout = null;
    window.addEventListener('resize', function() {
      if (resizeTimeout) {
        window.cancelAnimationFrame(resizeTimeout);
      }
      resizeTimeout = window.requestAnimationFrame(() => {
        handleHeroScroll();
        resizeTimeout = null;
      });
    });

    // Init
    setActiveSidebar('home');
    bindPaginationForCurrentSection();

    // Popstate
    window.addEventListener('popstate', function(e) {
      const section = e.state?.section || 'home';
      if (section === 'home') restoreHome(false);
      else {
        const url = window.location.pathname + window.location.search;
        if (url && url !== '/') loadRemoteSection(url, section, false);
        else restoreHome(false);
      }
    });

    console.log('✨ BoldNiwally · Instant search with auto-focus, no extra button.');
  })();
</script>
</body>
</html>