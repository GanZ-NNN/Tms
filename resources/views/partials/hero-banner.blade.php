<section class="banner-section" style="background-image: url('{{ asset('assets/img/410_devtai.jpg') }}'); >
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content: Search + Text -->
                <div class="col-lg-7">
                    <div class="section-search">
                        <h1>ค้นหาหลักสูตรที่คุณต้องการ<br><span>ได้ที่นี่ !!</span></h1>
                        <p>หลักสูตร การอบรม ประเภทการอบรม ค้นหาได้อย่างรวดเร็ว</p>

                        <!-- Search Form -->
                        <form action="{{ route('programs.index') }}" method="GET" class="d-flex flex-wrap gap-2 mt-4">
                            <div class="flex-grow-1">
                                <input type="text" name="keyword" class="form-control form-control-lg shadow-sm" placeholder="🔍 ค้นหาหลักสูตร...">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg fw-bold px-4">ค้นหา</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Content: Image / Illustration -->
                <!-- <div class="col-lg-5">
                    <div class="banner-imgs">
                        <img src="{{ asset('assets/img/Monogram-Logo-02.png') }}" alt="Illustration" class="img-fluid">
                    </div>
                </div> -->
            </div>
    </section>
