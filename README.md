<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 📖 User Manual (คู่มือการใช้งาน)

### 👤 For Users / Trainees (สำหรับผู้ใช้งานทั่วไป / ผู้เรียน)

#### 1. การสมัครสมาชิกและเข้าสู่ระบบ
- **สมัครสมาชิก:** ไปที่หน้าแรกและคลิกปุ่ม "Register" (สมัครสมาชิก) จากนั้นกรอกข้อมูล (ชื่อ, อีเมล, รหัสผ่าน) ให้ครบถ้วน
- **เข้าสู่ระบบ:** คลิกปุ่ม "Log in" (เข้าสู่ระบบ) แล้วกรอกอีเมลและรหัสผ่านที่ได้ลงทะเบียนไว้

#### 2. การค้นหาและดูรายละเอียดหลักสูตร
- **หน้าแรก:** จะแสดง "รอบอบรมที่เปิดรับสมัคร" ล่าสุด ผู้ใช้สามารถคลิกที่ Card เพื่อดูรายละเอียดเพิ่มเติม หรือคลิกที่ปุ่ม "ลงทะเบียน" ได้ทันที
- **หน้า "หลักสูตรทั้งหมด":** ผู้ใช้สามารถดูรายการหลักสูตรทั้งหมดที่มี และสามารถใช้ฟังก์ชันค้นหาเพื่อหาหลักสูตรที่สนใจได้
- **หน้ารายละเอียด:** เมื่อคลิกเข้ามา จะแสดงข้อมูลเชิงลึกของหลักสูตรนั้นๆ รวมถึง "รอบอบรมทั้งหมด" ที่เปิดอยู่ภายใต้หลักสูตรนี้

#### 3. การลงทะเบียนและยกเลิก
- **การลงทะเบียน:** ในหน้ารายละเอียด หรือจาก Card ในหน้าแรก ผู้ใช้สามารถกดปุ่ม "ลงทะเบียน" ในรอบอบรมที่ต้องการได้ หากยังไม่ได้ Login ระบบจะพาไปหน้า Login ก่อน
- **การยกเลิก:** ในหน้า **"หลักสูตรที่กำลังเรียน" (Upcoming Courses)** ผู้ใช้สามารถกดยกเลิกการลงทะเบียนได้ หากยังไม่เลยวันปิดรับสมัคร

#### 4. การจัดการข้อมูลส่วนตัว
- **Profile:** ผู้ใช้สามารถแก้ไขชื่อและอีเมลได้ที่หน้า Profile (เข้าถึงได้จากเมนู Dropdown ที่มีชื่อผู้ใช้)
- **My Courses:**
    - **หลักสูตรที่กำลังเรียน:** แสดงรายการรอบอบรมในอนาคตที่ได้ลงทะเบียนไว้
    - **ประวัติการอบรม:** แสดงรายการรอบอบรมที่เรียนจบไปแล้ว และเป็นช่องทางสำหรับ "ส่งแบบประเมิน" (Give Feedback)
- **My Certificates:** คลังเก็บใบรับรองทั้งหมดที่เคยได้รับ ผู้ใช้สามารถกด **"Download"** เพื่อดาวน์โหลดไฟล์ PDF ได้จากหน้านี้

---

### 👑 For Administrators (สำหรับผู้ดูแลระบบ)

#### 1. การเข้าสู่ระบบ
- ใช้ Account ที่ถูกกำหนด `role` เป็น `admin` ในฐานข้อมูลเพื่อเข้าสู่ระบบ
- **Default Admin (จาก Seeder):**
    - **Email:** `admin@example.com`
    - **Password:** `password`
- หลังจาก Login สำเร็จ ระบบจะพาไปยัง **Admin Dashboard** โดยอัตโนมัติ

#### 2. Admin Dashboard
- เป็นศูนย์กลางในการดูภาพรวมของทั้งระบบ ประกอบด้วย:
    - **Stat Cards:** สรุปข้อมูลสำคัญ (จำนวนผู้เรียน, รอบอบรมที่จะมาถึง, ฯลฯ)
    - **กราฟ:** แสดงแนวโน้มการเข้าเรียนและผลตอบรับ
    - **ตาราง Actionable:** แสดงรายการ "รอบอบรมที่จะมาถึง" และ "รอบอบรมที่รอปิดรอบ"

#### 3. การจัดการหลักสูตรและรอบอบรม (Programs & Sessions)
- ไปที่เมนู **"หลักสูตร & รอบอบรม"**
- **การสร้าง:**
    1.  คลิก **"เพิ่มโปรแกรม"** เพื่อสร้าง "หลักสูตรแม่" (Template) ก่อน โดยใส่ข้อมูลพื้นฐาน เช่น ชื่อ, หมวดหมู่, รูปภาพ
    2.  หลังจากสร้างโปรแกรมแล้ว ในตารางให้คลิกปุ่ม **"เพิ่มรอบอบรม"** (➕) ที่โปรแกรมนั้นๆ
    3.  กรอกรายละเอียดของ "รอบอบรม" ให้ครบถ้วน เช่น รอบที่, ผู้สอน, ระดับ, สถานที่, จำนวนที่นั่ง, และวันที่เปิด-ปิดรับสมัคร
- **การจัดการ:** สามารถ "แก้ไข" และ "ลบ" ทั้งโปรแกรมและรอบอบรมได้จากหน้านี้

#### 4. การจัดการการเข้าเรียน (Attendance)
- ไปที่เมนู **"การเข้าเรียน"**
- **Manage Attendance (Tab หลัก):** จะแสดงรายการรอบอบรมที่ **ยังไม่จบ**
    -   คลิกปุ่ม **"Mark Attendance"** เพื่อเข้าไปยังหน้าเช็คชื่อแบบรายวัน (เช้า/บ่าย)
    -   หลังจากบันทึกการเช็คชื่อแล้ว สามารถกดปุ่ม **"Complete"** เพื่อปิดรอบอบรมอย่างเป็นทางการได้
- **History (Tab รอง):** แสดงประวัติการเข้าเรียนของรอบอบรมที่จบไปแล้ว สามารถคลิก **"View Attendance"** เพื่อดูข้อมูลย้อนหลังได้

#### 5. การออกใบรับรอง (Certificate Generation)
- **อัตโนมัติ:** เมื่อ Admin กดปุ่ม **"Complete"** ในหน้่า Attendance, ระบบจะส่ง `IssueCertificateJob` เข้าไปในคิวโดยอัตโนมัติ
- **เงื่อนไข:** Job จะตรวจสอบผู้เรียนแต่ละคนในรอบนั้นๆ ว่าผ่านเกณฑ์หรือไม่ (เข้าเรียน >= 80% **และ** ส่ง Feedback แล้ว)
- **ผลลัพธ์:** สำหรับผู้ที่ผ่านเกณฑ์ ระบบจะสร้างไฟล์ PDF, บันทึกข้อมูลลงฐานข้อมูล, และส่งอีเมลแจ้งเตือนไปยังผู้เรียน

#### 6. การจัดการข้อมูลอื่นๆ
- **ผู้ใช้งาน:** จัดการ (เพิ่ม/ลบ/แก้ไข) ข้อมูล User และ Trainer
- **หมวดหมู่:** จัดการหมวดหมู่ของหลักสูตร
- **รายงาน Feedback:** ดูสรุปและรายละเอียดของผลตอบรับจากผู้เรียนในแต่ละรอบ
