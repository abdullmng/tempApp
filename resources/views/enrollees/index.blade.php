@extends('layouts.app')
@section('title', 'Enrollees')
@section('content')
<!-- Heading -->
<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="py-3 text-center">
        <h1 class="h3 fw-extrabold mb-1">
            @yield('title')
        </h1>
        <h2 class="fs-sm fw-medium text-muted mb-0">
            Manage & Enroll clients.
        </h2>
        </div>
    </div>
</div>
<!-- END Heading -->
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
                <div class="mb-4">
                    <button id="btn-add" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enroll-modal">Add Enrollee +</button>
                </div>
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
                        <h4 class="block-title">Add Enrollee</h4>
                        <a href="#" data-bs-dismiss="modal" class="btn-close"></a>
                    </div>
                    <div class="block-content">
                        <form action="" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="branch">Branch <span class="text-danger">*</span></label>
                                        <select name="branch_id" id="branch" class="form-control form-select" required>
                                            <option value="">Choose branch</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sector">Sector <span class="text-danger">*</span></label>
                                        <select name="sector_id" id="sector" class="form-control form-select" required>
                                            <option value="">Choose sector</option>
                                            @foreach ($sectors as $sector)
                                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="organisation">Organisation <span class="text-danger">*</span></label>
                                <select name="organisation_id" id="organisation" class="form-control form-select" required>
                                    <option value="">Choose organisation</option>
                                    @foreach ($organisations as $organisation)
                                        <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pf_number">PF Number</label>
                                <input type="text" name="pf_number" id="pf_number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="gender">Gender <span class="text-danger">*</span></label>
                                <select name="gender" id="gender" class="form-control form-select" required>
                                    <option value="">Choose gender</option>
                                    @php
                                        $genders = ['male', 'female', 'others'];
                                    @endphp
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender }}">{{ ucfirst($gender) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                <input type="number" name="phone_number" id="phone_number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required>
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
            $('#enrollees-table_processing').hide()
        }, 3000);
    </script>
@endsection