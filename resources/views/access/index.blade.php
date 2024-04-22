@extends('layouts.app')
@section('title', 'Roles')
@section('content')
<!-- Heading -->
<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="py-3 text-center">
        <h1 class="h3 fw-extrabold mb-1">
            @yield('title')
        </h1>
        <h2 class="fs-sm fw-medium text-muted mb-0">
            Manage Roles.
        </h2>
        </div>
    </div>
</div>
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
    <div class="col-md-12">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                @can(('can_create_roles'))
                <div class="mb-4">
                    <a href="{{ route('access.create_roles') }}"  class="btn btn-primary" >Add Role +</a>
                </div>
                @endif
                <div class="table-responsive">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
@section('js')
    <script>
        setTimeout(() => {
            $('#roles-table_processing').hide()
        }, 3000);
    </script>
@endsection