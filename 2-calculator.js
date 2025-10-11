function write_answer_days(text_msg){
    let my_p = document.getElementById("p_answer_days");
    my_p.innerHTML = text_msg;
}

function get_dob(){
    return document.getElementById("DOB").value;
}

function calculate_age_in_days() {
    let dob = get_dob();
    if (!dob) {
        write_answer_days("Please enter your date of birth.");
        return;
    }
    let birthDate = new Date(dob);
    let today = new Date();
    let diffTime = today - birthDate;
    let diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    write_answer_days(`You are ${diffDays} days old.`);
}

function write_answer_circle(text_msg){
    let my_p = document.getElementById("p_answer_circle");
    my_p.innerHTML = text_msg;
}

function calculate_circle_area() {
    let radius = prompt("Enter the circle radius:");
    if (!radius || isNaN(radius)) {
        write_answer_circle("Please enter a valid number for the radius.");
        return;
    }
    let area = Math.PI * radius * radius;
    write_answer_circle(`The area of the circle is ${area.toFixed(2)}.`);
}

function write_answer_palindrome(text_msg){
    let my_p = document.getElementById("p_answer_palindrome");
    my_p.innerHTML = text_msg;
}

function get_palindrome(){
    return document.getElementById("possible_palindrome").value;
}

function check_palindrome() {
    let text = get_palindrome();
    if (!text) {
        write_answer_palindrome("Please enter text.");
        return;
    }
    let normalized = text.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
    let reversed = normalized.split('').reverse().join('');
    if (normalized === reversed) {
        write_answer_palindrome(`"${text}" is a palindrome!`);
    } else {
        write_answer_palindrome(`"${text}" is NOT a palindrome.`);
    }
}

function write_answer_fibo(text_msg){
    let my_p = document.getElementById("p_answer_fibo");
    my_p.innerHTML = text_msg;
}

function calculate_fibonacci() {
    let n = parseInt(document.getElementById("fibo_length").value);
    if (isNaN(n) || n < 0) {
        write_answer_fibo("Please enter a valid non-negative integer.");
        return;
    }
    let fib = [0, 1];
    for (let i = 2; i <= n; i++) {
        fib[i] = fib[i - 1] + fib[i - 2];
    }
    write_answer_fibo(`Fibonacci number #${n} is ${fib[n]}.`);
}

function ItemGroup(name, price, quantity) {
    this.name = name;
    this.price = price;
    this.quantity = quantity;
}


function Cart() {
    this.items = [];

    this.addItemGroup = function(itemGroup) {
        this.items.push(itemGroup);
        alert(`Added ${itemGroup.quantity} x ${itemGroup.name} to cart.`);
    };

    this.getTotalAmount = function() {
        let amount = 0;
        for (let i = 0; i < this.items.length; i++) {
            amount += this.items[i].price * this.items[i].quantity;
        }
        return amount;
    };

    this.showTotalAmount = function() {
        let total = this.getTotalAmount();
        let taxRate = 0.13;
        let totalWithTax = total * (1 + taxRate);
        alert(`Item groups: ${this.items.length}\nTotal: $${total.toFixed(2)}\nTotal with tax: $${totalWithTax.toFixed(2)}`);
    };
}

let cart = new Cart();

function add_example_items() {
    let pants = new ItemGroup("Pants", 10.05, 15);
    let shirt = new ItemGroup("Shirt", 20.50, 3);
    cart.addItemGroup(pants);
    cart.addItemGroup(shirt);
    cart.showTotalAmount();
}
