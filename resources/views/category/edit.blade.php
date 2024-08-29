@extends('layouts.frontend2')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Category
                            <a href="{{url('category')}}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('category.update', $category->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                                @error('name') <span class="text-danger">{{$message}}</span>  @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Description</label>
                                <textarea name="description" rows="3" class="form-control">{!! $category->description !!}</textarea>
                                @error('description') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Status</label>
                                <input type="checkbox" style="width:30px;height:30px;" {{ $category->status == 1 ? 'checked':'' }} name="status" checked > Checked=visible, unchecked=hidden
                                @error('status')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

