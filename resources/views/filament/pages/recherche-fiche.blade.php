<x-filament-panels::page>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- En-tête --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                <!-- Rechercher une fiche -->
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Retrouvez rapidement une fiche à partir de son numéro appelant ou de sa référence.
            </p>
        </div>

        {{-- Zone de recherche --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

            <form wire:submit="rechercher">

                <div class="p-6 sm:p-8">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:1.15rem;height:1.15rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.35 4.35a7.5 7.5 0 0012.3 12.3z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">
                                Trouver une fiche
                            </h2>
                            <p class="text-xs text-gray-500">
                                Entrez un numéro appelant ou une référence de fiche.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-3">

                        <div class="flex-1">
                            <input type="text" wire:model="recherche" placeholder="Ex. 72973985" autocomplete="on" class="w-full h-12 rounded-xl border border-gray-300 bg-gray-50 px-4 text-sm text-gray-800 shadow-sm transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/30">

                            @error('recherche')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" wire:loading.attr="disabled" wire:target="rechercher" class="h-12 px-6 rounded-xl bg-blue-600 text-sm font-semibold text-white shadow-md shadow-blue-500/25 transition hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/30 flex-shrink-0">
                            <span wire:loading.remove wire:target="rechercher">Rechercher</span>
                            <span wire:loading wire:target="rechercher">Recherche...</span>
                        </button>

                        @if($rechercheEffectuee)
                            <button type="button" wire:click="reinitialiser" class="h-12 px-5 rounded-xl border border-gray-300 bg-white text-sm font-medium text-gray-700 transition hover:bg-gray-50 flex-shrink-0">
                                Réinitialiser
                            </button>
                        @endif

                    </div>

                </div>

            </form>

        </div>

        {{-- Aucune recherche effectuée --}}
        @if(! $rechercheEffectuee)

            <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gray-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:1.75rem;height:1.75rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.35 4.35a7.5 7.5 0 0012.3 12.3z" />
                    </svg>
                </div>
                <h2 class="mt-4 text-base font-semibold text-gray-900">Recherchez une fiche</h2>
                <p class="mt-1 max-w-md mx-auto text-sm text-gray-500">
                    Aucune fiche n'est affichée pour le moment. Lancez une recherche pour afficher uniquement les fiches correspondant à votre demande.
                </p>
            </div>

        {{-- Recherche effectuée mais aucun résultat --}}
        @elseif(count($resultats) === 0)

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-12 text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-orange-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:1.5rem;height:1.5rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-orange-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h2 class="mt-4 text-base font-semibold text-gray-900">Aucune fiche trouvée</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Aucun résultat ne correspond à <span class="font-semibold text-gray-700">« {{ $recherche }} »</span>.
                </p>
                <p class="mt-2 text-xs text-gray-400">Vérifiez le numéro ou la référence saisie puis réessayez.</p>
            </div>

        {{-- Résultats --}}
        @else

            <div class="space-y-5">

                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Résultat de la recherche</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ count($resultats) }} {{ count($resultats) > 1 ? 'résultats trouvés' : 'résultat trouvé' }}
                        </p>
                    </div>

                    <div class="text-sm text-gray-500">
                        Recherche : <span class="font-semibold text-gray-800">{{ $recherche }}</span>
                    </div>
                </div>

                @foreach($resultats as $fiche)

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm transition duration-200 hover:shadow-md">

                        <div class="p-6">

                            <div class="flex items-center justify-between gap-4">

                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-8 min-w-10 items-center justify-center rounded-lg bg-gray-100 px-3 text-xs font-semibold text-gray-700">#{{ $fiche->id }}</span>

                                    @if($fiche->statut === 'Clôturé')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Clôturé
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            {{ $fiche->statut ?: 'Actif' }}
                                        </span>
                                    @endif
                                </div>

                                <!-- <a href="{{ \App\Filament\Resources\Fiches\Pages\ViewFiche::getUrl(['record' => $fiche]) }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">Voir →</a> -->

                            </div>

                            <div class="mt-6">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Objet de la fiche</p>
                                <h3 class="mt-1.5 text-lg font-semibold text-gray-900">{{ $fiche->titre ?: 'Sans titre' }}</h3>
                            </div>

                            <div class="mt-6 grid grid-cols-2 gap-5 border-t border-gray-100 pt-5 md:grid-cols-4">
                                <div>
                                    <p class="text-xs text-gray-400">Numéro appelant</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-800">{{ $fiche->numero_appelant ?: '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Service</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-800">{{ $fiche->service ?: '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Groupe de traitement</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-800">{{ $fiche->groupe_traitement ?: '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Date de création</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-800">{{ $fiche->created_at?->format('d/m/Y à H:i') ?: '—' }}</p>
                                </div>
                            </div>

                            @if($fiche->lignes_client)
                                <div class="mt-5 border-t border-gray-100 pt-5">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Lignes client</p>
                                    <p class="mt-1.5 text-sm text-gray-700 whitespace-pre-line">{{ $fiche->lignes_client }}</p>
                                </div>
                            @endif

                            @if($fiche->description)
                                <div class="mt-5 border-t border-gray-100 pt-5">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">Description</p>
                                    <p class="mt-1.5 text-sm text-gray-700 whitespace-pre-line">{{ $fiche->description }}</p>
                                </div>
                            @endif

                            @if($fiche->commentaire_solution)
                                <div class="mt-5 rounded-xl border border-emerald-100 bg-emerald-50/60 p-4">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-700">Commentaire solution</p>
                                    <p class="mt-1.5 text-sm text-emerald-900 whitespace-pre-line">{{ $fiche->commentaire_solution }}</p>
                                </div>
                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</x-filament-panels::page>
