(function ($) {
  $.fn.menumaker = function (options) {
    var cssmenu = $(this),
      settings = $.extend(
        {
          title: "Menu",
          format: "dropdown",
          breakpoint: 1199,
          sticky: false,
        },
        options
      );

    return this.each(function () {
      cssmenu
        .find("li ul")
        .parent()
        .each(function () {
          var parentLi = $(this);
          // Check if the 'has-sub' class is already present
          if (!parentLi.hasClass("has-sub")) {
            parentLi.addClass("has-sub");
          }
          // Add submenu icon if not present
          if (parentLi.children(".submenu-button").length === 0) {
            parentLi.prepend(
              '<span class="submenu-button"><i class="fa-solid fa-plus"></i></span>'
            );
          }
        });

      if (settings.format != "select") {
        cssmenu.prepend(
          '<div id="menu-button">' +
            '<i class="fa-solid fa-bars"></i> ' +
            settings.title +
            "</div>"
        );
        $(this)
          .find("#menu-button")
          .on("click", function () {
            $(this).toggleClass("menu-opened");
            var mainmenu = $(this).siblings("ul");
            if (mainmenu.hasClass("open")) {
              mainmenu.hide().removeClass("open");
              if ($(window).scrollTop() === 0) {
                $(".main-navigation--container").removeClass(
                  "navigation-scrolled"
                );
              }
            } else {
              mainmenu.show().addClass("open");
              if ($(window).scrollTop() === 0) {
                $(".main-navigation--container").addClass(
                  "navigation-scrolled"
                );
              }
              if (settings.format === "dropdown") {
                mainmenu.find("ul").show();
              }
            }
            var icon = $(this).find("i");
            if ($(this).hasClass("menu-opened")) {
              icon.removeClass("fa-bars").addClass("fa-xmark");
            } else {
              icon.removeClass("fa-xmark").addClass("fa-bars");
            }
          });

        multiTg = function () {
          function updateMenu() {
            var screenWidth = $(window).width();

            if (screenWidth <= 1200) {
              if (cssmenu.find(".submenu-button").length === 0) {
                cssmenu
                  .find(".has-sub")
                  .prepend(
                    '<span class="submenu-button"><i class="fa-solid fa-plus"></i></span>'
                  );
              }
            } else {
              cssmenu.find(".submenu-button").remove();
            }
          }

          updateMenu();

          cssmenu.find(".submenu-button").on("click", function (e) {
            e.stopPropagation();
            var parentLi = $(this).closest("li");
            var $submenu = $(this).siblings("ul");

            parentLi.siblings().find("ul").removeClass("open").slideUp();
            parentLi
              .siblings()
              .find(".submenu-button i")
              .removeClass("fa-minus")
              .addClass("fa-plus");

            $submenu.toggleClass("open").slideToggle();
            $(this).toggleClass("submenu-opened");

            var icon = $(this).find("i");
            icon.toggleClass("fa-plus fa-minus");
          });
        };

        if (settings.format === "multitoggle") multiTg();
        else cssmenu.addClass("dropdown");
      } else if (settings.format === "select") {
        cssmenu.append('<select style="width: 100%"/>').addClass("select-list");
        var selectList = cssmenu.find("select");
        selectList.append("<option>" + settings.title + "</option>", {
          selected: "selected",
          value: "",
        });
        cssmenu.find("a").each(function () {
          var element = $(this),
            indentation = "";
          for (i = 1; i < element.parents("ul").length; i++) {
            indentation += "-";
          }
          selectList.append(
            '<option value="' +
              $(this).attr("href") +
              '">' +
              indentation +
              element.text() +
              "</option"
          );
        });
        selectList.on("change", function () {
          window.location = $(this).find("option:selected").val();
        });
      }

      if (settings.sticky === true) cssmenu.css("position", "fixed");

      resizeFix = function () {
        if ($(window).width() > settings.breakpoint) {
          cssmenu.find("ul").show();
          cssmenu.removeClass("small-screen");
          if (settings.format === "select") {
            cssmenu.find("select").hide();
          } else {
            cssmenu.find("#menu-button").removeClass("menu-opened");
          }
        }

        if (
          $(window).width() <= settings.breakpoint &&
          !cssmenu.hasClass("small-screen")
        ) {
          cssmenu.find("ul").hide().removeClass("open");
          cssmenu.addClass("small-screen");
          if (settings.format === "select") {
            cssmenu.find("select").show();
          }
        }
      };
      resizeFix();
      return $(window).on("resize", resizeFix);
    });
  };
})(jQuery);

// $(document).ready(function () {
//   $("a.calculator-sub-toggle").on("click", function (e) {
//     e.preventDefault();
//     var submenu = $(this).next("ul");
//     var span = $(this).find("i");

//     if (submenu.hasClass("calculator-sub-closed")) {
//       submenu.removeClass("calculator-sub-closed").addClass("calculator-sub-open");
//       $(this).closest("li").removeClass("calculator-closed").addClass("calculator-open");
//       span.removeClass("fa-chevron-down").addClass("fa-chevron-up");
//     } else {
//       submenu.removeClass("calculator-sub-open").addClass("calculator-sub-closed");
//       $(this).closest("li").removeClass("calculator-open").addClass("calculator-closed");
//       span.removeClass("fa-chevron-up").addClass("fa-chevron-down");
//     }
//   });
// });
