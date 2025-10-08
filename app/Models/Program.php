<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Program extends Model
{
        use HasFactory;
    protected $fillable = ['image', 'category_id', 'title', 'detail'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sessions()
    {
        return $this->hasMany(TrainingSession::class);
    }

    
        /**
     * Get the program's detail as a formatted HTML list.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function detail(): Attribute
    {
        return Attribute::make(
            // Accessor (Getter): 'comma,separated,string' -> '<ul><li>...</li></ul>'
            get: function ($value) {
                if (!$value) {
                    return null;
                }

                // 1. แยกส่วนหัวข้อ (ถ้ามี) ออกจากส่วนรายการ
                $parts = explode(':', $value, 2);
                $heading = '';
                $listContent = $value;

                if (count($parts) > 1) {
                    // ถ้าเจอ ':' ให้ถือว่าส่วนแรกเป็นหัวข้อ
                    $heading = '<p><strong>' . trim($parts[0]) . ':</strong></p>';
                    $listContent = $parts[1];
                }

                // 2. แปลงส่วนรายการ (ที่คั่นด้วย comma) ให้เป็น <li>
                $items = collect(explode(',', $listContent))
                    ->map(fn($item) => '<li>' . trim($item) . '</li>')
                    ->implode('');

                // 3. ประกอบร่าง HTML กลับเข้าไป
                return $heading . "<ul>{$items}</ul>";
            },

            // Mutator (Setter): '<ul><li>...</li></ul>' -> 'comma,separated,string'
            // (เรายังไม่จำเป็นต้องใช้ส่วนนี้ แต่เตรียมไว้)
            set: function ($value) {
                // ถ้าข้อมูลที่เข้ามาเป็น HTML list อยู่แล้ว ให้แปลงกลับ
                if (str_contains($value, '<li>')) {
                    preg_match_all('/<li>(.*?)<\/li>/', $value, $matches);
                    return implode(', ', $matches[1]);
                }
                return $value; // ถ้าเป็น string ธรรมดา ให้เก็บตามนั้น
            }
        );
    }

    /**
     * Get the raw detail attribute for forms.
     */
    public function getRawDetailAttribute()
    {
        // getOriginal() จะดึงค่าดิบๆ จากฐานข้อมูลโดยไม่ผ่าน Accessor
        return $this->getOriginal('detail');
    }
}

