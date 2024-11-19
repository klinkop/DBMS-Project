<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Template') }}
        </h2>
    </x-slot>
<div class="container">
    <h1>Create Email Template</h1>
    <form action="{{ route('email_templates.store') }}" method="POST" id="emailForm">
        @csrf
        <div class="form-group">
            <label for="title">Template Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div id="editor" style="height: 600px; border: 1px solid #ccc;"></div>
        <textarea name="content" id="content" class="d-none"></textarea>
        <button type="submit" class="btn btn-primary mt-3">Save Template</button>
    </form>
</div>

<!-- Include Unlayer -->
<script src="https://editor.unlayer.com/embed.js"></script>
<script>
    unlayer.init({
        id: 'editor',
        projectId: 1234, // Replace with your Unlayer project ID if applicable
        displayMode: 'email',
        features: {
            customJS: []
        }
    });

    // Handle form submission
    document.getElementById('emailForm').addEventListener('submit', function (e) {
        e.preventDefault();
        unlayer.exportHtml(function (data) {
            document.getElementById('content').value = data.html;
            e.target.submit();
        });
    });
</script>

</x-app-layout>
