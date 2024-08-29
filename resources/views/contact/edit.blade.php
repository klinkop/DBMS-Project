@extends('layouts.frontend')

@section('content-contact')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit contact
                            <a href="{{url('contact')}}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('contact.update', $contact->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $contact->name }}">
                                @error('name') <span class="text-danger">{{$message}}</span>  @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="">SC</label>
                                <textarea name="SC" rows="1" class="form-control">{!! $contact->SC !!}</textarea>
                                @error('SC') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">status</label>
                                <textarea name="status" rows="1" class="form-control">{!! $contact->status !!}</textarea>
                                @error('status') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Company</label>
                                <textarea name="company" rows="3" class="form-control">{!! $contact->company !!}</textarea>
                                @error('company') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">PIC</label>
                                <textarea name="pic" rows="1" class="form-control">{!! $contact->pic !!}</textarea>
                                @error('pic') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">email</label>
                                <textarea name="email" rows="1" class="form-control">{!! $contact->email !!}</textarea>
                                @error('email')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">contact1</label>
                                <textarea name="contact1" rows="1" class="form-control">{!! $contact->contact1 !!}</textarea>
                                @error('contact1')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">contact2</label>
                                <textarea name="contact2" rows="1" class="form-control">{!! $contact->contact2 !!}</textarea>
                                @error('contact2')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Industry</label>
                                <textarea name="industry" rows="1" class="form-control">{!! $contact->industry !!}</textarea>
                                @error('industry')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">City</label>
                                <textarea name="city" rows="1" class="form-control">{!! $contact->city !!}</textarea>
                                @error('city')<span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">State</label>
                                <textarea name="state" rows="1" class="form-control">{!! $contact->state !!}</textarea>
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

