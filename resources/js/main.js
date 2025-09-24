// ===== TMS Enhanced JavaScript (main.js) =====

class TMSApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeComponents();
    }

    setupEventListeners() {
        // DOM Content Loaded
        document.addEventListener('DOMContentLoaded', () => {
            this.onDOMReady();
        });

        // Window Events
        window.addEventListener('scroll', () => {
            this.handleScroll();
        });

        window.addEventListener('resize', () => {
            this.handleResize();
        });

        // Navigation Mobile Toggle
        this.setupMobileNavigation();
    }

    onDOMReady() {
        console.log('🚀 TMS App initialized');
        this.setupAnimations();
        this.setupDataTables();
        this.setupCarousels();
        this.setupScrollEffects();
        this.setupFormEnhancements();
        this.setupTooltips();
        this.animateElements();
    }

    initializeComponents() {
        // Initialize any additional components here
        this.setupSweetAlert();
        this.preloadImages();
    }

    // ===== Mobile Navigation =====
    setupMobileNavigation() {
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        if (navbarToggler && navbarCollapse) {
            navbarToggler.addEventListener('click', () => {
                navbarCollapse.classList.toggle('show');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!navbarToggler.contains(e.target) && !navbarCollapse.contains(e.target)) {
                    navbarCollapse.classList.remove('show');
                }
            });
        }
    }

    // ===== Animations =====
    setupAnimations() {
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.card, .table-container, .carousel').forEach(el => {
            observer.observe(el);
        });
    }

    animateElements() {
        // Stagger animation for cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });

        // Animate navbar items
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach((item, index) => {
            item.style.animation = `fadeInLeft 0.8s ease-out ${index * 0.1}s both`;
        });
    }

    // ===== DataTables Enhancement =====
    setupDataTables() {
        // Check if DataTables is available
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            $('.datatable').each(function() {
                const table = $(this).DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
                    order: [[0, 'desc']],
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
                    },
                    dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    initComplete: function() {
                        // Style DataTables elements
                        $('.dataTables_filter input')
                            .addClass('form-control')
                            .attr('placeholder', 'ค้นหาข้อมูล...')
                            .css('width', '200px');

                        $('.dataTables_length select')
                            .addClass('form-select')
                            .css('width', 'auto');

                        // Style pagination buttons
                        $('.paginate_button').addClass('btn btn-sm btn-outline-primary mx-1');
                        $('.paginate_button.current').removeClass('btn-outline-primary').addClass('btn-primary');
                    },
                    drawCallback: function() {
                        // Re-style pagination on redraw
                        $('.paginate_button').addClass('btn btn-sm btn-outline-primary mx-1');
                        $('.paginate_button.current').removeClass('btn-outline-primary').addClass('btn-primary');
                    }
                });

                // Enhanced search with highlighting
                this.enhanceTableSearch(table);
            });
        }
    }

    enhanceTableSearch(table) {
        let searchTimeout;
        $('.dataTables_filter input').on('input', function() {
            const searchTerm = this.value;
            clearTimeout(searchTimeout);

            // Add loading class
            $(this).addClass('searching');

            searchTimeout = setTimeout(() => {
                table.search(searchTerm).draw();
                $(this).removeClass('searching');
            }, 300);
        });

        // Highlight search results
        table.on('draw', function() {
            const searchTerm = $('.dataTables_filter input').val().toLowerCase();
            if (searchTerm) {
                $('tbody td', table.table().container()).each(function() {
                    const cellText = $(this).text();
                    const cellHtml = cellText.replace(
                        new RegExp(`(${searchTerm})`, 'gi'),
                        '<mark class="bg-warning text-dark">$1</mark>'
                    );
                    if (cellText !== cellHtml) {
                        $(this).html(cellHtml);
                    }
                });
            }
        });
    }

    // ===== Carousel Enhancement =====
    setupCarousels() {
        const carousels = document.querySelectorAll('.carousel');
        carousels.forEach(carousel => {
            this.addSwipeSupport(carousel);
            this.setupCarouselAutoplay(carousel);
        });
    }

    addSwipeSupport(carousel) {
        let startX = 0;
        let startY = 0;

        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        }, { passive: true });

        carousel.addEventListener('touchend', (e) => {
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;

            const deltaX = startX - endX;
            const deltaY = startY - endY;

            // Only trigger if horizontal swipe is more significant than vertical
            if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                if (typeof $ !== 'undefined') {
                    if (deltaX > 0) {
                        $(carousel).carousel('next');
                    } else {
                        $(carousel).carousel('prev');
                    }
                }
            }
        }, { passive: true });
    }

    setupCarouselAutoplay(carousel) {
        // Pause on hover, resume on leave
        carousel.addEventListener('mouseenter', () => {
            if (typeof $ !== 'undefined') {
                $(carousel).carousel('pause');
            }
        });

        carousel.addEventListener('mouseleave', () => {
            if (typeof $ !== 'undefined') {
                $(carousel).carousel('cycle');
            }
        });
    }

    // ===== Scroll Effects =====
    setupScrollEffects() {
        let ticking = false;

        this.handleScroll = () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    this.updateScrollEffects();
                    ticking = false;
                });
                ticking = true;
            }
        };
    }

    updateScrollEffects() {
        const scrolled = window.pageYOffset;
        const header = document.querySelector('.header');

        // Header scroll effect
        if (header) {
            if (scrolled > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }

        // Parallax effect for hero sections
        const heroElements = document.querySelectorAll('[data-parallax]');
        heroElements.forEach(hero => {
            const speed = parseFloat(hero.dataset.parallax) || 0.5;
            const yPos = -(scrolled * speed);
            hero.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
    }

    // ===== Form Enhancements =====
    setupFormEnhancements() {
        this.setupFormValidation();
        this.setupFormAnimations();
        this.setupFormAjax();
    }

    setupFormValidation() {
        const forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                    this.showFirstError(form);
                }
            });

            // Real-time validation
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', () => {
                    this.validateField(input);
                });

                input.addEventListener('input', () => {
                    this.clearFieldError(input);
                });
            });
        });
    }

    validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Required validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'กรุณากรอกข้อมูลนี้';
        }

        // Email validation
        if (field.type === 'email' && value && !this.isValidEmail(value)) {
            isValid = false;
            errorMessage = 'รูปแบบอีเมลไม่ถูกต้อง';
        }

        // Phone validation
        if (field.type === 'tel' && value && !this.isValidPhone(value)) {
            isValid = false;
            errorMessage = 'รูปแบบหมายเลขโทรศัพท์ไม่ถูกต้อง';
        }

        // Password validation
        if (field.type === 'password' && value && value.length < 6) {
            isValid = false;
            errorMessage = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร';
        }

        // Show/hide error
        if (isValid) {
            this.clearFieldError(field);
        } else {
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidPhone(phone) {
        const phoneRegex = /^(\+66|0)[0-9]{8,9}$/;
        return phoneRegex.test(phone.replace(/\s|-/g, ''));
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');

        let errorElement = field.parentNode.querySelector('.invalid-feedback');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'invalid-feedback';
            field.parentNode.appendChild(errorElement);
        }

        errorElement.textContent = message;
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        const errorElement = field.parentNode.querySelector('.invalid-feedback');
        if (errorElement) {
            errorElement.remove();
        }
    }

    showFirstError(form) {
        const firstError = form.querySelector('.is-invalid');
        if (firstError) {
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    setupFormAnimations() {
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            // Add focus effects
            input.addEventListener('focus', () => {
                input.parentNode.classList.add('focused');
            });

            input.addEventListener('blur', () => {
                if (!input.value) {
                    input.parentNode.classList.remove('focused');
                }
            });

            // Check if input has value on load
            if (input.value) {
                input.parentNode.classList.add('focused');
            }
        });
    }

    setupFormAjax() {
        const ajaxForms = document.querySelectorAll('form[data-ajax]');
        ajaxForms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleAjaxForm(form);
            });
        });
    }

    async handleAjaxForm(form) {
        const formData = new FormData(form);
        const submitButton = form.querySelector('[type="submit"]');
        const originalText = submitButton.textContent;

        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="loading"></span> กำลังส่ง...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.showAlert({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: result.message || 'บันทึกข้อมูลเรียบร้อยแล้ว',
                    timer: 2000
                });

                // Reset form if needed
                if (result.reset) {
                    form.reset();
                }

                // Redirect if needed
                if (result.redirect) {
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                }
            } else {
                throw new Error(result.message || 'เกิดข้อผิดพลาด');
            }
        } catch (error) {
            this.showAlert({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: error.message || 'ไม่สามารถส่งข้อมูลได้'
            });
        } finally {
            // Reset button state
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    }

    // ===== SweetAlert2 Integration =====
    setupSweetAlert() {
        // Setup global SweetAlert defaults
        if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            // Make toast globally available
            window.Toast = Toast;
        }
    }

    showAlert(options) {
        const defaultOptions = {
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
            customClass: {
                popup: 'glass',
                confirmButton: 'btn btn-primary mx-2',
                cancelButton: 'btn btn-secondary mx-2'
            }
        };

        const mergedOptions = { ...defaultOptions, ...options };

        if (typeof Swal !== 'undefined') {
            return Swal.fire(mergedOptions);
        } else {
            // Fallback to regular alert
            alert(options.text || options.title);
        }
    }

    // ===== Tooltips =====
    setupTooltips() {
        // Initialize tooltips for elements with data-bs-toggle="tooltip"
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(element => {
            // Simple tooltip implementation
            element.addEventListener('mouseenter', () => {
                this.showTooltip(element);
            });

            element.addEventListener('mouseleave', () => {
                this.hideTooltip(element);
            });
        });
    }

    showTooltip(element) {
        const tooltipText = element.getAttribute('title') || element.getAttribute('data-bs-title');
        if (!tooltipText) return;

        const tooltip = document.createElement('div');
        tooltip.className = 'custom-tooltip';
        tooltip.textContent = tooltipText;
        tooltip.style.cssText = `
            position: absolute;
            background: var(--dark-color);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.2s ease;
            pointer-events: none;
        `;

        document.body.appendChild(tooltip);

        // Position tooltip
        const rect = element.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();

        tooltip.style.left = `${rect.left + (rect.width - tooltipRect.width) / 2}px`;
        tooltip.style.top = `${rect.top - tooltipRect.height - 10}px`;

        // Show tooltip
        setTimeout(() => {
            tooltip.style.opacity = '1';
        }, 10);

        // Store reference
        element._tooltip = tooltip;
    }

    hideTooltip(element) {
        if (element._tooltip) {
            element._tooltip.style.opacity = '0';
            setTimeout(() => {
                if (element._tooltip) {
                    document.body.removeChild(element._tooltip);
                    element._tooltip = null;
                }
            }, 200);
        }
    }

    // ===== Image Preloading =====
    preloadImages() {
        const lazyImages = document.querySelectorAll('img[data-src]');

        if (!lazyImages.length) return;

        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    img.classList.add('lazy-loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => {
            img.classList.add('lazy');
            imageObserver.observe(img);
        });
    }

    // ===== Utility Functions =====
    handleResize() {
        // Recalculate DataTables on resize
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            setTimeout(() => {
                $('.datatable').DataTable().columns.adjust().responsive.recalc();
            }, 250);
        }
    }

    // ===== Public API Methods =====
    showToast(message, type = 'info') {
        if (window.Toast) {
            window.Toast.fire({
                icon: type,
                title: message
            });
        } else {
            console.log(`${type.toUpperCase()}: ${message}`);
        }
    }

    showConfirm(options) {
        return this.showAlert({
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            ...options
        });
    }

    scrollToElement(selector, offset = 0) {
        const element = document.querySelector(selector);
        if (element) {
            const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// ===== Global Utility Functions =====
function formatDate(dateString, format = 'dd/mm/yyyy') {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();

    switch (format) {
        case 'dd/mm/yyyy':
            return `${day}/${month}/${year}`;
        case 'yyyy-mm-dd':
            return `${year}-${month}-${day}`;
        case 'thai':
            const thaiMonths = [
                'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
            ];
            return `${day} ${thaiMonths[date.getMonth()]} ${year + 543}`;
        default:
            return date.toLocaleDateString();
    }
}

function formatNumber(number, decimals = 0) {
    return new Intl.NumberFormat('th-TH', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    }).format(number);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('th-TH', {
        style: 'currency',
        currency: 'THB'
    }).format(amount);
}

// ===== Initialize App =====
document.addEventListener('DOMContentLoaded', () => {
    window.tmsApp = new TMSApp();
});

// ===== Export for module usage =====
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TMSApp;
}
