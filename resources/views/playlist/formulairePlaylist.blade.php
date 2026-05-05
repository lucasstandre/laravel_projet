<x-app-layout>
    <div class="py-12 bg-[#000d1a] min-h-screen text-white">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#001a33] rounded-[2.5rem] p-10 border border-white/5 shadow-2xl">

                <h2 class="text-3xl font-bold italic tracking-tight mb-8 border-b border-white/10 pb-4">
                    {{ __('Éditer la playlist') }}
                </h2>

                <form method="post" action="{{ route('enregistrementPlaylist') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="id_playlist" value="{{ $playlist->id_playlist }}">

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2" for="playlist">
                            Nom de la playlist
                        </label>
                        <input class="w-full bg-black/30 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-yellow-500 focus:ring-0 transition-all"
                               id="playlist" name="playlist" type="text" value="{{ $playlist->playlist }}">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2" for="description">
                            Description
                        </label>
                        <textarea class="w-full bg-black/30 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-yellow-500 focus:ring-0 transition-all"
                                  id="description" name="description" rows="4">{{ $playlist->description }}</textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button id="soumettre_playlist"
                        class="flex-1 bg-yellow-500 hover:bg-yellow-400 text-black font-black uppercase tracking-widest py-4 rounded-2xl transition-all shadow-lg shadow-yellow-500/20"
                                type="button">
                            Enregistrer les modifications
                        </button>
                        <a href="{{ url()->previous() }}" class="px-8 py-4 text-gray-400 font-bold hover:text-white transition-all text-sm">
                            Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
{{-- regex pas dans app.js pcq ca marchait pas--}}
    <script>
/****************************************************************************/
/* Une expression régulière peut être définie sous la forme d'une constante */
/* (car elle ne devrait pas changer durant l'exécution du script). En JS,   */
/* une expression régulière est entourée de barres obliques (/).            */
/****************************************************************************/
const REGEX_PLAYLIST = /^[\p{L}\p{N}\s\-']{3,50}$/u;
// lettre + nombre + espace, au moins 3 char max 50
window.onload = () => {
    const btnSoumettre = document.getElementById("soumettre_playlist");
        if (btnSoumettre) {
            btnSoumettre.addEventListener("click", validerFormulairePlaylist);
        }
        };

        function validerFormulairePlaylist() {


            let playlistInput = document.getElementById("playlist"),
                descriptionInput = document.getElementById("description"),
                valuePlaylist = playlistInput.value,
                valueDescription = descriptionInput.value,
                monFormulaire = playlistInput.closest("form"),
                erreurs = [];


            if (!REGEX_PLAYLIST.test(valuePlaylist)) {
                erreurs.push("Le nom de la playlist est invalide (3 à 50 caractères, pas de symboles spéciaux).");
            }
            if (valueDescription.length < 5 || valueDescription.length > 250) {
                erreurs.push("La description doit contenir entre 5 et 250 caractères.");
            }
            if (erreurs.length > 0) {
                alert(erreurs.join("\n"));
            } else if (monFormulaire) {
                // fait le fetch
                const formData = new FormData(monFormulaire);

                fetch(monFormulaire.action, {
                    method: 'POST',
                    headers: {
                        // comme dans le lab
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    if (data.erreurs) {
                        // erreurs
                        let messages = [];
                        for (let cle in data.erreurs) {
                            messages.push(data.erreurs[cle].join('\n'));
                        }
                        alert("Erreur de validation :\n" + messages.join('\n'));
                    } else if (data.erreur) {
                        alert("Erreur serveur : " + data.erreur);
                    } else {
                        alert("Succès : " + data.succes);
                        // si ca marche on redirige
                        window.location.href = "{{ route('playlists') }}";
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Une erreur inattendue est survenue.");
                });
            }
        }
    </script>
</x-app-layout>
