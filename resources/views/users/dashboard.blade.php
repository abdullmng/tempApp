@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <!-- Row #1 -->
    @can('can_view_enrollees')
    <div class="col-6 col-xl-3">
      <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
        <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
          <div class="d-none d-sm-block">
            <i class="fa fa-users fa-2x opacity-25"></i>
          </div>
          <div>
            <div class="fs-3 fw-semibold">{{ $data['total_enrollees'] }}</div>
            <div class="fs-sm fw-semibold text-uppercase text-muted">Total Enrollees</div>
          </div>
        </div>
      </a>
    </div>

    @can('can_view_branches')
    @foreach ($data['branches'] as $branch)
    <div class="col-6 col-xl-3">
      <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
        <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
          <div class="d-none d-sm-block">
            <i class="fa fa-users fa-2x opacity-25"></i>
          </div>
          <div>
            <div class="fs-3 fw-semibold">{{ $branch->enrollees->count() }}</div>
            <div class="fs-sm fw-semibold text-uppercase text-muted">{{ $branch->name }} Enrollees</div>
          </div>
        </div>
      </a>
    </div>
    @endforeach
    @endcan
    @can('can_view_sectors')
    @foreach ($data['sectors'] as $sector)
    <div class="col-6 col-xl-3">
      <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
        <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
          <div class="d-none d-sm-block">
            <i class="fa fa-users fa-2x opacity-25"></i>
          </div>
          <div>
            <div class="fs-3 fw-semibold">{{ $sector->enrollees->count() }}</div>
            <div class="fs-sm fw-semibold text-uppercase text-muted">{{ $sector->name }} Sector</div>
          </div>
        </div>
      </a>
    </div>
    @endforeach
    @endcan
    @endcan
    @can('can_view_users')
    <div class="col-6 col-xl-3">
      <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
        <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
          <div class="d-none d-sm-block">
            <i class="fa fa-user fa-2x opacity-25"></i>
          </div>
          <div>
            <div class="fs-3 fw-semibold">{{ $data['users'] }}</div>
            <div class="fs-sm fw-semibold text-uppercase text-muted">Total Users</div>
          </div>
        </div>
      </a>
    </div>
    @endcan
    <!-- END Row #1 -->
  </div>
  @can('can_view_enrollees')
  <div class="row">
    <!-- Row #2 -->
    <div class="col-md-6">
      <div class="block block-rounded">
        <div class="block-header">
          <h3 class="block-title">
            Enrollees <small>Over the Last 7days</small>
          </h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo" onclick="loadData()">
              <i class="si si-refresh"></i>
            </button>
          </div>
        </div>
        <div class="block-content block-content-full p-1 bg-body-light">
          <!-- Chart.js Chart is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _js/pages/be_pages_dashboard.js -->
          <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
          <canvas id="enrolleesChart" style=""></canvas>
        </div>

      </div>
    </div>
    <div class="col-md-6">
      <div class="block block-rounded">
        <div class="block-header">
          <h3 class="block-title">
            Enrollees <small>Over the Last 7days</small>
          </h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo" onclick="loadData()">
              <i class="si si-refresh"></i>
            </button>
          </div>
        </div>
        <div class="block-content block-content-full p-1 bg-body-light">
          <!-- Chart.js Chart is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _js/pages/be_pages_dashboard.js -->
          <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
          <canvas id="enrolleesBarChart" style=""></canvas>
        </div>

      </div>
    </div>
    <!-- END Row #2 -->
  </div>
  @endcan
  {{--
  <div class="row">
    <!-- Row #3 -->
    <div class="col-md-4">
      <div class="block block-rounded">
        <div class="block-content block-content-full">
          <div class="py-3 text-center">
            <div class="mb-3">
              <i class="fa fa-envelope-open fa-4x opacity-25"></i>
            </div>
            <div class="fs-4 fw-semibold">9.25k Subscribers</div>
            <div class="text-muted">Your main list is growing!</div>
            <div class="pt-3">
              <a class="btn btn-primary" href="javascript:void(0)">
                <i class="fa fa-cog opacity-50 me-1"></i> Manage list
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="block block-rounded">
        <div class="block-content block-content-full">
          <div class="py-3 text-center">
            <div class="mb-3">
              <i class="fa fab fa-twitter fa-4x opacity-25"></i>
            </div>
            <div class="fs-4 fw-semibold">+36 followers</div>
            <div class="text-muted">You are doing great!</div>
            <div class="pt-3">
              <a class="btn btn-primary" href="javascript:void(0)">
                <i class="fa fa-users opacity-50 me-1"></i> Check them out
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="block block-rounded">
        <div class="block-content block-content-full">
          <div class="py-3 text-center">
            <div class="mb-3">
              <i class="fa fa-check fa-4x opacity-25"></i>
            </div>
            <div class="fs-4 fw-semibold">Business Plan</div>
            <div class="text-muted">This is your current active plan</div>
            <div class="pt-3">
              <a class="btn btn-primary" href="javascript:void(0)">
                <i class="fa fa-arrow-up opacity-50 me-1"></i> Upgrade to VIP
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END Row #3 -->
  </div>
  <div class="row">
    <!-- Row #4 -->
    <div class="col-md-6">
      <a class="block block-rounded block-link-shadow overflow-hidden" href="javascript:void(0)">
        <div class="block-content block-content-full">
          <i class="si si-briefcase fa-2x opacity-25"></i>
          <div class="row g-5 py-3">
            <div class="col-6 text-end border-end">
              <div>
                <div class="fs-3 fw-semibold">16</div>
                <div class="fs-sm fw-semibold text-uppercase text-muted">Projects</div>
              </div>
            </div>
            <div class="col-6">
              <div>
                <div class="fs-3 fw-semibold">2</div>
                <div class="fs-sm fw-semibold text-uppercase text-muted">Active</div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6">
      <a class="block block-rounded block-link-shadow overflow-hidden" href="javascript:void(0)">
        <div class="block-content block-content-full">
          <div class="text-end">
            <i class="si si-users fa-2x opacity-25"></i>
          </div>
          <div class="row g-5 py-3">
            <div class="col-6 text-end border-end">
              <div>
                <div class="fs-3 fw-semibold text-info">63250</div>
                <div class="fs-sm fw-semibold text-uppercase text-muted">Accounts</div>
              </div>
            </div>
            <div class="col-6">
              <div>
                <div class="fs-3 fw-semibold text-success">97%</div>
                <div class="fs-sm fw-semibold text-uppercase text-muted">Active</div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <!-- END Row #4 -->
  </div>
  <div class="row">
    <!-- Row #5 -->
    <div class="col-6 col-md-4 col-xl-2">
      <a class="block block-rounded block-link-shadow text-center" href="be_pages_generic_inbox.html">
        <div class="block-content ribbon ribbon-bookmark ribbon-primary ribbon-left">
          <div class="ribbon-box">15</div>
          <p class="my-3">
            <i class="si si-envelope-letter fa-2x"></i>
          </p>
          <p class="fw-semibold">Inbox</p>
        </div>
      </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <a class="block block-rounded block-link-shadow text-center" href="be_pages_generic_profile.html">
        <div class="block-content">
          <p class="my-3">
            <i class="si si-user fa-2x"></i>
          </p>
          <p class="fw-semibold">Profile</p>
        </div>
      </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <a class="block block-rounded block-link-shadow text-center" href="be_pages_forum_categories.html">
        <div class="block-content ribbon ribbon-bookmark ribbon-primary ribbon-left">
          <div class="ribbon-box">3</div>
          <p class="my-3">
            <i class="si si-bubbles fa-2x"></i>
          </p>
          <p class="fw-semibold">Forum</p>
        </div>
      </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <a class="block block-rounded block-link-shadow text-center" href="be_pages_generic_search.html">
        <div class="block-content">
          <p class="my-3">
            <i class="si si-magnifier fa-2x"></i>
          </p>
          <p class="fw-semibold">Search</p>
        </div>
      </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <a class="block block-rounded block-link-shadow text-center" href="be_comp_charts.html">
        <div class="block-content">
          <p class="my-3">
            <i class="si si-bar-chart fa-2x"></i>
          </p>
          <p class="fw-semibold">Live Stats</p>
        </div>
      </a>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
        <div class="block-content">
          <p class="my-3">
            <i class="si si-settings fa-2x"></i>
          </p>
          <p class="fw-semibold">Settings</p>
        </div>
      </a>
    </div>
    <!-- END Row #5 -->
  </div>--}}
@endsection
@can('can_view_enrollees')
@section('js')
  <script>
    function loadData() 
    {
      $.ajax({
          url: '{{ route("enrollment_data") }}',
          type: 'GET',
          success: function(response) {
              //console.log(response.enrollmentCounts)
              var ctxbar = document.getElementById('enrolleesBarChart');
              var myBarChart = new Chart(ctxbar, {
                  type: 'bar',
                  data: {
                      labels: response.dates,
                      datasets: [{
                          label: 'Enrollees',
                          data: response.enrollmentCounts,
                          backgroundColor: 'rgba(75, 192, 192, 0.2)',
                          borderColor: 'rgba(75, 192, 192, 1)',
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                  }
              });
              var ctx = document.getElementById('enrolleesChart');
              var myChart = new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: response.dates,
                      datasets: [{
                          label: 'Enrollees',
                          data: response.enrollmentCounts,
                          backgroundColor: 'rgba(75, 192, 192, 0.2)',
                          borderColor: 'rgba(75, 192, 192, 1)',
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          y: {
                            beginAtZero: true
                          }
                      }
                  }
              });
          }
      })
    }
    loadData()
  </script>
@endsection
@endcan