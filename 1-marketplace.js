function ItemGroup(name, price, quantity) {
    this.name = name;
    this.price = price;
    this.quantity = quantity;
}

function Cart() {
    this.itemGroups = [];

    this.addItemGroup = function(itemGroup) {
        this.itemGroups.push(itemGroup);
        this.showTotalAmount();
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
        const container = document.getElementById("cart_output");
        if (!container) return;
        if (this.itemGroups.length === 0) {
            container.innerHTML = "<p>You have 0 items, for a total amount of $0.00 in your cart!</p>";
        } else {
            const total = this.getTotalAmount();
            const totalWithTax = total * 1.15;
            let html = `<p>You have ${this.itemGroups.length} item group(s) in your cart.</p>`;
            html += `<p>Total before tax: $${total.toFixed(2)}</p>`;
            html += `<p>Total after tax (15%): $${totalWithTax.toFixed(2)}</p><hr>`;
            container.innerHTML = html;
        }
    }
}

let my_cart = new Cart();

function add_example_items() {
    let pants = new ItemGroup("pants", 10.05, 15);
    let coat = new ItemGroup("coat", 99.99, 1);
    my_cart.addItemGroup(pants);
    my_cart.addItemGroup(coat);
}

window.onload = function() {
    my_cart.showTotalAmount();
}
