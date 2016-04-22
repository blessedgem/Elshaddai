$(document).ready(function(){
    generateFunction();
    createTable($(".selected"), ["Selected Columns"], [], 'selection_table');
    createTable($(".conditions"), ["Selected Conditions"], [], "conditions_table");
    
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
        
        var split = $('#filt_drop').val().split("'");
        var operand = split[0];
        
        if(split.length > 1)
        {
            $('#fput_0').val() ? $('#fput_0').val("'" + split[1] + $('#fput_0').val() + split[1] + "'") : "";
            $('#fput_1').val() ? $('#fput_1').val("'" + split[1] + $('#fput_1').val() + split[1] + "'") : "";
        }
        
        var queried = $('#col_drop').val() + " " + operand + ($('#fput_0').val() ? " " + $('#fput_0').val() : "") + 
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
    var placehoder;
    var field = "text";
    
    switch(type) 
    {
        case "date":
        case "timestamp with time zone":
            filters = ["", "Not Null", "On", "Before", "After", "Between"];
            operands = ["is null", "is not null", "= '", "< '", "> '", ">= '"];
            placehoder = 'YYYY-MM-DD';
            field = "date";
            break;
        case "int":
        case "integer":
        case "numeric":
            filters = ["", "Not Null", "Equal To", "Less Than", "Greater Than", "Between"];
            operands = ["is null", "is not null", "=", "<", ">", ">="];
            placehoder = 'Enter number';
            break;
        case "string":
        case "text":
        case "varchar":
        case "character varying":
            filters = ["", "Not Null", "Contains", "Exactly"];
            operands = ["is null", "is not null", "like '%", "= '"];
            placehoder = 'Enter text';
            break;
        case "boolean":
            filters = ["", "Not Null", "Yes", "No"];
            operands = ["is null", "is not null", "is true", "is false"];
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
            field_inputs = index == 5 ? 2 : (index == 0 || index == 1 ? 0 : 1);
            for (var i = 0; i < conditionsCounter; i++) 
            {
                form.find(":last").remove();
            }

            conditionsCounter = 0;
            for (var i = 0; i < field_inputs; i++) 
            {
                if (type === 'boolean') continue;
                var text_input = $("<input/>").css('marginRight', '30px');
                text_input.attr("placeholder", placehoder);
                text_input.attr("id", 'fput_' + i);
                text_input.attr("type", field);
                form.append(text_input);
                conditionsCounter++;
            };
        });

        container.append(option);
    });
}

function createTable(container, header, data, id, footer) 
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
    
    if(footer === true)
    {
        var foot = $("<tfoot/>");
        var row = $("<tr/>");
        $.each(header, function(colIndex, c) 
        { 
            var cell = $("<th/>");
            row.append(cell);
        });
        foot.append(row);
        table.append(foot);
    }
    
    table.on('scroll', function () {
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
    getConditions();
    $(".anotherfield").html('');
    createTable($(".anotherfield"), colNames, [], "data_table", true);
    
    $("#data_table").addClass('stripe');
    $('#data_table').DataTable({
        "lengthMenu": [[10, 15, 20], [10, 15, 20]],
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "ssp.php",
            "type": "POST",
            "data": {
                cols: cols,
                where: cond,
                host: dbHost,
                password: dbPass,
                username: dbUser,
                databasename: db,
                tablename: dbTable,
                databasetype: dbType,
                columnNames: $.extend({}, colNames)
            }
        },
        "language": {
            "lengthMenu": "Display _MENU_ entries per page",
            "infoEmpty": "No records available",
            "zeroRecords": "Nothing found",
        }
    });

    $('#data_table tfoot th').each(function(){
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    });

    var table = $('#data_table').DataTable();
    table.columns().every( function (){
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function (){
            if ( that.search() !== this.value ){
                that.search( this.value ).draw();
            }
        });
    });
}

function getConditions()
{
    cols = "";
    cond = "";
    dummy = "";
    colNames = [];
    
    
    if(selectedColumns != '')
    {
        for (var key in selectedColumns)
        {
            cols = key == 0 ? cols : cols + ", ";
            dummy = key == 0 ? dummy : dummy + ", ";
            cols = cols + columnNames[selectedCols[key]];
            colNames.push(columnNames[selectedCols[key]]);
            dummy = dummy + columnNames[selectedCols[key]] + " " + dataTypes[selectedCols[key]] ;
        }
    }
    
    else
    {
        for (var key in columnNames)
        {
            cols = key == 0 ? cols : cols + ", ";
            dummy = key == 0 ? dummy : dummy + ", ";
            cols = cols + columnNames[key];
            colNames.push(columnNames[key]);
            dummy = dummy + columnNames[key] + " " + dataTypes[key] ;
        }
    }
    
    for (var key in conditions)
    {
        cond = key == 0 ? cond : cond + " and ";
        cond = cond + conditions[key];
    }
    cond = cond == '' ? "" : "(" + cond + ")";
}

function exportTable()
{
    $(".mask").show();
    $("#export_popup").show("slow");
    $("#export_popup").find(":button").remove();
    $("#export_popup").find(".form-horizontal").remove();
    
    var form = $("<form/>");
    form.addClass('form-horizontal');
    
    form.append("\n\
        <div class='form-group' style='margin-top:50px'>\n\
            <label for='name' class='col-sm-2 control-label'>Database Driver</label>\n\
            <div class='col-sm-10'>\n\
                <select  name=databasetype>\n\
                    <option value='hadoop'>Hadoop</option>\n\
                    <option value='postgresql'>Postgresql</option>\n\
                    <option value='mysql'>Mysql</option>\n\
                </select>\n\
            </div>\n\
        </div>\n\
        <div class='form-group'>\n\
            <label for='ip' class='col-sm-2 control-label'>Local Host IP</label>\n\
            <div class='col-sm-10'>\n\
                <input type='text' class='form-control' id='host' name='localhost' placeholder='host' value=''>\n\
            </div>\n\
        </div>\n\
        <div class='form-group'>\n\
            <label for='ip' class='col-sm-2 control-label'>Virtual Host IP</label>\n\
            <div class='col-sm-10'>\n\
                <input type='text' class='form-control' id='host' name='virtualhost' placeholder='host' value=''>\n\
            </div>\n\
        </div>\n\
        <div class='form-group'>\n\
            <label for='name' class='col-sm-2 control-label'>Directory Name</label>\n\
            <div class='col-sm-10'>\n\
                <input type='text' class='form-control' id='dirname' name='dirname' placeholder='directory name' value=''>\n\
            </div>\n\
        </div>\n\
        </div>\n\
    ");
    $("#export_popup").append(form);
    $("#export_popup").append("<button onclick=exporter() class='btn btn-primary' style='margin-left:55px'>Export</button>");
}

function exporter()
{
    $.ajax({
        type: "POST",
        data: {
            cols: cols,
            where: cond,
            graph: true,
            host: dbHost,
            dummy: dummy,
            password: dbPass,
            username: dbUser,
            databasename: db,
            tablename: dbTable,
            databasetype: dbType,
            dirname: $('[name="dirname"]').val(),
            localhost: $('[name="localhost"]').val(),
            virtualhost: $('[name="virtualhost"]').val(),
            export_databasetype: $('[name="databasetype"]').val(),
        },
        url: "addJob.php",
        dataType: "html",
        async: false,
        success: function(data) {
            alert('me');
        }
    });
}

function generateGraph()
{
    $(".mask").show();
    $("#graph_popup").show("slow");
}

