let logoutToggle = document.getElementById("Logout-Toggle");
let logoutButton = document.getElementById("Logout");

logoutToggle.addEventListener("click", () => {
    if (getComputedStyle(logoutButton).display === "none") {
        logoutButton.style.display = "flex";
    }
    else {
        logoutButton.style.display = "none";
    }
});
