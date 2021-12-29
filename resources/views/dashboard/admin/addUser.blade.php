@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header text-center">
                    Add A user
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.addUser') }}" method="post">
                        @csrf

<div class="form-group row">
    <label for="name" class=" required col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name') }}" required autocomplete="name" autofocus>

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
                        <div class="mt-4 form-group row ">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address')
                                }}</label>
                            <div class="col-md-6">
                                <input type="email" name="email" id="email" placeholder="Your email"
                                    class="form-control @error('email') is-invalid  @enderror" value="{{ old('email') }}">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                       <div class="form-group">
                        <label for="cat_id">cat</label>
                        <select class="form-control" name="cat_id" required>
                            <option value="">Select a cat</option>

                            @foreach ($cats as $cat)
                            <option value="{{ $cat->id }}" {{ $cat->id === old('cat_id') ? 'selected' : '' }}>{{
                                $cat->name }}</option>
                            @if ($cat->children)
                            @foreach ($cat->children as $child)
                            <option value="{{ $child->id }}" {{ $child->id === old('cat_id') ? 'selected' : '' }}>&nbsp;&nbsp;{{
                                $child->name }}</option>
                            @endforeach
                            @endif
                            @endforeach
                        </select>
                    </div>

                      <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" name="password" id="password" placeholder="Choose a password"
                                    class="form-control @error('password') is-invalid @enderror" value="">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Confirm
                                Password
                            </label>
                            <div class="col-md-6">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="Repeat your password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                    value="">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        {{-- <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember" class="mr-2">
                                <label for="remember">Remember me</label>
                            </div>
                        </div> --}}

                      <div class="mt-4 form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Create User') }}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
