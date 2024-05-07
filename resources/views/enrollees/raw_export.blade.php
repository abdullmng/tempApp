@extends('layouts.app')
@section('title', 'Enrollees Raw Export')
@section('content')
<!-- Heading -->
<div class="block block-rounded">
    <div class="block-content block-content-full">
        <div class="py-3 text-center">
        <h1 class="h3 fw-extrabold mb-1">
            @yield('title')
        </h1>
        <h2 class="fs-sm fw-medium text-muted mb-0">
            Export Raw Enrollment data in Excel format.
        </h2>
        </div>
    </div>
</div>
<!-- END Heading -->
<div class="row">
    <div class="col-lg-12">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <form action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="branch">Branch</label>
                                <select name="branch" id="branch" class="form-control form-select">
                                    <option value="">Select branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control form-select">
                                    <option value="">Choose Category</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sector">Sector</label>
                                <select name="sector" id="sector" class="form-control form-select">
                                    <option value="">Select sector</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="organisation">Organisation</label>
                                <select name="organisation" id="organisation" class="form-control form-select">
                                    <option value="">Select branch</option>
                                    @foreach ($organisations as $organisation)
                                        <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="hcp">HCP</label>
                                <select name="hcp" id="hcp" class="form-control form-select">
                                    <option value="">Choose HCP</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date_from">Date From</label>
                                <input type="date" name="date_from" id="date_from" class="form-control">
                                @if ($errors->has('date_from'))
                                    <span class="text-sm text-small text-danger">{{ $errors->first('date_from') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date_to">Date to</label>
                                <input type="date" name="date_to" id="date_to" class="form-control">
                                @if ($errors->has('date_to'))
                                    <span class="text-sm text-small text-danger">{{ $errors->first('date_to') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    Export to Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        function loadHcps()
        {
            $('#hcp').html(``);
            let organisation_id = $('#organisation').val()
            $.ajax({
                url: "/api/hcps/get/" + organisation_id,
                type: "GET",
                success: res => {
                    $('#hcp').html(`<option value="">Choose HCP</option>`)
                    res.forEach(hcp => {
                        $('#hcp').append(`<option value="${hcp.id}">${hcp.name}</option>`)
                    })
                }
            })
        }

        function LoadCategories()
        {
            $('#category').html(``);
            let branch_id = $('#branch').val()
            $.ajax({
                url: "/api/categories/get/" + branch_id,
                type: "GET",
                success: res => {
                    $('#category').html(`<option value="">Choose Category</option>`)
                    res.forEach(category => {
                        $('#category').append(`<option value="${category.id}">${category.name}</option>`)
                    })
                }
            })
        }

        $('#branch').on('change', function () {
            LoadCategories()
        })

        $('#organisation').on('change', function () {
            loadHcps()
        })
    </script>
@endsection