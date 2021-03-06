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
        
        <h5 class="card-title">Database Restore</h5>
        <div class="mb-2"><button id="caps" type="button" class="btn btn-danger">Execute</button> | Restore Capabilities Database</div>
        <div class="mb-2"><button id="cmdb" type="button" class="btn btn-danger">Execute</button> | Restore all CMDB & Propositions Databases</div>
        <div class="mb-2"><button id="cookbook" type="button" class="btn btn-danger">Execute</button> | Restore Cookbooks Database</div>
        <hr></hr>

        <h5 class="card-title">Initialise Settings</h5>
        <div class="mb-2"><button id="fts" type="button" class="btn btn-success">Execute</button> | Perform first time setup</div>
        <div class="mb-2"><button id="initcaps" type="button" class="btn btn-success">Execute</button> | Setup default capabilities</div>
        <hr></hr>

    </div>
</div>

<script type="text/javascript">
  $(window).on("load", function()
  {
    $("#caps").on("click", function () 
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

    $("#cmdb").on("click", function () 
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

    $("#syssettings").on("click", function () 
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

    $("#factoryreset").on("click", function () 
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

    $("#cookbook").on("click", function () 
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