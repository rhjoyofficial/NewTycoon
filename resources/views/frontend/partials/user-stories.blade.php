<!-- User Stories in Motion Section -->
<section class="w-full bg-white py-8">
    <div class="max-w-8xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 font-poppins">
                User Stories in Motion
            </h2>
            <p class="text-lg md:text-xl text-gray-600 font-cambay">
                See how our products come to life through real user experiences and stories
            </p>
        </div>

        <!-- Single Swiper for all screen sizes -->
        <div class="swiper userStoriesSwiper">
            <div class="swiper-wrapper">
                @foreach ($userStories as $index => $story)
                    <div class="swiper-slide">
                        <div class="w-full">
                            <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-lg">
                                <!-- Video Container -->
                                <div class="relative aspect-[9/16] bg-black">
                                    <video id="video-{{ $index }}" class="w-full h-full object-cover" controls
                                        playsinline preload="metadata" poster="{{ asset($story->thumbnail) ?? '' }}"
                                        data-video-index="{{ $index }}">
                                        <source src="{{ asset($story->video_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                    <!-- Loading indicator -->
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black/50 video-loading hidden">
                                        <div
                                            class="w-12 h-12 border-4 border-white/30 border-t-white rounded-full animate-spin">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-12 md:mt-16">
            <button
                class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-full font-semibold hover:bg-primary-dark transition-all duration-300 transform hover:scale-105 font-poppins">
                Share Your Story
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
            <p class="text-gray-500 text-sm mt-4 font-cambay">
                Upload your experience and get featured
            </p>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing User Stories Swiper...');

            // Get all videos
            const videos = document.querySelectorAll('video[data-video-index]');
            console.log(`Found ${videos.length} videos`);

            // Initialize single swiper with responsive settings
            const swiper = new Swiper('.userStoriesSwiper', {
                // Responsive slides per view
                slidesPerView: 1,
                spaceBetween: 16,
                loop: true,
                speed: 300,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: true,
                },
                navigation: false,
                pagination: false,

                // Responsive breakpoints
                breakpoints: {
                    // Mobile: 1 video
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 16,
                    },
                    // Tablet: 3 videos (640px and up)
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    // Laptop: 4 videos (1024px and up)
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 28,
                    },
                },

                on: {
                    init: function() {
                        console.log('Swiper initialized successfully');
                        console.log('Current slides per view:', this.params.slidesPerView);

                        // Initialize video event listeners
                        initVideoControls();
                    },

                    slideChange: function() {
                        console.log('Slide changed to index:', this.activeIndex);

                        // Pause all videos when slide changes
                        pauseAllVideos();
                    },

                    resize: function() {
                        console.log('Window resized, current slides per view:', this.params
                            .slidesPerView);
                    }
                }
            });

            // Initialize video controls
            function initVideoControls() {
                console.log('Initializing video controls...');

                videos.forEach((video, index) => {
                    const container = video.parentElement;
                    const loadingIndicator = container.querySelector('.video-loading');

                    console.log(`Setting up video ${index}:`, video.id);

                    // Show loading indicator when video starts loading
                    video.addEventListener('loadstart', function() {
                        console.log(`Video ${index} loading started`);
                        if (loadingIndicator) {
                            loadingIndicator.classList.remove('hidden');
                        }
                    });

                    // Hide loading indicator when video can play
                    video.addEventListener('canplay', function() {
                        console.log(`Video ${index} can play`);
                        if (loadingIndicator) {
                            loadingIndicator.classList.add('hidden');
                        }
                    });

                    // Handle video errors
                    video.addEventListener('error', function(e) {
                        console.error(`Video ${index} error:`, this.error);
                        console.error('Error details:', {
                            code: this.error ? this.error.code : 'N/A',
                            message: this.error ? this.error.message : 'N/A',
                            networkState: this.networkState,
                            readyState: this.readyState,
                            src: this.currentSrc || this.src
                        });

                        if (loadingIndicator) {
                            loadingIndicator.classList.add('hidden');
                        }
                    });

                    // Log when video metadata is loaded
                    video.addEventListener('loadedmetadata', function() {
                        console.log(
                            `Video ${index} metadata loaded - Duration: ${this.duration.toFixed(2)}s`
                        );
                    });

                    // Pause other videos when one starts playing
                    video.addEventListener('play', function() {
                        console.log(`Video ${index} started playing`);

                        // Pause all other videos
                        videos.forEach((otherVideo, otherIndex) => {
                            if (otherIndex !== index && !otherVideo.paused) {
                                console.log(`Pausing other video ${otherIndex}`);
                                otherVideo.pause();
                            }
                        });

                        // Pause swiper autoplay when video plays
                        if (swiper.autoplay.running) {
                            console.log('Pausing swiper autoplay');
                            swiper.autoplay.stop();
                        }
                    });

                    // Resume swiper autoplay when video pauses
                    video.addEventListener('pause', function() {
                        console.log(`Video ${index} paused`);

                        // Check if any video is still playing
                        const anyVideoPlaying = Array.from(videos).some(v => !v.paused);

                        if (!anyVideoPlaying && !swiper.autoplay.running) {
                            console.log('Resuming swiper autoplay');
                            swiper.autoplay.start();
                        }
                    });

                    // Resume swiper autoplay when video ends
                    video.addEventListener('ended', function() {
                        console.log(`Video ${index} ended`);

                        if (!swiper.autoplay.running) {
                            console.log('Resuming swiper autoplay after video ended');
                            swiper.autoplay.start();
                        }
                    });
                });

                console.log('Video controls initialized');
            }

            // Function to pause all videos
            function pauseAllVideos() {
                console.log('Pausing all videos...');
                let pausedCount = 0;

                videos.forEach((video, index) => {
                    if (!video.paused) {
                        video.pause();
                        pausedCount++;
                        console.log(`Paused video ${index}`);
                    }
                });

                console.log(`Paused ${pausedCount} videos`);

                // Restart swiper autoplay
                if (!swiper.autoplay.running) {
                    console.log('Restarting swiper autoplay');
                    swiper.autoplay.start();
                }
            }

            // Log initial video states
            console.log('Initial video states:');
            videos.forEach((video, index) => {
                console.log(`Video ${index}:`, {
                    id: video.id,
                    src: video.currentSrc || video.src,
                    paused: video.paused,
                    readyState: video.readyState,
                    networkState: video.networkState
                });
            });

            // Add click handler to pause all videos when clicking outside
            document.addEventListener('click', function(e) {
                // If click is not on a video or video controls
                if (!e.target.closest('video') && !e.target.closest('.video-controls')) {
                    pauseAllVideos();
                }
            });

            console.log('User Stories section initialized successfully');
        });
    </script>
@endpush
