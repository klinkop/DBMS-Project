<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Campaign') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Create New Campaign</h2>

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
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Campaign Name</label>
                <input type="text" name="name"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Enter campaign name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description
                    (Optional)</label>
                <textarea name="description"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    rows="3" placeholder="Enter a brief description">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="sender_name" class="block text-gray-700 text-sm font-bold mb-2">Sender Name</label>
                <input type="text" name="sender_name"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Enter Sender Name" value="{{ old('sender_name') }}" required>
            </div>

            <div class="mb-4">
                <label for="email_subject" class="block text-gray-700 text-sm font-bold mb-2">Email Subject</label>
                <input type="text" name="email_subject"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Enter email subject" value="{{ old('email_subject') }}" required>
            </div>

            <!-- Email builder -->
            <div class="mb-4">
                <label for="email_body" class="block text-gray-700 text-sm font-bold mb-2">Email Body</label>
                <div id="editor" class="border rounded shadow-md" style="height: 600px;"></div>
                <!-- Hidden fields to store the design JSON and HTML -->
                {{-- img --}}
                <textarea name="email_body_json" id="email_body_json" class="hidden">{{ old('email_body_json') }}</textarea>
                <textarea name="email_body_html" id="email_body_html" class="hidden">{{ old('email_body_html') }}</textarea>
            </div>

            <!-- Hidden field to pass user ID -->
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Campaign
                </button>
            </div>
        </form>
    </div>

    <!-- Include Unlayer -->
    <script src="https://editor.unlayer.com/embed.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Unlayer editor
            unlayer.init({
                id: 'editor',
                displayMode: 'email',
                onLoad: function() {
                    console.log("Unlayer Editor initialized successfully.");
                }
            });

            // Handle form submission
            document.getElementById('campaignForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Export the design
                unlayer.exportHtml(function(data) {
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
</x-app-layout>
