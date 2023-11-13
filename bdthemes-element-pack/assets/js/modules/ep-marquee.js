(function ($, elementor) {
  $(window).on("elementor/frontend/init", function () {
    let ModuleHandler = elementorModules.frontend.handlers.Base,
      ListMarquee;

    ListMarquee = ModuleHandler.extend({
      bindEvents: function () {
        this.run();
      },
      getDefaultSettings: function () {
        return {
          allowHTML: true,
        };
      },

      onElementChange: debounce(function (prop) {
        if (prop.indexOf("marquee_") !== -1) {
          this.run();
        }
      }, 400),

      settings: function (key) {
        return this.getElementSettings("marquee_" + key);
      },

      pauseOnHover: function (rollingTween) {
        $(".marquee-rolling").on("mouseenter", () => {
          rollingTween.pause();
        });
        $(".marquee-rolling").on("mouseleave", () => {
          rollingTween.play();
        });
      },
      run: function () {
        const widgetID = this.$element.data("id");
        var self = this;
        var options = this.getDefaultSettings();
        var element = this.findElement(".elementor-widget-container").get(0);
        if (jQuery(this.$element).hasClass("elementor-section")) {
          element = this.$element.get(0);
        }
        var $container = this.$element.find(".bdt-marquee");
        if (!$container.length) {
          return;
        }

        var widgetContainer = ".elementor-element-" + widgetID;
        var rollingTween = new TimelineMax({ paused: false });
        var time = this.settings("speed");
        var marqueeRolling = $container.find(".marquee-rolling");

        function startRolling() {
          marqueeRolling.css({ width: "auto" });
          var width = marqueeRolling.width();
          marqueeRolling.width(width);
          if (self.settings("direction") === "right") {
            TweenLite.set(widgetContainer + " .marquee-rolling-wrapper", {
              x: -width - 0,
            });
            var directionWidth = width;
          } else {
            var directionWidth = -width;
          }

          rollingTween.to(
            widgetContainer + " .marquee-rolling",
            time,
            {
              x: directionWidth,
              ease: Linear.easeIn,
              repeat: -1,
            },
            0
          );
          console.log(self.settings("pause_on_hover"));
          if (self.settings("pause_on_hover") === "yes") {
            self.pauseOnHover(rollingTween);
          }
          return rollingTween;
        }

        function rollingText() {
          var holder, clone, counter;
          holder = widgetContainer + " .marquee-rolling-wrapper";
          counter = $(widgetContainer + " .marquee-rolling").children().length;
          var marqueeType = self.settings("type");
          var cloneLimit = marqueeType === "text" ? 6 : 6;
          for (counter = Number(counter); counter <= cloneLimit; counter++) {
            clone = $(widgetContainer + " .marquee-rolling").clone();
            clone.prependTo(holder);
          }
          $(widgetContainer + " .marquee-rolling")
            .clone()
            .appendTo(widgetContainer + " .marquee-rolling-wrapper");
          startRolling();
        }
        rollingText();
      },
    });

    elementorFrontend.hooks.addAction(
      "frontend/element_ready/bdt-marquee.default",
      function ($scope) {
        elementorFrontend.elementsHandler.addHandler(ListMarquee, {
          $element: $scope,
        });
      }
    );
  });
})(jQuery, window.elementorFrontend);
