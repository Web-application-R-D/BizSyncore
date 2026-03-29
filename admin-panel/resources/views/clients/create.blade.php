<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Add client</h1>
            </div>
            <a href="{{ route('clients.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Back to list
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-lg shadow-slate-200/50 ring-1 ring-slate-900/5">
            <div class="border-b border-slate-100 bg-gradient-to-r from-indigo-50/80 to-white px-6 py-4">
                <h2 class="text-sm font-semibold text-slate-800">Client information</h2>
            </div>

            <form method="POST" action="{{ route('clients.store') }}" class="p-6 sm:p-8">
                @csrf

                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <x-input-label for="name">
                            Name <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full" :value="old('name')" required autofocus autocomplete="organization" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-input-label for="address" value="Address" />
                        <textarea id="address" name="address" rows="3"
                                  class="mt-1.5 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="company_name" value="Company name" />
                        <x-text-input id="company_name" name="company_name" type="text" class="mt-1.5 block w-full" :value="old('company_name')" autocomplete="organization" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="website" value="Website" />
                        <x-text-input id="website" name="website" type="text" class="mt-1.5 block w-full" :value="old('website')" />
                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email">
                            Email <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full" :value="old('email')" required autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Phone no" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1.5 block w-full" :value="old('phone')" autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="client_access_code">
                            Client access code <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="client_access_code" name="client_access_code" type="text" class="mt-1.5 block w-full font-mono text-sm" :value="old('client_access_code')" required autocomplete="off" />
                        <x-input-error :messages="$errors->get('client_access_code')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="url" value="URL" />
                        <x-text-input id="url" name="url" type="text" class="mt-1.5 block w-full" :value="old('url')" />
                        <x-input-error :messages="$errors->get('url')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('clients.index') }}"
                       class="inline-flex justify-center rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Cancel
                    </a>
                    <x-primary-button>Save client</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
