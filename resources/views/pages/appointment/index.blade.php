@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">Make Appointment</h4>
                
                <form action="{{ route('appointment.create') }}" method="post" enctype="multipart/form-data" id="appointmentForm">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Guest Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control mt-2" id="nama" name="nama" placeholder="Masukkan nama...">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label mt-4">Visit Purpose</label>
                        <div class="col-sm-10">
                            <div class="boxes">
                                <input type="checkbox" id="purpose-1" name="purpose-1">
                                <label for="purpose-1">Makan bareng sacho</label>
                                
                                <input type="checkbox" id="purpose-2" name="purpose-2">
                                <label for="purpose-2">Jalan-jalan keliling aisin</label>
                                
                                <input type="checkbox" id="purpose-3" name="purpose-3">
                                <label for="purpose-3">Makan di kantin aisin</label>
                            </div>
                            <small id="emailHelp" class="form-text text-muted mt-3">Pilih satu atau lebih</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Plan Visit</label>
                        <div class="col-sm-10">
                            <select class="form-control mt-1" id="frekuensi" name="frekuensi">
                                <option value="0" selected>-- pilih frekuensi --</option>
                                <option value="once">Once</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">Pilih frekuensi kedatangan</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Select Date</label>
                        <div class="col-sm-10">
                            <input type="date" name="date" id="date" class="form-control"/>
                            <small id="emailHelp" class="form-text text-muted">Pilih tanggal</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Select Time</label>
                        <div class="col-sm-10">
                            <input type="time" name="time" id="time" class="form-control"/>
                            <small id="emailHelp" class="form-text text-muted">Pilih jam</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Total Guest</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="jumlahTamu" name="jumlahTamu" aria-describedby="emailHelp" placeholder="jumlah orang" required>
                            <small id="emailHelp" class="form-text text-muted">Jumlah tamu yang datang</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">PIC</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="pic" name="pic" aria-describedby="emailHelp" placeholder="masukkan aja cyok" required>
                            <small id="emailHelp" class="form-text text-muted">Nama PIC yang akan ditemui beserta department</small>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" id="dept" name="dept" required>
                                <option value="0">-- pilih Department --</option>
                                <option value="ITD">IT Development</option>
                                <option value="Kepo">KEPO</option>
                                <option value="Kepo">KEPO</option>
                                <option value="Kepo">KEPO</option>
                                <option value="Kepo">KEPO</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Document</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="doc" name="doc">
                                <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Selfie Photo</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="selfie" name="selfie">
                                <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row mt-5">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-lg btn-primary"><i class="mdi mdi-cloud-check pr-3"></i></i>Submit</button>
                        </div>
                    </div>
                </form>
                
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
<script>
    const form = document.getElementById('appointmentForm');
    form.addEventListener('submit', function(event) {
        if (!form.querySelector('input[type="checkbox"]:checked')) {
            event.preventDefault();
            alert('Please select at least one checkbox');
        }
    });
</script>
@endpush
