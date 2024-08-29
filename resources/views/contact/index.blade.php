@extends('layouts.frontend')

@section('content-contact')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Parent Folders
                            <a href="{{ url('contact/create') }}" class="btn btn-primary float-end">Add Folders</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parentFolders as $folder)
                                    <tr>
                                        <td>{{ $folder->id }}</td>
                                        <td>{{ $folder->name }}</td>
                                        <td>
                                            <button id="toggle-button-{{ $folder->id }}" onclick="toggleChildFolders({{ $folder->id }})" class="btn btn-info">Show List</button>
                                            <div id="children-{{ $folder->id }}" style="display: none;">
                                                <!-- Child folders will be loaded here -->
                                            </div>
                                            <a href="{{route('contact.edit', $folder->id)}}" class="btn btn-success">Edit</a>
                                            <a href="{{route('contact.show', $folder->id)}}" class="btn btn-info">Open</a>

                                            <form action="{{route('contact.destroy',$folder->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        {{ $parentFolders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleChildFolders(parentId) {
            let button = $('#toggle-button-' + parentId);
            let childContainer = $('#children-' + parentId);

            if (childContainer.is(':visible')) {
                // Hide child folders
                childContainer.hide();
                button.text('Show Lists');
            } else {
                // Show child folders
                $.ajax({
                    url: '/contact/children/' + parentId,
                    method: 'GET',
                    success: function(data) {
                        childContainer.empty(); // Clear previous children

                        if (data.length > 0) {
                            let childList = '<ul>';
                            data.forEach(function(child) {
                                childList += '<li>' + child.name + '</li>';
                            });
                            childList += '</ul>';
                            childContainer.html(childList).show(); // Show the child folders
                        } else {
                            childContainer.html('<p>No child folders found.</p>').show();
                        }
                        button.text('Hide Lists'); // Change button text
                    },
                    error: function(error) {
                        console.error('Error fetching child folders:', error);
                    }
                });
            }
        }
    </script>

@endsection
