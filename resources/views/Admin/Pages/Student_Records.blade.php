<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Records | Smart E-Learning</title>
    <link rel="shortcut icon" href="{{ asset('images/Components/Favicon.png') }}" type="image/x-icon">
    @include('Global.Pwa_Meta')
    @vite(['resources/css/app.css'])
</head>
<body class="h-dvh w-screen overflow-hidden">

    <div id="app" class="h-full">

        {{-- COMPUTER --}}
        <left-navigation
            active-page="Student Records"
            :id-number="{{auth()->user()->id_number}}"
            user-name="{{auth()->user()->name}}"
            user-email="{{auth()->user()->email}}"
            profile-color="{{auth()->user()->profile_color}}"
            logo="{{ asset('images/Components/Logo.png') }}"
        ></left-navigation>

        {{-- MOBILE --}}
        <bottom-navigation
            active-page="Student Records"
        ></bottom-navigation>

        <main class="h-full min-w-0 md:w-[calc(100%-280px)] w-full flex flex-col md:ml-[280px] ml-0 p-3 sm:p-5 overflow-y-auto max-md:[scrollbar-width:none] max-md:[&::-webkit-scrollbar]:hidden">

            {{-- HEADER --}}
            <admin-header
                class="mb-3 sm:mb-5"
                user-name="{{auth()->user()->name}}"
                user-email="{{auth()->user()->email}}"
                profile-color="{{auth()->user()->profile_color}}"
            ></admin-header>

            <student-records-page
                :records='@json($records)'
                :initial-activities='@json($activities)'
                :initial-blocked-attempts="{{ $blockedAttemptsCount }}"
                :admin-id="{{ auth()->id() }}"
            ></student-records-page>

            <div class="h-[calc(4rem+env(safe-area-inset-bottom))] shrink-0 md:hidden"></div>
        </main>

    </div>

    @vite(['resources/js/app.js'])

</body>
</html>
