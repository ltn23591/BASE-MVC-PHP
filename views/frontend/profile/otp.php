<div id="otp-form-container" class="bg-white rounded-xl shadow-md p-6 sm:p-8 mt-6">
    <p class="text-gray-700 mb-2">Nhập mã OTP đã gửi đến email của bạn:</p>
    <input type="text" name="otp" placeholder="Nhập OTP"
        class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-yellow-400 outline-none" />
    <button type="button" onclick="verifyOtp()"
        class="mt-3 px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
        Xác nhận OTP
    </button>
</div>