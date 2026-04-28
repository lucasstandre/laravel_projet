<section style="background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); color: #dbe7ff; font-family: 'Manrope', sans-serif; border-radius: 8px; padding: 2rem;">
    <header style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #ffc500; margin: 0;">
            {{ __('Médias Sociaux') }}
        </h2>
        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: rgb(196, 214, 241, 0.7); margin-bottom: 0;">
            {{ __('Gérez vos profils de réseaux sociaux.') }}
        </p>
    </header>

    <div style="margin-top: 1.5rem;">
        <!-- Ajouter un média social -->
        <div style="margin-bottom: 2rem; padding: 1.5rem; background: rgba(28, 50, 84, 0.5); border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.2);">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #ffc500; margin: 0 0 1rem 0;">Ajouter un média social</h3>
            <form action="{{ route('profile.media.store') }}" method="POST" style="display: grid; gap: 1rem;">
                @csrf

                <div>
                    <label for="nom" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Nom du réseau</label>
                    <input type="text" name="nom" id="nom" placeholder="Twitter, Instagram, LinkedIn..."
                        style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;"
                        required>
                    @error('nom')
                        <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="url" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">URL du profil</label>
                    <input type="text" name="url" id="url"
                        style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;"
                        required>
                    @error('url')
                        <p style="margin-top: 0.4rem; font-size: 0.85rem; color: #ff7a7a;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" style="padding: 0.75rem 1.5rem; border: none; border-radius: 8px; background: #ffc500; color: #0b1528; font-weight: 700; cursor: pointer; font-size: 0.95rem; align-self: flex-start;">
                    Ajouter
                </button>
            </form>
        </div>

        <!-- Liste des médias sociaux -->
        <div>
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #ffc500; margin: 0 0 1rem 0;">Mes médias sociaux</h3>

            @if ($mediaSocials->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach ($mediaSocials as $media)
                        <div style="padding: 1.5rem; border: 1px solid rgba(126, 162, 211, 0.3); border-radius: 8px; background: rgba(28, 50, 84, 0.3); display: flex; align-items: center; justify-content: space-between;">
                            <div style="flex: 1;">
                                <div style="margin-bottom: 0.5rem;">
                                    <h4 style="font-weight: 700; color: #dbe7ff; margin: 0; font-size: 1rem;">{{ $media->nom }}</h4>
                                    <a href="{{ $media->url }}" target="_blank" style="display: inline-block; margin-top: 0.3rem; font-size: 0.85rem; color: #ffc500; text-decoration: none; word-break: break-all;">
                                        {{ $media->url }}
                                    </a>
                                </div>
                            </div>

                            <div style="display: flex; gap: 0.8rem; margin-left: 1rem;">
                                <!-- Modifier -->
                                <button type="button" onclick="openEditModal({{ $media->id }}, '{{ addslashes($media->nom) }}', '{{ addslashes($media->url) }}')"
                                    style="padding: 0.5rem 1rem; font-size: 0.85rem; background: #ffc500; color: #0b1528; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                    Modifier
                                </button>

                                <!-- Supprimer -->
                                <form action="{{ route('profile.media.destroy', $media) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer ce média social ?')"
                                        style="padding: 0.5rem 1rem; font-size: 0.85rem; background: #ff7a7a; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Modal de modification (caché par défaut) -->
                        <div id="editModal-{{ $media->id }}" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.7); overflow-y: auto; z-index: 1000;">
                            <div style="position: relative; top: 5rem; margin: 0 auto; padding: 2rem; border: 1px solid rgba(126, 162, 211, 0.3); width: 90%; max-width: 500px; background: linear-gradient(105deg, #01060f 0%, #03152d 52%, #04142b 100%); border-radius: 12px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
                                <h3 style="font-size: 1.2rem; font-weight: 700; color: #ffc500; margin: 0 0 1.5rem 0;">Modifier le média social</h3>

                                <form action="{{ route('profile.media.update', $media) }}" method="POST" style="display: grid; gap: 1rem;">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="edit-nom-{{ $media->id }}" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">Nom</label>
                                        <input type="text" name="nom" id="edit-nom-{{ $media->id }}"
                                            style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;"
                                            required>
                                    </div>

                                    <div>
                                        <label for="edit-url-{{ $media->id }}" style="display: block; font-size: 0.9rem; font-weight: 600; color: rgb(196, 214, 241, 0.75); margin-bottom: 0.4rem;">URL</label>
                                        <input type="text" name="url" id="edit-url-{{ $media->id }}"
                                            style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid rgba(126, 162, 211, 0.3); background: rgba(28, 50, 84, 0.7); color: #f1f7ff; font-size: 0.95rem; box-sizing: border-box;"
                                            required>
                                    </div>

                                    <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                                        <button type="submit" style="padding: 0.75rem 1.5rem; background: #ffc500; color: #0b1528; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">
                                            Sauvegarder
                                        </button>
                                        <button type="button" onclick="closeEditModal({{ $media->id }})" style="padding: 0.75rem 1.5rem; background: rgba(126, 162, 211, 0.2); color: #dbe7ff; border: 1px solid rgba(126, 162, 211, 0.3); border-radius: 8px; cursor: pointer; font-weight: 700;">
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: rgb(196, 214, 241, 0.6); padding: 2rem; font-style: italic;">Aucun média social ajouté pour le moment.</p>
            @endif
        </div>
    </div>
</section>

<script>
function openEditModal(mediaId, nom, url) {
    const modal = document.getElementById('editModal-' + mediaId);
    const nomInput = modal.querySelector('input[name="nom"]');
    const urlInput = modal.querySelector('input[name="url"]');

    nomInput.value = nom;
    urlInput.value = url;

    modal.style.display = 'block';

    // Fermer le modal en cliquant en dehors
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
}

function closeEditModal(mediaId) {
    const modal = document.getElementById('editModal-' + mediaId);
    modal.style.display = 'none';
}
</script>
