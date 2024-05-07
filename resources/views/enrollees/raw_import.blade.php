@extends('layouts.app')
@section('title', 'Enrollees Raw Import')
@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="text-center">
                        <h4>@yield('title')</h4>
                        <p class="lead">Import raw enrollee data as exported from the system</p>
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
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file">File</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Import</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection