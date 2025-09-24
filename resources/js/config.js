// ===== TMS Configuration File (config.js) =====

window.TMSConfig = {
    // ===== Animation Settings =====
    animations: {
        duration: 800,
        easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
        staggerDelay: 100,
        observerThreshold: 0.1,
        observerRootMargin: '0px 0px -50px 0px'
    },

    // ===== DataTables Settings =====
    dataTable: {
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        searchDelay: 300,
        language: {
            search: "ค้นหา:",
            lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
            info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            infoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
            infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
            paginate: {
                first: "หน้าแรก",
                last: "หน้าสุดท้าย",
                next: "ถัดไป",
                previous: "ก่อนหน้า"
            },
            emptyTable: "ไม่มีข้อมูลในตาราง",
            zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
            loadingRecords: "กำลังโหลด...",
            processing: "กำลังประมวลผล..."
        }
    },

    // ===== Carousel Settings =====
    carousel: {
        autoplay: true,
        autoplaySpeed: 5000,
        swipeThreshold: 50,
        pauseOnHover: true
    },

    // ===== Form Validation Settings =====
    validation: {
        realTime: true,
        highlightErrors: true,
        scrollToError: true,
        errorDelay: 100,
        messages: {
            required: 'กรุณากรอกข้อมูลนี้',
            email: 'รูปแบบอีเมลไม่ถูกต้อง',
            phone: 'รูปแบบหมายเลขโทรศัพท์ไม่ถูกต้อง',
            password: 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
            confirm: 'ยืนยันรหัสผ่านไม่ตรงกัน',
            number: 'กรุณากรอกตัวเลขเท่านั้น',
            url: 'รูปแบบ URL ไม่ถูกต้อง',
            date: 'รูปแบบวันที่ไม่ถูกต้อง'
        }
    },

    // ===== SweetAlert2 Settings =====
    sweetAlert: {
        toast: {
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        },
        confirm: {
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            showCancelButton: true
        },
        customClass: {
            popup: 'glass',
            confirmButton: 'btn btn-primary mx-2',
            cancelButton: 'btn btn-secondary mx-2'
        }
    },

    // ===== AJAX Settings =====
    ajax: {
        timeout: 30000,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        loadingText: 'กำลังโหลด...',
        errorMessages: {
            network: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้',
            timeout: 'การเชื่อมต่อหมดเวลา',
            server: 'เกิดข้อผิดพลาดที่เซิร์ฟเวอร์',
            unknown: 'เกิดข้อผิดพลาดที่ไม่ทราบสาเหตุ'
        }
    },

    // ===== Scroll Settings =====
    scroll: {
        headerScrollThreshold: 100,
        smoothScrollOffset: 80,
        parallaxSpeed: 0.5,
        throttleDelay: 16
    },

    // ===== Tooltip Settings =====
    tooltip: {
        delay: 500,
        hideDelay: 100,
        offset: 10,
        animation: 'fade'
    },

    // ===== Image Loading Settings =====
    images: {
        lazyLoading: true,
        placeholder: 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="300"%3E%3Crect width="100%25" height="100%25" fill="%23f8f9fa"/%3E%3C/svg%3E',
        fadeInDuration: 300
    },

    // ===== Responsive Breakpoints =====
    breakpoints: {
        xs: 480,
        sm: 576,
        md: 768,
        lg: 992,
        xl: 1200,
        xxl: 1400
    },

    // ===== API Endpoints =====
    api: {
        baseUrl: window.location.origin,
        endpoints: {
            sessions: '/api/sessions',
            programs: '/api/programs',
            users: '/api/users',
            registrations: '/api/registrations',
            certificates: '/api/certificates',
            feedback: '/api/feedback'
        }
    },

    // ===== Feature Flags =====
    features: {
        darkMode: true,
        animations: true,
        lazyLoading: true,
        serviceWorker: false,
        pushNotifications: false,
        offlineMode: false
    },

    // ===== Debug Settings =====
    debug: {
        enabled: false,
        logLevel: 'info', // 'error', 'warn', 'info', 'debug'
        showPerformance: false
    }
};

// ===== Utility Functions for Configuration =====
window.TMSConfig.get = function(path, defaultValue = null) {
    const keys = path.split('.');
    let current = this;

    for (const key of keys) {
        if (current[key] === undefined) {
            return defaultValue;
        }
        current = current[key];
    }

    return current;
};

window.TMSConfig.set = function(path, value) {
    const keys = path.split('.');
    const lastKey = keys.pop();
    let current = this;

    for (const key of keys) {
        if (!current[key]) {
            current[key] = {};
        }
        current = current[key];
    }

    current[lastKey] = value;
};

// ===== Environment Detection =====
window.TMSConfig.env = {
    isDevelopment: window.location.hostname === 'localhost' || window.location.hostname.includes('dev'),
    isProduction: !window.location.hostname === 'localhost' && !window.location.hostname.includes('dev'),
    isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
    isTablet: /iPad|Android/i.test(navigator.userAgent) && window.innerWidth >= 768,
    isDesktop: window.innerWidth >= 1024,
    browser: (function() {
        const ua = navigator.userAgent;
        if (ua.includes('Chrome')) return 'chrome';
        if (ua.includes('Firefox')) return 'firefox';
        if (ua.includes('Safari')) return 'safari';
        if (ua.includes('Edge')) return 'edge';
        return 'unknown';
    })()
};

// ===== Dynamic Configuration Based on Environment =====
if (window.TMSConfig.env.isDevelopment) {
    window.TMSConfig.debug.enabled = true;
    window.TMSConfig.debug.logLevel = 'debug';
    window.TMSConfig.debug.showPerformance = true;
}

if (window.TMSConfig.env.isMobile) {
    window.TMSConfig.animations.duration = 600; // Shorter animations on mobile
    window.TMSConfig.dataTable.pageLength = 5; // Fewer items per page
    window.TMSConfig.carousel.autoplaySpeed = 4000; // Faster carousel
}

// ===== Theme Configuration =====
window.TMSConfig.theme = {
    default: 'light',
    storageKey: 'tms-theme',
    colors: {
        light: {
            primary: '#667eea',
            secondary: '#764ba2',
            background: '#f5f7fa',
            surface: '#ffffff',
            text: '#2d3748'
        },
        dark: {
            primary: '#8b9cf5',
            secondary: '#9966cc',
            background: '#1a202c',
            surface: '#2d3748',
            text: '#f7fafc'
        }
    }
};

// ===== Performance Configuration =====
window.TMSConfig.performance = {
    lazyLoadOffset: 100,
    imageCompressionQuality: 0.8,
    enableServiceWorker: false,
    prefetchPages: [],
    criticalCSS: true,
    minifyHTML: true
};

// ===== Accessibility Configuration =====
window.TMSConfig.accessibility = {
    focusVisible: true,
    screenReaderSupport: true,
    highContrast: false,
    reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    ariaLabels: {
        close: 'ปิด',
        menu: 'เมนู',
        search: 'ค้นหา',
        loading: 'กำลังโหลด',
        error: 'ข้อผิดพลาด',
        success: 'สำเร็จ',
        previous: 'ก่อนหน้า',
        next: 'ถัดไป'
    }
};

// ===== Localization Configuration =====
window.TMSConfig.i18n = {
    defaultLocale: 'th',
    fallbackLocale: 'en',
    dateFormat: 'DD/MM/YYYY',
    timeFormat: 'HH:mm',
    currency: 'THB',
    numberFormat: {
        decimal: '.',
        thousands: ',',
        precision: 2
    }
};

// Log configuration loading
if (window.TMSConfig.debug.enabled) {
    console.log('TMS Configuration loaded:', window.TMSConfig);
}
