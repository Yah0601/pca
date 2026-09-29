<x-filament-panels::page>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Formulaire --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

            <div class="p-6 sm:p-8">

                <div class="flex items-center gap-3 mb-8">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:1.375rem;height:1.375rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-emerald-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 12m0 0l4.5-4.5M12 12V3" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">
                            Critères d'export
                        </h2>
                        <p class="text-xs text-gray-500">
                            Laissez un critère sur « Tous » pour ne pas le filtrer.
                        </p>
                    </div>
                </div>

                {{-- Filtres --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-8">

                    {{-- Statut --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Statut
                        </label>
                        <select
                            wire:model="statut"
                            style="height: 44px;"
                            class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 text-sm text-gray-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/30"
                        >
                            <option value="">Tous</option>
                            <option value="Actif">Actif</option>
                            <option value="Clôturé">Clôturé</option>
                        </select>
                    </div>

                    {{-- Service --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Service
                        </label>
                        <select
                            wire:model="service"
                            style="height: 44px;"
                            class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 text-sm text-gray-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/30"
                        >
                            <option value="">Tous</option>
                            <option value="7400">7400</option>
                            <option value="37070">37070</option>
                            <option value="7414">7414</option>
                            <option value="37171">37171</option>
                        </select>
                    </div>

                    {{-- Groupe --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Groupe de traitement
                        </label>
                        <select
                            wire:model="groupe"
                            style="height: 44px;"
                            class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 text-sm text-gray-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/30"
                        >
                            <option value="">Tous</option>
                            <option value="BO TCC">BO TCC</option>
                            <option value="PlateauTCC">PlateauTCC</option>
                        </select>
                    </div>

                    {{-- Date début --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Date de début
                        </label>
                        <input
                            type="date"
                            wire:model="dateDebut"
                            style="height: 44px;"
                            class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 text-sm text-gray-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/30"
                        >
                    </div>

                    {{-- Date fin --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Date de fin
                        </label>
                        <input
                            type="date"
                            wire:model="dateFin"
                            style="height: 44px;"
                            class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 text-sm text-gray-800 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/30"
                        >
                    </div>

                </div>

                {{-- Séparateur + bouton --}}
                <div class="border-t border-gray-100 mt-9 pt-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

                        <div>
                            <p class="text-sm font-medium text-gray-800">
                                Export au format CSV
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Le fichier peut être ouvert directement avec Excel.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="exporter"
                            wire:loading.attr="disabled"
                            wire:target="exporter"
                            class="inline-flex flex-shrink-0 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 text-sm font-semibold text-white shadow-md shadow-emerald-500/25 transition hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-500/30 disabled:cursor-not-allowed disabled:opacity-70"
                            style="height: 46px; min-width: 200px;"
                        >
                            <span wire:loading.remove wire:target="exporter" class="inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:1.1rem;height:1.1rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 12m0 0l4.5-4.5M12 12V3" />
                                </svg>
                                Exporter les fiches
                            </span>

                            <span wire:loading wire:target="exporter" class="inline-flex items-center gap-2">
                                <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Préparation de l'export...
                            </span>
                        </button>

                    </div>
                </div>

            </div>

        </div>

        {{-- Information --}}
        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
            <div class="flex gap-3">
                <div class="flex-shrink-0 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:1.25rem;height:1.25rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900">
                        À propos de l'export
                    </p>
                    <p class="mt-1 text-sm text-blue-700">
                        Seules les fiches correspondant aux critères sélectionnés seront incluses dans le fichier.
                    </p>
                </div>
            </div>
        </div>

    </div>

</x-filament-panels::page>
