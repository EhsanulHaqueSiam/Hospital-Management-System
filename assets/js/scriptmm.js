
const addButton = document.querySelector('.addbtn');
const inventoryTable = document.querySelector('table');

function isValidMedicineText(str) {
    if (str.length === 0) return false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        var isLetter = (ch >= 'a' && ch <= 'z') || (ch >= 'A' && ch <= 'Z');
        var isSpace = (ch === ' ');
        if (!isLetter && !isSpace) return false;
    }
    return true;
}

function isAllDigits(str) {
    if (str.length === 0) return false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        if (ch < '0' || ch > '9') return false;
    }
    return true;
}


function isFloatOrInt(str) {
    if (typeof str != "string") return false;
    return !isNaN(parseFloat(str));
}


function handleAddMedicine() {
    alert("ADDING new medicine.");
}

function initiateEdit(row) {
    for (let i = 1; i <= 4; i++) {
        const cell = row.cells[i];
        if (cell.querySelector('input')) continue;

        const currentText = cell.textContent.trim().replace('tk','');
        const input = document.createElement('input');

        input.type = "text";
        input.value = currentText;
        

        cell.innerHTML = '';
        cell.appendChild(input);
    }

    const editButton = row.querySelector('.edit');
    if (editButton) {
        editButton.textContent = 'EDIT';
        editButton.classList.remove('edit');
        editButton.classList.add('save');
    }

    alert("Editing mood.");
}

function saveEdit(row) {
    let isValid = true;
    let errorMessage = "There is an error:";
 

    for (let i = 1; i <= 4; i++) {
        const cell = row.cells[i];
        const input = cell.querySelector('input');
        if (!input) continue;

        let value = input.value.trim();
        const headerText = row.cells[0].parentNode.cells[i].textContent;
        const headerText1 = row.cells[1].parentNode.cells[i].textContent;
        const headerText2 = row.cells[2].parentNode.cells[i].textContent;
        const headerText3 = row.cells[3].parentNode.cells[i].textContent;

   
        let fieldError = ''; 

        if (value === "") {
            fieldError = "field is required and cannot be blank.", headerText;
        }

   
        else if ((i === 1 || i === 2) && !isValidMedicineText(value)) {
            fieldError = "must contain only alphabetical characters and spaces", headerText1;
        }

      
        else if (i === 3 && !isFloatOrInt(value.replace('tk', ''))) {
            fieldError = "must be a valid number", headerText2;
        }

    
        else if (i === 4 && !isAllDigits(value)) {
            fieldError = "must be a positive whole number (no decimals)", headerText3;
        }

        if (fieldError !== '') {
            isValid = false; 
           
            errorMessage += `${fieldError}`;
        
        }
    }


    if (!isValid) {
        alert(errorMessage);
        return;
    }


    for (let i = 1; i <= 4; i++) {
        const cell = row.cells[i];
        const input = cell.querySelector('input');

        if (input) {
            let finalValue = input.value.trim();

            if (i === 3) {
                finalValue = isFloatOrInt(finalValue) ? finalValue + 'tk' : finalValue;
            }
            cell.textContent = finalValue;
        }
    }

    const saveButton = row.querySelector('.save');
    if (saveButton) {
        saveButton.textContent = 'EDIT';
        saveButton.classList.remove('save');
        saveButton.classList.add('edit');
    }
    row.querySelectorAll('.delete, .restock').forEach(btn => btn.disabled = false);

    alert("Data saved successfully!");
}

function initiateRestock(row) {
    const medicineName = row.cells[1].textContent;
    const currentQuantityText = row.cells[4].textContent;
    const currentQuantity = parseInt(currentQuantityText.replace(''), 10) || 0;

    const restockAmount = prompt(`Restocking ${medicineName}. Enter quantity to add:`, "");

    if (restockAmount !== null) {
        const amountToAdd = parseInt(restockAmount);
        if (isAllDigits(restockAmount) && amountToAdd > 0) {
            const newQuantity = currentQuantity + amountToAdd;
            row.cells[4].textContent = newQuantity;
            alert(`${amountToAdd} added. New Quantity for ${medicineName}: ${newQuantity}`);
        } else if (restockAmount !== "") {
            alert("Invalid quantity entered (must be a positive whole number). Restock cancelled.");
        }
    }
}

function deleteRow(row) {
    const medicineName = row.cells[1].textContent.trim();
    if (confirm(`Action: Are you sure you want to DELETE ${medicineName}? This action cannot be undone.`)) {
        row.remove();
        alert(`SUCCESS: ${medicineName} has been deleted.`);
    }
}

function handleTableAction(event) {
    const target = event.target;

    if (target.tagName === 'BUTTON') {
        const row = target.closest('tr');
        if (!row) return;

        if (target.classList.contains('edit')) {
            initiateEdit(row);
        } else if (target.classList.contains('save')) {
            saveEdit(row);
        } else if (target.classList.contains('delete') && !target.disabled) {
            deleteRow(row);
        } else if (target.classList.contains('restock') && !target.disabled) {
            initiateRestock(row);
        }
    }
}

if (addButton) {
    addButton.addEventListener('click', handleAddMedicine);
}

if (inventoryTable) {
    inventoryTable.addEventListener('click', handleTableAction);
}
