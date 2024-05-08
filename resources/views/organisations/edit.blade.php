@extends('layouts.app')
@section('title', 'Edit Organisation')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="text-center">
                        <h4>@yield('title')</h4>
                        <p class="lead">{{ $organisation->name }}</p>
                    </div>
                </div>
            </div>
        </div>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <form action="" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="hmo">HMO</label>
                                    <select name="hmo_id" id="hmo" class="form-control form-select">
                                        <option value="">Select HMO</option>
                                        @foreach ($hmos as $hmo)
                                            <option value="{{ $hmo->id }}" {{ $organisation->hmo_id == $hmo->id ? 'selected': '' }}>{{ ucfirst($hmo->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $organisation->name }}">
                                </div>
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