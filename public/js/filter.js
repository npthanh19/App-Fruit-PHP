document
  .getElementById("traiCayBanOnline")
  .addEventListener("change", function () {
    if (this.checked) {
      window.location.href = "./san-pham.php?loai=traicaybanonline";
    }
  });

document
  .getElementById("traiCayBanTaiQuay")
  .addEventListener("change", function () {
    if (this.checked) {
      window.location.href = "./san-pham.php?loai=traicaybantaiquay";
    }
  });

document.addEventListener("DOMContentLoaded", function () {
  const checkboxes = document.querySelectorAll("input[type='checkbox']");
  checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
      if (this.checked) {
        const filterValue = this.getAttribute("data-filter");
        if (filterValue) {
          window.location.href = `./san-pham.php?gia=${filterValue}`;
        }
      }
    });
  });
});
