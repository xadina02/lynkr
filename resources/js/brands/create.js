import fetcher from "../fetcher.js";

document.addEventListener("DOMContentLoaded", () => {
    const token = localStorage.getItem("lynkr_token");
    const tokenType = localStorage.getItem("lynkr_token_type") || "Bearer";
    const form = document.getElementById("add-brand-form");
    const errorDiv = document.getElementById("form-error");
    const countriesSelect = document.getElementById("countries");

    const loadCountries = async () => {
        try {
            const response = await fetcher("/api/lynkr/countries");
            const countries = Array.isArray(response.data) ? response.data : [];

            let optionsHtml = "";
            countries.forEach((country) => {
                optionsHtml += `<option value="${country.code}">${country.name}</option>`;
            });
            countriesSelect.innerHTML = optionsHtml;
        } catch (err) {
            console.error("Failed to load countries:", err);
            errorDiv.textContent = "Failed to load countries.";
        }
    };

    loadCountries();

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        errorDiv.textContent = "";

        const name = form.name.value.trim();
        const rating = Number(form.rating.value);
        const imageFile = form.image.files[0];
        const countries = Array.from(form.countries.selectedOptions).map(
            (opt) => opt.value
        );

        if (
            !name ||
            !imageFile ||
            countries.length === 0 ||
            isNaN(rating) ||
            rating < 1 ||
            rating > 5
        ) {
            errorDiv.textContent = "Please fill out all fields correctly.";
            return;
        }

        const formData = new FormData();
        formData.append("name", name);
        formData.append("rating", rating);
        formData.append("image", imageFile);
        countries.forEach((countryCode) =>
            formData.append("country_codes[]", countryCode)
        );

        try {
            const response = await fetch("/api/lynkr/brands/create", {
                method: "POST",
                headers: {
                    Authorization: `${tokenType} ${token}`,
                    Accept: "application/json",
                },
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || "Failed to add brand.");
            }

            window.location.href = "/";
        } catch (err) {
            errorDiv.textContent = err.message || "Failed to add brand.";
        }
    });
});
