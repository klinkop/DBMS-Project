<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='createCamapaign'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create Campaign"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <!-- Back Button -->
        <button type="button" onclick="history.back()"
            class="btn bg-gradient-dark">
            Back
        </button>
    <div class="card card-body container mx-auto py-2">

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Campaign creation form -->
        <form action="{{ route('campaigns.store') }}" method="POST" id="campaignForm"
            class="shadow-md rounded px-4 pt-6 pb-8 mb-4">
            @csrf

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Campaign Name</label>
                    <input type="text" name="name"
                        class="form-control border border-2 p-2"
                        placeholder="Enter campaign name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea name="description"
                        class="form-control border border-2 p-2"
                        rows="3" placeholder="Enter a brief description">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="sender_name" class="form-label">Sender Name</label>
                    <input type="text" name="sender_name"
                        class="form-control border border-2 p-2"
                        placeholder="Enter Sender Name" value="{{ old('sender_name') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email_subject" class="form-label">Email Subject</label>
                    <input type="text" name="email_subject"
                        class="form-control border border-2 p-2"
                        placeholder="Enter email subject" value="{{ old('email_subject') }}" required>
                </div>
            </div>
            <!-- Email builder -->
            <div class="mb-4">
                <label for="email_body" class="form-label">Email Body</label>
                <div id="editor" class="border rounded shadow-md" style="height: 600px;"></div>
                <!-- Hidden fields to store the design JSON and HTML -->
                <textarea name="email_body_json" id="email_body_json" class="hidden" style="display: none">{{ old('email_body_json') }}</textarea>
                <textarea name="email_body_html" id="email_body_html" class="hidden" style="display: none">{{ old('email_body_html') }}</textarea>
            </div>

            <!-- Hidden field to pass user ID -->
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="btn bg-gradient-dark">
                    Create Campaign
                </button>
            </div>
        </form>
    </div>
    <x-footers.auth></x-footers.auth>
    </main>
    <x-plugins></x-plugins>
    </div>
    <!-- Include Unlayer -->
    <script src="https://editor.unlayer.com/embed.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize Unlayer editor
            unlayer.init({
                id: 'editor',
                displayMode: 'email',
                onLoad: function () {
                    console.log("Unlayer Editor initialized successfully.");
                }
            });

            // Handle form submission
            document.getElementById('campaignForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                // Export the design
                unlayer.exportHtml(function (data) {
                    const json = data.design; // JSON structure of the design
                    const html = data.html; // Final HTML output

                    console.log("Exported Design JSON:", json);
                    console.log("Exported Design HTML:", html);

                    // Save JSON and HTML into hidden fields
                    document.getElementById('email_body_json').value = JSON.stringify(json);
                    document.getElementById('email_body_html').value = html;

                    // Submit the form
                    e.target.submit();
                });
            });
        });
    </script>
</x-layout>
