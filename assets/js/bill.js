function addBillItem() {
    var table = document.getElementById("items_table");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);

    cell1.innerHTML = '<input type="text" name="item_description[]" required>';
    cell2.innerHTML = '<input type="number" name="quantity[]" value="1" min="1" onchange="calcBillTotal()">';
    cell3.innerHTML = '<input type="number" name="unit_price[]" step="0.01" value="0.00" onchange="calcBillTotal()">';
    cell4.innerHTML = '<span class="subtotal">0.00</span>';
    cell5.innerHTML = '<button type="button" onclick="removeBillItem(this)">Remove</button>';
}

function removeBillItem(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    calcBillTotal();
}

function calcBillTotal() {
    var quantities = document.getElementsByName("quantity[]");
    var prices = document.getElementsByName("unit_price[]");
    var subtotals = document.getElementsByClassName("subtotal");
    var total = 0;

    for (var i = 0; i < quantities.length; i++) {
        var qty = parseFloat(quantities[i].value) || 0;
        var price = parseFloat(prices[i].value) || 0;
        var sub = qty * price;
        subtotals[i].innerText = sub.toFixed(2);
        total += sub;
    }

    var discount = parseFloat(document.getElementById("discount").value) || 0;
    var tax = parseFloat(document.getElementById("tax").value) || 0;

    var discountAmount = (total * discount) / 100;
    var afterDiscount = total - discountAmount;
    var taxAmount = (afterDiscount * tax) / 100;
    var finalTotal = afterDiscount + taxAmount;

    document.getElementById("grand_total").innerText = finalTotal.toFixed(2);
}
