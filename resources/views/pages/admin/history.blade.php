@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin">

    @if (session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @elseif (session()->has('reject'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('reject') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-5">Appointment History</h4>
        <table class="table table-responsive-lg">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Guest Name</th>
              <th class="text-center">Visit Purpose</th>
              <th class="text-center">Plan Visit</th>
              <th class="text-center">Dates</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody class="text-center">
            @if(!$appointments->isEmpty())
              @foreach ($appointments as $appointment)
              
              <tr>
                <td class="display-4">{{ $loop->iteration }}</td>
                <td class="display-4">{{ $appointment->name }}</td>
                <td class="display-4">{{ $appointment->purpose }}</td>
                <td class="display-4">{{ $appointment->frequency }}</td>
                <td class="display-4">{{ $appointment->date }}</td>
                {{-- <td class="display-4">{{ $appointment->guest }}</td> --}}
                @if($appointment->status === "pending")
                  <td><span class="badge badge-pill badge-warning p-2 text-light">{{ $appointment->status }}</span></td>
                @elseif($appointment->status === "approved")
                  <td><span class="badge badge-pill badge-success p-2 text-light">{{ $appointment->status }}</span></td>
                @else
                  <td><span class="badge badge-pill badge-danger p-2 text-light">{{ $appointment->status }}</span></td>
                @endif
              </tr>
              
              @endforeach
            @else
              <tr>
                <td colspan="7">
                  <h4 class="mt-4">No tickets have been created yet</h4>
                </td>
              </tr>
            @endif
          </tbody>
        </table>
        {{-- @include('pagination.default') --}}
        {{ $appointments->links('pagination.default') }}
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
{!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
{!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}
@endpush

@push('custom-scripts')
{!! Html::script('/assets/js/dashboard.js') !!}
{{-- <script>
  $(document).ready(function() {
    
    $('#table').DataTable({
      searching: true,
      ordering:  true      
    });
    
  });
</script> --}}
@endpush