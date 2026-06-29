    <div class="kaa-app" id="app">
        <div class="kaa-grid">
            <div class="player-col">
                <div class="video-wrapper" id="videoWrapper">
                    <video id="video" controls playsinline preload="metadata" style="width:100%;height:100%;background:#000;"></video>
                    <div class="thumbnail-preview" id="thumbnailPreview">
                        <img id="thumbnailImg" src="" alt="Preview" />
                        <div class="thumbnail-time" id="thumbnailTime">00:00</div>
                    </div>
                    <div class="loading-overlay" id="loadingOverlay">
                        <div class="spinner"></div>
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
                        
                        <!-- Synopsis -->
                        @if(isset($synopsis) && $synopsis)
                            <div class="anime-synopsis">
                                {{ $synopsis }}
                            </div>
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
    </div>
