/* function getCookie(name) {
  var cookieValue = null;
  if (document.cookie && document.cookie !== "") {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
      var cookie = cookies[i].trim();
      if (cookie.substring(0, name.length + 1) === name + "=") {
        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
        break;
      }
    }
  }
  return cookieValue;
}

const handleCheckAccount = () => {
  let userCookie = getCookie("user");
  if (userCookie && userCookie != "" && userCookie != " ") {
    const user = document.querySelector(".topbar__user");
    user.innerHTML = "";
    let html = `
    <i class="fa-regular fa-user"></i>
    <span><a href="tai-khoan.php">${JSON.parse(userCookie).username}</a></span>

    <div class="logout" onClick=handleLogout()>
      <i class="fa-solid fa-right-from-bracket"></i>
      <span>Đăng xuất</span>
    </div>
    `;
    user.innerHTML = html;
  } else {
    const user = document.querySelector(".topbar__user");
    user.innerHTML = `<i class="fa-regular fa-user"></i>
                        <div class="topbar__user__choose">
                            <span data-bs-toggle="modal" data-bs-target="#staticBackdrop">Đăng
                                nhập</span>
                            <span>hoặc</span>
                            <span data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Đăng kí</span>
                        </div>`;
  }
};
handleCheckAccount();

function deleteCookie(name) {
  document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}

const handleLogout = () => {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "logout.php", true);

  xhr.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      window.location.href = "index.php";
    }
  };

  xhr.send();
};
 */
