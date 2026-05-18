// ── Country list ────────────────────────────────────────────────────────────
// Format: { iso, flag, name, dialCode }
// Most-relevant-for-platform countries first, then A–Z.
const COUNTRIES = [
    // ── Priority: CIS / China / Turkey / MENA ───────────────────────────────
    { iso: 'RU', flag: '🇷🇺', name: 'Россия / Russia',        dialCode: '+7' },
    { iso: 'CN', flag: '🇨🇳', name: '中国 / China',            dialCode: '+86' },
    { iso: 'KZ', flag: '🇰🇿', name: 'Казахстан / Kazakhstan', dialCode: '+7' },
    { iso: 'UZ', flag: '🇺🇿', name: 'Uzbekistan',             dialCode: '+998' },
    { iso: 'BY', flag: '🇧🇾', name: 'Belarus',                dialCode: '+375' },
    { iso: 'AZ', flag: '🇦🇿', name: 'Azerbaijan',             dialCode: '+994' },
    { iso: 'KG', flag: '🇰🇬', name: 'Kyrgyzstan',             dialCode: '+996' },
    { iso: 'TJ', flag: '🇹🇯', name: 'Tajikistan',             dialCode: '+992' },
    { iso: 'TM', flag: '🇹🇲', name: 'Turkmenistan',           dialCode: '+993' },
    { iso: 'AM', flag: '🇦🇲', name: 'Armenia',                dialCode: '+374' },
    { iso: 'GE', flag: '🇬🇪', name: 'Georgia',                dialCode: '+995' },
    { iso: 'MD', flag: '🇲🇩', name: 'Moldova',                dialCode: '+373' },
    { iso: 'UA', flag: '🇺🇦', name: 'Ukraine',                dialCode: '+380' },
    { iso: 'TR', flag: '🇹🇷', name: 'Turkey',                 dialCode: '+90' },
    { iso: 'IR', flag: '🇮🇷', name: 'Iran',                   dialCode: '+98' },
    { iso: 'AE', flag: '🇦🇪', name: 'UAE',                    dialCode: '+971' },
    { iso: 'SA', flag: '🇸🇦', name: 'Saudi Arabia',           dialCode: '+966' },
    { iso: 'QA', flag: '🇶🇦', name: 'Qatar',                  dialCode: '+974' },
    { iso: 'KW', flag: '🇰🇼', name: 'Kuwait',                 dialCode: '+965' },
    { iso: 'BH', flag: '🇧🇭', name: 'Bahrain',                dialCode: '+973' },
    { iso: 'OM', flag: '🇴🇲', name: 'Oman',                   dialCode: '+968' },

    // ── A–Z ─────────────────────────────────────────────────────────────────
    { iso: 'AF', flag: '🇦🇫', name: 'Afghanistan',            dialCode: '+93' },
    { iso: 'AL', flag: '🇦🇱', name: 'Albania',                dialCode: '+355' },
    { iso: 'DZ', flag: '🇩🇿', name: 'Algeria',                dialCode: '+213' },
    { iso: 'AD', flag: '🇦🇩', name: 'Andorra',                dialCode: '+376' },
    { iso: 'AO', flag: '🇦🇴', name: 'Angola',                 dialCode: '+244' },
    { iso: 'AG', flag: '🇦🇬', name: 'Antigua & Barbuda',      dialCode: '+1268' },
    { iso: 'AR', flag: '🇦🇷', name: 'Argentina',              dialCode: '+54' },
    { iso: 'AT', flag: '🇦🇹', name: 'Austria',                dialCode: '+43' },
    { iso: 'AU', flag: '🇦🇺', name: 'Australia',              dialCode: '+61' },
    { iso: 'BS', flag: '🇧🇸', name: 'Bahamas',                dialCode: '+1242' },
    { iso: 'BD', flag: '🇧🇩', name: 'Bangladesh',             dialCode: '+880' },
    { iso: 'BB', flag: '🇧🇧', name: 'Barbados',               dialCode: '+1246' },
    { iso: 'BE', flag: '🇧🇪', name: 'Belgium',                dialCode: '+32' },
    { iso: 'BZ', flag: '🇧🇿', name: 'Belize',                 dialCode: '+501' },
    { iso: 'BJ', flag: '🇧🇯', name: 'Benin',                  dialCode: '+229' },
    { iso: 'BT', flag: '🇧🇹', name: 'Bhutan',                 dialCode: '+975' },
    { iso: 'BO', flag: '🇧🇴', name: 'Bolivia',                dialCode: '+591' },
    { iso: 'BA', flag: '🇧🇦', name: 'Bosnia & Herzegovina',   dialCode: '+387' },
    { iso: 'BW', flag: '🇧🇼', name: 'Botswana',               dialCode: '+267' },
    { iso: 'BR', flag: '🇧🇷', name: 'Brazil',                 dialCode: '+55' },
    { iso: 'BN', flag: '🇧🇳', name: 'Brunei',                 dialCode: '+673' },
    { iso: 'BG', flag: '🇧🇬', name: 'Bulgaria',               dialCode: '+359' },
    { iso: 'BF', flag: '🇧🇫', name: 'Burkina Faso',           dialCode: '+226' },
    { iso: 'BI', flag: '🇧🇮', name: 'Burundi',                dialCode: '+257' },
    { iso: 'CV', flag: '🇨🇻', name: 'Cabo Verde',             dialCode: '+238' },
    { iso: 'KH', flag: '🇰🇭', name: 'Cambodia',               dialCode: '+855' },
    { iso: 'CM', flag: '🇨🇲', name: 'Cameroon',               dialCode: '+237' },
    { iso: 'CA', flag: '🇨🇦', name: 'Canada',                 dialCode: '+1' },
    { iso: 'CF', flag: '🇨🇫', name: 'Central African Rep.',   dialCode: '+236' },
    { iso: 'TD', flag: '🇹🇩', name: 'Chad',                   dialCode: '+235' },
    { iso: 'CL', flag: '🇨🇱', name: 'Chile',                  dialCode: '+56' },
    { iso: 'CO', flag: '🇨🇴', name: 'Colombia',               dialCode: '+57' },
    { iso: 'KM', flag: '🇰🇲', name: 'Comoros',                dialCode: '+269' },
    { iso: 'CG', flag: '🇨🇬', name: 'Congo',                  dialCode: '+242' },
    { iso: 'CD', flag: '🇨🇩', name: 'Congo (DRC)',            dialCode: '+243' },
    { iso: 'CR', flag: '🇨🇷', name: 'Costa Rica',             dialCode: '+506' },
    { iso: 'HR', flag: '🇭🇷', name: 'Croatia',                dialCode: '+385' },
    { iso: 'CU', flag: '🇨🇺', name: 'Cuba',                   dialCode: '+53' },
    { iso: 'CY', flag: '🇨🇾', name: 'Cyprus',                 dialCode: '+357' },
    { iso: 'CZ', flag: '🇨🇿', name: 'Czech Republic',         dialCode: '+420' },
    { iso: 'DK', flag: '🇩🇰', name: 'Denmark',                dialCode: '+45' },
    { iso: 'DJ', flag: '🇩🇯', name: 'Djibouti',               dialCode: '+253' },
    { iso: 'DO', flag: '🇩🇴', name: 'Dominican Republic',     dialCode: '+1809' },
    { iso: 'EC', flag: '🇪🇨', name: 'Ecuador',                dialCode: '+593' },
    { iso: 'EG', flag: '🇪🇬', name: 'Egypt',                  dialCode: '+20' },
    { iso: 'SV', flag: '🇸🇻', name: 'El Salvador',            dialCode: '+503' },
    { iso: 'GQ', flag: '🇬🇶', name: 'Equatorial Guinea',      dialCode: '+240' },
    { iso: 'ER', flag: '🇪🇷', name: 'Eritrea',                dialCode: '+291' },
    { iso: 'EE', flag: '🇪🇪', name: 'Estonia',                dialCode: '+372' },
    { iso: 'SZ', flag: '🇸🇿', name: 'Eswatini',               dialCode: '+268' },
    { iso: 'ET', flag: '🇪🇹', name: 'Ethiopia',               dialCode: '+251' },
    { iso: 'FJ', flag: '🇫🇯', name: 'Fiji',                   dialCode: '+679' },
    { iso: 'FI', flag: '🇫🇮', name: 'Finland',                dialCode: '+358' },
    { iso: 'FR', flag: '🇫🇷', name: 'France',                 dialCode: '+33' },
    { iso: 'GA', flag: '🇬🇦', name: 'Gabon',                  dialCode: '+241' },
    { iso: 'GM', flag: '🇬🇲', name: 'Gambia',                 dialCode: '+220' },
    { iso: 'DE', flag: '🇩🇪', name: 'Germany',                dialCode: '+49' },
    { iso: 'GH', flag: '🇬🇭', name: 'Ghana',                  dialCode: '+233' },
    { iso: 'GR', flag: '🇬🇷', name: 'Greece',                 dialCode: '+30' },
    { iso: 'GT', flag: '🇬🇹', name: 'Guatemala',              dialCode: '+502' },
    { iso: 'GN', flag: '🇬🇳', name: 'Guinea',                 dialCode: '+224' },
    { iso: 'GW', flag: '🇬🇼', name: 'Guinea-Bissau',          dialCode: '+245' },
    { iso: 'GY', flag: '🇬🇾', name: 'Guyana',                 dialCode: '+592' },
    { iso: 'HT', flag: '🇭🇹', name: 'Haiti',                  dialCode: '+509' },
    { iso: 'HN', flag: '🇭🇳', name: 'Honduras',               dialCode: '+504' },
    { iso: 'HU', flag: '🇭🇺', name: 'Hungary',                dialCode: '+36' },
    { iso: 'IS', flag: '🇮🇸', name: 'Iceland',                dialCode: '+354' },
    { iso: 'IN', flag: '🇮🇳', name: 'India',                  dialCode: '+91' },
    { iso: 'ID', flag: '🇮🇩', name: 'Indonesia',              dialCode: '+62' },
    { iso: 'IQ', flag: '🇮🇶', name: 'Iraq',                   dialCode: '+964' },
    { iso: 'IE', flag: '🇮🇪', name: 'Ireland',                dialCode: '+353' },
    { iso: 'IL', flag: '🇮🇱', name: 'Israel',                 dialCode: '+972' },
    { iso: 'IT', flag: '🇮🇹', name: 'Italy',                  dialCode: '+39' },
    { iso: 'CI', flag: '🇨🇮', name: 'Ivory Coast',            dialCode: '+225' },
    { iso: 'JM', flag: '🇯🇲', name: 'Jamaica',                dialCode: '+1876' },
    { iso: 'JP', flag: '🇯🇵', name: 'Japan',                  dialCode: '+81' },
    { iso: 'JO', flag: '🇯🇴', name: 'Jordan',                 dialCode: '+962' },
    { iso: 'KE', flag: '🇰🇪', name: 'Kenya',                  dialCode: '+254' },
    { iso: 'KI', flag: '🇰🇮', name: 'Kiribati',               dialCode: '+686' },
    { iso: 'KR', flag: '🇰🇷', name: 'Korea (South)',          dialCode: '+82' },
    { iso: 'XK', flag: '🇽🇰', name: 'Kosovo',                 dialCode: '+383' },
    { iso: 'LA', flag: '🇱🇦', name: 'Laos',                   dialCode: '+856' },
    { iso: 'LV', flag: '🇱🇻', name: 'Latvia',                 dialCode: '+371' },
    { iso: 'LB', flag: '🇱🇧', name: 'Lebanon',                dialCode: '+961' },
    { iso: 'LS', flag: '🇱🇸', name: 'Lesotho',                dialCode: '+266' },
    { iso: 'LR', flag: '🇱🇷', name: 'Liberia',                dialCode: '+231' },
    { iso: 'LY', flag: '🇱🇾', name: 'Libya',                  dialCode: '+218' },
    { iso: 'LI', flag: '🇱🇮', name: 'Liechtenstein',          dialCode: '+423' },
    { iso: 'LT', flag: '🇱🇹', name: 'Lithuania',              dialCode: '+370' },
    { iso: 'LU', flag: '🇱🇺', name: 'Luxembourg',             dialCode: '+352' },
    { iso: 'MG', flag: '🇲🇬', name: 'Madagascar',             dialCode: '+261' },
    { iso: 'MW', flag: '🇲🇼', name: 'Malawi',                 dialCode: '+265' },
    { iso: 'MY', flag: '🇲🇾', name: 'Malaysia',               dialCode: '+60' },
    { iso: 'MV', flag: '🇲🇻', name: 'Maldives',               dialCode: '+960' },
    { iso: 'ML', flag: '🇲🇱', name: 'Mali',                   dialCode: '+223' },
    { iso: 'MT', flag: '🇲🇹', name: 'Malta',                  dialCode: '+356' },
    { iso: 'MR', flag: '🇲🇷', name: 'Mauritania',             dialCode: '+222' },
    { iso: 'MU', flag: '🇲🇺', name: 'Mauritius',              dialCode: '+230' },
    { iso: 'MX', flag: '🇲🇽', name: 'Mexico',                 dialCode: '+52' },
    { iso: 'MC', flag: '🇲🇨', name: 'Monaco',                 dialCode: '+377' },
    { iso: 'MN', flag: '🇲🇳', name: 'Mongolia',               dialCode: '+976' },
    { iso: 'ME', flag: '🇲🇪', name: 'Montenegro',             dialCode: '+382' },
    { iso: 'MA', flag: '🇲🇦', name: 'Morocco',                dialCode: '+212' },
    { iso: 'MZ', flag: '🇲🇿', name: 'Mozambique',             dialCode: '+258' },
    { iso: 'MM', flag: '🇲🇲', name: 'Myanmar',                dialCode: '+95' },
    { iso: 'NA', flag: '🇳🇦', name: 'Namibia',                dialCode: '+264' },
    { iso: 'NP', flag: '🇳🇵', name: 'Nepal',                  dialCode: '+977' },
    { iso: 'NL', flag: '🇳🇱', name: 'Netherlands',            dialCode: '+31' },
    { iso: 'NZ', flag: '🇳🇿', name: 'New Zealand',            dialCode: '+64' },
    { iso: 'NI', flag: '🇳🇮', name: 'Nicaragua',              dialCode: '+505' },
    { iso: 'NE', flag: '🇳🇪', name: 'Niger',                  dialCode: '+227' },
    { iso: 'NG', flag: '🇳🇬', name: 'Nigeria',                dialCode: '+234' },
    { iso: 'MK', flag: '🇲🇰', name: 'North Macedonia',        dialCode: '+389' },
    { iso: 'NO', flag: '🇳🇴', name: 'Norway',                 dialCode: '+47' },
    { iso: 'PK', flag: '🇵🇰', name: 'Pakistan',               dialCode: '+92' },
    { iso: 'PW', flag: '🇵🇼', name: 'Palau',                  dialCode: '+680' },
    { iso: 'PA', flag: '🇵🇦', name: 'Panama',                 dialCode: '+507' },
    { iso: 'PG', flag: '🇵🇬', name: 'Papua New Guinea',       dialCode: '+675' },
    { iso: 'PY', flag: '🇵🇾', name: 'Paraguay',               dialCode: '+595' },
    { iso: 'PE', flag: '🇵🇪', name: 'Peru',                   dialCode: '+51' },
    { iso: 'PH', flag: '🇵🇭', name: 'Philippines',            dialCode: '+63' },
    { iso: 'PL', flag: '🇵🇱', name: 'Poland',                 dialCode: '+48' },
    { iso: 'PT', flag: '🇵🇹', name: 'Portugal',               dialCode: '+351' },
    { iso: 'RO', flag: '🇷🇴', name: 'Romania',                dialCode: '+40' },
    { iso: 'RW', flag: '🇷🇼', name: 'Rwanda',                 dialCode: '+250' },
    { iso: 'WS', flag: '🇼🇸', name: 'Samoa',                  dialCode: '+685' },
    { iso: 'SM', flag: '🇸🇲', name: 'San Marino',             dialCode: '+378' },
    { iso: 'ST', flag: '🇸🇹', name: 'Sao Tome & Principe',   dialCode: '+239' },
    { iso: 'SN', flag: '🇸🇳', name: 'Senegal',                dialCode: '+221' },
    { iso: 'RS', flag: '🇷🇸', name: 'Serbia',                 dialCode: '+381' },
    { iso: 'SL', flag: '🇸🇱', name: 'Sierra Leone',           dialCode: '+232' },
    { iso: 'SG', flag: '🇸🇬', name: 'Singapore',              dialCode: '+65' },
    { iso: 'SK', flag: '🇸🇰', name: 'Slovakia',               dialCode: '+421' },
    { iso: 'SI', flag: '🇸🇮', name: 'Slovenia',               dialCode: '+386' },
    { iso: 'SB', flag: '🇸🇧', name: 'Solomon Islands',        dialCode: '+677' },
    { iso: 'SO', flag: '🇸🇴', name: 'Somalia',                dialCode: '+252' },
    { iso: 'ZA', flag: '🇿🇦', name: 'South Africa',           dialCode: '+27' },
    { iso: 'SS', flag: '🇸🇸', name: 'South Sudan',            dialCode: '+211' },
    { iso: 'ES', flag: '🇪🇸', name: 'Spain',                  dialCode: '+34' },
    { iso: 'LK', flag: '🇱🇰', name: 'Sri Lanka',              dialCode: '+94' },
    { iso: 'SD', flag: '🇸🇩', name: 'Sudan',                  dialCode: '+249' },
    { iso: 'SR', flag: '🇸🇷', name: 'Suriname',               dialCode: '+597' },
    { iso: 'SE', flag: '🇸🇪', name: 'Sweden',                 dialCode: '+46' },
    { iso: 'CH', flag: '🇨🇭', name: 'Switzerland',            dialCode: '+41' },
    { iso: 'SY', flag: '🇸🇾', name: 'Syria',                  dialCode: '+963' },
    { iso: 'TW', flag: '🇹🇼', name: 'Taiwan',                 dialCode: '+886' },
    { iso: 'TZ', flag: '🇹🇿', name: 'Tanzania',               dialCode: '+255' },
    { iso: 'TH', flag: '🇹🇭', name: 'Thailand',               dialCode: '+66' },
    { iso: 'TL', flag: '🇹🇱', name: 'Timor-Leste',           dialCode: '+670' },
    { iso: 'TG', flag: '🇹🇬', name: 'Togo',                   dialCode: '+228' },
    { iso: 'TO', flag: '🇹🇴', name: 'Tonga',                  dialCode: '+676' },
    { iso: 'TT', flag: '🇹🇹', name: 'Trinidad & Tobago',     dialCode: '+1868' },
    { iso: 'TN', flag: '🇹🇳', name: 'Tunisia',                dialCode: '+216' },
    { iso: 'UG', flag: '🇺🇬', name: 'Uganda',                 dialCode: '+256' },
    { iso: 'GB', flag: '🇬🇧', name: 'United Kingdom',         dialCode: '+44' },
    { iso: 'US', flag: '🇺🇸', name: 'United States',          dialCode: '+1' },
    { iso: 'UY', flag: '🇺🇾', name: 'Uruguay',                dialCode: '+598' },
    { iso: 'VU', flag: '🇻🇺', name: 'Vanuatu',                dialCode: '+678' },
    { iso: 'VE', flag: '🇻🇪', name: 'Venezuela',              dialCode: '+58' },
    { iso: 'VN', flag: '🇻🇳', name: 'Vietnam',                dialCode: '+84' },
    { iso: 'YE', flag: '🇾🇪', name: 'Yemen',                  dialCode: '+967' },
    { iso: 'ZM', flag: '🇿🇲', name: 'Zambia',                 dialCode: '+260' },
    { iso: 'ZW', flag: '🇿🇼', name: 'Zimbabwe',               dialCode: '+263' },
];

// Locale → likely country (used as initial guess before IP detection)
const LOCALE_COUNTRY = {
    ru: 'RU',
    zh: 'CN',
    ar: 'SA',
    fa: 'IR',
    tr: 'TR',
    pt: 'BR',
    en: 'US',
};

// ── Component ────────────────────────────────────────────────────────────────
export function leadForm(options = {}) {
    return {
        // Config
        source:    options.source    ?? 'unknown',
        preselect: options.preselect ?? null,
        locale:    options.locale    ?? 'ru',

        // Popup
        open: false,

        // Form fields
        serviceId:   null,
        email:       '',
        phone:       '',
        dialCode:    '+7',
        countryFlag: '🇷🇺',
        countryIso:  'RU',

        // Phone picker UI
        pickerOpen:    false,
        countrySearch: '',

        // Form state
        loading: false,
        success: false,
        error:   false,
        errors:  {},

        // ── Computed ──────────────────────────────────────────────────────────
        get countries() {
            const q = this.countrySearch.toLowerCase();
            if (!q) return COUNTRIES;
            return COUNTRIES.filter(c =>
                c.name.toLowerCase().includes(q) ||
                c.dialCode.includes(q) ||
                c.iso.toLowerCase().includes(q)
            );
        },

        // ── Lifecycle ─────────────────────────────────────────────────────────
        init() {
            // Pre-select service if provided
            if (this.preselect) this.serviceId = this.preselect;

            // 1. Set country from locale as immediate default
            const localeIso = LOCALE_COUNTRY[this.locale];
            if (localeIso) this.setCountryByIso(localeIso);

            // 2. Browser language tag (e.g. "ru-RU", "zh-CN") → country code
            //    More reliable than external IP APIs: no CORS, no rate limits, instant.
            this.detectCountryFromBrowser();

            if (this.source === 'popup') {
                // Open event
                window.addEventListener('lead-form:open', (e) => {
                    if (e.detail?.preselect) this.serviceId = e.detail.preselect;
                    this.open = true;
                });

                // ESC key
                window.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') this.open = false;
                });

                // Scroll lock
                this.$watch('open', (value) => {
                    document.body.style.overflow = value ? 'hidden' : '';
                });
            }

            // Focus country search when picker opens
            this.$watch('pickerOpen', (open) => {
                if (open) {
                    this.$nextTick(() => {
                        this.$el.querySelector('[data-country-search]')?.focus();
                    });
                } else {
                    this.countrySearch = '';
                }
            });
        },

        // ── Methods ───────────────────────────────────────────────────────────
        setCountryByIso(iso) {
            const country = COUNTRIES.find(c => c.iso === iso);
            if (country) this.selectCountry(country);
        },

        detectCountryFromBrowser() {
            // navigator.languages returns tags like ["ru-RU", "ru", "en-US"]
            // The region subtag (after the dash) is an ISO 3166-1 country code.
            const langs = navigator.languages?.length ? navigator.languages : [navigator.language];
            for (const tag of langs) {
                const region = tag.split('-')[1];
                if (region?.length === 2) {
                    const found = COUNTRIES.find(c => c.iso === region.toUpperCase());
                    if (found) { this.selectCountry(found); return; }
                }
            }
            // Falls back to locale-based default set in init()
        },

        selectCountry(country) {
            this.dialCode    = country.dialCode;
            this.countryFlag = country.flag;
            this.countryIso  = country.iso;
            this.pickerOpen  = false;
        },

        sanitizePhone(e) {
            // Allow digits, spaces, +, -, (, ), .  — strip everything else
            const clean = e.target.value.replace(/[^\d\s()\-+.]/g, '');
            this.phone = clean;
            // Keep cursor in sync when characters are removed
            if (e.target.value !== clean) {
                e.target.value = clean;
            }
        },

        async submit() {
            this.loading = true;
            this.error   = false;
            this.errors  = {};

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            try {
                const res = await fetch('/leads', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept':       'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        service_id:         this.serviceId || null,
                        email:              this.email,
                        phone:              this.phone || null,
                        phone_country_code: this.phone ? this.dialCode : null,
                        source:             this.source,
                    }),
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    this.success   = true;
                    this.email     = '';
                    this.phone     = '';
                    this.serviceId = null;
                } else if (res.status === 422 && data.errors) {
                    this.errors = data.errors;
                } else {
                    this.error = true;
                }
            } catch {
                this.error = true;
            } finally {
                this.loading = false;
            }
        },
    };
}
