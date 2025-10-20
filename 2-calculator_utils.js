
function calculate_age_in_days() {
    const dob_input = document.getElementById("DOB").value;
    if (!dob_input) {
        alert("Please enter your date of birth.");
        return;
    }
    const dob = new Date(dob_input);
    const today = new Date();
    const diffTime = today - dob;
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    document.getElementById("p_answer_days").textContent = diffDays + " days";
}

function calculate_circle_area() {
    const radius = Math.min(window.innerWidth, window.innerHeight) / 2;
    const area = Math.PI * radius * radius;
    document.getElementById("p_answer_circle").textContent =
        "Radius: " + radius.toFixed(2) + " px, Area: " + area.toFixed(2) + " px²";
}

function check_palindrome() {
    const text = document.getElementById("possible_palindrome").value;
    if (!text) {
        alert("Please enter text to check.");
        return;
    }
    const cleaned = text.toLowerCase().replace(/[^a-z0-9]/g, '');
    const reversed = cleaned.split('').reverse().join('');
    const isPalindrome = cleaned === reversed;
    document.getElementById("p_answer_palindrome").textContent =
        isPalindrome ? "Yes, it is a palindrome" : "No, not a palindrome";
}

function calculate_fibonacci() {
    const n = parseInt(document.getElementById("fibo_length").value);
    if (isNaN(n) || n < 1) {
        alert("Enter a positive number.");
        return;
    }
    let fib = [0, 1];
    for (let i = 2; i < n; i++) {
        fib[i] = fib[i-1] + fib[i-2];
    }
    document.getElementById("p_answer_fibo").textContent = fib.slice(0, n).join(", ");
}


function ItemGroup(name, pricePerItem, numberOfItems) {
    this.name = name;
    this.pricePerItem = pricePerItem;
    this.numberOfItems = numberOfItems;
}

function Cart() {
    this.items = [];
}

Cart.prototype.addItemGroup = function(itemGroup) {
    this.items.push(itemGroup);
};

Cart.prototype.getTotalAmount = function() {
    let amount = 0;
    for (let i = 0; i < this.items.length; i++) {
        amount += this.items[i].pricePerItem * this.items[i].numberOfItems;
    }
    return amount;
};

let myCart = new Cart();

function add_example_items() {
    let pants = new ItemGroup("Nice Pants", 10.05, 15);
    let shirt = new ItemGroup("Cool Shirt", 20.50, 3);
    myCart.addItemGroup(pants);
    myCart.addItemGroup(shirt);

    document.getElementById("cart_count").textContent = myCart.items.length;
    const total = myCart.getTotalAmount();
    document.getElementById("cart_total").textContent = total.toFixed(2);
    document.getElementById("cart_total_tax").textContent = (total * 1.15).toFixed(2); // 15% tax
    alert("Items added! Check the Cart Summary below.");
}
