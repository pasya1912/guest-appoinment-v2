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
                {{-- Detail Modal --}}
                @foreach ($appointments as $appointment)   
                <div class="modal fade" id="detailModal-{{ $appointment->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body ">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ticket Detail</h5>
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
                                        <span class="text-muted">Visitor Purpose</span>
                                        <span class="font-weight-bold">{{ $appointment->purpose }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Visit Frequency</span>
                                        <span class="font-weight-bold">{{ $appointment->frequency}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Visit Date</span>
                                        <span class="font-weight-bold">{{ $appointment->date }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Visit Time</span>
                                        <span class="font-weight-bold">{{ $appointment->time }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">PIC</span>
                                        <span class="font-weight-bold">{{ $appointment->pic }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Total Visitor</span>
                                        <span class="font-weight-bold">{{ $appointment->guest }}</span>
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
                
                <!-- Modal -->
                {{-- Approval Modal --}}
                @foreach ($appointments as $appointment)   
                <div class="modal fade auto-off" id="approveModal-{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="demoModal-{{ $appointment->id }}" aria-hidden="true">
                    <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Approval confirmation</h5>
                                <button type="button px-4" class="close" data-dismiss="modal" aria-label="Close">
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
                                <button type="button px-4" class="close" data-dismiss="modal" aria-label="Close">
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