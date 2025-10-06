<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KKU Footer Component</title>
    <!-- โหลด Tailwind CSS และ Font Awesome สำหรับไอคอน -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- สไตล์ CSS สำหรับ Footer โดยเฉพาะ -->
    <style>
        /* ตั้งค่าฟอนต์หลักและรีเซ็ตพื้นฐาน */
        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0; /* ตรวจสอบให้แน่ใจว่าไม่มี margin ที่ body */
        }

        /* --------------------
           ส่วน Footer หลัก
           -------------------- */
        .main-footer {
            /* ไม่ต้องมี margin-top: auto; เมื่อแยกโค้ด จะได้ไม่ดันตัวเองลงด้านล่าง */
            background-color: #1a1a1a; /* สีพื้นหลังเข้มมาก */
            color: #fff; /* สีตัวอักษรหลัก */
            padding: 4rem 0 0; /* ระยะห่างด้านบน */
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.2);
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: grid;
            /* ปรับเป็น 3 คอลัมน์: About (2fr), Contact Info (1fr), Policy (1fr) */
            grid-template-columns: 2fr 1fr 1fr;
            gap: 2rem; /* ระยะห่างระหว่างคอลัมน์ */
        }

        /* สไตล์หัวข้อ */
        .footer-col h4 {
            font-size: 1.25rem; /* 20px */
            margin-bottom: 1.5rem; /* 24px */
            font-weight: 700;
            color: #00bcd4; /* สีเน้น (Cyan) */
            position: relative;
        }

        /* ขีดเส้นใต้หัวข้อ */
        .footer-col h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            height: 3px;
            width: 50px;
            background-color: #00bcd4;
            border-radius: 2px;
        }

        /* สไตล์คอลัมน์ About */
        .footer-col.about p {
            color: #ccc;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .footer-logo {
            font-size: 1.75rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 1.5rem;
        }

        /* สไตล์ข้อมูลติดต่อ (สำหรับคอลัมน์ Contact Info) */
        .footer-col.contact-info p {
            margin-bottom: 1rem;
            color: #ccc;
            line-height: 1.5;
            font-size: 0.95rem;
        }
        .footer-col.contact-info i {
            margin-right: 10px;
            color: #00bcd4;
        }

        /* สไตล์ Social Media Icons */
        .social-links a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            text-align: center;
            border: 1px solid #555;
            border-radius: 50%;
            color: #ccc;
            font-size: 1.1rem;
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
        }
        .social-links a:hover {
            background-color: #00bcd4;
            color: #1a1a1a;
            border-color: #00bcd4;
            transform: translateY(-3px);
        }

        /* สไตล์ลิสต์ข้อกำหนดและนโยบาย */
        .policy-links {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 0.85rem;
        }
        .policy-links li {
             margin-bottom: 0.5rem;
        }
        .policy-links a {
            color: #888;
            text-decoration: none;
        }
        .policy-links a:hover {
            text-decoration: underline;
            color: #ccc;
        }

        /* --------------------
           ส่วนล่างสุด (Copyright Bar)
           -------------------- */
        .footer-bottom {
            background-color: #111;
            padding: 1rem 1.5rem;
            margin-top: 3rem;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-bottom p {
            margin: 0;
            font-size: 0.85rem;
            color: #888;
        }
        .footer-bottom .back-to-top {
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        .footer-bottom .back-to-top:hover {
            color: #00bcd4;
        }


        /* --------------------
           Responsive Design
           -------------------- */
        /* หน้าจอแท็บเล็ต (<= 992px) */
        @media (max-width: 992px) {
            .footer-container {
                grid-template-columns: 1fr; /* เปลี่ยนกลับเป็น 1 คอลัมน์สำหรับแท็บเล็ต/มือถือ */
            }
            /* ปรับทุกคอลัมน์ให้อยู่ตรงกลางเมื่อเป็นคอลัมน์เดียว */
            .footer-col.about, .footer-col.contact-info, .footer-col.policy {
                text-align: center;
            }

            .footer-col h4::after {
                /* ย้ายขีดเส้นใต้ไปอยู่ตรงกลางเมื่ออยู่กึ่งกลาง */
                left: 50%;
                transform: translateX(-50%);
            }
        }

        /* หน้าจอมือถือ (<= 576px) */
        @media (max-width: 576px) {
            .footer-container {
                text-align: center;
            }

            .footer-col {
                padding-bottom: 1.5rem;
                margin-bottom: 1.5rem;
                border-bottom: 1px solid #333;
            }
            .footer-col:last-child {
                border-bottom: none;
                margin-bottom: 0;
            }

            /* จัดองค์ประกอบภายในให้อยู่ตรงกลาง */
            .footer-col h4::after {
                left: 50%;
                transform: translateX(-50%);
            }
            .social-links {
                display: flex;
                justify-content: center;
                gap: 10px;
            }
            .footer-bottom {
                flex-direction: column;
            }
            .footer-bottom .back-to-top {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- ส่วน FOOTER ที่ออกแบบไว้ -->
    <footer class="main-footer">
        <div class="footer-container">
            <!-- คอลัมน์ที่ 1: โลโก้ & ข้อมูลบริษัท & โซเชียลมีเดีย (KKU) **ซ้ายสุด 2fr** -->
            <div class="footer-col about">
                <h3 class="footer-logo">มหาวิทยาลัยขอนแก่น (KKU)</h3>
                <p>สถาบันอุดมศึกษาแห่งแรกในภาคตะวันออกเฉียงเหนือ มุ่งมั่นสู่ความเป็นเลิศด้านการวิจัย นวัตกรรม และการบริการสังคม เพื่อการพัฒนาที่ยั่งยืน (ข้อมูลจากเว็บไซต์หลัก KKU)</p>
                <div class="social-links">
                    <!-- ช่องทางหลักและสื่อสารยอดนิยมของ KKU -->
                    <!-- *** ส่วนที่ต้องแก้ไขลิงก์จริง: แก้ไขค่าใน href="..." สำหรับแต่ละช่องทาง *** -->
                    <a href="https://www.facebook.com/kkuthailand" aria-label="Facebook (KKU)"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Facebook Messenger (KKU)"><i class="fab fa-facebook-messenger"></i></a>
                    <a href="#" aria-label="Line (KKU)"><i class="fab fa-line"></i></a>
                    <a href="#" aria-label="Instagram (KKU)"><i class="fab fa-instagram"></i></a>
                    <!-- ช่องทางเผยแพร่คอนเทนต์และข่าวสาร -->
                    <a href="https://www.youtube.com/@kkuchannel" aria-label="Youtube (KKU Channel)"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="Twitter (KKU)"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Tumblr (KKU)"><i class="fab fa-tumblr"></i></a>
                </div>
            </div>

            <!-- คอลัมน์ที่ 2: ข้อมูลติดต่อ (MIDDLE) **อยู่ตรงกลาง 1fr** -->
            <div class="footer-col contact-info">
                <h4>ติดต่อเรา</h4>
                <p>
                    <i class="fas fa-map-marker-alt"></i> 123 หมู่ 16 ถ.มิตรภาพ ต.ในเมือง<br>
                    อ.เมือง จ.ขอนแก่น 40002
                </p>
                <p><i class="fas fa-phone"></i> 043-009700, 043-002539</p>
                <p><i class="fas fa-envelope"></i> info@kku.ac.th</p>
            </div>

            <!-- คอลัมน์ที่ 3: ข้อกำหนดและนโยบาย (RIGHTMOST) **อยู่ขวาสุด 1fr** -->
            <div class="footer-col policy">
                <h4>ข้อกำหนดและนโยบาย</h4>
                <ul class="policy-links">
                    <li><a href="https://www.kku.ac.th/th/policy/privacy-policy/" target="_blank">นโยบายความเป็นส่วนตัว</a></li>
                    <li><a href="#">ข้อกำหนดและเงื่อนไขการใช้บริการ</a></li>
                    <li><a href="#">นโยบายคุกกี้</a></li>
                </ul>
            </div>
        </div>

        <!-- ส่วนลิขสิทธิ์ (Copyright Bar) -->
        <div class="footer-bottom">
            <p>&copy; 2025 มหาวิทยาลัยขอนแก่น (Khon Kaen University). All Rights Reserved.</p>
            <a href="#top" class="back-to-top">กลับสู่ด้านบน <i class="fas fa-arrow-up"></i></a>
        </div>
    </footer>

</body>
</html>
