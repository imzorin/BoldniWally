<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $anime['title'] }} — MondigSAnime</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* ============================================
           MONDiGSANIME PREMIUM BLUE THEME (unchanged)
           ============================================ */
        :root {
            --bg-dark: #050816;
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
            --shadow-color: rgba(37, 99, 235, 0.15);
            --glass-bg: rgba(17, 24, 39, 0.5);
            --skeleton-base: #1a2332;
            --skeleton-shine: #2a3a5a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
            background-image: radial-gradient(ellipse at 20% 20%, rgba(37, 99, 235, 0.03) 0%, transparent 60%);
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent-color); }

        /* ============================================
           SKELETON LOADING (unchanged)
           ============================================ */
        .skeleton {
            background: linear-gradient(90deg, var(--skeleton-base) 25%, var(--skeleton-shine) 50%, var(--skeleton-base) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s ease-in-out infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .skeleton-hero {
            height: 600px;
            border-radius: 16px;
            margin-bottom: 2rem;
        }

        .skeleton-poster {
            width: 100%;
            height: 300px;
            border-radius: 16px;
        }

        .skeleton-title {
            height: 32px;
            width: 45%;
            margin-bottom: 0.75rem;
        }

        .skeleton-text {
            height: 18px;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .skeleton-text.short {
            width: 25%;
        }

        .skeleton-chip {
            height: 24px;
            width: 60px;
            border-radius: 50px;
            display: inline-block;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .skeleton-card {
            height: 200px;
            border-radius: 12px;
            flex: 0 0 160px;
            margin-right: 1rem;
        }

        /* ============================================
           HERO SECTION - DESKTOP LAYOUT (PERFECT, UNTOUCHED)
           ============================================ */
        .anime-hero {
            position: relative;
            padding: 0;
            margin-bottom: 2.5rem;
            border-radius: 16px;
            overflow: hidden;
            background: var(--bg-card);
            height: 65vh;
            min-height: 550px;
            max-height: 700px;
            isolation: isolate;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        }

        .hero-background {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .hero-background iframe {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100vw;
            height: 100vh;
            transform: translate(-50%, -50%);
            pointer-events: none;
            border: 0;
        }

        .hero-background .fallback-image {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center 30%;
            filter: blur(60px) brightness(0.4);
            transform: scale(1.1);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(180deg,
                rgba(5, 8, 22, 0.2) 0%,
                rgba(5, 8, 22, 0.1) 20%,
                rgba(5, 8, 22, 0.2) 40%,
                rgba(5, 8, 22, 0.6) 70%,
                rgba(5, 8, 22, 0.85) 100%
            );
        }

        /* DESKTOP: flex row, poster + info side by side, info at bottom */
        .anime-hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 2rem;
            align-items: flex-end;
            padding: 0 2rem 2.5rem;
            height: 100%;
        }

        .anime-poster-wrapper {
            flex: 0 0 160px;
            position: relative;
            margin-bottom: 0;
            transform: translateY(0);
        }

        .anime-poster {
            width: 100%;
            border-radius: 14px;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.7);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .anime-poster:hover {
            transform: translateY(-4px) scale(1.03);
            border-color: var(--accent-color);
            box-shadow: 0 16px 56px rgba(37, 99, 235, 0.3), 0 0 60px rgba(37, 99, 235, 0.1);
        }

        .anime-info {
            flex: 1;
            max-width: 48%;
            min-width: 0;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(59, 130, 246, 0.1);
            border-radius: 16px;
            padding: 1.5rem 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            margin-bottom: 0;
        }

        .anime-info:hover {
            border-color: rgba(59, 130, 246, 0.2);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.4);
            background: rgba(17, 24, 39, 0.55);
        }

        .anime-title {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 0.15rem;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
        }

        .anime-title-japanese {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            font-weight: 400;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .anime-status-badge {
            display: inline-block;
            padding: 0.15rem 0.8rem;
            border-radius: 50px;
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
            color: white;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
        }

        .info-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
            margin-bottom: 0.6rem;
        }

        .info-chip {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.2rem 0.7rem;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(59, 130, 246, 0.08);
            border-radius: 8px;
            min-width: 50px;
            transition: all 0.3s ease;
        }

        .info-chip:hover {
            border-color: var(--accent-color);
            background: rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        .info-chip-label {
            font-size: 0.45rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .info-chip-value {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 0.05rem;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-bottom: 0.6rem;
        }

        .btn-watch-now {
            padding: 0.5rem 1.6rem;
            background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-watch-now:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 32px rgba(37, 99, 235, 0.4);
            color: white;
        }

        .btn-watch-now i {
            font-size: 1rem;
        }

        .btn-action {
            padding: 0.35rem 0.9rem;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(59, 130, 246, 0.12);
            border-radius: 50px;
            color: var(--text-secondary);
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
        }

        .btn-action:hover {
            border-color: var(--accent-color);
            color: var(--text-primary);
            background: rgba(0, 0, 0, 0.5);
            transform: translateY(-2px);
        }

        .btn-action i {
            font-size: 0.7rem;
        }

        .genres-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
            margin-bottom: 0.4rem;
        }

        .genre-pill {
            padding: 0.1rem 0.7rem;
            border: 1.5px solid rgba(59, 130, 246, 0.15);
            border-radius: 50px;
            font-size: 0.6rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            text-decoration: none;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
        }

        .genre-pill:hover {
            border-color: var(--accent-color);
            color: var(--text-primary);
            background: rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        .studios-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
        }

        .studio-pill {
            padding: 0.1rem 0.7rem;
            border: 1.5px solid rgba(37, 99, 235, 0.1);
            border-radius: 50px;
            font-size: 0.6rem;
            color: var(--text-muted);
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
        }

        /* ============================================
           SYNOPSIS & OTHER SECTIONS (unchanged)
           ============================================ */
        .synopsis-card {
            background: var(--glass-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(8px);
        }

        .synopsis-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
        }

        .synopsis-card p {
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .horizontal-scroll-section {
            margin-bottom: 2.5rem;
        }

        .horizontal-scroll-section h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .horizontal-scroll-section h3 i {
            color: var(--accent-light);
        }

        .scroll-container {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            padding: 0.5rem 0 1.5rem;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .scroll-container::-webkit-scrollbar {
            height: 4px;
        }
        .scroll-container::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }
        .scroll-container::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 2px;
        }

        .scroll-item {
            flex: 0 0 160px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--text-primary);
        }

        .scroll-item:hover {
            transform: translateY(-4px);
        }

        .scroll-item-img {
            width: 100%;
            aspect-ratio: 2/3;
            object-fit: cover;
            border-radius: 12px;
            background: var(--bg-card);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .scroll-item:hover .scroll-item-img {
            border-color: var(--accent-color);
            box-shadow: 0 8px 32px rgba(37, 99, 235, 0.2);
        }

        .scroll-item-title {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            font-weight: 600;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: var(--text-secondary);
        }

        .scroll-item:hover .scroll-item-title {
            color: var(--text-primary);
        }

        .character-item {
            flex: 0 0 120px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .character-item:hover {
            transform: translateY(-4px);
        }

        .character-item-img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
            background: var(--bg-card);
        }

        .character-item:hover .character-item-img {
            border-color: var(--accent-color);
            box-shadow: 0 0 30px rgba(37, 99, 235, 0.15);
        }

        .character-item-name {
            font-size: 0.7rem;
            margin-top: 0.5rem;
            font-weight: 600;
            color: var(--text-secondary);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .character-item:hover .character-item-name {
            color: var(--text-primary);
        }

        .reviews-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .review-card {
            background: var(--glass-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .review-card:hover {
            border-color: var(--accent-color);
            background: var(--bg-card-hover);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .review-rating {
            font-weight: 700;
            color: var(--accent-light);
        }

        .review-text {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }

        .review-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-delete-review {
            padding: 0.25rem 0.75rem;
            background: transparent;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 50px;
            color: #ef4444;
            font-size: 0.7rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-delete-review:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
        }

        .review-form {
            background: var(--glass-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .review-form h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .review-form .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .review-form .form-control {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .review-form .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            background: var(--bg-card-hover);
        }

        .review-form .form-control::placeholder {
            color: var(--text-muted);
        }

        .btn-submit-review {
            padding: 0.6rem 2rem;
            background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-submit-review:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(37, 99, 235, 0.3);
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            padding: 0.45rem 1.2rem;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            background-color: var(--bg-card);
            transition: all 0.25s ease;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(4px);
            position: relative;
            z-index: 10;
        }
        .back-home i {
            font-size: 1rem;
            transition: transform 0.2s;
        }
        .back-home:hover {
            color: var(--text-primary);
            border-color: var(--border-hover);
            background-color: var(--bg-card-hover);
            box-shadow: 0 4px 20px var(--shadow-color);
            transform: translateX(-3px);
        }
        .back-home:hover i {
            transform: translateX(-4px);
        }

        /* ============================================
           RESPONSIVE: TABLET & MOBILE OVERRIDES
           Desktop (≥1024px) remains untouched.
           ============================================ */

        /* TABLET (768px – 1023px): trailer only, content below */
        @media (max-width: 1023px) and (min-width: 768px) {
            /* Hero becomes a pure trailer container */
            .anime-hero {
                height: 50vh; /* reduced, trailer focused */
                min-height: 380px;
                max-height: 520px;
                margin-bottom: 1.5rem;
                padding: 0;
            }

            /* Remove the flex row, poster and info are moved out */
            .anime-hero-content {
                display: none;
            }

            /* Poster is now outside hero, we'll render it via a new container */
            /* We move poster + info into a new section below hero */
        }

        /* MOBILE (<768px): full separation */
        @media (max-width: 767.98px) {
            .anime-hero {
                height: 40vh;
                min-height: 280px;
                max-height: 420px;
                margin-bottom: 1.25rem;
                padding: 0;
                border-radius: 12px;
            }

            .anime-hero-content {
                display: none; /* hide the floating content */
            }
        }

        /* ============================================
           NEW: POSTER + INFO SECTION (tablet & mobile)
           This replaces the hero-content on small screens.
           We render it inside the same container.
           ============================================ */
        .poster-info-section {
            display: none; /* hidden by default, shown on tablet/mobile */
        }

        @media (max-width: 1023px) {
            .poster-info-section {
                display: block;
                margin-top: 0;
                padding: 0 0.5rem;
            }

            .poster-info-section .poster-row {
                display: flex;
                gap: 1.5rem;
                align-items: flex-start;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
            }

            .poster-info-section .poster-wrapper {
                flex: 0 0 140px;
                width: 140px;
                margin-top: -20px; /* tiny overlap with trailer */
                z-index: 3;
                position: relative;
            }

            .poster-info-section .poster-wrapper img {
                width: 100%;
                border-radius: 14px;
                box-shadow: 0 12px 40px rgba(0,0,0,0.7);
                border: 2px solid transparent;
                transition: all 0.3s ease;
            }

            .poster-info-section .poster-wrapper img:hover {
                border-color: var(--accent-color);
                transform: scale(1.02);
            }

            .poster-info-section .info-card {
                flex: 1;
                min-width: 0;
                background: var(--glass-bg);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(59, 130, 246, 0.1);
                border-radius: 16px;
                padding: 1.25rem 1.5rem;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                transition: all 0.3s ease;
            }

            .poster-info-section .info-card:hover {
                border-color: rgba(59, 130, 246, 0.2);
                background: rgba(17, 24, 39, 0.55);
            }

            .poster-info-section .info-card .anime-title {
                font-size: 1.6rem;
            }

            .poster-info-section .info-card .anime-title-japanese {
                font-size: 0.85rem;
                color: var(--text-secondary);
                margin-bottom: 0.5rem;
            }

            /* Re-use existing styles for chips, buttons, etc. */
            .poster-info-section .info-card .info-chips {
                display: flex;
                flex-wrap: wrap;
                gap: 0.35rem;
                margin-bottom: 0.6rem;
            }
            .poster-info-section .info-card .info-chip {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 0.2rem 0.7rem;
                background: rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(4px);
                border: 1px solid rgba(59, 130, 246, 0.08);
                border-radius: 8px;
                min-width: 50px;
            }
            .poster-info-section .info-card .info-chip-label {
                font-size: 0.45rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: var(--text-muted);
                font-weight: 600;
            }
            .poster-info-section .info-card .info-chip-value {
                font-size: 0.7rem;
                font-weight: 700;
                color: var(--text-primary);
            }
            .poster-info-section .info-card .action-buttons {
                display: flex;
                flex-wrap: wrap;
                gap: 0.4rem;
                margin-bottom: 0.6rem;
            }
            .poster-info-section .info-card .genres-list {
                display: flex;
                flex-wrap: wrap;
                gap: 0.3rem;
                margin-bottom: 0.4rem;
            }
            .poster-info-section .info-card .studios-list {
                display: flex;
                flex-wrap: wrap;
                gap: 0.3rem;
            }
            .poster-info-section .info-card .anime-status-badge {
                display: inline-block;
                padding: 0.15rem 0.8rem;
                border-radius: 50px;
                font-size: 0.6rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 0.5rem;
                background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
                color: white;
                box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
            }

            /* Tablet specific adjustments */
            @media (max-width: 1023px) and (min-width: 768px) {
                .poster-info-section .poster-wrapper {
                    flex: 0 0 130px;
                    width: 130px;
                    margin-top: -30px; /* tiny overlap */
                }
                .poster-info-section .info-card .anime-title {
                    font-size: 1.5rem;
                }
                .poster-info-section .info-card {
                    padding: 1.25rem 1.5rem;
                }
            }

            /* Mobile specific adjustments */
            @media (max-width: 767.98px) {
                .poster-info-section .poster-row {
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                    gap: 1rem;
                }
                .poster-info-section .poster-wrapper {
                    flex: 0 0 120px;
                    width: 120px;
                    margin-top: -20px;
                }
                .poster-info-section .info-card {
                    width: 100%;
                    padding: 1rem 1rem;
                }
                .poster-info-section .info-card .anime-title {
                    font-size: 1.3rem;
                }
                .poster-info-section .info-card .info-chips {
                    justify-content: center;
                }
                .poster-info-section .info-card .action-buttons {
                    justify-content: center;
                }
                .poster-info-section .info-card .genres-list {
                    justify-content: center;
                }
                .poster-info-section .info-card .studios-list {
                    justify-content: center;
                }
                .poster-info-section .info-card .info-chip {
                    min-width: 45px;
                    padding: 0.2rem 0.5rem;
                }
                .poster-info-section .info-card .info-chip-value {
                    font-size: 0.65rem;
                }
                .btn-watch-now {
                    padding: 0.4rem 1.2rem;
                    font-size: 0.75rem;
                }
            }

            @media (max-width: 480px) {
                .poster-info-section .poster-wrapper {
                    flex: 0 0 100px;
                    width: 100px;
                    margin-top: -16px;
                }
                .poster-info-section .info-card {
                    padding: 0.75rem 0.75rem;
                }
                .poster-info-section .info-card .anime-title {
                    font-size: 1.1rem;
                }
                .poster-info-section .info-card .info-chip {
                    min-width: 40px;
                    padding: 0.15rem 0.4rem;
                }
                .poster-info-section .info-card .info-chip-value {
                    font-size: 0.6rem;
                }
                .action-buttons {
                    flex-direction: column;
                    align-items: center;
                    gap: 0.3rem;
                }
                .btn-watch-now {
                    width: 100%;
                    justify-content: center;
                }
            }
        }

        /* Fade in animation (unchanged) */
        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-delay-1 { animation-delay: 0.1s; opacity: 0; }
        .fade-in-delay-2 { animation-delay: 0.2s; opacity: 0; }
        .fade-in-delay-3 { animation-delay: 0.3s; opacity: 0; }
        .fade-in-delay-4 { animation-delay: 0.4s; opacity: 0; }
        .fade-in-delay-5 { animation-delay: 0.5s; opacity: 0; }
    </style>
</head>
<body>

<div class="container" style="max-width: 1280px; padding: 1.5rem 1rem;">

    {{-- BACK BUTTON --}}
    <a href="/" class="back-home">
        <i class="bi bi-arrow-left"></i> Back to Home
    </a>

    {{-- SKELETON LOADER --}}
    <div id="skeletonLoader">
        <div class="skeleton skeleton-hero"></div>
        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
            <div style="flex: 0 0 160px;">
                <div class="skeleton skeleton-poster"></div>
            </div>
            <div style="flex: 1; min-width: 0; max-width: 48%;">
                <div class="skeleton skeleton-title"></div>
                <div class="skeleton skeleton-text short" style="width: 25%;"></div>
                <div class="skeleton skeleton-text" style="width: 20%;"></div>
                <div style="display: flex; gap: 0.35rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                    <div class="skeleton skeleton-chip"></div>
                    <div class="skeleton skeleton-chip"></div>
                    <div class="skeleton skeleton-chip"></div>
                    <div class="skeleton skeleton-chip"></div>
                </div>
                <div style="display: flex; gap: 0.4rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                    <div class="skeleton" style="height: 35px; width: 140px; border-radius: 50px;"></div>
                    <div class="skeleton" style="height: 30px; width: 80px; border-radius: 50px;"></div>
                    <div class="skeleton" style="height: 30px; width: 80px; border-radius: 50px;"></div>
                </div>
                <div style="display: flex; gap: 0.3rem; flex-wrap: wrap; margin-bottom: 0.4rem;">
                    <div class="skeleton skeleton-chip" style="width: 45px;"></div>
                    <div class="skeleton skeleton-chip" style="width: 55px;"></div>
                    <div class="skeleton skeleton-chip" style="width: 50px;"></div>
                </div>
            </div>
        </div>
        <div style="margin-top: 2rem;">
            <div class="skeleton" style="height: 30px; width: 200px; margin-bottom: 1rem;"></div>
            <div style="display: flex; gap: 1rem; overflow-x: auto; padding: 0.5rem 0;">
                <div class="skeleton skeleton-card"></div>
                <div class="skeleton skeleton-card"></div>
                <div class="skeleton skeleton-card"></div>
                <div class="skeleton skeleton-card"></div>
                <div class="skeleton skeleton-card"></div>
            </div>
        </div>
    </div>

    {{-- REAL CONTENT --}}
    <div id="realContent" style="display: none;">

        {{-- HERO SECTION (DESKTOP) --}}
        <div class="anime-hero fade-in" id="animeHero">
            <div class="hero-background" id="heroBackground">
                @php
                    $hasTrailer = !empty($anime['trailer']['embed_url']);
                    $posterImage = $anime['images']['jpg']['large_image_url'] ?? '';
                    $backgroundImage = !empty($anime['trailer']['images']['maximum_image_url']) 
                        ? $anime['trailer']['images']['maximum_image_url'] 
                        : $posterImage;
                @endphp
                @if(!$hasTrailer)
                    <div class="fallback-image" style="background-image: url('{{ $backgroundImage }}');"></div>
                @endif
            </div>
            <div class="hero-overlay"></div>

            {{-- DESKTOP CONTENT (hidden on tablet/mobile) --}}
            <div class="anime-hero-content" id="desktopHeroContent">
                <div class="anime-poster-wrapper">
                    <img 
                        src="{{ $posterImage }}" 
                        alt="{{ $anime['title'] }}" 
                        class="anime-poster"
                        loading="lazy">
                </div>
                <div class="anime-info">
                    <h1 class="anime-title">{{ $anime['title'] }}</h1>
                    @if(!empty($anime['title_japanese']) && $anime['title_japanese'] !== $anime['title'])
                        <div class="anime-title-japanese">{{ $anime['title_japanese'] }}</div>
                    @endif
                    <div class="anime-status-badge">{{ $anime['status'] ?? 'Unknown' }}</div>
                    <div class="info-chips">
                        @if(!empty($anime['year']))
                            <div class="info-chip">
                                <span class="info-chip-label">Year</span>
                                <span class="info-chip-value">{{ $anime['year'] }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['type']))
                            <div class="info-chip">
                                <span class="info-chip-label">Type</span>
                                <span class="info-chip-value">{{ $anime['type'] }}</span>
                            </div>
                        @endif
                        @if(isset($anime['episodes']))
                            <div class="info-chip">
                                <span class="info-chip-label">Episodes</span>
                                <span class="info-chip-value">{{ $anime['episodes'] ?? '?' }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['score']))
                            <div class="info-chip">
                                <span class="info-chip-label">Score</span>
                                <span class="info-chip-value">{{ number_format($anime['score'], 2) }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['rank']))
                            <div class="info-chip">
                                <span class="info-chip-label">Rank</span>
                                <span class="info-chip-value">#{{ $anime['rank'] }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['popularity']))
                            <div class="info-chip">
                                <span class="info-chip-label">Popularity</span>
                                <span class="info-chip-value">#{{ $anime['popularity'] }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['members']))
                            <div class="info-chip">
                                <span class="info-chip-label">Members</span>
                                <span class="info-chip-value">{{ number_format($anime['members']) }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['season']))
                            <div class="info-chip">
                                <span class="info-chip-label">Season</span>
                                <span class="info-chip-value">{{ ucfirst($anime['season']) }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['duration']))
                            <div class="info-chip">
                                <span class="info-chip-label">Duration</span>
                                <span class="info-chip-value">{{ $anime['duration'] }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['source']))
                            <div class="info-chip">
                                <span class="info-chip-label">Source</span>
                                <span class="info-chip-value">{{ $anime['source'] }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="action-buttons">
                        <a href="/watch-now/{{ urlencode($anime['title']) }}" class="btn-watch-now">
                            <i class="bi bi-play-fill"></i> Watch Now
                        </a>
                        <form action="/favorites" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                            <input type="hidden" name="title" value="{{ $anime['title'] }}">
                            <input type="hidden" name="image" value="{{ $anime['images']['jpg']['image_url'] }}">
                            <button type="submit" class="btn-action"><i class="bi bi-heart"></i> Favorite</button>
                        </form>
                        <form action="/watchlist" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                            <input type="hidden" name="title" value="{{ $anime['title'] }}">
                            <input type="hidden" name="image" value="{{ $anime['images']['jpg']['image_url'] }}">
                            <button type="submit" class="btn-action"><i class="bi bi-bookmark"></i> Watchlist</button>
                        </form>
                        <button class="btn-action" onclick="navigator.clipboard?.writeText(window.location.href)">
                            <i class="bi bi-share"></i> Share
                        </button>
                    </div>
                    @if(!empty($anime['genres']))
                        <div class="genres-list">
                            @foreach($anime['genres'] as $genre)
                                <span class="genre-pill">{{ $genre['name'] }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if(!empty($anime['studios']))
                        <div class="studios-list">
                            @foreach($anime['studios'] as $studio)
                                <span class="studio-pill">{{ $studio['name'] }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- POSTER + INFO SECTION (for tablet & mobile) --}}
        <div class="poster-info-section fade-in fade-in-delay-1" id="posterInfoSection">
            <div class="poster-row">
                <div class="poster-wrapper">
                    <img 
                        src="{{ $posterImage }}" 
                        alt="{{ $anime['title'] }}" 
                        loading="lazy">
                </div>
                <div class="info-card">
                    <h1 class="anime-title">{{ $anime['title'] }}</h1>
                    @if(!empty($anime['title_japanese']) && $anime['title_japanese'] !== $anime['title'])
                        <div class="anime-title-japanese">{{ $anime['title_japanese'] }}</div>
                    @endif
                    <div class="anime-status-badge">{{ $anime['status'] ?? 'Unknown' }}</div>

                    <div class="info-chips">
                        @if(!empty($anime['year']))
                            <div class="info-chip">
                                <span class="info-chip-label">Year</span>
                                <span class="info-chip-value">{{ $anime['year'] }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['type']))
                            <div class="info-chip">
                                <span class="info-chip-label">Type</span>
                                <span class="info-chip-value">{{ $anime['type'] }}</span>
                            </div>
                        @endif
                        @if(isset($anime['episodes']))
                            <div class="info-chip">
                                <span class="info-chip-label">Episodes</span>
                                <span class="info-chip-value">{{ $anime['episodes'] ?? '?' }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['score']))
                            <div class="info-chip">
                                <span class="info-chip-label">Score</span>
                                <span class="info-chip-value">{{ number_format($anime['score'], 2) }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['rank']))
                            <div class="info-chip">
                                <span class="info-chip-label">Rank</span>
                                <span class="info-chip-value">#{{ $anime['rank'] }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['popularity']))
                            <div class="info-chip">
                                <span class="info-chip-label">Popularity</span>
                                <span class="info-chip-value">#{{ $anime['popularity'] }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['members']))
                            <div class="info-chip">
                                <span class="info-chip-label">Members</span>
                                <span class="info-chip-value">{{ number_format($anime['members']) }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['season']))
                            <div class="info-chip">
                                <span class="info-chip-label">Season</span>
                                <span class="info-chip-value">{{ ucfirst($anime['season']) }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['duration']))
                            <div class="info-chip">
                                <span class="info-chip-label">Duration</span>
                                <span class="info-chip-value">{{ $anime['duration'] }}</span>
                            </div>
                        @endif
                        @if(!empty($anime['source']))
                            <div class="info-chip">
                                <span class="info-chip-label">Source</span>
                                <span class="info-chip-value">{{ $anime['source'] }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="action-buttons">
                        <a href="/watch-now/{{ urlencode($anime['title']) }}" class="btn-watch-now">
                            <i class="bi bi-play-fill"></i> Watch Now
                        </a>
                        <form action="/favorites" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                            <input type="hidden" name="title" value="{{ $anime['title'] }}">
                            <input type="hidden" name="image" value="{{ $anime['images']['jpg']['image_url'] }}">
                            <button type="submit" class="btn-action"><i class="bi bi-heart"></i> Favorite</button>
                        </form>
                        <form action="/watchlist" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                            <input type="hidden" name="title" value="{{ $anime['title'] }}">
                            <input type="hidden" name="image" value="{{ $anime['images']['jpg']['image_url'] }}">
                            <button type="submit" class="btn-action"><i class="bi bi-bookmark"></i> Watchlist</button>
                        </form>
                        <button class="btn-action" onclick="navigator.clipboard?.writeText(window.location.href)">
                            <i class="bi bi-share"></i> Share
                        </button>
                    </div>

                    @if(!empty($anime['genres']))
                        <div class="genres-list">
                            @foreach($anime['genres'] as $genre)
                                <span class="genre-pill">{{ $genre['name'] }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($anime['studios']))
                        <div class="studios-list">
                            @foreach($anime['studios'] as $studio)
                                <span class="studio-pill">{{ $studio['name'] }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- SYNOPSIS --}}
        @if(!empty($anime['synopsis']))
            <div class="synopsis-card fade-in fade-in-delay-2">
                <h3><i class="bi bi-text-paragraph"></i> Synopsis</h3>
                <p>{{ $anime['synopsis'] }}</p>
            </div>
        @endif

        {{-- RECOMMENDATIONS --}}
        @if(count($recommendations) > 0)
            <div class="horizontal-scroll-section fade-in fade-in-delay-3">
                <h3><i class="bi bi-lightbulb"></i> You May Also Like</h3>
                <div class="scroll-container">
                    @foreach($recommendations as $recommendation)
                        <a href="/anime/{{ $recommendation['entry']['mal_id'] }}" class="scroll-item">
                            <img 
                                src="{{ $recommendation['entry']['images']['jpg']['image_url'] }}" 
                                alt="{{ $recommendation['entry']['title'] }}"
                                class="scroll-item-img"
                                loading="lazy">
                            <div class="scroll-item-title">{{ $recommendation['entry']['title'] }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CHARACTERS --}}
        @if(count($characters) > 0)
            <div class="horizontal-scroll-section fade-in fade-in-delay-4">
                <h3><i class="bi bi-people"></i> Characters</h3>
                <div class="scroll-container">
                    @foreach(array_slice($characters, 0, 15) as $character)
                        <div class="character-item">
                            <img 
                                src="{{ $character['character']['images']['jpg']['image_url'] }}" 
                                alt="{{ $character['character']['name'] }}"
                                class="character-item-img"
                                loading="lazy">
                            <div class="character-item-name">{{ $character['character']['name'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- REVIEWS --}}
        <div class="reviews-section fade-in fade-in-delay-5">
            <div class="review-form">
                <h3><i class="bi bi-pencil"></i> Write a Review</h3>
                <form action="/reviews" method="POST">
                    @csrf
                    <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                    <input type="hidden" name="anime_title" value="{{ $anime['title'] }}">
                    <div class="mb-3">
                        <label class="form-label">Rating (1-5)</label>
                        <input type="number" name="rating" min="1" max="5" class="form-control" style="max-width: 100px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Review</label>
                        <textarea name="review" rows="4" class="form-control" placeholder="Share your thoughts..." required></textarea>
                    </div>
                    <button type="submit" class="btn-submit-review"><i class="bi bi-send"></i> Submit Review</button>
                </form>
            </div>

            @if($reviews->count() > 0)
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">
                    <i class="bi bi-chat"></i> Community Reviews
                </h3>
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <span class="review-rating"><i class="bi bi-star-fill" style="color: #fbbf24;"></i> {{ $review->rating }}/5</span>
                            <small style="color: var(--text-muted);"><i class="bi bi-clock"></i> {{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="review-text">{{ $review->review }}</p>
                        <div class="review-actions">
                            <form action="/reviews/{{ $review->id }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete-review"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

</div>

<script>
    (function() {
        'use strict';

        const skeletonLoader = document.getElementById('skeletonLoader');
        const realContent = document.getElementById('realContent');

        setTimeout(function() {
            skeletonLoader.style.transition = 'opacity 0.4s ease';
            skeletonLoader.style.opacity = '0';
            realContent.style.display = 'block';
            realContent.style.opacity = '0';
            realContent.style.transition = 'opacity 0.5s ease';
            void realContent.offsetHeight;
            setTimeout(function() {
                realContent.style.opacity = '1';
                setTimeout(function() {
                    skeletonLoader.style.display = 'none';
                }, 400);
            }, 100);
        }, 500);

        @php
            $trailerUrl = $anime['trailer']['embed_url'] ?? '';
            $hasTrailer = !empty($trailerUrl);
        @endphp

        @if($hasTrailer)
            (function() {
                const heroBackground = document.getElementById('heroBackground');
                const iframe = document.createElement('iframe');
                let embedUrl = '{{ $trailerUrl }}';
                if (embedUrl.includes('youtube.com') || embedUrl.includes('youtu.be')) {
                    let videoId = '';
                    if (embedUrl.includes('v=')) {
                        videoId = embedUrl.split('v=')[1]?.split('&')[0] || '';
                    } else if (embedUrl.includes('youtu.be/')) {
                        videoId = embedUrl.split('youtu.be/')[1]?.split('?')[0] || '';
                    }
                    if (videoId) {
                        embedUrl = 'https://www.youtube.com/embed/' + videoId + 
                            '?autoplay=1&mute=1&loop=1&playlist=' + videoId + 
                            '&controls=0&showinfo=0&rel=0&modestbranding=1&iv_load_policy=3';
                    }
                }
                iframe.src = embedUrl;
                iframe.allow = 'autoplay; encrypted-media';
                iframe.loading = 'lazy';
                iframe.style.width = '100vw';
                iframe.style.height = '100vh';
                iframe.style.position = 'absolute';
                iframe.style.top = '50%';
                iframe.style.left = '50%';
                iframe.style.transform = 'translate(-50%, -50%)';
                iframe.style.border = '0';
                iframe.style.pointerEvents = 'none';
                heroBackground.appendChild(iframe);
            })();
        @endif

        console.log('✨ MondigSAnime — Hero fully separated from content on tablet & mobile.');
    })();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>