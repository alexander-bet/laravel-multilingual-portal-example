<?php

declare(strict_types=1);

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'sort_order' => 1,
                'translations' => [
                    'ru' => ['slug' => 'biznes-s-kitaem',     'name' => 'Бизнес с Китаем',        'description' => 'Практические советы и стратегии для ведения бизнеса с китайскими партнёрами.'],
                    'en' => ['slug' => 'business-with-china', 'name' => 'Business with China',     'description' => 'Practical advice and strategies for doing business with Chinese partners.'],
                    'ar' => ['slug' => 'amal-maa-alsin',      'name' => 'الأعمال مع الصين',        'description' => 'نصائح واستراتيجيات عملية للقيام بالأعمال التجارية مع الشركاء الصينيين.'],
                    'fa' => ['slug' => 'karobar-ba-chin',     'name' => 'کسب‌وکار با چین',         'description' => 'توصیه‌های عملی و استراتژی‌هایی برای انجام تجارت با شرکای چینی.'],
                    'tr' => ['slug' => 'cin-ile-is',          'name' => 'Çin ile İş',              'description' => 'Çinli ortaklarla iş yapmak için pratik tavsiyeler ve stratejiler.'],
                    'pt' => ['slug' => 'negocios-com-china',  'name' => 'Negócios com a China',    'description' => 'Conselhos práticos e estratégias para fazer negócios com parceiros chineses.'],
                ],
            ],
            [
                'sort_order' => 2,
                'translations' => [
                    'ru' => ['slug' => 'logistika-i-postavki',    'name' => 'Логистика и поставки',   'description' => 'Всё о доставке товаров из Китая: таможня, перевозчики, сроки.'],
                    'en' => ['slug' => 'logistics-and-supply',    'name' => 'Logistics & Supply',     'description' => 'Everything about shipping goods from China: customs, carriers, timelines.'],
                    'ar' => ['slug' => 'allogistik-waltadarat',   'name' => 'اللوجستيك والتوريد',     'description' => 'كل شيء عن شحن البضائع من الصين: الجمارك والناقلين والجداول الزمنية.'],
                    'fa' => ['slug' => 'logistik-va-tamin',       'name' => 'لجستیک و تأمین',         'description' => 'همه چیز درباره ارسال کالا از چین: گمرک، حمل‌ونقل، زمان‌بندی.'],
                    'tr' => ['slug' => 'lojistik-ve-tedarik',     'name' => 'Lojistik ve Tedarik',    'description' => 'Çin\'den mal nakliyesi hakkında her şey: gümrük, taşıyıcılar, zaman çizelgeleri.'],
                    'pt' => ['slug' => 'logistica-e-fornecimento','name' => 'Logística e Fornecimento','description' => 'Tudo sobre o envio de mercadorias da China: alfândega, transportadoras, prazos.'],
                ],
            ],
            [
                'sort_order' => 3,
                'translations' => [
                    'ru' => ['slug' => 'rynki-i-tendentsii',  'name' => 'Рынки и тренды',          'description' => 'Аналитика китайского рынка, новые ниши и перспективные отрасли.'],
                    'en' => ['slug' => 'markets-and-trends',  'name' => 'Markets & Trends',        'description' => 'Chinese market analytics, new niches and promising industries.'],
                    'ar' => ['slug' => 'alaswaaq-waltawijhat', 'name' => 'الأسواق والاتجاهات',      'description' => 'تحليلات السوق الصيني والمجالات الجديدة والصناعات الواعدة.'],
                    'fa' => ['slug' => 'bazarha-va-roandha',  'name' => 'بازارها و روندها',         'description' => 'تحلیل بازار چین، جایگاه‌های جدید و صنایع امیدوارکننده.'],
                    'tr' => ['slug' => 'pazarlar-ve-trendler','name' => 'Pazarlar ve Trendler',    'description' => 'Çin pazar analizleri, yeni nişler ve umut vaat eden endüstriler.'],
                    'pt' => ['slug' => 'mercados-e-tendencias','name' => 'Mercados e Tendências',  'description' => 'Análises do mercado chinês, novos nichos e indústrias promissoras.'],
                ],
            ],
        ];

        foreach ($categories as $data) {
            $category = Category::create(['sort_order' => $data['sort_order']]);

            foreach ($data['translations'] as $locale => $translation) {
                $category->translateOrNew($locale)->fill($translation)->save();
            }
        }
    }
}
