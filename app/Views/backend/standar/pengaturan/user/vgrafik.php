<canvas id="myChart" class="d-none d-sm-block" height="114"></canvas>
<canvas id="myChartMob" class="d-block d-sm-none" height="180"></canvas>
<!-- <canvas id="pie-ecart" class="d-none d-sm-block" height="114"></canvas> -->
<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />
<?php

$tanggal = "";
$jumlah = "";


foreach ($grafik as $row) :
    $tgl        = mediumdate_indo($row->tgl);
    $tanggal .= "'$tgl'" . ",";
    $jml    = $row->jumlah;
    $jumlah .= "'$jml'" . ",";
// $tahun .= "'$tgl'" . ",";
endforeach;
?>

<script>
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?= $tanggal ?>],

            datasets: [{
                label: 'Jumlah Kunjungan',

                data: [<?= $jumlah ?>],
                backgroundColor: [

                    'rgba(0, 99, 132, 0.6)',
                    'rgba(20, 99, 132, 0.6)',
                    'rgba(40, 99, 132, 0.6)',
                    'rgba(60, 99, 132, 0.6)',
                    'rgba(80, 99, 132, 0.6)',
                    'rgba(100, 99, 132, 0.6)',
                    'rgba(120, 99, 132, 0.6)',
                    'rgba(140, 99, 132, 0.6)',
                    'rgba(160, 99, 132, 0.6)',
                    'rgba(180, 99, 132, 0.6)',

                    'rgba(200, 99, 132, 0.6)',
                    'rgba(220, 99, 132, 0.6)',
                    'rgba(240, 99, 132, 0.6)',
                    'rgba(260, 99, 132, 0.6)',
                    'rgba(280, 99, 132, 0.6)',
                    'rgba(300, 99, 132, 0.6)',
                    'rgba(320, 99, 132, 0.6)',
                    'rgba(340, 99, 132, 0.6)',
                    'rgba(360, 99, 132, 0.6)',
                    'rgba(280, 99, 132, 0.6)',

                ],
                borderColor: [
                    'rgba(0, 99, 132, 1)',
                    'rgba(20, 99, 132, 1)',
                    'rgba(40, 99, 132, 1)',
                    'rgba(60, 99, 132, 1)',
                    'rgba(80, 99, 132, 1)',
                    'rgba(100, 99, 132, 1)',
                    'rgba(120, 99, 132, 1)',
                    'rgba(140, 99, 132, 1)',
                    'rgba(160, 99, 132, 1)',
                    'rgba(180, 99, 132, 1)',

                    'rgba(200, 99, 132, 1)',
                    'rgba(220, 99, 132, 1)',
                    'rgba(240, 99, 132, 1)',
                    'rgba(260, 99, 132, 1)',
                    'rgba(280, 99, 132, 1)',
                    'rgba(300, 99, 132, 1)',
                    'rgba(320, 99, 132, 1)',
                    'rgba(340, 99, 132, 1)',
                    'rgba(360, 99, 132, 1)',
                    'rgba(380, 99, 132, 1)',

                ],
                borderWidth: 0
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Grafik Kunjungan",
                fontSize: 16,
                fontColor: "#111"
            },
            legend: {
                display: false,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 12
                }
            }
        }
    });
</script>


<script>
    var ctx = document.getElementById('myChartMob');
    var myChartMob = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?= $tanggal ?>],

            datasets: [{
                label: 'Jumlah Kunjungan',

                data: [<?= $jumlah ?>],
                backgroundColor: [

                    'rgba(102, 205, 170,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',

                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',

                ],
                borderWidth: 0
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Grafik Kunjungan",
                fontSize: 16,
                fontColor: "#111"
            },
            legend: {
                display: false,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 12
                }
            }
        }
    });
</script>