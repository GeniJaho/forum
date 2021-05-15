<template>
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu"
                            :aria-expanded="String(mobileMenuActive)"
                            @click="toggleMobileMenu"
                    >
                        <span class="sr-only">Open main menu</span>
                        <svg
                            class="h-6 w-6"
                            :class="{ 'hidden': mobileMenuActive, 'block': !mobileMenuActive }"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg
                            class="h-6 w-6"
                            :class="{ 'block': mobileMenuActive, 'hidden': !mobileMenuActive }"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-white text-base font-medium transform-none">
                            Forum
                        </a>
                    </div>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">

                            <!--  Browse ------------------------------------- -->

                            <div class="relative inline-block text-left">
                                <div>
                                    <button type="button"
                                            class="inline-flex justify-center w-full text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                            id="menu-button"
                                            @click="toggleBrowseDropdown"
                                            :aria-expanded="String(browseDropdownActive)"
                                            aria-haspopup="true"
                                    >
                                        Browse
                                        <!-- Heroicon name: solid/chevron-down -->
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>

                                <div
                                    v-show="browseDropdownActive"
                                    class="origin-top-left absolute left-0 mt-2 w-56 z-10 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                                >
                                    <div class="py-1" role="none">
                                        <a href="/threads"
                                           class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                                           role="menuitem" tabindex="-1">
                                            All Threads
                                        </a>
                                        <a v-if="signedIn"
                                           :href="'/threads?by=' + $userName"
                                           class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                                           role="menuitem"
                                           tabindex="-1"
                                        >My Threads</a>
                                        <a href="/threads?popular=1"
                                           class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                                           role="menuitem" tabindex="-1">
                                            Popular Threads
                                        </a>
                                        <a href="/threads?unanswered=1"
                                           class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                                           role="menuitem" tabindex="-1">
                                            Unanswered Threads
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <!--  Channels ------------------------------------- -->

                            <div
                                v-if="channels"
                                class="relative inline-block text-left"
                            >
                                <div>
                                    <button type="button"
                                            class="inline-flex justify-center w-full text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                            id="menu-button-channels"
                                            @click="toggleChannelsDropdown"
                                            :aria-expanded="String(channelsDropdownActive)"
                                            aria-haspopup="true"
                                    >
                                        Channels
                                        <!-- Heroicon name: solid/chevron-down -->
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>

                                <div
                                    v-show="channelsDropdownActive"
                                    class="origin-top-left absolute left-0 mt-2 w-56 z-10 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button-channels" tabindex="-1"
                                >
                                    <div class="py-1" role="none">
                                        <a
                                            v-for="channel in channels"
                                            :href="'/threads/' + channel.slug"
                                           class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                                           role="menuitem" tabindex="-1">
                                            {{ channel.name }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <template v-if="guest">
                        <a href="/login"
                           class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Login
                        </a>
                        <a href="/register"
                           class="ml-6 bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">
                            Register
                        </a>
                    </template>
                    <template v-else>
                        <a href="/threads/create"
                           class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">
                            <!-- Heroicon name: solid/plus -->
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>New Thread</span>
                        </a>

                        <user-notifications></user-notifications>

                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <div>
                                <Avatar
                                    id="user-menu-button"
                                    @click="toggleProfileDropdown"
                                    :user="$user"
                                    :aria-expanded="String(profileDropdownActive)"
                                    aria-haspopup="true"/>
                            </div>

                            <div v-show="profileDropdownActive"
                                 class="origin-top-right absolute right-0 mt-2 w-48 z-10 divide-y divide-gray-100 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                 role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                 tabindex="-1">

                                <div class="px-4 py-3">
                                    <p class="text-sm" v-text="$user.name"></p>
                                </div>

                                <div>
                                <a :href="'/profiles/' + $userName"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                   role="menuitem" tabindex="-1">
                                    My Profile
                                </a>
                                <form method="POST" action="/logout" role="none">
                                    <input type="hidden" name="_token" :value="csrfToken">
                                    <button type="submit"
                                            class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                            role="menuitem" tabindex="-1">
                                        Sign out
                                    </button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu" v-if="mobileMenuActive">
            <div class="px-2 pt-2 pb-3 space-y-1">

                <!--  Browse Mobile ------------------------------------- -->

                <div class="relative inline-block text-left">
                    <div>
                        <button type="button"
                                class="inline-flex justify-center w-full text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                id="menu-button"
                                @click="toggleBrowseDropdown"
                                :aria-expanded="String(browseDropdownActive)"
                                aria-haspopup="true"
                        >
                            Browse
                            <!-- Heroicon name: solid/chevron-down -->
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>

                    <div v-show="browseDropdownActive"
                         class="origin-top-left absolute left-0 mt-2 w-56 z-10 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                         role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a href="/threads"
                               class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                               role="menuitem" tabindex="-1">
                                All Threads
                            </a>
                            <a v-if="signedIn"
                               :href="'/threads?by=' + $userName"
                               class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                               role="menuitem"
                               tabindex="-1"
                            >My Threads</a>
                            <a href="/threads?popular=1"
                               class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                               role="menuitem" tabindex="-1">
                                Popular Threads
                            </a>
                            <a href="/threads?unanswered=1"
                               class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                               role="menuitem" tabindex="-1">
                                Unanswered Threads
                            </a>
                        </div>
                    </div>
                </div>

                <!--  Channels Mobile ------------------------------------- -->

                <div
                    v-if="channels"
                    class="relative inline-block text-left"
                >
                    <div>
                        <button type="button"
                                class="inline-flex justify-center w-full text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                id="menu-button-channels"
                                @click="toggleChannelsDropdown"
                                :aria-expanded="String(channelsDropdownActive)"
                                aria-haspopup="true"
                        >
                            Channels
                            <!-- Heroicon name: solid/chevron-down -->
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>

                    <div v-show="channelsDropdownActive"
                         class="origin-top-left absolute left-0 mt-2 w-56 z-10 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                         role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a
                                v-for="channel in channels"
                                :href="'/threads/' + channel.slug"
                                class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm"
                                role="menuitem" tabindex="-1">
                                {{ channel.name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import Avatar from "./Avatar";

export default {
    name: "Navbar",
    components: {Avatar},
    data() {
        return {
            csrfToken: document.querySelector('meta[name="csrf-token"]').content,
            mobileMenuActive: false,
            profileDropdownActive: false,
            browseDropdownActive: false,
            channelsDropdownActive: false,
            channels: []
        }
    },
    methods: {
        toggleMobileMenu() {
            this.mobileMenuActive = !this.mobileMenuActive;
        },
        toggleProfileDropdown() {
            this.profileDropdownActive = !this.profileDropdownActive;
        },
        toggleBrowseDropdown() {
            this.browseDropdownActive = !this.browseDropdownActive;
        },
        toggleChannelsDropdown() {
            this.channelsDropdownActive = !this.channelsDropdownActive;
        },
        getChannels() {
            axios.get('/channels')
                .then(response => this.channels = response.data);
        }
    },
    mounted() {
        this.getChannels();
    }
}
</script>

