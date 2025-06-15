<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage='profile'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <x-navbars.navs.auth titlePage="Contact List"></x-navbars.navs.auth>

    <style>
        .round{
            border-radius: 1rem;
        }
    </style>

    <div class="">
        <div class="card overflow-hidden m-6 round">
            <div class="px-5 py-3 sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="px-5 py-3 sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="px-5 py-3 sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    <x-footers.auth></x-footers.auth>
    </main>
    <x-plugins></x-plugins>
</x-layout>

