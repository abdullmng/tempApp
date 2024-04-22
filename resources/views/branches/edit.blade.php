@extends('layouts.app')
@section('title', 'Edit Branch')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="text-center">
                        <h4>Edit Branch</h4>
                        <p class="lead">{{ $branch->name }}</p>
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
                                    <label for="name">Branch Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $branch->name }}">
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