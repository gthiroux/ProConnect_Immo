document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('rdv_date');
    const errorDisplay = document.getElementById('rdv_error');
    if (!input) return;

    const minDate = new Date();
    minDate.setHours(minDate.getHours() + 24);
    
    input.min = minDate.toISOString().slice(0, 16);

    input.addEventListener('change', () => {
        const selectedDate = new Date(input.value);
        const day = selectedDate.getDay();
        const hour = selectedDate.getHours();
        let message = "";

        if (day === 0) {
            message = "Nous sommes fermés le dimanche.";
        } else if (hour < 9 || hour >= 19) {
            message = "Horaires d'ouverture : 09h00 à 19h00.";
        } else if (selectedDate < minDate) {
            message = "Le délai minimum est de 24h.";
        }

        errorDisplay.textContent = message;

        if (message !== "") {
            input.style.borderColor = "#d32f2f";
            input.value = "";
        } else {
            input.style.borderColor = "#2e7d32";
            errorDisplay.textContent = "Créneau disponible";
            errorDisplay.style.color = "#2e7d32";
        }
    });
});