{{-- resources/views/schedule.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Schedule — MondigSAnime</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* ============================================
           MONDiGSANIME PREMIUM BLUE THEME
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
            --glass-bg: rgba(17, 24, 39, 0.75);
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
            padding: 1.5rem 1rem 3rem;
            background-image: radial-gradient(ellipse at 20% 20%, rgba(37, 99, 235, 0.03) 0%, transparent 60%);
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent-color); }

        .schedule-wrapper {
            max-width: 1280px;
            margin: 0 auto;
        }

        /* ----- BACK BUTTON ----- */
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
           SKELETON LOADING
           ============================================ */
        .skeleton {
            background: linear-gradient(
                90deg,
                var(--skeleton-base) 25%,
                var(--skeleton-shine) 50%,
                var(--skeleton-base) 75%
            );
            background-size: 200% 100%;
            animation: shimmer 1.5s ease-in-out infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Carousel skeleton */
        .carousel-skeleton-wrapper {
            position: relative;
            padding: 2rem 0 3rem;
            margin-bottom: 1rem;
            perspective: 1200px;
            overflow: hidden;
            min-height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-skeleton-track {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
            width: 100%;
        }

        .skeleton-card {
            flex: 0 0 160px;
            height: 300px;
            border-radius: 16px;
            background: var(--skeleton-base);
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(59, 130, 246, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .skeleton-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.05) 50%,
                transparent 100%
            );
            animation: shimmer 1.5s ease-in-out infinite;
        }

        .skeleton-card.center-skeleton {
            flex: 0 0 240px;
            height: 340px;
            border-color: rgba(37, 99, 235, 0.2);
            box-shadow: 0 8px 40px rgba(37, 99, 235, 0.15);
        }

        .skeleton-card .skeleton-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 30%, rgba(5, 8, 22, 0.85) 90%);
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .skeleton-card .skeleton-overlay .skeleton-line {
            height: 12px;
            background: rgba(59, 130, 246, 0.15);
            border-radius: 4px;
            margin-bottom: 0.3rem;
        }

        .skeleton-card .skeleton-overlay .skeleton-line.short {
            width: 60%;
        }

        .skeleton-card .skeleton-overlay .skeleton-line.medium {
            width: 80%;
        }

        .skeleton-card .skeleton-overlay .skeleton-line.small {
            width: 40%;
            height: 10px;
        }

        .skeleton-card .skeleton-overlay .skeleton-badge {
            width: 50px;
            height: 16px;
            background: rgba(59, 130, 246, 0.2);
            border-radius: 50px;
            margin-top: 0.2rem;
        }

        /* Schedule list skeleton */
        .schedule-skeleton-list {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .schedule-skeleton-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 0.6rem;
        }

        .schedule-skeleton-item .thumb-skeleton {
            width: 52px;
            height: 78px;
            border-radius: 6px;
            background: var(--skeleton-base);
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .schedule-skeleton-item .thumb-skeleton::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.05) 50%,
                transparent 100%
            );
            animation: shimmer 1.5s ease-in-out infinite;
        }

        .schedule-skeleton-item .info-skeleton {
            flex: 1;
            min-width: 0;
        }

        .schedule-skeleton-item .info-skeleton .title-skeleton {
            height: 18px;
            width: 70%;
            background: var(--skeleton-base);
            border-radius: 4px;
            margin-bottom: 0.3rem;
            position: relative;
            overflow: hidden;
        }

        .schedule-skeleton-item .info-skeleton .title-skeleton::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.05) 50%,
                transparent 100%
            );
            animation: shimmer 1.5s ease-in-out infinite;
        }

        .schedule-skeleton-item .info-skeleton .meta-skeleton {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .schedule-skeleton-item .info-skeleton .meta-skeleton .time-skeleton {
            height: 16px;
            width: 60px;
            background: var(--skeleton-base);
            border-radius: 50px;
            position: relative;
            overflow: hidden;
        }

        .schedule-skeleton-item .info-skeleton .meta-skeleton .time-skeleton::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.05) 50%,
                transparent 100%
            );
            animation: shimmer 1.5s ease-in-out infinite;
        }

        .schedule-skeleton-item .info-skeleton .meta-skeleton .type-skeleton {
            height: 16px;
            width: 40px;
            background: var(--skeleton-base);
            border-radius: 50px;
            position: relative;
            overflow: hidden;
        }

        .schedule-skeleton-item .info-skeleton .meta-skeleton .type-skeleton::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.05) 50%,
                transparent 100%
            );
            animation: shimmer 1.5s ease-in-out infinite;
        }

        .schedule-skeleton-item .arrow-skeleton {
            width: 20px;
            height: 20px;
            background: var(--skeleton-base);
            border-radius: 50%;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .schedule-skeleton-item .arrow-skeleton::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(59, 130, 246, 0.05) 50%,
                transparent 100%
            );
            animation: shimmer 1.5s ease-in-out infinite;
        }

        /* Fade transitions */
        .fade-enter {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .fade-enter-active {
            opacity: 1;
        }

        .fade-exit {
            opacity: 1;
            transition: opacity 0.2s ease;
        }

        .fade-exit-active {
            opacity: 0;
        }

        /* Hide content initially */
        .content-hidden {
            display: none;
        }

        /* ============================================
           COVER FLOW CAROUSEL
           ============================================ */
        .carousel-container {
            position: relative;
            padding: 2rem 0 3rem;
            margin-bottom: 1rem;
            perspective: 1200px;
            overflow: hidden;
            touch-action: pan-y;
            user-select: none;
            -webkit-user-select: none;
        }

        .carousel-track {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            padding: 0.5rem 0;
            min-height: 380px;
            cursor: grab;
            touch-action: pan-y;
        }
        .carousel-track.dragging {
            cursor: grabbing;
            transition: none;
        }

        .carousel-card {
            flex: 0 0 160px;
            height: 300px;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            cursor: pointer;
            transform: scale(0.75) rotateY(8deg);
            opacity: 0.5;
            filter: blur(1px) brightness(0.6);
            border: 2px solid transparent;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            background: var(--bg-card);
            transform-style: preserve-3d;
            touch-action: pan-y;
        }

        .carousel-card .card-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease;
            z-index: 0;
        }

        .carousel-card .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 30%, rgba(5, 8, 22, 0.85) 90%);
            z-index: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .carousel-card .card-overlay .day-name {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--accent-light);
            font-weight: 700;
            margin-bottom: 0.2rem;
        }
        .carousel-card .card-overlay .anime-title {
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.15rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .carousel-card .card-overlay .meta-row {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            font-size: 0.6rem;
            color: var(--text-secondary);
        }
        .carousel-card .card-overlay .meta-row .time {
            display: flex;
            align-items: center;
            gap: 0.2rem;
        }
        .carousel-card .card-overlay .meta-row .time i {
            font-size: 0.5rem;
            color: var(--accent-light);
        }
        .carousel-card .card-overlay .meta-row .type {
            padding: 0.1rem 0.5rem;
            background: linear-gradient(135deg, #2563EB, #3B82F6);
            border-radius: 50px;
            font-size: 0.5rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* center card */
        .carousel-card.center {
            flex: 0 0 240px;
            height: 340px;
            transform: scale(1) rotateY(0deg);
            opacity: 1;
            filter: blur(0) brightness(1);
            border-color: var(--accent-color);
            box-shadow: 0 8px 40px rgba(37, 99, 235, 0.3), 0 0 60px rgba(37, 99, 235, 0.1);
            z-index: 2;
        }

        .carousel-card.center .card-overlay {
            opacity: 1;
        }

        .carousel-card.center .card-bg {
            transform: scale(1.02);
        }

        /* left cards */
        .carousel-card.left-1 {
            transform: scale(0.8) rotateY(12deg) translateX(10px);
            opacity: 0.7;
            filter: blur(0.5px) brightness(0.7);
        }
        .carousel-card.left-2 {
            transform: scale(0.65) rotateY(20deg) translateX(30px);
            opacity: 0.4;
            filter: blur(1.5px) brightness(0.5);
        }
        .carousel-card.right-1 {
            transform: scale(0.8) rotateY(-12deg) translateX(-10px);
            opacity: 0.7;
            filter: blur(0.5px) brightness(0.7);
        }
        .carousel-card.right-2 {
            transform: scale(0.65) rotateY(-20deg) translateX(-30px);
            opacity: 0.4;
            filter: blur(1.5px) brightness(0.5);
        }

        .carousel-card:hover:not(.center) {
            transform: scale(0.85) rotateY(0deg);
            opacity: 0.85;
            filter: blur(0) brightness(0.9);
            border-color: var(--border-hover);
        }

        .carousel-card .glow-ring {
            position: absolute;
            inset: -2px;
            border-radius: 16px;
            background: transparent;
            z-index: 0;
            pointer-events: none;
            transition: all 0.5s ease;
        }
        .carousel-card.center .glow-ring {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.4), rgba(59, 130, 246, 0.1));
            box-shadow: inset 0 0 40px rgba(37, 99, 235, 0.15);
        }

        /* carousel navigation dots */
        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-bottom: 0.5rem;
        }
        .carousel-dots .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--border-color);
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        .carousel-dots .dot.active {
            background: var(--accent-color);
            width: 24px;
            border-radius: 4px;
            box-shadow: 0 0 16px rgba(37, 99, 235, 0.4);
        }
        .carousel-dots .dot:hover {
            background: var(--accent-light);
        }

        /* ============================================
           SCHEDULE LIST
           ============================================ */
        .schedule-section {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .schedule-section .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }
        .schedule-section .section-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.3px;
        }
        .schedule-section .section-header h2 i {
            color: var(--accent-color);
            margin-right: 0.5rem;
        }
        .schedule-section .section-header .badge-count {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 0.25rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
        }
        .schedule-section .section-header .badge-count span {
            color: var(--text-primary);
        }

        .schedule-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 0.6rem;
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--text-primary);
        }
        .schedule-item:hover {
            background-color: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateX(6px);
            box-shadow: 0 6px 24px var(--shadow-color);
            color: var(--text-primary);
        }
        .schedule-item .thumb {
            width: 52px;
            height: 78px;
            object-fit: cover;
            border-radius: 6px;
            background-color: var(--bg-input);
            flex-shrink: 0;
            transition: transform 0.2s;
        }
        .schedule-item:hover .thumb {
            transform: scale(1.03);
        }
        .schedule-item .info {
            flex: 1;
            min-width: 0;
        }
        .schedule-item .info .title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.1rem;
            line-height: 1.3;
        }
        .schedule-item .info .meta {
            font-size: 0.75rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .schedule-item .info .meta .time {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            background: var(--bg-input);
            padding: 0.1rem 0.5rem;
            border-radius: 50px;
        }
        .schedule-item .info .meta .time i {
            font-size: 0.6rem;
            color: var(--accent-light);
        }
        .schedule-item .info .meta .type {
            padding: 0.1rem 0.5rem;
            background: linear-gradient(135deg, #2563EB, #3B82F6);
            border-radius: 50px;
            font-size: 0.55rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .schedule-item .info .meta .ep {
            padding: 0.1rem 0.5rem;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            font-size: 0.55rem;
            color: var(--text-secondary);
        }
        .schedule-item .arrow {
            color: var(--text-muted);
            flex-shrink: 0;
            transition: transform 0.2s, color 0.2s;
            font-size: 1.1rem;
        }
        .schedule-item:hover .arrow {
            transform: translateX(4px);
            color: var(--accent-color);
        }

        /* empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }
        .empty-state i {
            font-size: 3rem;
            color: var(--border-color);
            display: block;
            margin-bottom: 1rem;
        }
        .empty-state h5 {
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .empty-state p {
            font-size: 0.9rem;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 991.98px) {
            .carousel-card {
                flex: 0 0 130px;
                height: 240px;
            }
            .carousel-card.center {
                flex: 0 0 190px;
                height: 280px;
            }
            .carousel-card .card-overlay .anime-title {
                font-size: 0.65rem;
            }
            .skeleton-card {
                flex: 0 0 130px;
                height: 240px;
            }
            .skeleton-card.center-skeleton {
                flex: 0 0 190px;
                height: 280px;
            }
        }

        @media (max-width: 767.98px) {
            body { padding: 1rem 0.5rem 2rem; }
            .back-home { font-size: 0.8rem; padding: 0.35rem 1rem; margin-bottom: 0.75rem; }
            .carousel-container { padding: 1rem 0 2rem; }
            .carousel-track { gap: 0.25rem; min-height: 260px; }
            .carousel-card {
                flex: 0 0 90px;
                height: 170px;
                border-radius: 12px;
            }
            .carousel-card.center {
                flex: 0 0 140px;
                height: 210px;
            }
            .carousel-card .card-overlay {
                padding: 0.5rem;
            }
            .carousel-card .card-overlay .day-name {
                font-size: 0.45rem;
                letter-spacing: 1px;
            }
            .carousel-card .card-overlay .anime-title {
                font-size: 0.55rem;
            }
            .carousel-card .card-overlay .meta-row {
                font-size: 0.5rem;
            }
            .carousel-card .card-overlay .meta-row .type {
                font-size: 0.4rem;
                padding: 0.05rem 0.35rem;
            }
            .carousel-card.left-1 { transform: scale(0.7) rotateY(15deg) translateX(8px); }
            .carousel-card.left-2 { transform: scale(0.5) rotateY(25deg) translateX(20px); }
            .carousel-card.right-1 { transform: scale(0.7) rotateY(-15deg) translateX(-8px); }
            .carousel-card.right-2 { transform: scale(0.5) rotateY(-25deg) translateX(-20px); }

            .schedule-section .section-header h2 { font-size: 1.2rem; }
            .schedule-item { padding: 0.5rem 0.6rem; gap: 0.6rem; }
            .schedule-item .thumb { width: 40px; height: 60px; }
            .schedule-item .info .title { font-size: 0.8rem; }
            .schedule-item .info .meta { font-size: 0.65rem; gap: 0.3rem; }

            .skeleton-card {
                flex: 0 0 90px;
                height: 170px;
                border-radius: 12px;
            }
            .skeleton-card.center-skeleton {
                flex: 0 0 140px;
                height: 210px;
            }
            .schedule-skeleton-item .thumb-skeleton {
                width: 40px;
                height: 60px;
            }
        }

        @media (max-width: 480px) {
            .carousel-card {
                flex: 0 0 70px;
                height: 130px;
                border-radius: 10px;
            }
            .carousel-card.center {
                flex: 0 0 110px;
                height: 170px;
            }
            .carousel-card .card-overlay .anime-title {
                font-size: 0.45rem;
            }
            .carousel-card .card-overlay .meta-row {
                font-size: 0.4rem;
            }
            .carousel-card .card-overlay .day-name {
                font-size: 0.4rem;
            }
            .carousel-track { min-height: 200px; }
            .skeleton-card {
                flex: 0 0 70px;
                height: 130px;
                border-radius: 10px;
            }
            .skeleton-card.center-skeleton {
                flex: 0 0 110px;
                height: 170px;
            }
        }
    </style>
</head>
<body>

<div class="schedule-wrapper">

    {{-- BACK BUTTON --}}
    <a href="/" class="back-home">
        <i class="bi bi-arrow-left"></i> Back to Home
    </a>

    @php
        // ----- GROUP SCHEDULE DATA BY DAY -----
        $groupedSchedule = [
            'monday' => [], 'tuesday' => [], 'wednesday' => [],
            'thursday' => [], 'friday' => [], 'saturday' => [], 'sunday' => []
        ];

        if (is_array($schedule)) {
            foreach ($schedule as $item) {
                if (isset($item['ts'])) {
                    $timestamp = $item['ts'] / 1000;
                    $dayOfWeek = strtolower(date('l', $timestamp));

                    $posterId = '';
                    if (isset($item['poster'])) {
                        if (is_array($item['poster'])) {
                            $posterId = $item['poster']['sm'] ?? $item['poster']['hq'] ?? '';
                        } else {
                            $posterId = $item['poster'];
                        }
                    }

                    $time = date('H:i', $timestamp);

                    if (array_key_exists($dayOfWeek, $groupedSchedule)) {
                        $groupedSchedule[$dayOfWeek][] = [
                            'title' => $item['title'] ?? 'Unknown',
                            'slug' => $item['slug'] ?? '',
                            'poster_id' => $posterId,
                            'time' => $time,
                            'type' => $item['type'] ?? 'TV',
                            'episode' => $item['episode'] ?? null
                        ];
                    }
                }
            }
        }

        // ----- BUILD FEATURED CARDS (first anime per day) -----
        $featuredDays = [];
        $dayLabels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $dayKeys = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($dayKeys as $index => $key) {
            if (!empty($groupedSchedule[$key])) {
                $first = $groupedSchedule[$key][0];
                $featuredDays[] = [
                    'key' => $key,
                    'label' => $dayLabels[$index],
                    'title' => $first['title'],
                    'slug' => $first['slug'],
                    'poster_id' => $first['poster_id'],
                    'time' => $first['time'],
                    'type' => $first['type'],
                    'count' => count($groupedSchedule[$key])
                ];
            }
        }

        // If no data, fallback to empty
        if (empty($featuredDays)) {
            $featuredDays = [
                ['key' => 'monday', 'label' => 'Monday', 'title' => 'No schedule yet', 'slug' => '', 'poster_id' => '', 'time' => '--:--', 'type' => 'TV', 'count' => 0],
            ];
        }

        // Determine which day to show first (today or first available)
        $todayKey = strtolower(date('l'));
        $defaultDay = $todayKey;
        if (empty($groupedSchedule[$todayKey])) {
            $defaultDay = $featuredDays[0]['key'] ?? 'monday';
        }

        $selectedDay = request()->get('day', $defaultDay);
        if (!array_key_exists($selectedDay, $groupedSchedule)) {
            $selectedDay = $defaultDay;
        }

        // Find index of selected day in featured array for carousel centering
        $selectedIndex = 0;
        foreach ($featuredDays as $idx => $fd) {
            if ($fd['key'] === $selectedDay) {
                $selectedIndex = $idx;
                break;
            }
        }
    @endphp

    {{-- ============================================
    SKELETON LOADER (initially visible)
    ============================================ --}}
    <div id="skeletonLoader">
        {{-- Carousel Skeleton --}}
        <div class="carousel-skeleton-wrapper">
            <div class="carousel-skeleton-track">
                @for($i = 0; $i < 7; $i++)
                    <div class="skeleton-card {{ $i === 3 ? 'center-skeleton' : '' }}">
                        <div class="skeleton-overlay">
                            <div class="skeleton-line short"></div>
                            <div class="skeleton-line medium"></div>
                            <div class="skeleton-line small"></div>
                            <div class="skeleton-badge"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Dots skeleton --}}
        <div class="carousel-dots" style="margin-top: 1rem; padding-bottom: 0.5rem;">
            @for($i = 0; $i < 7; $i++)
                <div class="dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--border-color); {{ $i === 3 ? 'width: 24px; border-radius: 4px; background: var(--accent-color);' : '' }}"></div>
            @endfor
        </div>

        {{-- Schedule List Skeleton --}}
        <div class="schedule-skeleton-list">
            @for($i = 0; $i < 7; $i++)
                <div class="schedule-skeleton-item">
                    <div class="thumb-skeleton"></div>
                    <div class="info-skeleton">
                        <div class="title-skeleton"></div>
                        <div class="meta-skeleton">
                            <div class="time-skeleton"></div>
                            <div class="type-skeleton"></div>
                        </div>
                    </div>
                    <div class="arrow-skeleton"></div>
                </div>
            @endfor
        </div>
    </div>

    {{-- ============================================
    REAL CONTENT (hidden initially)
    ============================================ --}}
    <div id="realContent" style="display: none;">

        {{-- COVER FLOW CAROUSEL --}}
        <div class="carousel-container" id="carouselContainer">
            <div class="carousel-track" id="carouselTrack">
                @foreach($featuredDays as $index => $day)
                    @php
                        $posterUrl = $day['poster_id'] ? 'https://kaa.lt/image/poster/' . $day['poster_id'] . '.webp' : '';
                        $isCenter = ($index === $selectedIndex);
                        // determine position class
                        $posClass = '';
                        if ($index < $selectedIndex) {
                            $diff = $selectedIndex - $index;
                            $posClass = $diff === 1 ? 'left-1' : 'left-2';
                        } elseif ($index > $selectedIndex) {
                            $diff = $index - $selectedIndex;
                            $posClass = $diff === 1 ? 'right-1' : 'right-2';
                        }
                        if ($isCenter) $posClass = 'center';
                    @endphp
                    <div class="carousel-card {{ $posClass }}" data-day="{{ $day['key'] }}" data-index="{{ $index }}">
                        <div class="glow-ring"></div>
                        <div class="card-bg" style="background-image: url('{{ $posterUrl }}'); background-size: cover; background-position: center;"></div>
                        <div class="card-overlay">
                            <div class="day-name">{{ $day['label'] }}</div>
                            <div class="anime-title">{{ $day['title'] }}</div>
                            <div class="meta-row">
                                <span class="time"><i class="bi bi-clock"></i> {{ $day['time'] }}</span>
                                <span class="type">{{ $day['type'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Dots --}}
            <div class="carousel-dots" id="carouselDots">
                @foreach($featuredDays as $index => $day)
                    <button class="dot {{ $index === $selectedIndex ? 'active' : '' }}" data-index="{{ $index }}"></button>
                @endforeach
            </div>
        </div>

        {{-- SCHEDULE LIST --}}
        <div class="schedule-section" id="scheduleSection">
            @if(!empty($groupedSchedule[$selectedDay]))
                <div class="schedule-list" id="scheduleList">
                    @foreach($groupedSchedule[$selectedDay] as $anime)
                        @php
                            $slug = $anime['slug'] ?? '';
                            $title = $anime['title'] ?? 'Unknown Title';
                            $posterId = $anime['poster_id'] ?? '';
                            $time = $anime['time'] ?? 'Today';
                            $type = $anime['type'] ?? 'TV';
                            $episode = $anime['episode'] ?? null;
                            $posterUrl = $posterId ? 'https://kaa.lt/image/poster/' . $posterId . '.webp' : '';
                        @endphp
                        <a href="/kaa-anime/{{ $slug }}" class="schedule-item">
                            <img src="{{ $posterUrl }}" class="thumb" alt="{{ $title }}" loading="lazy"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'52\' height=\'78\'%3E%3Crect width=\'52\' height=\'78\' fill=\'%23111827\'/%3E%3C/svg%3E'">
                            <div class="info">
                                <div class="title">{{ $title }}</div>
                                <div class="meta">
                                    <span class="time"><i class="bi bi-clock"></i> {{ $time }}</span>
                                    @if($type)<span class="type">{{ $type }}</span>@endif
                                    @if($episode)<span class="ep">EP {{ $episode }}</span>@endif
                                </div>
                            </div>
                            <i class="bi bi-chevron-right arrow"></i>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <h5>No releases scheduled for {{ ucfirst($selectedDay) }}</h5>
                    <p>Check back later or select another day from the carousel.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- subtle footer --}}
    <div style="margin-top: 2.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color); text-align: center;">
        <p style="color: var(--text-muted); font-size: 0.75rem; margin: 0;">
            <i class="bi bi-info-circle" style="margin-right: 0.3rem; color: var(--accent-light);"></i>
            Schedule times are displayed in your local timezone.
        </p>
    </div>
</div>

<script>
    (function() {
        'use strict';

        // ----- SKELETON LOADING -----
        const skeletonLoader = document.getElementById('skeletonLoader');
        const realContent = document.getElementById('realContent');

        // Show real content after a short delay (simulate loading)
        // In production, this would be triggered by actual data loading
        setTimeout(function() {
            // Fade out skeleton
            skeletonLoader.style.transition = 'opacity 0.4s ease';
            skeletonLoader.style.opacity = '0';
            
            // Show real content
            realContent.style.display = 'block';
            realContent.style.opacity = '0';
            realContent.style.transition = 'opacity 0.5s ease';
            
            // Trigger reflow
            void realContent.offsetHeight;
            
            // Fade in real content
            setTimeout(function() {
                realContent.style.opacity = '1';
                // Remove skeleton after fade
                setTimeout(function() {
                    skeletonLoader.style.display = 'none';
                }, 400);
            }, 100);
        }, 400); // Simulate loading time

        // ----- CAROUSEL LOGIC -----
        const track = document.getElementById('carouselTrack');
        const cards = track ? track.querySelectorAll('.carousel-card') : [];
        const dots = document.querySelectorAll('.dot');
        const scheduleSection = document.getElementById('scheduleSection');

        let currentIndex = {{ $selectedIndex }};
        const total = cards.length;

        // ----- DRAG / SWIPE SUPPORT -----
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let dragOffset = 0;
        let trackWidth = 0;
        let cardWidth = 0;
        let gap = 0;
        let dragThreshold = 0;
        let isSwiping = false;
        let swipeDirection = 0;
        let isLoading = false;

        function getDragMetrics() {
            const trackRect = track.getBoundingClientRect();
            trackWidth = trackRect.width;
            if (cards.length > 0) {
                const cardRect = cards[0].getBoundingClientRect();
                cardWidth = cardRect.width;
                const totalCardsWidth = cards.length * cardWidth;
                gap = (trackWidth - totalCardsWidth) / (cards.length - 1);
                if (gap < 0) gap = 10;
                dragThreshold = cardWidth * 0.15;
            }
        }

        function getCardOffset(index) {
            const centerOffset = (total - 1) / 2;
            return (index - centerOffset) * (cardWidth + gap);
        }

        function snapToNearest() {
            if (total === 0) return;
            getDragMetrics();
            
            if (isSwiping) {
                if (swipeDirection < 0 && currentIndex < total - 1) {
                    const nextCard = cards[currentIndex + 1];
                    if (nextCard) {
                        const day = nextCard.dataset.day;
                        const index = parseInt(nextCard.dataset.index);
                        updateCarousel(index);
                        loadScheduleWithSkeleton(day);
                        return;
                    }
                } else if (swipeDirection > 0 && currentIndex > 0) {
                    const prevCard = cards[currentIndex - 1];
                    if (prevCard) {
                        const day = prevCard.dataset.day;
                        const index = parseInt(prevCard.dataset.index);
                        updateCarousel(index);
                        loadScheduleWithSkeleton(day);
                        return;
                    }
                }
            }
            
            updateCarousel(currentIndex);
        }

        // ----- LOAD SCHEDULE WITH SKELETON -----
        function loadScheduleWithSkeleton(dayKey) {
            if (isLoading) return;
            isLoading = true;

            // Show skeleton in schedule section
            const scheduleList = document.querySelector('.schedule-list');
            if (scheduleList) {
                // Fade out current list
                scheduleList.style.transition = 'opacity 0.2s ease';
                scheduleList.style.opacity = '0';
                
                setTimeout(() => {
                    // Replace with skeleton
                    scheduleList.innerHTML = generateScheduleSkeleton();
                    scheduleList.style.opacity = '1';
                }, 200);
            }

            // Load actual content
            const url = new URL(window.location.href);
            url.searchParams.set('day', dayKey);
            window.history.pushState({ day: dayKey }, '', url.toString());

            fetch('/schedule?day=' + dayKey, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newSection = doc.getElementById('scheduleSection');
                if (newSection && scheduleList) {
                    // Replace skeleton with actual content
                    setTimeout(() => {
                        scheduleList.style.transition = 'opacity 0.3s ease';
                        scheduleList.style.opacity = '0';
                        
                        setTimeout(() => {
                            scheduleList.innerHTML = newSection.innerHTML;
                            scheduleList.style.opacity = '1';
                            isLoading = false;
                        }, 200);
                    }, 300); // Minimum skeleton display time
                } else {
                    window.location.reload();
                }
            })
            .catch(() => {
                window.location.href = '/schedule?day=' + dayKey;
            });
        }

        function generateScheduleSkeleton() {
            let html = '';
            for (let i = 0; i < 7; i++) {
                html += `
                    <div class="schedule-skeleton-item">
                        <div class="thumb-skeleton"></div>
                        <div class="info-skeleton">
                            <div class="title-skeleton"></div>
                            <div class="meta-skeleton">
                                <div class="time-skeleton"></div>
                                <div class="type-skeleton"></div>
                            </div>
                        </div>
                        <div class="arrow-skeleton"></div>
                    </div>
                `;
            }
            return html;
        }

        // Mouse events
        track.addEventListener('mousedown', (e) => {
            if (e.button !== 0) return;
            isDragging = true;
            isSwiping = false;
            swipeDirection = 0;
            startX = e.clientX;
            currentX = startX;
            dragOffset = 0;
            getDragMetrics();
            track.classList.add('dragging');
            track.style.transition = 'none';
            e.preventDefault();
        });

        window.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            const delta = e.clientX - startX;
            const trackRect = track.getBoundingClientRect();
            const maxDrag = (trackRect.width * 0.3);
            const clampedDelta = Math.max(-maxDrag, Math.min(maxDrag, delta));
            const centerOffset = (total - 1) / 2;
            const baseOffset = -currentIndex * (cardWidth + gap) + (trackRect.width / 2) - (cardWidth / 2);
            const newOffset = baseOffset + clampedDelta;
            track.style.transform = `translateX(${newOffset}px)`;
            dragOffset = clampedDelta;
        });

        window.addEventListener('mouseup', (e) => {
            if (!isDragging) return;
            isDragging = false;
            track.classList.remove('dragging');
            track.style.transition = '';
            
            const delta = e.clientX - startX;
            const absDelta = Math.abs(delta);
            
            if (absDelta > dragThreshold) {
                isSwiping = true;
                swipeDirection = delta;
            }
            
            snapToNearest();
            track.style.transform = '';
        });

        // Touch events
        let touchStartX = 0;
        let touchCurrentX = 0;
        let isTouching = false;

        track.addEventListener('touchstart', (e) => {
            const touch = e.touches[0];
            if (!touch) return;
            isTouching = true;
            isSwiping = false;
            swipeDirection = 0;
            touchStartX = touch.clientX;
            touchCurrentX = touchStartX;
            dragOffset = 0;
            getDragMetrics();
            track.classList.add('dragging');
            track.style.transition = 'none';
        }, { passive: true });

        track.addEventListener('touchmove', (e) => {
            if (!isTouching) return;
            const touch = e.touches[0];
            if (!touch) return;
            const delta = touch.clientX - touchStartX;
            const trackRect = track.getBoundingClientRect();
            const maxDrag = trackRect.width * 0.3;
            const clampedDelta = Math.max(-maxDrag, Math.min(maxDrag, delta));
            const centerOffset = (total - 1) / 2;
            const baseOffset = -currentIndex * (cardWidth + gap) + (trackRect.width / 2) - (cardWidth / 2);
            const newOffset = baseOffset + clampedDelta;
            track.style.transform = `translateX(${newOffset}px)`;
            dragOffset = clampedDelta;
            touchCurrentX = touch.clientX;
        }, { passive: true });

        track.addEventListener('touchend', (e) => {
            if (!isTouching) return;
            isTouching = false;
            track.classList.remove('dragging');
            track.style.transition = '';
            
            const delta = touchCurrentX - touchStartX;
            const absDelta = Math.abs(delta);
            
            if (absDelta > dragThreshold) {
                isSwiping = true;
                swipeDirection = delta;
            }
            
            snapToNearest();
            track.style.transform = '';
        }, { passive: true });

        // ----- update carousel position -----
        function updateCarousel(index) {
            if (index < 0) index = 0;
            if (index >= total) index = total - 1;
            currentIndex = index;

            cards.forEach((card, i) => {
                card.classList.remove('center', 'left-1', 'left-2', 'right-1', 'right-2');

                let posClass = '';
                if (i === index) {
                    posClass = 'center';
                } else if (i < index) {
                    const diff = index - i;
                    posClass = diff === 1 ? 'left-1' : 'left-2';
                } else {
                    const diff = i - index;
                    posClass = diff === 1 ? 'right-1' : 'right-2';
                }
                card.classList.add(posClass);
            });

            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }

        // ----- click on card -----
        cards.forEach((card) => {
            card.addEventListener('click', function(e) {
                if (isDragging || isTouching) return;

                const day = this.dataset.day;
                const index = parseInt(this.dataset.index);
                if (!day) return;

                if (index === currentIndex) {
                    return;
                }

                updateCarousel(index);
                loadScheduleWithSkeleton(day);
            });
        });

        // ----- dot click -----
        dots.forEach((dot) => {
            dot.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                const card = cards[index];
                if (!card) return;
                card.click();
            });
        });

        // ----- keyboard navigation -----
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && currentIndex > 0) {
                cards[currentIndex - 1]?.click();
                e.preventDefault();
            } else if (e.key === 'ArrowRight' && currentIndex < total - 1) {
                cards[currentIndex + 1]?.click();
                e.preventDefault();
            }
        });

        // ----- ensure the carousel is correctly positioned on load -----
        updateCarousel(currentIndex);

        // ----- handle back/forward browser buttons -----
        window.addEventListener('popstate', function(e) {
            const day = e.state?.day;
            if (day) {
                let foundIndex = -1;
                cards.forEach((card, i) => {
                    if (card.dataset.day === day) {
                        foundIndex = i;
                    }
                });
                if (foundIndex >= 0) {
                    updateCarousel(foundIndex);
                    loadScheduleWithSkeleton(day);
                } else {
                    window.location.reload();
                }
            }
        });

        console.log('✨ MondigSAnime Schedule — Premium Cover Flow with Skeleton Loading ready.');

    })();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>