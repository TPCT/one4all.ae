$(document).ready(function () {
  // Cached Selectors
  const $window = $(window);
  const $menuButton = $("#menu-button");
  const $searchContainer = $(".main-navigation-search-container");
  const $cssMenu = $("#cssmenu");
  const $body = $("body");

  // Check if an element is overflowing
  function checkIfOverflowing($element) {
    const elementOffset = $element.offset().left;
    const elementWidth = $element.outerWidth();
    const viewportWidth = $window.width();
    const isArabic = $body.hasClass("arabic-version");

    const isOverflowing = isArabic
      ? elementOffset < 0 || elementOffset + elementWidth > viewportWidth
      : elementOffset + elementWidth > viewportWidth || elementOffset < 0;

    $element.toggleClass("overflowing-menu-container", isOverflowing);
  }

  // Overflow handling for submenu
  $("li.has-sub")
    .on("mouseenter touchstart", function () {
      checkIfOverflowing($(this).find("> ul"));
    })
    .on("mouseleave touchend", function () {
      $(this).find("> ul").removeClass("overflowing-menu-container");
    });

  // Initialize the menu
  $cssMenu.menumaker({ title: "", format: "multitoggle" });

  // Search bar toggle
  $searchContainer.on("click", ".navigation-search", () => {
    $(".searchBarOpen").addClass("search-active");
  });
  $(".searchBarOpen--closeBtn").click(() => {
    $(".searchBarOpen").removeClass("search-active");
  });

  // Dropdown handling for sign-in button
  $(".dropdown.signin-btn > .dropdown-toggle").click(() => {
    $menuButton.removeClass("menu-opened");
    $cssMenu.find("ul, .cssmenu2 ul").removeClass("open").css("display", "");
  });

  // Footer toggle button for mobile
  // $(".toggleButton").click(function () {
  //   if ($window.width() <= 991) {
  //     const $ul = $(this).closest("div").next("ul");
  //     const isShown = $ul.toggleClass("show").hasClass("show");
  //     $(this).find(".fa-plus").toggle(!isShown);
  //     $(this).find(".fa-minus").toggle(isShown);
  //   }
  // });

  // Back to top button
  $(".backtotop-box").click(() => {
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });

  // Navbar active link toggle
  $(".nav-link").click(function () {
    $(".nav-link").removeClass("active");
    $(this).addClass("active");
  });

  // Navbar search toggle
  $(".search-icon").click(() => {
    $(".nav-search, .navbar-search-bar-container").addClass("active");
  });
  $(".close-icon").click(() => {
    $(".nav-search, .navbar-search-bar-container").removeClass("active");
  });

  // Submenu toggle in the navigation
  $(".has-sub").click(function () {
    const $submenu = $(this).find("> ul");
    const isOpen = $submenu.hasClass("open");

    $("li.has-sub > ul").removeClass("open").css("display", "");
    $("li.has-sub > span.submenu-button").removeClass("submenu-opened");

    if (!isOpen) {
      $submenu.addClass("open").css("display", "block");
      $(this).find("span.submenu-button").addClass("submenu-opened");
    }
  });
});
