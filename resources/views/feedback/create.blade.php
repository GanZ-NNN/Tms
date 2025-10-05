<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">แบบประเมินความพึงพอใจการฝึกอบรม</h1>

        <form method="POST" action="{{ route('feedback.store', $session) }}">
            @csrf

            {{-- ข้อมูลหลักสูตร --}}
            <div class="mb-4">
                <label class="font-semibold">หัวข้อการฝึกอบรม: {{ $session->title }}</label>
                <p class="text-sm text-gray-600">
                    วันที่: {{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}
                </p>
            </div>

            {{-- เพศ --}}
            <div class="mb-4">
                <label class="font-semibold">เพศ *</label>
                <div class="flex gap-4 mt-1">
                    <label><input type="radio" name="sex" value="male"> ชาย</label>
                    <label><input type="radio" name="sex" value="female"> หญิง</label>
                    <label><input type="radio" name="sex" value="lgbtqia"> LGBTQIA+</label>
                    <label><input type="radio" name="sex" value="other"> อื่นๆ:</label>
                    <input type="text" name="sex_other" placeholder="ระบุอื่น ๆ" class="border rounded px-2">
                </div>
            </div>

            {{-- อายุ --}}
            <div class="mb-4">
                <label class="font-semibold">อายุ *</label>
                <div class="flex gap-4 mt-1">
                    @foreach(['18-20','21-25','26-30','31-40','41+'] as $age)
                        <label>
                            <input type="radio" name="age" value="{{ $age }}"> {{ $age }} ปี
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- เนื้อหา --}}
            <div class="mb-4">
                <label class="font-semibold">เนื้อหาและความเหมาะสม (Content and Relevance) *</label>
                @foreach([
                    'เนื้อหาครอบคลุมตามที่คาดหวัง',
                    'เนื้อหามีความทันสมัย',
                    'เนื้อหาสอดคล้องกับงานที่ปฏิบัติ'
                ] as $item)
                <div class="mt-2">
                    <span>{{ $item }}</span>
                    <div class="flex gap-2 mt-1">
                        @for($i=1; $i<=5; $i++)
                            <label class="inline-flex items-center">
                                <input type="radio" name="content[{{ $loop->index }}]" value="{{ $i }}" class="mr-1" required>
                                {{ $i }}
                            </label>
                        @endfor
                        <input type="hidden" name="content_keys[{{ $loop->index }}]" value="{{ $item }}">
                    </div>
                </div>
                @endforeach
            </div>

            {{-- วิทยากร --}}
            <div class="mb-4">
                <label class="font-semibold">วิทยากรและการบรรยาย (Speakers and Lectures) *</label>
                @foreach([
                    'การนำเข้าสู่หลักสูตรเหมาะสม',
                    'การถ่ายทอด ชัดเจนและเข้าใจง่าย',
                    'การถาม-ตอบชัดเจน'
                ] as $item)
                <div class="mt-2">
                    <span>{{ $item }}</span>
                    <div class="flex gap-2 mt-1">
                        @for($i=1; $i<=5; $i++)
                            <label class="inline-flex items-center">
                                <input type="radio" name="speakers[{{ $loop->index }}]" value="{{ $i }}" class="mr-1" required>
                                {{ $i }}
                            </label>
                        @endfor
                        <input type="hidden" name="speakers_keys[{{ $loop->index }}]" value="{{ $item }}">
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Future Topics --}}
            <div class="mb-4">
                <label class="font-semibold">ท่านต้องการให้ศูนย์ฯ จัดกิจกรรมฝึกอบรมหัวข้อใดอีกในอนาคต *</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-1">
                    @foreach($topics as $topic)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="future_topics[]" value="{{ $topic }}" class="mr-2"> {{ $topic }}
                        </label>
                    @endforeach
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="future_topics[]" value="other" class="mr-2" id="future_topics_other_check">
                        อื่นๆ:
                        <input type="text" name="future_topics_other" placeholder="ระบุอื่น ๆ" class="border rounded px-2 ml-1" id="future_topics_other_input">
                    </label>
                </div>
            </div>

            {{-- ข้อเสนอแนะ --}}
            <div class="mb-4">
                <label class="font-semibold">ข้อเสนอแนะเพิ่มเติม (Other suggestions)</label>
                <textarea name="suggestions" rows="4" class="block w-full border rounded mt-1"></textarea>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">ส่งแบบประเมิน</button>
        </form>
    </div>

    <script>
        const checkOther = document.getElementById('future_topics_other_check');
        const inputOther = document.getElementById('future_topics_other_input');

        inputOther.disabled = !checkOther.checked;

        checkOther.addEventListener('change', function() {
            inputOther.disabled = !this.checked;
            if(!this.checked) inputOther.value = '';
        });
    </script>
</x-app-layout>
