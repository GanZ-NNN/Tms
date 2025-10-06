<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h1 class="text-2xl font-bold">แบบประเมินความพึงพอใจต่อกิจกรรม Innovation Complex</h1>
            <p class="text-sm mt-2">Innovation Complex Activity Satisfaction Survey</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <p class="text-sm mb-2">โปรดเลือกระดับคะแนนความพึงพอใจของท่านในแต่ละหัวข้อ</p>
            <p class="text-sm mb-2">5 = ดีมาก 4 = ดี 3= ปานกลาง 2 = น้อย 1 = น้อยมาก</p>
            <p class="text-sm font-medium">Please select your level of satisfaction for each category</p>
            <p class="text-sm">5 = Very Good, 4 = Good, 3 = Neutral, 2 = Low, 1 = Very Low</p>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <p class="text-sm">อีเมลและชื่อของท่านจะถูกใช้เฉพาะเพื่อจัดทำและจัดส่งใบประกาศนียบัตรให้กับผู้ที่ประสงค์จะรับใบประกาศฯ หลังสิ้นสุดกิจกรรมเท่านั้น โดยข้อมูลเหล่านี้จะไม่ถูกนำไปใช้ในวัตถุประสงค์อื่นใดที่อาจละเมิดความเป็นส่วนตัวของท่าน.</p>
            <p class="text-sm mt-2">Your email and name will be used solely for the purpose of issuing and delivering the certificate after the activity to those who request it. This information will not be used for any other purpose that may compromise your privacy.</p>
        </div>

        <form method="POST" action="{{ route('feedback.store', $session) }}">
            @csrf

            {{-- ข้อมูลหลักสูตร --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold text-lg">หัวข้อการฝึกอบรม: {{ $session->title }}</label>
                <p class="text-sm text-gray-600 mt-1">
                    วันที่: {{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}
                </p>
            </div>

            {{-- เพศ --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold">เพศ (Sex) <span class="text-red-500">*</span></label>
                <div class="space-y-2 mt-3">
                    <label class="flex items-center">
                        <input type="radio" name="sex" value="ชาย" required class="mr-2"> ชาย (Male)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="sex" value="หญิง" required class="mr-2"> หญิง (Female)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="sex" value="LGBTQIA+" required class="mr-2"> LGBTQIA+
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="sex" value="อื่นๆ" required class="mr-2"> อื่นๆ:
                        <input type="text" name="sex_other" class="border rounded px-3 py-1 flex-2">
                    </label>
                </div>
            </div>

            {{-- อายุ --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold">อายุ (Age) <span class="text-red-500">*</span></label>
                <div class="space-y-2 mt-3">
                    <label class="flex items-center">
                        <input type="radio" name="age" value="18-20" required class="mr-2"> 18-20 ปี (18-20 Years old)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="age" value="21-25" required class="mr-2"> 21-25 ปี (21-25 Years old)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="age" value="26-30" required class="mr-2"> 26-30 ปี (26-30 Years old)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="age" value="30-40" required class="mr-2"> 30-40 ปี (30-40 Years old)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="age" value="41+" required class="mr-2"> 41 ปีขึ้นไป (41 Years old and above)
                    </label>
                </div>
            </div>

            {{-- วิทยากรและการบรรยาย --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold text-lg mb-4 block">วิทยากรและการบรรยาย (Speakers and Lectures) <span class="text-red-500">*</span></label>

                @php
                $speakerItems = [
                    'การนำเข้าสู่หลักสูตรเหมาะสม (Well-structured course introduction)',
                    'การถ่ายทอด ชัดเจนและเข้าใจง่าย (Clear and easy-to-understand delivery)',
                    'การถาม-ตอบชัดเจน (Clear Q&A sessions)',
                    'การใช้สื่อการสอน กิจกรรม หรือการยกตัวอย่างที่เหมาะสม (Effective use of teaching materials, activities, or relevant examples)',
                    'การกระตุ้นให้ผู้เรียนมีส่วนร่วม (Encouraging participant engagement)',
                    'การสรุปและทบทวนให้เข้าใจยิ่งขึ้น (Summarizing and reviewing for better understanding)',
                    'การยอมรับความคิดเห็นผู้เข้าร่วมอบรม/สัมมนา (Respecting participants\' opinions)',
                    'มีความรู้/ประสบการณ์ ตรงกับเนื้อหาหลักสูตร (Knowledge and experience relevant to the course content)',
                    'มีบุคลิกภาพที่ดี และน่าเชื่อถือ (Good personality and credibility)',
                    'การควบคุมและรักษาเวลา (Effective time management and adherence to schedule)'
                ];
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left pb-2"></th>
                                @for($i = 5; $i >= 1; $i--)
                                    <th class="text-center pb-2 px-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($speakerItems as $index => $item)
                            <tr class="border-b">
                                <td class="py-3 pr-4 text-sm">{{ $item }}</td>
                                @for($i = 5; $i >= 1; $i--)
                                    <td class="text-center">
                                        <input type="radio" name="speakers[{{ $index }}]" value="{{ $i }}" required>
                                    </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- หลักสูตร/เนื้อหา --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold text-lg mb-4 block">หลักสูตร/เนื้อหา (Course/Content) <span class="text-red-500">*</span></label>

                @php
                $contentItems = [
                    'เนื้อหาการฝึกอบรมตรงตามความต้องการ (The training content aligns with the requirements)',
                    'การลำดับเนื้อหา/ความต่อเนื่องของการฝึกอบรม (Content structure/continuity of the training)',
                    'ความรู้ และทักษะที่ได้รับสามารถนำไปประยุกต์ใช้ในการทำงาน (The skills and knowledge obtained are applicable to professional tasks)',
                    'ความพร้อมของวัสดุ/อุปกรณ์ เครื่องมือ เครื่องจักร สำหรับการฝึกอบรม (ถ้ามี) (Accessibility of necessary materials, equipment, and tools for the training (if applicable))',
                    'เอกสารประกอบการฝึกอบรม (Training materials)',
                    'ระยะเวลาในการฝึกอบรม (Training duration)'
                ];
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left pb-2"></th>
                                @for($i = 5; $i >= 1; $i--)
                                    <th class="text-center pb-2 px-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contentItems as $index => $item)
                            <tr class="border-b">
                                <td class="py-3 pr-4 text-sm">{{ $item }}</td>
                                @for($i = 5; $i >= 1; $i--)
                                    <td class="text-center">
                                        <input type="radio" name="content[{{ $index }}]" value="{{ $i }}" required>
                                    </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- การบริการเจ้าหน้าที่ --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold text-lg mb-4 block">การบริการเจ้าหน้าที่ (Staff support) <span class="text-red-500">*</span></label>

                @php
                $staffItems = [
                    'ความสะดวกในการเข้าถึงข้อมูล/ข่าวสารการฝึกอบรม (Accessibility of training information and announcements)',
                    'ความสะดวกในการติดต่อประสานงาน (Convenience in communication accessibility)',
                    'ความรวดเร็วในการให้บริการ (Promptness of service)',
                    'ความเต็มใจในการให้ความช่วยเหลือ (Willingness to support)',
                    'การแก้ปัญหาและการให้คำแนะนำของเจ้าหน้าที่ (Staff\'s problem-solving and advisory assistance)'
                ];
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left pb-2"></th>
                                @for($i = 5; $i >= 1; $i--)
                                    <th class="text-center pb-2 px-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffItems as $index => $item)
                            <tr class="border-b">
                                <td class="py-3 pr-4 text-sm">{{ $item }}</td>
                                @for($i = 5; $i >= 1; $i--)
                                    <td class="text-center">
                                        <input type="radio" name="staff[{{ $index }}]" value="{{ $i }}" required>
                                    </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ความพึงพอใจโดยรวม --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold">ความพึงพอใจโดยรวมต่อการฝึกอบรม (Overall satisfaction with the training) <span class="text-red-500">*</span></label>
                <div class="overflow-x-auto mt-3">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left pb-2">ระดับความพึงพอใจ (Level of satisfaction)</th>
                                @for($i = 5; $i >= 1; $i--)
                                    <th class="text-center pb-2 px-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-3"></td>
                                @for($i = 5; $i >= 1; $i--)
                                    <td class="text-center">
                                        <input type="radio" name="overall" value="{{ $i }}" required>
                                    </td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ระดับความรู้ก่อนและหลัง --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">ความรู้/ความเข้าใจเกี่ยวกับเนื้อหาก่อนเข้ารับการฝึกอบรม (Knowledge/understanding of the content before attending the training) <span class="text-red-500">*</span></label>
                <div class="overflow-x-auto">
                    <table class="w-full mb-6">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left pb-2">ระดับความรู้ก่อนอบรม (Pre-training knowledge level)</th>
                                @for($i = 5; $i >= 1; $i--)
                                    <th class="text-center pb-2 px-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-3"></td>
                                @for($i = 5; $i >= 1; $i--)
                                    <td class="text-center">
                                        <input type="radio" name="pre_knowledge" value="{{ $i }}" required>
                                    </td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>

                <label class="font-semibold mb-3 block mt-6">ความรู้/ความเข้าใจเกี่ยวกับเนื้อหาหลังเข้ารับการฝึกอบรม (Knowledge/understanding of the content after attending the training) <span class="text-red-500">*</span></label>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left pb-2">ระดับความรู้หลังอบรม (Post-training knowledge level)</th>
                                @for($i = 5; $i >= 1; $i--)
                                    <th class="text-center pb-2 px-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-3"></td>
                                @for($i = 5; $i >= 1; $i--)
                                    <td class="text-center">
                                        <input type="radio" name="post_knowledge" value="{{ $i }}" required>
                                    </td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- รับข่าวสาร --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">ท่านต้องการรับข่าวสารประชาสัมพันธ์กิจกรรมของศูนย์ฯ ในอนาคตหรือไม่ (Would you like to be informed about upcoming events?) <span class="text-red-500">*</span></label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="want_news" value="ต้องการ" required class="mr-2"> ต้องการ (Yes)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="want_news" value="ไม่ต้องการ" required class="mr-2"> ไม่ต้องการ (No)
                    </label>
                </div>
            </div>

            {{-- ช่องทางรับข่าวสาร --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">ช่องทางใดที่ท่านคิดว่าเหมาะสมในการรับข่าวสารประชาสัมพันธ์ของศูนย์ฯ (Which channel do you prefer for receiving news and updates?) <span class="text-red-500">*</span></label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="news_channels[]" value="E-mail ประชาสัมพันธ์" class="mr-2"> E-mail ประชาสัมพันธ์ (Public Relations E-mail)
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="news_channels[]" value="กลุ่ม Line ของรายวิชา/section" class="mr-2"> กลุ่ม Line ของรายวิชา/section (Line group for the course/section)
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="news_channels[]" value="Facebook page: คณะวิศวกรรมศาสตร์" class="mr-2"> Facebook page: คณะวิศวกรรมศาสตร์ (Facebook page: Faculty of Engineering)
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="news_channels[]" value="Facebook page: Creative Digital Learning Center" class="mr-2"> Facebook page: Creative Digital Learning Center
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="news_channels[]" value="Monitor ประชาสัมพันธ์ของคณะฯ" class="mr-2"> Monitor ประชาสัมพันธ์ของคณะฯ (Faculty's Public Relations Monitor)
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="news_channels[]" value="อื่นๆ" class="mr-2"> อื่นๆ:
                        <input type="text" name="news_channels_other" class="border rounded px-3 py-1 flex-2">
                    </label>
                </div>
            </div>

            {{-- หัวข้อที่อยากให้จัดในอนาคต --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">ท่านต้องการให้ศูนย์ฯ จัดกิจกรรมฝึกอบรมหัวข้อใดอีกในอนาคต (What topics do you think should be covered in future training sessions?) <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @php
                    $futureTopics = [
                        'Artificial Intelligence: ปัญญาประดิษฐ์',
                        'Automation: ระบบอัตโนมัติ',
                        'Building Information Modeling: กระบวนการของการสร้างแบบจำลองสารสนเทศอาคาร',
                        'Blockchain: บล็อคเชน',
                        'Coding: การเขียนโปรแกรมคอมพิวเตอร์',
                        'CAD/CAM: Computer Aided Design/Computer Aided Manufacturing',
                        'Cloud: คลาวด์',
                        'Digital Media: การผลิตสื่อดิจิทัล',
                        'Data Science: วิทยาการข้อมูล',
                        'Drone: อากาศยานไร้คนขับ',
                        'Electric Vehicle: ยานยนต์ระบบไฟฟ้า',
                        'Entrepreneurship: การเป็นผู้ประกอบการ',
                        'Full Stack Developer',
                        'Factory 4.0: โรงงานอัจฉริยะ'
                    ];
                    @endphp
                    @foreach($futureTopics as $topic)
                        <label class="flex items-center">
                            <input type="checkbox" name="future_topics[]" value="{{ $topic }}" class="mr-2"> {{ $topic }}
                        </label>
                    @endforeach
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="other_topic_check" name="future_topics[]" value="อื่นๆ" class="mr-2"> อื่นๆ:
                        <input type="text" id="other_topic_input" name="future_topics_other" class="border rounded px-3 py-1 flex-2" disabled>
                    </label>
                </div>
            </div>

            {{-- ด้านอื่น ๆ ที่เกี่ยวข้องกับคณะวิศวกรรมศาสตร์ --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold text-lg mb-4 block">ด้านอื่น ๆ ที่เกี่ยวข้องกับคณะวิศวกรรมศาสตร์ (Other aspects related to the Faculty of Engineering) <span class="text-red-500">*</span></label>

                @php
                $facultyItems = [
                    'ท่านจะแนะนำให้เพื่อนหรือคนรู้จักเข้ามาศึกษาหรือใช้บริการที่คณะฯ มากน้อยเพียงใด (How likely would you be to recommend the Faculty to friends or acquaintances for study or services?)',
                    'ความพึงพอใจต่อการสื่อสาร / ประชาสัมพันธ์ของคณะวิศวกรรมศาสตร์ (Satisfaction with the Faculty of Engineering\'s communication and publicity)',
                    'ท่านรับทราบและเข้าใจข้อมูลวิสัยทัศน์ และค่านิยมของคณะวิศวกรรมศาสตร์ (Do you acknowledge and comprehend the Faculty of Engineering\'s vision and values?)'
                ];
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left pb-2"></th>
                                @for($i = 5; $i >= 1; $i--)
                                    <th class="text-center pb-2 px-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($facultyItems as $index => $item)
                            <tr class="border-b">
                                <td class="py-3 pr-4 text-sm">{{ $item }}</td>
                                @for($i = 5; $i >= 1; $i--)
                                    <td class="text-center">
                                        <input type="radio" name="faculty_related[{{ $index }}]" value="{{ $i }}" required>
                                    </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- เคยเข้าร่วมกิจกรรม --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">ท่านเคยเข้าร่วมกิจกรรมอื่นๆ ของ Innovation Complex มาก่อนหรือไม่ (Have you ever participated in other activities organized by the Innovation Complex?) <span class="text-red-500">*</span></label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="participated_before" value="เคย" required class="mr-2"> เคย (Yes)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="participated_before" value="ไม่เคย" required class="mr-2"> ไม่เคย (No)
                    </label>
                </div>
            </div>

            {{-- รูปแบบกิจกรรม --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">ท่านอยากให้มีการจัดกิจกรรมรูปแบบใด (What kind of activity would you prefer to be organized?) <span class="text-red-500">*</span></label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="activity_format" value="Online" required class="mr-2"> Online
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="activity_format" value="Onsite" required class="mr-2"> Onsite
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="activity_format" value="Hybrid" required class="mr-2"> Hybrid
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="activity_format" value="อื่นๆ" required class="mr-2"> อื่นๆ:
                        <input type="text" name="activity_format_other" class="border rounded px-3 py-1 flex-2">
                    </label>
                </div>
            </div>

            {{-- อิทธิพลข้อมูลวิทยากร --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">หากท่านไม่ได้รับข้อมูลเกี่ยวกับวิทยากรที่จะดำเนินการฝึกอบรม ท่านคิดว่าข้อมูลดังกล่าวมีอิทธิพลต่อการตัดสินใจเข้าร่วมกิจกรรมมากน้อยเพียงใด (If you do not receive information about the training instructor, to what extent does this affect your decision to participate in the activity?) <span class="text-red-500">*</span></label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="instructor_info_influence" value="ส่งผลต่อการตัดสินใจอย่างมาก" required class="mr-2"> ส่งผลต่อการตัดสินใจอย่างมาก (Strong influence on the decision)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="instructor_info_influence" value="ส่งผลต่อการตัดสินใจบ้าง" required class="mr-2"> ส่งผลต่อการตัดสินใจบ้าง (Some influence on the decision)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="instructor_info_influence" value="ไม่ส่งผลต่อการตัดสินใจ" required class="mr-2"> ไม่ส่งผลต่อการตัดสินใจ (No influence on the decision)
                    </label>
                </div>
            </div>

            {{-- อิทธิพลการจัดนอกเวลาราชการ --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">การจัดกิจกรรมนอกเวลาราชการ ส่งผลต่อการตัดสินใจเข้าร่วมกิจกรรมของท่านมากน้อยเพียงใด (To what extent does organizing the activity outside official working hours influence your decision to participate?) <span class="text-red-500">*</span></label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="outside_hours_influence" value="ส่งผลต่อการตัดสินใจอย่างมาก" required class="mr-2"> ส่งผลต่อการตัดสินใจอย่างมาก (Strong influence on the decision)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="outside_hours_influence" value="ส่งผลต่อการตัดสินใจบ้าง" required class="mr-2"> ส่งผลต่อการตัดสินใจบ้าง (Some influence on the decision)
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="outside_hours_influence" value="ไม่ส่งผลต่อการตัดสินใจ" required class="mr-2"> ไม่ส่งผลต่อการตัดสินใจ (No influence on the decision)
                    </label>
                </div>
            </div>

            {{-- ข้อเสนอแนะเพิ่มเติม --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <label class="font-semibold mb-3 block">ข้อเสนอแนะเพิ่มเติม (Other suggestions)</label>
                <textarea name="comment" rows="4" class="block w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="คำตอบของคุณ"></textarea>
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" class="px-6 py-3 bg-gray-800 text-white rounded hover:bg-gray-900 transition">
                    ส่ง
                </button>
                <button type="button" class="text-blue-600 hover:underline">
                    ล้างแบบฟอร์ม
                </button>
            </div>
        </form>
    </div>

    <script>
        // Enable/disable "Other" input for future topics
        const checkOther = document.getElementById('other_topic_check');
        const inputOther = document.getElementById('other_topic_input');

        checkOther.addEventListener('change', () => {
            inputOther.disabled = !checkOther.checked;
            if(!checkOther.checked) inputOther.value = '';
        });

        // Clear form functionality
        document.querySelector('button[type="button"]').addEventListener('click', function() {
            if(confirm('คุณต้องการล้างแบบฟอร์มทั้งหมดหรือไม่?')) {
                document.querySelector('form').reset();
            }
        });
    </script>
</x-app-layout>
