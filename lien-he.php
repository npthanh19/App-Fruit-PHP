<?php include('./partial/header.php'); ?>

<main>
    <div class="contact">
        <div class="container">
            <div class="d-flex">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="contact__form">
                        <form action="" method="get">
                            <input type="text" placeholder="Họ tên">
                            <input type="text" placeholder="Email">
                            <input type="text" placeholder="Điện thoại">
                            <textarea name="" id="" cols="30" rows="10" placeholder="Nhập nội dung"></textarea>
                            <input type="submit" placeholder="Gửi liên hệ">
                        </form>
                    </div>
                </div>
                <div class="col-6">
                    <div class="contact__info">
                        <ul>
                            <li>
                                <div class="contact__info__img">
                                    <div class="contact__info__icon">
                                        <i class="fa-solid fa-shop"></i>
                                    </div>
                                </div>
                                <div class="contact__info__desc">
                                    <h3>Địa chỉ liên hệ</h3>
                                    <span>338 Hai Bà Trưng, Phường Tân định, Quận 1, Tp Hồ Chí Minh</span>
                                </div>
                            </li>
                            <li>
                                <div class="contact__info__img">
                                    <div class="contact__info__icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                </div>
                                <div class="contact__info__desc">
                                    <h3>Số điện thoại</h3>
                                    <span>0909131418 - 0798531637</span>
                                    <span>Thứ 2 - Chủ nhật: 7:00 - 21:00</span>
                                </div>
                            </li>
                            <li>
                                <div class="contact__info__img">
                                    <div class="contact__info__icon">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="contact__info__desc">
                                    <h3>Email</h3>
                                    <span>hong3ly@gmail.com</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.2787944155207!2d106.68736481462268!3d10.789946192312346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528cd4a781e15%3A0xb0047b51393359f2!2zMzM4IEhhaSBCw6AgVHLGsG5nLCBUw6JuIMSQ4buLbmgsIFF14bqtbiAxLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZpZXRuYW0!5e0!3m2!1sen!2s!4v1597808820552!5m2!1sen!2s"
                    width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                    tabindex="0"></iframe>
            </div>
        </div>
    </div>
</main>

<?php include('./partial/footer.php'); ?>