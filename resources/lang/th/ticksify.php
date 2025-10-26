<?php

return [
    'name' => 'FOB Ticksify',
    'category' => 'หมวดหมู่',
    'title' => 'หัวข้อ',
    'ticket' => 'ตั๋ว',
    'priority' => 'ลำดับความสำคัญ',
    'content' => 'เนื้อหา',
    'locked' => 'ถูกล็อค',
    'resolved' => 'แก้ไขแล้ว',
    'replies' => 'ตอบกลับ',
    'ticket_id' => 'รหัสตั๋ว',
    'created_at' => 'สร้างเมื่อ',
    'updated_at' => 'อัปเดตเมื่อ',
    'reply' => 'ตอบกลับตั๋ว',
    'resolved_message' => 'ตั๋วนี้ได้รับการแก้ไขแล้ว',
    'locked_message' => 'ตั๋วนี้ถูกล็อค ผู้ใช้ไม่สามารถตอบกลับได้',
    'update_ticket' => 'อัปเดตตั๋ว',
    'user' => 'ผู้ใช้',
    'staff' => 'พนักงาน',
    'menu_counter' => ':count เปิด',
    'total' => 'ทั้งหมด',

    'tickets' => [
        'name' => 'ตั๋ว',
    ],

    'categories' => [
        'name' => 'หมวดหมู่',
    ],

    'messages' => [
        'name' => 'ข้อความ',
    ],

    'enums' => [
        'statuses' => [
            'open' => 'เปิด',
            'in_progress' => 'กำลังดำเนินการ',
            'on_hold' => 'พักไว้',
            'closed' => 'ปิด',
        ],

        'priorities' => [
            'low' => 'ต่ำ',
            'medium' => 'ปานกลาง',
            'high' => 'สูง',
            'critical' => 'วิกฤต',
        ],
    ],
];
