<!-- resources/views/campaigns/edit.blade.php -->
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Campaign') }}
        </h2>
    </x-slot>

<div class="container">

    <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Campaign Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $campaign->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $campaign->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="email_subject">Email Subject</label>
            <input type="text" name="email_subject" id="email_subject" class="form-control" value="{{ $campaign->email_subject }}" required>
        </div>

        <div class="form-group">
            <label for="email_body">Email Body</label>
            <textarea name="email_body" id="email_body" class="form-control" required>{{ $campaign->email_body }}</textarea>
        </div>

        <div class="form-group">
            <label for="scheduled_at">Scheduled At</label>
            <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control"
                   value="{{ optional($campaign->scheduled_at)->format('Y-m-d\TH:i') }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Campaign</button>
    </form>
</div>
</x-app-layout>
