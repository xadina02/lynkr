import fetcher from "../fetcher.js";

document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("lynkr_token");
    const tokenType = localStorage.getItem("lynkr_token_type") || "Bearer";
    const form = document.getElementById("update-brand-form");
    const errorDiv = document.getElementById("form-error");
    const countriesSelect = document.getElementById("countries");
    const brandId = document.querySelector(".form-container").dataset.brandId;

    const loadCountries = async (selectedCodes = []) => {
        try {
            const response = await fetcher("/api/lynkr/countries");
            const countries = Array.isArray(response.data) ? response.data : [];

            countriesSelect.innerHTML = "";
            countries.forEach((country) => {
                const option = document.createElement("option");
                option.value = country.code;
                option.textContent = country.name;
                if (selectedCodes.includes(country.code)) {
                    option.selected = true;
                }
                countriesSelect.appendChild(option);
            });
        } catch (err) {
            errorDiv.textContent = "Failed to load countries.";
        }
    };

    const loadBrand = async () => {
        try {
            const response = await fetcher(`/api/lynkr/brands/${brandId}`);
            const brand = response.data;

            form.name.value = brand.name;
            form.rating.value = brand.rating;
            await loadCountries(brand.country_codes || []);
        } catch (err) {
            errorDiv.textContent = "Failed to load brand details.";
        }
    };

    await loadBrand();

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        errorDiv.textContent = "";

        const name = form.name.value.trim();
        const rating = Number(form.rating.value);
        const imageFile = form.image.files[0];
        const countries = Array.from(form.countries.selectedOptions).map(opt => opt.value);

        if (!name || isNaN(rating) || rating < 1 || rating > 5 || countries.length === 0) {
            errorDiv.textContent = "Please fill out all fields correctly.";
            return;
        }

        const formData = new FormData();
        formData.append("name", name);
        formData.append("rating", rating);
        countries.forEach((code) => formData.append("country_codes[]", code));
        if (imageFile) formData.append("image", imageFile);

        try {
            const response = await fetch(`/api/lynkr/brands/${brandId}`, {
                method: "POST",
                headers: {
                    Authorization: `${tokenType} ${token}`,
                    Accept: "application/json"
                },
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || "Failed to update brand.");
            }

            window.location.href = "/brands";
        } catch (err) {
            errorDiv.textContent = err.message || "Failed to update brand.";
        }
    });
});
