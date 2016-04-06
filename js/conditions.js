$(document).ready(function(){
    createTable($(".anotherfield"), columnNames, actData, "data_table");
        
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
        for (var i = 0; i <= selectedColumns.length; i++) 
        {
            selection[i] = [selectedColumns[i]];
        };

        createTable($(".selected"), ["Selected Columns"], selection, 'selection_table');
    });
    
    $("#accept_conditon").click(function(){
        
        if(!$('#col_drop').val() || ($('#filt_drop').val() != '' && $('#fput_0').val() == '') || (($('#filt_drop').val() === '>=' && !$('#fput_1').val()))) 
        {
            alert('seriously?');
            throw new Error("Something went badly wrong!");
        } 
        
        $(".mask").hide();
        $(".popup table").remove();
        $(".popup").hide();
        
        $(".conditions table").remove();
        conditionsCounter = 0;
        
        var queried = $('#col_drop').val() + " " + $('#filt_drop').val() + ($('#fput_0').val() ? " " + $('#fput_0').val() : "") + 
            ($('#fput_1').val() ? " and " + $('#col_drop').val() + " <= " + $('#fput_1').val() : "");
        conditions[conditions.length] = [queried];
        createTable($(".conditions"), ["Selected Conditions"], conditions, "conditions_table");
    });
});

function myFunction() 
{
    $(".mask").show();
    $("#selection_popup").slideToggle("slow");

    data = [];
    for (var i = 0; i <= columns.length; i++) 
    {
        data[i] = [columns[i], selectedColumns[i]];
    };

    createTable($("#selection_popup"), ["Available Columns", "Selected Columns"], data, "popup_table");
}

function myFunction2() 
{
    $(".mask").show();
    $("#conditions_popup").show("slow");
    $("#conditions_popup").find(":input").remove();

    var form = $("<form/>");
    var columns_drop_down = $("<select/>").addClass('drop_margins').css('marginRight', '30px').attr('id', 'col_drop');
    var filter_drop_down = $("<select/>").addClass('drop_margins').css('marginRight', '250px').attr('id', 'filt_drop');

    var option = $("<option/>");
    columns_drop_down.append(option);

    $.each(columnNames, function(index, value)
    { 
        var option = $("<option/>");
        option.text(columns[index]);
        option.attr("value", value);

        option.click(function()
        {
            filter_drop_down.html("");
            for (var i = 0; i < conditionsCounter; i++) 
            {
                form.find(":last").remove();
            }
            conditionsCounter = 0;
            createFilterDropDown(form, filter_drop_down, dataTypes[index]);
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
    var operands;
    var field = "text";
    
    switch(type) 
    {
        case "date":
            filters = ["", "On", "Before", "After", "Between"];
            operands = ["is null", "=", "<", ">", ">="];
            field = "date";
            break;
        case "int":
        case "integer":
        case "numeric":
            filters = ["", "Equal To", "Less Than", "Greater Than", "Between"];
            operands = ["is null", "=", "<", ">", ">="];
            break;
        case "string":
        case "text":
        case "varchar":
        case "character varying":
            filters = ["", "Contains", "Exactly"];
            operands = ["is null", "like", "="];
            break;
        case "boolean":
            filters = ["", "Yes", "No"];
            operands = ["is null", "is true", "is false"];
            break;
        default:
            break
    } 

    $.each(filters, function(index, value)
    { 
        var option = $("<option/>");
        option.text(value);
        option.attr("value", operands[index]);

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
                text_input.attr("id", 'fput_' + i);
                text_input.attr("type", field);
                form.append(text_input);
                conditionsCounter++;
            };
        });

        container.append(option);
    });
}

function createTable(container, header, data, id) 
{
    var table = $("<table/>");
    
    table.attr('id', id);
    table.addClass('table table-bordered');
    
    var head = $("<thead/>");
    var body = $("<tbody/>");
    
    var row = $("<tr/>");
    $.each(header, function(colIndex, c) 
    { 
        var cell = $("<th/>");
        cell.text(c);

        row.append(cell);
    });
    head.append(row);
        
    $.each(data, function(rowIndex, r) 
    {
        var row = $("<tr/>");
        $.each(r, function(colIndex, c) 
        { 
            var cell = $("<td/>");
            cell.text(r[colIndex]);
            
            cell.click(function(){
                manuplateTable(id, cell, 1, rowIndex, colIndex, c);
            });
            
            cell.dblclick(function(){
                manuplateTable(id, cell, 2, rowIndex, colIndex, c);
            });
            
            row.append(cell);
        });
        body.append(row);
    });
    
    table.append(head);
    table.append(body);
    table.on('scroll', function () {
//        $("table > *").width(table.width() + table.scrollLeft());
        $('#' + id + ' > *').width(table.width() + table.scrollLeft());
    });
    return container.append(table);
}

function manuplateTable(id, cell, clicks, rowIndex, colIndex, colVal)
{
    if(clicks === 1 && id === 'popup_table')
    {
        if(colIndex === 1) return false;
        if(selectedFields[cell.html()])
        {
            alert(cell.html() + ' already selected');
            return false;
        } 
        selectedFields[cell.html()] = true;
        selectedCols.push(rowIndex);
        selectedColumns.push(colVal);
        populateTable(id, selectedColumns);
    }
    
    if(clicks === 2 && id === 'popup_table')
    {
        if(colIndex === 0) return false;
        selectedCols.splice(rowIndex , 1);
        selectedColumns.splice(rowIndex , 1);
        selectedFields[cell.html()] = false;
        populateTable(id, selectedColumns);
    };
    
    if(clicks === 2 && id === 'conditions_table')
    {
        conditions.splice(rowIndex , 1);
        $(".conditions table").remove();
        createTable($(".conditions"), ["Selected Conditions"], conditions, "conditions_table");
    }
}

function populateTable(id, data)
{
    var count = 0;
    $('#' + id + ' td').each(function(index, value) {
        if(index % 2 != 1) return true;
        $(this).html('');
        $(this).html(data[count++]);
    });	
}

function generateFunction()
{
    if(selectedColumns == '' && conditions == '')
    {
        alert('No Conditions or Columns set');
        throw new Error("Something went badly wrong!");
    }
    
    var cols = "";
    var cond = "";
    var colNames = [];
    for (var key in selectedColumns)
    {
        cols = key == 0 ? cols : cols + ", ";
        cols = cols + columnNames[selectedCols[key]];
        colNames.push(selectedColumns[key]);
    }
    
    for (var key in conditions)
    {
        cond = key == 0 ? cond : cond + " and ";
        cond = cond + conditions[key];
    }
    
    $.ajax({
        type: "POST",
        data: {
            cols: cols,
            where: cond,
            host: dbHost,
            password: dbPass,
            username: dbUser,
            databasename: db,
            tablename: dbTable,
            databasetype: dbType,
        },
        url: "database.php",
        dataType: "html",
        async: false,
        success: function(data) {
            result = data;
            $(".anotherfield table").remove();
            createTable($(".anotherfield"), colNames == '' ? columnNames : colNames , JSON.parse(result), "data_table");
        }
    });
}