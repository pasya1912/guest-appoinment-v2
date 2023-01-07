@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-5">Ticket List</h4>
        <table class="table table-responsive-lg">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Guest Name</th>
              <th class="text-center">Visit Purpose</th>
              <th class="text-center">Plan Visit</th>
              <th class="text-center">Dates</th>
              {{-- <th class="text-center">Total Guest</th> --}}
              <th class="text-center">Status</th>
              <th class="text-center"></th>
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
                @if($appointment->status === 'pending')
                  <td><span class="badge badge-pill badge-warning p-2 text-light">{{ $appointment->status }}</span></td>
                  <td>
                    <button class="btn btn-icons btn-inverse-info" data-toggle="tooltip" title="QR disable" disabled>
                      <i class="mdi mdi-qrcode"></i>
                    </button>
                  </td>
                @elseif($appointment->status === 'approved')
                  <td><span class="badge badge-pill badge-success p-2 text-light">{{ $appointment->status }}</span></td>
                  <td>
                    <button data-toggle="tooltip" title="QR Code" data-toggle="modal" data-target="#demoModal-{{ $appointment->id }}" type="submit" class="btn btn-icons btn-inverse-info">
                      <i class="mdi mdi-qrcode"></i>
                    </button>
                  </td>
                @else
                  <td><span class="badge badge-pill badge-danger p-2 text-light">{{ $appointment->status }}</span></td>
                  <td><button hidden>QR code</button></td>
                @endif

              </tr>
              
              @endforeach
            @else
              <tr>
                <td colspan="7">
                  <h4 class="mt-4">You don't have any ticket</h4>
                </td>
              </tr>
            @endif
          </tbody>
        </table>

        <!-- Modal -->
        @foreach ($appointments as $appointment)   
        <div class="modal fade auto-off" id="demoModal-{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="demoModal-{{ $appointment->id }}" aria-hidden="true">
          <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
            <div class="modal-content">
              
              <div class="container-fluid">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="row">
                  <div class="col-md-12 text-center py-5 px-sm-5 ">
                    <h2>Your Barcode is Here!</h2>
                    <p class="text-muted">show this barcode to the security guard</p>
                    <span>{!! \QrCode::size(200)->generate($appointment->id) !!}</span>
                    <form class="pt-5">
                      <button type="submit" class="btn btn-primary" data-dismiss="modal" aria-label="Close">close modal</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <!-- Modal Ends -->

        {{-- @include('pagination.default') --}}
        {{ $appointments->links() }}
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>

<script>
  $(function () {
      $('[data-toggle="tooltip"]').tooltip()
  });
</script>
@endpush