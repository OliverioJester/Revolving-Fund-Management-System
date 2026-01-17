import * as XLSX from "xlsx";

function downloadReports() {
    const t1 = document.getElementById("transmitalSlip_reported_unreported").cloneNode(true);
    const t2 = document.getElementById("reported_unreportedTable").cloneNode(true);
    const t3 = document.getElementById("serviceReplenishmentreported_unreported").cloneNode(true);
    const t4 = document.getElementById("categories_reported_unreported").cloneNode(true);
    const t5 = document.getElementById("preparedBy").cloneNode(true);

    // remove columns you don't want
    [t1, t2, t3, t4, t5].forEach(table => {
        table.querySelectorAll(".no-export").forEach(e => e.remove());
    });

    // --- Convert table1 normally ---
    const data1 = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(t1), { header: 1 });

    // --- Convert table2 manually to preserve date strings ---
    const data2 = [];
    const rows2 = t2.querySelectorAll("tr");
    rows2.forEach(tr => {
        const row = [];
        tr.querySelectorAll("td, th").forEach((td, colIndex) => {
            if (colIndex === 1) { 
                // DATE column: force string
                row.push(td.textContent.trim());
            } else {
                row.push(td.textContent.trim());
            }
        });
        data2.push(row);
    });

    // Convert table3 and table4 normally
    const data3 = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(t3), { header: 1 });
    const data4 = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(t4), { header: 1 });
    const data5 = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(t5), { header: 1 });

    // add blank rows between tables
    data1.push([]);
    data2.push([]);
    data3.push([]);
    data4.push([]);

    // --- Position t3 to the right ---
    const t1t2ColCount = Math.max(data1[0].length, data2[0].length);
    const t3ffset = t1t2ColCount + -2;
    const t4ffset = t1t2ColCount + -4;
    const t5ffset = t3ffset + -6;
    const shiftedT3 = data3.map(row => Array(t3ffset).fill("").concat(row));
    const shiftedT4 = data4.map(row => Array(t4ffset).fill("").concat(row));
    const shiftedT5 = data5.map(row => Array(t5ffset).fill("").concat(row));

    // Merge all tables
    const mergedData = data1.concat(data2, shiftedT3, shiftedT5, shiftedT4, );

    // create worksheet
    const ws = XLSX.utils.aoa_to_sheet(mergedData);

    // --- Set column widths dynamically for t2 only ---
    const totalCols = mergedData[0].length;
    const t1Cols = data1[0]?.length || 0;
    const t2Cols = data2[0]?.length || 0;
    const wsCols = Array(totalCols).fill({ wch: 15 });

    for (let i = 0; i < t2Cols; i++) {
        wsCols[t1Cols + i] = { wch: 25 };
    }

    ws['!cols'] = wsCols;

    // create workbook and append sheet
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Report");

    // download
    XLSX.writeFile(wb, "report.xlsx");
}

window.downloadReports = downloadReports;
