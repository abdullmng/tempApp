@extends('layouts.app')
@section('title', 'Enrollee')
@section('style')
    <style>
        .camera {
            width: 320px;
            height: 240px;
            border: 1px solid black;
        }
        .camera-container {
            display: flex;
            flex-direction: row;
        }
    </style>
@endsection
@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
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
        @foreach ($errors->all() as $err)
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
        
            {{ $err }}
        </div>
        @endforeach
        <div class="row">
            <div class="col-lg-12">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <h3 class="block-title mb-4">Enrollee Personal Data</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reference">Reference</label>
                                    <input type="text" id="reference" class="form-control form-control-alt" value="{{ $enrollee->reference }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="pf_number">Pf Number</label>
                                    <input type="text" name="pf_number" id="pf_number" value="{{ $enrollee->pf_number }}" class="form-control" placeholder="Enter personal file number">
                                </div>
                                <div class="mb-3">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" value="{{ $enrollee->first_name }}" class="form-control" required>
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" name="middle_name" id="middle_name" value="{{ $enrollee->middle_name }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name" value="{{ $enrollee->last_name }}" class="form-control" required>
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ $enrollee->date_of_birth }}" class="form-control" required>
                                    @if ($errors->has('date_of_birth'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('date_of_birth') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="address">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" id="address" class="form-control" required>{{ $enrollee->address }}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="nin">NIN</label>
                                    <input type="text" name="nin" id="nin" value="{{ $enrollee->nin }}" class="form-control" placeholder="Enter your national identification number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">ID Print Count: <span>{{ number_format($enrollee->id_print_count) }}</span></label>
                                </div>
                                <div class="mb-3">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" class="form-control form-select" required>
                                        <option value="">Choose gender</option>
                                        @php
                                            $genders = ['male', 'female', 'others'];
                                        @endphp
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender }}" {{ $enrollee->gender == $gender ? 'selected': '' }}>{{ ucfirst($gender) }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('gender') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="marital_status">Marital Status <span class="text-danger">*</span></label>
                                    <select name="marital_status" id="marital_status" class="form-control form-select" required>
                                        <option value="">Choose marital status</option>
                                        @php
                                            $genders = ['single', 'engaged', 'married', 'co-habitating', 'divorced', 'widowed'];
                                        @endphp
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender }}" {{ $enrollee->marital_status == $gender ? 'selected': '' }}>{{ ucfirst($gender) }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('marital_status'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('marital_status') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $enrollee->email }}" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                    <input type="number" name="phone_number" id="phone_number" class="form-control" value="{{ $enrollee->phone_number }}" required>
                                    @if ($errors->has('phone_number'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('phone_number') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="branch_id">Branch <span class="text-danger">*</span></label>
                                    <select name="branch_id" id="branch_id" class="form-control form-select" required>
                                        <option value="">Choose Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ $enrollee->branch_id == $branch->id ? 'selected': '' }}>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('branch_id') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category_id" id="category" class="form-control form-select">
                                        <option value="">Choose Category</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div>
                                        <img src="{{ $enrollee->picture }}" alt="picture" class="img-fluid w-25">
                                    </div>
                                    <label for="picture">Picture </label>
                                    <div class="mb-3 mt-3">
                                        <a href="javascript:void" class="btn btn-primary btn-sm" onclick="showCapture()">Capture</a>
                                        <a href="javascript:void" class="btn btn-success btn-sm" onclick="showUpload()">Upload</a>
                                    </div>
                                    <div class="picture_area">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <h3 class="mb-4 block-title">Enrollee HCPs</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb">
                                    <label for="organisation_id">Organisation <span class="text-danger">*</span></label>
                                    <select name="organisation_id" id="organisation_id" class="form-control form-select" required>
                                        <option value="">Choose Organisation </option>
                                        @foreach ($organisations as $organisation)
                                            <option value="{{ $organisation->id }}" {{ $enrollee->organisation_id == $organisation->id ? 'selected': '' }}>{{ $organisation->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('organisation_id'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('organisation_id') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="hcp_id">Primary HCP <span class="text-danger">*</span></label>
                                    <select name="hcp_id" id="hcp" class="form-control form-select" required>
                                        <option value="">Choose HCP</option>
                                    </select>
                                    @if ($errors->has('hcp_id'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('hcp_id') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="blood_group">Blood Group <span class="text-danger">*</span></label>
                                    <select name="blood_group_id" id="blood_group" class="form-control form-select" required>
                                        <option value="">Choose Blood Group</option>
                                        @foreach ($blood_groups as $blood_group)
                                            <option value="{{ $blood_group->id }}" {{ $enrollee->blood_group_id == $blood_group->id ? 'selected' : '' }}>{{ $blood_group->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('blood_group_id'))
                                        <span class="text-danger text-sm text-small">{{ $errors->first('blood_group_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="illness">Illness</label>
                                    <textarea name="illness" id="illness" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <h3 class="block-title mb-4">Enrollee Employment</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organisation">Organisation</label>
                                    <input type="text" name="organisation" id="organisation" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="date_of_first_appointment">Date of First Appointment</label>
                                    <input type="date" name="date_of_first_appointment" id="date_of_first_appointment" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="occupation">Occupation</label>
                                    <input type="text" name="occupation" id="occupation" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="designation">Designation</label>
                                    <input type="text" name="designation" id="designation" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="station">Station</label>
                                    <input type="text" name="station" id="station" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="hmo">HMO</label>
                                    <input type="text" name="hmo" id="hmo" class="form-control form-control-alt" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mb-4">
            <button type="submit" class="btn btn-primary">Update Enrollee Details</button>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <p>Last Updated By: {{ $enrollee->updated_by_username }}</p>
                        <p>Last Updated At: {{ $enrollee->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
<script>
    function showCapture()
    {
        $('.picture_area').html(`<div class="capture">
                                        <input type="hidden" name="picture_bin" id="picture_bin">
                                        <div class="camera-container">
                                            <div class="camera">

                                            </div>
                                            <div class="result">
    
                                            </div>
                                        </div>
                                        <div>
                                            <a href="javascript:void" class="btn btn-primary" onclick="initiateCamera()">Start Camera</a>
                                            <a href="javascript:void" style="display: none" class="btn btn-danger stop-cam" onclick="stopCamera()">Stop Camera</a>
                                            <a href="javascript:void" class="btn btn-warning snap" onclick="takeSnapShot()">Snap photo</a>
                                        </div>
                                    </div>`)
    }
    function showUpload()
    {
        $('.picture_area').html(`<div class="upload">
                                        <input type="file" name="picture" id="picture" class="form-control" capture>
                                    </div>`)
    }
    function initiateCamera()
    {
        Webcam.set({
            width: 320,
            height: 240,
            crop_width: 240,
            crop_height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90,
            constraints: {
                facingMode: "environment"
            }
        });
        Webcam.attach( '.camera' );
        $('.stop-cam').show();
    }

    function stopCamera() 
    {
        Webcam.reset()
        $('.stop-cam').hide()
    }

    function takeSnapShot()
    {
        Webcam.snap( function(data_uri) {
            // display results in page
            $('.result').html(`<img src="${data_uri}" class="img-fluid" alt="img">`)
            $('#picture_bin').val(data_uri)
            /*document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';*/
        });
    }
    function loadHcps()
    {
        $('#hcp').html(``);
        let organisation_id = $('#organisation_id').val()
        let hcp_id = "{{ $enrollee->hcp_id }}";
        $.ajax({
            url: "/api/hcps/get/" + organisation_id,
            type: "GET",
            success: res => {
                $('#hcp').html(`<option value="">Choose HCP</option>`)
                res.forEach(hcp => {
                    $('#hcp').append(`<option value="${hcp.id}" ${hcp_id == hcp.id ? 'selected' : ''}>${hcp.name}</option>`)
                })
            }
        })
    }

    function LoadCategories()
    {
        $('#category').html(``);
        let branch_id = $('#branch_id').val()
        let category_id = "{{ $enrollee->category_id }}";
        $.ajax({
            url: "/api/categories/get/" + branch_id,
            type: "GET",
            success: res => {
                $('#category').html(`<option value="">Choose Category</option>`)
                res.forEach(category => {
                    $('#category').append(`<option value="${category.id}" ${category_id == category.id ? 'selected' : ''}>${category.name}</option>`)
                })
            }
        })
    }

    LoadCategories()
    loadHcps()

    $('#branch_id').on('change', function () {
        LoadCategories()
    })

    $('#organisation_id').on('change', function () {
        loadHcps()
    })
</script>
@endsection