<!DOCTYPE html>
<html lang="en">
<head>
  <title>Neo App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css">
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>

</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Neo App</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <!-- <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li> -->
    </ul>
  </div>
</nav>
  
<div class="container">
  <h3>Asteroid - Neo Stats</h3>
  <p>Please enter the date range to get the Neo data.</p>
</div>
<div class="container">
<div class="form-inline">
    <div class="form-group">
        <label for="startDate">Start Date</label>
        <input id="startDate" name="startDate" type="text" class="form-control" />
        &nbsp;
        <label for="endDate">End Date</label>
        <input id="endDate" name="endDate" type="text" class="form-control" />
    </div>
    <div class="form-group">
        <button onClick="getData();" class="btn btn-success">Submit</button>
    </div>
    </div>
    </div>
    <br><br>
    <div class="container">
    <div class="form-group">
    <h4>Fastest Asteroid in km/h</h4>
            <label> Asteroid ID:</label><div id="speed_id"></div>
            <label > Speed:</label><div id="speed_value"></div>
    </div>
    </div>
    <br><br>
    <div class="container">
    <div class="form-group">
    <h4>Closest Asteroid in km</h4>
            <label> Asteroid ID:</label><div id="close_id"></div>
            <label > Distance:</label><div id="close_value"></div>
    </div>
    </div>
    <br><br>

    
    <div class="container">
    <h1>Graph Analysis :</h1>
    <canvas id="examChart"></canvas>
    <canvas id="myChart" width="400" height="400"></canvas>
    </div>
    </body>
    </html>

<script>

    var sd = new Date(), ed = new Date();
  
    $('#startDate').datetimepicker({ 
      pickTime: false, 
      format: "YYYY-MM-DD", 
      defaultDate: sd, 
      maxDate: ed 
    });
  
    $('#endDate').datetimepicker({ 
      pickTime: false, 
      format: "YYYY-MM-D", 
      defaultDate: ed, 
      minDate: sd 
    });

function getData() {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    if(endDate != '') {
      $.ajax({
        type: 'get',
        url: 'https://api.nasa.gov/neo/rest/v1/feed?start_date='+startDate+'&end_date='+endDate+'&api_key=GMZ2JD6eYnDkWFRPOS36Z3UGXiyiy9MsHcFBMfGH',
        dataType: 'json',
        beforeSend: function() {
        },
        error: function(res) {
          
        },
        success: function(res) {
                // alert(res.near_earth_objects);
                var data = JSON.stringify(res.near_earth_objects);
                $.ajax({
                            type: 'post',
                            url: "{{route('getData')}}",
                            data:'data='+data,
                            dataType: 'json',
                            beforeSend: function() {
                            },
                            error: function(res) {
                            
                            },
                            success: function(res) {
                               $('#speed_id').html(res[0].id);
                               $('#speed_value').html(res[0].relative_velocity);   
                               $('#close_id').html(res[1].id);
                               $('#close_value').html(res[1].miss_distance);
                            //    alert(res[2]);  
                               var time_Array = res[2];
                                var meas_value_Array = res[3];


                                //console.log(time_Array);
                                //console.log(meas_value_Array);

                                var ctx = document.getElementById ('myChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                labels: time_Array,
                                datasets: [{
                                label: 'Neo Stats',
                                data: meas_value_Array,
                                backgroundColor: "rgba(255,153,0,0.4)"
                                }]
                                },

                                    options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }],
                                        xAxes: [{
                                            type: 'time',
                                            time: {
                                                parser: 'YYYY-MM-DD HH:mm:ss',
                                                unit: 'minute',
                                                displayFormats: {
                                                    'minute': 'YYYY-MM-DD HH:mm:ss',
                                                    'hour': 'YYYY-MM-DD HH:mm:ss'
                                                }
                                            },
                                            ticks: {
                                                source: 'data'
                                            }
                                        }]                    
                                    }
                                }
                            });
        
                            }
                        })
        }
      })
    }
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>

<script>

 

</script>