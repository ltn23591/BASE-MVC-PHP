document.addEventListener("DOMContentLoaded", () => {
  const applyBtn = document.getElementById("apply_voucher");
  const voucherInput = document.getElementById("voucher_code");
  const discountValue = document.getElementById("discount_value");
  const totalValue = document.getElementById("total_value");

  if (!applyBtn) return;

  applyBtn.addEventListener("click", async (e) => {
    e.preventDefault(); // không reload form

    const code = voucherInput.value.trim();
    try {
        // Gửi yêu cầu AJAX để áp dụng voucher
        const response  = await fetch("index.php?controllers=applyvoucher&action=applyVoucher", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "code=" + encodeURIComponent(code)
        });

        const data = await response.json();

        if (data.success) {
            discountValue.textContent = `- ${data.discount_value.toLocaleString()} đ`;
            totalValue.textContent = `${data.new_total.toLocaleString()} đ`;

            totalValue.value = data.new_total;

            Toastify({
                text: data.message,
                duration: 1500,
                gravity: "top",
                position: "left",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
            }).showToast();
        }
        else {
            Toastify({
                text: data.message,
                duration: 1500,
                gravity: "top",
                position: "left",
                style: {
                    background: "linear-gradient(to right, #ff416c, #ff4b2b)",
                },
            }).showToast();
        }
    } catch (error) {
        console.error("Lỗi:", error);
        Toastify({
            text: "Đã xảy ra lỗi. Vui lòng thử lại.",
            duration: 1500,
            gravity: "top",
            position: "right",
            close: true,
            style: {
                background: "linear-gradient(to right, #ff416c, #ff4b2b)",
            },
        }).showToast();
    }
  });
});
