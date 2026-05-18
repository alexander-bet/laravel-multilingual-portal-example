<?php

declare(strict_types=1);

namespace Modules\Services\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Services\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'sort_order' => 1,
                'status'     => 'published',
                'translations' => [
                    'ru' => ['slug' => 'poisk-postavshchikov',          'title' => 'Поиск поставщиков',              'excerpt' => 'Находим проверенных производителей под ваш запрос: от первого контакта до подписания контракта.'],
                    'en' => ['slug' => 'supplier-sourcing',             'title' => 'Supplier Sourcing',              'excerpt' => 'We find verified manufacturers for your request: from first contact to contract signing.'],
                    'ar' => ['slug' => 'albahthu-an-almuwridin',        'title' => 'البحث عن الموردين',              'excerpt' => 'نجد لك مصنعين موثوقين لطلبك: من الاتصال الأول إلى توقيع العقد.'],
                    'fa' => ['slug' => 'jostojuye-tamin-konandegan',    'title' => 'جستجوی تامین‌کنندگان',           'excerpt' => 'تولیدکنندگان تأییدشده را برای درخواست شما پیدا می‌کنیم: از اولین تماس تا امضای قرارداد.'],
                    'tr' => ['slug' => 'tedarikci-bulma',               'title' => 'Tedarikçi Bulma',               'excerpt' => 'Talebiniz için doğrulanmış üreticileri buluyoruz: ilk temastan sözleşme imzalamaya kadar.'],
                    'pt' => ['slug' => 'busca-de-fornecedores',         'title' => 'Busca de Fornecedores',         'excerpt' => 'Encontramos fabricantes verificados para a sua solicitação: do primeiro contato à assinatura do contrato.'],
                ],
            ],
            [
                'sort_order' => 2,
                'status'     => 'published',
                'translations' => [
                    'ru' => ['slug' => 'kontrol-kachestva',             'title' => 'Контроль качества',              'excerpt' => 'Инспекция продукции на любом этапе производства. Работаем с сертифицированными инспекторами по всему Китаю.'],
                    'en' => ['slug' => 'quality-control',               'title' => 'Quality Control',               'excerpt' => 'Product inspection at any stage of production. We work with certified inspectors across China.'],
                    'ar' => ['slug' => 'muraqabat-aljawda',             'title' => 'مراقبة الجودة',                 'excerpt' => 'فحص المنتجات في أي مرحلة من مراحل الإنتاج. نعمل مع مفتشين معتمدين في جميع أنحاء الصين.'],
                    'fa' => ['slug' => 'control-keifiat',               'title' => 'کنترل کیفیت',                  'excerpt' => 'بازرسی محصول در هر مرحله از تولید. با بازرسان گواهی‌شده در سراسر چین کار می‌کنیم.'],
                    'tr' => ['slug' => 'kalite-kontrolu',               'title' => 'Kalite Kontrolü',               'excerpt' => 'Üretimin herhangi bir aşamasında ürün denetimi. Çin genelinde sertifikalı denetçilerle çalışıyoruz.'],
                    'pt' => ['slug' => 'controle-de-qualidade',         'title' => 'Controle de Qualidade',         'excerpt' => 'Inspeção de produtos em qualquer etapa da produção. Trabalhamos com inspetores certificados em toda a China.'],
                ],
            ],
            [
                'sort_order' => 3,
                'status'     => 'published',
                'translations' => [
                    'ru' => ['slug' => 'logistika-i-dostavka',          'title' => 'Логистика и доставка',           'excerpt' => 'Морские, авиа и железнодорожные перевозки из Китая. Таможенное оформление под ключ.'],
                    'en' => ['slug' => 'logistics-and-delivery',        'title' => 'Logistics & Delivery',          'excerpt' => 'Sea, air and rail freight from China. Turnkey customs clearance.'],
                    'ar' => ['slug' => 'allogistik-walttawsil',         'title' => 'اللوجستيك والتوصيل',            'excerpt' => 'الشحن البحري والجوي والسككي من الصين. التخليص الجمركي الشامل.'],
                    'fa' => ['slug' => 'logistik-va-tahvil',            'title' => 'لجستیک و تحویل',               'excerpt' => 'حمل دریایی، هوایی و ریلی از چین. ترخیص گمرکی کلید در دست.'],
                    'tr' => ['slug' => 'lojistik-ve-teslimat',          'title' => 'Lojistik ve Teslimat',          'excerpt' => 'Çin\'den deniz, hava ve demiryolu taşımacılığı. Anahtar teslim gümrükleme.'],
                    'pt' => ['slug' => 'logistica-e-entrega',           'title' => 'Logística e Entrega',           'excerpt' => 'Frete marítimo, aéreo e ferroviário da China. Desembaraço aduaneiro completo.'],
                ],
            ],
            [
                'sort_order' => 4,
                'status'     => 'published',
                'translations' => [
                    'ru' => ['slug' => 'biznes-tury-v-kitay',           'title' => 'Бизнес-туры в Китай',            'excerpt' => 'Организуем поездки на выставки и фабрики. Переводчики, трансфер, переговоры под ключ.'],
                    'en' => ['slug' => 'business-tours-to-china',       'title' => 'Business Tours to China',       'excerpt' => 'We organise trips to exhibitions and factories. Interpreters, transfers and turnkey negotiations.'],
                    'ar' => ['slug' => 'alrihilat-altijaria-ila-alsin', 'title' => 'الرحلات التجارية إلى الصين',    'excerpt' => 'ننظم رحلات إلى المعارض والمصانع. مترجمون ونقل ومفاوضات شاملة.'],
                    'fa' => ['slug' => 'tour-tojari-be-chin',           'title' => 'تورهای تجاری به چین',           'excerpt' => 'سفر به نمایشگاه‌ها و کارخانه‌ها را سازماندهی می‌کنیم. مترجم، ترانسفر و مذاکرات کلید در دست.'],
                    'tr' => ['slug' => 'cine-is-turlari',               'title' => 'Çin\'e İş Turları',             'excerpt' => 'Fuarlara ve fabrikalara geziler düzenliyoruz. Tercümanlar, transferler ve anahtar teslim müzakereler.'],
                    'pt' => ['slug' => 'tours-de-negocios-para-china',  'title' => 'Tours de Negócios para a China','excerpt' => 'Organizamos viagens a exposições e fábricas. Intérpretes, transfers e negociações completas.'],
                ],
            ],
            [
                'sort_order' => 5,
                'status'     => 'published',
                'translations' => [
                    'ru' => ['slug' => 'yuridicheskoe-soprovozhdenie',  'title' => 'Юридическое сопровождение',      'excerpt' => 'Проверка контрагентов, составление контрактов и защита интересов при спорах с китайскими партнёрами.'],
                    'en' => ['slug' => 'legal-support',                 'title' => 'Legal Support',                 'excerpt' => 'Counterparty verification, contract drafting and interest protection in disputes with Chinese partners.'],
                    'ar' => ['slug' => 'aldaaem-alqanuni',              'title' => 'الدعم القانوني',                'excerpt' => 'التحقق من الأطراف المقابلة وصياغة العقود وحماية المصالح في النزاعات مع الشركاء الصينيين.'],
                    'fa' => ['slug' => 'poshtibani-huquqi',             'title' => 'پشتیبانی حقوقی',               'excerpt' => 'تأیید طرف مقابل، تنظیم قرارداد و حمایت از منافع در اختلافات با شرکای چینی.'],
                    'tr' => ['slug' => 'hukuki-destek',                 'title' => 'Hukuki Destek',                 'excerpt' => 'Karşı taraf doğrulama, sözleşme hazırlama ve Çinli ortaklarla anlaşmazlıklarda çıkar koruma.'],
                    'pt' => ['slug' => 'suporte-juridico',              'title' => 'Suporte Jurídico',              'excerpt' => 'Verificação de contrapartes, elaboração de contratos e proteção de interesses em disputas com parceiros chineses.'],
                ],
            ],
        ];

        foreach ($services as $data) {
            $service = Service::create([
                'sort_order' => $data['sort_order'],
                'status'     => $data['status'],
            ]);

            foreach ($data['translations'] as $locale => $translation) {
                $service->translateOrNew($locale)->fill($translation)->save();
            }
        }
    }
}
