@extends('layout.master')

@push('plugin-styles')
<!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-5">Appointment History</h4>
        <table class="table" id="table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Guest Name</th>
                    <th class="text-center">Visit Purpose</th>
                    <th class="text-center">Plan Visit</th>
                    <th class="text-center">Dates</th>
                    <th class="text-center">Total Guest</th>
                    <th class="text-center">PIC</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>1</td>
                    <td>apa aja</td>
                    <td>apa aja</td>
                    <td>apa aja</td>
                    <td>apa aja</td>
                    <td>apa aja</td>
                    <td>apa aja</td>
                    <td>apa aja</td>
                </tr>
            </tbody>
        </table>
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
    $(document).ready(function() {

      $('#table').DataTable({
        searching: true,
        ordering:  true      
      });

    });
</script>
@endpush