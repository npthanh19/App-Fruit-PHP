<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./styles/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Fruit Home - Quản trị</title>
    <link rel="icon" type="image/x-icon" href="./assets/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--  -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

</head>
<style>
.content {
    transition: width 0.3s ease-in-out;
}

.sidebar-collapsed {
    width: 0px;
    transition: width 0.3s ease-in-out;
    height: 100vh;
}

.content-expanded {
    width: 100%;
    transition: width 0.5s ease-in-out;
}

.content-dashboard {
    overflow-y: scroll;
    height: 100vh;
}

/* .section-content {
    height: 100vh;
    overflow-y: scroll;
} */
</style>

<body>
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-2 sidenav">
                <?php include('./menu.php') ?>
            </div>

            <div class="col content-dashboard">

                <?php include('./section.php') ?>

            </div>
        </div>
    </div>
    <!-- <?php include('./footer.php') ?> -->

</body>
<script>
const sidebar = document.querySelector(".sidenav");
const content = document.querySelector(".content-dashboard");
const menuButton = document.querySelector(".btn-menu");

menuButton.addEventListener("click", () => {
    const isSidebarCollapsed = sidebar.classList.contains("sidebar-collapsed");

    sidebar.classList.toggle("sidebar-collapsed");
    content.classList.toggle("content-expanded");

    localStorage.setItem("sidebarCollapsed", isSidebarCollapsed ? "false" : "true");
});

const storedSidebarCollapsed = localStorage.getItem("sidebarCollapsed");
if (storedSidebarCollapsed === "true") {
    sidebar.classList.add("sidebar-collapsed");
    content.classList.remove("content-expanded");
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="./js/main.js"></script>

</html>