<?php 
  head(tab: "Creator", pdir: "Capabilities");
?>

<div id="jsonHTML">

</div>

<script type="text/javascript">

window.onload = function()
{
    console.log("Creating new");

    $.ajax(
    {
        url: "<?php echo $GLOBALS['server']; ?>" + "/capability/get/new",
        type: "POST",
        success: function (response) 
        {
            console.log(response);

            response = JSON.parse(response);
            $("#jsonHTML").html(jsonToHtml(response));
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
                html += `<li><button type="button" class="delete-item mb-2 btn btn-danger btn-sm">Delete Item</button></li>`;

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

                if (typeof value == "string" || typeof value == "boolean")
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
            <div class='mb-2 new-row-created'>
                <div class="input-group">   
                    <input type="text" class="form-control" value="` + val + `">
                    <div class="input-group-append">
                        <button type="button" class="delete-new-row btn btn-danger">Delete</button>
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
                <button type="button" class="create-new-` + title + ` btn btn-success btn-sm">New Item</button>
            </h3>
        `;
    }

    // Create new buttons
    $(document).on("click", ".create-new-Params", function () 
    {
        $caller = $(this);

        $.ajax(
        {
            url: "<?php echo $GLOBALS['server']; ?>" + "/capability/get/new/param",
            type: "POST",
            success: function (response) 
            {
                console.log(response);
                $($caller).closest("li").append(jsonToHtml(JSON.parse(response)));
            }
        });
    });

    $(document).on("click", ".create-new-DisplayFields", function () 
    {
        $(this).closest("li").append(jsonToHtml(""));
    });

    $(document).on("click", ".create-new-ResultTags", function () 
    {
        $(this).closest("li").append(jsonToHtml(""));
    });

    $(document).on("click", ".create-new-DataType", function () 
    {
        $(this).closest("li").append(jsonToHtml(""));
    });
    
    $(document).on("click", ".delete-new-row", function () 
    {
        $(this).closest(".new-row-created").remove();
    });

    $(document).on("click", ".delete-item", function () 
    {
        $(this).closest("ul").remove();
    });
};

</script>

<?php foot(); ?>