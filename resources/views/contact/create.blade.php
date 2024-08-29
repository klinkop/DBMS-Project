@extends('layouts.frontend')

@section('content-contact')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Contact List
                            <a href="{{url('contact')}}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('contact.store')}}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control">
                                @error('name') <span class="text-danger">{{$message}}</span>  @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="">SC</label>
                                <textarea name="SC" rows="1" class="form-control"></textarea>
                                @error('SC') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">status</label>
                                <textarea name="status" rows="1" class="form-control"></textarea>
                                @error('status') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Company</label>
                                <textarea name="description" rows="3" class="form-control"></textarea>
                                @error('description') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">PIC</label>
                                <textarea name="pic" rows="1" class="form-control"></textarea>
                                @error('pic') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">email</label>
                                <textarea name="email" rows="1" class="form-control"></textarea>
                                @error('email')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">contact1</label>
                                <textarea name="contact1" rows="1" class="form-control"></textarea>
                                @error('contact1')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">contact2</label>
                                <textarea name="contact2" rows="1" class="form-control"></textarea>
                                @error('contact2')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Industry</label>
                                <textarea name="industry" rows="1" class="form-control"></textarea>
                                @error('industry')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">City</label>
                                <textarea name="city" rows="1" class="form-control"></textarea>
                                @error('city')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">State</label>
                                <textarea name="state" rows="1" class="form-control"></textarea>
                                @error('city')<span class="text-danger">{{$message}}</span> @enderror
                            </div> --}}
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

