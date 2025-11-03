window.addEventListener("DOMContentLoaded", () => {
    const savedItems = JSON.parse(localStorage.getItem("todoItems")) || [];
    savedItems.forEach(item => renderItem(item));
});

document.getElementById("todo-form").addEventListener("submit", (e) => {
    e.preventDefault();
    const input = document.getElementById("todo-input");
    const value = input.value.trim();

    if (value === "") {
        alert("Please enter a task!");
        return;
    }

    renderItem(value);
    saveToLocalStorage(value);
    input.value = ""; 
});

function renderItem(itemText) {
    const ul = document.getElementById("todo-list");
    const li = document.createElement("li");

    // Text
    const textSpan = document.createElement("span");
    textSpan.textContent = itemText;
    li.appendChild(textSpan);

    // Bin 
    const trashSpan = document.createElement("span");
    trashSpan.classList.add("fas", "fa-trash");
    trashSpan.style.marginLeft = "10px";
    trashSpan.style.cursor = "pointer";
    trashSpan.style.color = "red";
    li.appendChild(trashSpan);

    
    trashSpan.addEventListener("click", () => {
        li.remove();
        removeFromLocalStorage(itemText);
    });

    ul.appendChild(li);
}

// Save a new item to localStorage
function saveToLocalStorage(itemText) {
    let items = JSON.parse(localStorage.getItem("todoItems")) || [];
    items.push(itemText);
    localStorage.setItem("todoItems", JSON.stringify(items));
}

// Remove an item from the localStorage
function removeFromLocalStorage(itemText) {
    let items = JSON.parse(localStorage.getItem("todoItems")) || [];
    items = items.filter(item => item !== itemText);
    localStorage.setItem("todoItems", JSON.stringify(items));
}
