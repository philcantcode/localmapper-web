<?php 
  head(tab: "Propositions", pdir: "Overview");

  // $ch = curl_init($GLOBALS["server"] . "/propositions/refresh");
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  // curl_exec($ch);

  $json = file_get_contents($GLOBALS['server'] . "/propositions/get-all");
  $json = json_decode($json, true);

  foreach ($json as $prop)
  {
      if ($prop["Status"] != 0) {
          continue;
      }
      
      echo "
      <div class='row'>
          <div class='card'>
            <div class='card-body'>
              <h5 class='card-title'>Proposition #" . $prop["ID"] . " - " . $prop["DateTime"] . "</h5>
              <p>" . $prop["Desc"] . "</p>
      
              <div class='d-flex align-items-start'>
                <div class='nav flex-column nav-pills me-3' id='prop-tab-" . $prop["ID"] . "' role='tablist' aria-orientation='vertical'>
                  <button class='nav-link active' id='prop-info-tab-" . $prop["ID"] . "' data-bs-toggle='pill' data-bs-target='#v-pills-home' type='button' role='tab' aria-controls='v-pills-home' aria-selected='true'>Info</button>
                  <button class='nav-link' id='prop-override-tab-" . $prop["ID"] . "' data-bs-toggle='pill' data-bs-target='#prop-override-content-" . $prop["ID"] . "' type='button' role='tab' aria-controls='prop-override-content-" . $prop["ID"] . "' aria-selected='false'>Override</button>
                </div>
                <div class='tab-content w-100' id='prop-info-content-" . $prop["ID"] . "'>
                  <div class='tab-pane fade show active' id='v-pills-home' role='tabpanel' aria-labelledby='prop-info-tab-" . $prop["ID"] . "'>
                      <div class='input-group mb-3'>
                        <span class='input-group-text'>" . $prop["Predicate"]["Label"] . "</span>
                        <input type='text' class='form-control' id='basic-url' value='" . $prop["Predicate"]["Value"] . "'>
                      </div>
     
                      <div class='row'>
                        <div class='col-12'>
                        <input type='button' class='prop-accept-default-btn btn btn-success float-right' value='Accept Default' data-propID='" . $prop["ID"] . "'></input>
                      </div>
                      </div>
                  </div>
                  <div class='tab-pane fade' id='prop-override-content-" . $prop["ID"] . "' role='tabpanel' aria-labelledby='prop-override-tab-" . $prop["ID"] . "'>
                    <p>Our best guess is that it's one of these values:</p>
                    <div class='input-group mb-3'>
                      <span class='input-group-text'>" . $prop["Predicate"]["Label"] . "</span>
                      <select class='form-select' aria-label='Default select example'>";
                      
                      foreach ($prop["Predicate"]["Options"] as $option)
                      {
                          echo "<option value='" . $option . "'>" . $option . "</option>";
                      }
                      
                      echo "
                      </select>
                      <input type='button' class='btn btn-success float-right' value='Update'></input>
                    </div>

                    <p>Alternatively, input your own value (make sure it's of the same data type):</p>
                    <div class='input-group mb-3'>
                      <span class='input-group-text'>" . $prop["Predicate"]["Label"] . "</span>
                      <input type='text' class='form-control' id='basic-url'>
                      <input type='button' class='btn btn-success float-right' value='Update'></input>
                    </div>
                  </div>
                </div>
              </div>              
            </div>
          </div>
      </div>";
  }
?>

<script type="text/javascript">

$( document ).ready(function() 
{
    $(".prop-accept-default-btn").click(function() 
    {
        var propID = $(this).attr("data-propID");

        $.ajax(
        {
            url: "<?php echo $GLOBALS['server']; ?>" + "/propositions/accept-defaults",
            type: "POST",
            data: {
              ID: propID,
            },
            success: function(response) 
            {
                conslole.log(response);
            }
        });
    });
});

</script>

<?php foot(); ?>