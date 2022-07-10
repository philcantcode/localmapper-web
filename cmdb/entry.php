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
                                    <?php echo $json["Description"]; ?>
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
        <h5 class="card-title">Metadata & Logs</h5>
        
        <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="systags-tab" data-bs-toggle="tab" data-bs-target="#bordered-systags" type="button" role="tab" aria-controls="systags" aria-selected="true">System Tags</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="logs-tab" data-bs-toggle="tab" data-bs-target="#bordered-logs" type="button" role="tab" aria-controls="logs" aria-selected="false">Logs</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
            </li>
        </ul>

        <div class="tab-content pt-2" id="borderedTabContent">
            <div class="tab-pane fade show active" id="bordered-systags" role="tabpanel" aria-labelledby="systags-tab">
                <p>This list of tags is system managed and cannot be edited by the user.</p>
                <table id="systags-table" class="table datatable">
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
                                <td>" . $tag["Description"] . "</td>
                                <td>" . $tag["DataType"] . "</td>";
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
            <div class="tab-pane fade" id="bordered-logs" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Load associated logs</h5>
                                <form>
                                    <button id="nmap-logs" class="btn btn-sm btn-primary mt-1" type="button">Load NMAP Logs</button>
                                    <button id="all-logs" class="btn btn-sm btn-primary mt-1" type="button">Load All Logs</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Results</h5>
                                <table id="log-table" class="table datatable small">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Result</a></th>
                                        </tr>
                                    </thead>
                                    <tbody id="log-results">
      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="bordered-contact" role="tabpanel" aria-labelledby="contact-tab">
            Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
            </div>
        </div>
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
                $caps = loadJSON("/compatability/get/capabilities/" . $id, true);

                foreach($caps as $cap)
                {
                    echo '
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ac-cap-' . $count . '">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ac-cap-itm-' . $count . '" aria-expanded="false" aria-controls="ac-cap-itm-' . $count . '">
                            ';

                            if ($cap["Category"] == "DISCOVERY") {
                                echo $cap["Label"];
                            }
                            else {
                                echo $cap["Label"] . '<span style="margin-left:10px;" class="badge bg-danger">' . $cap["Category"] . '</span>';
                            }

                            echo '</button>
                        </h2>
                        <div id="ac-cap-itm-' . $count . '" class="accordion-collapse collapse" aria-labelledby="ac-cap-' . $count . '" data-bs-parent="#capability-accordion">
                            <div class="accordion-body">
                                <p><b>' . $cap["Description"] . '</b></p>';

                            foreach ($cap["Command"]["Params"] as $param)
                            {
                                if ($param["Options"] != null) 
                                {
                                    echo "<p class='mt-3'><span class='badge bg-success'>Option</span> Please select one of the following " . $param["Description"] . "</p>";

                                    echo '
                                    <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Label</a></th>
                                            <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Value</a></th>
                                            <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">File Size</a></th>
                                            <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Risk Level</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>';    

                                    $count = 0;
                                    foreach ($param["Options"] as $opt)
                                    {
                                        echo "<tr class='small'>";

                                        echo '
                                            <td class="opt-id" name="' . $count . '">
                                                <div class="form-check">
                                                    <input class="form-check-input param-opt" type="radio" name="' . $param["Flag"] . '" id="' . $param["Flag"] . $count . '">
                                                    <label class="form-check-label" for="' . $param["Flag"] . $count . '">'
                                                    . $opt["Label"] .
                                                    '</label>
                                                </div>
                                            </td>
                                            <td>' . $opt["Value"] . '</td>
                                            <td>' . $opt["FileSize"] . '</td>
                                            <td>' . $opt["RiskLevel"] .'</td>
                                        ';

                                        echo "</tr>";

                                        $count++;
                                    }
                                    echo '</tbody>
                                </table>
                                    ';
                                }
                            }

                            echo '<div class="d-grid gap-2 mt-3">
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
                                <p>' . $cook["Description"] . '</p>
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
    $(window).on("load", function() {
        logTable = new simpleDatatables.DataTable("#log-table");
        systagsTable = new simpleDatatables.DataTable("#systags-table");

        $(".run-capability").click(function () {
            var capID = $(this).attr("data-capability-id");
            var cmdbID = $(this).attr("data-cmdb-id");

            var options = {};

            $(this).closest(".accordion-item").find(".param-opt").each(function()
            {
                $flag = $(this).attr("name");
                $optID = $(this).closest("tr").find(".opt-id").attr("name");
                $isChecked = $(this).is(':checked');

                console.log("Flag: " + $flag);
                console.log("OptID: " + $optID)
                console.log("IsChecked: " + $isChecked)

                if ($isChecked)
                {
                    options[$flag] = $optID;
                }
            });

            $.ajax(
            {
                url: "<?php echo $GLOBALS['api']; ?>" + "/compatability/run/capabilities/" + cmdbID + "/" + capID,
                type: "POST",
                data: options,
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

        $("#nmap-logs").click(function () 
        {
            loadNmapLogs(`[{"hosts.addresses.addr": "<?php echo searchByLabel('IP', $json['SysTags'])['Values'][0]; ?>"}]`, `[{}]`);
        });

        $("#all-logs").click(function () 
        {
            loadNmapLogs(`[{}]`, `[{}]`);
        });
            
    });

/*
    `[{"args": "nmap -sn --system-dns -oX - 192.168.1.110"}]` //JSON.stringify(Array.from(filter))],
*/
function loadNmapLogs(filter, projection)
{
    $.ajax({
        url: "<?php echo $GLOBALS['api']; ?>" + "/tools/nmap/select-logs",
        type: "POST",
        data: { // must be arrays
            "filter": filter, 
            "projection": projection,
        },
        success: function (response) {
            response = JSON.parse(response);

            // Clear existing table results
            while (logTable.data.length != 0)
            {
                console.log(logTable.data.length); // Current num tables
                logTable.rows().remove();
            }

            // Loop the json array results
            for(let i = 0; i < response.length; i++) 
            {
                row = [];
                row.push(JSON.stringify(response[i]));

                logTable.rows().add(row);
            }

            logTable.refresh();
        }
    });
}
</script>

<?php foot(); ?>