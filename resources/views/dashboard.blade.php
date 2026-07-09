@extends('layout')

@section('content')

<h3 class="mb-4">Dashboard</h3>

<style>

body{
    background:linear-gradient(135deg,#dbeafe,#bfdbfe,#93c5fd);
    min-height:100vh;
}

.navbar{
    box-shadow:0 4px 10px rgba(0,0,0,.2);
}

.card-box{

    padding:20px;
    border-radius:15px;
    color:white;
    box-shadow:0 5px 15px rgba(0,0,0,.2);
    transition:.3s;

}

.clickable-card{
    cursor:pointer;
}

.clickable-card:hover{

    transform:translateY(-5px);

    box-shadow:0 10px 25px rgba(0,0,0,.3);

}

.card{

    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.15);

}

.card-body{

    padding:25px;

}

#chart{

    width:100%!important;
    height:420px!important;

}

</style>


<div class="row">

    <!-- SUHU -->
    <div class="col-md-3 mb-3">

        <div class="card-box bg-danger clickable-card">

            <small>Suhu Saat Ini</small>

           <h3 id="suhu">{{ $data->suhu ?? 0 }} °C</h3>

        </div>

    </div>


    <!-- KELEMBAPAN -->
    <div class="col-md-3 mb-3">

        <div class="card-box bg-primary clickable-card">

            <small>Kelembapan</small>

            <h3 id="kelembapan">{{ $data->kelembapan ?? 0 }} %</h3>

        </div>

    </div>


    <!-- USIA TELUR -->
    <div class="col-md-3 mb-3">

        <div class="card-box bg-warning clickable-card">

            <small>Usia Telur</small>

            <h3>{{ $usia }} Hari</h3>

        </div>

    </div>


    <!-- STATUS HEATER -->
    <div class="col-md-3 mb-3">

        <div class="card-box {{ ($kontrol->heater ?? 'OFF')=='ON' ? 'bg-success' : 'bg-danger' }} clickable-card">

            <small>Status Heater</small>

          <h3 id="heater">{{ $kontrol->heater ?? 'OFF' }}</h3>

        </div>

    </div>

    <div class="col-md-3 mb-3">

    <div class="card-box clickable-card"style="background:linear-gradient(135deg,#7b2ff7,#9b59ff);">

          <small>Motor Putar</small>
          
          <h3 id="motorStatus">{{ $kontrol->motor ?? 'OFF' }}</h3>
          
          <small id="motorInfo">Menunggu...</small>
    </div>
    </div>


<!-- =========================== -->
<!-- GRAFIK -->
<!-- =========================== -->

<div class="row mt-4">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

                    Grafik Suhu & Kelembapan

                </h5>

                <canvas id="chart"></canvas>

            </div>

        </div>

    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

let chart;

function loadChart(){

    fetch('/api/suhu')
    .then(response => response.json())
    .then(data => {

        // Update status motor
        fetch('/api/kontrol')
        .then(r => r.json())
        .then(k => {
            document.getElementById("motorStatus").innerHTML = k.motor;
        });

        let label = [];
        let suhu = [];
        let kelembapan = [];

        data.forEach(item => {

            // jam:menit:detik
            let waktu = new Date(item.created_at);

            label.push(
                waktu.toLocaleTimeString('id-ID')
            );

            suhu.push(parseFloat(item.suhu));
            kelembapan.push(parseFloat(item.kelembapan));

        });

        if(chart){
            chart.destroy();
        }

        chart = new Chart(document.getElementById("chart"),{

            type:'line',

            data:{

                labels:label,

                datasets:[

                    {

                        label:'Suhu',

                        data:suhu,

                        borderColor:'#2196F3',

                        backgroundColor:'rgba(33,150,243,.2)',

                        borderWidth:3,

                        fill:false,

                        tension:0.4

                    },

                    {

                        label:'Kelembapan',

                        data:kelembapan,

                        borderColor:'#F44336',

                        backgroundColor:'rgba(244,67,54,.2)',

                        borderWidth:3,

                        fill:false,

                        tension:0.4

                    }

                ]

            },

            options:{

                responsive:true,

                maintainAspectRatio:false,

                scales:{

                    y:{
                        beginAtZero:false
                    }

                }

            }

        });

    });

}
// Pertama kali
loadChart();

// Refresh grafik setiap 5 detik
setInterval(loadChart,5000);

</script>
<script>

const intervalMotor = 3 * 60 * 60;   // 3 jam
const durasiMotor  = 60;             // 60 detik

let sisa = intervalMotor;

setInterval(function(){

    let status = document.getElementById("motorStatus").innerHTML;

    if(status=="ON"){

        document.getElementById("motorInfo").innerHTML =
        "Motor sedang berputar";

    }else{

        sisa--;

        if(sisa<=0){

            sisa=intervalMotor;

        }

        let jam=Math.floor(sisa/3600);
        let menit=Math.floor((sisa%3600)/60);
        let detik=sisa%60;

        document.getElementById("motorInfo").innerHTML=
        "Putar lagi : "
        +String(jam).padStart(2,'0')+":"
        +String(menit).padStart(2,'0')+":"
        +String(detik).padStart(2,'0');

    }

},1000);

// ==========================
// REALTIME SENSOR
// ==========================

function loadRealtime(){

    fetch('/api/sensor')

    .then(res => res.json())

    .then(data =>{

        // suhu
        document.getElementById("suhu").innerHTML =
            data.suhu + " °C";

        // kelembapan
        document.getElementById("kelembapan").innerHTML =
            data.kelembapan + " %";

        // heater
        document.getElementById("heater").innerHTML =
            data.heater;

    });


    // motor

    fetch('/api/kontrol')

    .then(res=>res.json())

    .then(data=>{

        document.getElementById("motorStatus").innerHTML =
            data.motor;

    });

}

// jalankan setiap 3 detik
setInterval(loadRealtime,3000);

// pertama kali halaman dibuka
loadRealtime();

</script>

@endsection