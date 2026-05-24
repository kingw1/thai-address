# 🇹🇭 Thai Address

Laravel Package สำหรับจัดการข้อมูลที่อยู่ไทย (ตำบล / อำเภอ / จังหวัด / รหัสไปรษณีย์) พร้อมรหัสพื้นที่ครบถ้วน

ข้อมูลอ้างอิงจาก [jquery.Thailand.js](https://github.com/earthchie/jquery.Thailand.js) โดย earthchie

---

## ความต้องการของระบบ

- PHP `^8.2`
- Laravel `^10.0 | ^11.0 | ^12.0 | ^13.0`

---

## การติดตั้ง

```bash
composer require vichone/thai-address
```

---

## การใช้งาน

### Import ข้อมูลลง Database

Package มีข้อมูลที่อยู่ไทยมาให้พร้อมแล้ว ไม่ต้องต่อ internet

```bash
php artisan thai-addresses:install
```

### อัพเดทข้อมูลล่าสุดจาก GitHub

ใช้เมื่อต้องการดึงข้อมูลใหม่จาก source

```bash
php artisan thai-addresses:sync
```

---

## Commands

| Command | คำอธิบาย |
|---|---|
| `thai-addresses:install` | Import ข้อมูลจาก JSON ที่มาพร้อม package เข้า DB (ไม่ต้องต่อ internet) |
| `thai-addresses:sync` | ดึงข้อมูลล่าสุดจาก GitHub → บันทึก JSON → import ลง DB |

### Options

```bash
# ดูตัวอย่างข้อมูลก่อน import จริง
php artisan thai-addresses:install --dry-run
php artisan thai-addresses:sync --dry-run
```

---

## Models

### `ThaiAddress`

ใช้สำหรับค้นหาข้อมูลที่อยู่ไทย

```php
use VichOne\ThaiAddress\Models\ThaiAddress;

// ค้นหาตำบล
ThaiAddress::where('subdistrict', 'like', '%ลาดยาว%')->get();

// ค้นหาตามจังหวัด
ThaiAddress::where('province', 'กรุงเทพมหานคร')->get();

// ค้นหาตามรหัสไปรษณีย์
ThaiAddress::where('postal_code', '10900')->get();

// ค้นหาตามรหัสอำเภอ
ThaiAddress::where('district_code', '1001')->get();
```

### `Address`

ใช้สำหรับบันทึกที่อยู่ของ Model ต่างๆ ในระบบ รองรับ Polymorphic Relationship

```php
use VichOne\ThaiAddress\Models\Address;

// สร้างที่อยู่ใหม่
Address::create([
    'addressable_type' => 'App\Models\User',
    'addressable_id'   => 1,
    'label'            => 'บ้าน',
    'address'          => '123',
    'moo'              => '7',
    'road'             => 'สุขุมวิท',
    'subdistrict'      => 'คลองเตย',
    'district'         => 'คลองเตย',
    'province'         => 'กรุงเทพมหานคร',
    'postal_code'      => '10110',
    'contact_phone'    => '0812345678',
]);
```

---

## Trait `HasAddresses`

ใช้กับ Model ใดก็ได้ที่ต้องการเก็บข้อมูลที่อยู่ เช่น `User`, `Customer`, `Shop`

### 1. เพิ่ม Trait เข้า Model

```php
use VichOne\ThaiAddress\Traits\HasAddresses;

class User extends Authenticatable
{
    use HasAddresses;
}
```

### 2. ใช้งาน

```php
$user = User::find(1);

// ดึงที่อยู่ทั้งหมดของ user
$user->addresses;

// เพิ่มที่อยู่ใหม่
$user->addresses()->create([
    'label'         => 'บ้าน',
    'address'       => '123',
    'moo'           => '7',
    'road'          => 'สุขุมวิท',
    'subdistrict'   => 'คลองเตย',
    'district'      => 'คลองเตย',
    'province'      => 'กรุงเทพมหานคร',
    'postal_code'   => '10110',
    'contact_phone' => '0812345678',
]);

// ดึงที่อยู่แรก
$user->addresses()->first();

// ค้นหาที่อยู่ตาม label
$user->addresses()->where('label', 'บ้าน')->first();
```

---

## โครงสร้างตาราง

### `thai_addresses`

| Column | Type | คำอธิบาย |
|---|---|---|
| `id` | bigint | Primary key |
| `subdistrict_code` | string | รหัสตำบล |
| `subdistrict` | string | ชื่อตำบล / แขวง |
| `district_code` | string | รหัสอำเภอ |
| `district` | string | ชื่ออำเภอ / เขต |
| `province_code` | string | รหัสจังหวัด |
| `province` | string | ชื่อจังหวัด |
| `postal_code` | string | รหัสไปรษณีย์ |
| `created_at` | timestamp |
| `updated_at` | timestamp |
| `deleted_at` | timestamp | Soft delete |

### `addresses`

| Column | Type | คำอธิบาย |
|---|---|---|
| `id` | bigint | Primary key |
| `addressable_type` | string | ชื่อ Model ที่เชื่อมอยู่ |
| `addressable_id` | bigint | ID ของ Model ที่เชื่อมอยู่ |
| `label` | string | ชื่อที่อยู่ เช่น บ้าน, ที่ทำงาน |
| `address` | string | บ้านเลขที่ |
| `moo` | string | หมู่ที่ |
| `road` | string | ถนน |
| `subdistrict` | string | ตำบล / แขวง |
| `district` | string | อำเภอ / เขต |
| `province` | string | จังหวัด |
| `postal_code` | string | รหัสไปรษณีย์ |
| `contact_phone` | string | เบอร์โทรติดต่อ |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

## แหล่งที่มาของข้อมูล

ข้อมูลที่อยู่ไทยได้รับมาจาก [jquery.Thailand.js](https://github.com/earthchie/jquery.Thailand.js) ซึ่งอ้างอิงจากฐานข้อมูลของไปรษณีย์ไทย

---

## License

MIT