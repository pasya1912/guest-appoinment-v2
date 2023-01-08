@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin">
        @if (session('approved'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('approved') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">Ticket list</h4>
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
                            <th class="text-center">Action</th>
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
                            <td><span class="badge badge-pill badge-warning p-2 text-light">{{ $appointment->status }}</span></td>
                            <td>

                                {{-- detail --}}
                                <button data-toggle="modal" data-target="#detailModal-{{ $appointment->id }}"  class="btn btn-icons btn-inverse-info" data-toggle="tooltip" title="Detail">
                                    <i class="mdi mdi-information"></i>
                                </button>

                                {{-- apporval --}}
                                <button data-toggle="modal" data-target="#approveModal-{{ $appointment->id }}" type="submit" class="btn btn-icons btn-inverse-success" data-toggle="tooltip" title="Approve">
                                    <i class="mdi mdi-check-circle"></i>
                                </button>

                                {{-- reject --}}
                                <button data-toggle="modal" data-target="#rejectModal-{{ $appointment->id }}" type="submit" class="btn btn-icons btn-inverse-danger" data-toggle="tooltip" title="Reject">
                                    <i class="mdi mdi-close-circle"></i>
                                </button>

                            </td>
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
                
                <!-- Modal -->
                {{-- Approval Modal --}}
                @foreach ($appointments as $appointment)   
                <div class="modal fade auto-off" id="detailModal-{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="demoModal-{{ $appointment->id }}" aria-hidden="true">
                    <div class="modal-dialog animated zoomInDown modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Ticket Detail</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img class="rounded" src="{{ asset('uploads/selfie/'. $appointment->selfie) }}" width="300" height="300">
                                    </div>
                                    <div class="col-md-8 text-left   pr-5">
                                        <h4 class="font-weight-bold pb-3">Personal Data</h4>
                                        <p class="">Visitor Name <span class="pl-5 pb-1">: {{ $appointment->name }}</span></p>
                                        <p class="">Visitor Company <span class="pl-5 pb-1">: {{ $appointment->user->company }}</span></p>
                                        
                                        <h4 class="font-weight-bold pb-3">Visit Plan</h4>
                                        <p class="">Visit Purpose <span class="pl-5">: {{ $appointment->purpose }}</span></p>
                                        <p class="">Visit Frequency<span class="pl-5">: {{ $appointment->frequency }}</span></p>
                                        <p class="">Visit Date <span class="pl-5">: {{ $appointment->date }}</span></p>
                                        <p class="">Visit Time <span class="pl-5">: {{ $appointment->time }}</span></p>
                                        <p class="">Total Visitor <span class="pl-5">: {{ $appointment->guest }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="/appointment/approval/{{ $appointment->id }}" method="post" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Modal Ends -->

                <!-- Modal -->
                {{-- Approval Modal --}}
                @foreach ($appointments as $appointment)   
                <div class="modal fade auto-off" id="approveModal-{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="demoModal-{{ $appointment->id }}" aria-hidden="true">
                    <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Approval confirmation</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Are you sure want to <strong>approve</strong> this ticket?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="/appointment/approval/{{ $appointment->id }}" method="post" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Modal Ends -->

                <!-- Modal -->
                {{-- rejection Modal --}}
                @foreach ($appointments as $appointment)   
                <div class="modal fade auto-off" id="rejectModal-{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="demoModal-{{ $appointment->id }}" aria-hidden="true">
                    <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Rejection confirmation</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Are you sure want to <strong>reject</strong> this ticket?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="/appointment/rejection/{{ $appointment->id }}" method="post" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Modal Ends -->
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

<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

@endpush