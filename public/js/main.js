$(document).ready(function () {
  var itemsPerSlide = 4;
  var totalItems = $(".carousel-multiple-item").length;
  var currentIndex = 0;

  $(".carousel-multiple").on("slide.bs.carousel", function (e) {
    var $e = $(e.relatedTarget);
    var activeIndex = $e.index();
    if (activeIndex + itemsPerSlide > totalItems) {
      currentIndex = activeIndex - (totalItems - itemsPerSlide);
    } else {
      currentIndex = activeIndex;
    }
  });

  $(".carousel-multiple").carousel({
    interval: 2000,
  });

  $(".carousel-multiple .carousel-multiple-item").each(function () {
    var minPerSlide = itemsPerSlide;
    var next = $(this).next();
    if (!next.length) {
      next = $(this).siblings(":first");
    }
    next.children(":first-child").clone().appendTo($(this));

    for (var i = 0; i < minPerSlide; i++) {
      next = next.next();
      if (!next.length) {
        next = $(this).siblings(":first");
      }
      next.children(":first-child").clone().appendTo($(this));
    }
  });
});

$(document).ready(function () {
  var itemsPerSlide = 3;
  var totalItems = $(".carousel-multiple-item-product").length;
  var currentIndex = 0;

  $(".carousel-multiple-product").on("slide.bs.carousel", function (e) {
    var $e = $(e.relatedTarget);
    var activeIndex = $e.index();
    if (activeIndex + itemsPerSlide > totalItems) {
      currentIndex = activeIndex - (totalItems - itemsPerSlide);
    } else {
      currentIndex = activeIndex;
    }
  });

  $(".carousel-multiple-product").carousel({
    interval: 2000,
  });

  $(".carousel-multiple-product .carousel-multiple-item-product").each(
    function () {
      var minPerSlide = itemsPerSlide;
      var next = $(this).next();
      if (!next.length) {
        next = $(this).siblings(":first");
      }
      next.children(":first-child").clone().appendTo($(this));

      for (var i = 0; i < minPerSlide; i++) {
        next = next.next();
        if (!next.length) {
          next = $(this).siblings(":first");
        }
        next.children(":first-child").clone().appendTo($(this));
      }
    }
  );
});

function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches(".dropbtn")) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains("show")) {
        openDropdown.classList.remove("show");
      }
    }
  }
};
