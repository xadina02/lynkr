import "./bootstrap";
import "./fetcher";
import "./login";
import "./brands/index";
import "./brands/create";
// import "./brands/edit";

const toggleAuthUI = () => {
    const authNav = document.getElementById("auth-nav");
    const guestNav = document.getElementById("guest-nav");
    const token = localStorage.getItem("lynkr_token");

    if (authNav && guestNav) {
        if (token) {
            authNav.classList.remove("hidden");
            guestNav.classList.add("hidden");
        } else {
            authNav.classList.add("hidden");
            guestNav.classList.remove("hidden");
        }
    }
};

document.addEventListener("DOMContentLoaded", () => {
    toggleAuthUI();

    const logoutForm = document.getElementById("logout-form");

    if (logoutForm) {
        logoutForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const token = localStorage.getItem("lynkr_token");
            const tokenType =
                localStorage.getItem("lynkr_token_type") || "Bearer";

            try {
                const response = await fetch("/api/lynkr/auth/logout", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: `${tokenType} ${token}`,
                    },
                    body: JSON.stringify({}),
                });

                if (!response.ok) {
                    const error = await response.json();
                    throw new Error(error.message || "Logout failed.");
                }

                localStorage.removeItem("lynkr_token");
                localStorage.removeItem("lynkr_token_type");
                localStorage.removeItem("lynkr_user");

                window.location.href = "/";
            } catch (err) {
                alert(err.message);
            }
        });
    }
});
