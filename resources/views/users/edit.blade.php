{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Add User</h3>
                        </div>
                        <!--begin::Form-->
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                @if(is_array(session('success')))
                                    <ul>
                                        @foreach (session('success') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ session('success') }}
                                @endif
                            </div>
                        @endif
                        @if ($errors->any())

                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form" method="post" action="{{route('users.update',$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group col">
                                    <label>Name</label>
                                    <input type="name" name="name" value="{{$data->name}}" class="form-control form-control-solid" placeholder="Example John" />
                                </div>
                                <div class="form-group col">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{$data->email}}" class="form-control form-control-solid" placeholder="Example email" readonly />
                                </div>
                                <div class="form-group col">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control form-control-solid" />
                                </div>
                                <div class="form-group col">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-solid" />
                                </div>
                                <div class="form-group col">
                                    <label>Phone</label>
                                    <input type="tel" name="phone" value="{{$data->phone}}" class="form-control form-control-solid" />
                                </div>
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control form-control-solid" name="gendr">
                                        <option value="Male" {{ ( $data->status == "Male") ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ ( $data->status == "Female") ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea">Textarea</label>
                                    <textarea class="form-control form-control-solid" name="address" rows="3">{{$data->address}}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection



{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}

    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

@endsection
