import fetcher from "../fetcher.js";

document.addEventListener("DOMContentLoaded", () => {
    const addBrandBtn = document.getElementById("add-brand-btn");
    const token = localStorage.getItem("lynkr_token");

    if (token) {
        addBrandBtn?.classList.remove("hidden");
    }

    const listContainer = document.getElementById("brand-list");
    const searchInput = document.getElementById("search-input");

    const loadBrands = async (query = "") => {
        try {
            const data = await fetcher(
                `/api/lynkr/brands?search=${encodeURIComponent(query)}`
            );
            listContainer.innerHTML = "";

            data.data.forEach((brand) => {
                const card = document.createElement("div");
                // card.innerHTML = `
                //     <div class="brand-card bg-white shadow-md rounded-lg overflow-hidden">
                //         <img src="${brand.image}" alt="${brand.name}" class="brand-image w-full h-48 object-cover">
                //         <div class="brand-text-div p-4">
                //             <p class="brand-rating text-sm text-gray-600">Rating: <b>${brand.rating}</b></p>
                //             <h2 class="brand-name text-xl font-semibold mb-2">${brand.name}</h2>
                //         </div>
                //         <button class="explore-button">EXPLORE MORE</button>
                //     </div>
                // `;

                card.classList.add(
                    "brand-card",
                    "bg-white",
                    "shadow-md",
                    "rounded-lg",
                    "overflow-hidden"
                );

                let cardHtml = `
                    <img src="${brand.image}" alt="${brand.name}" class="brand-image w-full h-48 object-cover">
                    <div class="brand-text-div p-4">
                        <p class="brand-rating text-sm text-gray-600">Rating: <b>${brand.rating}</b></p>
                        <h2 class="brand-name text-xl font-semibold mb-2">${brand.name}</h2>
                    </div>
                    <button class="explore-button">EXPLORE MORE</button>
                `;

                if (token) {
                    cardHtml += `
                    <div class="mt-4 flex justify-between px-4 pb-4 brand-actions">
                        <a href="/brands/${brand.id}/edit" class="edit-button text-blue-600 hover:underline">Edit</a>
                        <button class="text-red-600 hover:underline delete-btn" data-id="${brand.id}">Delete</button>
                    </div>
                `;
                }

                card.innerHTML = cardHtml;
                listContainer.appendChild(card);
            });

            if (token) {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', async (e) => {
                    const confirmed = confirm('Are you sure you want to delete this brand?');
                    if (!confirmed) return;

                    const brandId = e.target.getAttribute('data-id');
                    try {
                        const tokenType = localStorage.getItem('lynkr_token_type') || 'Bearer';

                        const response = await fetch(`/api/lynkr/brands/${brandId}`, {
                            method: 'DELETE',
                            headers: {
                                'Authorization': `${tokenType} ${token}`,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            }
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Failed to delete brand.');
                        }

                        // Reload brands after deletion
                        loadBrands(searchInput?.value || '');

                    } catch (error) {
                        alert(error.message);
                    }
                });
            });
        }

        } catch (error) {
            listContainer.innerHTML =
                '<p class="text-red-600">Failed to load brands.</p>';
        }
    };

    searchInput?.addEventListener("input", (e) => {
        loadBrands(e.target.value);
    });

    loadBrands();
});
