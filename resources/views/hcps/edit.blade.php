@extends('layouts.app')
@section('title', 'Edit HCP')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="text-center">
                        <h4>@yield('title')</h4>
                        <p class="lead">{{ $hcp->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <form action="" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="organisation">Organisation</label>
                                    <select name="organisation_id" id="organisation" class="form-control form-select">
                                        <option value="">Select organisation</option>
                                        @foreach ($organisations as $organisation)
                                            <option value="{{ $organisation->id }}" {{ $hcp->organisation_id == $organisation->id ? 'selected' :'' }}>{{ $organisation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $hcp->name }}">
                                </div>
                                @if(session()->has('success'))
                                    <div
                                        class="alert alert-success alert-dismissible fade show"
                                        role="alert"
                                    >
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="alert"
                                            aria-label="Close"
                                        ></button>
                                    
                                        {{ session('success') }}
                                    </div>
                                    
                                @endif
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection