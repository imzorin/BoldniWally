        (function() {
            "use strict";

            // ----- DOM refs -----
            const video = document.getElementById('video');
            const videoWrapper = document.getElementById('videoWrapper');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const epGrid = document.getElementById('epGrid');
            const epSearch = document.getElementById('epSearch');
            const groupSelector = document.getElementById('groupSelector');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const mobileToggle = document.getElementById('mobileToggle');
            const epPanel = document.getElementById('epPanel');
            
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

            // Comments refs
            const commentInput = document.getElementById('commentInput');
            const commentSubmit = document.getElementById('commentSubmit');
            const commentList = document.getElementById('commentList');
            const commentCount = document.getElementById('commentCount');

            // ----- episode data -----
            const allEpisodes = window.KAA_DATA.episodes
            let currentSlug =window.KAA_DATA.episode
            const animeSlug =window.KAA_DATA.anime
            let currentEpNumber = null;
            const epMap = {};
            allEpisodes.forEach(ep => {
                epMap[ep.slug] = ep.episode_number;
                if (ep.slug === currentSlug) currentEpNumber = ep.episode_number;
            });

            // ----- localStorage keys -----
            const STORAGE_KEY = 'kaa_continue_watch';
            const AUTO_PLAY_KEY = 'kaa_auto_play';
            const AUTO_NEXT_KEY = 'kaa_auto_next';
            const QUALITY_KEY = 'kaa_quality';
            const SUBTITLE_KEY = 'kaa_subtitle_lang';
            const SPEED_KEY = 'kaa_speed';
            const COMMENTS_KEY = 'kaa_comments';

            // ----- localStorage continue-watching -----
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

            // ----- Auto Play / Next -----
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
            });
            autoNextToggle.addEventListener('click', function() {
                autoNextEnabled = !autoNextEnabled;
                localStorage.setItem(AUTO_NEXT_KEY, autoNextEnabled);
                updateToggleUI();
            });
            const originalPlay = video.play.bind(video);
            video.play = function() {
                if (autoPlayEnabled) return originalPlay();
                return Promise.resolve();
            };

            // ----- Quality Menu -----
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

            // ----- Speed Control -----
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

            // ----- Subtitle Management (FIXED: no stale restore) -----
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
                // If track not found but we have subtitles, try re-adding
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
                
                // Remove existing tracks
                const existingTracks = video.querySelectorAll('track');
                console.log('Removing', existingTracks.length, 'existing tracks');
                existingTracks.forEach(track => {
                    if (track.kind === 'subtitles') track.remove();
                });
                
                // Verify tracks are removed
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
                
                // Add new tracks with debug logging
                subtitles.forEach((sub, index) => {
                    if (!sub.src || !sub.language) return;
                    const track = document.createElement('track');  
                    track.kind = 'subtitles';
                    track.label = sub.name || sub.language;
                    track.srclang = sub.language;
                    track.src = sub.src;
                    track.default = false;
                    
                    // Debug: track load/error events
                    track.addEventListener('load', function() {
                        console.log('TRACK_LOADED', this.srclang, this.track?.cues?.length, 'cues');
                    });
                    track.addEventListener('error', function() {
                        console.log('TRACK_ERROR', this.srclang);
                    });
                    
                    video.appendChild(track);
                    console.log(`Added track ${index + 1}/${subtitles.length}:`, sub.language, sub.src);
                });
                
                // Wait for tracks to be processed by browser
                setTimeout(() => {
                    console.log('After adding, textTracks.length =', video.textTracks.length);
                    for (let i = 0; i < video.textTracks.length; i++) {
                        const track = video.textTracks[i];
                        console.log(`Track ${i}:`, track.label, track.language, track.kind, 'cues:', track.cues?.length || 0);
                    }
                }, 200);
                
                // Apply selected language after tracks are added
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
                    // If selected not found, default to off
                    if (!foundSelected && selectedSubtitleLang !== 'off' && subtitles.length > 0) {
                        const selectedSub = subtitles.find(s => s.language === selectedSubtitleLang);
                        if (!selectedSub) {
                            selectedSubtitleLang = 'off';
                            localStorage.setItem(SUBTITLE_KEY, 'off');
                        }
                    }
                    buildCaptionsMenu(subtitles);
                    
                    // Final debug: log track states after 1s
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

            // ============================================================
            // ROOT FIX: Fullscreen on videoWrapper instead of video
            // This ensures the thumbnail stays in the fullscreen rendering layer
            // ============================================================
            
            // Override the native fullscreen behavior
            const originalRequestFullscreen = video.requestFullscreen;
            
            // Replace video.requestFullscreen with wrapper.requestFullscreen
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
                // Fallback to original
                return originalRequestFullscreen.call(video);
            };
            
            // Also handle webkit fullscreen
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

            // ----- Thumbnail Preview (ROOT FIX - Works in all modes) -----
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

                // Load VTT data
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

                // Detect timeline position - works in both normal and fullscreen
                function getTimelineRect() {
                    const videoRect = video.getBoundingClientRect();
                    const wrapperRect = videoWrapper.getBoundingClientRect();
                    
                    // Use the wrapper rect for fullscreen detection
                    const isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement);
                    const targetRect = isFullscreen ? wrapperRect : videoRect;
                    
                    let rect = null;
                    
                    // Try to find the actual timeline element
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

                // Clean up old listeners
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

                // Position the thumbnail - works in both normal and fullscreen
                function positionThumbnail(e) {
                    const videoRect = video.getBoundingClientRect();
                    const wrapperRect = videoWrapper.getBoundingClientRect();
                    const isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement);
                    
                    // Use the appropriate rect for positioning
                    const targetRect = isFullscreen ? wrapperRect : videoRect;
                    
                    // Horizontal positioning
                    const previewWidth = 200;
                    const displayWidth = targetRect.width;
                    const displayLeft = targetRect.left;
                    const leftPos = Math.max(10, Math.min(displayWidth - previewWidth - 10, (e.clientX - displayLeft) - previewWidth / 2));
                    thumbnailPreview.style.left = leftPos + 'px';
                    thumbnailPreview.style.transform = 'none';
                    
                    // Vertical positioning - always position relative to the wrapper
                    const previewHeight = thumbnailPreview.offsetHeight || 214;
                    // Position above the controls
                    const controlsHeight = isFullscreen ? Math.min(80, targetRect.height * 0.12) : Math.min(60, targetRect.height * 0.10);
                    const topPosition = targetRect.height - previewHeight - controlsHeight - 20;
                    
                    thumbnailPreview.style.top = topPosition + 'px';
                    thumbnailPreview.style.bottom = 'auto';
                }

                function onDocumentMouseMove(e) {
                    // Check if cursor is directly over the timeline
                    const onTimeline = isCursorOnTimeline(e.clientX, e.clientY);
                    
                    if (!onTimeline) {
                        if (isHoveringTimeline) {
                            isHoveringTimeline = false;
                            scheduleHide();
                        }
                        return;
                    }
                    
                    // Cursor IS on the timeline
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
                    
                    // Calculate position using the video's bounding rect
                    const videoRect = video.getBoundingClientRect();
                    const displayWidth = videoRect.width;
                    const displayLeft = videoRect.left;
                    
                    const x = Math.max(0, Math.min(1, (e.clientX - displayLeft) / displayWidth));
                    const duration = video.duration || 1;
                    const currentTime = x * duration;
                    
                    // Find matching thumbnail cue
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

                // Setup initial listeners
                setupThumbnailListeners();

                // Handle fullscreen changes
                function handleFullscreenChange() {
                    const fsElement = document.fullscreenElement || document.webkitFullscreenElement;
                    console.log('Fullscreen change - element:', fsElement);
                    console.log('fullscreenElement tag:', fsElement ? fsElement.tagName : 'null');
                    console.log('Expected fullscreen target: DIV#videoWrapper');
                    
                    // Reset state
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

                // Listen for fullscreen events (cross-browser)
                document.addEventListener('fullscreenchange', handleFullscreenChange);
                document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
                document.addEventListener('mozfullscreenchange', handleFullscreenChange);
                document.addEventListener('MSFullscreenChange', handleFullscreenChange);
                
                // Handle zoom/resize
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        if (!thumbnailListenersActive) {
                            setupThumbnailListeners();
                        }
                    }, 200);
                });

                // Hide thumbnail when clicking anywhere not on timeline
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

                // Clean up on page unload
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

            // ----- Loading Overlay -----
            function showLoading() { loadingOverlay.classList.add('is-active'); }
            function hideLoading() { loadingOverlay.classList.remove('is-active'); }
            document.addEventListener('click', function(e) {
                const link = e.target.closest('.episode-link');
                if (link) {
                    showLoading();
                    if (video.currentTime > 0) saveProgress(currentSlug, video.currentTime);
                }
            });
            video.addEventListener('canplay', hideLoading);
            video.addEventListener('error', hideLoading);

            // ----- Auto-next -----
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

            // ----- Prev / Next -----
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

            // ----- Episode grouping -----
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
                groupSelector.innerHTML = '';
                groups.forEach(g => {
                    const btn = document.createElement('button');
                    btn.className = 'group-btn';
                    btn.dataset.start = g.start;
                    btn.dataset.end = g.end;
                    btn.textContent = g.label;
                    groupSelector.appendChild(btn);
                });
                const currentNum = currentEpNumber || 1;
                const currentRange = getGroupRange(currentNum);
                const btns = groupSelector.querySelectorAll('.group-btn');
                btns.forEach(btn => {
                    const start = parseInt(btn.dataset.start);
                    if (start === currentRange.start) {
                        btn.classList.add('active');
                        activeGroup = currentRange;
                    } else btn.classList.remove('active');
                });
                if (!groupSelector.querySelector('.group-btn.active')) {
                    const first = groupSelector.querySelector('.group-btn');
                    if (first) {
                        first.classList.add('active');
                        const s = parseInt(first.dataset.start);
                        const e = parseInt(first.dataset.end);
                        activeGroup = { start: s, end: e, label: first.textContent };
                    }
                }
                applyGroupFilter();
            }
            function applyGroupFilter() {
                if (!activeGroup) return;
                const items = epGrid.querySelectorAll('.episode-link');
                items.forEach(el => {
                    const num = parseInt(el.dataset.number);
                    if (num >= activeGroup.start && num <= activeGroup.end) el.classList.remove('hidden');
                    else el.classList.add('hidden');
                });
                applySearchFilter();
                updateNavButtons();
            }
            function switchToGroupForEpisode(episodeNumber) {
                const range = getGroupRange(episodeNumber);
                if (!activeGroup || activeGroup.start !== range.start) {
                    activeGroup = range;
                    const btns = groupSelector.querySelectorAll('.group-btn');
                    btns.forEach(btn => {
                        const start = parseInt(btn.dataset.start);
                        if (start === range.start) btn.classList.add('active');
                        else btn.classList.remove('active');
                    });
                    applyGroupFilter();
                    if (epPanel.classList.contains('collapsed')) {
                        epPanel.classList.remove('collapsed');
                        mobileToggle.classList.remove('open');
                    }
                    updateNavButtons();
                }
            }
            groupSelector.addEventListener('click', function(e) {
                const btn = e.target.closest('.group-btn');
                if (!btn) return;
                const start = parseInt(btn.dataset.start);
                const end = parseInt(btn.dataset.end);
                activeGroup = { start, end, label: btn.textContent };
                groupSelector.querySelectorAll('.group-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                applyGroupFilter();
                if (epPanel.classList.contains('collapsed')) {
                    epPanel.classList.remove('collapsed');
                    mobileToggle.classList.remove('open');
                }
                updateNavButtons();
            });

            // ----- Search -----
            function applySearchFilter() {
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
            epSearch.addEventListener('input', applySearchFilter);

            // ----- click on episode (FIXED: proper lifecycle) -----
            document.querySelectorAll('.episode-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Let the main HLS click handler do the work
                    // This is just for UI updates after HLS is ready
                    setTimeout(() => {
                        const newSlug = this.dataset.episode;
                        if (newSlug !== currentSlug) {
                            if (video.currentTime > 0) saveProgress(currentSlug, video.currentTime);
                            currentSlug = newSlug;
                            currentEpNumber = parseInt(this.dataset.number);
                            document.querySelectorAll('.episode-link').forEach(el => el.classList.remove('active'));
                            this.classList.add('active');
                            switchToGroupForEpisode(currentEpNumber);
                            const saved = getProgress(currentSlug);
                            if (saved > 0) {
                                video.addEventListener('loadedmetadata', function onMeta() {
                                    video.currentTime = saved;
                                    video.removeEventListener('loadedmetadata', onMeta);
                                }, { once: true });
                            }
                            updateNavButtons();
                        }
                    }, 50);
                });
            });

            // ----- mobile toggle -----
            mobileToggle.addEventListener('click', function() {
                epPanel.classList.toggle('collapsed');
                this.classList.toggle('open');
            });
            if (window.innerWidth > 820) {
                epPanel.classList.remove('collapsed');
                mobileToggle.classList.remove('open');
            }

            // ----- Comments System -----
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

            // Load comments on page load
            loadComments();

            // ----- init -----
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

            // Watch for HLS levels
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

            // Initial subtitles & thumbnails from backend
            const initialSubtitles = window.KAA_DATA.subtitles
            const initialThumbnails = window.KAA_DATA.thumbnails

            console.log(
                'INITIAL_THUMBNAILS',
                initialThumbnails
            );

            if (initialThumbnails)
                setupThumbnailPreview(initialThumbnails);

            if (initialSubtitles && initialSubtitles.length > 0) {
                if (selectedSubtitleLang === 'off' || !selectedSubtitleLang) {
                    selectedSubtitleLang = 'off';
                    localStorage.setItem(SUBTITLE_KEY, 'off');
                }
                // Wait for video to be ready before adding initial subtitles
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

            // Expose to window
            window.__kaa = {
                showLoading, hideLoading, updateNavButtons, applyGroupFilter, applySearchFilter,
                switchToGroupForEpisode, getAdjacentLink, populateQualityMenu,
                selectedQuality, autoPlayEnabled, autoNextEnabled,
                addSubtitleTracks, setupThumbnailPreview, selectSubtitle,
                selectedSubtitleLang, currentSubtitles
            };
            console.log('KAA UI ready (subtitle lifecycle fixed)');
        })();
   


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
                // DON'T add subtitles here - let the episode click handler do it after HLS is ready
                manifestCache[episode] = data.manifest;
                
                // Prefetch the manifest to warm cache
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

            const firstManifest = '/kaa-cat?url=' + encodeURIComponent('window.KAA_DATA.manifest');

            // ----- FIXED EPISODE CLICK HANDLER WITH PROPER LIFECYCLE -----
            document.querySelectorAll('.episode-link').forEach(link => {
                link.addEventListener('click', async function (e) {
                    e.preventDefault();
                    const episode = this.dataset.episode;
                    const episodeNumber = parseInt(this.dataset.number);
                    
                    try {
                        console.time('EPISODE_SWITCH');
                        console.log('Switching to episode:', episode);
                        
                        // Store the subtitle data from manifest
                        let subtitleData = null;
                        let thumbnailData = null;
                        
                        console.time('MANIFEST');
                        const manifest = await getManifest(episode);
                        console.timeEnd('MANIFEST');
                        
                        // Get the full manifest data including subtitles
                        const manifestResponse = await fetch(`/kaa-manifest/{{ $anime }}/${episode}`);
                        const manifestData = await manifestResponse.json();
                        subtitleData = manifestData.subtitles || [];
                        thumbnailData = manifestData.thumbnails || null;
                        
                        console.log('Subtitle data for episode:', subtitleData.length, 'tracks');
                        
                        const newManifest = '/kaa-cat?url=' + encodeURIComponent(manifest);
                        
                        if (Hls.isSupported()) {
                            console.time('PLAYER_LOAD');
                            
                            // Destroy old HLS
                            if (hls) {
                                hls.stopLoad();
                                hls.detachMedia();
                                hls.destroy();
                                console.log('Old HLS destroyed');
                            }
                            
                            // Create new HLS instance
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
                            
                            // Wait for manifest to parse before adding subtitles
                            let subtitlesAdded = false;
                            
                            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                                console.log('MANIFEST_PARSED - adding subtitles now');
                                
                                // NOW add subtitles after HLS is ready
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
                                
                                // Restore quality selection
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
                                
                                console.timeEnd('PLAYER_LOAD');
                                console.timeEnd('EPISODE_SWITCH');
                            });
                            
                            // Fallback: if manifest parsed already happened, use canplay
                            const onCanPlay = () => {
                                console.log('VIDEO_CANPLAY - fallback subtitle add');
                                if (subtitleData && subtitleData.length > 0 && window.__kaa && !subtitlesAdded) {
                                    // Check if tracks already exist
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
                            // For non-HLS browsers
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
                        
                        // Update UI
                        history.pushState({}, '', `/kaa-watch/{{ $anime }}/${episode}`);
                        document.querySelectorAll('.episode-link').forEach(el => el.classList.remove('active'));
                        this.classList.add('active');
                        
                        if (episodeNumber && window.__kaa && window.__kaa.switchToGroupForEpisode) {
                            window.__kaa.switchToGroupForEpisode(episodeNumber);
                        }
                        
                        // Prefetch next episodes
                        prefetchNextEpisode(this);
                        
                    } catch (error) {
                        console.error('Episode switch error:', error);
                        hideLoading();
                    }
                });
            });

            // Initial HLS setup
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
                    video.play().catch(() => {});
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
                    video.muted = true;
                    video.play().catch(() => {});
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
