<?php 
  head(tab: "Propositions", pdir: "Overview");

  // $ch = curl_init($GLOBALS["server"] . "/propositions/refresh");
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  // curl_exec($ch);

  file_get_contents($GLOBALS['server'] . "/propositions/refresh");

  $json = file_get_contents($GLOBALS['server'] . "/propositions/get-all");
  $json = json_decode($json, true);

  foreach ($json as $prop)
  {     
      echo "
      <div class='row'>
          <div class='card'>
            <div class='card-body'>
              <h5 class='card-title'>Proposition #" . substr($prop["ID"], -6) . " - " . $prop["DateTime"] . "</h5>
              <p>" . $prop["Description"] . "</p>
      
              <div class='d-flex align-items-start'>
                <div class='nav flex-column nav-pills me-3' id='prop-tab-" . $prop["ID"] . "' role='tablist' aria-orientation='vertical'>
                  <button class='nav-link active' id='prop-info-tab-" . $prop["ID"] . "' data-bs-toggle='pill' data-bs-target='#v-pills-home' type='button' role='tab' aria-controls='v-pills-home' aria-selected='true'>Info</button>
                  <button class='nav-link' id='prop-override-tab-" . $prop["ID"] . "' data-bs-toggle='pill' data-bs-target='#prop-override-content-" . $prop["ID"] . "' type='button' role='tab' aria-controls='prop-override-content-" . $prop["ID"] . "' aria-selected='false'>Override</button>
                </div>
                <div class='tab-content w-100' id='prop-info-content-" . $prop["ID"] . "'>
                  <div class='tab-pane fade show active' id='v-pills-home' role='tabpanel' aria-labelledby='prop-info-tab-" . $prop["ID"] . "'>
                      <div class='input-group mb-3'>
                        <span class='input-group-text'>" . $prop["Predicates"][0]["Label"] . "</span>
                        <input type='text' class='form-control' id='basic-url' value='" . $prop["Predicates"][0]["Value"] . "'>
                        <input type='button' class='prop-accept-default-btn btn btn-success float-right' value='Accept Default' data-propID='" . $prop["ID"] . "' data-propValue='0' data-propType='" . $prop["Type"] . "'></input>
                      </div>
                  </div>
                  <div class='tab-pane fade' id='prop-override-content-" . $prop["ID"] . "' role='tabpanel' aria-labelledby='prop-override-tab-" . $prop["ID"] . "'>
                    <p>Our best guess is that it's one of these values:</p>
                    <div class='input-group mb-3'>
                      <span class='input-group-text'>" . $prop["Predicates"][1]["Label"] . "</span>
                      <select class='form-select' aria-label='Default select example'>";
                      
                      $count = 0;
                      foreach ($prop["Predicates"] as $option)
                      {
                          echo "<option value='" . $count . "'>" . $option["Value"] . "</option>";
                          $count++;
                      }
                      
                      echo "
                      </select>
                      <input type='button' data-propID='" . $prop["ID"] . "' data-propType='" . $prop["Type"] . "' class='btn btn-success float-right alt-select' value='Select'></input>
                    </div>

                    <p>Alternatively, input your own value (make sure it's of the same data type):</p>
                    <div class='input-group mb-3'>
                      <span class='input-group-text'>" . $prop["Predicates"][1]["Label"] . "</span>
                      <input type='text' class='form-control' id='basic-url'>
                      <input type='button' class='btn btn-success float-right' value='Select'></input>
                    </div>
                  </div>
                </div>
              </div>"; 
              
              if ($prop["Evidence"] != null) {
                  foreach ($prop["Evidence"] as $evidence)
                  {
                      echo "<div class='row'>
                        <hr></hr>
                        <h5>" . $evidence["Label"] . "</h5>
                        <p>" . $evidence["Value"] . "</p>
                      </div>";
                  }
              }

            echo "
            </div>
          </div>
      </div>";
  }
?>

<script type="text/javascript">

$(window).on("load", function()
{
    $(".prop-accept-default-btn").on("click", function() 
    {
        var propID = $(this).attr("data-propID");
        var propValue = $(this).attr("data-propValue"); 
        var propType = $(this).attr("data-propType");
        $url = "<?php echo $GLOBALS['api']; ?>";

        if (propType == "LOCAL_IDENTITY")
        {
            $url += "/propositions/cmdb/resolve/local-identity";
        }

        if (propType == "IP_IDENTITY_CONFLICT")
        {
            $url += "/propositions/cmdb/resolve/ip-conflict";
        }

        $.ajax(
        {
            url: $url,
            type: "POST",
            data: {
              ID: propID,
              Value: propValue,
            },
            success: function(response) 
            {
                console.log(response);
            }
        });
    });

    $(".alt-select").on("click", function() 
    {
        var propID = $(this).attr("data-propID");
        var propValue = $(this).parent('div').find(':selected').val();
        var propType = $(this).attr("data-propType");

        $.ajax(
        {
            url: "<?php echo $GLOBALS['api']; ?>" + "/propositions/cmdb/resolve",
            type: "POST",
            data: {
              ID: propID,
              Value: propValue,
            },
            success: function(response) 
            {
                console.log(response);
            }
        });
    });
});

</script>

<?php foot(); ?>