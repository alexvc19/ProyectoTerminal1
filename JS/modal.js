
const errorModal = document.getElementById("errorModal");
const successModal = document.getElementById("successModal");
const closeErrorModal = document.getElementById("closeErrorModal");
const closeSuccessModal = document.getElementById("closeSuccessModal");


function showErrorModal() {
    errorModal.style.display = "block";
};


function showSuccessModal() {
    successModal.style.display = "block";
};

// Cerrar ventanas modales al hacer clic en el botón de cierre
closeErrorModal.addEventListener("click", () => {
    errorModal.style.display = "none";
});

closeSuccessModal.addEventListener("click", () => {
    successModal.style.display = "none";
});

// Cerrar ventanas modales al hacer clic fuera de ellas
window.addEventListener("click", (event) => {
    if (event.target === errorModal) {
        errorModal.style.display = "none";
    }
    if (event.target === successModal) {
        successModal.style.display = "none";
    }
});
