
let items = JSON.parse(localStorage.getItem("items")) || [];
renderList();  


document.getElementById("todo-form").addEventListener("submit", (e) => {
    e.preventDefault();
    const input = document.getElementById("todo-input");
    const value = input.value.trim();

    if (value === "") {
        alert("Please enter a task!");
        return;
    }

    const newItem = {
        text: value,
        id: Date.now() 
    };

    items.push(newItem);
    localStorage.setItem("items", JSON.stringify(items));

    renderItem(newItem.text, newItem.id);
    input.value = "";
});


function renderList() {
    items.forEach(item => renderItem(item.text, item.id));
}


function renderItem(itemText, id) {
    const ul = document.getElementById("todo-list");
    const li = document.createElement("li");

    li.dataset.id = id; // this is so we can keep the id inside the DOM when we delet it

   
    const textSpan = document.createElement("span");
    textSpan.textContent = itemText;
    li.appendChild(textSpan);

    // Trash icon when deleting
    const trashSpan = document.createElement("span");
    trashSpan.classList.add("fas", "fa-trash");
    trashSpan.style.marginLeft = "10px";
    trashSpan.style.cursor = "pointer";
    trashSpan.style.color = "red";
    li.appendChild(trashSpan);

    // Deleting 
    trashSpan.addEventListener("click", () => {
        li.remove();

        // Removing from storage by each id
        items = items.filter(x => x.id !== id);
        localStorage.setItem("items", JSON.stringify(items));
    });

    ul.appendChild(li);
}
