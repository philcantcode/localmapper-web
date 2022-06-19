<?php 
  head(tab: "Creator", pdir: "Capabilities");
?>

<div id="raw">

</div>

<hr></hr>

<div id="jsonHTML">

</div>

<script type="text/javascript">

$(document).ready(function () 
{
    $.ajax(
    {
        url: "<?php echo $GLOBALS['server']; ?>" + "/capability/get/new",
        type: "POST",
        success: function (response) 
        {
            response = JSON.parse(response);
            $("#jsonHTML").html(jsonToHtml(response));
            $("#raw").text(JSON.stringify(response));
        }
    });

    //Pass a JSON.parse result to parse it into a list
    function jsonToHtml(json, value)
    {
        var html = "";

        switch (jQuery.type(json))
        {
            case "array":
                html += "<ul>";

                $.each(json, function(index, jArrItem)
                {
                    html += jsonToHtml(jArrItem);
                });

                html += "</ul>";
                return html;
                break;
            case "object":
                html += "<ul>";

                $.each(Object.keys(json), function(index, jObjKey)
                {
                    key = jObjKey;
                    val = json[jObjKey];

                    html += jsonToHtml(key, val);
                });

                html += "</ul>";
                return html;
                break;
            case "string":
            case "boolean":
                if (typeof value == "undefined")
                {
                    return inRow(json);
                }

                if (typeof value == "string")
                {
                    return "<li>" + inGroup(json, value) + "</li>";
                }
                
                return "<li><h3>" + arrayTitle(json) + "</h3>" + jsonToHtml(value) + "</li>";

                break;
        }

        return html;
    }
    
    // For Key:Value pairs
    function inGroup(key, val)
    {
        return `
            <div class='mb-2'>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">` + key +`</div>
                    </div>
                <input type="text" class="form-control" id="" value="` + val + `">
                <div class="input-group-append">
                </div>
            </div>
        `;
    }

    // For single values
    function inRow(val)
    {
        return  `
            <div class='mb-2'>
                <div class="input-group">   
                    <input type="text" class="form-control" id="" value="` + val + `">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        `;
    }

    // For array titles
    function arrayTitle(title)
    {
        return `
            <h3>` + title + `
                <button type="button" class="btn btn-success btn-sm">New Item</button>
            </h3>
        `;
    }
});

</script>

<?php foot(); ?>