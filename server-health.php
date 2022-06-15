<?php 
  head(tab: "Server Health", pdir: "Overview");
?>

<section class="section dashboard">

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">System Info <span>| Operating System</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-laptop"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                    <?php
                                        $json = file_get_contents($GLOBALS['server'] . "/local/get-os-info");
                                        $json = json_decode($json);

                                        echo $json -> {"OS"};
                                    ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">System Info <span>| Architecture</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bounding-box"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                    <?php
                                        $json = file_get_contents($GLOBALS['server'] . "/local/get-os-info");
                                        $json = json_decode($json);

                                        echo $json -> {"Architecture"};
                                    ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">System Info <span>| Time</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php
                                        $json = file_get_contents($GLOBALS['server'] . "/local/get-date-time");
                                        $json = json_decode($json);

                                        echo $json -> {"HHMMSS"};
                                    ?>
                                    </h6>
                                    <span class="text-muted small pt-2 ps-1">   
                                    <?php
                                        $json = file_get_contents($GLOBALS['server'] . "/local/get-date-time");
                                        $json = json_decode($json);

                                        echo $json -> {"DDMMYYYY"};
                                    ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Network Info <span>| Default IP</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-broadcast-pin"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php
                                        $json = file_get_contents($GLOBALS['server'] . "/cmdb/inventory/get/local");
                                        $json = json_decode($json, true);

                                        // If the IP is uninitialised, link to the propositions page
                                        if (searchByLabel("IP", $json["SysTags"]) == null)
                                            echo "<a href='" . $GLOBALS['web'] . "/propositions.php'><span><i class='bi bi-arrow-right-circle-fill'></i> Uninitialised</span></a>";
                                        else
                                            echo searchByLabel("IP", $json["SysTags"])["Values"][0];
                                    ?>
                                    </h6>
                                    <span class="text-muted small pt-2 ps-1">   
                                    <?php
                                        $json = file_get_contents($GLOBALS['server'] . "/local/get-default-ip-gateway");
                                        $json = json_decode($json);

                                        echo "Default Gateway: "  . $json -> {"DefaultGateway"};
                                    ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Network Adapters</h5>
                    <p>A list of all network adapters on the server.</p>

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">IP Address</th>
                                <th scope="col">Tags</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                $json = file_get_contents($GLOBALS['server'] . "/local/get-network-adapters");
                $json = json_decode($json, true);
                $count = 1;
                
                foreach($json as $adapter) 
                {
                    echo "
                        <tr>
                        <td>" . $count++ . "</td>
                        <td>" . $adapter["Name"] . "</td>
                        <td>" . $adapter["IP"] . "<br><span class='text-muted small pt-2 ps-1'>" . $adapter['MAC'] . "</span></td>
                        <td></td>
                        <td></td>
                        </tr>
                    ";
                }
            ?>
                        </tbody>
                    </table>
                    <!-- End Tables without borders -->

                </div>
            </div>
        </div>
    </div>

    <?php foot(); ?>