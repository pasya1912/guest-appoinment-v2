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
                                <th class="text-center">Visitor Company <small class="text-muted"> / 合計ゲスト</small></th>
                                <th class="text-center">Visit Purpose <small class="text-muted"> / 訪問目的</small></th>
                                <th class="text-center">Visit Date <small class="text-muted"> / 訪問日</small></th>
                                <th class="text-center">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @if (!$appointments->isEmpty())
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td class="display-4">{{ $appointment->id }}</td>
                                        <td class="display-4">{{ $appointment->name }}</td>
                                        <td class="display-4">{{ $appointment->user->company }}</td>
                                        <td class="display-4">{{ $appointment->purpose }}</td>
                                        <td class="display-4">
                                            {{ Carbon\Carbon::parse($appointment->date)->toFormattedDateString() }}</td>
                                        {{-- <td class="display-4">{{ $appointment->guest }}</td> --}}

                                        @if ($appointment->pic_approval == 'pending' && $appointment->dh_approval == 'pending')
                                            <td class="display-4">
                                                <span class="badge badge-warning">Pending</span>
                                            </td>
                                        @elseif($appointment->pic_approval == 'approved' && $appointment->dh_approval == 'pending')
                                            <td class="display-4">
                                                <span class="badge badge-secondary">Peding Dept. Head</span>
                                            </td>
                                        @elseif($appointment->pic_approval == 'approved' && $appointment->dh_approval == 'approved')
                                            <td class="display-4">
                                                <span class="badge badge-success">Approved</span>
                                            </td>
                                        @elseif($appointment->pic_approval == 'rejected' && $appointment->dh_approval == 'rejected')
                                            <td class="display-4">
                                                <span class="badge badge-danger">Rejected</span>
                                            </td>
                                        @elseif($appointment->pic_approval == 'approved' && $appointment->dh_approval == 'rejected')
                                            <td class="display-4">
                                                <span class="badge badge-danger">Rejected by Dept. Head</span>
                                            </td>
                                        @endif


                                        <td class="display-4">
                                            {{-- detail --}}
                                            <button data-toggle="modal" data-target="#detailModal-{{ $appointment->id }}"
                                                class="btn btn-icons btn-inverse-info" data-toggle="tooltip" title="Detail">
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
                        <div class="modal fade" id="detailModal-{{ $appointment->id }}" data-backdrop="static"
                            data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body ">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ticket Details</h5>
                                            <button type="button px-4" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="px-4 py-1">

                                            <div class="text-center">

                                                <img class="rounded"
                                                    src="{{ asset('uploads/selfie/' . $appointment->selfie) }}"
                                                    width="300" height="200">
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
                                                <span class="text-muted">Visit Date</span>
                                                <span
                                                    class="font-weight-bold">{{ Carbon\Carbon::parse($appointment->date)->toFormattedDateString() }}<span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Visit Time</span>
                                                <span class="font-weight-bold">{{ $appointment->time }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Visit Out Time</span>
                                                <span class="font-weight-bold">{{ $appointment->time_end }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Total Visitor</span>
                                                <span class="font-weight-bold">{{ $appointment->guest }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Assigned Room</span>
                                                <span
                                                    class="font-weight-bold">{{ isset($appointment->room_detail) ? $appointment->room_detail->room->name : '-' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Room Time</span>
                                                <span
                                                    class="font-weight-bold">{{ isset($appointment->room_detail) ? $appointment->room_detail->booking_time : '-' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Room Time Out</span>
                                                <span
                                                    class="font-weight-bold">{{ isset($appointment->room_detail) ? $appointment->room_detail->booking_time_end : '-' }}</span>
                                            </div>

                                            <div class="mb-3">
                                                <hr class="new1">
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <span class="font-weight-bold">PIC</span>
                                                <span class="font-weight-bold">{{ $appointment->pic->name }}</span>
                                            </div>
                                            <div class="row d-flex justify-content-center">

                                                <div class="col-md-12">

                                                    <input type="checkbox" id="dry-food-non-history"
                                                        name="dry-food-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->snack_kering > 0 ? 'checked' : '' ?>
                                                        disabled>

                                                    <label for="dry-food-non-history">Snack Kering :
                                                        <span>{{ $appointment->facility_detail->snack_kering ?? '0' }}</label>


                                                    <input type="checkbox" id="wet-food-non-history"
                                                        name="wet-food-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->snack_basah > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="wet-food-non-history">Snack Basah:
                                                        <span>{{ $appointment->facility_detail->snack_basah ?? '0' }}</label>

                                                    <input type="checkbox" id="lunch-non-history"
                                                        name="lunch-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->makan_siang > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="lunch-non-history">Makan Siang :
                                                        <span>{{ $appointment->facility_detail->makan_siang ?? '0' }}</label>

                                                    <input type="checkbox" id="candy-non-history"
                                                        name="candy-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->permen > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="candy-non-history">Permen :
                                                        <span>{{ $appointment->facility_detail->permen ?? '0' }}</label>
                                                    <input type="checkbox" id="coffee-non-history"
                                                        name="coffee-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->kopi > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="coffee-non-history">Coffee :
                                                        <span>{{ $appointment->facility_detail->kopi ?? '0' }}</label>

                                                    <input type="checkbox" id="tea-non-history" name="tea-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->teh > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="tea-non-history">Tea :
                                                        <span>{{ $appointment->facility_detail->teh ?? '0' }}</label>

                                                    <input type="checkbox" id="soft-drink-non-history"
                                                        name="soft-drink-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->soft_drink > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="soft-drink-non-history">Soft Drink :
                                                        <span>{{ $appointment->facility_detail->soft_drink ?? '0' }}</label>

                                                    <input type="checkbox" id="mineral-water-non-history"
                                                        name="mineral-water-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->air_mineral > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="mineral-water-non-history">Mineral Water :
                                                        <span>{{ $appointment->facility_detail->air_mineral ?? '0' }}</label>
                                                    <input type="checkbox" id="helm-non-history" name="helm-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->helm > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="helm-non-history">Helm :
                                                        <span>{{ $appointment->facility_detail->helm ?? '0' }}</label>

                                                    <input type="checkbox" id="handuk-non-history"
                                                        name="handuk-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->handuk > 0 ? 'checked' : '' ?>
                                                        disabled>

                                                    <label for="handuk-non-history">Handuk :
                                                        <span>{{ $appointment->facility_detail->handuk ?? '0' }}</label>

                                                    <input type="checkbox" id="speaker-non-history"
                                                        name="speaker-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->speaker > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="speaker-non-history">Speaker :
                                                        <span>{{ $appointment->facility_detail->speaker ?? '0' }}</label>


                                                    <input type="checkbox" id="speaker-wireless-non-history"
                                                        name="speaker-wireless-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->speaker_wireless > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="speaker-wireless-non-history">Speaker
                                                        Wireless :
                                                        <span>{{ $appointment->facility_detail->speaker_wireless ?? '0' }}</label>
                                                    <input type="checkbox" id="motor-non-history"
                                                        name="motor-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->motor > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="motor-non-history">Motor :
                                                        <span>{{ $appointment->facility_detail->motor ?? '0' }}</label>


                                                    <input type="checkbox" id="mobil-non-history"
                                                        name="mobil-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->mobil > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="mobil-non-history">Mobil :
                                                        <span>{{ $appointment->facility_detail->mobil ?? '0' }}</label>



                                                    <input type="checkbox" id="mini-bus-non-history"
                                                        name="mini-bus-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->mini_bus > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="mini-bus-non-history">Mini Bus :
                                                        <span>{{ $appointment->facility_detail->mini_bus ?? '0' }}</label>

                                                    <input type="checkbox" id="bus-non-history" name="bus-non-history"
                                                        <?= $appointment->facility_detail != null && $appointment->facility_detail->bus > 0 ? 'checked' : '' ?>
                                                        disabled>
                                                    <label for="bus-non-history">Bus :
                                                        <span>{{ $appointment->facility_detail->bus ?? '0' }}</label>
                                                </div>

                                            </div>
                                            <div class="mx-4 mt-2">
                                                <div>Other :</div>
                                                <div>
                                                    {{ $appointment->facility_detail != null ? $appointment->facility_detail->other : '' }}
                                                </div>
                                            </div>
                                            <div class="text-center mt-5">
                                                <a class="btn btn-primary py-3"
                                                    href="{{ asset('uploads/doc/' . $appointment->doc) }}"
                                                    download="">
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

            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            });

            $('#allTicket').DataTable({
                order: [
                    [0, "desc"]
                ],
                "lengthChange": false
            });

        });

        const dry_food = document.getElementById('dry-food-non');
        const wet_food = document.getElementById('wet-food-non');
        const lunch = document.getElementById('lunch-non');
        const candy = document.getElementById('candy-non');
        const coffee = document.getElementById('coffee-non');
        const tea = document.getElementById('tea-non');
        const mineral_water = document.getElementById('mineral-water-non');
        const soft_drink = document.getElementById('soft-drink-non');
        const helm = document.getElementById('helm-non');
        const handuk = document.getElementById('handuk-non');
        const speaker = document.getElementById('speaker-non');
        const speaker_wireless = document.getElementById('speaker-wireless-non');
        const motor = document.getElementById('motor-non');
        const mobil = document.getElementById('mobil-non');
        const mini_bus = document.getElementById('mini-bus-non');
        const bus = document.getElementById('bus-non');
        // const checkbox = document.getElementById('dry-food-non');
        // const checkbox = document.getElementById('dry-food-non');

        // food
        $('#dry-food-non-quantity').hide();
        $('#wet-food-non-quantity').hide();
        $('#lunch-non-quantity').hide();
        $('#candy-non-quantity').hide();
        $("input[type='checkbox']").on("change", function() {
            if (this.checked) {
                if (this == dry_food) {
                    $('#dry-food-non-quantity').show();
                } else if (this == wet_food) {
                    $('#wet-food-non-quantity').show();
                } else if (this == lunch) {
                    $('#lunch-non-quantity').show();
                } else if (this == candy) {
                    $('#candy-non-quantity').show();
                }
            } else {
                if (this == dry_food) {
                    $('#dry-food-non-quantity').hide();
                } else if (this == wet_food) {
                    $('#wet-food-non-quantity').hide();
                } else if (this == lunch) {
                    $('#lunch-non-quantity').hide();
                } else if (this == candy) {
                    $('#candy-non-quantity').hide();
                }
            }
        });

        // drink
        $('#coffee-non-quantity').hide();
        $('#tea-non-quantity').hide();
        $('#soft-drink-non-quantity').hide();
        $('#mineral-water-non-quantity').hide();
        $("input[type='checkbox']").on("change", function() {
            if (this.checked) {
                if (this == coffee) {
                    $('#coffee-non-quantity').show();
                } else if (this == tea) {
                    $('#tea-non-quantity').show();
                } else if (this == soft_drink) {
                    $('#soft-drink-non-quantity').show();
                } else if (this == mineral_water) {
                    $('#mineral-water-non-quantity').show();
                }
            } else {
                if (this == coffee) {
                    $('#coffee-non-quantity').hide();
                } else if (this == tea) {
                    $('#tea-non-quantity').hide();
                } else if (this == soft_drink) {
                    $('#soft-drink-non-quantity').hide();
                } else if (this == mineral_water) {
                    $('#mineral-water-non-quantity').hide();
                }
            }
        });

        // Plant tour
        $('#helm-non-quantity').hide();
        $('#handuk-non-quantity').hide();
        $('#speaker-non-quantity').hide();
        $('#speaker-wireless-non-quantity').hide();
        $("input[type='checkbox']").on("change", function() {
            if (this.checked) {
                if (this == helm) {
                    $('#helm-non-quantity').show();
                } else if (this == handuk) {
                    $('#handuk-non-quantity').show();
                } else if (this == speaker) {
                    $('#speaker-non-quantity').show();
                } else if (this == speaker_wireless) {
                    $('#speaker-wireless-non-quantity').show();
                }
            } else {
                if (this == helm) {
                    $('#helm-non-quantity').hide();
                } else if (this == handuk) {
                    $('#handuk-non-quantity').hide();
                } else if (this == speaker) {
                    $('#speaker-non-quantity').hide();
                } else if (this == speaker_wireless) {
                    $('#speaker-wireless-non-quantity').hide();
                }
            }
        });

        // Parkir
        $('#motor-non-quantity').hide();
        $('#mobil-non-quantity').hide();
        $('#mini-bus-non-quantity').hide();
        $('#bus-non-quantity').hide();
        $("input[type='checkbox']").on("change", function() {
        if (this.checked) {
            if (this == motor) {
                $('#motor-non-quantity').show();
            } else if (this == mobil) {
                $('#mobil-non-quantity').show();
            } else if (this == mini_bus) {
                $('#mini-bus-non-quantity').show();
            } else if (this == bus) {
                $('#bus-non-quantity').show();
            }
        } else {
            if (this == motor) {
                $('#motor-non-quantity').hide();
            } else if (this == mobil) {
                $('#mobil-non-quantity').hide();
            } else if (this == mini_bus) {
                $('#mini-bus-non-quantity').hide();
            } else if (this == bus) {
                $('#bus-non-quantity').hide();
            }
        }
        });

        });
    </script>
@endpush
