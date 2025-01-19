document.addEventListener("DOMContentLoaded", function () {
    const preorderForm = document.getElementById("preorder-form");
    const submitButton = document.getElementById("submit-order");
    const orderSummary = document.getElementById("order-summary");
    const proceedButton = document.getElementById("proceed-to-transaction");
    const transactionSummary = document.getElementById("transaction-summary");
    const payButton = document.getElementById("pay-button");
    const receipt = document.getElementById("receipt");
    const newOrderButton = document.getElementById("new-order");

    submitButton.addEventListener("click", function () {
        const name = document.getElementById("name").value;
        const jurusan = document.getElementById("jurusan").value;
        const kelas = document.getElementById("kelas").value;
        const telp = document.getElementById("telp").value;
        const email = document.getElementById("email").value;
        const payment = document.getElementById("payment").value;

        if (name && jurusan && kelas && telp && payment) {
            document.getElementById("order-summary-name").textContent = name;
            document.getElementById("order-summary-jurusan").textContent = jurusan;
            document.getElementById("order-summary-kelas").textContent = kelas;
            document.getElementById("order-summary-telp").textContent = telp;
            document.getElementById("order-summary-email").textContent = email;
            document.getElementById("order-summary-payment").textContent = payment;

            preorderForm.style.display = "none";
            orderSummary.classList.remove("hidden");
        } else {
            alert("Harap Masukan Data Yang Lengkap Jangan Sampai Ada Yang Kosong !!!");
        }
    });

    proceedButton.addEventListener("click", function () {
        const transactionId = "TXN" + Date.now() + Math.floor(Math.random() * 1000000);
        const paymentMethod = document.getElementById("payment").value;
        const currentDate = new Date().toLocaleString('en-US', {
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: true 
        });

        document.getElementById("transaction-date").textContent = currentDate;
        document.getElementById("transaction-id").textContent = transactionId;
        document.getElementById("transaction-payment").textContent = paymentMethod;

        orderSummary.style.display = "none";
        transactionSummary.classList.remove("hidden");
    });

    payButton.addEventListener("click", function () {
        const currentDate = new Date().toLocaleDateString();
        const transactionId = document.getElementById("transaction-id").textContent;
        const name = document.getElementById("order-summary-name").textContent;

        document.getElementById("receipt-name").textContent = name;
        document.getElementById("receipt-transaction").textContent = transactionId;
        document.getElementById("receipt-date").textContent = currentDate;

        transactionSummary.style.display = "none";
        receipt.classList.remove("hidden");
    });

    newOrderButton.addEventListener("click", function () {
        preorderForm.reset();
        preorderForm.style.display = "block";
        receipt.classList.add("hidden");
    });
});
