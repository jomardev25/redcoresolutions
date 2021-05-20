
(function($) {
    "use strict";
    var path = window.location.href;
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

    $(".card-fullscreen").click(function(e) {
        e.preventDefault();
        $(".tooltip").remove();
        var $this = $(this);
        if ($this.children("i").hasClass("fa-expand")) {
          $this.children("i").removeClass("fa-expand");
          $this.children("i").addClass("fa-compress");
        } else if ($this.children("i").hasClass("fa-compress")) {
          $this.children("i").removeClass("fa-compress");
          $this.children("i").addClass("fa-expand");
        }
        $(this)
          .closest(".card")
          .toggleClass("fullscreen", 1000);
    });

    $(".card-close").click(function(e) {
    e.preventDefault();
    $(".tooltip").remove();
    $(this)
        .closest(".card")
        .remove();
    });

    $(".card-collapsable").click(function(e) {
        e.preventDefault();
        var $this = $(this);

        if ($this.children("i").hasClass("fa-chevron-up")) {
          $this.children("i").removeClass("fa-chevron-up");
          $this.children("i").addClass("fa-chevron-down");
        } else if ($this.children("i").hasClass("fa-chevron-down")) {
          $this.children("i").removeClass("fa-chevron-down");
          $this.children("i").addClass("fa-chevron-up");
        }

        $(this)
          .closest(".card")
          .toggleClass("minimized", 1000);
    });

    var notification = function(options) {
        var defaults = {
          type: "info",
          title: "CMS",
        };

        var opt = defaults;

        if (options) opt = $.extend(defaults, options);

        var type = opt.type,
          message = opt.message,
          title = opt.title;

        toastr.options = {
          closeButton: true,
          debug: false,
          newestOnTop: false,
          progressBar: true,
          positionClass: "toast-top-right",
          onclick: null,
          showDuration: "1000",
          hideDuration: "1000",
          timeOut: "5000",
          extendedTimeOut: "1000",
          showEasing: "swing",
          hideEasing: "linear",
          showMethod: "fadeIn",
          hideMethod: "fadeOut",
          preventDuplicates: true,
        };

        if (type == "danger") type = "error";
        toastr[type](message, title);
    };

    var notify = $(".notification"),
      type = notify.data("notify"),
      driver = notify.data("driver"),
      message = notify.data("message"),
      title = notify.data("title");
    notification({ driver, type, message, title });

})(jQuery);
