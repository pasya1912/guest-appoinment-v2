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

          <div class="form-group">
            <label>Tujuan kedatangan Anda?</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option selected>-- pilih opsi --</option>
              <option>KEPO</option>
              <option>KEPO</option>
              <option>KEPO</option>
              <option>KEPO</option>
              <option>KEPO</option>
            </select>
            <small id="emailHelp" class="form-text text-muted">Pilih sesuai tujuan anda</small>
          </div>

          <div class="form-group mt-4">
            <label>Siapa Nama Anda?</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="masukin nama cyok" required>
            <small id="emailHelp" class="form-text text-muted">Masukkan nama lengkap</small>
          </div>

          <div class="form-group mt-4">
            <label class="mb-4">Apa Agenda Kamu Cyok?</label>
            <div class="boxes">
                <input type="checkbox" id="box-1">
                <label for="box-1">Makan bareng sacho</label>
                
                <input type="checkbox" id="box-2">
                <label for="box-2">Jalan-jalan keliling aisin</label>
                
                <input type="checkbox" id="box-3">
                <label for="box-3">Makan di kantin aisin</label>
            </div>
            <small id="emailHelp" class="form-text text-muted mt-3">Pilih satu atau lebih</small>
        </div>

        <label class="mt-4">Plan visit</label>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <select class="browser-default custom-select mt-3" id="exampleFormControlSelect1" required>
                        <option value="" selected>-- pilih frekuensi --</option>
                        <option>Daily</option>
                        <option>Weekly</option>
                        <option>Monthly</option>
                    </select>
                    <small id="emailHelp" class="form-text text-muted">Pilih frekuensi kedatangan</small>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label class="control-label" for="datetimepicker-1">Select Date</label>
                        <input type="date" name="date" id="date" class="form-control"/>
                        <small id="emailHelp" class="form-text text-muted">Pilih tanggal</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label class="control-label" for="datetimepicker-2">Select Time</label>
                        <input type="time" name="time" id="time" class="form-control"/>
                        <small id="emailHelp" class="form-text text-muted">Pilih jam</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mt-4">
          <label>Berapa banyak tamu?</label>
          <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="jumlah orang" required>
          <small id="emailHelp" class="form-text text-muted">Jumlah tamu yang datang</small>
        </div>

        <label class="mt-4">Siapa PIC yang ditemui Cyok?</label>
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6">
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="masukkan aja cyok" required>
                    <small id="emailHelp" class="form-text text-muted">Nama PIC yang akan ditemui beserta department</small>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="form-group">
                    <select class="browser-default custom-select" id="exampleFormControlSelect1" required>
                        <option value="" selected>-- pilih Department --</option>
                        <option>IT Development</option>
                        <option>KEPO</option>
                        <option>KEPO</option>
                        <option>KEPO</option>
                        <option>KEPO</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- <div class="container mb-5"> --}}
          <div class="row mt-5">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <button type="button" class="btn btn-lg btn-primary"><i class="mdi mdi-cloud-check pr-3"></i></i>Submit</button>
              </div>
          </div>
        {{-- </div> --}}
        
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
@endpush