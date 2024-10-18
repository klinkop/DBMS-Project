<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Campaign') }}
        </h2>
    </x-slot>
        <div class="container">
            <h1>Create Email Campaign</h1>
            <form action="{{ route('campaigns.send') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Campaign Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="email_subject">Email Subject</label>
                    <input type="text" class="form-control" id="email_subject" name="email_subject" required>
                </div>
                <div class="form-group">
                    <label for="email_body">Email Body</label>
                    <textarea class="form-control" id="email_body" name="email_body" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="scheduled_at">Scheduled Time</label>
                    <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at">
                </div>
                <button type="submit" class="btn btn-primary">Send Campaign</button>
            </form>
        </div>
</x-app-layout>
