@extends('layouts.app')
@section('title', 'Sectors')
@section('content')
<!-- Heading -->
<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="py-3 text-center">
        <h1 class="h3 fw-extrabold mb-1">
            @yield('title')
        </h1>
        <h2 class="fs-sm fw-medium text-muted mb-0">
            Manage Sectors.
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
                @can(('can_create_sectors'))
                <div class="mb-4">
                    <button id="btn-add" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enroll-modal">Add Sector +</button>
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

@section('modals')
    <div class="modal fade" id="enroll-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h4 class="block-title">Add Sector</h4>
                        <a href="#" data-bs-dismiss="modal" class="btn-close"></a>
                    </div>
                    <div class="block-content">
                        <form action="" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Proceed</button>
                            </div>
                        </form>
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
            $('#sectors-table_processing').hide()
        }, 3000);
    </script>
@endsection