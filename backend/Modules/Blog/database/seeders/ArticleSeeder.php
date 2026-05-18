<?php

declare(strict_types=1);

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $cat1 = Category::whereTranslation('slug', 'biznes-s-kitaem')->first();
        $cat2 = Category::whereTranslation('slug', 'logistika-i-postavki')->first();
        $cat3 = Category::whereTranslation('slug', 'rynki-i-tendentsii')->first();

        $articles = [
            // Category 1 — Бизнес с Китаем (3 articles)
            [
                'status'       => 'published',
                'published_at' => now()->subDays(2),
                'category_id'  => $cat1?->id,
                'translations' => [
                    'ru' => ['slug' => 'kak-nayti-postavshchika-v-kitae',       'title' => 'Как найти надёжного поставщика в Китае',             'excerpt' => 'Пошаговое руководство по поиску, проверке и работе с китайскими производителями.'],
                    'en' => ['slug' => 'how-to-find-supplier-in-china',          'title' => 'How to Find a Reliable Supplier in China',           'excerpt' => 'A step-by-step guide to finding, vetting and working with Chinese manufacturers.'],
                    'ar' => ['slug' => 'kaif-tajid-muwrid-fi-alsin',            'title' => 'كيف تجد مورداً موثوقاً في الصين',                    'excerpt' => 'دليل خطوة بخطوة للعثور على المصنعين الصينيين والتحقق منهم والعمل معهم.'],
                    'fa' => ['slug' => 'yaftan-tamin-konande-dar-chin',         'title' => 'نحوه یافتن تامین‌کننده معتبر در چین',                 'excerpt' => 'راهنمای گام‌به‌گام برای یافتن، ارزیابی و همکاری با تولیدکنندگان چینی.'],
                    'tr' => ['slug' => 'cinde-tedarikci-nasil-bulunur',         'title' => 'Çin\'de Güvenilir Tedarikçi Nasıl Bulunur',          'excerpt' => 'Çinli üreticileri bulmak, değerlendirmek ve onlarla çalışmak için adım adım kılavuz.'],
                    'pt' => ['slug' => 'como-encontrar-fornecedor-na-china',    'title' => 'Como Encontrar um Fornecedor Confiável na China',     'excerpt' => 'Um guia passo a passo para encontrar, avaliar e trabalhar com fabricantes chineses.'],
                ],
            ],
            [
                'status'       => 'published',
                'published_at' => now()->subDays(7),
                'category_id'  => $cat1?->id,
                'translations' => [
                    'ru' => ['slug' => 'peregovory-s-kitajskimi-partnerami',     'title' => 'Переговоры с китайскими партнёрами: культурный код',  'excerpt' => 'Как понять китайскую деловую культуру и избежать типичных ошибок на переговорах.'],
                    'en' => ['slug' => 'negotiating-with-chinese-partners',      'title' => 'Negotiating with Chinese Partners: The Cultural Code','excerpt' => 'Understanding Chinese business culture and avoiding common negotiation mistakes.'],
                    'ar' => ['slug' => 'altafawud-maa-alshurakaa-alsinyeen',     'title' => 'التفاوض مع الشركاء الصينيين: الكود الثقافي',          'excerpt' => 'فهم ثقافة الأعمال الصينية وتجنب أخطاء التفاوض الشائعة.'],
                    'fa' => ['slug' => 'mozakere-ba-sharikan-chini',            'title' => 'مذاکره با شرکای چینی: کد فرهنگی',                    'excerpt' => 'درک فرهنگ تجاری چین و اجتناب از اشتباهات رایج در مذاکره.'],
                    'tr' => ['slug' => 'cin-ortaklariyla-muzakere',             'title' => 'Çinli Ortaklarla Müzakere: Kültürel Kod',            'excerpt' => 'Çin iş kültürünü anlamak ve yaygın müzakere hatalarından kaçınmak.'],
                    'pt' => ['slug' => 'negociando-com-parceiros-chineses',     'title' => 'Negociando com Parceiros Chineses: O Código Cultural', 'excerpt' => 'Compreender a cultura de negócios chinesa e evitar erros comuns de negociação.'],
                ],
            ],
            [
                'status'       => 'published',
                'published_at' => now()->subDays(14),
                'category_id'  => $cat1?->id,
                'translations' => [
                    'ru' => ['slug' => 'registratsiya-kompanii-v-kitae',         'title' => 'Регистрация компании в Китае в 2025 году',            'excerpt' => 'Актуальный порядок открытия WFOE, СП и представительства для иностранного бизнеса.'],
                    'en' => ['slug' => 'company-registration-in-china-2025',     'title' => 'Company Registration in China in 2025',              'excerpt' => 'Current procedure for opening a WFOE, JV and representative office for foreign businesses.'],
                    'ar' => ['slug' => 'tasjil-sharika-fi-alsin-2025',          'title' => 'تسجيل شركة في الصين عام 2025',                       'excerpt' => 'الإجراء الحالي لفتح شركة مملوكة بالكامل لأجانب أو شركة مشتركة أو مكتب تمثيل.'],
                    'fa' => ['slug' => 'sabt-sherkiat-dar-chin-2025',           'title' => 'ثبت شرکت در چین در سال ۲۰۲۵',                       'excerpt' => 'روش جاری برای افتتاح WFOE، JV و دفتر نمایندگی برای کسب‌وکارهای خارجی.'],
                    'tr' => ['slug' => 'cinde-sirket-kurulumu-2025',            'title' => 'Çin\'de Şirket Kuruluşu 2025',                       'excerpt' => 'Yabancı işletmeler için WFOE, JV ve temsilcilik ofisi açmanın güncel prosedürü.'],
                    'pt' => ['slug' => 'registro-de-empresa-na-china-2025',     'title' => 'Registro de Empresa na China em 2025',               'excerpt' => 'Procedimento atual para abrir uma WFOE, JV e escritório de representação para empresas estrangeiras.'],
                ],
            ],

            // Category 2 — Логистика (3 articles)
            [
                'status'       => 'published',
                'published_at' => now()->subDays(5),
                'category_id'  => $cat2?->id,
                'translations' => [
                    'ru' => ['slug' => 'morskie-perevozki-iz-kitaya',            'title' => 'Морские перевозки из Китая: полный гид',              'excerpt' => 'FCL и LCL, выбор порта, инкотермсы и типичные ошибки при морской доставке.'],
                    'en' => ['slug' => 'sea-freight-from-china-complete-guide',  'title' => 'Sea Freight from China: The Complete Guide',         'excerpt' => 'FCL vs LCL, port selection, Incoterms and common mistakes in sea shipping.'],
                    'ar' => ['slug' => 'alshahn-albahri-min-alsin-dalil-kamil', 'title' => 'الشحن البحري من الصين: الدليل الكامل',               'excerpt' => 'حاويات كاملة مقابل حاويات مشتركة، اختيار الميناء، الإنكوترمز والأخطاء الشائعة.'],
                    'fa' => ['slug' => 'barisazi-darya-az-chin-rahnama',        'title' => 'حمل‌ونقل دریایی از چین: راهنمای کامل',               'excerpt' => 'FCL در مقابل LCL، انتخاب بندر، اینکوترمز و اشتباهات رایج در حمل دریایی.'],
                    'tr' => ['slug' => 'cinden-deniz-tasimaciligi-rehberi',     'title' => 'Çin\'den Deniz Taşımacılığı: Eksiksiz Rehber',       'excerpt' => 'FCL ve LCL, liman seçimi, Incoterms ve deniz nakliyesindeki yaygın hatalar.'],
                    'pt' => ['slug' => 'frete-maritimo-da-china-guia-completo', 'title' => 'Frete Marítimo da China: Guia Completo',             'excerpt' => 'FCL vs LCL, seleção de porto, Incoterms e erros comuns no transporte marítimo.'],
                ],
            ],
            [
                'status'       => 'published',
                'published_at' => now()->subDays(10),
                'category_id'  => $cat2?->id,
                'translations' => [
                    'ru' => ['slug' => 'tamozhennoe-oformlenie-tovara-iz-kitaya', 'title' => 'Таможенное оформление товаров из Китая',             'excerpt' => 'Документы, коды ТН ВЭД, пошлины и НДС при импорте товаров из КНР.'],
                    'en' => ['slug' => 'customs-clearance-goods-from-china',      'title' => 'Customs Clearance for Goods from China',            'excerpt' => 'Documents, HS codes, duties and VAT when importing goods from China.'],
                    'ar' => ['slug' => 'altakhlis-aljumruki-lilbadaril-siniya',  'title' => 'التخليص الجمركي للبضائع الصينية',                    'excerpt' => 'المستندات ورموز النظام المنسق والرسوم الجمركية وضريبة القيمة المضافة عند استيراد البضائع من الصين.'],
                    'fa' => ['slug' => 'trakhlis-gomroki-kala-az-chin',         'title' => 'ترخیص گمرکی کالا از چین',                           'excerpt' => 'اسناد، کدهای HS، عوارض و مالیات بر ارزش افزوده هنگام واردات کالا از چین.'],
                    'tr' => ['slug' => 'cinden-mal-gumruk-islemleri',           'title' => 'Çin\'den Gelen Malların Gümrük İşlemleri',           'excerpt' => 'Çin\'den mal ithal ederken belgeler, HS kodları, gümrük vergileri ve KDV.'],
                    'pt' => ['slug' => 'despacho-aduaneiro-mercadorias-china',   'title' => 'Despacho Aduaneiro de Mercadorias da China',         'excerpt' => 'Documentos, códigos HS, direitos e IVA ao importar mercadorias da China.'],
                ],
            ],
            [
                'status'       => 'published',
                'published_at' => now()->subDays(18),
                'category_id'  => $cat2?->id,
                'translations' => [
                    'ru' => ['slug' => 'kontrol-kachestva-na-fabrike-v-kitae',   'title' => 'Контроль качества на фабрике в Китае',               'excerpt' => 'Как организовать инспекцию продукции: pre-production, during-production и final QC.'],
                    'en' => ['slug' => 'quality-control-at-china-factory',       'title' => 'Quality Control at a Factory in China',             'excerpt' => 'How to organise product inspection: pre-production, during-production and final QC.'],
                    'ar' => ['slug' => 'muraqabat-aljawda-fi-masnaaf-alsin',    'title' => 'مراقبة الجودة في مصنع صيني',                         'excerpt' => 'كيفية تنظيم فحص المنتجات: ما قبل الإنتاج وأثناءه والجودة النهائية.'],
                    'fa' => ['slug' => 'control-keifiat-dar-karkhaneh-chin',    'title' => 'کنترل کیفیت در کارخانه چین',                        'excerpt' => 'نحوه سازماندهی بازرسی محصول: قبل از تولید، حین تولید و QC نهایی.'],
                    'tr' => ['slug' => 'cin-fabrikasinda-kalite-kontrolu',      'title' => 'Çin Fabrikasında Kalite Kontrolü',                   'excerpt' => 'Ürün denetimini nasıl düzenlersiniz: üretim öncesi, üretim sırası ve nihai KK.'],
                    'pt' => ['slug' => 'controle-qualidade-fabrica-china',      'title' => 'Controle de Qualidade em Fábrica na China',          'excerpt' => 'Como organizar a inspeção de produtos: pré-produção, durante a produção e QC final.'],
                ],
            ],

            // Category 3 — Рынки и тренды (3 articles)
            [
                'status'       => 'published',
                'published_at' => now()->subDays(3),
                'category_id'  => $cat3?->id,
                'translations' => [
                    'ru' => ['slug' => 'top-10-rynkov-odezhdy-guangzhou-2026',   'title' => 'Топ 10 рынков одежды в Гуанчжоу 2026',               'excerpt' => 'Обзор крупнейших оптовых рынков одежды Гуанчжоу с адресами и специализацией.'],
                    'en' => ['slug' => 'top-10-clothing-markets-guangzhou-2026', 'title' => 'Top 10 Clothing Markets in Guangzhou 2026',          'excerpt' => 'Overview of Guangzhou\'s largest wholesale clothing markets with addresses and specialisations.'],
                    'ar' => ['slug' => 'afadal-10-aswaaq-malabis-guangzhou',    'title' => 'أفضل 10 أسواق ملابس في غوانغتشو 2026',               'excerpt' => 'نظرة عامة على أكبر أسواق الملابس بالجملة في غوانغتشو مع العناوين والتخصصات.'],
                    'fa' => ['slug' => '10-bazar-lebas-guangzhou-2026',         'title' => '۱۰ بازار برتر پوشاک در گوانگجو ۲۰۲۶',               'excerpt' => 'مرور بزرگترین بازارهای عمده‌فروشی پوشاک گوانگجو با آدرس‌ها و تخصص‌ها.'],
                    'tr' => ['slug' => 'guangzhou-giyim-pazarlari-top-10-2026', 'title' => 'Guangzhou\'da En İyi 10 Giyim Pazarı 2026',          'excerpt' => 'Guangzhou\'nun en büyük toptan giyim pazarlarına genel bakış, adresler ve uzmanlıklar.'],
                    'pt' => ['slug' => 'top-10-mercados-roupas-guangzhou-2026', 'title' => 'Top 10 Mercados de Roupas em Guangzhou 2026',         'excerpt' => 'Visão geral dos maiores mercados atacadistas de roupas de Guangzhou com endereços e especializações.'],
                ],
            ],
            [
                'status'       => 'published',
                'published_at' => now()->subDays(9),
                'category_id'  => $cat3?->id,
                'translations' => [
                    'ru' => ['slug' => 'zapchasti-iz-kitaya-dlya-oborudovaniya', 'title' => 'Запчасти из Китая для промышленного оборудования',    'excerpt' => 'Как создать надёжный канал поставок промышленных запчастей напрямую с заводов КНР.'],
                    'en' => ['slug' => 'spare-parts-from-china-industrial',      'title' => 'Spare Parts from China for Industrial Equipment',    'excerpt' => 'How to build a reliable supply channel for industrial spare parts directly from Chinese factories.'],
                    'ar' => ['slug' => 'qitaa-ghiyar-siniya-lilmuaddaat',       'title' => 'قطع غيار صينية للمعدات الصناعية',                    'excerpt' => 'كيفية بناء قناة توريد موثوقة لقطع الغيار الصناعية مباشرة من المصانع الصينية.'],
                    'fa' => ['slug' => 'ghiaat-yadar-chin-baraye-sanat',        'title' => 'قطعات یدکی از چین برای تجهیزات صنعتی',              'excerpt' => 'نحوه ایجاد کانال تأمین قابل اعتماد برای قطعات یدکی صنعتی مستقیم از کارخانه‌های چینی.'],
                    'tr' => ['slug' => 'cinden-endustri-ekipmani-yedek-parca',  'title' => 'Çin\'den Endüstriyel Ekipman Yedek Parçaları',       'excerpt' => 'Çin fabrikalarından doğrudan endüstriyel yedek parça için güvenilir tedarik kanalı nasıl kurulur.'],
                    'pt' => ['slug' => 'pecas-reposicao-china-equipamentos',    'title' => 'Peças de Reposição da China para Equipamentos',       'excerpt' => 'Como construir um canal de fornecimento confiável para peças industriais diretamente de fábricas chinesas.'],
                ],
            ],
            [
                'status'       => 'published',
                'published_at' => now()->subDays(21),
                'category_id'  => $cat3?->id,
                'translations' => [
                    'ru' => ['slug' => 'medtekhnika-iz-kitaya-tendentsii-2026',  'title' => 'Медтехника из Китая: тренды 2026',                   'excerpt' => 'Телемедицина, диагностика и лабораторное оборудование — что экспортирует Китай в 2026 году.'],
                    'en' => ['slug' => 'medical-devices-china-trends-2026',      'title' => 'Medical Devices from China: 2026 Trends',            'excerpt' => 'Telemedicine, diagnostics and lab equipment — what China is exporting in 2026.'],
                    'ar' => ['slug' => 'ajhizat-tibia-siniya-ittijahat-2026',   'title' => 'الأجهزة الطبية الصينية: اتجاهات 2026',               'excerpt' => 'الطب عن بُعد والتشخيص ومعدات المختبرات — ماذا تصدر الصين في 2026.'],
                    'fa' => ['slug' => 'tajhizat-pezeshki-chin-2026',           'title' => 'تجهیزات پزشکی از چین: روندهای ۲۰۲۶',                'excerpt' => 'پزشکی از راه دور، تشخیص و تجهیزات آزمایشگاهی — چین در ۲۰۲۶ چه صادر می‌کند.'],
                    'tr' => ['slug' => 'cinli-tibbi-cihazlar-trendler-2026',    'title' => 'Çin\'den Tıbbi Cihazlar: 2026 Trendleri',            'excerpt' => 'Teleıp, teşhis ve laboratuvar ekipmanları — Çin 2026\'da ne ihraç ediyor.'],
                    'pt' => ['slug' => 'dispositivos-medicos-china-2026',       'title' => 'Dispositivos Médicos da China: Tendências 2026',      'excerpt' => 'Telemedicina, diagnóstico e equipamentos de laboratório — o que a China exporta em 2026.'],
                ],
            ],
        ];

        foreach ($articles as $data) {
            $article = Article::create([
                'category_id'  => $data['category_id'],
                'status'       => $data['status'],
                'published_at' => $data['published_at'],
            ]);

            foreach ($data['translations'] as $locale => $translation) {
                $article->translateOrNew($locale)->fill($translation)->save();
            }
        }
    }
}
