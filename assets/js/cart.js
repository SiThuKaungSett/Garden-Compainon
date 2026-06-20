$(document).ready(function () {
    // Function to update the cart total dynamically
    function updateCartTotal() {
        let newSubtotal = 0;
        $(".cart-total").each(function () {
            let itemTotal = parseFloat($(this).text().replace(" Ks", "")) || 0;
            newSubtotal += itemTotal;
        });
        $("#cart-total").text(newSubtotal.toFixed(2) + " Ks");
    }

    // Handle quantity change event
    $(".cart-quantity-input").on("change", function () {
        let productId = $(this).data("product-id");
        let newQuantity = $(this).val();

        if (newQuantity < 1) {
            $(this).val(1);
            newQuantity = 1; // Prevent negative or zero values
        }

        $.ajax({
            url: "update_cart.php",
            method: "POST",
            data: { product_id: productId, quantity: newQuantity },
            dataType: "json",
            success: function (response) {
                console.log("Server Response:", response); // Debugging response

                if (response.success) {
                    // Update the item total price dynamically
                    $(".cart-total[data-product-id='" + productId + "']").text(response.item_total + " Ks");

                    // Update the cart subtotal dynamically
                    $("#cart-total").text(response.cart_subtotal + " Ks");
                } else {
                    console.error("Server error:", response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    });

    // Handle item removal
    $(".cart-remove").on("click", function (e) {
        e.preventDefault();
        
        let form = $(this).closest("form");
        let productId = form.find("input[name='product_id']").val();
        let cartItem = form.closest(".cart-item");

        $.ajax({
            url: "cart.php",
            method: "POST",
            data: { product_id: productId, remove: true },
            success: function () {
                // Remove the item from the DOM
                cartItem.remove();

                // Recalculate cart total after removing item
                updateCartTotal();

                // If cart is empty, show empty cart message
                if ($(".cart-item").length === 0) {
                    $(".cart-items").html('<p class="empty-cart">Your cart is empty.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error("Item Remove Error:", error);
            }
        });
    });

    // Checkout Modal Functionality
    const checkoutModal = document.getElementById("checkout-modal");
    const checkoutBtn = document.querySelector(".checkout-btn");
    const closeBtn = document.querySelector(".close-btn");

    checkoutBtn.addEventListener("click", function () {
        checkoutModal.style.display = "flex";
    });

    closeBtn.addEventListener("click", function () {
        checkoutModal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === checkoutModal) {
            checkoutModal.style.display = "none";
        }
    });

    // Handle "Confirm Order" Button Click
    $(".checkout-submit").on("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: "checkout.php",
            method: "POST",
            data: $("#checkout-form").serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#checkout-modal").css("display", "none"); // Close checkout modal
                    $("#order-success-modal").addClass("active"); // Show success modal
                } else {
                    alert("Order failed: " + response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error("Checkout Error:", error);
            }
        });
    });

    // Close Success Modal
    $("#success-ok-btn").on("click", function () {
        $("#order-success-modal").removeClass("active");
        window.location.href = "cart.php"; // Redirect user to cart.php
    });
});
