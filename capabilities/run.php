<?php 
head(tab: "Capabilities", pdir: "Overview");

$jsonf = file_get_contents($GLOBALS['server'] . "/capability/get");
$json = json_decode($jsonf, true);

foreach ($json as $cap)
{
    ?>

    <div class='row'> 
        <div class='card'>
            <div class='row'>
                <div class='card-body'>
                    <h5 class='card-title'><?php echo $cap["Name"]; ?> <span class="filter badge bg-primary text-white"><?php echo $cap["ID"]; ?></span></h5> 
                    <p><?php echo $cap["Desc"]; ?></p>
                    <div id='json-area'></div>                    
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

    $( document ).ready(function() 
    {
        var myjson = JSON.parse('<?php echo $jsonf; ?>');
        var opt = { 
            change: function(data) { /* called on every change */ },
            propertyclick: function(path) { /* called when a property is clicked with the JS path to that property */ }
        };

        /* opt.propertyElement = '<textarea>'; */ // element of the property field, <input> is default
        /* opt.valueElement = '<textarea>'; */  // element of the value field, <input> is default
        $('#json-area').jsonEditor(myjson, opt);
        
      });
    </script>

    <?php

    break;
}

foot(); ?>