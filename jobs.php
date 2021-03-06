<?php 
  head(tab: "Running Jobs", pdir: "Overview");

  $stats = loadJSON("/capability/jobs/get/stats", true);
  $dtGraph = $stats["TimeGraph"]; 
  $jtGraph = $stats["TypeGraph"]; 
  $lifecycleJobs = $stats["LifecycleJobs"];
?>

<div class="row">
    <div class="col-8" style="padding-left:0">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Running Jobs</h5>
                <div class=""><canvas id="lineChart" style="max-height: 300px;"></canvas></div>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card" style="padding-right:0">
            <div class="card-body">
                <h5 class="card-title">Job Types</h5>
                <div id="pieChart" style="min-height: 300px;" class="echart"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    new Chart(document.querySelector('#lineChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_slice($dtGraph["Keys"], -100)); ?>,
            datasets: [{
                label: 'Dates Observed',
                data: <?php echo json_encode(array_slice($dtGraph["Values"], -100)); ?>,
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.6,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    display: false
                }
            },
            ticks: {
                autoSkip: true,
                maxTicksLimit: 10
            },
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    echarts.init(document.querySelector("#pieChart")).setOption({
    tooltip: {
        trigger: 'item'
    },
    legend: {
    },
    series: [{
        name: 'Access From',
        type: 'pie',
        radius: ['40%', '70%'],
        avoidLabelOverlap: false,
        label: {
        show: false,
        position: 'center'
        },
        emphasis: {
        label: {
            show: true,
            fontSize: '18',
            fontWeight: 'bold'
        }
        },
        labelLine: {
        show: false
        },
        data: <?php echo str_replace(array("Value", "Name"), array("value", "name"), json_encode($jtGraph)); ?>
    }]
    });
});
</script>

<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Running Jobs</h5>
            <p>List of currently running jobs</p>

            <!-- Table with stripped rows -->
            <table class="table datatable">
                <thead>
                    <tr>
                        <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">ID</a></th>
                        <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Description</a></th>
                        <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Duration</a></th>
                        <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Status</a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $json = array_reverse($lifecycleJobs);
                        
                        foreach($json as $row)
                        {
                            if ($row["Tracking"]["Status"] == "DONE") {
                                continue;
                            }

                            echo "
                                <tr>
                                    <td>" . $row["Tracking"]["ID"] . "</td>
                                    <td>" . $row["Capability"]["Label"] . "<br><p class='text-wrap text-muted small pt-2 ps-1'>" . $row["Tracking"]["Command"] . "</p>" . "</td>
                                    <td>" . $row["Tracking"]["RuntimeDurationPrint"] . "</td>";

                            if ($row["Tracking"]["Status"] == "EXECUTING") 
                                echo "<td>" . $row["Tracking"]["Status"] . " (" . $row["Tracking"]["ExecDurationPrint"] . ")</td>";
                            else
                                echo "<td>" . $row["Tracking"]["Status"] . "</td>";

                            echo "
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Job History</h5>
            <p>List if previously ran jobs</p>

            <!-- Table with stripped rows -->
            <table class="table datatable">
                <thead>
                    <tr>
                        <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">ID</a></th>
                        <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Description</a></th>
                        <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Duration</a></th>
                        <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Status</a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $json = array_reverse($lifecycleJobs);
                        
                        foreach($json as $row)
                        {
                            if ($row["Tracking"]["Status"] != "DONE") 
                            {
                                continue;
                            }

                            echo "
                                <tr>
                                    <td>" . $row["Tracking"]["ID"] . "</td>
                                    <td>" . $row["Capability"]["Label"] . "<br><p class='text-wrap text-muted small pt-2 ps-1'>" . $row["Tracking"]["Command"] . "</p>" . "</td>
                                    <td>" . $row["Tracking"]["RuntimeDurationPrint"] . "</td>";

                            if ($row["Tracking"]["Status"] == "EXECUTING") 
                                echo "<td>" . $row["Tracking"]["Status"] . " (" . $row["Tracking"]["ExecDurationPrint"] . ")</td>";
                            else
                                echo "<td>" . $row["Tracking"]["Status"] . "</td>";

                            echo "
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<?php foot(); ?>