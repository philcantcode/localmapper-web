<?php 
    head(tab: 'Feeds', pdir: 'Threat Intel');

    $wordlists = loadJSON('/feeds/get/wordlists', true);

    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'K', 'M', 'G', 'T');   

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
?>

<section class='section dashboard'>

    <div class='row'>
        <div class='col-12'>
            <div class='row'>

                <?php
                
                foreach ($wordlists as $wordlist)
                {
                    echo "
                    <div class='col-4'>
                        <div class='card info-card sales-card'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . $wordlist["Description"] . " <span>| " . formatBytes($wordlist["Size"]) . "</span></h5>

                                <div class='d-flex align-items-center'>
                                    <div class='card-icon rounded-circle d-flex align-items-center justify-content-center'>
                    ";

                    if ($wordlist["Type"] == "Network") 
                    {
                        echo "<i class='bi bi-ethernet'></i>";
                    }
                    else if ($wordlist["Type"] == "Web") 
                    {
                        echo "<i class='bi bi-search'></i>";
                    }
                    else if ($wordlist["Type"] == "Fuzzing") 
                    {
                        echo "<i class='bi bi-megaphone'></i>";
                    }
                    else if ($wordlist["Type"] == "Confirmation") 
                    {
                        echo "<i class='bi bi-check-all'></i>";
                    }

                    echo "
                                    </div>
                                    <div class='ps-3'>
                                        <h6>
                                        " . $wordlist["Label"] . "
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
                }
                ?>
            </div>
        </div>
    </div>

    <?php foot(); ?>