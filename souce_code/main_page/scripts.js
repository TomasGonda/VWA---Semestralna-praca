function updateText() {
    const text = document.getElementById("welcome-text");

    if (window.innerWidth <= 480) {
        text.textContent = "Vitajte na webovej stránke firmy LGR electronics";
    } else if (window.innerWidth > 480 && window.innerWidth <= 768) {
        text.textContent = "Vitajte na webovej stránke slovenského výrobcu elektronických výsledkových panelov pre šport.";
    } else {
        text.textContent = "Vitajte na webovej stránke firmy LGR electronic, spol. s r.o. z Prievidze – slovenského výrobcu elektronických výsledkových panelov pre šport.";
    } 
}
window.addEventListener("resize", updateText);
updateText();