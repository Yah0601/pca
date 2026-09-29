<x-filament-panels::page>

    <div class="space-y-6">

        {{-- ============================
             EN-TÊTE DE BIENVENUE
        ============================= --}}
        <div class="flex items-center justify-between p-6 bg-white rounded-xl shadow-sm border border-gray-100">

            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Bonjour, {{ auth()->user()->prenom ?? 'Utilisateur' }} 👋
                </h1>

                <p class="text-gray-500 text-sm mt-1">
                    Bienvenue sur l'application de secours du CRM.
                    Que souhaitez-vous faire aujourd'hui ?
                </p>
            </div>

            <!-- <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Système opérationnel
            </span> -->

        </div>


        {{-- ============================
             GRILLE DES ACTIONS
        ============================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


            {{-- ============================
                 AJOUTER UNE FICHE
            ============================= --}}
            <a
                href="{{ \App\Filament\Resources\Fiches\Pages\CreateFiche::getUrl() }}"
                class="block p-6 bg-amber-50/50 hover:bg-amber-50 border border-amber-200/60 rounded-2xl transition duration-200 shadow-sm hover:shadow"
            >

                <div class="w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold mb-4">
                    +
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                    Ajouter une fiche
                </h3>

                <p class="text-sm text-gray-600 mb-6">
                    Enregistrer une nouvelle demande ou un nouveau cas.
                </p>

                <span class="inline-flex items-center text-sm font-semibold text-amber-600">
                    Commencer →
                </span>

            </a>


            {{-- ============================
                 RECHERCHER UNE FICHE
            ============================= --}}
            <a
                href="{{ \App\Filament\Resources\Fiches\Pages\RechercheFiche::getUrl() }}"
                class="block p-6 bg-blue-50/50 hover:bg-blue-50 border border-blue-200/60 rounded-2xl transition duration-200 shadow-sm hover:shadow"
            >

                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold mb-4">
                    🔍
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                    Rechercher une fiche
                </h3>

                <p class="text-sm text-gray-600 mb-6">
                    Consulter une fiche existante.
                </p>

                <span class="inline-flex items-center text-sm font-semibold text-blue-600">
                    Accéder →
                </span>

            </a>


            {{-- ============================
                 CC : MES FICHES
            ============================= --}}
            @if(auth()->user()->role === 'CC')

                <a
                    href="{{ \App\Filament\Resources\Fiches\Pages\ListFiches::getUrl() }}"
                    class="block p-6 bg-emerald-50/50 hover:bg-emerald-50 border border-emerald-200/60 rounded-2xl transition duration-200 shadow-sm hover:shadow"
                >

                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold mb-4">
                        ✓
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                        Mes fiches
                    </h3>

                    <p class="text-sm text-gray-600 mb-6">
                        Voir les fiches créées par moi.
                    </p>

                    <span class="inline-flex items-center text-sm font-semibold text-emerald-600">
                        Accéder →
                    </span>

                </a>

            @else

                {{-- ============================
                     ADMIN : EXPORTER
                ============================= --}}
                <a
                    href="{{ \App\Filament\Resources\Fiches\Pages\ExportFiches::getUrl() }}"
                    class="block p-6 bg-emerald-50/50 hover:bg-emerald-50 border border-emerald-200/60 rounded-2xl transition duration-200 shadow-sm hover:shadow"
                >

                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold mb-4">
                        📊
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                        Exporter les fiches
                    </h3>

                    <p class="text-sm text-gray-600 mb-6">
                        Télécharger les données selon vos critères de recherche.
                    </p>

                    <span class="inline-flex items-center text-sm font-semibold text-emerald-600">
                        Exporter →
                    </span>

                </a>

            @endif

        </div>

    </div>

</x-filament-panels::page>
