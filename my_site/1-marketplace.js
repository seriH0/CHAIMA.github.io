// ItemGroup prototype
function ItemGroup(name, price, quantity) {
    this.name = name;
    this.price = price;
    this.quantity = quantity;
}

// Cart prototype
function Cart() {
    this.itemGroups = [];

    this.addItemGroup = function(itemGroup) {
        this.itemGroups.push(itemGroup);
    }

    this.getTotalAmount = function() {
        let amount = 0;
        for (let i = 0; i < this.itemGroups.length; i++) {
            const item = this.itemGroups[i];
            amount += item.price * item.quantity;
        }
        return amount;
    }

    this.showTotalAmount = function() {
        if (this.itemGroups.length === 0) {
            document.getElementById("cart_output").innerHTML = 
                "<p>You have 0 item, for a total amount of $0.00 in your cart!</p>";
        } else {
            let totalItems = 0;
            for (let i = 0; i < this.itemGroups.length; i++) {
                totalItems += this.itemGroups[i].quantity;
            }
            const total = this.getTotalAmount();
            const totalWithTax = total * 1.15;

            let html = `<p>You have ${totalItems} item(s), for a total amount of $${total.toFixed(2)} in your cart!<br>`;
            html += `With taxes (15%), that’s $${totalWithTax.toFixed(2)}.</p>`;
            document.getElementById("cart_output").innerHTML = html;
        }
    }
}

// create cart
let my_cart = new Cart();
my_cart.showTotalAmount();

// function to add item from user input
function add_item_to_cart() {
    const name = document.getElementById("item_name").value.trim();
    const price = parseFloat(document.getElementById("item_price").value);
    const quantity = parseInt(document.getElementById("item_quantity").value);

    if (!name || isNaN(price) || isNaN(quantity) || price < 0 || quantity < 1) {
        alert("Please enter valid item name, price, and quantity.");
        return;
    }

    const item = new ItemGroup(name, price, quantity);
    my_cart.addItemGroup(item);
    my_cart.showTotalAmount();

    document.getElementById("item_name").value = "";
    document.getElementById("item_price").value = "";
    document.getElementById("item_quantity").value = "";
}

// function to add a coat (predefined)
function add_coat() {
    const coat = new ItemGroup("coat", 99.99, 1);
    my_cart.addItemGroup(coat);
    my_cart.showTotalAmount();
}
