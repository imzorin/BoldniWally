<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Profile Statistics') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="bg-red-100 dark:bg-red-900/20 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400" id="favoritesCount">-</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">❤️ Favorites</div>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900/20 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400" id="watchlistCount">-</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">📺 Watchlist</div>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900/20 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="reviewsCount">-</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">⭐ Reviews</div>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900/20 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400" id="currentlyWatchingCount">-</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">▶ Currently Watching</div>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900/20 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400" id="recentlyWatchedCount">-</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">🕒 Recently Watched</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

<script>
fetch('/profile/stats')
    .then(response => response.json())
    .then(data => {
        document.getElementById('favoritesCount').textContent = data.favorites;
        document.getElementById('watchlistCount').textContent = data.watchlist;
        document.getElementById('reviewsCount').textContent = data.reviews;
        document.getElementById('currentlyWatchingCount').textContent = data.currently_watching;
        document.getElementById('recentlyWatchedCount').textContent = data.recently_watched;
    })
    .catch(error => console.error('Error loading stats:', error));
</script>
</x-app-layout>