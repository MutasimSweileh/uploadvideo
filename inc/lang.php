<?php

function lang($lan,$type,$time=''){

  global $St;
if($type == 'admin'){

  $l='لوحة تحكم الاداره' ;        ;

}else if($type == 'home'){

  $l='الرئيسيه' ;
if(isand(true)){
$l = $St->title;
}
}else if($type == 'contact'){

  $l='اتصل بنا' ;

}else if($type == 'about'){

  $l='حول الموقع' ;

}else if($type == 'msg'){

  $l='الرسائل' ;

}else if($type == 'sendMail'){

  $l='الارسال' ;

}else if($type == 'setMail'){

  $l='الاعدادات' ;

}else if($type == 'reportMail'){

  $l='التقارير' ;

}else if($type == 'addMail'){

  $l='القوائم' ;

}else if($type == 'sms' || $type == 'Sms'){

  $l='خدمة الرسائل' ;

}else if($type == 'true'){

  $l='الاشتراك' ;

}else if($type == 'share'){

  $l='النشر' ;

}else if($type == 'myposts'){

  $l='منشوراتى' ;

}else if($type == 'install'){

  $l='تثبيت السكريبت' ;

}else if($type == 'nof'){

  $l='الاشعارات' ;

}else if($type == 'status'){

  $l='احصائيات النشر' ;

}else if($type == 'posts'){

  $l='المنشورات' ;

}else if($type == 'users'){

  $l='المستخدمين' ;

}else if($type == 'set'){

  $l='الاعدادات' ;

}else if($type == 'admin_login'){

  $l='عمليات الدخول' ;

}else if($type == 'check'){

  $l='فحص الاكسس' ;

}else if($type == 'logout'){

  $l='تسجيل الخروج' ;

}else if($type == 'title'){

  $l='اسم الموقع' ;

}else if($type == 'url'){

  $l='رابط الموقع' ;

}else if($type == 'logolink'){

  $l='رابط الايقونه' ;

}else if($type == 'app_id'){

  $l='اى دى التطبيق' ;

}else if($type == 'app_key'){

  $l='مفتاح التطبيق' ;

}else if($type == 'des'){

  $l='وصف الموقع' ;

}else if($type == 'site_status'){

  $l='حالة الموقع' ;

}else if($type == 'close'){

  $l='مغلق' ;

}else if($type == 'open'){

  $l='مفتوح' ;

}else if($type == 'close_msg'){

  $l='رسالة الاغلاق' ;

}else if($type == 'fb_link'){

  $l='صفحة الفيس بوك' ;

}else if($type == 'tw_link'){

  $l='صفحة تويتر' ;

}else if($type == 'youtube_link'){

  $l='قناة اليوتيوب' ;

}else if($type == 'home_ad'){

  $l='اعلان الصفحه الرئيسيه' ;

}else if($type == 'email'){

  $l='بريد المدير' ;

}else if($type == 'admin_name'){

  $l='اسم الادمن' ;

}else if($type == 'pass'){

  $l='باسورد الادمن' ;

}else if($type == 'PostTo'){

  $l='النشر لــ' ;

}else if($type == 'pages'){

  $l='الصفحات' ;

}else if($type == 'getpages'){

  $l='جلب صفحات المستخدم' ;

}else if($type == 'friends'){

  $l='الاصدقاء' ;

}else if($type == 'getfriends'){

  $l='جلب اصدقاء المستخدم' ;

}else if($type == 'post_help'){

  $l='يمكنك وضع {user} داخل المنشور <br> ليظهر مكانها اسم المستخدم' ;

}else if($type == 'cantry'){

  $l='اختر الدوله' ;

}else if($type == 'select_all'){

  $l='تحديد الكل' ;

}else if($type == 'unselect'){

  $l='الغاء التحديد' ;

}else if($type == 'login_msg'){

  $l='من فضلك قم اولا بتسجيل الدخول' ;

}else if($type == 'login'){

  $l='تسجيل الدخول' ;

}else if($type == 'update'){

  $l='تحديث السكريبت' ;

}else if($type == 'cron'){

  $l='النشر المجدول' ;

}else if($type == 'cron_time'){

  $l='وقت النشر المجدول بالساعات' ;

}else if($type == 'numposts'){

  $l='عدد المنشورات فى الرئيسيه' ;

}else if($type == 'tlink'){

  $l='الرابط' ;

}else if($type == 'sred'){

  $l='تحويل الاشتراك المباشر'         ;

}else if($type == 'ttext'){

  $l='النص'         ;

}else if($type == 'text' ){

  $l='نص'         ;

}else if($type == 'link'){

  $l='رابط'         ;

}else if($type == 'type_post'){

  $l='نوع المنشور'         ;

}else if($type == 'ttype_post'){

  $l='نوع العمليه'         ;

}else if($type == 'post'){

  $l='اضافه'         ;
if(isand("true"))
  $l= $St->title;

}else if($type == 'fb'){

  $l='فيس بوك'         ;

}else if($type == 'rvideo'){

  $l='شرح طريقة الأشتراك'         ;

}else if($type == 'likes'){

  $l='اوتو لايك'         ;

}else if($type == 'htc'){

  $l='التطبيق الدائم'         ;

}else if($type == 'hits'){

  $l='الزيارات'         ;

}else if($type == 'tfb'){

  $l='فيس بوك مجدول'         ;

}else if($type == 'delete'){

  $l='حذف المنشور'         ;

}else if($type == 'tw'){

  $l='تويتر'         ;

}else if($type == 'youtube'){

  $l='يوتيوب'         ;

}else if($type == 'logout_msg'){

  $l='تم تسجيل الخروج بنجاح'         ;

}else if($type == 'img'){

  $l='صوره'         ;

}else if($type == 'images'){

  $l='معرض الصور'         ;

}else if($type == 'video'){

  $l='معرض الفديو'         ;

}else if($type == 'timg'){

  $l='رابط الصوره'         ;

}else if($type == 'add'){

  $l='اضافة الى الجدول'         ;

}else if($type == 'sleep'){

  $l='الفاصل الزمنى'         ;

}else if($type == 'time'){

  $l='وقت النشر'         ;

}else if($type == 'token'){

  $l='فحص'         ;

}else if($type == 'count'){

  $l='العدد الكلى'         ;

}else if($type == 'success'){

  $l='نجح'         ;

}else if($type == 'error'){

  $l='فشل'         ;

}else if($type == 'status_post'){

  $l='الحاله'         ;

}else if($type == 'option_post'){

  $l='خيارات'         ;

}else if($type == 'tp'){

  $l='نوع المستخدم'         ;

}else if($type == 'male'){

  $l='ذكر'         ;

}else if($type == 'female'){

  $l='اثنى'         ;

}else if($type == 'all'){

  $l='الكل'         ;

}else if($type == 'nosend'){

  $l='لم يتم'         ;

}else if($type == 'send'){

  $l='تم'         ;

}else if($type == 'time_post'){

  $l='منشورات لم يتم نشرها'         ;

}else if($type == 'red_link'){

  $l='رابط الاشتراك المباشر'         ;

}else if($type == 'cron_link'){

  $l='رابط ملف الكرون'         ;

}else if($type == 'backup'){

  $l='نسخه احتياطيه من قاعدة البيانات'         ;

}else if($type == 'numpost'){

  $l='عدد المنشورات'         ;

}else if($type == 'type'){

  $l='النوع'         ;

}else if($type == 'Stw'){

  $l='اشتراك تويتر'         ;

}else if($type == 'Sadmin'){

  $l='بيانات الادمن'         ;

}else if($type == 'numnof'){

  $l='عدد الاشعارات'         ;

}else if($type == 'privacy'){

  $l='سياسة الخصوصيه'         ;

}else if($type == 'watch'){

  $l='مشاهده'         ;

}else if($type == 'copy'){

  $l='جميع الحقوق محفوظه'         ;

}else if($type == 'me'){

  $l='تصميم وبرمجة : معتصم محمد'         ;

}else if($type == 'hide'){

  $l='اخفاء'         ;

}else if($type == 'rfb'){

  $l='اشتراك فيس بوك'         ;

}else if($type == 'danger'){

  $l='تحذير  !!!'         ;

}else if($type == 'click_here'){

  $l='اضغط هنا'         ;

}else if($type == 'danger_msg'){

  $l='هذا السكريبت مدفوع  ولا يحق  لك استخدامه الى بأذن المبرمج يمكنك التواصل  معه   وطلب الحصول على ترخيص  ....'         ;

}else if($type == 'rtw'){

  $l='اشتراك تويتر'         ;

}else if($type == 'HTC'){

  $l='HTC'         ;

}else if($type == 'UpDate'){

  $l='تحديث'         ;

}else if($type == 'logo'){

  $l='ايقونة الموقع'         ;

}else if($type == 'Delete'){

  $l='حذف الاشتراك'         ;

}else if($type == 'mDelete'){

  $l='سيتم حذف الاشتراك فورا ان شاء الله بعد كتابه  سبب الحذف فى الاسفل  فضلا قم بكتابه السبب كى نعمل على تحسين الخدمه .'         ;

}else if($type == 'Delete_msg'){

  $l='اكتب هنا السبب لحذف الاشتراك وسيتم الحذف فورا ان شاء الله'         ;

}else if($type == 'AddPost'){

  $l='اضافة منشور'         ;

}else if($type == 'write'){

  $l='اكتب هنا المنشور ....'         ;

}else if($type == 'Ltext'){

  $l='رسالة تسجيل الدخول'         ;

}else if($type == 'TimeShare'){

  $l='تحديد وقت النشر'         ;

}else if($type == 'save'){

  $l='حفظ'         ;

}else if($type == 'Ctype'){

  $l='نوع الفحص'         ;

}else if($type == 'TtDelete'){

  $l='حذف المتوقف تلقائى'         ;

}else if($type == 'alll'){

  $l='كل'         ;

}else if($type == 'p'){

  $l='منشور'         ;

}else if($type == 'Ired'){

  $l='سيمكنك هذا الخيار من تحويل  المشترك بعد الاشتراك على اى رابط تريد'         ;

}else if($type == 'TDelete'){

  $l='حذف العمليات المكتمله'         ;

}else if($type == 'h'){

  $l='ساعه'         ;

}else if($type == 'Ishare'){

  $l='النشر الفورى'         ;

}else if($type == 'Iadd'){

  $l='اضافه الى النشر المجدول'         ;

}else if($type == 'Ttask'){

  $l='العمليات'         ;

}else if($type == 'Fw'){

  $l='اكتب كلمة البحث ثم اضغط انتر'         ;

}else if($type == 'Fbtn'){

  $l='بحث'         ;

}else if($type == 'Clink'){

  $l='رابط مخصص'         ;

}else if($type == 'video'){

  $l='فديو'         ;

}else if($type == 'Nlink'){

  $l='رابط تلقائى'         ;

}else if($type == 'Nmlink'){

  $l='عنوان الرابط'         ;

}else if($type == 'Dlink'){

  $l='وصف الرابط'         ;

}else if($type == 'Ilink'){

  $l='صورة الرابط'         ;

}else if($type == 'online'){

  $l='المتواجدين الان'         ;

}else if($type == 'UDelete'){

  $l='حذف المتوقف'         ;

}else if($type == 'Nots'){

  $l='ملحوظه'         ;

}else if($type == 'Ssite'){

  $l='الاعدادات العامه'         ;

}else if($type == 'Sfb'){

  $l='اعدادات فيس بوك'         ;

}else if($type == 'Satw'){

  $l='اعدادات تويتر'         ;

}else if($type == 'CDuser'){

  $l='يفضل فحص الاكسس اولا قبل القيام بهذا الاجراء'         ;

}else if($type == 'Sadmin'){

  $l='بيانات الادمن'         ;

}else if($type == 'users_fb'){

  $l='مستخدمين فيس بوك'         ;

}else if($type == 'users_tw'){

  $l='مستخدمين توتير'         ;

}else if($type == 'utime'){

  $l='وقت النشر '.$time.' ساعه';

}else if($type == 'EditeTime'){

  $l='تعديل وقت النشر'         ;

}else if($type == 'duser'){



$l='انت  بالفعل غير مشترك فى التطبيق اتصل بنا لمزيد من المعلومات';

}else if($type == 'posttime'){
$l = "وقت النشر ";
}else if($type == 'Sup'){



$l='تحديث';

}else if($type == 'Fbpage'){



$l='تابعنا على شبكات التواصل الاجتماعى';

}else{
  $l = $St->title;
}

return $l;

}

    function Ginfo($l='',$t)

    {

if($t == 1){

$l="رابط تلقائى";

}else if($t == 5){

$l="صوره عاديه";

}else if($t == 6){

$l="ورد قرآنى";

}else if($t == 2){

$l="صور  تحول الى رابط";

}else if($t == 8){

$l="اشتراك فورى ثم تحويل";

}else if($t == 3){

$l="رابط مخصص";

}else if($t == 4){

$l="تدوينه";

}else if($t == 7){

$l="فديو";

}else if($t == 'male'){

$l="ذكر";

}else if($t == "female"){

$l="انثى";

}else if($t == 0){

$l="نص";

}

return $l;

 }

function Sshare($lg,$s)

    {

if($s == 1){

$l="تم الانتهاء";

}else if($s == 2){

$l="<font color='red'>تم حظر او حذف المنشور </font>";

}else if($s == 3){

$l="<font color='red'>تم  ايقاف التطبيق</font>";

}else if($s == 4){

$l="<font color='red'>تم ايقاف العمليه</font>";

}else{

$l="جارى الارسال";

}

return $l;

 }

 function isSend($l,$s)

    {

if($s == 1){

$l="تم النشر";

}else if($s == 0){

$l="لم يتم";

}

return $l;

 }

 function Sactive($l,$s)

    {

if($s == 1){

$l="مفعل ";

}else{

$l="غير مفعل";

}

return $l;

 }

 function Dactive($l,$s)

    {

if($s == 0){

$l="مفعل ";

}else{

$l="غير مفعل";

}

return $l;

 }



?>
