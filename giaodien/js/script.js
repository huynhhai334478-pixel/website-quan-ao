document.addEventListener("DOMContentLoaded", function () {
    const imgPosition = document.querySelectorAll(".slider-container img");
    const imgContainer = document.querySelector(".slider-container");
    const dotItem = document.querySelectorAll(".dot");
    let imgnumber = imgPosition.length;
    let index = 0;

    imgPosition.forEach(function (image, index) {
        image.style.left = index * 100 + "%";
        dotItem[index].addEventListener("click", function () {
            slider(index);
        });
    });

    function imgSlide() {
        index++;
        if (index >= imgnumber) {
            index = 0;
        }
        slider(index);
    }

    function slider(index) {
        if (!imgContainer) return;
        imgContainer.style.left = "-" + index * 100 + "%";
        const dotActive = document.querySelector(".active");
        if (dotActive) {
            dotActive.classList.remove("active");
        }
        dotItem[index].classList.add("active");
    }
    setInterval(imgSlide, 5000);
});


// cartegory////////////////
document.addEventListener('DOMContentLoaded', function() {
    const itemsliderbar = document.querySelectorAll(".cartegory-left-li");
    itemsliderbar.forEach(function(menu) {
        menu.addEventListener("click", function() {
        menu.classList.toggle("block");
        });
    });
});
//----------------------------------------product-----------------------------------------------


document.addEventListener("DOMContentLoaded", function() {
    const baoquan = document.querySelector(".baoquan");
    const chitiet = document.querySelector(".chitiet");

    if (baoquan && chitiet) {
        baoquan.addEventListener("click", function() {
            document.querySelector(".product-content-right-button-content-chitiet").style.display = "none";
            document.querySelector(".product-content-right-button-content-baoquan").style.display = "block";
        });

        chitiet.addEventListener("click", function() {
            document.querySelector(".product-content-right-button-content-chitiet").style.display = "block";
            document.querySelector(".product-content-right-button-content-baoquan").style.display = "none";
        });
    }
});
document.addEventListener("DOMContentLoaded", function() {
    const button = document.querySelector(".product-content-right-product-button-top")
    if(button)
    {
        button.addEventListener("click", function()
        {
            document.querySelector(".product-content-right-button-content-big").classList.toggle("activeB");
        });
    }
});
// login////////////////////////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    // Đặt tất cả các biến DOM ở đây
    const registerlink = document.querySelector('.register-link');
    const loginlink = document.querySelector('.login-link');
    const btnpopup = document.querySelector('.btnLogin-popup');
    const warpper = document.querySelector('.warpper');

    if (registerlink) {
        registerlink.addEventListener('click', () => {
            warpper.classList.add('activeC');
        });
    }
    if (loginlink) {
        loginlink.addEventListener('click', () => {
            warpper.classList.remove('activeC');
        });
    }
    if (btnpopup) {
        btnpopup.addEventListener('click', () => {
            warpper.classList.add('active-popup');
        });
    }

    // Dropdown tài khoản
    var userDropdown = document.querySelector('.user-dropdown');
    var submenu = userDropdown ? userDropdown.querySelector('.sub-taikhoan') : null;

    if (userDropdown && submenu) {
        userDropdown.querySelector('a').addEventListener('click', function(e) {
            e.preventDefault();
            submenu.style.setProperty('display', submenu.style.display === 'block' ? 'none' : 'block', 'important');
        });

        document.addEventListener('click', function(e) {
            if (submenu.style.display === 'block' && !userDropdown.contains(e.target)) {
                submenu.style.display = 'none';
            }
        });
    }
});
//cart/////////////////////////////////////
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('change', function () {
        // Lấy tất cả các ô nhập số lượng
        const quantityInputs = document.querySelectorAll('input[type="number"]');
        let totalQuantity = 0;
        let totalPrice = 0;

        // Duyệt qua từng ô nhập số lượng để tính tổng
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value); // Lấy số lượng
            const price = parseInt(input.closest('tr').querySelector('td:nth-child(5) p').getAttribute('data-price')); // Lấy giá sản phẩm từ thuộc tính data-price
            if (!isNaN(quantity) && !isNaN(price)) {
                totalQuantity += quantity;
                totalPrice += quantity * price;
            }
        });

        // Cập nhật tổng sản phẩm
        document.querySelector('#total-quantity').textContent = totalQuantity;

        // Cập nhật tổng tiền hàng
        document.querySelector('#total-price').textContent = totalPrice.toLocaleString('vi-VN') + 'đ';
    });
});
const cartSlInput = document.getElementById('cart_sl');
if (cartSlInput) {
    cartSlInput.addEventListener('input', function () {
        const max = 25;
        const min = 1;
        let value = parseInt(this.value);

        if (value > max) {
            this.value = max;
        } else if (value < min) {
            this.value = min;
        }
    });
}

//vote sao
    const voteForm = document.getElementById('voteForm');
    if (voteForm) {
        const stars = voteForm.querySelectorAll('input[name="sao"]');
        stars.forEach(star => {
            star.addEventListener('change', () => {
                voteForm.submit();
            });
        });
    }
//voucher
document.addEventListener('DOMContentLoaded', function () {
    const voucherSelect = document.getElementById('voucher-select');
    const discountAmount = document.getElementById('discount-amount');
    const finalTotal = document.getElementById('final-total');
    const finalTotalValue = document.getElementById('final-total-value');
    const grandTotal = parseInt(finalTotalValue.value) || 0;

    const idvoucherValue = document.getElementById('idvoucher-value');

    function formatCurrency(amount) {
        return amount.toLocaleString('vi-VN') + '<sup>VNĐ</sup>';
    }

    voucherSelect.addEventListener('change', function () {
        const selected = voucherSelect.options[voucherSelect.selectedIndex];
        const discount = parseFloat(selected.getAttribute('data-discount')) || 0;
        const type = selected.getAttribute('data-type');
        let discountValue = 0;

        if (type === 'PHẦN TRĂM') {
            discountValue = Math.round(grandTotal * discount / 100);
        } else if (type === 'VNĐ') {
            discountValue = discount;
        }

        // Không cho giảm quá nhiều (phải để lại 1 VNĐ)
        if (grandTotal - discountValue < 1) {
            discountValue = grandTotal - 1;
        }

        let final = grandTotal - discountValue;

        discountAmount.innerHTML = formatCurrency(discountValue);
        finalTotal.innerHTML = formatCurrency(final);

        idvoucherValue.value = selected.value;
        finalTotalValue.value = final;

    });
});
// ======================= Hiện/Ẩn mật khẩu =======================
document.querySelectorAll('.toggle-password').forEach(function (eyeIcon) {
    eyeIcon.addEventListener('click', function () {
        const inputSelector = this.getAttribute('toggle');
        const passwordInput = document.querySelector(inputSelector);
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});
//quên mật khẩu //
document.addEventListener('DOMContentLoaded', function () {
    const goToResetBtn = document.getElementById('goToResetBtn');
    const wrapper = document.querySelector('.warpper');
    const forgotUserInput = document.getElementById('forgot_user');
    const forgotPhoneInput = document.getElementById('forgot_phone');
    const resetUserInput = document.getElementById('reset_user');

    if (goToResetBtn) {
        goToResetBtn.addEventListener('click', function () {
            const username = forgotUserInput.value.trim();
            const phone = forgotPhoneInput.value.trim();

            if (!username) {
                alert("Vui lòng nhập tài khoản.");
                return;
            }
            if (!phone) {
                alert("Vui lòng nhập số điện thoại.");
                return;
            }

            if (resetUserInput) {
                resetUserInput.value = username;
            }

            wrapper.classList.add('activeReset');
        });
    }
});


