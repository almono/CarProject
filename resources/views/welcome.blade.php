<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Car project</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            @if( $car_makes->isEmpty())
            <div class="col-xs-12 text-center" style="border: 1px solid black; padding: 15px;">
                <span>Upload the csv file here</span>
                <form method="POST" action="{{ route('upload_csv') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" value="Send file..." name="csv_file">
                    <input type="submit" value="Upload">
                </form>
            </div>
            @else
                <div class="col-xs-12 text-left">
                    <h1>Cascading vehicle form</h1>
                    <label for="Make">Make</label>
                    <select class="form-control" id="Make" style="max-width: 260px;">
                        <option value="0">-- PLEASE SELECT MAKE --</option>
                        @foreach($car_makes as $m)
                            <option value="{{ $m->id }}">{{ $m->make_name }}</option>
                        @endforeach
                    </select>
                    <label for="Model">Model</label>
                    <select class="form-control" id="Model" style="max-width: 260px;">
                        <option value="0">MODEL</option>
                    </select>
                    <label for="Submodel">Submodel</label>
                    <select class="form-control" id="Submodel" style="max-width: 260px;">
                        <option value="0">SUBMODEL</option>
                    </select>
                    <div class="col-xs-12 text-center">
                        <span id="result_span"></span>
                    </div>
                </div>
            @endif
        </div>
    </body>
</html>

<script type="text/javascript">
    $(document).ready( function() {

        $("option:selected").prop("selected", false);

        $("#Make").on('change', function() {

            var car_make = $(this).children("option:selected").val();

            $("#Submodel option:selected").prop("selected", false);

            $.ajax({
                type: 'POST',
                url: "{{ route('get_models') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    car_model: car_make
                },
                success: function(data) {
                    var html = '';
                    html += "<option value=" + 0 + ">MODEL</option>";
                    $.each(data, function(array, model) {
                        html += "<option value=" + model.id + ">"+ model.model_name + "</option>"
                    });

                    $("#Model").html(html);
                }
            });

            var make = $("#Make option:selected").text();
            $("#result_span").html(make);
        });
        $("#Model").on('change', function() {

            var car_model = $(this).children("option:selected").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('get_submodels') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    car_submodel: car_model
                },
                success: function(data) {
                    var html = '';
                    html += "<option value=" + 0 + ">SUBMODEL</option>";
                    $.each(data, function(array, submodel) {
                        html += "<option value=" + submodel.id + ">"+ submodel.submodel_name + "</option>"
                    });

                    console.log(html);

                    $("#Submodel").html(html);
                }
            });

            var make = $("#Make option:selected").text();
            var model = $("#Model option:selected").text();
            $("#result_span").html(make + ' ' + model);
        });

        $("#Submodel").on('change', function() {
            var make = $("#Make option:selected").text();
            var model = $("#Model option:selected").text();
            var submodel = $("#Submodel option:selected").text();
            $("#result_span").html(make + ' ' + model + ' ' + submodel);
        });
    });
</script>
