$(document).ready(function(){
	$(".close").click(function(){
		$(".mask").hide();
		$(".popup table").remove();
		$(".popup").hide();

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

    var cityTable = createTable($("#selection_popup"), data);
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
            cell.id = "cell_" + rowIndex + "" + colIndex;
            cell.text(c);
            cell.click(function(){
				alert($(this).html());
				alert($("#cell_20").html());
			});
            row.append(cell);
        });
        table.append(row);
    });
    return container.append(table);
}



