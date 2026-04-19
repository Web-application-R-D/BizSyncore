<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <p class="text-sm text-slate-400">Clients <span class="px-2 text-amber-400">/</span> Edit client</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-100">Edit {{ $client->name }}</h1>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('clients.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-slate-600 bg-slate-800/60 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-slate-500 hover:bg-slate-700/70">
                    Cancel
                </a>
                <button type="submit" form="client-form"
                        class="inline-flex items-center justify-center rounded-lg bg-amber-400 px-5 py-2 text-sm font-semibold text-slate-950 transition hover:bg-amber-300">
                    Save changes
                </button>
            </div>
        </div>
    </x-slot>

    <form id="client-form" method="POST" action="{{ route('clients.update', $client) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="grid gap-6 xl:grid-cols-12">
            <div class="space-y-6 xl:col-span-7">
                <section class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 sm:p-6">
                    <h2 class="text-sm font-semibold text-amber-400">Business information</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="name" value="Client name *" />
                            <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full" :value="old('name', $client->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="company_name" value="Company name *" />
                            <x-text-input id="company_name" name="company_name" type="text" class="mt-1.5 block w-full" :value="old('company_name', $client->company_name)" required />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="business_type" value="Business type" />
                            <select id="business_type" name="business_type" class="mt-1.5 block w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-sm text-slate-100 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/25">
                                <option value="">Select type</option>
                                @foreach (['Pharmacy', 'Retail', 'Hospitality', 'Food & Beverage', 'Fashion', 'Other'] as $type)
                                    <option value="{{ $type }}" @selected(old('business_type', $client->business_type) === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('business_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="country" value="Country" />
                            <select id="country" name="country" class="mt-1.5 block w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-sm text-slate-100 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/25">
                                <option value="">Select country</option>
                                @foreach (['Sri Lanka', 'India', 'Bangladesh', 'Pakistan'] as $country)
                                    <option value="{{ $country }}" @selected(old('country', $client->country) === $country)>{{ $country }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Contact email *" />
                            <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full" :value="old('email', $client->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" value="Contact phone" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1.5 block w-full" :value="old('phone', $client->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="address" value="Business address" />
                            <textarea id="address" name="address" rows="3" class="mt-1.5 block w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400/25">{{ old('address', $client->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 sm:p-6">
                    <h2 class="text-sm font-semibold text-amber-400">Subscription plan</h2>
                    <div class="mt-4 grid gap-3 md:grid-cols-3">
                        @php($selectedPlan = old('plan', $client->plan ?: 'medium'))
                        @foreach ([
                            'small' => ['label' => 'Small', 'price' => 'LKR 1,800/mo', 'meta' => '5 users · 2 terminals'],
                            'medium' => ['label' => 'Medium', 'price' => 'LKR 4,800/mo', 'meta' => '10 users · 5 terminals'],
                            'large' => ['label' => 'Large', 'price' => 'LKR 12,500/mo', 'meta' => '50 users · Unlimited'],
                        ] as $key => $plan)
                            <label class="cursor-pointer rounded-xl border p-4 transition {{ $selectedPlan === $key ? 'border-amber-400 bg-slate-800/60' : 'border-slate-700 bg-slate-900/40 hover:border-slate-600' }}">
                                <input type="radio" name="plan" value="{{ $key }}" class="sr-only" {{ $selectedPlan === $key ? 'checked' : '' }}>
                                <p class="text-base font-semibold text-slate-100">{{ $plan['label'] }}</p>
                                <p class="mt-1 text-lg font-semibold text-amber-400">{{ $plan['price'] }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $plan['meta'] }}</p>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('plan')" class="mt-2" />
                </section>

                <section class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 sm:p-6">
                    <h2 class="text-sm font-semibold text-amber-400">API configuration</h2>
                    <div class="mt-4 space-y-3">
                        <div>
                            <x-input-label for="pos_api_base_url" value="POS API base URL" />
                            <x-text-input id="pos_api_base_url" name="pos_api_base_url" type="text" class="mt-1.5 block w-full font-mono text-sm" :value="old('pos_api_base_url', $client->pos_api_base_url ?: 'https://api.bizsyncore.com')" />
                            <x-input-error :messages="$errors->get('pos_api_base_url')" class="mt-2" />
                        </div>
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 px-3 py-2 text-xs text-emerald-400">
                            GET /api/v1/client/resolve?code=<span id="preview-code">{{ old('client_access_code', $client->client_access_code) }}</span><br>
                            <span class="text-slate-400">returns apiBaseUrl, branding, planFeatures</span>
                        </div>
                    </div>
                </section>
            </div>

            <div class="space-y-6 xl:col-span-5">
                <section class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 sm:p-6">
                    <h2 class="text-sm font-semibold text-amber-400">Access code</h2>
                    <div class="mt-4 space-y-4">
                        <div>
                            <div class="flex items-center justify-between gap-3">
                                <x-input-label for="client_access_code" value="Auto-generated access code" />
                                <button id="regenerate-code" type="button" class="rounded-md border border-slate-600 bg-slate-800 px-2.5 py-1 text-xs font-semibold text-amber-400 hover:border-slate-500">Regenerate</button>
                            </div>
                            <x-text-input id="client_access_code" name="client_access_code" type="text" class="mt-1.5 block w-full font-mono text-base tracking-widest text-amber-400" :value="old('client_access_code', $client->client_access_code)" required readonly />
                            <x-input-error :messages="$errors->get('client_access_code')" class="mt-2" />
                        </div>

                        <label class="flex items-center gap-2 text-sm text-slate-300">
                            <input id="custom-code-toggle" type="checkbox" class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-amber-400 focus:ring-amber-400/30" {{ old('client_access_code', $client->client_access_code) !== $client->client_access_code ? 'checked' : '' }}>
                            Customize access code manually
                        </label>

                        <div>
                            <x-input-label for="code_format" value="Code format" />
                            <div class="mt-1.5 rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-sm text-slate-300">BS-[CLIENT]-[YEAR]</div>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 sm:p-6">
                    <h2 class="text-sm font-semibold text-amber-400">Branding</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <x-input-label for="display_name" value="Display name (shown on POS login)" />
                            <x-text-input id="display_name" name="display_name" type="text" class="mt-1.5 block w-full" :value="old('display_name', $client->display_name)" />
                            <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="primary_color" value="Primary color" />
                            <input id="primary_color" name="primary_color" type="color" class="mt-1.5 h-11 w-full cursor-pointer rounded-lg border border-slate-700 bg-slate-950 p-1" value="{{ old('primary_color', $client->primary_color ?: '#1E2A5E') }}" />
                            <x-input-error :messages="$errors->get('primary_color')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="accent_color" value="Accent color" />
                            <input id="accent_color" name="accent_color" type="color" class="mt-1.5 h-11 w-full cursor-pointer rounded-lg border border-slate-700 bg-slate-950 p-1" value="{{ old('accent_color', $client->accent_color ?: '#F5A623') }}" />
                            <x-input-error :messages="$errors->get('accent_color')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="logo_url" value="Logo URL" />
                            <x-text-input id="logo_url" name="logo_url" type="text" class="mt-1.5 block w-full" :value="old('logo_url', $client->logo_url)" placeholder="https://" />
                            <x-input-error :messages="$errors->get('logo_url')" class="mt-2" />
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 sm:p-6">
                    <h2 class="text-sm font-semibold text-amber-400">Feature flags</h2>
                    <div class="mt-4 space-y-4">
                        <input type="hidden" name="feature_flags[advanced_reporting]" value="0">
                        <label class="flex items-center justify-between gap-3">
                            <span class="text-sm text-slate-300">Advanced reporting</span>
                            <input type="checkbox" name="feature_flags[advanced_reporting]" value="1" class="peer sr-only" {{ old('feature_flags.advanced_reporting', data_get($client->feature_flags, 'advanced_reporting', false)) ? 'checked' : '' }}>
                            <span class="h-6 w-11 rounded-full bg-slate-700 transition peer-checked:bg-amber-400"></span>
                        </label>

                        <input type="hidden" name="feature_flags[multi_outlet_support]" value="0">
                        <label class="flex items-center justify-between gap-3">
                            <span class="text-sm text-slate-300">Multi-outlet support</span>
                            <input type="checkbox" name="feature_flags[multi_outlet_support]" value="1" class="peer sr-only" {{ old('feature_flags.multi_outlet_support', data_get($client->feature_flags, 'multi_outlet_support', false)) ? 'checked' : '' }}>
                            <span class="h-6 w-11 rounded-full bg-slate-700 transition peer-checked:bg-amber-400"></span>
                        </label>

                        <input type="hidden" name="feature_flags[api_access]" value="0">
                        <label class="flex items-center justify-between gap-3">
                            <span class="text-sm text-slate-300">API access (webhooks)</span>
                            <input type="checkbox" name="feature_flags[api_access]" value="1" class="peer sr-only" {{ old('feature_flags.api_access', data_get($client->feature_flags, 'api_access', false)) ? 'checked' : '' }}>
                            <span class="h-6 w-11 rounded-full bg-slate-700 transition peer-checked:bg-amber-400"></span>
                        </label>
                    </div>
                </section>
            </div>
        </div>
    </form>

    <script>
        (() => {
            const nameInput = document.getElementById('name');
            const codeInput = document.getElementById('client_access_code');
            const previewCode = document.getElementById('preview-code');
            const regenButton = document.getElementById('regenerate-code');
            const customToggle = document.getElementById('custom-code-toggle');

            const toSegment = (value) => {
                const clean = (value || '').toUpperCase().replace(/[^A-Z0-9]/g, '');
                return (clean.slice(0, 5) || 'NEWXX').padEnd(5, 'X');
            };

            const generateCode = () => {
                const year = new Date().getFullYear();
                const code = `BS-${toSegment(nameInput.value)}-${year}`;
                codeInput.value = code;
                previewCode.textContent = code;
            };

            const syncReadOnlyState = () => {
                const customMode = customToggle.checked;
                codeInput.readOnly = !customMode;
                if (!customMode) {
                    generateCode();
                }
            };

            regenButton.addEventListener('click', generateCode);
            nameInput.addEventListener('input', () => {
                if (codeInput.readOnly) {
                    generateCode();
                }
            });
            customToggle.addEventListener('change', syncReadOnlyState);
            codeInput.addEventListener('input', () => {
                previewCode.textContent = codeInput.value || 'BS-NEWXX-2026';
            });

            previewCode.textContent = codeInput.value || 'BS-NEWXX-2026';
            syncReadOnlyState();
        })();
    </script>
</x-admin-layout>
