(function () {
    function revealElements() {
        var items = document.querySelectorAll("[data-animate]");
        if (!items.length) {
            return;
        }

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12 },
        );

        items.forEach(function (item, idx) {
            item.classList.add("fx-reveal");
            item.style.transitionDelay = Math.min(idx * 45, 360) + "ms";
            observer.observe(item);
        });
    }

    function attachTiltCards() {
        var cards = document.querySelectorAll(".tilt-card");
        cards.forEach(function (card) {
            card.addEventListener("mousemove", function (event) {
                var r = card.getBoundingClientRect();
                var x = event.clientX - r.left;
                var y = event.clientY - r.top;
                var rx = (y / r.height - 0.5) * -6;
                var ry = (x / r.width - 0.5) * 6;
                card.style.transform =
                    "perspective(800px) rotateX(" +
                    rx +
                    "deg) rotateY(" +
                    ry +
                    "deg)";
            });

            card.addEventListener("mouseleave", function () {
                card.style.transform =
                    "perspective(800px) rotateX(0deg) rotateY(0deg)";
            });
        });
    }

    function addLoadBar() {
        if (document.getElementById("ui-loading-bar")) {
            return;
        }

        var bar = document.createElement("div");
        bar.id = "ui-loading-bar";
        document.body.appendChild(bar);
        bar.style.width = "80%";

        window.setTimeout(function () {
            bar.style.width = "100%";
            window.setTimeout(function () {
                bar.style.opacity = "0";
            }, 180);
        }, 220);
    }

    function setupPageLoader() {
        var pageLoader = document.getElementById("ui-page-loader");
        if (!pageLoader) {
            return;
        }

        function hideLoader() {
            pageLoader.classList.add("is-hidden");
            window.setTimeout(function () {
                if (pageLoader && pageLoader.parentNode) {
                    pageLoader.parentNode.removeChild(pageLoader);
                }
            }, 280);
        }

        // Keep loader visible briefly to avoid flashing on very fast renders.
        window.setTimeout(hideLoader, 220);
        window.addEventListener("load", hideLoader, { once: true });
    }

    function enhancedAlerts() {
        var flash = document.querySelector("[data-flash-type]");
        if (!flash || typeof window.Swal === "undefined") {
            return;
        }

        Swal.fire({
            icon: flash.getAttribute("data-flash-type"),
            title: flash.getAttribute("data-flash-title") || "Notification",
            text: flash.getAttribute("data-flash-message") || "",
            timer: 2400,
            showConfirmButton: false,
            toast: true,
            position: "top-end",
            background: "#ffffff",
            color: "#1a2f43",
        });
    }

    function setupActionAlerts() {
        var trigger = document.querySelector(
            '[data-action="show-system-alert"]',
        );
        if (!trigger || typeof window.Swal === "undefined") {
            return;
        }

        trigger.addEventListener("click", function () {
            Swal.fire({
                title: "Command Center",
                html: '<p style="margin:0">Live UX effects are active. Hover cards, switch brands, and trigger exports to see transitions.</p>',
                icon: "info",
                confirmButtonText: "Continue",
                background: "#ffffff",
                color: "#1a2f43",
                confirmButtonColor: "#0f9f99",
            });
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        setupPageLoader();
        addLoadBar();
        revealElements();
        attachTiltCards();
        enhancedAlerts();
        setupActionAlerts();
    });
})();
