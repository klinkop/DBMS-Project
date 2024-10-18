<!-- resources/views/campaigns/index.blade.php -->
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="container">

        <!-- Display success message after deleting a campaign -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Campaigns Table -->
        <table class="table-striped table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Email Subject</th>
                    <th>Scheduled At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campaigns as $campaign)
                    <tr>
                        <td>{{ $campaign->id }}</td>
                        <td>{{ $campaign->name }}</td>
                        <td>{{ $campaign->description }}</td>
                        <td>{{ $campaign->email_subject }}</td>
                        <td>{{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'Not Scheduled' }}
                        </td>
                        <td>
                            <!-- View button -->
                            <a href="{{ route('campaigns.show', $campaign->id) }}" class="btn btn-info btn-sm">View</a>

                            <!-- Edit button -->
                            <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete form -->
                            <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this campaign?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination (if campaigns are paginated) -->
        <div class="d-flex justify-content-center">
            {{ $campaigns->links() }}
        </div>
    </div>
</x-app-layout>
