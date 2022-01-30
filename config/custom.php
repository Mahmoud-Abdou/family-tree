<?php

return [

    // relations types
    'relations-types' => ['general', 'media', 'video', 'event', 'news', 'newborn', 'marriages'],

    // Categories types
    'category-types' => ['general', 'media', 'video', 'event', 'news', 'newborn', 'marriages', 'deaths'],

    //all roles
    'roles' => [
        'dashboard' => ['slug' => 'dashboard', 'name' => 'Dashboard', 'name_ar' => 'لوحة التحكم'],
        'users' => ['slug' => 'users', 'name' => 'Users', 'name_ar' => 'المستخدمين'],
        'roles' => ['slug' => 'roles', 'name' => 'Roles', 'name_ar' => 'الصلاحيات'],
        'cities' => ['slug' => 'cities', 'name' => 'Cities', 'name_ar' => 'المدن'],
        'categories' => ['slug' => 'categories', 'name' => 'Categories', 'name_ar' => 'التصنيفات'],
        'settings' => ['slug' => 'settings', 'name' => 'Settings', 'name_ar' => 'الاعدادات'],
        'activities' => ['slug' => 'activities', 'name' => 'Activities', 'name_ar' => 'سجل العمليات'],
        'news' => ['slug' => 'news', 'name' => 'News', 'name_ar' => 'الأخبار'],
        'families' => ['slug' => 'families', 'name' => 'Families', 'name_ar' => 'العائلات'],
        'newborns' => ['slug' => 'newborns', 'name' => 'Newborns', 'name_ar' => 'المواليد'],
        'death' => ['slug' => 'death', 'name' => 'Death', 'name_ar' => 'الوفيات'],
        'media' => ['slug' => 'media', 'name' => 'Media', 'name_ar' => 'معرض الصور'],
        'events' => ['slug' => 'events', 'name' => 'Events', 'name_ar' => 'المناسبات'],
    ],

    //all permissions
    'permissions' => [
        'users' => [
            ['name' => 'users.read', 'name_ar' => 'مشاهدة المستخدمين', 'description' => 'مشاهدة المستخدمين'],
            ['name' => 'users.create', 'name_ar' => 'اضافة المستخدمين', 'description' => 'اضافة المستخدمين'],
            ['name' => 'users.update', 'name_ar' => 'تعديل المستخدمين', 'description' => 'تعديل المستخدمين'],
            ['name' => 'users.delete', 'name_ar' => 'حذف المستخدمين', 'description' => 'حذف المستخدمين'],
            ['name' => 'users.activate', 'name_ar' => 'تفعيل المستخدمين', 'description' => 'تفعيل المستخدمين'],
        ],
        'roles' => [
            ['name' => 'roles.read', 'name_ar' => 'مشاهدة الصلاحيات', 'description' => 'تفعيل الصلاحيات'],
            ['name' => 'roles.create', 'name_ar' => 'اضافة صلاحيات', 'description' => 'اضافة الصلاحيات'],
            ['name' => 'roles.update', 'name_ar' => 'تعديل الصلاحيات', 'description' => 'تعديل الصلاحيات'],
            ['name' => 'roles.delete', 'name_ar' => 'حذف الصلاحيات', 'description' => 'حذف الصلاحيات'],
        ],
        'cities' => [
            ['name' => 'cities.read', 'name_ar' => 'مشاهدة المدن', 'description' => 'مشاهدة المدن'],
            ['name' => 'cities.create', 'name_ar' => 'اضافة مدينة', 'description' => 'اضافة المدن'],
            ['name' => 'cities.update', 'name_ar' => 'تعديل مدينة', 'description' => 'تعديل المدن'],
            ['name' => 'cities.delete', 'name_ar' => 'حذف مدينة', 'description' => 'حذف المدن'],
        ],
        'settings' => [
            ['name' => 'settings.read', 'name_ar' => 'مشاهدة الاعدادات', 'description' => 'مشاهدة الاعدادات'],
            ['name' => 'settings.update', 'name_ar' => 'تعديل الاعدادات', 'description' => 'تعديل الاعدادات'],
        ],
        'news' => [
            ['name' => 'news.read', 'name_ar' => 'مشاهدة الأخبار', 'description' => 'مشاهدة الأخبار'],
            ['name' => 'news.create', 'name_ar' => 'اضافة خبر', 'description' => 'اضافة خبر'],
            ['name' => 'news.update', 'name_ar' => 'تعديل خبر', 'description' => 'تعديل خبر'],
            ['name' => 'news.delete', 'name_ar' => 'حذف خبر', 'description' => 'حذف خبر'],
        ],
        'families' => [
            ['name' => 'families.read', 'name_ar' => 'مشاهدة العائلات', 'description' => 'مشاهدة العائلات'],
            ['name' => 'families.create', 'name_ar' => 'اضافة عائلة', 'description' => 'اضافة عائلة'],
            ['name' => 'families.update', 'name_ar' => 'تعديل عائلة', 'description' => 'تعديل عائلة'],
            ['name' => 'families.delete', 'name_ar' => 'حذف عائلة', 'description' => 'حذف عائلة'],
        ],
        'newborns' => [
            ['name' => 'newborns.read', 'name_ar' => 'مشاهدة الولادات', 'description' => 'مشاهدة الولادات'],
            ['name' => 'newborns.create', 'name_ar' => 'اضافة ولادة', 'description' => 'اضافة ولادة'],
            ['name' => 'newborns.update', 'name_ar' => 'تعديل ولادة', 'description' => 'تعديل ولادة'],
            ['name' => 'newborns.delete', 'name_ar' => 'حذف ولادة', 'description' => 'حذف ولادة'],
        ],
        'death' => [
            ['name' => 'death.read', 'name_ar' => 'مشاهدة الوفيات', 'description' => 'مشاهدة الوفيات'],
            ['name' => 'death.create', 'name_ar' => 'اضافة وفاة', 'description' => 'اضافة وفاة'],
            ['name' => 'death.update', 'name_ar' => 'تعديل وفاة', 'description' => 'تعديل وفاة'],
            ['name' => 'death.delete', 'name_ar' => 'حذف وفاة', 'description' => 'حذف وفاة'],
        ],
        'media' => [
            ['name' => 'media.read', 'name_ar' => 'مشاهدة الوسائط', 'description' => 'مشاهدة الوسائط'],
            ['name' => 'media.create', 'name_ar' => 'اضافة وسائط', 'description' => 'اضافة وسائط'],
            ['name' => 'media.update', 'name_ar' => 'تعديل وسائط', 'description' => 'تعديل وسائط'],
            ['name' => 'media.delete', 'name_ar' => 'حذف وسائط', 'description' => 'حذف وسائط'],
        ],
//        'histories' => [
//            ['name' => 'histories.read', 'name_ar' => 'مشاهدة السجل', 'description' => 'مشاهدة السجل'],
//            ['name' => 'histories.delete', 'name_ar' => 'حذف السجل', 'description' => 'حذف السجل'],
//        ],
        'activities' => [
            ['name' => 'activities.read', 'name_ar' => 'مشاهدة السجل', 'description' => 'مشاهدة السجل'],
            ['name' => 'activities.delete', 'name_ar' => 'حذف السجل', 'description' => 'حذف السجل'],
        ],
        'events' => [
            ['name' => 'events.read', 'name_ar' => 'مشاهدة المناسبات', 'description' => 'مشاهدة المناسبات'],
            ['name' => 'events.create', 'name_ar' => 'اضافة مناسبة', 'description' => 'اضافة مناسبة'],
            ['name' => 'events.update', 'name_ar' => 'تعديل مناسبة', 'description' => 'تعديل مناسبة'],
            ['name' => 'events.delete', 'name_ar' => 'حذف مناسبة', 'description' => 'حذف مناسبة'],
        ],
        'categories' => [
            ['name' => 'categories.read', 'name_ar' => 'مشاهدة التصنيفات', 'description' => 'مشاهدة التصنيفات'],
            ['name' => 'categories.create', 'name_ar' => 'اضافة التصنيف', 'description' => 'اضافة التصنيف'],
            ['name' => 'categories.update', 'name_ar' => 'تعديل التصنيف', 'description' => 'تعديل التصنيف'],
            ['name' => 'categories.delete', 'name_ar' => 'حذف التصنيف', 'description' => 'حذف التصنيف'],
        ],
        'dashboard' => [
            ['name' => 'dashboard.read', 'name_ar' => 'مشاهدة لوحة التحكم', 'description' => 'مشاهدة لوحة التحكم'],
            ['name' => 'dashboard.update', 'name_ar' => 'تعديل لوحة التحكم', 'description' => 'تعديل لوحة التحكم'],
        ],

    ],

    // main menu
    'main_menu' => [
        ['id' => 1, 'title' => 'Profile', 'title_ar' => 'الرئيسية', 'link' => 'home', 'icon' => 'ri-home-line', 'permission' => null, 'child' => null],
//        ['id' => 2, 'title' => 'Family', 'title_ar' => 'العائلة', 'link' => 'home', 'icon' => 'ri-group-2-line', 'permission' => '', 'child' => null],
        ['id' => 3, 'title' => 'About Family', 'title_ar' => 'نبذة عن العائلة', 'link' => 'about', 'icon' => 'ri-information-line', 'permission' => null, 'child' => null],
        ['id' => 4, 'title' => 'Family Tree', 'title_ar' => 'شجرة العائلة', 'link' => 'home', 'icon' => 'ri-group-2-line', 'permission' => 'families.read', 'child' => null],
        ['id' => 5, 'title' => 'Events', 'title_ar' => 'المناسبات', 'link' => 'events.index', 'icon' => 'ri-calendar-event-line', 'permission' => 'events.read', 'child' => null],
        ['id' => 6, 'title' => 'Newborn', 'title_ar' => 'المواليد', 'link' => 'newborns.index', 'icon' => 'ri-user-smile-line', 'permission' => 'newborns.read', 'child' => null],
        ['id' => 7, 'title' => 'Death', 'title_ar' => 'الوفيات', 'link' => 'deaths.index', 'icon' => 'ri-user-4-line', 'permission' => 'death.read', 'child' => null],
        ['id' => 8, 'title' => 'Media', 'title_ar' => 'المعرض', 'link' => 'home', 'icon' => 'ri-image-2-line', 'permission' => 'media.read', 'child' => null],
        ['id' => 9, 'title' => 'News', 'title_ar' => 'الأخبار', 'link' => 'news.index', 'icon' => 'ri-newspaper-line', 'permission' => 'news.read', 'child' => null],
    ],

    'app_menu' => [
        ['id' => 1, 'title' => 'Dashboard', 'title_ar' => 'لوحة التحكم', 'link' => 'admin.dashboard', 'icon' => 'ri-dashboard-line', 'permission' => 'dashboard.read', 'child' => null],
        ['id' => 2, 'title' => 'Users', 'title_ar' => 'المستخدمين', 'link' => 'admin.users.index', 'icon' => 'ri-user-2-line', 'permission' => 'users.read', 'child' => null],
        ['id' => 3, 'title' => 'Roles', 'title_ar' => 'الصلاحيات', 'link' => 'admin.roles.index', 'icon' => 'ri-guide-line', 'permission' => 'roles.read', 'child' => null],
        ['id' => 4, 'title' => 'Cities', 'title_ar' => 'المدن', 'link' => 'admin.cities.index', 'icon' => 'ri-map-2-line', 'permission' => 'cities.read', 'child' => null],
        ['id' => 5, 'title' => 'Categories', 'title_ar' => 'التصنيفات', 'link' => 'admin.categories.index', 'icon' => 'ri-price-tag-2-line', 'permission' => 'categories.read', 'child' => null],
        ['id' => 6, 'title' => 'Events', 'title_ar' => 'المناسبات', 'link' => 'admin.events.index', 'icon' => 'ri-calendar-event-line', 'permission' => 'events.read', 'child' => null],
        ['id' => 7, 'title' => 'Settings', 'title_ar' => 'الاعدادات', 'link' => 'admin.settings.show', 'icon' => 'ri-settings-4-line', 'permission' => 'settings.read', 'child' => null],
        ['id' => 8, 'title' => 'Log', 'title_ar' => 'السجل', 'link' => 'admin.log.index', 'icon' => 'ri-archive-line', 'permission' => 'activities.read', 'child' => null],
    ],

];
