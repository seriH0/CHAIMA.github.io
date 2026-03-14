// ---------------- age ----------------
function compute_days() {
    const dob = document.getElementById("DOB").value;
    const container = document.getElementById("output_days");
    if (!dob) {
        container.innerHTML = "<p>Please enter your date of birth.</p>";
        return;
    }
    const birthDate = new Date(dob);
    const today = new Date();
    const diffDays = Math.floor((today - birthDate) / (1000 * 60 * 60 * 24));
    container.innerHTML = `<p>You are ${diffDays} day(s) old.</p>`;
}

// ---------------- circle ----------------
function compute_circle() {
    const container = document.getElementById("output_circle");
    const screen = window.screen;
    const radius = Math.min(screen.width, screen.height) / 2;
    const area = Math.PI * radius * radius;
    container.innerHTML = `<p>Radius: ${radius.toFixed(2)} px</p>
                           <p>Area: ${area.toFixed(2)} px²</p>`;
}

// ---------------- palindrome ----------------
function check_palindrome() {
    const text_input = document.getElementById("possible_palindrome").value;
    const container = document.getElementById("output_palindrome");
    if (!text_input) {
        container.innerHTML = "<p>Please enter text.</p>";
        return;
    }

    const cleaned = text_input.replace(/[^a-z0-9]/gi, '').toLowerCase();
    const reversed = cleaned.split('').reverse().join('');
    const isPalindrome = cleaned === reversed;

    container.innerHTML = isPalindrome 
        ? `<p>"${text_input}" is a palindrome!</p>` 
        : `<p>"${text_input}" is NOT a palindrome.</p>`;
}

// ---------------- FIibonacci sequence ----------------
function create_fibo() {
    const n = parseInt(document.getElementById("fibo_length").value, 10);
    const container = document.getElementById("output_fibo");
    if (isNaN(n) || n < 1) {
        container.innerHTML = "<p>Please enter a positive integer.</p>";
        return;
    }

    const fib = [0, 1];
    for (let i = 2; i < n; i++) {
        fib[i] = fib[i - 1] + fib[i - 2];
    }

    container.innerHTML = `<p>Fibonacci sequence of length ${n}: ${fib.slice(0, n).join(", ")}</p>`;
}
