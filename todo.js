// Load saved items from localStorage
window.addEventListener("DOMContentLoaded", () => {
    const savedItems = JSON.parse(localStorage.getItem("todoItems")) || [];
    savedItems.forEach(item => renderItem(item));
});

// Handle form submission
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
    input.value = ""; // clear input
});

// Render a single item with trash icon
function renderItem(itemText) {
    const ul = document.getElementById("todo-list");
    const li = document.createElement("li");

    // Text span
    const textSpan = document.createElement("span");
    textSpan.textContent = itemText;
    li.appendChild(textSpan);

    // Trash icon span
    const trashSpan = document.createElement("span");
    trashSpan.classList.add("fas", "fa-trash");
    trashSpan.style.marginLeft = "10px";
    trashSpan.style.cursor = "pointer";
    trashSpan.style.color = "red";
    li.appendChild(trashSpan);

    // Delete on click
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

// Remove item from localStorage
function removeFromLocalStorage(itemText) {
    let items = JSON.parse(localStorage.getItem("todoItems")) || [];
    items = items.filter(item => item !== itemText);
    localStorage.setItem("todoItems", JSON.stringify(items));
}
