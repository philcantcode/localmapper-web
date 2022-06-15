<?php 
  head(tab: "Logs", pdir: "Overview");
?>


<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Runtime Logs</h5>
                    <p>Server logs</p>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col" data-sortable="" style="width: 5.50459%;"><a href="#" class="dataTable-sorter">#</a></th>
                                <th scope="col" data-sortable="" style="width: 18.1651%;"><a href="#" class="dataTable-sorter">Type</a></th>
                                <th scope="col" data-sortable="" style="width: 57.156%;"><a href="#" class="dataTable-sorter">Context</a></th>
                                <th scope="col" data-sortable="" style="width: 19.63303%;"><a href="#" class="dataTable-sorter">Date</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                        $json = file_get_contents($GLOBALS['server'] . "/system/get-logs");
                                        $json = json_decode($json, true);
                                        $json = array_reverse($json);
                                        $count = sizeof($json);
                                        
                                        foreach($json as $row)
                                        {
                                            echo "
                                                <tr>
                                                <td>" . $count-- . "</td>
                                            ";

                                            if ($row["Type"] == "Info") 
                                            {
                                                echo "<td class='table-light'>" . $row["Type"] . "</td>";
                                            }
                                            else if ($row["Type"] == "Error") 
                                            {
                                                echo "<td class='table-warning'>" . $row["Type"] . "</td>";
                                            }
                                            else if ($row["Type"] == "Fatal") 
                                            {
                                                echo "<td class='table-danger'>" . $row["Type"] . "</td>";
                                            }
                                            
                                            echo "
                                                <td>" . $row["Context"] . "</td>
                                                <td>" . $row["DateTime"] . "</td>
                                                </tr>
                                            ";
                                        }
                                    ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- End Table with stripped rows -->

        </div>
    </div>

    </div>
    </div>
</section>

<?php foot(); ?>