@extends('layouts.app')
@section('title', 'Add Role')
@section('content')
    <!-- Heading -->
<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="py-3 text-center">
        <h1 class="h3 fw-extrabold mb-1">
            @yield('title')
        </h1>
        <h2 class="fs-sm fw-medium text-muted mb-0">
            Create & assign permissions to roles.
        </h2>
        </div>
    </div>
</div>
<!-- END Heading -->
<!-- END Heading -->
@if (session()->has('success'))
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
@foreach ($errors->all() as $error)
    <div
        class="alert alert-danger alert-dismissible fade show"
        role="alert"
    >
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    
        {{ $error }}
    </div>
    
@endforeach
<div class="row">
    <div class="col-lg-12">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <form action="" method="post">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit Role</button>
                    </div>
                    @csrf
                    <div class="mb-3">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    
                    <h4>
                        Permissions
                    </h4>
                    <div class="mb-3">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkAll" >
                                <label class="form-check-label" for="checkAll">Select All Permissions</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" id="permission{{ $permission->id }}" name="permissions[]">
                                        <label class="form-check-label" for="permission{{ $permission->id }}">{{ str_replace('_', ' ', $permission->name) }}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        // Get the "Check All" checkbox
        var checkAllCheckbox = document.getElementById('checkAll');

        // Get all other checkboxes
        var checkboxes = document.querySelectorAll('.form-check-input');

        // Attach click event listener to "Check All" checkbox
        checkAllCheckbox.addEventListener('click', function() {
            // Iterate through other checkboxes and set their checked state
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = checkAllCheckbox.checked;
            });
        });
    </script>
@endsection