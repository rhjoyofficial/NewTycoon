document.addEventListener("DOMContentLoaded", () => {
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

    gsap.registerPlugin(ScrollTrigger);

    const section = document.querySelector(".featured-products-section");
    if (!section) return;

    lazyInitElement(section, () => {
        const skeletons = section.querySelector(".featured-skeletons");
        const productsGrid = section.querySelector(".featured-products");
        const title = section.querySelector(".featured-products-title");
        const cards = section.querySelectorAll(".featured-product-card");

        // Initial states
        gsap.set(title, { opacity: 0, y: 30 });
        gsap.set(cards, { opacity: 0, y: 40, scale: 0.96 });

        const tl = gsap.timeline();

        // 1️⃣ Fade out skeletons
        if (skeletons && productsGrid) {
            tl.to(skeletons, {
                opacity: 0,
                duration: 0.4,
                ease: "power1.out",
            }).add(() => {
                skeletons.classList.add("hidden");
                productsGrid.classList.remove("hidden");
            });
        }

        // 2️⃣ Animate title
        tl.to(title, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: "power3.out",
        })

            // 3️⃣ Animate cards
            .to(
                cards,
                {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.6,
                    ease: "power3.out",
                    stagger: {
                        each: 0.08,
                        grid: "auto",
                        from: "start",
                    },
                },
                "-=0.2",
            );
    });
});

function lazyInitElement(element, callback, options = {}) {
    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    callback(element);
                    obs.disconnect();
                }
            });
        },
        {
            rootMargin: "0px 0px -20% 0px",
            threshold: 0.1,
            ...options,
        },
    );

    observer.observe(element);
}
