// ─── PAYMENT CHECKOUT REDIRECT ───
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const button = document.getElementById('paymentContinue');
    if (!form) return;
    if (button) {
        button.addEventListener('click', function() {
            form.submit();
        });
    }
    // ─── AUTO-SUBMIT TO THE PAYMENT GATEWAY ───
    setTimeout(function() {
        form.submit();
    }, 2000);
});