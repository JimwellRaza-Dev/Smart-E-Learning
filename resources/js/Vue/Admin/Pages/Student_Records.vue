<template>
    <div class="w-full min-w-0 shrink-0 md:shrink md:flex-1 md:min-h-[320px] flex flex-col gap-4">

        <!-- STAT CARDS (4-column responsive grid) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4 shrink-0">

            <!-- TOTAL RECORDS -->
            <button
                type="button"
                @click="setViewMode('records', 'All')"
                class="group text-left min-w-0 sharedTXT flex flex-col items-start justify-center gap-1 sm:flex-row sm:items-center sm:justify-start sm:gap-3.5 p-3 sm:p-4 rounded-2xl sharedSurface shadow-lg sharedShadow hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 cursor-pointer"
            >
                <div class="hidden sm:flex items-center justify-center shrink-0 w-11 h-11 rounded-xl sharedTile">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 sharedTXTAccent">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                    </svg>
                </div>
                <div class="flex flex-col justify-center min-w-0">
                    <span class="text-xl sm:text-2xl font-bold leading-tight tabular-nums">{{ totalCount }}</span>
                    <span class="text-[10px] sm:text-xs font-medium sharedTXTMuted leading-tight">Total IDs</span>
                </div>
            </button>

            <!-- ACTIVE RECORDS -->
            <button
                type="button"
                @click="setViewMode('records', 'Active')"
                class="group text-left min-w-0 sharedTXT flex flex-col items-start justify-center gap-1 sm:flex-row sm:items-center sm:justify-start sm:gap-3.5 p-3 sm:p-4 rounded-2xl sharedSurface shadow-lg sharedShadow hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 cursor-pointer"
            >
                <div class="hidden sm:flex items-center justify-center shrink-0 w-11 h-11 rounded-xl sharedTile">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 sharedStateText">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div class="flex flex-col justify-center min-w-0">
                    <span class="text-xl sm:text-2xl font-bold leading-tight tabular-nums">{{ activeCount }}</span>
                    <span class="text-[10px] sm:text-xs font-medium sharedTXTMuted leading-tight">Active IDs</span>
                </div>
            </button>

            <!-- DISABLED RECORDS -->
            <button
                type="button"
                @click="setViewMode('records', 'Disabled')"
                class="group text-left min-w-0 sharedTXT flex flex-col items-start justify-center gap-1 sm:flex-row sm:items-center sm:justify-start sm:gap-3.5 p-3 sm:p-4 rounded-2xl sharedSurface shadow-lg sharedShadow hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 cursor-pointer"
            >
                <div class="hidden sm:flex items-center justify-center shrink-0 w-11 h-11 rounded-xl sharedTile">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 sharedTXTDanger">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <div class="flex flex-col justify-center min-w-0">
                    <span class="text-xl sm:text-2xl font-bold leading-tight tabular-nums">{{ disabledCount }}</span>
                    <span class="text-[10px] sm:text-xs font-medium sharedTXTMuted leading-tight">Disabled IDs</span>
                </div>
            </button>

            <!-- BLOCKED LOGIN ATTEMPTS -->
            <button
                type="button"
                @click="setViewMode('dashboard', null, 'blocked')"
                class="group text-left min-w-0 sharedTXT flex flex-col items-start justify-center gap-1 sm:flex-row sm:items-center sm:justify-start sm:gap-3.5 p-3 sm:p-4 rounded-2xl sharedSurface shadow-lg sharedShadow hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 cursor-pointer relative"
                :class="unreadBlockedAttemptsCount > 0 ? 'ring-1 ring-red-500/40 bg-red-500/5' : ''"
            >
                <div
                    class="hidden sm:flex items-center justify-center shrink-0 w-11 h-11 rounded-xl"
                    :class="unreadBlockedAttemptsCount > 0 ? 'sharedStateDanger sharedStateTint' : 'sharedTile'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="size-5"
                        :class="unreadBlockedAttemptsCount > 0 ? 'sharedTXTDanger' : 'sharedTXTMuted'"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <div class="flex flex-col justify-center min-w-0">
                    <div class="flex items-center gap-1.5">
                        <span
                            class="text-xl sm:text-2xl font-bold leading-tight tabular-nums"
                            :class="unreadBlockedAttemptsCount > 0 ? 'text-red-500 font-extrabold' : ''"
                        >
                            {{ blockedAttemptsCount }}
                        </span>
                        <span v-if="unreadBlockedAttemptsCount > 0" class="inline-flex size-2 rounded-full bg-red-500 animate-pulse"></span>
                    </div>
                    <span class="text-[10px] sm:text-xs font-medium sharedTXTMuted leading-tight">Blocked Logins</span>
                </div>
            </button>

        </div>

        <!-- SECURITY ALERT BANNER -->
        <div
            v-if="unreadBlockedAttemptsCount > 0"
            class="flex items-start sm:items-center justify-between gap-3 p-3.5 sm:px-4 sm:py-3 rounded-2xl border border-red-500/30 bg-red-500/10 text-red-500 text-xs sm:text-sm shrink-0 transition-all duration-200"
        >
            <div class="flex items-start sm:items-center gap-2.5 min-w-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 text-red-500 mt-0.5 sm:mt-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <div class="leading-snug break-words">
                    <span class="font-bold">Security Alert:</span>
                    <span> {{ unreadBlockedAttemptsCount }} unauthorized login {{ unreadBlockedAttemptsCount === 1 ? 'attempt' : 'attempts' }} detected with disabled student IDs.</span>
                    <span v-if="latestBlockedAttempt" class="hidden md:inline text-red-400 font-medium"> (Latest: ID {{ latestBlockedAttempt.target }} — {{ formatTimeAgo(latestBlockedAttempt.created_at) }})</span>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <button
                    type="button"
                    @click="setViewMode('dashboard', null, 'blocked')"
                    class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all cursor-pointer"
                >
                    View Log
                </button>
                <button
                    type="button"
                    @click="markBlockedAttemptsViewed"
                    aria-label="Dismiss alert"
                    class="p-1 rounded-lg hover:bg-red-500/20 text-red-400 hover:text-red-600 transition-colors cursor-pointer"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- VIEW SELECTOR BAR & ADD BUTTON -->
        <div class="w-full shrink-0 flex flex-col gap-2.5 sm:flex-row sm:items-center sm:justify-between">

            <!-- VIEW SELECTOR TABS -->
            <div class="flex items-center gap-1 p-1 rounded-xl border sharedBorder sharedSurfaceBG w-fit max-w-full overflow-x-auto">
                <button
                    type="button"
                    @click="currentView = 'records'"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-all duration-200 cursor-pointer"
                    :class="currentView === 'records' ? 'sharedBtn' : 'sharedTXTMuted sharedRowHover sharedHoverTXT'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                    </svg>
                    <span>Student Directory</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full font-mono" :class="currentView === 'records' ? 'bg-white/20' : 'sharedTile'">
                        {{ recordsList.length }}
                    </span>
                </button>

                <button
                    type="button"
                    @click="setViewMode('dashboard')"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-all duration-200 cursor-pointer relative"
                    :class="currentView === 'dashboard' ? 'sharedBtn' : 'sharedTXTMuted sharedRowHover sharedHoverTXT'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.143 2.143L15.75 6" />
                    </svg>
                    <span>Mini Dashboard</span>
                    <span
                        v-if="unreadBlockedAttemptsCount > 0"
                        class="text-[10px] px-1.5 py-0.2 rounded-full font-bold bg-red-500 text-white animate-pulse"
                    >
                        {{ unreadBlockedAttemptsCount }}
                    </span>
                    <span v-else class="text-[10px] px-1.5 py-0.2 rounded-full font-mono" :class="currentView === 'dashboard' ? 'bg-white/20' : 'sharedTile'">
                        {{ activitiesList.length }}
                    </span>
                </button>

                <!-- SPLIT VIEW TOGGLE (Desktop Only) -->
                <button
                    type="button"
                    @click="setViewMode('split')"
                    class="hidden xl:flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap transition-all duration-200 cursor-pointer"
                    :class="currentView === 'split' ? 'sharedBtn' : 'sharedTXTMuted sharedRowHover sharedHoverTXT'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <span>Split View</span>
                </button>
            </div>

            <!-- ADD STUDENT ID BUTTON -->
            <button
                type="button"
                @click="showAddModal = true"
                class="flex items-center justify-center gap-1.5 px-3 py-2 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-medium sharedBtn cursor-pointer active:scale-95 transition-all duration-200 shrink-0 w-full sm:w-auto"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3.5 sm:size-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add Student ID</span>
            </button>
        </div>

        <!-- MAIN WORKSPACE LAYOUT (Adaptive: Table Only, Dashboard Only, or Split View) -->
        <div
            class="w-full min-w-0 md:flex-1 md:min-h-0 flex flex-col gap-4"
            :class="currentView === 'split' ? 'xl:flex-row' : ''"
        >

            <!-- ========================================================================= -->
            <!-- 1. STUDENT RECORDS DIRECTORY TABLE -->
            <!-- ========================================================================= -->
            <div
                v-show="currentView === 'records' || currentView === 'split'"
                class="w-full min-w-0 rounded-2xl border sharedBorder sharedSurfaceBG shadow-lg sharedShadow overflow-hidden flex flex-col md:flex-1 md:min-h-0"
                :class="currentView === 'split' ? 'xl:flex-[1.4]' : ''"
            >
                <!-- TABLE CONTROLS BAR -->
                <div
                    class="p-3 sm:p-4 border-b sharedBorder flex flex-col gap-3 shrink-0"
                    :class="currentView === 'split' ? '2xl:flex-row 2xl:items-center 2xl:justify-between' : 'lg:flex-row lg:items-center lg:justify-between'"
                >

                    <!-- STATUS TABS -->
                    <div class="flex items-center gap-1 p-1 rounded-xl border sharedBorder sharedTile w-fit max-w-full overflow-x-auto scrollbar-none shrink-0">
                        <button
                            v-for="tab in statusTabs"
                            :key="tab"
                            type="button"
                            @click="activeTab = tab"
                            class="px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap transition-all duration-200 cursor-pointer shrink-0"
                            :class="activeTab === tab
                                ? 'sharedBtn shadow-xs'
                                : 'sharedTXTMuted sharedRowHover sharedHoverTXT'"
                        >
                            {{ tab }}
                        </button>
                    </div>

                    <!-- SEARCH INPUT & RECORD COUNT -->
                    <div
                        class="flex items-center gap-2.5 sm:gap-3 w-full"
                        :class="currentView === 'split' ? '2xl:w-auto' : 'lg:w-auto'"
                    >
                        <div
                            class="relative flex-1"
                            :class="currentView === 'split' ? '2xl:w-[220px] 2xl:flex-none' : 'lg:w-[240px] lg:flex-none'"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor"
                                class="size-4 absolute left-3 top-1/2 -translate-y-1/2 z-10 sharedTXTMuted pointer-events-none">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input
                                v-model="searchQuery"
                                type="search"
                                placeholder="Search records..."
                                aria-label="Search student records"
                                class="w-full h-9 pl-9 pr-3 rounded-xl text-xs sm:text-sm
                                    appearance-none [color-scheme:dark]
                                    sharedInputDark border outline-none
                                    focus:ring-1 transition-all duration-200"
                            >
                        </div>
                        <span class="text-xs font-medium sharedTXTMuted shrink-0 whitespace-nowrap" aria-live="polite">
                            {{ filteredRecords.length }} {{ filteredRecords.length === 1 ? 'record' : 'records' }}
                        </span>
                    </div>

                </div>

                <!-- UNIFIED TABLE SCROLL WRAPPER (Header and Rows scroll together with synchronized columns) -->
                <div class="flex-1 min-h-0 flex flex-col overflow-x-auto overflow-y-hidden scrollbar-thin">
                    <div
                        class="min-w-full min-h-0 flex-1 flex flex-col"
                        :class="currentView === 'split' ? 'min-w-[560px]' : 'min-w-[660px] lg:min-w-0'"
                    >
                        <!-- TABLE HEADER (Desktop) -->
                        <div
                            class="hidden lg:grid shrink-0 items-center px-3 sm:px-4 py-2.5 border-b sharedBorder text-xs font-medium sharedTXTMuted select-none"
                            :class="[gridCols, gridGap]"
                        >
                            <span class="truncate">ID Number</span>
                            <span class="truncate">Course & Year</span>
                            <span class="truncate">Registered Account</span>
                            <span class="text-center truncate">Status</span>
                            <span class="text-right truncate">Actions</span>
                        </div>

                        <!-- TABLE ROWS -->
                        <ul class="overflow-y-auto flex-1 min-h-[300px] max-h-[calc(100dvh-22rem)] scrollbar-thin">
                            <li
                                v-for="record in filteredRecords"
                                :key="record.id"
                                class="flex flex-col gap-3 px-3 sm:px-4 py-3 border-b sharedBorder last:border-b-0 sharedRowHover transition-colors duration-200
                                       lg:grid lg:items-center"
                                :class="[gridCols, gridGap]"
                            >
                                <!-- ID Number & Mobile Badges -->
                                <div class="flex items-center justify-between lg:justify-start gap-2 min-w-0">
                                    <span class="text-sm font-mono font-semibold sharedTXT tabular-nums truncate" :title="record.id_number">
                                        {{ record.id_number }}
                                    </span>

                                    <!-- Mobile Status Badge -->
                                    <span
                                        class="lg:hidden shrink-0 inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium"
                                        :class="record.is_disabled
                                            ? 'sharedStateDanger sharedStateChip ring-1'
                                            : record.user
                                                ? 'sharedStateOpen sharedStateChip ring-1'
                                                : 'sharedStateWarning sharedTile sharedRingSoft'"
                                    >
                                        {{ record.is_disabled ? 'Disabled' : record.user ? 'Active' : 'Unregistered' }}
                                    </span>
                                </div>

                                <!-- Course & Year -->
                                <div class="flex flex-col gap-0.5 min-w-0 text-xs">
                                    <span v-if="record.course" class="font-medium sharedTXT truncate" :title="record.course">{{ record.course }}</span>
                                    <span v-if="record.year_level" class="sharedTXTMuted truncate" :title="record.year_level">{{ record.year_level }}</span>
                                    <span v-if="!record.course && !record.year_level" class="sharedTXTMuted italic text-[11px]">—</span>
                                </div>

                                <!-- Registered Account info -->
                                <div class="flex items-center gap-1.5 min-w-0 text-xs">
                                    <template v-if="record.user">
                                        <span class="font-medium sharedTXT truncate" :title="record.user.name">
                                            {{ record.user.name }}
                                        </span>
                                        <span
                                            class="sharedTXTMuted font-mono truncate"
                                            :class="currentView === 'split' ? 'hidden 2xl:inline' : 'hidden sm:inline'"
                                            :title="record.user.email"
                                        >
                                            ({{ record.user.email }})
                                        </span>
                                    </template>
                                    <template v-else>
                                        <span class="sharedTXTMuted italic text-[11px] truncate">
                                            Not yet registered
                                        </span>
                                    </template>
                                </div>

                                <!-- Desktop Status Badge -->
                                <div class="hidden lg:flex justify-center">
                                    <span
                                        class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-medium whitespace-nowrap"
                                        :class="record.is_disabled
                                            ? 'sharedStateDanger sharedStateChip ring-1'
                                            : record.user
                                                ? 'sharedStateOpen sharedStateChip ring-1'
                                                : 'sharedStateWarning sharedTile sharedRingSoft'"
                                    >
                                        {{ record.is_disabled ? 'Disabled' : record.user ? 'Active' : 'Unregistered' }}
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-1.5 lg:justify-end">

                                    <!-- DISABLE / ENABLE BUTTON -->
                                    <button
                                        type="button"
                                        @click="promptToggleDisable(record)"
                                        :aria-label="`${record.is_disabled ? 'Enable' : 'Disable'} ${record.id_number}`"
                                        :title="record.is_disabled ? 'Enable ID' : 'Disable ID'"
                                        class="flex-1 lg:flex-none flex items-center justify-center gap-1 px-2 py-1 sm:px-2.5 sm:py-1.5 min-h-9 lg:min-h-0 rounded-xl text-xs font-medium ring-1 whitespace-nowrap shrink-0 active:scale-95 transition-all duration-200 cursor-pointer"
                                        :class="record.is_disabled
                                            ? 'sharedStateOpen sharedStateChip sharedStateChipLink'
                                            : 'sharedStateWarning sharedTile sharedRingSoft sharedHoverState'"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5 shrink-0">
                                            <path
                                                v-if="record.is_disabled"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
                                            />
                                            <path
                                                v-else
                                                stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
                                            />
                                        </svg>
                                        <span class="whitespace-nowrap">{{ record.is_disabled ? 'Enable' : 'Disable' }}</span>
                                    </button>

                                    <!-- REMOVE BUTTON -->
                                    <button
                                        type="button"
                                        @click="confirmDelete(record)"
                                        :aria-label="`Remove ${record.id_number}`"
                                        title="Remove ID"
                                        class="flex-1 lg:flex-none flex items-center justify-center gap-1 px-2 py-1 sm:px-2.5 sm:py-1.5 min-h-9 lg:min-h-0 rounded-xl text-xs font-medium ring-1 whitespace-nowrap shrink-0 sharedStateDanger sharedStateChip sharedDangerSolidHover active:scale-95 transition-all duration-200 cursor-pointer"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                        <span class="whitespace-nowrap">Remove</span>
                                    </button>
                                </div>
                            </li>

                            <li v-if="filteredRecords.length === 0" class="px-4 py-12 text-center text-sm sharedTXTMuted flex flex-col items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 opacity-40">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                                <span>{{ searchQuery ? 'No records match your search.' : 'No student IDs found for this filter.' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- 2. MINI DASHBOARD: ACTIVITY & SECURITY FEED -->
            <!-- ========================================================================= -->
            <div
                v-show="currentView === 'dashboard' || currentView === 'split'"
                class="w-full min-w-0 rounded-2xl border sharedBorder sharedSurfaceBG shadow-lg sharedShadow overflow-hidden flex flex-col md:flex-1 md:min-h-0"
                :class="currentView === 'split' ? 'xl:flex-[1]' : ''"
            >
                <!-- MINI DASHBOARD HEADER -->
                <div class="p-3 sm:p-4 border-b sharedBorder flex items-center justify-between gap-3 shrink-0">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center sharedTile shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4.5 sharedTXTAccent">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.143 2.143L15.75 6" />
                            </svg>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm font-semibold sharedTXTBody leading-tight truncate">Activity & Security Feed</span>
                            <span class="text-[11px] sharedTXTMuted leading-tight truncate">Tracking ID management & login attempts</span>
                        </div>
                    </div>

                    <!-- REFRESH BUTTON -->
                    <button
                        type="button"
                        @click="refreshActivities"
                        :disabled="isRefreshingActivities"
                        title="Refresh activity feed"
                        class="p-2 rounded-xl border sharedBorder sharedTile hover:sharedRowHover transition-all cursor-pointer active:scale-95 disabled:opacity-50"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="size-4 sharedTXTMuted"
                            :class="isRefreshingActivities ? 'animate-spin' : ''"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </button>
                </div>

                <!-- FILTER TABS & SEARCH FOR ACTIVITIES -->
                <div class="px-3 py-2.5 sm:px-4 border-b sharedBorder flex flex-col gap-2 shrink-0">

                    <!-- FILTER PILLS -->
                    <div class="flex items-center gap-1 overflow-x-auto pb-0.5 scrollbar-none">
                        <button
                            v-for="flt in activityFilterOptions"
                            :key="flt.value"
                            type="button"
                            @click="activityFilter = flt.value"
                            class="px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap transition-all duration-200 cursor-pointer flex items-center gap-1.5 shrink-0"
                            :class="activityFilter === flt.value
                                ? (flt.value === 'blocked' ? 'bg-red-500 text-white shadow-xs' : 'sharedBtn shadow-xs')
                                : 'sharedTXTMuted sharedRowHover sharedHoverTXT'"
                        >
                            <span>{{ flt.label }}</span>
                            <span
                                v-if="flt.count > 0"
                                class="text-[10px] px-1.5 py-0.2 rounded-full font-mono"
                                :class="flt.value === 'blocked'
                                    ? (activityFilter === flt.value ? 'bg-white/25 text-white' : 'bg-red-500/20 text-red-500 font-bold')
                                    : (activityFilter === flt.value ? 'bg-white/20' : 'sharedTile')"
                            >
                                {{ flt.count }}
                            </span>
                        </button>
                    </div>

                    <!-- SEARCH INPUT -->
                    <div class="relative w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="size-3.5 absolute left-3 top-1/2 -translate-y-1/2 z-10 sharedTXTMuted pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input
                            v-model="activitySearch"
                            type="search"
                            placeholder="Filter activities by ID or name..."
                            class="w-full h-8 pl-8 pr-3 rounded-lg text-xs
                                appearance-none [color-scheme:dark]
                                sharedInputDark border outline-none
                                focus:ring-1 transition-all duration-200"
                        >
                    </div>

                </div>

                <!-- ACTIVITIES LIST -->
                <ul class="overflow-y-auto flex-1 min-h-[300px] max-h-[calc(100dvh-22rem)] scrollbar-thin p-3 sm:p-4 flex flex-col gap-2.5">
                    <li
                        v-for="act in filteredActivities"
                        :key="act.id || act.created_at + act.target"
                        class="p-3 rounded-xl border sharedBorder transition-all duration-200 sharedRowHover flex items-start gap-3 relative"
                        :class="act.action === 'attempted_login_disabled' ? 'border-red-500/30 bg-red-500/[0.04]' : 'sharedSurface'"
                    >
                        <!-- ICON BADGE -->
                        <div
                            class="shrink-0 w-9 h-9 rounded-xl flex items-center justify-center"
                            :class="activityIcon(act.action).badge"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4.5">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="activityIcon(act.action).d" />
                            </svg>
                        </div>

                        <!-- CONTENT -->
                        <div class="flex-1 min-w-0 flex flex-col gap-1">
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                <!-- ACTION TITLE TAG -->
                                <span
                                    class="text-[10px] font-bold tracking-wider uppercase px-2 py-0.5 rounded-full"
                                    :class="activityTag(act.action)"
                                >
                                    {{ activityTitle(act.action) }}
                                </span>

                                <!-- TIME AGO -->
                                <span class="text-[11px] sharedTXTMuted font-mono shrink-0">
                                    {{ formatTimeAgo(act.created_at) }}
                                </span>
                            </div>

                            <!-- DETAILS -->
                            <div class="text-xs sharedTXT leading-relaxed">
                                <template v-if="act.action === 'attempted_login_disabled'">
                                    <span class="font-bold text-red-500">{{ act.name }}</span>
                                    <span class="sharedTXTMuted"> attempted to log in using disabled student ID </span>
                                    <span class="font-mono font-bold text-red-500 px-1.5 py-0.5 rounded bg-red-500/10">{{ act.target }}</span>
                                </template>
                                <template v-else-if="act.action === 'added_student_record' || act.action === 'added_student_records'">
                                    <strong class="font-semibold">{{ act.name }}</strong>
                                    <span class="sharedTXTMuted"> added student ID(s): </span>
                                    <span class="font-mono font-semibold sharedStateOpen sharedStateChip px-1.5 py-0.2 rounded">{{ act.target }}</span>
                                </template>
                                <template v-else-if="act.action === 'disabled_student_record'">
                                    <strong class="font-semibold">{{ act.name }}</strong>
                                    <span class="sharedTXTMuted"> disabled student ID </span>
                                    <span class="font-mono font-semibold sharedStateDanger sharedStateChip px-1.5 py-0.2 rounded line-through">{{ act.target }}</span>
                                </template>
                                <template v-else-if="act.action === 'enabled_student_record'">
                                    <strong class="font-semibold">{{ act.name }}</strong>
                                    <span class="sharedTXTMuted"> enabled student ID </span>
                                    <span class="font-mono font-semibold sharedStateOpen sharedStateChip px-1.5 py-0.2 rounded">{{ act.target }}</span>
                                </template>
                                <template v-else-if="act.action === 'deleted_student_record'">
                                    <strong class="font-semibold">{{ act.name }}</strong>
                                    <span class="sharedTXTMuted"> removed student ID </span>
                                    <span class="font-mono font-semibold sharedStateDanger sharedStateChip px-1.5 py-0.2 rounded line-through">{{ act.target }}</span>
                                </template>
                                <template v-else>
                                    <strong class="font-semibold">{{ act.name }}</strong>
                                    <span class="sharedTXTMuted"> updated student record {{ act.target }}</span>
                                </template>
                            </div>
                        </div>
                    </li>

                    <li v-if="filteredActivities.length === 0" class="py-12 text-center text-xs sharedTXTMuted flex flex-col items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 opacity-30">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>{{ activitySearch ? 'No activities match your search.' : 'No student record activities recorded yet.' }}</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- ADD MODAL -->
        <Teleport to="body">
            <Transition name="modal-fade">
                <div
                    v-if="showAddModal"
                    class="fixed inset-0 w-screen h-screen sharedOverlay backdrop-blur-sm z-[99] flex items-center justify-center p-4"
                    @click.self="closeAdd"
                >
                    <form
                        @submit.prevent="submitAdd"
                        class="modal-card relative w-full max-w-[480px] sharedLightBG rounded-2xl shadow-2xl sharedShadow ring-1 sharedNavRing flex flex-col p-6 gap-4"
                    >
                        <button type="button" @click="closeAdd" aria-label="Close"
                            class="absolute right-4 top-4 p-1.5 rounded-md sharedTXTLightFaint sharedLightIconBtn transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="flex items-start gap-3 pr-6">
                            <div class="shrink-0 w-10 h-10 rounded-lg sharedStateLightAccent sharedStateTint flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 sharedStateText">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                </svg>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-lg font-semibold sharedTXTOnLight leading-tight">Add Student IDs</span>
                                <span class="text-xs sm:text-sm sharedTXTLightMuted">Enter one or multiple student IDs with course and year level.</span>
                            </div>
                        </div>

                        <p v-if="addError" class="sharedTXTDanger text-sm text-center m-0">{{ addError }}</p>

                        <!-- COURSE & YEAR LEVEL DROPDOWNS -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="flex flex-col gap-1.5">
                                <label for="add-course" class="text-sm font-medium sharedTXTOnLight">
                                    Course <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="add-course"
                                    v-model="newCourse"
                                    required
                                    class="w-full px-3 py-2 text-sm outline-none border sharedInput sharedInputHover rounded-xl transition-all duration-150 focus:ring-4 cursor-pointer"
                                >
                                    <option value="" disabled>— Select Course —</option>
                                    <option v-for="course in courseOptions" :key="course" :value="course">{{ course }}</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="add-year-level" class="text-sm font-medium sharedTXTOnLight">
                                    Year Level <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="add-year-level"
                                    v-model="newYearLevel"
                                    required
                                    class="w-full px-3 py-2 text-sm outline-none border sharedInput sharedInputHover rounded-xl transition-all duration-150 focus:ring-4 cursor-pointer"
                                >
                                    <option value="" disabled>— Select Year —</option>
                                    <option v-for="year in yearLevelOptions" :key="year" :value="year">{{ year }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center justify-between">
                                <label for="add-id-number" class="text-sm font-medium sharedTXTOnLight">Student ID Numbers <span class="text-red-500">*</span></label>
                                <span
                                    v-if="detectedIds.length > 0"
                                    class="text-xs px-2 py-0.5 rounded-full font-medium"
                                    :class="detectedIds.length > 1 ? 'sharedStateOpen sharedStateChip' : 'sharedTXTMuted'"
                                >
                                    {{ detectedIds.length }} {{ detectedIds.length === 1 ? 'ID detected' : 'IDs detected' }}
                                </span>
                            </div>

                            <textarea
                                id="add-id-number"
                                v-model="newIdNumber"
                                rows="5"
                                placeholder="e.g.&#10;2023-00001&#10;2023-00002&#10;2023-00003&#10;&#10;(Or separate IDs by commas)"
                                class="w-full px-3 py-2.5 text-sm font-mono outline-none border sharedInput sharedInputHover rounded-xl transition-all duration-150 focus:ring-4 resize-y"
                            ></textarea>

                            <span class="text-[11px] sm:text-xs sharedTXTLightFaint">
                                Enter one ID per line or separate them with commas. You can also paste directly from Excel or Google Sheets.
                            </span>
                        </div>

                        <div class="flex gap-3 mt-1">
                            <button type="button" @click="closeAdd"
                                class="w-1/3 py-2.5 rounded-lg text-sm font-medium sharedBtnGhostLight border transition-colors cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit"
                                :disabled="isAdding || detectedIds.length === 0 || !newCourse || !newYearLevel"
                                class="w-2/3 py-2.5 rounded-lg text-sm font-medium sharedBtn shadow-sm transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-1.5">
                                <svg v-if="isAdding" class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"/>
                                </svg>
                                {{ isAdding ? 'Adding...' : (detectedIds.length > 1 ? `Add ${detectedIds.length} Student IDs` : 'Add Student ID') }}
                            </button>
                        </div>
                    </form>
                </div>
            </Transition>
        </Teleport>

        <!-- DISABLE / ENABLE CONFIRMATION MODAL -->
        <Teleport to="body">
            <Transition name="modal-fade">
                <div
                    v-if="showDisableModal"
                    class="fixed inset-0 w-screen h-screen sharedOverlay backdrop-blur-sm z-[99] flex items-center justify-center p-4"
                    @click.self="closeDisable"
                >
                    <div class="modal-card relative w-full max-w-[420px] sharedLightBG rounded-2xl shadow-2xl sharedShadow ring-1 sharedNavRing flex flex-col p-6 gap-5">

                        <button type="button" @click="closeDisable" aria-label="Close"
                            class="absolute right-4 top-4 p-1.5 rounded-md sharedTXTLightFaint sharedLightIconBtn transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="flex items-start gap-3 pr-6">
                            <div
                                class="shrink-0 w-10 h-10 rounded-lg flex items-center justify-center"
                                :class="recordToToggle?.is_disabled ? 'sharedStateLightAccent sharedStateTint' : 'sharedStateLightDanger'"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-5"
                                    :class="recordToToggle?.is_disabled ? 'sharedStateText' : 'sharedTXTDanger'">
                                    <path
                                        v-if="recordToToggle?.is_disabled"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
                                    />
                                    <path
                                        v-else
                                        stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
                                    />
                                </svg>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-lg font-semibold sharedTXTOnLight leading-tight">
                                    {{ recordToToggle?.is_disabled ? 'Enable Student ID' : 'Disable Student ID' }}
                                </span>
                                <p class="text-sm sharedTXTLightMuted m-0">
                                    <template v-if="recordToToggle?.is_disabled">
                                        Re-enabling <span class="font-mono font-semibold sharedTXTOnLight">{{ recordToToggle?.id_number }}</span> will restore access for the student.
                                    </template>
                                    <template v-else>
                                        Disabling <span class="font-mono font-semibold sharedTXTOnLight">{{ recordToToggle?.id_number }}</span> will prevent this ID from being used to register or log in.
                                        <span v-if="recordToToggle?.user" class="block mt-1 text-amber-600 font-medium">
                                            The student account "{{ recordToToggle.user.name }}" will be disabled.
                                        </span>
                                    </template>
                                </p>
                            </div>
                        </div>

                        <p v-if="disableError" class="sharedTXTDanger text-sm text-center m-0">{{ disableError }}</p>

                        <div class="flex gap-3">
                            <button type="button" @click="closeDisable"
                                class="w-1/3 py-2.5 rounded-lg text-sm font-medium sharedBtnGhostLight border transition-colors cursor-pointer">
                                Cancel
                            </button>
                            <button
                                type="button"
                                @click="submitToggleDisable"
                                :disabled="isToggling"
                                class="w-2/3 py-2.5 rounded-lg text-sm font-medium shadow-sm transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-1.5"
                                :class="recordToToggle?.is_disabled ? 'sharedBtn' : 'sharedStateDanger sharedStateChip ring-1 sharedDangerSolidHover'"
                            >
                                <svg v-if="isToggling" class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"/>
                                </svg>
                                <span>{{ isToggling ? 'Processing...' : (recordToToggle?.is_disabled ? 'Enable ID' : 'Disable ID') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- DELETE CONFIRM MODAL -->
        <Teleport to="body">
            <Transition name="modal-fade">
                <div
                    v-if="showDeleteModal"
                    class="fixed inset-0 w-screen h-screen sharedOverlay backdrop-blur-sm z-[99] flex items-center justify-center p-4"
                    @click.self="closeDelete"
                >
                    <div class="modal-card relative w-full max-w-[420px] sharedLightBG rounded-2xl shadow-2xl sharedShadow ring-1 sharedNavRing flex flex-col p-6 gap-5">

                        <button type="button" @click="closeDelete" aria-label="Close"
                            class="absolute right-4 top-4 p-1.5 rounded-md sharedTXTLightFaint sharedLightIconBtn transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="flex items-start gap-3 pr-6">
                            <div class="shrink-0 w-10 h-10 rounded-lg sharedStateLightDanger flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 sharedTXTDanger">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-lg font-semibold sharedTXTOnLight leading-tight">Remove Student ID</span>
                                <p class="text-sm sharedTXTLightMuted m-0">
                                    Remove <span class="font-mono font-semibold sharedTXTOnLight">{{ recordToDelete?.id_number }}</span>?
                                </p>
                                <p class="text-xs text-red-600 font-semibold mt-1 m-0">
                                    Warning: Any user registered with this ID will also be permanently deleted from the system.
                                </p>
                            </div>
                        </div>

                        <p v-if="deleteError" class="sharedTXTDanger text-sm text-center m-0">{{ deleteError }}</p>

                        <div class="flex gap-3">
                            <button type="button" @click="closeDelete"
                                class="w-1/3 py-2.5 rounded-lg text-sm font-medium sharedBtnGhostLight border transition-colors cursor-pointer">
                                Cancel
                            </button>
                            <button type="button" @click="submitDelete"
                                :disabled="isDeleting"
                                class="w-2/3 py-2.5 rounded-lg text-sm font-medium sharedBtn shadow-sm transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-1.5"
                                style="background: rgb(220 38 38); color: white;">
                                <svg v-if="isDeleting" class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"/>
                                </svg>
                                {{ isDeleting ? 'Removing...' : 'Remove & Block' }}
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- TOAST NOTIFICATION -->
        <Toast
            :show="showToast"
            :message="toastMessage"
            :is-error="toastIsError"
            @close="showToast = false"
        />

    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import Toast from '../components/Toast.vue';

const props = defineProps({
    records: {
        type: Array,
        default: () => []
    },
    initialActivities: {
        type: Array,
        default: () => []
    },
    initialBlockedAttempts: {
        type: Number,
        default: 0
    },
    adminId: {
        type: [Number, String],
        required: true
    }
});

const viewedAttemptsStorageKey = `student-records:viewed-blocked-attempts:${props.adminId}`;

function loadViewedBlockedAttemptKeys() {
    if (typeof window === 'undefined') return new Set();

    try {
        const savedKeys = window.localStorage.getItem(viewedAttemptsStorageKey);
        const parsedKeys = savedKeys ? JSON.parse(savedKeys) : [];
        return new Set(Array.isArray(parsedKeys) ? parsedKeys.map(String) : []);
    } catch (error) {
        console.error('Unable to load viewed blocked-login alerts.', error);
        return new Set();
    }
}

// View states: 'records', 'dashboard', 'split'
const currentView = ref('records');

// Responsive table grid columns tailored for full view vs split view
const gridCols = computed(() => {
    if (currentView.value === 'split') {
        return 'grid-cols-[105px_minmax(80px,1fr)_minmax(110px,1.2fr)_85px_145px]';
    }
    return (
        'lg:grid-cols-[130px_minmax(100px,1fr)_minmax(130px,1.3fr)_95px_170px] ' +
        'xl:grid-cols-[150px_minmax(120px,1fr)_minmax(150px,1.3fr)_105px_180px]'
    );
});

const gridGap = computed(() => (currentView.value === 'split' ? 'gap-2 xl:gap-2.5' : 'gap-3'));

function handleWindowResize() {
    if (typeof window === 'undefined') return;
    if (window.innerWidth < 1280 && currentView.value === 'split') {
        currentView.value = 'records';
    }
}

onMounted(() => {
    window.addEventListener('resize', handleWindowResize);
    handleWindowResize();
});

onUnmounted(() => {
    window.removeEventListener('resize', handleWindowResize);
});

const statusTabs = ['All', 'Active', 'Unregistered', 'Disabled'];
const activeTab = ref('All');
const searchQuery = ref('');
const recordsList = ref([...props.records]);
const activitiesList = ref([...props.initialActivities]);
const viewedBlockedAttemptKeys = ref(loadViewedBlockedAttemptKeys());
const isRefreshingActivities = ref(false);

const activityFilter = ref('all');
const activitySearch = ref('');

// Computed Stats
const totalCount = computed(() => recordsList.value.length);
const activeCount = computed(() => recordsList.value.filter(r => !r.is_disabled && r.user).length);
const disabledCount = computed(() => recordsList.value.filter(r => r.is_disabled).length);
const blockedAttemptsCount = computed(() =>
    activitiesList.value.filter(a => a.action === 'attempted_login_disabled').length
);

const unreadBlockedAttemptsCount = computed(() =>
    activitiesList.value.filter(a =>
        a.action === 'attempted_login_disabled' &&
        !viewedBlockedAttemptKeys.value.has(activityKey(a))
    ).length
);

const latestBlockedAttempt = computed(() =>
    activitiesList.value.find(a => a.action === 'attempted_login_disabled') || null
);

function activityKey(activity) {
    return String(activity.id ?? `${activity.created_at}:${activity.action}`);
}

function markBlockedAttemptsViewed() {
    const viewedKeys = activitiesList.value
        .filter(activity => activity.action === 'attempted_login_disabled')
        .map(activityKey);
    viewedBlockedAttemptKeys.value = new Set(viewedKeys);

    try {
        window.localStorage.setItem(viewedAttemptsStorageKey, JSON.stringify(viewedKeys));
    } catch (error) {
        console.error('Unable to save viewed blocked-login alerts.', error);
    }
}

function setViewMode(view, tab = null, actFilter = null) {
    currentView.value = view;
    if (tab) activeTab.value = tab;
    if (actFilter) activityFilter.value = actFilter;
    if (view === 'dashboard' || view === 'split') markBlockedAttemptsViewed();
}

// Activity Filter Options
const activityFilterOptions = computed(() => [
    { label: 'All', value: 'all', count: activitiesList.value.length },
    {
        label: 'Blocked Logins',
        value: 'blocked',
        count: activitiesList.value.filter(a => a.action === 'attempted_login_disabled').length
    },
    {
        label: 'Added',
        value: 'added',
        count: activitiesList.value.filter(a => a.action === 'added_student_record' || a.action === 'added_student_records').length
    },
    {
        label: 'Disabled / Enabled',
        value: 'disabled_enabled',
        count: activitiesList.value.filter(a => a.action === 'disabled_student_record' || a.action === 'enabled_student_record').length
    },
    {
        label: 'Removed',
        value: 'deleted',
        count: activitiesList.value.filter(a => a.action === 'deleted_student_record').length
    },
]);

// Filtered activities list
const filteredActivities = computed(() => {
    const q = activitySearch.value.trim().toLowerCase();
    const flt = activityFilter.value;

    return activitiesList.value.filter(act => {
        // Tab filter
        if (flt === 'blocked' && act.action !== 'attempted_login_disabled') return false;
        if (flt === 'added' && act.action !== 'added_student_record' && act.action !== 'added_student_records') return false;
        if (flt === 'disabled_enabled' && act.action !== 'disabled_student_record' && act.action !== 'enabled_student_record') return false;
        if (flt === 'deleted' && act.action !== 'deleted_student_record') return false;

        // Search query
        if (!q) return true;
        const name = String(act.name ?? '').toLowerCase();
        const target = String(act.target ?? '').toLowerCase();
        const action = String(act.action ?? '').toLowerCase();

        return name.includes(q) || target.includes(q) || action.includes(q);
    });
});

async function refreshActivities() {
    if (isRefreshingActivities.value) return;
    isRefreshingActivities.value = true;
    try {
        const response = await fetch('/student-records/activities', {
            headers: { 'Accept': 'application/json' }
        });
        const data = await response.json();
        if (response.ok && data.success && Array.isArray(data.activities)) {
            activitiesList.value = data.activities;
            triggerToast('Activity feed refreshed.');
        }
    } catch {
        triggerToast('Failed to refresh activity feed.', true);
    } finally {
        isRefreshingActivities.value = false;
    }
}

// Activity SVG and styles
function activityIcon(action) {
    switch (action) {
        case 'attempted_login_disabled':
            return {
                badge: 'sharedStateDanger sharedStateTint sharedStateText',
                d: 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z'
            };
        case 'added_student_record':
        case 'added_student_records':
            return {
                badge: 'sharedStatePassed sharedStateTint sharedStateText',
                d: 'M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z'
            };
        case 'disabled_student_record':
            return {
                badge: 'sharedStateDanger sharedStateTint sharedStateText',
                d: 'M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z'
            };
        case 'enabled_student_record':
            return {
                badge: 'sharedStateOpen sharedStateTint sharedStateText',
                d: 'M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z'
            };
        case 'deleted_student_record':
            return {
                badge: 'sharedStateDanger sharedStateTint sharedStateText',
                d: 'm14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0'
            };
        default:
            return {
                badge: 'sharedTile sharedTXTMuted',
                d: 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'
            };
    }
}

function activityTitle(action) {
    switch (action) {
        case 'attempted_login_disabled': return 'Blocked Login Attempt';
        case 'added_student_record':
        case 'added_student_records': return 'ID Added';
        case 'disabled_student_record': return 'ID Disabled';
        case 'enabled_student_record': return 'ID Enabled';
        case 'deleted_student_record': return 'ID Removed';
        default: return 'Record Updated';
    }
}

function activityTag(action) {
    switch (action) {
        case 'attempted_login_disabled': return 'bg-red-500/20 text-red-500 border border-red-500/30';
        case 'added_student_record':
        case 'added_student_records': return 'sharedStatePassed sharedStateChip';
        case 'disabled_student_record': return 'sharedStateDanger sharedStateChip';
        case 'enabled_student_record': return 'sharedStateOpen sharedStateChip';
        case 'deleted_student_record': return 'sharedStateDanger sharedStateChip';
        default: return 'sharedTile sharedTXTMuted';
    }
}

function formatTimeAgo(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    const now = new Date();
    const diffSeconds = Math.max(0, Math.floor((now - date) / 1000));

    if (diffSeconds < 60) return 'Just now';
    const minutes = Math.floor(diffSeconds / 60);
    if (minutes < 60) return `${minutes}m ago`;
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours}h ago`;
    const days = Math.floor(hours / 24);
    if (days < 30) return `${days}d ago`;
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
}

// Toast
const showToast    = ref(false);
const toastMessage = ref('');
const toastIsError = ref(false);

function triggerToast(msg, isError = false) {
    toastMessage.value = msg;
    toastIsError.value = isError;
    showToast.value    = true;
}

// Add Modal
const showAddModal = ref(false);
const newIdNumber  = ref('');
const newCourse    = ref('');
const newYearLevel = ref('');
const addError     = ref('');
const isAdding     = ref(false);

const courseOptions = [
    'BSCS',
    'BSINTE',
    'BINDTECH',
    'COMTECH',
];

const yearLevelOptions = [
    '1st Year',
    '2nd Year',
    '3rd Year',
    '4th Year',
];

const detectedIds = computed(() => {
    const raw = newIdNumber.value;
    if (!raw) return [];
    return raw
        .split(/[\r\n,;]+/)
        .map(s => s.trim())
        .filter(Boolean);
});

function closeAdd() {
    showAddModal.value = false;
    newIdNumber.value  = '';
    newCourse.value    = '';
    newYearLevel.value = '';
    addError.value     = '';
}

async function submitAdd() {
    if (isAdding.value || detectedIds.value.length === 0) return;

    if (!newCourse.value || !newYearLevel.value) {
        addError.value = 'Please select both a course and a year level.';
        return;
    }

    addError.value = '';
    isAdding.value = true;

    try {
        const response = await fetch('/student-records', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                id_numbers: detectedIds.value,
                course:     newCourse.value,
                year_level: newYearLevel.value,
            }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
            if (Array.isArray(data.records) && data.records.length > 0) {
                recordsList.value.unshift(...data.records);
            } else if (data.record) {
                recordsList.value.unshift(data.record);
            }
            if (data.activity) {
                activitiesList.value.unshift(data.activity);
            }
            triggerToast(data.message || 'Student IDs added successfully.');
            closeAdd();
        } else if (data.errors) {
            addError.value = Object.values(data.errors).flat().join(' ');
        } else {
            addError.value = data.message || 'Failed to add records. Please try again.';
        }
    } catch {
        addError.value = 'Something went wrong. Please try again.';
    } finally {
        isAdding.value = false;
    }
}

// Disable / Enable
const showDisableModal = ref(false);
const recordToToggle   = ref(null);
const disableError     = ref('');
const isToggling       = ref(false);

function promptToggleDisable(record) {
    recordToToggle.value = record;
    disableError.value   = '';
    showDisableModal.value = true;
}

function closeDisable() {
    showDisableModal.value = false;
    recordToToggle.value   = null;
    disableError.value     = '';
}

async function submitToggleDisable() {
    if (isToggling.value || !recordToToggle.value) return;

    disableError.value = '';
    isToggling.value   = true;

    try {
        const response = await fetch('/student-records/toggle-disable', {
            method: 'PATCH',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ id: recordToToggle.value.id }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
            const index = recordsList.value.findIndex(r => r.id === recordToToggle.value.id);
            if (index !== -1) {
                recordsList.value[index].is_disabled = data.is_disabled;
                if (recordsList.value[index].user) {
                    recordsList.value[index].user.disabled = data.is_disabled;
                }
            }
            if (data.activity) {
                activitiesList.value.unshift(data.activity);
            }
            triggerToast(data.message);
            closeDisable();
        } else {
            disableError.value = data.message || 'Failed to update record status.';
        }
    } catch {
        disableError.value = 'Something went wrong. Please try again.';
    } finally {
        isToggling.value = false;
    }
}

// Delete
const showDeleteModal = ref(false);
const recordToDelete  = ref(null);
const deleteError     = ref('');
const isDeleting      = ref(false);

function confirmDelete(record) {
    recordToDelete.value = record;
    showDeleteModal.value = true;
    deleteError.value = '';
}

function closeDelete() {
    showDeleteModal.value = false;
    recordToDelete.value  = null;
    deleteError.value     = '';
}

async function submitDelete() {
    if (isDeleting.value || !recordToDelete.value) return;

    deleteError.value = '';
    isDeleting.value  = true;

    try {
        const response = await fetch('/student-records', {
            method: 'DELETE',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ id: recordToDelete.value.id }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
            recordsList.value = recordsList.value.filter(r => r.id !== recordToDelete.value.id);
            if (data.activity) {
                activitiesList.value.unshift(data.activity);
            }
            triggerToast(data.message);
            closeDelete();
        } else {
            deleteError.value = data.message || 'Failed to remove record. Please try again.';
        }
    } catch {
        deleteError.value = 'Something went wrong. Please try again.';
    } finally {
        isDeleting.value = false;
    }
}

// Filter Records
const filteredRecords = computed(() => {
    const q = searchQuery.value.trim().toLowerCase();

    return recordsList.value.filter(record => {
        const matchesTab =
            activeTab.value === 'All' ||
            (activeTab.value === 'Active' && !record.is_disabled && record.user) ||
            (activeTab.value === 'Unregistered' && !record.is_disabled && !record.user) ||
            (activeTab.value === 'Disabled' && Boolean(record.is_disabled));

        if (!matchesTab) return false;

        if (!q) return true;

        const idNum = String(record.id_number ?? '').toLowerCase();
        const userName = String(record.user?.name ?? '').toLowerCase();
        const userEmail = String(record.user?.email ?? '').toLowerCase();
        const course = String(record.course ?? '').toLowerCase();
        const yearLevel = String(record.year_level ?? '').toLowerCase();

        return idNum.includes(q) || userName.includes(q) || userEmail.includes(q) || course.includes(q) || yearLevel.includes(q);
    });
});
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active { transition: opacity 0.15s ease; }
.modal-fade-enter-from,
.modal-fade-leave-to { opacity: 0; }

.modal-card { animation: modal-pop-in 0.15s ease; }

@keyframes modal-pop-in {
    from { opacity: 0; transform: scale(0.96) translateY(4px); }
    to   { opacity: 1; transform: scale(1)    translateY(0);   }
}
</style>