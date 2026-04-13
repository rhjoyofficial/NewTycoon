class CartManager {
    constructor() {
        this.sessionKey = "cart_last_update";
        this.debounceTimeout = null;
        this.debounceDelay = 250;
        this.init();
    }

    init() {
        this.checkCartStale();
        this.initAddToCartForms();
        // this.initCartUpdates();
        this.initCartPageHandlers();
        this.setupQuantityHandlers();
        document.querySelectorAll(".cart-item-form").forEach((form) => {
            this.updateQuantityButtons(form);
        });
        const initialCount =
            Number(document.querySelector(".cart-count-number")?.textContent) ||
            0;
        this.updateCheckoutButton(initialCount);
    }

    checkCartStale() {
        const now = Date.now();
        const lastUpdateKey = this.sessionKey || "cart_last_update"; // fallback key

        let lastUpdate = localStorage.getItem(lastUpdateKey);

        if (!lastUpdate) {
            // First visit / no timestamp yet — initialize
            localStorage.setItem(lastUpdateKey, now);
            return; // no warning on first visit
        }

        // Convert stored value to number
        lastUpdate = parseInt(lastUpdate, 10);

        // Calculate hours since last cart update
        const hoursSinceUpdate = (now - lastUpdate) / (1000 * 60 * 60);

        if (hoursSinceUpdate > 24) {
            // Cart is stale — show warning
            // this.showFlash(
            //     "Your cart may be outdated. Please refresh.",
            //     "warning",
            // );

            // update the timestamp so it doesn't warn repeatedly
            localStorage.setItem(lastUpdateKey, now);
        }
    }

    initAddToCartForms() {
        // Event delegation for dynamic content
        document.addEventListener("submit", (e) => {
            const form = e.target.closest(".add-to-cart-form");
            if (!form) return;

            e.preventDefault();
            const button = form.querySelector(".add-to-cart-btn");
            if (!button || button.disabled) return;

            this.handleAddToCart(form, button);
        });
    }

    async handleAddToCart(form, button) {
        if (button.dataset.loading === "true") return;
        button.dataset.loading = "true";

        const url = form.action;
        const token =
            form.querySelector('input[name="_token"]')?.value ||
            document.querySelector('meta[name="csrf-token"]')?.content;

        if (!token) {
            this.showFlash("Security error. Please refresh the page.", "error");
            button.dataset.loading = "false";
            return;
        }
        // READ QUANTITY SAFELY
        const quantityInput = form.querySelector('input[name="quantity"]');
        let quantity = 1;

        if (quantityInput) {
            const parsedQty = parseInt(quantityInput.value, 10);
            quantity = !isNaN(parsedQty) && parsedQty > 0 ? parsedQty : 1;
        }

        // Save original state
        const originalHTML = button.innerHTML;
        const originalClasses = button.className;

        // Show loading state
        button.disabled = true;
        button.classList.add("opacity-75", "cursor-not-allowed");
        button.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-gray-700" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
            </svg>`;

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({ quantity }),
            });

            const data = await response.json();

            if (!response.ok || data.success === false) {
                throw new Error(
                    data.message || data.error || `Error ${response.status}`,
                );
            }

            // Update cart count
            this.updateCartCount(data.cart_count || 0);

            // Show success message
            const message = data.message || "Item added to cart successfully!";
            this.showFlash(message, "success");

            // Show success animation on button
            this.showSuccessAnimation(button);

            // Revert button after delay
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.disabled = false;
                button.className = originalClasses;
                button.dataset.loading = "false";
            }, 1500);
        } catch (error) {
            // Show error message
            this.showFlash(
                error.message || "Failed to add to cart. Please try again.",
                "error",
            );

            // Revert button immediately
            button.innerHTML = originalHTML;
            button.disabled = false;
            button.className = originalClasses;
            button.dataset.loading = "false";
        }
    }

    showSuccessAnimation(button) {
        button.innerHTML = `
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 text-green-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>`;
    }

    updateCartCount(count) {
        count = Number(count) || 0;

        // Navbar / badge update
        document.querySelectorAll(".cart-badge").forEach((badge) => {
            const oldCount = Number(badge.textContent) || 0;
            badge.textContent = count;

            if (count > 0) {
                badge.classList.remove("hidden");

                if (count > oldCount) {
                    badge.classList.add("animate-bounce");
                    setTimeout(
                        () => badge.classList.remove("animate-bounce"),
                        800,
                    );
                }
            } else {
                badge.classList.add("hidden");
            }
        });

        // Cart page count update
        document.querySelectorAll(".cart-count-number").forEach((el) => {
            el.textContent = count;
        });

        // toggle checkout button
        this.updateCheckoutButton(count);

        // Update last cart update time
        localStorage.setItem(this.sessionKey, Date.now());
    }

    showFlash(message, type = "success", duration = 3000, description = "") {
        if (typeof window.flash === "function") {
            window.flash(message, type, duration, description);
        } else {
            console.log(`[${type}] ${message}`);
        }
    }

    // initCartUpdates() {
    //     // Quantity updates
    //     document.querySelectorAll(".cart-update-quantity").forEach((button) => {
    //         button.addEventListener("click", async (e) => {
    //             e.preventDefault();
    //             await this.handleCartUpdate(button);
    //         });
    //     });

    //     // Remove items
    //     document.querySelectorAll(".cart-remove-item").forEach((button) => {
    //         button.addEventListener("click", async (e) => {
    //             e.preventDefault();
    //             await this.handleCartRemove(button);
    //         });
    //     });
    // }

    initCartPageHandlers() {
        // Clear cart button
        const clearCartBtn = document.getElementById("clear-cart-btn");
        if (clearCartBtn) {
            clearCartBtn.addEventListener("click", async (e) => {
                e.preventDefault();
                await this.handleClearCart();
            });
        }

        // Remove items
        document.querySelectorAll(".cart-remove-item").forEach((button) => {
            button.addEventListener("click", async (e) => {
                e.preventDefault();
                await this.handleCartRemove(button);
            });
        });
    }

    setupQuantityHandlers() {
        // Listen for quantity changes
        document.addEventListener("click", (e) => {
            // Handle increment/decrement buttons
            if (e.target.closest(".quantity-decrement")) {
                this.handleQuantityChange(
                    e.target.closest(".quantity-decrement"),
                    -1,
                );
            }
            if (e.target.closest(".quantity-increment")) {
                this.handleQuantityChange(
                    e.target.closest(".quantity-increment"),
                    1,
                );
            }
        });

        // Handle direct input changes with debounce
        document.addEventListener("change", (e) => {
            if (e.target.classList.contains("quantity-input")) {
                this.handleQuantityInputChange(e.target);
            }
        });
    }

    async handleQuantityChange(button, change) {
        const form = button.closest(".cart-item-form");
        if (!form) return;
        if (form.dataset.loading === "true") return;

        const input = form.querySelector(".quantity-input");
        const productId = input.dataset.productId;
        const currentQuantity = parseInt(input.value) || 1;
        const newQuantity = currentQuantity + change;

        // Check if product is in stock
        const itemElement = document.querySelector(
            `.cart-item[data-product-id="${productId}"]`,
        );

        const isInStock = itemElement?.dataset.productInStock === "true";

        if (!isInStock && newQuantity > 0) {
            this.showFlash("This item is out of stock", "error");
            return;
        }

        // Validate min/max
        const min = parseInt(input.min) || 1;
        const max = parseInt(input.max) || 999;

        if (newQuantity < min || newQuantity > max) {
            this.showFlash(
                `Quantity must be between ${min} and ${max}`,
                "warning",
            );
            return;
        }

        // Update input immediately for better UX
        input.value = newQuantity;

        // UPDATE BUTTON STATES IMMEDIATELY
        this.updateQuantityButtons(form);

        // Update in database
        await this.updateCartItem(productId, newQuantity, form);
    }

    async handleQuantityInputChange(input) {
        clearTimeout(this.debounceTimeout);
        this.debounceTimeout = setTimeout(async () => {
            const productId = input.dataset.productId;
            const newQuantity = parseInt(input.value) || 1;
            const form = input.closest(".cart-item-form");

            if (!form) return;

            // Validate min/max
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 999;

            if (newQuantity < min || newQuantity > max) {
                this.showFlash(
                    `Quantity must be between ${min} and ${max}`,
                    "warning",
                );
                input.value = Math.min(Math.max(newQuantity, min), max);
                return;
            }
            // UPDATE BUTTON STATES
            this.updateQuantityButtons(form);

            await this.updateCartItem(productId, newQuantity, form);
        }, this.debounceDelay);
    }

    async updateCartItem(productId, quantity, formElement) {
        if (formElement.dataset.loading === "true") return;
        formElement.dataset.loading = "true";

        const url = formElement.action || formElement.dataset.url;
        const token =
            formElement.querySelector('input[name="_token"]')?.value ||
            document.querySelector('meta[name="csrf-token"]')?.content;
        const input = formElement.querySelector(".quantity-input");

        if (!token) {
            this.showFlash("Security error. Please refresh the page.", "error");
            return;
        }

        // Disable input during update
        input.disabled = true;
        input.classList.add("opacity-50", "cursor-not-allowed");

        try {
            const controller = new AbortController();
            setTimeout(() => controller.abort(), 5000);

            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({ quantity }),
                signal: controller.signal,
            });

            const data = await response.json();

            if (!response.ok || data.success === false) {
                throw new Error(data.message || "Failed to update quantity");
            }

            // Update all totals
            this.updateCartCount(data.cart_count || 0);
            this.updateCartTotals(data);
            this.updateItemTotal(productId, data.item_total);
            this.updateQuantityButtons(formElement);
            // Show success message
            this.showFlash(
                data.message || "Cart updated successfully",
                "success",
            );
        } catch (error) {
            if (error.name === "AbortError" || error.name === "TimeoutError") {
                this.showFlash(
                    "Request timed out. Please check your connection.",
                    "error",
                );
            } else if (error.name === "NetworkError") {
                this.showFlash(
                    "Network error. Please check your connection.",
                    "error",
                );
            } else {
                this.showFlash(error.message, "error");
            }

            // Revert to previous value
            const previousValue = input.getAttribute("data-previous-value");
            if (previousValue) {
                input.value = previousValue;
            }
        } finally {
            // Re-enable input
            input.disabled = false;
            input.classList.remove("opacity-50", "cursor-not-allowed");
            input.setAttribute("data-previous-value", input.value);
            formElement.dataset.loading = "false";
        }
    }

    updateItemTotal(productId, itemTotal) {
        // Find the item total element for this product
        const itemElement = document.querySelector(
            `.cart-item[data-product-id="${productId}"]`,
        );
        if (itemElement) {
            const totalElement = itemElement.querySelector(".item-total");
            if (totalElement) {
                const amount = Number(itemTotal);
                totalElement.innerHTML = `<span class="font-bengali">৳</span>${amount.toFixed(
                    2,
                )}`;

                // Add animation
                totalElement.classList.add("animate-pulse");
                setTimeout(() => {
                    totalElement.classList.remove("animate-pulse");
                }, 1000);
            }
        }
    }

    // async handleCartUpdate(button) {
    //     const form = button.closest(".cart-item-form");
    //     const url = form.action || form.dataset.url;
    //     const token =
    //         form.querySelector('input[name="_token"]')?.value ||
    //         document.querySelector('meta[name="csrf-token"]')?.content;
    //     const quantityInput = form.querySelector('input[name="quantity"]');
    //     const quantity = parseInt(quantityInput.value);
    //     const productId = quantityInput.dataset.productId;

    //     button.disabled = true;
    //     const originalText = button.innerHTML;
    //     button.innerHTML = `
    //         <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24">
    //             <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
    //             <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    //         </svg>`;

    //     try {
    //         const response = await fetch(url, {
    //             method: "POST",
    //             headers: {
    //                 "X-CSRF-TOKEN": token,
    //                 Accept: "application/json",
    //                 "Content-Type": "application/json",
    //                 "X-Requested-With": "XMLHttpRequest",
    //             },
    //             body: JSON.stringify({ quantity }),
    //         });

    //         const data = await response.json();

    //         if (!response.ok || data.success === false) {
    //             throw new Error(data.message || "Failed to update cart");
    //         }

    //         // Update all totals
    //         this.updateCartCount(data.cart_count || 0);
    //         this.updateCartTotals(data);
    //         this.updateItemTotal(productId, data.item_total);
    //         this.showFlash(
    //             data.message || "Cart updated successfully",
    //             "success"
    //         );
    //     } catch (error) {
    //         this.showFlash(error.message, "error");
    //     } finally {
    //         button.disabled = false;
    //         button.innerHTML = originalText;
    //     }
    // }

    async handleCartRemove(button) {
        if (
            !confirm(
                "Are you sure you want to remove this item from your cart?",
            )
        ) {
            return;
        }

        const url = button.dataset.url || button.href;
        const token = document.querySelector(
            'meta[name="csrf-token"]',
        )?.content;
        const itemElement = button.closest(".cart-item, tr.cart-item");

        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML = `
            <span class="flex items-center">
                <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Removing...
            </span>`;

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (!response.ok || data.success === false) {
                throw new Error(data.message || "Failed to remove item");
            }

            // Remove item from UI with animation
            if (itemElement) {
                itemElement.style.opacity = "0.5";
                itemElement.style.transform = "translateX(-100%)";
                setTimeout(() => {
                    itemElement.remove();

                    // Show empty cart message if no items left
                    if (document.querySelectorAll(".cart-item").length === 0) {
                        console.log("No Items Left 0");
                        this.showEmptyCartMessage();
                    }
                }, 300);
            }

            // Update counts and totals
            this.updateCartCount(data.cart_count || 0);
            this.updateCartTotals(data);
            this.showFlash(data.message || "Item removed from cart", "success");
        } catch (error) {
            this.showFlash(error.message, "error");
            button.disabled = false;
            button.innerHTML = originalText;
        }
    }

    async handleClearCart() {
        if (!confirm("Are you sure you want to clear your entire cart?")) {
            return;
        }

        const button = document.getElementById("clear-cart-btn");
        const originalText = button.innerHTML;
        const url = button.dataset.url;

        button.disabled = true;
        button.innerHTML = `
            <span class="flex items-center">
                <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Clearing...
            </span>`;

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (!response.ok || data.success === false) {
                throw new Error(data.message || "Failed to clear cart");
            }

            // Update cart count
            this.updateCartCount(data.cart_count || 0);
            this.updateCartTotals(data);

            // Show success message
            this.showFlash(
                data.message || "Cart cleared successfully",
                "success",
            );

            // Reload page after delay
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } catch (error) {
            this.showFlash(error.message, "error");
            button.disabled = false;
            button.innerHTML = originalText;
        }
    }

    updateCartTotals(data) {
        // Update cart total
        const totalElement = document.getElementById("cart-total");
        if (totalElement && data.cart_total !== undefined) {
            totalElement.innerHTML = `<span class="font-bengali">৳</span>${Number(
                data.cart_total,
            ).toFixed(2)}`;
            totalElement.classList.add("animate-pulse");
            setTimeout(
                () => totalElement.classList.remove("animate-pulse"),
                1000,
            );
        }

        // Update subtotal
        const subtotalElement = document.getElementById("cart-subtotal");
        if (subtotalElement && data.cart_subtotal !== undefined) {
            subtotalElement.innerHTML = `<span class="font-bengali">৳</span>${Number(
                data.cart_subtotal,
            ).toFixed(2)}`;
            subtotalElement.classList.add("animate-pulse");
            setTimeout(
                () => subtotalElement.classList.remove("animate-pulse"),
                1000,
            );
        }
    }

    showEmptyCartMessage() {
        console.log("No Items Left 2");
        const cartContainer = document.querySelector(".cart-container");
        console.log("No Items Left 2");
        if (cartContainer) {
            const emptyMessage = document.createElement("div");
            emptyMessage.className =
                "text-center py-12 empty-cart-message animate-fade-in";
            emptyMessage.innerHTML = `
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-4">Add some products to get started!</p>
                <a href="/products" class="inline-block bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors transform hover:scale-105">
                    Continue Shopping
                </a>
            `;
            cartContainer.innerHTML = "";
            cartContainer.appendChild(emptyMessage);
        }
    }

    updateQuantityButtons(form) {
        if (!form) return;

        const input = form.querySelector(".quantity-input");
        const decrementBtn = form.querySelector(".quantity-decrement");
        const incrementBtn = form.querySelector(".quantity-increment");

        if (!input || !decrementBtn || !incrementBtn) return;

        const quantity = parseInt(input.value) || 1;
        const min = parseInt(input.min) || 1;
        const max = parseInt(input.max) || 999;

        // Decrement button
        decrementBtn.disabled = quantity <= min;
        decrementBtn.classList.toggle("opacity-50", decrementBtn.disabled);
        decrementBtn.classList.toggle(
            "cursor-not-allowed",
            decrementBtn.disabled,
        );

        // Increment button
        incrementBtn.disabled = quantity >= max;
        incrementBtn.classList.toggle("opacity-50", incrementBtn.disabled);
        incrementBtn.classList.toggle(
            "cursor-not-allowed",
            incrementBtn.disabled,
        );
    }

    updateCheckoutButton(cartCount) {
        const buttons = document.querySelectorAll(".checkout-btn");
        if (!buttons.length) return;

        cartCount = Number(cartCount) || 0;

        buttons.forEach((btn) => {
            if (cartCount <= 0) {
                btn.classList.add(
                    "opacity-50",
                    "cursor-not-allowed",
                    "pointer-events-none",
                );
                btn.setAttribute("aria-disabled", "true");
            } else {
                btn.classList.remove(
                    "opacity-50",
                    "cursor-not-allowed",
                    "pointer-events-none",
                );
                btn.removeAttribute("aria-disabled");
            }
        });
    }
}

// Initialize cart manager
(function () {
    function init() {
        if (!window.cartManager) {
            window.cartManager = new CartManager();
        }
    }

    // Initialize based on DOM state
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(init, 100);
        });
    } else {
        setTimeout(init, 100);
    }
})();
