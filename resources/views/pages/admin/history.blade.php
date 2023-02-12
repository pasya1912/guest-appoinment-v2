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
        <h4 class="card-title mb-5">Ticket History <small class="text-muted"> / チケット履歴</small></h4>
        <table class="table table-responsive-lg" id="allTicket">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Visitor Name <small class="text-muted"> / 訪問者名</small></th>
              <th class="text-center">Visit Purpose <small class="text-muted"> / 訪問目的</small></th>
              <th class="text-center">Visit Plan<small class="text-muted"> / 見学プラン</small></th>
              <th class="text-center">Visit Date <small class="text-muted"> / 訪問日</small></th>
              <th class="text-center">Status</th>
              <th></th>
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
              <td class="display-4">{{ Carbon\Carbon::parse($appointment->start_date)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($appointment->end_date)->toFormattedDateString() }}</td>
              {{-- <td class="display-4">{{ $appointment->guest }}</td> --}}
              @if($appointment->pic_approval === "pending")
                <td><span class="badge badge-pill badge-warning p-2 text-light">{{ $appointment->pic_approval }}</span></td>
              @elseif($appointment->pic_approval === "approved")
                <td><span class="badge badge-pill badge-success p-2 text-light">{{ $appointment->pic_approval }}</span></td>
              @else
                <td><span class="badge badge-pill badge-danger p-2 text-light">{{ $appointment->pic_approval }}</span></td>
              @endif
              
              <td class="display-4">
                {{-- detail --}}
                <button data-toggle="modal" data-target="#detailModal-{{ $appointment->id }}"  class="btn btn-icons btn-inverse-info" data-toggle="tooltip" title="Detail">
                  <i class="mdi mdi-information"></i>
                </button>
              </td>
            </tr>
            
            @endforeach
            @endif
          </tbody>
        </table>
        
        <!-- Modal -->
        {{-- Detail Modal --}}
        @foreach ($appointments as $appointment)   
        <div class="modal fade" id="detailModal-{{ $appointment->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body ">
                <div class="modal-header">
                  <h5 class="modal-title">Ticket Details</h5>
                  <button type="button px-4" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                
                <div class="px-4 py-1">
                  
                  <div class="text-center">
                    
                    <img class="rounded" src="{{ asset('uploads/selfie/'. $appointment->selfie) }}" width="300" height="200">
                  </div>
                  {{-- <span class="theme-color font-weight-bold">Ticket Detail</span> --}}
                  <div class="mb-3">
                    <hr class="new1">
                  </div>
                  
                  <div class="d-flex justify-content-between">
                    <span class="font-weight-bold h4">Personal Data</span>
                  </div>
                  
                  <div class="d-flex justify-content-between">
                    <span class="text-muted">Visitor Name</span>
                    <span class="font-weight-bold">{{ $appointment->name }}</span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted">Visitor Company</span>
                    <span class="font-weight-bold">{{ $appointment->user->company }}</span>
                  </div>
                  
                  <div class="d-flex justify-content-between pt-4">
                    <span class="font-weight-bold h4">Plan Visit</span>
                  </div>
                  
                  <div class="d-flex justify-content-between">
                    <span class="text-muted">Visit Purpose</span>
                    <span class="font-weight-bold">{{ $appointment->purpose }}</span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted">Visit Frequency</span>
                    <span class="font-weight-bold">{{ $appointment->frequency}}</span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted">Visit Date</span>
                    <span class="font-weight-bold">{{ Carbon\Carbon::parse($appointment->start_date)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($appointment->end_date)->toFormattedDateString() }}</span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted">Visit Time</span>
                    <span class="font-weight-bold">{{ $appointment->time }}</span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted">Total Visitor</span>
                    <span class="font-weight-bold">{{ $appointment->guest }}</span>
                  </div>
                  
                  <div class="mb-3">
                    <hr class="new1">
                  </div>
                  
                  <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">PIC</span>
                    <span class="font-weight-bold">{{ $appointment->pic->name }}</span>
                  </div>
                  
                  <div class="text-center mt-5">
                    <a class="btn btn-primary py-3" href="{{ asset('uploads/doc/' . $appointment->doc) }}" download="">
                      <i class="mdi mdi-cloud-check pr-2"></i>Download Document
                    </a>   
                  </div>                   
                  
                </div>
                
                
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <!-- Modal Ends -->
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
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function() {
    
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    
    $('#allTicket').DataTable({
      "lengthChange": false
    });
    
  });
</script>
@endpush