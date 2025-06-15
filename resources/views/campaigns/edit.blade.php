<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage='Campaign'></x-navbars.sidebar>

    <main class="main-content position-relative mix-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Campaign"></x-navbars.navs.auth>
        <!-- End Navbar -->

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

        <!-- Campaign edit form -->
        <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST" id="campaignForm"
            class="shadow-md rounded px-4 pt-6 pb-2 mb-4">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Campaign Name</label>
                    <input type="text" name="name"
                        class="form-control border border-2 p-2"
                        placeholder="Enter campaign name" value="{{ old('name', $campaign->name) }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea name="description"
                        class="form-control border border-2 p-2"
                        rows="3"
                        placeholder="Enter a brief description">{{ old('description', $campaign->description) }}</textarea>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="sender_name" class="form-label">Sender Name</label>
                    <input type="text" name="sender_name"
                        class="form-control border border-2 p-2"
                        placeholder="Enter Sender Name" value="{{ old('sender_name', $campaign->sender_name) }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email_subject" class="form-label">Email Subject</label>
                    <input type="text" name="email_subject"
                        class="form-control border border-2 p-2"
                        placeholder="Enter email subject" value="{{ old('email_subject', $campaign->email_subject) }}" required>
                </div>
            </div>
            <!-- Email builder -->
            <div class="mb-4">
                <label for="email_body" class="form-label">Email Body test</label>
                <div id="editor" class="border rounded shadow-md {{-- card card-body border --}}" style="height: 600px;"></div>
                <input type="hidden" name="email_body_json" id="email_body_json" value="{{ old('email_body_json', $campaign->email_body_json ?? '') }}">
                <input type="hidden" name="email_body_html" id="email_body_html" value="{{ old('email_body_html', $campaign->email_body_html ?? '') }}">
            </div>

            <!-- Hidden field to pass user ID -->
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="btn bg-gradient-dark">
                    Save Changes
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
            unlayer.init({
                id: 'editor',
                displayMode: 'email',
            });

            // Load the previous design
            var design = {!! $campaign->email_body_json !!}; // Ensure this outputs valid JSON
            unlayer.loadDesign(design);

            // Handle form submission
            document.getElementById('campaignForm').addEventListener('submit', function (e) {
                e.preventDefault();
                // Export the design data (both JSON and HTML)
                unlayer.exportHtml(function(data) {
                    var json = data.design;  // This is the JSON structure
                    var html = data.html;    // This is the rendered HTML content

                    // Store the JSON and HTML in the hidden fields
                    document.getElementById('email_body_json').value = JSON.stringify(json);  // Save the design JSON
                    document.getElementById('email_body_html').value = html;  // Save the rendered HTML content

                    // Now submit the form
                    e.target.submit();
                });
            });
        });
    </script>
</x-app-layout>
