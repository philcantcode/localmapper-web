<?php 
head(tab: "Inventory Entry", pdir: "Inventory");
$id = $_GET["id"];

$json = loadJSON("/cmdb/get/" . $id, true);
$identConf = loadJSON("/cmdb/identity-confidence/get/" . $id, true);
$dtGraph = loadJSON("/cmdb/utils/date-time-graph/get/" . $id, true);  

$json = $json[0];

?>
<div class="row section dashboard">
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Inventory Identity <span>|
                                <?php echo $json["ID"]; ?>
                            </span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-laptop"></i>
                            </div>
                            <div class="ps-3">
                                <h6>
                                    <?php echo $json["Label"]; ?>
                                </h6>
                                <span class="text-muted small pt-2 ps-1">
                                    <?php echo $json["Desc"]; ?>
                                </span>
                            </div>
                        </div>
                        <hr></hr>

                        <p>This is the identity matrix showing the confidence that the system has in tracking the device over time. The average score for this device is <?php echo $identConf["Average"]; ?></p>
                        
                        <div class="row">
                            <div class="col-md-6 col-sm-12"><canvas id="radarChart" style="max-height: 400px;"></canvas></div>
                            <div class="col-md-6 col-sm-12"><canvas id="lineChart" style="max-height: 400px;"></canvas></div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#radarChart'), {
                                    type: 'radar',
                                    data: {
                                        labels: [
                                            'IP',
                                            'Vendor',
                                            'Host Name',
                                            'Operating System',
                                            'MAC',
                                            'Dates Seen',
                                        ],
                                        datasets: [{
                                            label: 'Device Identity Confidence (%)',
                                            data: [
                                                <?php echo $identConf["IP"]; ?>,
                                                <?php echo $identConf["Vendor"]; ?>,
                                                <?php echo $identConf["HostName"]; ?>,
                                                <?php echo $identConf["OS"]; ?>,
                                                <?php echo $identConf["MAC"]; ?>,
                                                <?php echo $identConf["DateSeen"]; ?>,
                                            ],
                                            fill: true,
                                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                            borderColor: 'rgb(255, 99, 132)',
                                            pointBackgroundColor: 'rgb(255, 99, 132)',
                                            pointBorderColor: '#fff',
                                            pointHoverBackgroundColor: '#fff',
                                            pointHoverBorderColor: 'rgb(255, 99, 132)'
                                        }]
                                    },
                                    options: {
                                        elements: {
                                            line: {
                                                borderWidth: 3
                                            }
                                        },
                                        scale: {
                                          
                                                max: 100,
                                                min: 0,
                                                beginAtZero: true,
                                                stepSize: 20,
                                            
                                        }
                                    }
                                });
                            });
                        </script>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#lineChart'), {
                                    type: 'line',
                                    data: {
                                        labels: <?php echo json_encode($dtGraph["Keys"]); ?>,
                                        datasets: [{
                                            label: 'Dates Observed',
                                            data: <?php echo json_encode($dtGraph["Values"]); ?>,
                                            fill: true,
                                            borderColor: 'rgb(75, 192, 192)',
                                            tension: 0.3,
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">System Tags</h5>
        <p>This list of tags is system managed and cannot be edited by the user.</p>
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col" data-sortable="" style="width: 5.50459%;"><a href="#"
                            class="dataTable-sorter">Label</a></th>
                    <th scope="col" data-sortable="" style="width: 18.1651%;"><a href="#"
                            class="dataTable-sorter">Description</a></th>
                    <th scope="col" data-sortable="" style="width: 57.156%;"><a href="#" class="dataTable-sorter">Data
                            Type</a></th>
                    <th scope="col" data-sortable="" style="width: 19.63303%;"><a href="#"
                            class="dataTable-sorter">Values</a></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($json["SysTags"] as $tag)
                {
                    echo "
                        <td>" . $tag["Label"] . "</td>
                        <td>" . $tag["Desc"] . "</td>
                        <td>" . dataType($tag["DataType"]) . "</td>";
                    echo "</ul></td> 
                        <td>";
                            foreach ($tag["Values"] as $val)
                            {
                                echo "<li>" . $val . "</li>";
                            }
                        echo "</td>
                        </tr>
                    ";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>


<?php

// VLAN IP Range Section
if ($json["CMDBType"] == 0)
{
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">VLAN IP Address Definition</h5>
                <p>Update the VLAN definitions here</p>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Low IP</span>
                    <input type="text" class="form-control"
                        value="<?php echo searchByLabel('LowIP', $json['SysTags'])['Values'][0]; ?>">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">High IP</span>
                    <input type="text" class="form-control"
                        value="<?php echo searchByLabel('HighIP', $json['SysTags'])['Values'][0]; ?>">
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-primary btn-sm" type="button">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Execute Capabilities</h5>
                <p>Launch capabilities against this inventory asset</p>
                <div class="accordion accordion-flush" id="capability-accordion">
                <?php
                $count = 0;
                $caps = loadJSON("/capability/get/cmdb-compatible/" . $id, true);

                foreach($caps as $cap)
                {
                    echo '
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ac-cap-' . $count . '">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ac-cap-itm-' . $count . '" aria-expanded="false" aria-controls="ac-cap-itm-' . $count . '">
                            ' . $cap["Name"] . ' 
                            </button>
                        </h2>
                        <div id="ac-cap-itm-' . $count . '" class="accordion-collapse collapse" aria-labelledby="ac-cap-' . $count . '" data-bs-parent="#capability-accordion">
                            <div class="accordion-body">
                                <p>' . $cap["Desc"] . '</p>
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-sm btn-primary run-capability" type="button" data-capability-id="' . $cap['ID'] . '" data-cmdb-id="' . $id . '">Launch</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';

                    $count++;
                }
                ?>
                </div>
            </div>
        </div>  
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Execute Cookbooks</h5>
                <p>Launch cookbooks which are groups of capabilities to perform a larger task</p>
                <div class="accordion accordion-flush" id="cookbook-accordion">
                <?php
                $count = 0;
                $cookbooks = loadJSON("/cookbook/get/all", true);

                foreach($cookbooks as $cook)
                {
                    echo '
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ac-cook-' . $count . '">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ac-cook-itm-' . $count . '" aria-expanded="false" aria-controls="ac-cook-itm-' . $count . '">
                            ' . $cook["Label"] . ' 
                            </button>
                        </h2>
                        <div id="ac-cook-itm-' . $count . '" class="accordion-collapse collapse" aria-labelledby="ac-cook-' . $count . '" data-bs-parent="#cookbook-accordion">
                            <div class="accordion-body">
                                <p>' . $cook["Desc"] . '</p>
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-sm btn-primary run-cookbook" type="button" data-cookbook-id="' . $cook['CCBI'] . '" data-cmdb-id="' . $id . '">Launch</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                    
                    $count++;
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        $(".run-capability").click(function () {
            var capID = $(this).attr("data-capability-id");
            var cmdbID = $(this).attr("data-cmdb-id");

            $.ajax(
            {
                url: "<?php echo $GLOBALS['api']; ?>" + "/capability/run/cmdb-compatible/" + cmdbID + "/" + capID,
                type: "POST",
                success: function (response) {
                    console.log(response);
                }
            });
        });

        $(".run-cookbook").click(function () {
            var cookID = $(this).attr("data-cookbook-id");
            var cmdbID = $(this).attr("data-cmdb-id");

            console.log("Running /cookbook/run/" + cookID + "/" + cmdbID);

            $.ajax(
            {
                url: "<?php echo $GLOBALS['api']; ?>" + "/cookbook/run/" + cookID + "/" + cmdbID,
                type: "POST",
                success: function (response) {
                    console.log(response);
                }
            });
        });
    });
</script>

<?php foot(); ?>