<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="container">
        <h1>Campaign Details</h1>

        <div class="card mb-3">
            <div class="card-header">
                <h3>{{ $campaign->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> {{ $campaign->description }}</p>
                <p><strong>Email Subject:</strong> {{ $campaign->email_subject }}</p>
                <p><strong>Email Body:</strong></p>
                <div class="email-body">
                    {!! $campaign->email_body !!}
                </div>
                <p><strong>Scheduled At:</strong>
                    {{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'Not Scheduled' }}
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="actions">
            <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-warning">Edit Campaign</a>

            <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this campaign?')">Delete Campaign</button>
            </form>

            <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">Back to List</a>

            <!-- Send Campaign to Test Email Button -->
            <form action="{{ route('campaigns.send', $campaign->id) }}" method="POST" style="display:inline-block;">
                @csrf
                <input type="email" name="test_email" value="test@example.com" class="form-control d-inline" placeholder="Enter Test Email" style="width: 250px;">
                <button type="submit" class="btn btn-success">Send to Test Email</button>
            </form>

            <!-- Send Campaign to All Recipients Button -->
            <form action="{{ route('campaigns.sendAll', $campaign->id) }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-primary">Send to All Recipients</button>
            </form>
        </div>
    </div>

    <!-- Add Recipients Section -->
    <div class="mt-4">
        <h3>Add Recipient to Campaign</h3>
        <form action="{{ route('campaigns.addRecipient', $campaign->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Recipient Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter recipient name" required>
            </div>
            <div class="form-group">
                <label for="email">Recipient Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter recipient email" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Recipient</button>
        </form>

        <h4>Current Recipients</h4>
        @if ($campaign->recipients && $campaign->recipients->isEmpty())
            <p>No recipients added yet.</p>
        @elseif ($campaign->recipients)
            <ul>
                @foreach ($campaign->recipients as $recipient)
                    <li>
                        {{ $recipient->name ?? 'Unnamed Recipient' }} ({{ $recipient->email ?? 'No Email' }})
                    </li>
                @endforeach
            </ul>
        @else
            <p>No recipient information available.</p>
        @endif

    </div>

</x-app-layout>



