@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
<div class="row justify-content-between">
    <div class="col-lg-6 grid-margin">
        <main class="page payment-page">
            <section class="payment-form dark">
                <div class="container">
                    <form  action="{{ route('qrScan.index') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="products text-center">
                            <h3 class="title">Scan QR Code</h3>
                            <input type="text" class="form-control" placeholder="QR Code..." name="qrcode" autofocus>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
    <div class="col-lg-6 grid-margin">
        <main class="page payment-page">
            <section class="payment-form dark">
                <div class="container">
                    <form>
                        <div class="products">
                            <h3 class="title">Ticket Details</h3>
                            @if(empty($appointments))
                            <div class="text-center pt-3">
                                <span class="">No barcode has been scanned</span>
                            </div>
                            @else
                            <div class="item">
                                <p class="item-name">Personal Data</p>
                                <span class="price">{{ $appointments->name }}</span>
                                <p class="item-description">Visitor Name</p>
                            </div>
                            <div class="total">PIC<span class="price">{{ $appointments->pic }}</span></div>
                            @endif
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection

@push('plugin-scripts')
{!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
{!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}
@endpush

@push('custom-scripts')
{!! Html::script('/assets/js/dashboard.js') !!}
@endpush