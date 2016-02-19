$(document).ready(function(){
	$(".close").click(function(){
		$(".mask").hide();
		$(".popup table").remove();
		$(".popup").hide();
		selectedFields = {};
		selectedColumns = [];
	});

	$("#accept_selection").click(function(){
		$(".mask").hide();
		$(".popup table").remove();
		$(".popup").hide();
		selectedFields = {};
		
		$(".selected table").remove();
		
		var selection = [];
	    selection[0] = ["Selected Columns"] //headers
	    for (var i = 0; i <= selectedColumns.length; i++) {
	    	selection[i + 1] = [selectedColumns[i]];
	    };

	    createTable($(".selected"), selection);
	});
});


function myFunction() {
	$(".mask").show();
    $("#selection_popup").slideToggle("slow");

    data = [];
    data[0] = ["Available Columns", "Selected Columns"] //headers
    for (var i = 0; i <= columns.length; i++) {
    	data[i + 1] = [columns[i], ""];
    };

    createTable($("#selection_popup"), data);
}


function myFunction2() {
	$(".mask").show();
    $("#conditions_popup").show("slow");
}


function createTable(container, data) {
    var table = $("<table/>").addClass('table table-bordered');
    $.each(data, function(rowIndex, r) {
        var row = $("<tr/>");
        $.each(r, function(colIndex, c) { 
            var cell = rowIndex == 0 ? $("<th/>") : $("<td/>");
            cell.text(c);
            cell.click(function(){
            	if(colIndex == 1) return false;
            	if(selectedFields[rowIndex])
				{
					alert(cell.html() + ' already selected');
					return false;
				} 
   				selectedColumns.push(cell.html());
   				selectedFields[rowIndex] = true;
 				populateTable();
			});
			cell.dblclick(function(){
            	if(colIndex == 0) return false;
            	selectedColumns.sli;
				populateTable();
			});
            row.append(cell);
        });
        table.append(row);
    });
    return container.append(table);
}


function populateTable(){
	var count = 0;
	$('.table td').each(function(index, value) {
    	if(index % 2 != 1) return true;
		$(this).text(selectedColumns[count++]);
	});	
}



