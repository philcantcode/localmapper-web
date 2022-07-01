<?php 
  head(tab: "Pending Devices", pdir: "CMDB");
?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Devices</h5>
                    <p>These devices are pending input to the CMDB. They were discovered as a result of a scan. Please approve or deny them.</p>

                    <!-- Table with stripped rows -->
                    <table class="table datatable" style="table-layout: fixed; word-wrap: break-word;">
                        <thead>
                            <tr>
                                <th scope="col" data-sortable=""><a href="#" style="width:25%" class="dataTable-sorter">Label / ID</a></th>
                                <th scope="col" data-sortable=""><a href="#" style="width:15%" class="dataTable-sorter">Date Seen</a></th>
                                <th scope="col" data-sortable=""><a href="#" style="width:25%" class="dataTable-sorter">Features</a></th>
                                <th scope="col" data-sortable=""><a href="#" style="width:15%" class="dataTable-sorter">Actions</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $json = loadJSON("/cmdb/pending/get/all", true);
                            $json = array_reverse($json);
                            
                            foreach($json as $row)
                            {
                                echo "
                                    <tr>
                                    <td><a href='" . inventoryURL($row['ID']) . "'>" . $row["Label"] . "</a>
                                        <br><span class='text-muted small pt-2 ps-1'>" . $row["ID"] . "</span>
                                    </td>
                                    <td><ul>";


                                    foreach (array_slice($row["DateSeen"], -3) as $date)
                                    {
                                        echo "<li>" . $date . "</li>";
                                    }
                                    
                                    echo "</ul></td> 
                                    <td>";
                                        foreach ($row["SysTags"] as $tag)
                                        {
                                            foreach ($tag["Values"] as $value)
                                            {
                                                echo "<span class='badge mx-1 bg-primary'>" . $value . "</span>";
                                            }
                                        }
                                    echo "</td>
                                        <td><button data-entry-id='" . $row["ID"] . "' type='button' class=' approve-pending btn btn-success btn-sm'>Approve</button>
                                        <button data-entry-id='" . $row["ID"] . "' type='button' class='deny-pending btn btn-danger btn-sm'>Deny</button</td>
                                    </tr>
                                ";
                            }
                              ?>
                        </tbody>
                    </table>

                    <button id='deny-all-pending' type='button' class='btn col-12 mt-5 btn-danger btn-sm'>Deny All</button>
                </div>

            </div>
            <!-- End Table with stripped rows -->

        </div>
    </div>

    </div>
    </div>
</section>

<script type="text/javascript">
  $(document).ready(function () {
    $(".approve-pending").click(function () 
    {
        var id = $(this).attr("data-entry-id");
        console.log(".approve-penidng: " + id);

        $.ajax(
        {
            url: "<?php echo $GLOBALS['api']; ?>" + "/cmdb/pending/approve",
            type: "POST",
            data: {
            "ID": id,
            },
            success: function (response) {
                console.log(response);
            }, error: function (response) {
                console.log("ERR: " + response);
            },
        });
    });

    $(".deny-pending").click(function () 
    {
        var id = $(this).attr("data-entry-id");
        console.log(".deny-penidng: " + id);

        $.ajax(
        {
            url: "<?php echo $GLOBALS['api']; ?>" + "/cmdb/pending/deny",
            type: "POST",
            data: {
            "ID": id,
            },
            success: function (response) {
                console.log(response);
            }
        });
    });

    $("#deny-all-pending").click(function () 
    {
        console.log("#deny-all-penidng");

        $.ajax(
        {
            url: "<?php echo $GLOBALS['api']; ?>" + "/cmdb/pending/deny/all",
            type: "POST",
            success: function (response) {
                console.log(response);
            }
        });
    });
  });
</script>

<?php foot(); ?>