<template>
    <div>
        <!-- Vue Filter Form -->
        <div class="mb-4 flex items-end space-x-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700">ค้นหาชื่อโปรแกรม</label>
                <input type="text" v-model="searchTerm" placeholder="ค้นหา..." class="mt-1 block w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <select v-model="selectedCategory" class="mt-1 block w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Vue Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg">
                <thead>
                    <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-semibold text-center">ID</th>
                        <th class="px-6 py-3 font-semibold text-center">รูป</th>
                        <th class="px-6 py-3 font-semibold text-left">ชื่อโปรแกรม</th>
                        <th class="px-6 py-3 font-semibold text-center">Category</th>
                        <th class="px-6 py-3 font-semibold text-center">จัดการ</th>
                    </tr>
                </thead>
                
                <template v-for="program in filteredPrograms" :key="program.id">
                    <tbody class="divide-y divide-gray-200 border-t" x-data="{ open: false }">
                        <tr class="bg-gray-50 hover:bg-gray-100">
                            <td class="px-6 py-4 text-center">{{ program.id }}</td>
                            <td class="px-6 py-4 text-center">
                                <img v-if="program.image" :src="`/storage/${program.image}`" :alt="program.title" class="w-16 h-16 object-cover rounded mx-auto">
                                <span v-else>-</span>
                            </td>
                            <td class="px-6 py-4">
                                <button @click="open = !open" class="flex items-center justify-start space-x-2 w-full text-blue-600 hover:text-blue-800 font-bold text-left">
                                    <span>{{ program.title }}</span>
                                    <svg class="w-4 h-4 transition-transform flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </td>
                            <td class="px-6 py-4 text-center">{{ program.category ? program.category.name : '-' }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                {{-- ลิงก์และปุ่มต่างๆ ต้องสร้าง URL ด้วยตัวเอง --}}
                                <a :href="`/admin/programs/${program.id}/edit`" class="bg-yellow-400 ...">✏️ แก้ไข</a>
                                <a :href="`/admin/programs/${program.id}/sessions/create`" class="bg-blue-500 ...">➕ เพิ่มรอบอบรม</a>
                                {{-- ปุ่มลบต้องจัดการแยกต่างหากเพราะมี form --}}
                            </td>
                        </tr>
                        <tr class="bg-white" v-show="open" v-cloak>
                            <td class="py-2"></td>
                            <td colspan="4" class="p-0">
                                {{-- ตารางย่อยสำหรับ Sessions --}}
                            </td>
                        </tr>
                    </tbody>
                </template>

                <tbody v-if="filteredPrograms.length === 0">
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">ไม่พบโปรแกรม</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    initialPrograms: Array,
    categories: Array,
});

const searchTerm = ref('');
const selectedCategory = ref('');

const filteredPrograms = computed(() => {
    return props.initialPrograms.filter(program => {
        const searchMatch = program.title.toLowerCase().includes(searchTerm.value.toLowerCase());
        const categoryMatch = selectedCategory.value ? program.category_id == selectedCategory.value : true;
        return searchMatch && categoryMatch;
    });
});
</script>

<style scoped>
    [v-cloak] {
        display: none;
    }
</style>