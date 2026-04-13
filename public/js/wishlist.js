class WishlistManager {
    constructor() {
        this.init();
    }

    init() {
        this.initAddToWishlist();
        this.initRemoveFromWishlist();
        this.initMoveToCart();
        // console.log("Wishlist Initialize Successfully.");
    }

    /* ===============================
       ADD TO WISHLIST
    =============================== */
    initAddToWishlist() {
        document.addEventListener("submit", (e) => {
            const form = e.target.closest(".add-to-wishlist-form");
            if (!form) return;

            e.preventDefault();

            const button = form.querySelector("button");
            if (!button || button.disabled) return;

            this.handleAdd(form, button);
        });
    }

    async handleAdd(form, button) {
        const url = form.action;
        const token =
            form.querySelector('input[name="_token"]')?.value ||
            document.querySelector('meta[name="csrf-token"]')?.content;

        if (!token) {
            this.flash("Security error. Refresh the page.", "error");
            return;
        }

        const originalHTML = button.innerHTML;

        button.disabled = true;
        button.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-red-500" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
            </svg>
        `;

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (!response.ok || data.success === false) {
                throw new Error(data.message || "Failed to add to wishlist");
            }

            this.updateWishlistCount(data.wishlist_count || 0);
            this.flash(data.message || "Added to wishlist", "success");

            button.innerHTML = `
                <svg class="h-5 w-5 text-red-500 fill-red-500" viewBox="0 0 24 24">
                    <path d="M12 21l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                    2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09
                    C13.09 3.81 14.76 3 16.5 3
                    19.58 3 22 5.42 22 8.5
                    c0 3.78-3.4 6.86-8.55 11.18L12 21z"/>
                </svg>
            `;
        } catch (error) {
            this.flash(error.message, "error");
            button.innerHTML = originalHTML;
        } finally {
            button.disabled = false;
        }
    }

    /* ===============================
       REMOVE FROM WISHLIST
    =============================== */
    initRemoveFromWishlist() {
        document.addEventListener("click", (e) => {
            const btn = e.target.closest(".wishlist-remove-btn");
            if (!btn) return;

            e.preventDefault();
            this.handleRemove(btn);
        });
    }

    async handleRemove(button) {
        if (!confirm("Remove from wishlist?")) return;

        const url = button.dataset.url;
        const token = document.querySelector(
            'meta[name="csrf-token"]',
        )?.content;
        const item = button.closest(".wishlist-item");

        button.disabled = true;

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (!response.ok || data.success === false) {
                throw new Error(data.message || "Failed to remove item");
            }

            item?.remove();
            this.updateWishlistCount(data.wishlist_count || 0);
            this.flash(data.message || "Removed from wishlist", "success");
        } catch (error) {
            this.flash(error.message, "error");
            button.disabled = false;
        }
    }

    /* ===============================
       MOVE TO CART
    =============================== */
    initMoveToCart() {
        document.addEventListener("click", (e) => {
            const btn = e.target.closest(".wishlist-move-to-cart-btn");
            if (!btn) return;

            e.preventDefault();
            this.handleMoveToCart(btn);
        });
    }

    async handleMoveToCart(button) {
        const url = button.dataset.url;
        const token = document.querySelector(
            'meta[name="csrf-token"]',
        )?.content;

        button.disabled = true;

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (!response.ok || data.success === false) {
                throw new Error(data.message || "Failed to move to cart");
            }

            this.updateWishlistCount(data.wishlist_count || 0);

            if (window.cartManager) {
                window.cartManager.updateCartCount(data.cart_count || 0);
            }

            this.flash(data.message || "Moved to cart", "success");

            button.closest(".wishlist-item")?.remove();
        } catch (error) {
            this.flash(error.message, "error");
            button.disabled = false;
        }
    }

    /* ===============================
       HELPERS
    =============================== */
    updateWishlistCount(count) {
        const el = document.getElementById("wishlist-count");
        if (!el) return;

        el.textContent = count;
        el.classList.toggle("hidden", count <= 0);
    }

    flash(message, type = "success") {
        if (typeof window.flash === "function") {
            window.flash(message, type);
        } else {
            console.log(`[${type}] ${message}`);
        }
    }
}

/* ===============================
   INIT
================================ */
(function () {
    function boot() {
        if (!window.wishlistManager) {
            window.wishlistManager = new WishlistManager();
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", boot);
    } else {
        boot();
    }
})();
