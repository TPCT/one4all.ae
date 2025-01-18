document.addEventListener("DOMContentLoaded", function () {
  // Footer menu maker logic
  const menuMaker = (selector, options) => {
    const menu = document.querySelector(selector);
    const { title = "", format = "multitoggle" } = options;
    // Add your menu logic here if needed
  };

  menuMaker("#cssmenu", {
    title: "",
    format: "multitoggle",
  });

  const breakpointValue = 991;

  // Ensure the initial icon states
  document
    .querySelectorAll(".main-footer-container .fa-chevron-down")
    .forEach((plusIcon) => {
      plusIcon.style.display = "block";
    });
  document
    .querySelectorAll(".main-footer-container .fa-chevron-up")
    .forEach((minusIcon) => {
      minusIcon.style.display = "none";
    });

  // Handle toggle button click
  document.querySelectorAll(".toggleButton").forEach((button) => {
    button.addEventListener("click", function () {
      // Check if the window width is less than or equal to the breakpoint
      if (window.innerWidth <= breakpointValue) {
        const footerItem = this.closest(".footer-item");
        const ulElement = footerItem.querySelector("ul");

        // Toggle the visibility of the target element using classes
        ulElement.classList.toggle("show");

        // Toggle the icon based on the presence of the 'show' class
        const hasShowClass = ulElement.classList.contains("show");
        this.querySelector(".fa-chevron-down").style.display = hasShowClass
          ? "none"
          : "block";
        this.querySelector(".fa-chevron-up").style.display = hasShowClass
          ? "block"
          : "none";
      }
    });
  });
});
