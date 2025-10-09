<div class="container my-4">
    <form id="search-filter-form" action="{{ route('home') }}" method="GET" class="search-filter-form d-flex flex-wrap align-items-stretch p-3 bg-light rounded-4 shadow-sm">

        {{-- Keyword --}}
        <div class="input-grow">
            <input type="text" name="keyword"
                   class="form-control form-control-lg shadow-sm w-100"
                   placeholder="🔍 ค้นหาหลักสูตร..."
                   value="{{ request('keyword') }}">
        </div>

        {{-- Group --}}
        <div class="select-fixed">
            <select name="group" id="group-select" class="form-select form-select-lg shadow-sm select-limit">
                <option value="">-- เลือกกลุ่ม --</option>
                @foreach($groups as $group)
                    <option value="{{ $group->group }}" {{ request('group') == $group->group ? 'selected' : '' }}>
                        {{ Str::limit($group->group, 20) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Category --}}
        <div class="select-fixed">
            <select name="category_id" id="category-select" class="form-select form-select-lg shadow-sm select-limit">
                <option value="">-- เลือกหมวดหมู่ --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                            data-group="{{ $category->group ?? '' }}" {{-- เพิ่ม group เพื่อ filter --}}
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ Str::limit($category->name, 20) }}
                    </option>
                @endforeach
            </select>
        </div>

    </form>
</div>

<style>
.search-filter-form {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    gap: 0.25rem;
}
.input-grow { flex: 1 1 auto; min-width: 150px; max-width: 400px; }
.select-fixed { flex: 0 0 auto; }
.select-limit { max-width: 180px; min-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.search-filter-form .form-control, .search-filter-form .form-select { border-radius: 0.75rem; height: 100%; }
@media (max-width: 768px) {
    .input-grow, .select-fixed { flex: 1 1 100%; min-width: 0; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('search-filter-form');
    const groupSelect = document.getElementById('group-select');
    const categorySelect = document.getElementById('category-select');

    // ฟังก์ชัน filter category ตาม group
    function filterCategory() {
        const selectedGroup = groupSelect.value;
        const options = categorySelect.querySelectorAll('option');

        options.forEach(option => {
            const group = option.getAttribute('data-group');
            if (!group || selectedGroup === '' || group === selectedGroup) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
                if (option.selected) option.selected = false;
            }
        });
    }

    // เรียก filter ครั้งแรก
    filterCategory();

    // เมื่อเปลี่ยน Group
    groupSelect.addEventListener('change', function() {
        filterCategory();
        form.submit(); // ส่งฟอร์มอัตโนมัติ
    });

    // เมื่อเปลี่ยน Keyword หรือ Category ก็ส่งฟอร์มอัตโนมัติ
    form.querySelector('input[name="keyword"]').addEventListener('input', function() {
        form.submit();
    });
    categorySelect.addEventListener('change', function() {
        form.submit();
    });
});
</script>


<style>
/* Form wrapper */
.search-filter-form {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    gap: 0.25rem; /* ลดระยะห่าง */
}

/* Input */
.input-grow {
    flex: 1 1 auto;
    min-width: 150px;
    max-width: 400px; /* Input ไม่เกินความกว้างสูงสุด */
}

/* Select */
.select-fixed {
    flex: 0 0 auto;
}
.select-limit {
    max-width: 180px;  /* กำหนดความกว้างสูงสุด */
    min-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Button */
.btn-fixed {
    flex: 0 0 auto;
    min-width: 120px;
}

/* ปรับ form-control, form-select และ button */
.search-filter-form .form-control,
.search-filter-form .form-select,
.search-filter-form .btn-primary {
    border-radius: 0.75rem;
    height: 100%;
}

/* Responsive มือถือ */
@media (max-width: 768px) {
    .search-filter-form {
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .input-grow,
    .select-fixed,
    .btn-fixed {
        flex: 1 1 100%;
        min-width: 0;
    }

    .search-filter-form .btn-primary {
        width: 100%;
    }
}
</style>
