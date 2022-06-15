<?php 
  head(tab: "Overview", pdir: "Settings");
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">System Settings</h5>
        <p>List of systems settings</p>

        <h5 class="card-title">System Restore</h5>
        <div class="mb-2"><button id="factoryreset" type="button" class="btn btn-danger">Execute</button> | Restore to factory settings</div>
        <div class="mb-2"><button id="syssettings" type="button" class="btn btn-danger">Execute</button> | Restore to system settings</div>
        <hr></hr>
        
        <h5 class="card-title">Database Settings</h5>
        <div class="mb-2"><button id="caps" type="button" class="btn btn-danger">Execute</button> | Drop Capabilities Database</div>
        <div class="mb-2"><button id="cmdb" type="button" class="btn btn-danger">Execute</button> | Drop all CMDB Databases</div>
        <div class="mb-2"><button id="cookbook" type="button" class="btn btn-danger">Execute</button> | Drop Cookbooks Database</div>
        <hr></hr>

        <h5 class="card-title">Initialise Settings</h5>
        <div class="mb-2"><button id="fts" type="button" class="btn btn-success">Execute</button> | Perform first time setup</div>
        <div class="mb-2"><button id="initcaps" type="button" class="btn btn-success">Execute</button> | Setup default capabilities</div>
        <hr></hr>

    </div>
</div>

<script type="text/javascript">
  $(document).ready(function () 
  {
    $("#caps").click(function () 
    {
      $.ajax(
        {
          url: "<?php echo $GLOBALS['server']; ?>" + "/capability/utils/restore",
          type: "POST",
          success: function (response) {
            console.log(response);
          }
        });
    });

    $("#cmdb").click(function () 
    {
      $.ajax(
        {
          url: "<?php echo $GLOBALS['server']; ?>" + "/cmdb/utils/restore",
          type: "POST",
          success: function (response) {
            console.log(response);
          }
        });
    });

    $("#syssettings").click(function () 
    {
      $.ajax(
        {
          url: "<?php echo $GLOBALS['server']; ?>" + "/system/utils/restore",
          type: "POST",
          success: function (response) {
            console.log(response);
          }
        });
    });

    $("#factoryreset").click(function () 
    {
      $.ajax(
        {
          url: "<?php echo $GLOBALS['server']; ?>" + "/system/utils/restore",
          type: "POST",
          success: function (response) {
            console.log(response);
          }
        });
    });

    $("#cookbook").click(function () 
    {
      $.ajax(
        {
          url: "<?php echo $GLOBALS['server']; ?>" + "/cookbook/utils/restore",
          type: "POST",
          success: function (response) {
            console.log(response);
          }
        });
    });
  });
</script>

<?php foot(); ?>