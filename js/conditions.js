$(document).ready(function(){
    $(".close").click(function(){
        $(".mask").hide();
        $(".popup table").remove();
        $(".popup").hide();
        conditionsCounter = 0;
    });

$("#accept_selection").click(function(){
    $(".mask").hide();
    $(".popup table").remove();
    $(".popup").hide();

    $(".selected table").remove();

    var selection = [];
    selection[0] = ["Selected Columns"] //headers
    for (var i = 0; i <= selectedColumns.length; i++) 
    {
        selection[i + 1] = [selectedColumns[i]];
    };

    createTable($(".selected"), selection, 'selection_table', false);
    });
});

function myFunction() 
{
    $(".mask").show();
    $("#selection_popup").slideToggle("slow");

    data = [];
    data[0] = ["Available Columns", "Selected Columns"] //headers
    for (var i = 0; i <= columns.length; i++) 
    {
        data[i + 1] = [i, selectedColumns[i]];
    };

    createTable($("#selection_popup"), data, "popup_table", true);
}

function myFunction2() 
{
    $(".mask").show();
    $("#conditions_popup").show("slow");
    $("#conditions_popup").find(":input").remove();

    var form = $("<form/>");
    var columns_drop_down = $("<select/>").addClass('drop_margins').css('marginRight', '30px');
    var filter_drop_down = $("<select/>").addClass('drop_margins').css('marginRight', '250px');

    var option = $("<option/>");
    columns_drop_down.append(option);

    $.each(selectedColumns, function(index, value)
    { 
        var option = $("<option/>");
        option.text(columns[value]);
        option.attr("value", value);

        option.click(function()
        {
            filter_drop_down.html("");
            for (var i = 0; i < conditionsCounter; i++) 
            {
                form.find(":last").remove();
            }
            conditionsCounter = 0;
            createFilterDropDown(form, filter_drop_down, dataTypes[value]);
        });

        columns_drop_down.append(option);
    });

    form.append(columns_drop_down);
    form.append(filter_drop_down);

    $("#conditions_popup").append(form);
}

function createFilterDropDown(form, container, type)
{
    var filters;
    var field = "text";

    switch(type) 
    {
        case "date":
            filters = ["", "On", "Before", "After", "Between"];
            field = "date";
            break;
        case "int":
        case "integer":
        case "numeric":
            filters = ["", "Equal To", "Less Than", "Greater Than", "Between"];
            break;
        case "string":
        case "text":
        case "varchar":
        case "character varying":
            filters = ["", "Contains", "Exactly"];
            break;
        case "boolean":
            filters = ["", "Yes", "No"];
            field = "null";
            break;
        default:
            break
    } 

    $.each(filters, function(index, value)
    { 
        var option = $("<option/>");
        option.text(value);
        option.attr("value", index);

        option.click(function(){
            field_inputs = index == 4 ? 2 : (index == 0 ? 0 : 1);
            for (var i = 0; i < conditionsCounter; i++) 
            {
                form.find(":last").remove();
            }

            conditionsCounter = 0;
            for (var i = 0; i < field_inputs; i++) 
            {
                if (type === 'boolean') continue;
                var text_input = $("<input/>").css('marginRight', '30px');
                text_input.attr("type", field);
                form.append(text_input);
                conditionsCounter++;
            };
        });

        container.append(option);
    });
}

function createTable(container, data, id, clicks) 
{
    var table = $("<table/>")
    clicks ? table.addClass('table table-bordered') : null;
    table.attr('id', id);
    $.each(data, function(rowIndex, r) 
    {
        var row = $("<tr/>");
        $.each(r, function(colIndex, c) 
        { 
            var cell = rowIndex == 0 ? $("<th/>") : $("<td/>");
            cell.text(rowIndex == 0 ? c : columns[c]);

            if(clicks)
            {
                cell.click(function(){
                    if(colIndex == 1 || rowIndex == 0) return false;
                    if(selectedFields[cell.html()])
                    {
                        alert(cell.html() + ' already selected');
                        return false;
                    } 
                    selectedFields[cell.html()] = true;
                    selectedColumns.push(c);
                    populateTable(id);
                });
                cell.dblclick(function(){
                    if(colIndex == 0 || rowIndex == 0) return false;
                    selectedColumns.splice(rowIndex - 1 ,1);
                    selectedFields[cell.html()] = false;
                                    populateTable(id);
                });
            }
            row.append(cell);
        });
        table.append(row);
    });
    return container.append(table);
}

function populateTable(id)
{
    var count = 0;
    $('#' + id + ' td').each(function(index, value) {
        if(index % 2 != 1) return true;
        $(this).html(' ');
        $(this).html(columns[selectedColumns[count++]]);
    });	
}



