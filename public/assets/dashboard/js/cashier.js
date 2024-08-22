$(document).ready(function () {
    // Category filtering by AJAX
    $(".category-link").on("click", function (e) {
        e.preventDefault();
        let categoryId = $(this).data("category-id");
        $.ajax({
            url: `/cashier/get-product-by-category/${categoryId}`,
            type: "GET",
            success: function (response) {
                $("#product-list").html(response.html);
            },
            error: function () {
                $("#product-list").html(
                    '<p class="text-center">An error occurred. Please try again later.</p>'
                );
            },
        });
    });

    // Payment method selection
    $('input[name="payment_method"]').on("change", function () {
        if ($(this).val() === "cash") {
            $("#paymentFields").slideDown().removeClass("d-none");
        } else {
            $("#paymentFields").slideUp().addClass("d-none");
        }
    });

    let total = 0;

    // Add to cart
    $(document).on("click", ".add-to-cart", function (e) {
        e.preventDefault();

        const productName = $(this).data("name");
        const productPrice = parseInt($(this).data("price")); // Ubah ke parseInt
        const productThumbnail = $(this).data("thumbnail");

        const cartItemHtml = `
                <div class="d-flex justify-content-between align-items-center gap-2 mb-3 cart-item">
                    <img src="${productThumbnail}" alt="${productName}" class="img-thumbnail my-2 border-0" width="50" height="50">
                    <div class="d-flex flex-column">
                        <p class="text-dark mb-0" style="font-weight: 700">${productName}</p>
                        <p class="text-primary mb-0">Rp. ${productPrice.toLocaleString(
                            "id-ID"
                        )}</p>
                    </div>
                    <div class="d-flex flex-column ms-4">
                        <p class="text-danger mb-1 sub-total">Rp. ${productPrice.toLocaleString(
                            "id-ID"
                        )}</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm btn-decrease" type="button"><i class="ti ti-minus"></i></button>
                            <input name="qty" type="text" class="form-control form-control-sm w-25 qty-input" min="1" size="1" inputmode="numeric" value="1">
                            <button class="btn btn-danger btn-sm btn-increase" type="button"><i class="ti ti-plus"></i></button>
                        </div>
                    </div>
                </div>
            `;

        $("#cart-items-container").append(cartItemHtml);
        total += productPrice;
        updateTotal(total);
        checkCartItems();
    });

    // Increase quantity
    $(document).on("click", ".btn-increase", function () {
        const $qtyInput = $(this).siblings(".qty-input");
        let qty = parseInt($qtyInput.val()) + 1;
        $qtyInput.val(qty);

        const $cartItem = $(this).closest(".cart-item");
        const productPrice = parseInt(
            $cartItem
                .find(".text-primary")
                .text()
                .replace(/[^0-9]/g, "")
        );
        const newSubTotal = productPrice * qty;
        $cartItem
            .find(".sub-total")
            .text(`Rp. ${newSubTotal.toLocaleString("id-ID")}`);

        total += productPrice;
        updateTotal(total);

        if (qty > 1) {
            $(this)
                .siblings(".btn-decrease")
                .find("i")
                .removeClass("ti-trash")
                .addClass("ti-minus");
        }
    });

    // Decrease quantity or remove item
    $(document).on("click", ".btn-decrease", function () {
        const $qtyInput = $(this).siblings(".qty-input");
        let qty = parseInt($qtyInput.val()) - 1;

        const $cartItem = $(this).closest(".cart-item");
        const productPrice = parseInt(
            $cartItem
                .find(".text-primary")
                .text()
                .replace(/[^0-9]/g, "")
        );

        if (qty > 0) {
            $qtyInput.val(qty);
            const newSubTotal = productPrice * qty;
            $cartItem
                .find(".sub-total")
                .text(`Rp. ${newSubTotal.toLocaleString("id-ID")}`);

            total -= productPrice;
            updateTotal(total);

            if (qty === 1) {
                $(this).find("i").removeClass("ti-minus").addClass("ti-trash");
            }
        } else {
            $cartItem.remove();
            total -= productPrice;
            updateTotal(total);
            checkCartItems();
        }
    });

    // Update total price
    function updateTotal(total) {
        $("#totalPayment").text(`Rp. ${total.toLocaleString("id-ID")}`);
    }

    // Check if cart is empty
    function checkCartItems() {
        if ($("#cart-items-container").children().length === 0) {
            $("#empty-cart-message").show();
        } else {
            $("#empty-cart-message").hide();
        }
    }
});
