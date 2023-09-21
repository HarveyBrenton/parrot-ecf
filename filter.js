document.addEventListener("DOMContentLoaded", function () {
    // Récupération des éléments HTML pour le kilométrage
    const mileageRangeMinInput = document.getElementById("mileage-range-min");
    const mileageRangeMaxInput = document.getElementById("mileage-range-max");
    const mileageMinInput = document.getElementById("mileage-input-min");
    const mileageMaxInput = document.getElementById("mileage-input-max");
    const mileageProgress = document.querySelector(".mileage-slider .progress");

    const mileageGap = 1000;

    // Récupération des éléments HTML pour le prix
    const priceRangeMinInput = document.getElementById("price-range-min");
    const priceRangeMaxInput = document.getElementById("price-range-max");
    const priceMinInput = document.getElementById("price-input-min");
    const priceMaxInput = document.getElementById("price-input-max");
    const priceProgress = document.querySelector(".price-slider .progress");

    const priceGap = 1000;

    // Récupération des éléments HTML pour les années
    const yearRangeMinInput = document.getElementById("year-range-min");
    const yearRangeMaxInput = document.getElementById("year-range-max");
    const yearMinInput = document.getElementById("year-input-min");
    const yearMaxInput = document.getElementById("year-input-max");
    const yearProgress = document.querySelector(".year-slider .progress");

    const yearGap = 1;

    // Fonction de mise à jour des valeurs en fonction des curseurs pour le kilométrage
    function updateMileageValues() {
        const minVal = parseInt(mileageRangeMinInput.value);
        const maxVal = parseInt(mileageRangeMaxInput.value);

        if (maxVal - minVal < mileageGap) {
            mileageRangeMinInput.value = maxVal - mileageGap;
        } else {
            mileageMinInput.value = minVal;
            mileageMaxInput.value = maxVal;
            mileageProgress.style.left = (minVal / mileageRangeMinInput.max) * 100 + "%";
            mileageProgress.style.right = 100 - (maxVal / mileageRangeMaxInput.max) * 100 + "%";
        }

        // Appeler la fonction de mise à jour des résultats après avoir mis à jour les valeurs
        updateFilteredResults();
    }

    // Fonction de mise à jour des valeurs en fonction des curseurs pour le prix
    function updatePriceValues() {
        const minVal = parseInt(priceRangeMinInput.value);
        const maxVal = parseInt(priceRangeMaxInput.value);

        if (maxVal - minVal < priceGap) {
            priceRangeMinInput.value = maxVal - priceGap;
        } else {
            priceMinInput.value = minVal;
            priceMaxInput.value = maxVal;
            priceProgress.style.left = (minVal / priceRangeMinInput.max) * 100 + "%";
            priceProgress.style.right = 100 - (maxVal / priceRangeMaxInput.max) * 100 + "%";
        }

        // Appeler la fonction de mise à jour des résultats après avoir mis à jour les valeurs
        updateFilteredResults();
    }

    // Fonction de mise à jour des valeurs en fonction des curseurs pour les années
    function updateYearValues() {
        const minVal = parseInt(yearRangeMinInput.value);
        const maxVal = parseInt(yearRangeMaxInput.value);

        if (maxVal - minVal < yearGap) {
            yearRangeMinInput.value = maxVal - yearGap;
        } else {
            yearMinInput.value = minVal;
            yearMaxInput.value = maxVal;
            yearProgress.style.left = ((minVal - yearRangeMinInput.min) / (yearRangeMinInput.max - yearRangeMinInput.min)) * 100 + "%";
            yearProgress.style.right = 100 - ((maxVal - yearRangeMaxInput.min) / (yearRangeMaxInput.max - yearRangeMaxInput.min)) * 100 + "%";
        }

        // Appeler la fonction de mise à jour des résultats après avoir mis à jour les valeurs
        updateFilteredResults();
    }

    // Fonction pour mettre à jour les résultats en fonction des valeurs de filtrage
function updateFilteredResults() {
    // Récupérez les valeurs de filtrage
    const minMileage = parseInt(mileageMinInput.value);
    const maxMileage = parseInt(mileageMaxInput.value);
    const minPrice = parseInt(priceMinInput.value);
    const maxPrice = parseInt(priceMaxInput.value);
    const minYear = parseInt(yearMinInput.value);
    const maxYear = parseInt(yearMaxInput.value);

    // Filtrer les véhicules en fonction des critères
    const filteredVehicles = vehicles.filter(vehicle => {
        return (
            vehicle.mileage >= minMileage &&
            vehicle.mileage <= maxMileage &&
            vehicle.price >= minPrice &&
            vehicle.price <= maxPrice &&
            vehicle.year >= minYear &&
            vehicle.year <= maxYear
        );
    });

    // Mettre à jour l'affichage des résultats
    const resultsContainer = document.getElementById("results-container");
    resultsContainer.innerHTML = "";

    if (filteredVehicles.length === 0) {
        // Si aucun résultat n'est trouvé, affiche "Aucun résultat trouvé"
        resultsContainer.innerHTML = "<p class='no-result'>Aucun résultat trouvé</p>";
    } else {
        // Afficher les véhicules filtrés
        filteredVehicles.forEach(vehicle => {
            const vehicleElement = document.createElement("div");
            vehicleElement.classList.add("vehicle");
            vehicleElement.innerHTML = `
                <a href="./details.php?id=${vehicle.id}" class="detail-link">
                    <img src="${vehicle.image}" alt="${vehicle.title}">
                </a>
                <div class="text-content">
                    <h3>${vehicle.title}</h3>
                    <p>Prix: ${vehicle.price} €<br>
                    Année: ${vehicle.year}<br>
                    Kilométrage: ${vehicle.mileage} km</p>
                    <a href="./details.php?id=${vehicle.id}" class="detail-link">+ Détails</a><br>
                    <a href="./contactId.php?id=${vehicle.id}" class="detail-link">+ Contact</a>
                </div>
            `;
            resultsContainer.appendChild(vehicleElement);
        });
    }
}

    // Écouteurs d'événements pour les curseurs du kilométrage
    mileageRangeMinInput.addEventListener("input", updateMileageValues);
    mileageRangeMaxInput.addEventListener("input", updateMileageValues);

    // Écouteurs d'événements pour les curseurs du prix
    priceRangeMinInput.addEventListener("input", updatePriceValues);
    priceRangeMaxInput.addEventListener("input", updatePriceValues);

    // Écouteurs d'événements pour les curseurs des années
    yearRangeMinInput.addEventListener("input", updateYearValues);
    yearRangeMaxInput.addEventListener("input", updateYearValues);

    // Appeler la fonction initiale pour afficher les résultats non filtrés
    updateFilteredResults();
});
