const roomTable = document.querySelector("table");
const roomForm = document.querySelector("form");

function isAllDigits(str) {
    if (str.length === 0) return false;
    for (var i = 0; i < str.length; i++) {
        var ch = str.charAt(i);
        if (ch < "0" || ch > "9") return false;
    }
    return true;
}

function isFloatOrInt(str) {
    if (typeof str != "string") return false;
    return !isNaN(parseFloat(str));
}

function initiateEdit(row) {
    for (let i = 0; i <= 5; i++) {
        const cell = row.cells[i];
        if (cell.querySelector("input")) continue;

        const currentText = cell.textContent.trim().replace("tk", "");
        const input = document.createElement("input");

        input.type = "text";
        input.value = currentText;
        input.style.width = "90%";

        cell.innerHTML = "";
        cell.appendChild(input);
    }

    const editBtn = Array.from(row.querySelectorAll("button")).find(b => b.textContent.toUpperCase() === "EDIT");
    if (editBtn) {
        editBtn.textContent = "SAVE";
        editBtn.classList.remove("edit");
        editBtn.classList.add("save");
    }
}

function saveEdit(row) {
    let isValid = true;
    let errorMessage = "Validation Errors Encountered:\n\n";
    let errorCount = 0;

    for (let i = 0; i <= 5; i++) {
        const cell = row.cells[i];
        const input = cell.querySelector("input");
        if (!input) continue;

        let value = input.value.trim();
        const headerText = roomTable.rows[0].cells[i].textContent;
        let fieldError = "";

        if (value === "" && i !== 5) {
            fieldError = `${headerText} field is "required" and cannot be blank.`;
        }
        else if (i === 3 && !isFloatOrInt(value.replace("tk", ""))) {
            fieldError = `${headerText} must be a valid number.`;
        }
        else if (i === 0 && !isAllDigits(value)) {
            fieldError = `${headerText} must contain only digits.`;
        }

        if (fieldError !== "") {
            isValid = false;
            errorCount++;
            errorMessage += `${errorCount}. ${fieldError}\n`;
            input.style.border = "2px solid red";
        } else {
            input.style.border = "1px solid #ccc";
        }
    }

    if (!isValid) {
        alert(errorMessage);
        return;
    }

    for (let i = 0; i <= 5; i++) {
        const cell = row.cells[i];
        const input = cell.querySelector("input");
        if (input) {
            let finalValue = input.value.trim();
            if (i === 3 && finalValue !== "") {
                finalValue += " tk";
            }
            cell.textContent = finalValue;
        }
    }

    const saveBtn = Array.from(row.querySelectorAll("button")).find(b => b.textContent.toUpperCase() === "SAVE");
    if (saveBtn) {
        saveBtn.textContent = "Edit";
        saveBtn.classList.remove("save");
        saveBtn.classList.add("edit");
    }
    alert("Data saved successfully!");
}

function deleteRow(row) {
    const roomNo = row.cells[0].textContent;
    if (confirm(`Action: Are you sure you want to DELETE Room ${roomNo}?`)) {
        row.remove();
        alert(`SUCCESS: Room ${roomNo} has been deleted.`);
    }
}

function handleTableAction(event) {
    const target = event.target;
    if (target.tagName !== "BUTTON") return;

    const row = target.closest("tr");
    const action = target.textContent.toUpperCase();

    if (action === "EDIT") {
        initiateEdit(row);
    } else if (action === "SAVE") {
        saveEdit(row);
    } else if (action === "DELETE") {
        deleteRow(row);
    } else if (action === "ASSIGN PATIENT") {
        const name = prompt("Enter Patient Name:");
        if (name) {
            row.cells[5].textContent = name;
            row.cells[4].textContent = "Occupied";
        }
    }
}

if (roomTable) {
    roomTable.addEventListener("click", handleTableAction);
}

if (roomForm) {
    roomForm.addEventListener("submit", function(e) {
        e.preventDefault();
        alert("New room entry submitted.");
    });
}

