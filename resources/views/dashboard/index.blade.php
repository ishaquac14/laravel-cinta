@extends('layouts.app')

@section('body')

<div class="container">
  <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
