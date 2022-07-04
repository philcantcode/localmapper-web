<?php 
  head(tab: "Inventory", pdir: "Overview");
?>

<div class="row">
  <div class="col-lg-12">

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">VLAN Definitions</h5>
        <p>Use this table to define the VLANs on your network.</p>
        <table id="vlan-table" class="table datatable">
          <thead>
            <tr>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Label / ID</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Description</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Low IP</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">High IP</a></th>
            </tr>
          </thead>
          <tbody>
            <?php

            $json = loadJSON("/cmdb/inventory/get/type/0", true);

            foreach($json as $row)
            {
                echo "
                    <tr>
                        <td><a href='" . inventoryURL($row['ID']) . "'>" . $row["Label"] . "<br><span class='text-muted small pt-2 ps-1'>" . $row['ID'] . "</span></a></td>
                        <td>" . $row["Description"] . "</td>
                        <td>" . searchByLabel("LowIP", $row['SysTags'])['Values'][0] . "</td>
                        <td>" . searchByLabel("HighIP", $row['SysTags'])['Values'][0] . "</td>
                    </tr>
                ";
            }
              ?>
          </tbody>
        </table>
        <div class="card">
          <div class="card-body">
            <form class="row g-2">
              <h5 class="card-title">Create New VLAN</h5>
              <p>Specify the following details to create a new VLAN definition.</p>
              <form class="row g-2">
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-text">Label</span>
                    <input id="create-vlan-label" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-text">Description</span>
                    <input id="create-vlan-desc" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-text">Low IP</span>
                    <input id="create-vlan-lowIP" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-text">High IP</span>
                    <input id="create-vlan-highIP" type="text" class="form-control">
                  </div>
                </div>
                <input id="create-vlan" type='button' class='btn btn-success float-right' value='Submit'></input>
              </form>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Server Database</h5>
        <p>This table displays all servers stored in the CMDB.</p>
        <table id="server-table" class="table datatable">
          <thead>
            <tr>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Label / ID</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Description</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">OSI Layer</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">IP / MAC</a></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $json = loadJSON("/cmdb/inventory/get/type/1", true);
            
            foreach($json as $row)
            {
                echo "
                    <tr>
                    <td><a href='" . inventoryURL($row['ID']) . "'>" . $row["Label"] . "<br><span class='text-muted small pt-2 ps-1'>" . $row['ID'] . "</span></a></td>
                        <td>" . $row["Description"] . "</td>
                        <td>" . $row["OSILayer"] . "</td>
                        <td>" . searchByLabel("IP", $row['SysTags'])['Values'][0] . "<br><span class='text-muted small pt-2 ps-1'>" . searchByLabel("MAC", $row['SysTags'])['Values'][0] . "</span></a></td>
                    </tr>
                ";
              }
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Unclassified Devices</h5>
        <p>This table displays all of the unclassified devices (by type) in the CMDB.</p>
        <table id="unclassified-devices-table" class="table datatable">
          <thead>
            <tr>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Label / ID</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">Description</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">OSI Layer</a></th>
              <th scope="col" data-sortable=""><a href="#" class="dataTable-sorter">IP / MAC</a></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $json = loadJSON("/cmdb/inventory/get/type/3", true);
            
            foreach($json as $row)
            {
                echo "
                    <tr>
                    <td><a href='" . inventoryURL($row['ID']) . "'>" . $row["Label"] . "<br><span class='text-muted small pt-2 ps-1'>" . $row['ID'] . "</span></a></td>
                        <td>" . $row["Description"] . "</td>
                        <td>" . $row["OSILayer"] . "</td>
                        <td>" . searchByLabel("IP", $row['SysTags'])['Values'][0] . "<br><span class='text-muted small pt-2 ps-1'>" . searchByLabel("MAC", $row['SysTags'])['Values'][0] . "</span></a></td>
                    </tr>
                ";
              }
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(window).on("load", function() {
        vlanTable = new simpleDatatables.DataTable("#vlan-table");
        unclassifiedTable = new simpleDatatables.DataTable("#unclassified-devices-table");
        serverTable = new simpleDatatables.DataTable("#server-table");
  });

  $(document).ready(function () {
    $("#create-vlan").click(function () {
      var label = $("#create-vlan-label").val();
      var desc = $("#create-vlan-desc").val();
      var lowIP = $("#create-vlan-lowIP").val();
      var highIP = $("#create-vlan-highIP").val();

      $.ajax(
        {
          url: "<?php echo $GLOBALS['api']; ?>" + "/cmdb/pending/put",
          type: "POST",
          data: {
            "Label": label,
            "Description": desc,
            "HighIP": highIP,
            "LowIP": lowIP,
            "CMDBType": "0",
          },
          success: function (response) {
            console.log(response);
          }
        });
    });
  });
</script>

<?php foot(); ?>