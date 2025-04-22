# Generating the README.md content in markdown format as requested

readme_content = """
# 📚 نظام إدارة الكتب - Laravel 12

نظام متكامل لإدارة الكتب مبني باستخدام Laravel 12، وتم تطويره وفقًا لمبادئ **SOLID** لضمان نظافة الكود، قابلية التوسعة، وقوة الصيانة.

---

## ✅ المبادئ البرمجية SOLID

### 1. مبدأ المسؤولية الواحدة (SRP)
- كل Repository مسؤول عن وظيفة واحدة: إنشاء، تعديل، حذف أو عرض الكتب.

### 2. مبدأ الفتح/الإغلاق (OCP)
- يمكننا توسيع النظام بسهولة بإضافة Repository جديدة دون التعديل على الكود الموجود.

### 3. مبدأ الاستبدال (LSP)
- جميع الـ Repositories تستبدل الواجهات الخاصة بها دون أن تؤثر على سلوك النظام.

### 4. مبدأ فصل الواجهات (ISP)
- فصل الواجهات الكبيرة إلى واجهات صغيرة مثل:
    - `BookCreationInterface`
    - `BookUpdatingInterface`
    - `BookDeletionInterface`
    - `BookListingInterface`

### 5. مبدأ عكس الاعتماد (DIP)
- تعتمد الـ Controller على الـ Interface وليس على الكلاسات المباشرة.

---

## 🧱 تصميم الكيان الأساسي: الكتاب (Book)

### 1. قاعدة البيانات (Database Schema)
تم إنشاء جدول `books` عبر Migration مخصص يحتوي على الحقول التالية:

| الحقل             | الوصف |
|-------------------|-------|
| `id`              | المفتاح الأساسي |
| `title`           | عنوان الكتاب، فريد |
| `slug`            | نسخة صالحة للرابط من العنوان |
| `author_name`     | اسم المؤلف |
| `description`     | وصف تفصيلي للكتاب |
| `price`           | السعر مع خانتين عشريتين |
| `cover_image`     | مسار صورة الغلاف |
| `isbn`            | الرقم الدولي الموحد |
| `published_at`    | تاريخ النشر |
| `stock`           | عدد النسخ المتوفرة |
| `language`        | لغة الكتاب |
| `pages`           | عدد الصفحات |
| `is_valid`        | حالة صلاحية العرض |
| `created_at/updated_at` | تواريخ التحديث |

### 2. الموديل (Model)
الموديل `Book` يمثل الكيان `books` ويتحكم في البيانات المرتبطة به.  
تم تحديد الخصائص `fillable` حتى نتحكم في القيم التي يمكن تمريرها من الطلبات (Requests).

```php
protected $fillable = [
  'title', 'slug', 'author_name', 'description', 'price',
  'cover_image', 'isbn', 'published_at', 'stock',
  'language', 'pages', 'is_valid',
];
3. الاستخدام عبر بنية MVC
- Controller
يتم حقن الواجهات الخاصة بكل عملية داخل الـ Controller، مما يجعل الكود مرنًا وسهل الاختبار.

- Repositories
كل Repository يقوم بوظيفة محددة:

BookCreationRepository: إضافة الكتب إلى قاعدة البيانات.

BookUpdatingRepository: تعديل بيانات الكتب.

BookDeletionRepository: حذف الكتب وصور الأغلفة.

BookListingRepository: عرض وتفاصيل الكتب.

- View
تم استخدام Blade templates لعرض النماذج (Forms) والبيانات داخل الواجهة الأمامية.

- RAW Logic
لم نستخدم TransactionService ككلاس مستقل، بل استخدمنا منطق إدارة المعاملات مباشرة داخل دوال store و update باستخدام:

php
Always show details

Copy
DB::beginTransaction();
try {
    // العمليات
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    throw $e;
}
هذا يضمن سلامة البيانات في حال حدوث خطأ أثناء تنفيذ العمليات الحساسة مثل الإنشاء أو التحديث. """
