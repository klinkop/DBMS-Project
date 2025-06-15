<x-layout>
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative min-height-vh-100 h-100 border-radius-lg" style="height: 100vh;">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">folder</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Parent Folders</p>
                                <h4 class="mb-0">{{ $parentFolderCount }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">

                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">folder_copy</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Sub Folder</p>
                                <h4 class="mb-0">{{ $subFolderCount }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">campaign</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Campaigns</p>
                                <h4 class="mb-0">{{ $campaignCount }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">contacts</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Contacts</p>
                                <h4 class="mb-0">{{ $contactCount }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    {{-- <canvas id="chart-bars" class="chart-canvas" height="170"></canvas> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">You last Campaign</h6>
                            @if ($latestCampaign)
                                <p class="text-sm">Last Campaign Sent: {{ $latestCampaign->name ?? 'N/A' }}</p>
                                <hr class="dark horizontal">
                                <div class="d-flex">
                                    <i class="material-icons text-sm my-auto me-1">schedule</i>
                                    <p class="mb-0 text-sm">{{ $message ?? 'No message available' }}</p>
                                </div>
                            @else
                                <p class="text-sm">No campaigns have been created yet.</p>
                            @endif

                                <!-- Additional Information -->

                                <div class="d-flex">
                                    <i class="material-icons text-sm my-auto me-1">folder</i>
                                    <p class="mb-0 text-sm">
                                        Contacts From:
                                        @if ($latestCampaign && $latestCampaign->recipients->isNotEmpty())
                                            {{ optional($latestCampaign->recipients->first()->subFolder)->name ?? 'No subfolder assigned' }}
                                        @else
                                            No campaign data available
                                        @endif
                                    </p>
                                </div>
                                <!-- Total Emails Sent -->
                                <div class="d-flex">
                                    <i class="material-icons text-sm my-auto me-1">email</i>
                                    <p class="mb-0 text-sm">Total Emails Sent: {{ $totalEmailsSent ?? '0'}}</p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="botdash"><x-footers.auth></x-footers.auth></div>

    </main>
    <x-plugins></x-plugins>

</x-layout>
