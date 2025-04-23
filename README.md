اعتمدت على 4 كيانات رئيسية في قاعدة البيانات:

1. users (المستخدمين)
   يمثل الأشخاص المسجلين في النظام، سواء كانوا قرّاء أو مؤلفين.

2. book_types (أنواع الكتب)
   مثل: رواية، تقنية، ديني، أطفال...

3. languages (اللغات)
   مثل: عربي، إنجليزي، فرنسي...

4. books (الكتب)
   الكيان الأساسي ويحتوي على كافة تفاصيل الكتاب.


الكيانات وخصائصها:

كيان: User
الموديل المقابل: App\Models\User

المستخدمون هم من يملكون الكتب أو يديرونها في النظام.

الخاصية | النوع | الوصف
id | int | رقم المستخدم
name | string | اسم المستخدم
email | string | البريد الإلكتروني
password | string | كلمة المرور
timestamps | timestamps | وقت الإنشاء والتحديث



كيان: BookType

الموديل المقابل: App\Models\BookType

يعبر عن تصنيف الكتاب مثل: رواية، تقنية، ديني...

الخاصية | النوع | الوصف
id | int | رقم نوع الكتاب
name | string | اسم النوع (رواية...)


كيان: Language

الموديل المقابل: App\Models\Language

يعبر عن اللغة التي كتب بها كل كتاب.

الخاصية | النوع | الوصف
id | int | رقم اللغة
name | string | اسم اللغة
abbreviation | string | اختصار (مثل EN)


كيان: Book

الموديل المقابل: App\Models\Book

يمثل كيان الكتاب في النظام، ويحتوي على الخصائص التالية:
الخاصية | النوع | الوصف
id | int | رقم الكتاب
title | string | عنوان الكتاب
slug | string | عنوان للرابط
author_id | foreign key | يربط الكتاب بالمستخدم (User)
description | text | وصف الكتاب
price | float | سعر الكتاب
cover_image | string | صورة الغلاف
pdf_copy | string | نسخة PDF
isbn | string | رقم ISBN (اختياري)
published_at | date | تاريخ النشر
stock | integer | عدد النسخ المتوفرة
language_id | foreign key | يربط بلغة محددة
type_id | foreign key | يربط بنوع كتاب
pages | int | عدد الصفحات
is_valid | boolean | هل الكتاب صالح للنشر؟
timestamps | timestamps | تاريخ الإنشاء والتعديل تلقائيًا


في الموديلات التي تحتاج  تجربه لبيانات وهميه 

استخدمت HasFactory لدعم إنشاء بيانات وهمية للتجريب (باستخدام Factory).



#################################################################################

تم بناء نظام إدارة الكتب في Laravel 12 باستخدام هيكلية تعتمد على مبادئ SOLID، من خلال استخدام:

الواجهات (Interfaces)

الفئات المستودعية (Repositories)

الفصل بين المسؤوليات (Separation of Concerns)


تطبيق مبادئ SOLID عمليًا:
1. Single Responsibility Principle (SRP)
مبدأ المسؤولية الواحدة
تم فصل كل عملية (إنشاء، عرض، تعديل، حذف) في واجهة (Interface) مستقلة، وفي كلاس Repository مستقل.

الوظيفة | الواجهة | الكلاس
إضافة كتاب | BookCreationInterface | BookCreationRepository
عرض الكتب | BookListingInterface | BookListingRepository
التعديل | BookUpdatingInterface | BookUpdatingRepository
الحذف | BookDeletionInterface | BookDeletionRepository


هذا يحقق المسؤولية الواحدة لكل كلاس، بحيث لا يحمل أكثر من مهمة واحدة.


2. Open/Closed Principle (OCP)
   الكود مفتوح للإضافة، مغلق للتعديل
   تم اعتماد واجهات، مما يتيح إضافة منطق مختلف (مثلاً: تخزين الكتاب في Amazon S3 أو إرسال إشعار عند الإضافة) دون تعديل الكود الأساسي، فقط نغير Repository داخل الـ Service Container.

// تغيير ربط الواجهة بكلاس جديد فقط
app()->bind(BookCreationInterface::class, NewBookCreationRepository::class);


3. Liskov Substitution Principle (LSP)
استبدال الكلاس الأب بالكلاس الابن دون كسر النظام
كل Repository يطبّق الواجهة الخاصة به بشكل يضمن أن أي عملية تعتمد على تلك الواجهة لن تتعطل إذا تم تبديل الكلاس.



4. Interface Segregation Principle (ISP)
عدم إجبار الكلاس على تطبيق واجهات لا يحتاجها
بدلاً من واجهة ضخمة فيها كل الدوال، تم تقسيم الوظائف إلى واجهات صغيرة متخصصة مثل:

BookCreationInterface

BookUpdatingInterface

BookDeletionInterface

BookListingInterface

 هذا يجعل كل Repository يطبق فقط ما يحتاجه بالضبط.


5. Dependency Inversion Principle (DIP)
   اعتمد على التجريد (الواجهات) بدل التحديد (كلاسات)
   التحكم الكامل تم من خلال حقن التبعيات باستخدام الواجهات داخل الـ Controller:

هذا يجعل الكود قابل للاختبار (Testable)، وسهل التوسعة بدون تعديل الكلاس.


############################################################################################################


FileTraits
هو Trait يعيد استخدامه أكثر من Repository، هدفه تنظيم عمليات رفع الملفات (upload) و الحذف (delete) داخل المشروع.

UserFactory
يولد بيانات مستخدم عشوائي مع كلمة مرور password مشفرة باستخدام Hash::make()



BookFactory
ينشئ بيانات كتب تلقائيًا عبر Faker، ويملأ كل الخصائص مثل:

title, author_id, language_id, type_id

يستخدم Str::slug() و randomFloat() و isbn13


يعتمد على:

علاقات فعلية (Users, Languages, BookTypes)

يستثني رفع صورة أو PDF حقيقية لتسهيل الاستخدام


 BookTypeSeeder:
يولّد قائمة بأنواع الكتب مثل:

Novels, Technology, Religious, Science, etc.


LanguageTableSeeder:
يضيف قائمة ضخمة من اللغات العالمية مع اختصاراتها، وهي ضرورية لربط الكتب بلغة معينة.

تم استخدام الseeder ل :
لتجهيز النظام ببيانات افتراضية جاهزة.

تسريع التجريب دون الحاجة لإدخال يدوي.

يمكن إعادة تكرارها في كل نسخة من النظام بسهولة.

########################################################################################

 BookRequest (التحقق من صحة البيانات - Validation)
 حماية النظام من مدخلات خاطئة أو ضارة

ضمان أن البيانات نظيفة ومرتبة

 ModifiBookMiddleware (التأكد من صلاحية التعديل)

 Middleware يقوم بمنع المستخدمين من تعديل أو حذف كتب لا يملكونها.

 RedirectIfAuth (منع المستخدم المسجل من العودة لصفحة تسجيل الدخول)

Middleware يمنع المستخدم الذي قام بتسجيل الدخول من الرجوع إلى صفحة تسجيل الدخول أو التسجيل.

 نظام الـ Routes
 تم بناء نظام المسارات على الشكل التالي:

Route | Functionality | Middleware
/books | عرض الكتب | auth
/books/create | نموذج إضافة كتاب | auth
/books/{book}/edit | تعديل كتاب معين | auth + canModifyBook
/books/{book} | عرض كتاب معين | auth
/books/{book} (PUT) | تعديل الكتاب في القاعدة | auth + canModifyBook
/books/{book} (DEL) | حذف الكتاب | auth + canModifyBook
/login, /register | تسجيل دخول/تسجيل جديد | redirect.auth


خلاصه :
تم استخدام نظام التحقق من صحة البيانات في Laravel من خلال BookRequest لضمان أن جميع البيانات المدخلة مطابقة للمعايير المطلوبة، مع تخصيص رسائل الخطأ.
كما تم تطبيق Middleware باسم ModifiBookMiddleware لحماية الكتب من التعديل من قبل مستخدمين غير مخولين.
ولتحسين تجربة المستخدم، تم إعداد Middleware إضافي RedirectIfAuth لمنع تسجيل الدخول المكرر.
تم تنظيم المسارات باستخدام RESTful routes مدعومة بجميع القيود الأمنية المطلوبة مثل auth و canModifyBook.
