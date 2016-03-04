$(document).ready(function(){
	$(".close").click(function(){
		$(".mask").hide();
		$(".popup table").remove();
		$(".popup").hide();
	});

	$("#accept_selection").click(function(){
		$(".mask").hide();
		$(".popup table").remove();
		$(".popup").hide();
		
		$(".selected table").remove();
		
		var selection = [];
	    selection[0] = ["Selected Columns"] //headers
	    for (var i = 0; i <= selectedColumns.length; i++) {
	    	selection[i + 1] = [selectedColumns[i]];
	    };

	    createTable($(".selected"), selection, 'selection_table', false);
	});
});


function myFunction() {
	$(".mask").show();
    $("#selection_popup").slideToggle("slow");

    data = [];
    data[0] = ["Available Columns", "Selected Columns"] //headers
    for (var i = 0; i <= columns.length; i++) {
    	data[i + 1] = [columns[i], selectedColumns[i]];
    };

    createTable($("#selection_popup"), data, "popup_table", true);
}


function myFunction2() {
	$(".mask").show();
    $("#conditions_popup").show("slow");

    var form = $("<form/>");
    var columns_drop_down = $("<select/>");
    var filter_drop_down = $("<select/>");

    $.each(selectedColumns, function(index, value){ 
    	var option = $("<option/>");
    	option.text(value);
    	option.attr("value", index);
    	option.click(function(){

    	});
    	columns_drop_down.append(option);
    });

    form.append(columns_drop_down);
    form.append(filter_drop_down);

    $("#conditions_popup").append(form);

}


function createTable(container, data, id, clicks) {
    var table = $("<table/>")
    clicks ? table.addClass('table table-bordered') : null;
    table.attr('id', id);
    $.each(data, function(rowIndex, r) {
        var row = $("<tr/>");
        $.each(r, function(colIndex, c) { 
            var cell = rowIndex == 0 ? $("<th/>") : $("<td/>");
            cell.text(c);

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
	   				selectedColumns.push(cell.html());
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


function populateTable(id){
	var count = 0;
	$('#' + id + ' td').each(function(index, value) {
    	if(index % 2 != 1) return true;
    	$(this).html(' ');
		$(this).html(selectedColumns[count++]);
	});	
}



