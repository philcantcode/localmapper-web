<?php 
    head(tab: "Discovery Jobs", pdir: "CMDB");

    $json = file_get_contents($GLOBALS['server'] . "/jobs/get-all");
    $json = json_decode($json, true);

    foreach ($json as $job)
    {
        echo "
            <div class='row'>
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>Job Specification #" . $job["JobID"] . " - " . $job["Name"] . "</h5>
                        <p>" . $job["Description"] . "</p>

                        <div class='progress'>
                            <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' style='width: 33%' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100'></div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }

foot(); ?>