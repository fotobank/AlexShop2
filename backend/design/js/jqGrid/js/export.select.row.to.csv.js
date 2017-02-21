var exportSelectRowToCVS = function (gridID, filename) {
    var grid = $('#' + gridID),
        rowIDList = grid.getDataIDs(),
        row = grid.getRowData(rowIDList[0]),
        selRowIds = grid.jqGrid('getGridParam', 'selarrrow'), // id выбранных строк
        colDelim = ";",
        rowDelim = "\r\n",
        colNames = [],
        html = "",
        i = 0, col, json,
        obj = {};
    filename = filename.replace('.csv', '') + '.csv';

    // массив имен столбцов
    for (var cName in row) {
        colNames[i++] = cName;
        // если тип "строка" - оборачиваем в кавычки
        html += (isNaN(cName) ? '"' + cName + '"' : cName) + colDelim;
    }
    html = html.slice(0, -1);

    // если чмсло выделенных строк чекбоксов > 0
    if (selRowIds.length > 0) {
        rowIDList = selRowIds;
    }
    html += rowDelim;
    for (var j = 0; j < rowIDList.length; j++) {
        row = grid.getRowData(rowIDList[j]);
        for (i = 0; i < colNames.length; i++) {
            col = row[colNames[i]];
            html += (isNaN(col) ? '"' + col + '"' : col) + colDelim;
        }
        html = html.slice(0, -1);
        html += rowDelim;
    }

    // вывод Data URI
    //this trick will generate a temp "a" tag
    var link = document.createElement("a");
    link.id = "lnkDwnldLnk";
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    var csvData = 'data:application/csv;charset=utf-8,' + '\uFEFF' + encodeURIComponent(html);
    jQuery("#lnkDwnldLnk")
        .attr({
            'download': filename,
            'href': csvData
        });
    jQuery('#lnkDwnldLnk')[0].click();
    document.body.removeChild(link);
};
